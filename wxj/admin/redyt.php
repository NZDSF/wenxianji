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


//大雁塔列表查询
function dyt_show_fenye($gotourl,$dh_fl){
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

    getFenyePage_dyt_name1($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        echo '<div>层数 怪物名称 怪物等级</div>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $ta_ceng = $row['ta_ceng'];
            $gw_id = $row['gw_id'];

            $sql = "select gw_name,gw_dj from s_guaiwu_all where num=$gw_id";
            $res = $sqlHelper->execute_dql($sql);

            $url = 'x=w&id='.$ta_ceng;
            $ur2 = 'x=e&id='.$ta_ceng;
            echo "<div>第".$ta_ceng."层 ".$res["gw_name"]." ".$res["gw_dj"]."级 <a href='redyt.php?$url'>管理</a>&nbsp;<a href='redyt.php?$ur2'>删除</a></div>";

        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无层数数据</div>';
    }
}

//怪物列表查询
function dyt_gw_show_fenye($gotourl,$dh_fl,$ta_ceng){
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

    getFenyePage_gw_dyt($fenyePage,$dh_fl,$ta_ceng);

    if($fenyePage->res_array){
        echo '<div>序号 名称</div>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $gw_name = $row['gw_name'];
            $gw_dj = $row['gw_dj'];

            global $id;
            $url = 'x=t&id='.$id.'&gw_id='.$num;
            echo '<div>'.$num.'.'.$gw_name." ".$gw_dj."级 <a href='redyt.php?$url'>选择</a></div>";

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

//物品列表查询
function dyt_wp_show_fenye($gotourl,$dh_fl,$ta_ceng){
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

    getFenyePage_wp_dyt($fenyePage,$dh_fl,$ta_ceng);

    if($fenyePage->res_array){
        echo '<div>名称 数量 几率</div>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $gw_name = $row['wp_name'];

            echo '<form action="" method="post">';
            echo "<input type='hidden' name='jl_id' value='$num'>";
            echo '<div>'.$gw_name.' <input style="width:60px;" type="text" name="jl_sl" placeholder="掉落数量" > <input style="width:60px;" type="text" name="jl_jl" placeholder="掉落几率" > <input type="submit" value="增加"></div>';
            echo '</form>';

        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无物品数据</div>';
    }
}

echo "<div>【问仙纪-大雁塔管理】</div><br/>";

if($_SERVER["QUERY_STRING"]) {

    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];
    }else{
        $dh_fl = $_GET["x"];
    }
    if (isset($url_info["id"])) {
        $suxin1 = explode(".", $url_info["id"]);
        $id = $suxin1[0];
    }else{
        if(isset($_GET["id"])){
            $id = $_GET["id"];
        }
    }
}

