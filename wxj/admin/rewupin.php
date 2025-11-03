<?php
/**
 * Author: by suxin
 * Date: 2020/1/21
 * Time: 11:14
 * Note: 物品管理
 */
?>

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
    <script type="text/javascript" src="http://wap.wmtgame.com/js/jquery.min.js"></script>
</head>
<?php

require_once "include/fzr.php";

//物品列表查询
function wp_show_fenye_rewupin($gotourl,$dh_fl){
    require_once "include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=20;

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

    getFenyePage_wp($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        echo '<table style="text-align: center;">';
        echo '<tr><td>序号</td><td>名称</td><td>商城价格</td><td>商城上架</td><td>操作</td></tr>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $wp_num = $row['num'];
            $wp_name = $row['wp_name'];
            $wp_coin = $row['wp_coin'];
            $wp_shop = $row['wp_shop'];

            if($wp_coin == 0){
                $wp_coin = '<span style="color:red;">'.$wp_coin.'</span>';
            }else{
                $wp_coin = '<span style="color:green;">'.$wp_coin.'</span>';
            }
            if($wp_shop == 0){
                $wp_shop = '<span style="color:red;">否</span>';
            }else{
                $wp_shop = '<span style="color:green;">是</span>';
            }
            $url = 'x=w&id='.$wp_num;
            echo '<tr><td>'.$wp_num.'</td><td>'.$wp_name.'</td><td>'.$wp_coin.'</td><td>'.$wp_shop."</td><td><a href='rewupin.php?$url'>管理</a></td></tr>";

        }
        $sqlHelper->close_connect();
        echo '</table>';

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无物品</div>';
    }
}

//箱子新增物品列表查询
function wp_show_fenye_xiangzi($gotourl,$dh_fl,$xiangzi_num){
    require_once "include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=150;

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

    getFenyePage_wp_xiangzi($fenyePage,$dh_fl,$xiangzi_num);

    if($fenyePage->res_array){
        echo '<table style="text-align: center";>';
        echo '<tr><td>序号</td><td>名称</td><td>最小数量</td><td>最大数量</td><td>几率</td><td>操作</td></tr>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $wp_num = $row['num'];
            $wp_name = $row['wp_name'];

            echo '<form action="" method="post">';
            echo "<input type='hidden' name='wp_num' value='$wp_num'>";
            echo '<tr><td>'.$wp_num.'</td><td>'.$wp_name.'</td><td><input type="text" name="min_sl" style="width:64px;"></td><td><input type="text" name="max_sl" style="width:64px;"></td><td><input type="text" name="jilv" style="width:64px;"></td><td><input type="submit" name="submit" value="增加"></td></tr>';

            echo '</form>';
        }
        echo '</table>';
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无物品</div>';
    }
}

echo "<div style='margin-bottom: 10px;'>【物品管理】</div>";


if($_SERVER["QUERY_STRING"]) {

    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];
    }else{
        $dh_fl = $_GET["x"];
    }
}


