<title>问仙纪GM管理中心</title>
<head>
    <style>
        table{
            border-collapse: collapse;
        }
        td{
            border:solid black 1px;
        }

    </style>
<?php


require_once "include/fzr.php";


//怪物列表查询
function gw_show_fenye($gotourl,$dh_fl){
    require_once "include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=10;

    global $key_url_md_5;

    if($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];
//            if($pagenowid > 20){
//                $fenyePage->pageNow=20;
//            }else{
                $fenyePage->pageNow=$pagenowid;
//            }
        }
    }

    getFenyePage_gw($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        echo '<div>序号 名称</div>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $gw_name = $row['gw_name'];

            $url = 'x=w&id='.$num;
            echo '<div>'.$num.'.'.$gw_name." <a href='regw.php?$url'>管理</a></div>";

        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无怪物数据</div>';
    }
}


echo "<div>【问仙纪-怪物管理】</div><br/>";

if($_SERVER["QUERY_STRING"]) {

    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];
    }else{
        $dh_fl = $_GET["x"];
    }
}

if($dh_fl == "q"){
    //怪物列表
    echo "<div><a href='regw.php?x=r'>新增怪物</a></div><br/>";

    echo '<div>请输入你要搜索的怪物名称(支持模糊搜索):</div>';

    echo "<form id='form3' action='' method='post'>";
    echo "<div>怪物名称: <input type='text'  name='sousuo_name' /><input style='margin-left: 5px;' type='submit' value='搜索'></div>";
    echo '</form>';

    if(isset($_POST["sousuo_name"]) && $_POST["sousuo_name"] != ""){
        $sqlHelper = new SqlHelper();
        $sql = "select num,gw_name from s_guaiwu_all where gw_name like '%$_POST[sousuo_name]%'";
        $res = $sqlHelper->execute_dql2($sql);
        $sqlHelper->close_connect();
        if($res){

            echo "<table style='text-align: center'>";
            echo "<tr><td>怪物ID</td><td>怪物名称</td><td>操作</td></tr>";
            for($i=0;$i<count($res);$i++){
                $num = $res[$i]["num"];
                $name = $res[$i]["gw_name"];
                echo "<tr><td>$num</td><td><span style='color:green;'>$name</span></td><td><a href='regw.php?x=w&id=$num'>管理</a></td></tr>";
            }
            echo "</table>";
        }else{
            echo "<span style='color:red'>抱歉,没有搜索到该怪物</span>";
        }
    }

    echo '<div>怪物列表:</div>';
    gw_show_fenye('regw.php',$dh_fl);
}
elseif($dh_fl == "w" && $_GET["id"]){
    //怪物详情
    $sqlHelper = new SqlHelper();
    $sql = "select gw_name,gw_dj,gw_gj,gw_xq,gw_fy,gw_bj,gw_rx,gw_hp from s_guaiwu_all where num=$_GET[id]";
    $res = $sqlHelper->execute_dql($sql);

    if($res) {
        echo "<div><a href='regw.php?x=e&id=$_GET[id]'>删除该怪物</a></div><br/>";

        echo "<form action='regw.php?x=w&id=$_GET[id]' method='post'>";
        echo "<div>名称: " . $res["gw_name"] . " <input type='text' name='gw_name'></div>";
        echo "<div>等级: " . $res["gw_dj"] . " <input type='text' name='gw_dj'></div>";
        echo "<div>攻击: " . $res["gw_gj"] . " <input type='text' name='gw_gj'></div>";
        echo "<div>仙气: " . $res["gw_xq"] . " <input type='text' name='gw_xq'></div>";
        echo "<div>防御: " . $res["gw_fy"] . " <input type='text' name='gw_fy'></div>";
        echo "<div>暴击: " . $res["gw_bj"] . " <input type='text' name='gw_bj'></div>";
        echo "<div>韧性: " . $res["gw_rx"] . " <input type='text' name='gw_rx'></div>";
        echo "<div>气血: " . $res["gw_hp"] . " <input type='text' name='gw_hp'></div>";


        echo "<input type='submit' name='submit' value='修改怪物信息' style='margin-left: 50px;margin-top: 8px;'><br/>";

        echo "</form>";

    }else{
        echo "该怪物不存在<br/><br/>";
    }
    $sqlHelper->close_connect();

    echo "<a href='regw.php?x=q'>返回怪物列表</a>";

    if(isset($_POST["submit"])){
        $sqlHelper = new SqlHelper();

        $gw_name = $_POST["gw_name"];
        $gw_dj = $_POST["gw_dj"];
        $gw_gj = $_POST["gw_gj"];
        $gw_xq = $_POST["gw_xq"];
        $gw_fy = $_POST["gw_fy"];
        $gw_bj = $_POST["gw_bj"];
        $gw_rx = $_POST["gw_rx"];
        $gw_hp = $_POST["gw_hp"];

        if($gw_name != ""){
            $sql = "update s_guaiwu_all set gw_name='$gw_name' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($gw_dj != ""){
            $sql = "update s_guaiwu_all set gw_dj='$gw_dj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($gw_gj != ""){
            $sql = "update s_guaiwu_all set gw_gj='$gw_gj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($gw_xq != ""){
            $sql = "update s_guaiwu_all set gw_xq='$gw_xq' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($gw_fy != ""){
            $sql = "update s_guaiwu_all set gw_fy='$gw_fy' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($gw_bj != ""){
            $sql = "update s_guaiwu_all set gw_bj='$gw_bj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($gw_rx != ""){
            $sql = "update s_guaiwu_all set gw_rx='$gw_rx' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($gw_hp != ""){
            $sql = "update s_guaiwu_all set gw_hp='$gw_hp' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
        header("location: regw.php?x=w&id=$_GET[id]");
        exit;
    }
}
elseif($dh_fl == 'e' && $_GET["id"]){
    //删除gw
    $sqlHelper = new SqlHelper();
    $sql = "delete from s_guaiwu_all where num=$_GET[id]";
    $res1 = $sqlHelper->execute_dml($sql);
    $sql = "delete from s_fuben_info3 where fb_gw_num='$_GET[id]'";
    $res1 = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();
    header("location: regw.php?x=q");
    exit;
}
elseif($dh_fl == 'r') {
    //新增怪物添加信息页
    echo '<div style="margin-bottom: 10px;">【新增怪物】</div>';
    echo "<form action='regw.php?x=t' method='post'>";
    echo "<div>名称: <input type='text' name='gw_name'></div>";
    echo "<div>等级:  <input type='text' name='gw_dj'></div>";
    echo "<div>攻击:  <input type='text' name='gw_gj'></div>";
    echo "<div>仙气:  <input type='text' name='gw_xq'></div>";
    echo "<div>防御:  <input type='text' name='gw_fy'></div>";
    echo "<div>暴击:  <input type='text' name='gw_bj'></div>";
    echo "<div>韧性:  <input type='text' name='gw_rx'></div>";
    echo "<div>气血:  <input type='text' name='gw_hp'></div>";

    echo "<input type='submit' name='submit' value='添加怪物' style='margin-left: 50px;margin-top: 8px;'><br/>";
    echo "</form>";


    echo "<a href='regw.php?x=q'>返回怪物列表</a>";
}
elseif($dh_fl == "t") {
    //新增gw执行页
    if (isset($_POST["submit"])) {
        $gw_name = $_POST["gw_name"];
        $gw_dj = $_POST["gw_dj"];
        $gw_gj = $_POST["gw_gj"];
        $gw_xq = $_POST["gw_xq"];
        $gw_fy = $_POST["gw_fy"];
        $gw_bj = $_POST["gw_bj"];
        $gw_rx = $_POST["gw_rx"];
        $gw_hp = $_POST["gw_hp"];

        $sqlHelper = new SqlHelper();
        $sql = "select num from s_guaiwu_all where gw_name='$gw_name'";
        $res = $sqlHelper->execute_dql($sql);
        if ($res) {
            echo "<div><span style='color:red;'>已存在该怪物</span></div><br/>";
        } else {
            $sql = "insert into s_guaiwu_all(gw_name,gw_dj,gw_gj,gw_xq,gw_fy,gw_bj,gw_rx,gw_hp) values('$gw_name','$gw_dj','$gw_gj','$gw_xq','$gw_fy','$gw_bj','$gw_rx','$gw_hp')";
            $res = $sqlHelper->execute_dml($sql);
            echo "<div><span style='color:red;'>新增怪物成功</span></div><br/>";
        }

        $sqlHelper->close_connect();

        echo "<div><a href='regw.php?x=r'>继续新增怪物</a></div>";
        echo "<div><a href='regw.php?x=q'>返回怪物首页</a></div>";
    }
}

?>


<div style="margin-top: 20px;"><a href='index.php'>返回GM首页</a></div>
<div><a href='index.php?out=out'>退出登录</a></div>
