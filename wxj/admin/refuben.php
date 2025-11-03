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


//大副本列表查询
function fb_show_fenye($gotourl,$dh_fl){
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

    getFenyePage_fb_name1($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        echo '<div>副本名称 副本等级</div>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $fb_name = $row['fb_name'];
            $fb_min_dj = $row['fb_min_dj'];
            $fb_max_dj = $row['fb_max_dj'];

            $url = 'x=w&id='.$num;
            echo '<div>'.$fb_name.'('.$fb_min_dj.'~'.$fb_max_dj.')'." <a href='refuben.php?$url'>管理</a></div>";

        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无副本数据</div>';
    }
}

//子副本阶段添加怪物列表
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

    getFenyePage_fb_name1($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        echo '<div>副本名称 副本等级</div>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $fb_name = $row['fb_name'];
            $fb_min_dj = $row['fb_min_dj'];
            $fb_max_dj = $row['fb_max_dj'];

            $url = 'x=w&id='.$num;
            echo '<div>'.$fb_name.'('.$fb_min_dj.'~'.$fb_max_dj.')'." <a href='refuben.php?$url'>管理</a></div>";

        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无副本数据</div>';
    }
}


echo "<div>【问仙纪-副本管理】</div><br/>";

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
    //大副本列表
    echo "<div><a href='refuben.php?x=r'>新增大副本</a></div><br/>";


    echo '<div>大副本列表:</div>';
    fb_show_fenye('refuben.php',$dh_fl);
}
elseif($dh_fl == "w" && $_GET["id"]){
    //大副本详情
    $sqlHelper = new SqlHelper();
    $sql = "select fb_name,fb_min_dj,fb_max_dj from s_fuben_info1 where num=$_GET[id]";
    $res = $sqlHelper->execute_dql($sql);

    if($res) {
        echo "<div><a href='refuben.php?x=e&id=$_GET[id]'>删除该大副本</a> (该大副本对应的下列小副本及怪物全部删除)</div><br/>";

        echo "<form action='refuben.php?x=w&id=$_GET[id]' method='post'>";
        echo "<div>副本名称: " . $res["fb_name"] . " <input type='text' name='fb_name'></div>";
        echo "<div>最小等级: " . $res["fb_min_dj"] . " <input type='text' name='fb_min_dj'></div>";
        echo "<div>最大等级: " . $res["fb_max_dj"] . " <input type='text' name='fb_max_dj'></div>";


        echo "<input type='submit' name='submit' value='修改副本信息' style='margin-left: 50px;margin-top: 8px;'><br/>";

        echo "</form>";

        echo '<br/>';
        echo '<div>'.$res["fb_name"].'子副本列表</div>';

        $sql = "select num,fb_jindu,fb_name,fb_min_dj,fb_max_dj from s_fuben_info2 where fb_info1_num=$_GET[id] order by num desc";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            echo '<div>副本进度 副本名称 副本等级</div>';
            for($i=0;$i<count($res);$i++){
                $url = 'x=y&id='.$res[$i]["num"];
                $ur2 = 'x=o&id='.$res[$i]["num"];
                echo '<div>'.$res[$i]["fb_jindu"].' '.$res[$i]["fb_name"].'('.$res[$i]["fb_min_dj"].'~'.$res[$i]["fb_max_dj"].')'." <a href='refuben.php?$url'>怪物管理</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='refuben.php?$ur2'>掉落管理</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无子副本信息</div>';
        }

        echo '<br/>';
        echo "<div>请输入你要新增的小副本信息:</div>";

        echo "<form action='refuben.php?x=w&id=$_GET[id]' method='post'>";
        echo "<div>副本名称: <input type='text' name='xfb_name'></div>";
        echo "<div>副本进度: <input type='text' name='fb_jindu'></div>";
        echo "<div>最小等级: <input type='text' name='fb_min_dj'></div>";
        echo "<div>最大等级: <input type='text' name='fb_max_dj'></div>";


        echo "<input type='submit' name='submit' value='新增子副本信息' style='margin-left: 50px;margin-top: 8px;'><br/>";

        echo "</form>";

    }else{
        echo "<div>该大副本不存在</div>";
    }
    $sqlHelper->close_connect();

    echo "<div style='margin-top: 10px;'><a href='refuben.php?x=q'>返回大副本列表</a></div>";

    if(isset($_POST["submit"]) && isset($_POST["fb_name"])){
        $sqlHelper = new SqlHelper();

        $fb_name = $_POST["fb_name"];
        $fb_min_dj = $_POST["fb_min_dj"];
        $fb_max_dj = $_POST["fb_max_dj"];

        if($fb_name != ""){
            $sql = "update s_fuben_info1 set fb_name='$fb_name' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($fb_min_dj != ""){
            $sql = "update s_fuben_info1 set fb_min_dj='$fb_min_dj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($fb_max_dj != ""){
            $sql = "update s_fuben_info1 set fb_max_dj='$fb_max_dj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
        header("location: refuben.php?x=w&id=$_GET[id]");
        exit;
    }

    if(isset($_POST["xfb_name"])){
        $sqlHelper = new SqlHelper();

        $fb_name = $_POST["xfb_name"];
        $fb_min_dj = $_POST["fb_min_dj"];
        $fb_max_dj = $_POST["fb_max_dj"];
        $fb_jindu = $_POST["fb_jindu"];

        if($fb_name != ""){
            $sql = "insert into s_fuben_info2(fb_name,fb_min_dj,fb_max_dj,fb_info1_num,fb_jindu) values('$fb_name','$fb_min_dj','$fb_max_dj','$_GET[id]','$fb_jindu')";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
        header("location: refuben.php?x=w&id=$_GET[id]");
        exit;
    }
}
elseif($dh_fl == 'e' && $_GET["id"]){
    //删除大副本
    $fb_info1_num = $_GET["id"];

    $sqlHelper = new SqlHelper();
    $sql = "select num from s_fuben_info2 where fb_info1_num=$fb_info1_num";
    $res = $sqlHelper->execute_dql2($sql);
    for($i=0;$i<count($res);$i++){
        $fb_info2_num = $res[$i]["num"];
        $sql = "delete from s_fuben_info3 where fb_info2_num=$fb_info2_num";
        $res1 = $sqlHelper->execute_dml($sql);
        $sql = "delete from s_fuben_diaoluo where fb_jindu=$fb_info2_num";
        $res1 = $sqlHelper->execute_dml($sql);
    }

    $sql = "delete from s_fuben_info2 where fb_info1_num=$fb_info1_num";
    $res1 = $sqlHelper->execute_dml($sql);

    $sql = "delete from s_fuben_info1 where num=$fb_info1_num";
    $res1 = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();
    header("location: refuben.php?x=q");
    exit;
}
elseif($dh_fl == 'r') {
    //新增大副本添加信息页
    echo '<div style="margin-bottom: 10px;">【新增副本】</div>';
    echo "<form action='refuben.php?x=t' method='post'>";
    echo "<div>副本名称: <input type='text' name='fb_name'></div>";
    echo "<div>最小等级:  <input type='text' name='fb_min_dj'></div>";
    echo "<div>最大等级:  <input type='text' name='fb_max_dj'></div>";

    echo "<input type='submit' name='submit' value='添加副本' style='margin-left: 50px;margin-top: 8px;'><br/>";
    echo "</form>";

    echo "<a href='refuben.php?x=q'>返回副本列表</a>";
}
elseif($dh_fl == "t") {
    //新增大副本执行页
    if (isset($_POST["submit"])) {
        $fb_name = $_POST["fb_name"];
        $fb_min_dj = $_POST["fb_min_dj"];
        $fb_max_dj = $_POST["fb_max_dj"];

        $sqlHelper = new SqlHelper();
        $sql = "select num from s_fuben_info1 where fb_name='$fb_name'";
        $res = $sqlHelper->execute_dql($sql);
        if ($res) {
            echo "<div><span style='color:red;'>已存在该副本</span></div><br/>";
        } else {
            $sql = "insert into s_fuben_info1(fb_name,fb_min_dj,fb_max_dj) values('$fb_name','$fb_min_dj','$fb_max_dj')";
            $res = $sqlHelper->execute_dml($sql);
            echo "<div><span style='color:red;'>新增副本成功</span></div><br/>";
        }

        $sqlHelper->close_connect();

        echo "<div><a href='refuben.php?x=r'>继续新增副本</a></div>";
        echo "<div><a href='refuben.php?x=q'>返回副本首页</a></div>";
    }
}
elseif($dh_fl == "y" && $_GET["id"]){
    //小副本怪物详情
    if(isset($_POST["submit"]) && isset($_POST["fb_name"])){
        $sqlHelper = new SqlHelper();

        $fb_name = $_POST["fb_name"];
        $fb_min_dj = $_POST["fb_min_dj"];
        $fb_max_dj = $_POST["fb_max_dj"];
        $fb_jindu = $_POST["fb_jindu"];

        if($fb_name != ""){
            $sql = "update s_fuben_info2 set fb_name='$fb_name' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($fb_min_dj != ""){
            $sql = "update s_fuben_info2 set fb_min_dj='$fb_min_dj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($fb_max_dj != ""){
            $sql = "update s_fuben_info2 set fb_max_dj='$fb_max_dj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($fb_jindu != ""){
            $sql = "update s_fuben_info2 set fb_jindu='$fb_jindu' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
        header("location: refuben.php?x=y&id=$_GET[id]");
        exit;
    }

    $sqlHelper = new SqlHelper();
    $sql = "select fb_name,fb_jindu,fb_min_dj,fb_max_dj,fb_info1_num from s_fuben_info2 where num=$_GET[id]";
    $res = $sqlHelper->execute_dql($sql);

    if($res) {
        $fb_info1_num = $res["fb_info1_num"];
        echo "<div><a href='refuben.php?x=u&id=$_GET[id]'>删除该子副本</a> (该子副本对应的怪物及掉落全部删除)</div><br/>";

        echo "<form action='refuben.php?x=y&id=$_GET[id]' method='post'>";
        echo "<div>副本名称: " . $res["fb_name"] . " <input type='text' name='fb_name'></div>";
        echo "<div>副本进度: " . $res["fb_jindu"] . " <input type='text' name='fb_jindu'></div>";
        echo "<div>最小等级: " . $res["fb_min_dj"] . " <input type='text' name='fb_min_dj'></div>";
        echo "<div>最大等级: " . $res["fb_max_dj"] . " <input type='text' name='fb_max_dj'></div>";


        echo "<input type='submit' name='submit' value='修改子副本信息' style='margin-left: 50px;margin-top: 8px;'><br/>";

        echo "</form>";

        echo '<br/>';
        echo '<div>'.$res["fb_name"].'怪物列表</div>';

        echo "<div style='color:green;'>第一阶段怪物列表:</div>";
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="jieduan" value="1">';
        echo '<div>新增怪物id号: <input type="text" style="width:100px;" placeholder="请输入怪物id" name="gw_id"><input style="margin-left:5px;" type="submit" value="新增"></div>';
        echo '</form>';

        $sql = "select num,fb_gw_num from s_fuben_info3 where fb_info2_num=$_GET[id] and fb_jindu= 1";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            for($i=0;$i<count($res);$i++){
                $gw_num = $res[$i]["fb_gw_num"];
                $num = $res[$i]["num"];
                $sql = "select gw_name,gw_dj from s_guaiwu_all where num=$gw_num";
                $res1 = $sqlHelper->execute_dql($sql);

                $url = 'refuben.php?x=i&fbid='.$_GET["id"].'&id='.$num;
                echo '<div>'.($i+1).'.'.$res1["gw_name"].$res1["gw_dj"]."级 <a href='$url'>删除</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无怪物信息</div>';
        }

        echo "<div style='color:green;margin-top: 10px;'>第二阶段怪物列表:</div>";
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="jieduan" value="2">';
        echo '<div>新增怪物id号: <input type="text" style="width:100px;" placeholder="请输入怪物id" name="gw_id"><input style="margin-left:5px;" type="submit" value="新增"></div>';
        echo '</form>';

        $sql = "select num,fb_gw_num from s_fuben_info3 where fb_info2_num=$_GET[id] and fb_jindu= 2";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            for($i=0;$i<count($res);$i++){
                $gw_num = $res[$i]["fb_gw_num"];
                $num = $res[$i]["num"];
                $sql = "select gw_name,gw_dj from s_guaiwu_all where num=$gw_num";
                $res1 = $sqlHelper->execute_dql($sql);
                $url = 'refuben.php?x=i&fbid='.$_GET["id"].'&id='.$num;
                echo '<div>'.($i+1).'.'.$res1["gw_name"].$res1["gw_dj"]."级 <a href='$url'>删除</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无怪物信息</div>';
        }

        echo "<div style='color:green;margin-top: 10px;'>第三阶段怪物列表:</div>";
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="jieduan" value="3">';
        echo '<div>新增怪物id号: <input type="text" style="width:100px;" placeholder="请输入怪物id" name="gw_id"><input style="margin-left:5px;" type="submit" value="新增"></div>';
        echo '</form>';

        $sql = "select num,fb_gw_num from s_fuben_info3 where fb_info2_num=$_GET[id] and fb_jindu= 3";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            for($i=0;$i<count($res);$i++){
                $gw_num = $res[$i]["fb_gw_num"];
                $num = $res[$i]["num"];
                $sql = "select gw_name,gw_dj from s_guaiwu_all where num=$gw_num";
                $res1 = $sqlHelper->execute_dql($sql);
                $url = 'refuben.php?x=i&fbid='.$_GET["id"].'&id='.$num;
                echo '<div>'.($i+1).'.'.$res1["gw_name"].$res1["gw_dj"]."级 <a href='$url'>删除</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无怪物信息</div>';
        }

        echo "<div style='color:green;margin-top: 10px;'>第四阶段怪物列表:</div>";
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="jieduan" value="4">';
        echo '<div>新增怪物id号: <input type="text" style="width:100px;" placeholder="请输入怪物id" name="gw_id"><input style="margin-left:5px;" type="submit" value="新增"></div>';
        echo '</form>';

        $sql = "select num,fb_gw_num from s_fuben_info3 where fb_info2_num=$_GET[id] and fb_jindu= 4";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            for($i=0;$i<count($res);$i++){
                $gw_num = $res[$i]["fb_gw_num"];
                $num = $res[$i]["num"];
                $sql = "select gw_name,gw_dj from s_guaiwu_all where num=$gw_num";
                $res1 = $sqlHelper->execute_dql($sql);
                $url = 'refuben.php?x=i&fbid='.$_GET["id"].'&id='.$num;
                echo '<div>'.($i+1).'.'.$res1["gw_name"].$res1["gw_dj"]."级 <a href='$url'>删除</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无怪物信息</div>';
        }

        echo '<div style="color:green;font-weight: bold; margin-top: 10px;">怪物序列号查询</div>';
        echo '<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" width="100%px;" height="380px;" src="gw_list.php"></iframe>';

        $url = 'refuben.php?x=w&id='.$fb_info1_num;
        echo "<div style='margin-top: 10px;'><a href='$url'>返回上页</a></div>";
    }else{
        echo "<div>该子副本不存在</div>";
        echo "<div style='margin-top: 10px;'><a href='refuben.php?x=q'>返回上页</a></div>";
    }

    $sqlHelper->close_connect();

    if(isset($_POST["jieduan"])){
        $sqlHelper = new SqlHelper();

        $fb_info2_num = $_GET["id"];
        $jieduan = $_POST["jieduan"];
        $gw_id = $_POST["gw_id"];

        if($gw_id != "" && $jieduan != ''){
            $sql = "insert into s_fuben_info3(fb_info2_num,fb_jindu,fb_gw_num) values('$fb_info2_num','$jieduan','$gw_id')";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
        header("location: refuben.php?x=y&id=$_GET[id]");
        exit;
    }
}
elseif($dh_fl == 'u' && $_GET["id"]){
    //删除子副本
    $fb_info2_num = $_GET["id"];

    $sqlHelper = new SqlHelper();
    $sql = "delete from s_fuben_info3 where fb_info2_num=$fb_info2_num";
    $res1 = $sqlHelper->execute_dml($sql);

    $sql = "delete from s_fuben_diaoluo where fb_jindu=$fb_info2_num";
    $res1 = $sqlHelper->execute_dml($sql);

    $sql = "select fb_info1_num from s_fuben_info2 where num=$fb_info2_num";
    $res = $sqlHelper->execute_dql($sql);

    $sql = "delete from s_fuben_info2 where num=$fb_info2_num";
    $res1 = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();

    $url = 'refuben.php?x=w&id='.$res["fb_info1_num"];
    header("location: $url");
    exit;
}
elseif($dh_fl == 'i' && $_GET["id"] && $_GET["fbid"]){
    //删除子副本怪物
    $sqlHelper = new SqlHelper();
    $sql = "delete from s_fuben_info3 where num=$_GET[id]";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();

    $url = 'refuben.php?x=y&id='.$_GET["fbid"];
    header("location: $url");
    exit;
}
elseif($dh_fl == "o" && $_GET["id"]){
    //小副本掉落详情
    if(isset($_POST["submit"]) && isset($_POST["fb_name"])){
        $sqlHelper = new SqlHelper();

        $fb_name = $_POST["fb_name"];
        $fb_min_dj = $_POST["fb_min_dj"];
        $fb_max_dj = $_POST["fb_max_dj"];

        if($fb_name != ""){
            $sql = "update s_fuben_info2 set fb_name='$fb_name' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($fb_min_dj != ""){
            $sql = "update s_fuben_info2 set fb_min_dj='$fb_min_dj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($fb_max_dj != ""){
            $sql = "update s_fuben_info2 set fb_max_dj='$fb_max_dj' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
        header("location: refuben.php?x=y&id=$_GET[id]");
        exit;
    }

    if(isset($_POST["jieduan"])){
        $sqlHelper = new SqlHelper();

        $fb_info2_num = $_GET["id"];
        $jieduan = $_POST["jieduan"];
        $wp_id = $_POST["wp_id"];
        $wp_sl = $_POST["wp_sl"];
        $wp_jl = $_POST["wp_jl"] * 100;;

        if($wp_id != "" && $jieduan != '' && $wp_sl != '' && $wp_jl != ''){
            $sql = "insert into s_fuben_diaoluo(fb_jindu,fb_jieduan,wp_num,wp_sl,wp_jilv) values ('$fb_info2_num','$jieduan','$wp_id','$wp_sl','$wp_jl')";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
        header("location: refuben.php?x=o&id=$_GET[id]");
        exit;
    }

    $sqlHelper = new SqlHelper();
    $sql = "select fb_name,fb_info1_num from s_fuben_info2 where num=$_GET[id]";
    $res = $sqlHelper->execute_dql($sql);

    if($res) {
        $fb_info1_num = $res["fb_info1_num"];
        echo '<div>'.$res["fb_name"].'掉落列表</div>';

        echo "<div style='color:green;'>第一阶段掉落列表:</div>";
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="jieduan" value="1">';
        echo '<div>新增物品id号 几率: <input type="text" style="width:60px;" placeholder="物品id" name="wp_id"><input type="text" style="width:60px;margin-left:5px;" placeholder="物品数量" name="wp_sl"><input type="text" style="width:60px;margin-left:10px;" placeholder="物品几率" name="wp_jl"><input style="margin-left:5px;" type="submit" value="新增"></div>';
        echo '</form>';

        $sql = "select num,wp_num,wp_sl,wp_jilv from s_fuben_diaoluo where fb_jindu=$_GET[id] and fb_jieduan= 1";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            for($i=0;$i<count($res);$i++){
                $wp_num = $res[$i]["wp_num"];
                $wp_sl = $res[$i]["wp_sl"];
                $wp_jilv = $res[$i]["wp_jilv"];
                $num = $res[$i]["num"];
                $sql = "select wp_name from s_wupin_all where num=$wp_num";
                $res1 = $sqlHelper->execute_dql($sql);

                $url = 'refuben.php?x=p&fbid='.$_GET["id"].'&id='.$num;
                echo '<div>'.($i+1).'.'.$res1["wp_name"].'x'.$wp_sl. ' '.($wp_jilv/100)."% <a href='$url'>删除</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无物品掉落信息</div>';
        }

        echo "<div style='color:green;margin-top: 10px;'>第二阶段掉落列表:</div>";
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="jieduan" value="2">';
        echo '<div>新增物品id号 几率: <input type="text" style="width:60px;" placeholder="物品id" name="wp_id"><input type="text" style="width:60px;margin-left:5px;" placeholder="物品数量" name="wp_sl"><input type="text" style="width:60px;margin-left:10px;" placeholder="物品几率" name="wp_jl"><input style="margin-left:5px;" type="submit" value="新增"></div>';
        echo '</form>';

        $sql = "select num,wp_num,wp_sl,wp_jilv from s_fuben_diaoluo where fb_jindu=$_GET[id] and fb_jieduan= 2";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            for($i=0;$i<count($res);$i++){
                $wp_num = $res[$i]["wp_num"];
                $wp_sl = $res[$i]["wp_sl"];
                $wp_jilv = $res[$i]["wp_jilv"];
                $num = $res[$i]["num"];
                $sql = "select wp_name from s_wupin_all where num=$wp_num";
                $res1 = $sqlHelper->execute_dql($sql);

                $url = 'refuben.php?x=p&fbid='.$_GET["id"].'&id='.$num;
                echo '<div>'.($i+1).'.'.$res1["wp_name"].'x'.$wp_sl. ' '.($wp_jilv/100)."% <a href='$url'>删除</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无物品掉落信息</div>';
        }

        echo "<div style='color:green;margin-top: 10px;'>第三阶段掉落列表:</div>";
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="jieduan" value="3">';
        echo '<div>新增物品id号 几率: <input type="text" style="width:60px;" placeholder="物品id" name="wp_id"><input type="text" style="width:60px;margin-left:5px;" placeholder="物品数量" name="wp_sl"><input type="text" style="width:60px;margin-left:10px;" placeholder="物品几率" name="wp_jl"><input style="margin-left:5px;" type="submit" value="新增"></div>';
        echo '</form>';

        $sql = "select num,wp_num,wp_sl,wp_jilv from s_fuben_diaoluo where fb_jindu=$_GET[id] and fb_jieduan= 3";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            for($i=0;$i<count($res);$i++){
                $wp_num = $res[$i]["wp_num"];
                $wp_sl = $res[$i]["wp_sl"];
                $wp_jilv = $res[$i]["wp_jilv"];
                $num = $res[$i]["num"];
                $sql = "select wp_name from s_wupin_all where num=$wp_num";
                $res1 = $sqlHelper->execute_dql($sql);

                $url = 'refuben.php?x=p&fbid='.$_GET["id"].'&id='.$num;
                echo '<div>'.($i+1).'.'.$res1["wp_name"].'x'.$wp_sl. ' '.($wp_jilv/100)."% <a href='$url'>删除</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无物品掉落信息</div>';
        }

        echo "<div style='color:green;margin-top: 10px;'>第四阶段掉落列表:</div>";
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="jieduan" value="4">';
        echo '<div>新增物品id号 几率: <input type="text" style="width:60px;" placeholder="物品id" name="wp_id"><input type="text" style="width:60px;margin-left:5px;" placeholder="物品数量" name="wp_sl"><input type="text" style="width:60px;margin-left:10px;" placeholder="物品几率" name="wp_jl"><input style="margin-left:5px;" type="submit" value="新增"></div>';
        echo '</form>';

        $sql = "select num,wp_num,wp_sl,wp_jilv from s_fuben_diaoluo where fb_jindu=$_GET[id] and fb_jieduan= 4";
        $res = $sqlHelper->execute_dql2($sql);

        if($res){
            for($i=0;$i<count($res);$i++){
                $wp_num = $res[$i]["wp_num"];
                $wp_sl = $res[$i]["wp_sl"];
                $wp_jilv = $res[$i]["wp_jilv"];
                $num = $res[$i]["num"];
                $sql = "select wp_name from s_wupin_all where num=$wp_num";
                $res1 = $sqlHelper->execute_dql($sql);

                $url = 'refuben.php?x=p&fbid='.$_GET["id"].'&id='.$num;
                echo '<div>'.($i+1).'.'.$res1["wp_name"].'x'.$wp_sl. ' '.($wp_jilv/100)."% <a href='$url'>删除</a></div>";
            }
        }else{
            echo '<div style="color:red;">暂无物品掉落信息</div>';
        }

        echo '<div style="color:green;font-weight: bold; margin-top: 10px;">物品序列号查询</div>';
        echo '<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" width="100%px;" height="380px;" src="wp_list.php"></iframe>';

        $url = 'refuben.php?x=w&id='.$fb_info1_num;
        echo "<div style='margin-top: 10px;'><a href='$url'>返回上页</a></div>";
    }else{
        echo "<div>该子副本不存在</div>";
        echo "<div style='margin-top: 10px;'><a href='refuben.php?x=q'>返回上页</a></div>";
    }

    $sqlHelper->close_connect();


}
elseif($dh_fl == 'p' && $_GET["id"] && $_GET["fbid"]){
    //删除子副本掉落信息
    $sqlHelper = new SqlHelper();
    $sql = "delete from s_fuben_diaoluo where num=$_GET[id]";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();

    $url = 'refuben.php?x=o&id='.$_GET["fbid"];
    header("location: $url");
    exit;
}
?>

<div style="margin-top: 20px;"><a href='index.php'>返回GM首页</a></div>
<div><a href='index.php?out=out'>退出登录</a></div>