if($dh_fl == "q"){
    //大雁塔列表
    echo "<div><a href='redyt.php?x=r'>新增层数</a></div><br/>";


    echo '<div>大雁塔列表:</div>';
    dyt_show_fenye('redyt.php',$dh_fl);
}
elseif($dh_fl == "w" && $_GET["id"]) {
    //大副本详情

    if(isset($_POST["jl_exp"]) && $_POST["jl_exp"] != ''){
        $sqlHelper = new SqlHelper();
        $sql = "select jl_sl from s_ta_jiangli where ta_ceng=$_GET[id] and jl_lx='exp'";
        $res = $sqlHelper->execute_dql($sql);
        if($res){
            $sql = "update s_ta_jiangli set jl_sl=$_POST[jl_exp] where ta_ceng=$_GET[id] and jl_lx='exp'";
            $res = $sqlHelper->execute_dml($sql);
        }else{
            $sql = "insert into s_ta_jiangli(ta_ceng,jl_lx,jl_sl) values('$_GET[id]','exp','$_POST[jl_exp]')";
            $res = $sqlHelper->execute_dml($sql);
        }
        $sqlHelper->close_connect();
    }

    $sqlHelper = new SqlHelper();
    $sql = "select gw_id from s_ta_guaiwu where ta_ceng=$_GET[id]";
    $res = $sqlHelper->execute_dql($sql);

    if ($res) {
        $sql = "select gw_name,gw_dj from s_guaiwu_all where num=$res[gw_id]";
        $res = $sqlHelper->execute_dql($sql);
        echo '<div>当前守塔boss:';
        if ($res) {
            echo ' ' . $res["gw_name"] . ' ' . $res["gw_dj"] . '级';
        } else {
            echo ' 无';
        }

        $url = 'x=r&id='.$_GET["id"];
        echo " <a href='redyt.php?$url'>更换</a></div>";

        $sql = "select jl_sl from s_ta_jiangli where ta_ceng=$_GET[id] and jl_lx='exp'";
        $res = $sqlHelper->execute_dql($sql);
        if($res){
            $exp = $res["jl_sl"];
        }else{
            $exp = 0;
        }

        echo "<form action='' method='post'>";
        echo '<div style="margin-top: 10px;">当前层数奖励经验:'.$exp;
        echo " <input style='width:60px;' type='text' name='jl_exp'>";
        echo " <input type='submit' value='更改'>";
        echo '</div>';
        echo '</form>';

        $url = 'x=i&id='.$_GET["id"];
        echo "<div style='margin-top: 10px;'>当前层数挖宝奖励: <a href='redyt.php?$url'>增加</a></div>";
        $sql = "select num,jl_lx,jl_id,jl_sl,jl_jl from s_ta_jiangli where ta_ceng=$_GET[id] and jl_lx != 'exp'";
        $res = $sqlHelper->execute_dql2($sql);
        if($res){
            echo '<div style="color:green;">名称数量 获得几率</div>';
            $count_jiangli = count($res);
            for($i=0;$i<$count_jiangli;$i++){
                $num = $res[$i]["num"];
                $jl_lx = $res[$i]["jl_lx"];
                $jl_id = $res[$i]["jl_id"];
                $jl_sl = $res[$i]["jl_sl"];
                $jl_jl = $res[$i]["jl_jl"];

                if($jl_lx = 'wp'){
                    $sql = "select wp_name from s_wupin_all where num=$jl_id";
                    $res1 = $sqlHelper->execute_dql($sql);
                    $url = 'x=y&id='.$_GET["id"].'&num='.$num;
                    echo '<div>'.$res1["wp_name"].'x'.$jl_sl.' '.($jl_jl / 100)."% <a href='redyt.php?$url'>删除</a></div>";
                }
            }
        }else{
            echo '<div style="color:red;">暂无奖励</div>';
        }

        $url = 'x=o&id='.$_GET["id"];
        echo "<div style='margin-top: 20px;'>当前层数宝箱奖励: <a href='redyt.php?$url'>增加</a></div>";
        $sql = "select num,jl_lx,jl_id,jl_sl,jl_jl from s_ta_jiangli_box where ta_ceng=$_GET[id]";
        $res = $sqlHelper->execute_dql2($sql);
        if($res){
            echo '<div style="color:green;">名称数量 获得几率</div>';
            $count_jiangli = count($res);
            for($i=0;$i<$count_jiangli;$i++){
                $num = $res[$i]["num"];
                $jl_lx = $res[$i]["jl_lx"];
                $jl_id = $res[$i]["jl_id"];
                $jl_sl = $res[$i]["jl_sl"];
                $jl_jl = $res[$i]["jl_jl"];

                if($jl_lx = 'wp'){
                    $sql = "select wp_name from s_wupin_all where num=$jl_id";
                    $res1 = $sqlHelper->execute_dql($sql);
                    $url = 'x=u&id='.$_GET["id"].'&num='.$num;
                    echo '<div>'.$res1["wp_name"].'x'.$jl_sl.' '.($jl_jl / 100)."% <a href='redyt.php?$url'>删除</a></div>";
                }
            }
        }else{
            echo '<div style="color:red;">暂无奖励</div>';
        }

    } else {
        echo "<div>该层数不存在</div>";
    }
    $sqlHelper->close_connect();

    echo "<div style='margin-top: 10px;'><a href='redyt.php?x=q'>返回大雁塔列表</a></div>";
}
elseif($dh_fl == 'e' && $_GET["id"]){
    //删除大雁塔某层数
    $ta_ceng = $_GET["id"];

    $sqlHelper = new SqlHelper();

    $sql = "delete from s_ta_guaiwu where ta_ceng=$ta_ceng";
    $res = $sqlHelper->execute_dml($sql);

    $sql = "delete from s_ta_jiangli where ta_ceng=$ta_ceng";
    $res = $sqlHelper->execute_dml($sql);

    $sql = "delete from s_ta_jiangli_box where ta_ceng=$ta_ceng";
    $res = $sqlHelper->execute_dml($sql);

    $sqlHelper->close_connect();
    header("location: redyt.php?x=q");
    exit;
}
elseif($dh_fl == "r" && $id) {
    //替换守塔boss前页面
    $sqlHelper = new SqlHelper();
    $sql = "select gw_id from s_ta_guaiwu where ta_ceng=$id";
    $res = $sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();

    if ($res) {
        $sqlHelper = new SqlHelper();
        $sql = "select gw_name,gw_dj from s_guaiwu_all where num=$res[gw_id]";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();

        echo '<div>当前守塔boss:';
        if ($res) {
            echo ' ' . $res["gw_name"] . ' ' . $res["gw_dj"] . '级';
        } else {
            echo ' 无';
        }

        dyt_gw_show_fenye('redyt.php',$dh_fl,$id);

    } else {
        echo "<div>该层数不存在</div>";
    }

    echo "<div style='margin-top: 10px;'><a href='redyt.php?x=q'>返回大雁塔列表</a></div>";
}
elseif($dh_fl == "t" && $id) {
    //替换守塔boss执行页
    $sqlHelper = new SqlHelper();
    $sql = "update s_ta_guaiwu set gw_id=$_GET[gw_id] where ta_ceng=$id";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();

    $url = 'x=w&id='.$id;
    header("location: redyt.php?$url");
    exit;
}
elseif($dh_fl == "y" && $_GET["id"]){
    //删除大雁塔挖宝奖励物品

    $sqlHelper = new SqlHelper();
    $sql = "delete from s_ta_jiangli where num=$_GET[num]";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();

    $url = 'x=w&id='.$_GET["id"];
    header("location: redyt.php?$url");
    exit;
}
elseif($dh_fl == "u" && $_GET["id"]){
    //删除大雁塔宝箱奖励物品

    $sqlHelper = new SqlHelper();
    $sql = "delete from s_ta_jiangli_box where num=$_GET[num]";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();

    $url = 'x=w&id='.$_GET["id"];
    header("location: redyt.php?$url");
    exit;
}
elseif($dh_fl == "i" && $id) {
    //替换层数挖宝奖励前页面
    echo '<div style="margin-bottom: 10px;">闯塔挖宝奖励</div>';
    $sqlHelper = new SqlHelper();

    if(isset($_POST["jl_id"]) && isset($_POST["jl_sl"]) && isset($_POST["jl_jl"]) && $_POST["jl_id"] != '' && $_POST["jl_sl"] != '' && $_POST["jl_jl"] != ''){
        $jl_id = $_POST["jl_id"];
        $jl_sl = $_POST["jl_sl"];
        $jl_jl = $_POST["jl_jl"] * 100;

        $sql = "insert into s_ta_jiangli(ta_ceng,jl_lx,jl_id,jl_sl,jl_jl) values ('$id','wp','$jl_id','$jl_sl','$jl_jl')";
        $res = $sqlHelper->execute_dml($sql);
    }

    $sql = "select num,jl_lx,jl_id,jl_sl,jl_jl from s_ta_jiangli where ta_ceng=$id and jl_lx != 'exp'";
    $res = $sqlHelper->execute_dql2($sql);
    if($res){
        echo '<div style="color:green;">名称数量 获得几率</div>';
        $count_jiangli = count($res);
        for($i=0;$i<$count_jiangli;$i++){
            $num = $res[$i]["num"];
            $jl_lx = $res[$i]["jl_lx"];
            $jl_id = $res[$i]["jl_id"];
            $jl_sl = $res[$i]["jl_sl"];
            $jl_jl = $res[$i]["jl_jl"];

            if($jl_lx = 'wp'){
                $sql = "select wp_name from s_wupin_all where num=$jl_id";
                $res1 = $sqlHelper->execute_dql($sql);
                echo '<div>'.$res1["wp_name"].'x'.$jl_sl.' '.($jl_jl / 100)."%</div>";
            }
        }
    }else{
        echo '<div style="color:red;">暂无奖励</div>';
    }

    echo '<br/>';

    dyt_wp_show_fenye('redyt.php',$dh_fl,$id);

    echo '<br/>';
    $url = 'x=w&id='.$id;
    echo "<div style='margin-top: 10px;'><a href='redyt.php?$url'>返回上页</a></div>";
    echo "<div'><a href='redyt.php?x=q'>返回大雁塔列表</a></div>";
}
elseif($dh_fl == "o" && $id) {
    //替换层数宝箱奖励前页面
    echo '<div style="margin-bottom: 10px;">闯塔挖宝奖励</div>';
    $sqlHelper = new SqlHelper();

    if(isset($_POST["jl_id"]) && isset($_POST["jl_sl"]) && isset($_POST["jl_jl"]) && $_POST["jl_id"] != '' && $_POST["jl_sl"] != '' && $_POST["jl_jl"] != ''){
        $jl_id = $_POST["jl_id"];
        $jl_sl = $_POST["jl_sl"];
        $jl_jl = $_POST["jl_jl"] * 100;

        $sql = "insert into s_ta_jiangli_box(ta_ceng,jl_lx,jl_id,jl_sl,jl_jl) values ('$id','wp','$jl_id','$jl_sl','$jl_jl')";
        $res = $sqlHelper->execute_dml($sql);
    }

    $sql = "select num,jl_lx,jl_id,jl_sl,jl_jl from s_ta_jiangli_box where ta_ceng=$id";
    $res = $sqlHelper->execute_dql2($sql);
    if($res){
        echo '<div style="color:green;">名称数量 获得几率</div>';
        $count_jiangli = count($res);
        for($i=0;$i<$count_jiangli;$i++){
            $num = $res[$i]["num"];
            $jl_lx = $res[$i]["jl_lx"];
            $jl_id = $res[$i]["jl_id"];
            $jl_sl = $res[$i]["jl_sl"];
            $jl_jl = $res[$i]["jl_jl"];

            if($jl_lx = 'wp'){
                $sql = "select wp_name from s_wupin_all where num=$jl_id";
                $res1 = $sqlHelper->execute_dql($sql);
                echo '<div>'.$res1["wp_name"].'x'.$jl_sl.' '.($jl_jl / 100)."%</div>";
            }
        }
    }else{
        echo '<div style="color:red;">暂无奖励</div>';
    }

    echo '<br/>';

    dyt_wp_show_fenye('redyt.php',$dh_fl,$id);

    echo '<br/>';
    $url = 'x=w&id='.$id;
    echo "<div style='margin-top: 10px;'><a href='redyt.php?$url'>返回上页</a></div>";
    echo "<div'><a href='redyt.php?x=q'>返回大雁塔列表</a></div>";
}
?>


<div style="margin-top: 20px;"><a href='index.php'>返回GM首页</a></div>
<div><a href='index.php?out=out'>退出登录</a></div>