if($dh_fl == 'q'){
    //物品列表
    echo '<div style="margin-bottom: 10px;"><a href="rewupin.php?x=r">新增物品</a></div>';
    wp_show_fenye_rewupin('rewupin.php',$dh_fl);
}
elseif($dh_fl == 'w' && $_GET["id"]){
    //物品详情
    if(isset($_POST["submit"])){
        $wp_name = trim($_POST["wp_name"]);
        $wp_coin = trim($_POST["wp_coin"]);
        $wp_xfl = trim($_POST["wp_xfl"]);
        $wp_shop_fl = trim($_POST["wp_shop_fl"]);
        $wp_zfl = trim($_POST["wp_zfl"]);
        $wp_note = trim($_POST["wp_note"]);

        $sqlHelper = new SqlHelper();

        if($wp_name != ''){
            $sql = "update s_wupin_all set wp_name='$wp_name' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($wp_coin != ''){
            $sql = "update s_wupin_all set wp_coin='$wp_coin' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($wp_xfl != 'wu'){
            $sql = "update s_wupin_all set wp_xfl='$wp_xfl' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($wp_shop_fl != 'wu'){
            $sql = "update s_wupin_all set wp_shop_fl='$wp_shop_fl' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($wp_zfl != 'wu'){
            $sql = "update s_wupin_all set wp_zfl='$wp_zfl' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($wp_note != ''){
            $sql = "update s_wupin_all set wp_note='$wp_note' where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
    }

    if(isset($_GET["k"])){
        if($_GET["k"] == 1){
            $sqlHelper = new SqlHelper();
            $sql = "update s_wupin_all set wp_canuse=0 where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }elseif($_GET["k"] == 2){
            $sqlHelper = new SqlHelper();
            $sql = "update s_wupin_all set wp_canuse=1 where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }elseif($_GET["k"] == 3){
            $sqlHelper = new SqlHelper();
            $sql = "update s_wupin_all set wp_bd=0 where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }elseif($_GET["k"] == 4){
            $sqlHelper = new SqlHelper();
            $sql = "update s_wupin_all set wp_bd=1 where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }elseif($_GET["k"] == 5){
            $sqlHelper = new SqlHelper();
            $sql = "update s_wupin_all set wp_shop=0 where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }elseif($_GET["k"] == 6){
            $sqlHelper = new SqlHelper();
            $sql = "update s_wupin_all set wp_shop=1 where num=$_GET[id]";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }
    }

    echo "<div style='margin-bottom: 5px;'><a href='rewupin.php?x=t&id=$_GET[id]'>删除该物品</a></div>";

    $sqlHelper = new SqlHelper();
    $sql = "select wp_name,wp_canuse,wp_coin,wp_bd,wp_xfl,wp_shop_fl,wp_zfl,wp_shop,wp_list,wp_note from s_wupin_all where num='$_GET[id]'";
    $res = $sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();
    if($res){
        echo '<form action="" method="post">';
        echo '<div>物品名称: <span style="color:green;">'.$res["wp_name"].'</span> <input style="width:120px;" type="text" name="wp_name"></div>';
        echo '<div>是否可用: ';
        if($res["wp_canuse"]){
            $url = 'x=w&id='.$_GET["id"].'&k=1';
            echo "<span style='color:green;'>可用</span> <a href='rewupin.php?$url'>切换</a>";
        }else{
            $url = 'x=w&id='.$_GET["id"].'&k=2';
            echo "<span style='color:green;'>不可用</span> <a href='rewupin.php?$url'>切换</a>";
        }
        echo '</div>';
        echo '<div>物品价格: <span style="color:green;">'.$res["wp_coin"].'</span> <input style="width:120px;" type="text" name="wp_coin"></div>';
        echo '<div>物品绑定: ';
        if($res["wp_bd"] == 1){
            $url = 'x=w&id='.$_GET["id"].'&k=3';
            echo "<span style='color:green;'>已绑定</span> <a href='rewupin.php?$url'>切换</a>";
        }else{
            $url = 'x=w&id='.$_GET["id"].'&k=4';
            echo "<span style='color:green;'>未绑定</span> <a href='rewupin.php?$url'>切换</a>";
        }
        echo '</div>';
        echo '<div>物品详细分类: ';
        if($res["wp_xfl"] == 'daoju'){
            echo "<span style='color:green;'>道具</span>";
        }elseif($res["wp_xfl"] == 'baoshi'){
            echo "<span style='color:green;'>宝石</span>";
        }elseif($res["wp_xfl"] == 'chenghao'){
            echo "<span style='color:green;'>称号</span>";
        }elseif($res["wp_xfl"] == 'hunlian'){
            echo "<span style='color:green;'>婚链</span>";
        }elseif($res["wp_xfl"] == 'xiangzi'){
            echo "<span style='color:green;'>箱子</span>";
        }
        echo ' <select name="wp_xfl">
        <option value="wu" selected>无</option>
        <option value="daoju">道具</option>
        <option value="baoshi">宝石</option>
        <option value="chenghao">称号</option>
        <option value="hunlian">婚链</option>
        <option value="xiangzi">箱子</option>
        </select>';

        echo '</div>';

        if($res["wp_xfl"] == 'xiangzi'){
            $url = 'x=e&id='.$_GET["id"];
            echo "<div style='margin-bottom: 10px;margin-top: 10px;'>物品开箱列表: <a href='rewupin.php?$url'>管理</a>";
            if($res["wp_list"]){
                $wp_list = explode('|',$res["wp_list"]);

                $sqlHelper = new SqlHelper();
                echo '<table>';
                echo '<tr><td>物品</td><td>名称</td><td>数量</td><td>几率</td></tr>';
                for($i=0;$i<count($wp_list);$i++){
                    $jiangli = explode(",",$wp_list[$i]);
                    if($jiangli[0] == 'wp'){
                        $sql = "select wp_name from s_wupin_all where num=$jiangli[1]";
                        $res1 = $sqlHelper->execute_dql($sql);
                        echo '<tr><td>物品</td><td>'.$res1["wp_name"].'</td><td>'.$jiangli[2] . '</td><td>'.($jiangli[3] / 100).'</td></tr>';
                    }
                }
                echo '</table>';
                $sqlHelper->close_connect();
            }else{
               echo '无';
            }

            echo '</div>';
        }

        echo '<div>物品商城分类: ';
        if($res["wp_shop_fl"] == 'daoju'){
            echo "<span style='color:green;'>道具</span>";
        }elseif($res["wp_shop_fl"] == 'baoshi'){
            echo "<span style='color:green;'>宝石</span>";
        }elseif($res["wp_shop_fl"] == 'chenghao'){
            echo "<span style='color:green;'>称号</span>";
        }elseif($res["wp_shop_fl"] == 'libao'){
            echo "<span style='color:green;'>礼包</span>";
        }
        echo ' <select name="wp_shop_fl">
        <option value="wu" selected>无</option>
        <option value="daoju">道具</option>
        <option value="baoshi">宝石</option>
        <option value="chenghao">称号</option>
        <option value="libao">礼包</option>
        </select>';

        echo '</div>';

        echo '<div>物品背包分类: ';
        if($res["wp_zfl"] == 'wp'){
            echo "<span style='color:green;'>物品</span>";
        }elseif($res["wp_zfl"] == 'bs'){
            echo "<span style='color:green;'>宝石</span>";
        }elseif($res["wp_zfl"] == 'ch'){
            echo "<span style='color:green;'>称号</span>";
        }elseif($res["wp_zfl"] == 'lb'){
            echo "<span style='color:green;'>礼包</span>";
        }elseif($res["wp_zfl"] == 'hl'){
            echo "<span style='color:green;'>婚链</span>";
        }
        echo ' <select name="wp_zfl">
        <option value="wu" selected>无</option>
        <option value="wp">物品</option>
        <option value="bs">宝石</option>
        <option value="ch">称号</option>
        <option value="lb">礼包</option>
        <option value="hl">婚链</option>
        </select>';

        echo '</div>';
        echo '<div>物品商城出售: ';
        if($res["wp_shop"] == 1){
            $url = 'x=w&id='.$_GET["id"].'&k=5';
            echo "<span style='color:green;'>已上架</span> <a href='rewupin.php?$url'>切换</a>";
        }else{
            $url = 'x=w&id='.$_GET["id"].'&k=6';
            echo "<span style='color:green;'>未上架</span> <a href='rewupin.php?$url'>切换</a>";
        }
        echo '</div>';
        echo '<div>物品说明: <span style="color:green;">'.$res["wp_note"].'</span> <input style="width:180px;" type="text" name="wp_note"></div>';
        echo '<input style="margin-left:80px;margin-top: 10px;"  type="submit" name="submit" value="确认修改">';
        echo '</form>';
    }else{
        echo '<div>该物品不存在</div>';
    }

    echo "<div><a href='rewupin.php?x=q'>返回物品列表</a></div>";
}
elseif($dh_fl == 'e' && $_GET["id"]){
    //修改箱子物品
    if(isset($_GET["wpnum"])){
        $sqlHelper = new SqlHelper();
        $sql = "select wp_name,wp_xfl,wp_list from s_wupin_all where num='$_GET[id]'";
        $res = $sqlHelper->execute_dql($sql);

        if($res){
            if($res["wp_list"]){
                $wp_list_array = array();

                $wp_list = explode('|',$res["wp_list"]);
                $sqlHelper = new SqlHelper();
                for($i=0;$i<count($wp_list);$i++){
                    $jiangli = explode(",",$wp_list[$i]);
                    if($jiangli[1] == $_GET["wpnum"]){
                        continue;
                    }else{
                        $wp_list_array []= $jiangli[0].','.$jiangli[1].','.$jiangli[2].','.$jiangli[3];
                    }
                }

                $wp_list = '';
                for($i=0;$i<count($wp_list_array);$i++){
                    if($i == 0){
                        $wp_list .= $wp_list_array[$i];
                    }else{
                        $wp_list .= '|'.$wp_list_array[$i];
                    }
                }

                $sql = "update s_wupin_all set wp_list='$wp_list' where num='$_GET[id]'";
                $res = $sqlHelper->execute_dml($sql);
            }
        }

        $sqlHelper->close_connect();
    }

    if(isset($_POST["submit"])){
        $min_sl = trim($_POST["min_sl"]);
        $max_sl = trim($_POST["max_sl"]);
        $wp_num = trim($_POST["wp_num"]);
        $jilv = trim($_POST["jilv"]) * 100;

        ######## ########### ##################
        ######## ########### ##################
        $sqlHelper = new SqlHelper();
        $sql = "select wp_name,wp_xfl,wp_list from s_wupin_all where num='$_GET[id]'";
        $res = $sqlHelper->execute_dql($sql);

        if($res) {
            if ($res["wp_xfl"] == 'xiangzi') {
                $add_state = 1;

                $wp_list = explode('|', $res["wp_list"]);
                $sqlHelper = new SqlHelper();
                for ($i = 0; $i < count($wp_list); $i++) {
                    $jiangli = explode(",", $wp_list[$i]);
                    if ($jiangli[1] == $wp_num) {
                        $add_state = 0;
                        break;
                    }
                }

                if($add_state == 1){
                    $wp_list = $res["wp_list"];
                    if($wp_list){
                        $wp_list .= '|'.'wp,'.$wp_num.','.$min_sl.'~'.$max_sl.','.$jilv;
                    }else{
                        $wp_list = 'wp,'.$wp_num.','.$min_sl.'~'.$max_sl.','.$jilv;
                    }
                }

                $sql = "update s_wupin_all set wp_list='$wp_list' where num='$_GET[id]'";
                $res = $sqlHelper->execute_dml($sql);
            }
        }

        $sqlHelper->close_connect();
    }

    $sqlHelper = new SqlHelper();
    $sql = "select wp_name,wp_xfl,wp_list from s_wupin_all where num='$_GET[id]'";
    $res = $sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();
    if($res){
        echo '<div>物品名称: '.$res["wp_name"].'</div>';

        if($res["wp_xfl"] == 'xiangzi'){
            echo "<div style='margin-bottom: 10px;margin-top: 10px;'>物品开箱列表: </div>";
            if($res["wp_list"]){
                $wp_list = explode('|',$res["wp_list"]);

                $sqlHelper = new SqlHelper();
                echo '<table style="text-align: center;">';
                echo '<tr><td>分类</td><td>名称</td><td>数量</td><td>几率</td><td>操作</td></tr>';
                for($i=0;$i<count($wp_list);$i++){
                    $jiangli = explode(",",$wp_list[$i]);
                    if($jiangli[0] == 'wp'){
                        $sql = "select wp_name from s_wupin_all where num=$jiangli[1]";
                        $res1 = $sqlHelper->execute_dql($sql);
                        $url = 'x=e&id='.$_GET["id"].'&wpnum='.$jiangli[1];
                        echo '<tr><td>物品</td><td>'.$res1["wp_name"].'</td><td>'.$jiangli[2] . '</td><td>'.($jiangli[3] / 100)."%</td><td><a href='rewupin.php?$url'>删除</a></td></tr>";
                    }
                }
                echo '</table>';
                $sqlHelper->close_connect();
            }else{
                echo '无';
            }

            echo '<div style="margin-top: 40px;"></div>';

            wp_show_fenye_xiangzi('rewupin.php',$dh_fl,$_GET["id"]);
        }else{
            echo '<div>该物品无法选择开箱物品</div>';
        }


        $url = 'x=w&id='.$_GET["id"];
        echo "<div style='margin-top: 10px;'><a href='rewupin.php?$url'>返回物品详情</a></div>";
    }else{
        echo '<div>该物品不存在</div>';
    }

    echo "<div><a href='rewupin.php?x=q'>返回物品列表</a></div>";
}
elseif($dh_fl == 'r') {
    //新增
    if (isset($_POST["submit"])) {
        $wp_name = trim($_POST["wp_name"]);
        $wp_canuse = trim($_POST["wp_canuse"]);
        $wp_bd = trim($_POST["wp_bd"]);
        $wp_coin = trim($_POST["wp_coin"]);
        $wp_xfl = trim($_POST["wp_xfl"]);
        $wp_shop_fl = trim($_POST["wp_shop_fl"]);
        $wp_zfl = trim($_POST["wp_zfl"]);
        $wp_note = trim($_POST["wp_note"]);
        $wp_shop = trim($_POST["wp_shop"]);

        $sqlHelper = new SqlHelper();
        $sql = "select num from s_wupin_all where wp_name='$wp_name'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();
        if($res){
            echo '<div style="margin-bottom: 5px;color:red;">该物品已存在</div>';
        }else{
            $sqlHelper = new SqlHelper();
            $sql = "insert into s_wupin_all(wp_name,wp_canuse,wp_coin,wp_bd,wp_xfl,wp_shop_fl,wp_zfl,wp_shop,wp_note) values ('$wp_name','$wp_canuse','$wp_coin','$wp_bd','$wp_xfl','$wp_shop_fl','$wp_zfl','$wp_shop','$wp_note')";
            $res = $sqlHelper->execute_dml($sql);
            $sql = "select num from s_wupin_all where wp_name='$wp_name'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();
            header("location: rewupin.php?x=w&id=$res[num]");
            exit;
        }
    }

    echo '<form action="" method="post">';
    echo '<div>物品名称: <input style="width:120px;" type="text" name="wp_name"></div>';
    echo '<div>是否可用: ';
    echo '<select name="wp_canuse">
        <option value="0" selected>否</option>
        <option value="1">是</option>
        </select>';
    echo '</div>';
    echo '<div>物品价格: <input style="width:120px;" type="text" name="wp_coin"></div>';
    echo '<div>物品绑定: ';
    echo '<select name="wp_bd">
        <option value="0" selected>否</option>
        <option value="1">是</option>
        </select>';
    echo '</div>';
    echo '<div>物品详细分类: ';
    echo '<select name="wp_xfl">
        <option value="wu" selected>无</option>
        <option value="daoju">道具</option>
        <option value="baoshi">宝石</option>
        <option value="chenghao">称号</option>
        <option value="hunlian">婚链</option>
        <option value="xiangzi">箱子</option>
        </select>';

    echo '</div>';


    echo '<div>物品商城分类: ';
    echo '<select name="wp_shop_fl">
        <option value="wu" selected>无</option>
        <option value="daoju">道具</option>
        <option value="baoshi">宝石</option>
        <option value="chenghao">称号</option>
        <option value="libao">礼包</option>
        </select>';

    echo '</div>';

    echo '<div>物品背包分类: ';
    echo '<select name="wp_zfl">
        <option value="wu" selected>无</option>
        <option value="wp">物品</option>
        <option value="bs">宝石</option>
        <option value="ch">称号</option>
        <option value="lb">礼包</option>
        <option value="hl">婚链</option>
        </select>';

    echo '</div>';
    echo '<div>物品商城出售: ';
    echo '<select name="wp_shop">
        <option value="0" selected>不出售</option>
        <option value="1">出售</option>
        </select>';
    echo '</div>';
    echo '<div>物品说明: <input style="width:180px;" type="text" name="wp_note"></div>';
    echo '<input style="margin-left:80px;margin-top: 10px;"  type="submit" name="submit" value="确认增加">';
    echo '</form>';


    echo "<div><a href='rewupin.php?x=q'>返回物品列表</a></div>";
}
elseif($dh_fl == 't' && $_GET["id"]){
    //删除物品
    $sqlHelper = new SqlHelper();
    $sql = "delete from s_wupin_all where num=$_GET[id]";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();

    header("location: rewupin.php?x=q");
    exit;
}
?>


<div style="margin-top: 10px;"><a href='index.php'>返回GM首页</a></div>
<div><a href='index.php?out=out'>退出登录</a></div>