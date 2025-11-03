<?php
/**
 * Author: by suxin
 * Date: 2019/12/17
 * Time: 10:52
 * Note: 拍卖行
 */


require_once '../include/fzr.php';
require_once '../include/SqlHelper.class.php';
require_once '../include/func.php';


//拍卖行物品总览列表
function paimai_show_fenye_paimai($gotourl,$pm_wp_zfl,$dh_fl,$pagenowid){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=15;

    $fenyePage->pageNow=$pagenowid;

    getFenyePage_paimai_shangjia($fenyePage,$pm_wp_zfl,$dh_fl);

    $xuhao = ($pagenowid - 1) * $fenyePage->pageSize +1;

    if(!$fenyePage->res_array){
        echo "<div></div><br/>";
        echo "<div><span style='color:green;'>暂无物品出售</span></div><br/>";
    }

    global $date,$key_url_md_5;

    $sqlHelper=new SqlHelper();
    for($i=0;$i<count($fenyePage->res_array);$i++) {
        $row = $fenyePage->res_array[$i];

        $wp_num = $row["wp_num"];

        $sql = "select count(num) from s_wj_paimai where wp_num=$wp_num and wp_money !=''";

        $res = $sqlHelper->execute_dql($sql);
        $shoumai_count = $res["count(num)"];

        $sql = "select wp_name from s_wupin_all where num=$wp_num";
        $res = $sqlHelper->execute_dql($sql);
        $wupin_name = $res["wp_name"];

        $jiami1 = "x=v&id=".$wp_num;
        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

        echo "<div>".$xuhao.".<a href='pm.php?$url1'>" . $wupin_name . "</a> (" . $shoumai_count . "件)</div>";

        $xuhao += 1;
    }

    $sqlHelper->close_connect();

    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
    }

    if($fenyePage->res_array){
        echo '<br/>';
    }

    $jiami1 = "x=a";
    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
    $jiami2 = "x=qq";
    $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

    echo "<div><a href='pm.php?$url1'>上架拍卖</a>|<a href='pm.php?$url2'>拍卖信息</a></div>";
}

//金币选择物品寄售导航
function money_jishou_daohang($dq_fenlei,$pagenowid){
    $daohang_array = wj_bag_pm_daohang();

    for($i=0;$i<count($daohang_array);$i++){
        if($dq_fenlei == $daohang_array[$i][0]){
            echo $daohang_array[$i][1];
            $fenlei = $daohang_array[$i][2];
        }else{
            $daohang_fenlei = $daohang_array[$i][0];

            global $date,$key_url_md_5;
            $jiami1 = "x=".$daohang_fenlei;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<a href='pm.php?$url1'>".$daohang_array[$i][1]."</a>";

        }

        if((($i+1) % 4) == 0){
            echo '<br/>';
        }else{
            if(($i + 1) < count($daohang_array)){
                echo '|';
            }
        }
    }

    bag_show_fenye_paimai("pm.php","$fenlei",$dq_fenlei,$pagenowid);

}

//背包物品可被拍卖的列表
function bag_show_fenye_paimai($gotourl,$bag_fenlei,$dh_fl,$pagenowid){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=15;

    $fenyePage->pageNow=$pagenowid;

    getFenyePage_bag_paimai($fenyePage,$bag_fenlei,$dh_fl);

    $xuhao = ($pagenowid - 1) * $fenyePage->pageSize +1;

    global $date,$key_url_md_5;

    $sqlHelper=new SqlHelper();
    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];

        $jiami1 = "x=z&id=".$num;
        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

        echo "<div>".$xuhao.".<a href='pm.php?$url1'>".$row['wp_name']."(".$row["wp_counts"].")</a></div>";
        $xuhao += 1;
    }
    $sqlHelper->close_connect();

    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
    }

    $jiami1 = "x=q";
    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

    echo "<br/><div><a href='pm.php?$url1'>返回拍卖行</a></div>";
}

//拍卖行某个物品一览列表
function paimai_show_fenye_one_list($gotourl,$wp_num,$dh_fl,$pagenowid){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=15;

    $fenyePage->pageNow=$pagenowid;

    getFenyePage_paimai_one_list($fenyePage,$wp_num,$dh_fl);

    $xuhao = ($pagenowid - 1) * $fenyePage->pageSize +1;

    echo '<div>【拍卖行】</div>';

    global $date,$key_url_md_5;

    $sqlHelper=new SqlHelper();
    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $wp_counts = $row["wp_counts"];
        $wp_money = $row["wp_money"];

        $sql = "select wp_name from s_wupin_all where num=$wp_num";
        $res = $sqlHelper->execute_dql($sql);
        $wupin_name = $res["wp_name"];

        $jiami1 = "x=b&id=".$num;
        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

        echo "<div>".$xuhao.".<a href='pm.php?$url1'>".$wupin_name."x".$wp_counts."</a>(".$wp_money."灵石)</div>";

        $xuhao += 1;
    }
    $sqlHelper->close_connect();

    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }

    $jiami1 = "x=q";
    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

    echo "<div><a href='pm.php?$url1'>返回拍卖行</a></div>";
}

//检查物品过期情况
function check_wp_expire_time(){
    $sqlHelper=new SqlHelper();
    $now_time = date("Y-m-d H:i:s");
    $sql = "select num,s_name,wp_num,wp_counts from s_wj_paimai where wp_expire_time < '$now_time'";
    $res = $sqlHelper->execute_dql2($sql);

    for($i=0;$i<count($res);$i++){
        $num = $res[$i]["num"];
        $s_name = $res[$i]["s_name"];
        $wp_num = $res[$i]["wp_num"];
        $wp_counts = $res[$i]["wp_counts"];

        $sql = "delete from s_wj_paimai where num=$num";
        $res1 = $sqlHelper->execute_dml($sql);

        $now_time = date("Y-m-d H:i:s");
        $sql = "insert into s_wj_youxiang(s_name,wp_num,wp_counts,yx_leixin,times) values('$s_name','$wp_num','$wp_counts','pmgq','$now_time')";
        $res1 = $sqlHelper->execute_dml($sql);
    }

    $sqlHelper->close_connect();
}

//查看我的拍卖物品
function wj_pm_show_fenye($gotourl,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=15;

    global $key_url_md_5,$date;

    if($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];
            if($pagenowid > 20){
                $fenyePage->pageNow=20;
            }else{
                $fenyePage->pageNow=$pagenowid;
            }
            $xuhao = ($fenyePage->pageNow - 1) * $fenyePage->pageSize +1;
        }else{
            $xuhao = 1;
        }
    }

    getFenyePage_wj_pm($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num=$row['num'];
            $wp_num=$row['wp_num'];
            $wp_counts=$row['wp_counts'];
            $wp_money=$row['wp_money'];

            $sql = "select wp_name from s_wupin_all where num=$wp_num";
            $res1 = $sqlHelper->execute_dql($sql);
            $wp_name = $res1["wp_name"];

            $jiami1 = 'x=ww&id='.$num;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo '<div>'.$xuhao.".<a href='pm.php?$url1'>".$wp_name."x".$wp_counts."</a>(".$wp_money."灵石)</div>";

            $xuhao++;
        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无上架物品</div>';
    }
}

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {

        check_wp_expire_time();

        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if ($dh_fl == 'q' || $dh_fl == 'w' || $dh_fl == 'e' || $dh_fl == 'r') {
            //拍卖行-物品分类
            echo '<div>【拍卖行】</div>';

            $daohang_array = pm_daohang();

            for ($i = 0; $i < count($daohang_array); $i++) {
                if ($dh_fl == $daohang_array[$i][0]) {
                    echo $daohang_array[$i][1];
                    $fenlei = $daohang_array[$i][2];
                } else {
                    $daohang_fenlei = $daohang_array[$i][0];

                    $jiami1 = "x=" . $daohang_fenlei;
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<a href='pm.php?$url1'>" . $daohang_array[$i][1] . "</a>";
                }

                if ((($i + 1) % 4) == 0) {
                    echo '<br/>';
                } else {
                    if (($i + 1) < count($daohang_array)) {
                        echo '|';
                    }
                }
            }

            if (isset($url_info["pagenowid"])) {
                $suxin1 = explode(".", $url_info["pagenowid"]);
                $pagenowid = $suxin1[0];
            } else {
                $pagenowid = 1;
            }

            paimai_show_fenye_paimai("pm.php", "$fenlei","$dh_fl",$pagenowid);
        }
        elseif ($dh_fl == 'a' || $dh_fl == 's' || $dh_fl == 'd' || $dh_fl == 'f') {
            //上架物品
            echo "<div>【拍卖行-寄售】</div>";
            if (isset($url_info["pagenowid"])) {
                $suxin1 = explode(".", $url_info["pagenowid"]);
                $pagenowid = $suxin1[0];
            } else {
                $pagenowid = 1;
            }

            money_jishou_daohang($dh_fl, $pagenowid);
        }
        elseif ($dh_fl == 'z') {
            //上架物品信息查看
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_id = $suxin1[0];

                wp_info($wp_id, 1);
            }

            $jiami1 = "x=a";
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            echo "<div><a href='pm.php?$url1'>返回上页</a></div>";
        }
        elseif ($dh_fl == 'x') {
            //上架物品确认
            $jiami1 = "x=a";
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            if (isset($_POST["submit"])) {
                $wp_num = floor($_POST["wp_num"]);
                $wp_counts = floor($_POST["shuliang"]);
                $wp_money = floor($_POST["money"]);

                require_once '../../safe/feifa.php';

                $wp_num_state = feifa_shuzi($wp_num);
                $wp_money_state = feifa_shuzi($wp_money);
                $wp_counts_state = feifa_shuzi($wp_counts);

                if ($wp_num_state == 1 && $wp_money_state == 1 && $wp_counts_state == 1) {
                    $sqlHelper = new SqlHelper();
                    $sql = "select wp_name,wp_counts,wp_bd from s_wj_bag where s_name='$_SESSION[id]' and num=$wp_num";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();
                    if ($res) {
                        if ($res["wp_bd"] == 1) {
                            header("location: pm.php?$url1");
                            exit;
                        }

                        echo '【拍卖行-寄售】<br/>';

                        if ($res["wp_counts"] >= $wp_counts) {
                            require_once '../control/control.php';

                            $paimai_shouxufei = paimai_shouxufei();
                            echo '你确定以<span style="color:red;">' . $wp_money . '</span>灵石的价格拍卖 <span style="color:green;">' . $res["wp_name"] . 'x' . $wp_counts . '</span>？<br/>';
                            $shouxufei = floor(($paimai_shouxufei / 100) * $wp_money);
                            if ($shouxufei <= 0) {
                                $shouxufei = '1';
                            }
                            echo '【将收取你<span style="color:red;">' . $shouxufei . '</span>灵石作为手续费！！！】<br/>';

                            $jiami1 = "x=c";
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                            echo "<form action='pm.php?$url1' method='post'>";
                            echo "<input type='hidden' name='shuliang' value='$wp_counts'>";
                            echo "<input type='hidden' name='money' value='$wp_money'>";
                            echo "<input type='hidden' name='wp_num' value='$wp_num'>";
                            echo "<input type='submit' name='submit' value='确认上架' class='button_djy' style='margin-top: 10px;'>";
                            echo "</form>";

                            $jiami1 = "x=z&id=" . $wp_num;
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                            echo "<div><a href='pm.php?$url1'>重新设定价格</a></div>";
                        } else {
                            echo '<div>物品数量不足，无法进行拍卖</div>';
                            $jiami1 = "x=z&id=" . $wp_num;
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                            echo "<div><a href='pm.php?$url1'>重新设定数量</a></div>";
                        }
                    } else {
                        header("location: pm.php?$url1");
                        exit;
                    }
                } else {
                    header("location: pm.php?$url1");
                    exit;
                }
            } else {
                header("location: pm.php?$url1");
                exit;
            }
        }
        elseif ($dh_fl == 'c') {
            //上架物品执行-金币
            $jiami1 = "x=a";
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            if (isset($_POST["submit"])) {
                $wp_num = $_POST["wp_num"];
                $wp_counts = $_POST["shuliang"];
                $wp_money = $_POST["money"];

                require_once '../../safe/feifa.php';

                $wp_num_state = feifa_shuzi($wp_num);
                $wp_money_state = feifa_shuzi($wp_money);
                $wp_counts_state = feifa_shuzi($wp_counts);

                if ($wp_num_state == 1 && $wp_money_state == 1 && $wp_counts_state == 1) {
                    $sqlHelper = new SqlHelper();
                    $sql = "select wp_name,wp_counts,wp_bd from s_wj_bag where s_name='$_SESSION[id]' and num=$wp_num";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();
                    if ($res) {
                        if ($res["wp_bd"] == 1) {
                            header("location: pm.php?$url1");
                            exit;
                        }

                        echo '【拍卖行-寄售】';

                        if ($res["wp_counts"] >= $wp_counts) {
                            require_once '../control/control.php';

                            $paimai_shouxufei = paimai_shouxufei();
                            $shouxufei = floor(($paimai_shouxufei / 100) * $wp_money);
                            if ($shouxufei <= 0) {
                                $shouxufei = 1;
                            }

                            $sqlHelper = new SqlHelper();
                            $wj_money = $sqlHelper->chaxun_wj_user_neirong("money");
                            $sqlHelper->close_connect();
                            if ($wj_money >= $shouxufei) {
                                $sqlHelper = new SqlHelper();
                                $sql = "select num,wp_zfl from s_wupin_all where wp_name='$res[wp_name]'";
                                $res1 = $sqlHelper->execute_dql($sql);
                                $wp_num = $res1["num"];
                                $wp_zfl = $res1["wp_zfl"];
                                $sqlHelper->close_connect();

                                $use_state = use_wupin("$res[wp_name]", $wp_counts);

                                if ($use_state == 1) {
                                    $sqlHelper = new SqlHelper();

                                    $sqlHelper->jianshao_wj_user_neirong("money", $shouxufei);

                                    $wp_expire_time = date("Y-m-d H:i:s", strtotime("+24 hour"));
                                    $now_time = date("Y-m-d H:i:s");

                                    $sql = "insert into s_wj_paimai(s_name,wp_num,wp_counts,wp_money,wp_zfl,wp_expire_time,wp_start_time) values('$_SESSION[id]','$wp_num','$wp_counts','$wp_money','$wp_zfl','$wp_expire_time','$now_time')";
                                    $res = $sqlHelper->execute_dml($sql);
                                    $sqlHelper->close_connect();
                                    echo "<div>物品上架成功，收取了 <span style='color:red;'>" . $shouxufei . "</span>灵石作为手续费</div>";

                                    $jiami1 = "x=q";
                                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                    echo "<a href='pm.php?$url1'>返回拍卖行</a>";
                                } else {
                                    header("location: pm.php?$url1");
                                    exit;
                                }
                            } else {
                                echo "<div>灵石不足，无法上架拍卖行</div>";
                                $jiami1 = "x=z&id=" . $wp_num;
                                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                echo "<div><a href='pm.php?$url1'>重新设定价格</a></div>";
                            }
                        } else {
                            echo "<div>物品数量不足，无法进行拍卖</div>";

                            $jiami1 = "x=z&id=" . $wp_num;
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                            echo "<div><a href='pm.php?$url1'>重新设定数量</a></div>";
                        }
                    } else {
                        header("location: pm.php?$url1");
                        exit;
                    }
                } else {
                    header("location: pm.php?$url1");
                    exit;
                }
            } else {
                header("location: pm.php?$url1");
                exit;
            }
        }
        elseif($dh_fl == 'v'){
            //查看某件物品拍卖信息一览
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_num = $suxin1[0];
            }

            if (isset($url_info["pagenowid"])) {
                $suxin1 = explode(".", $url_info["pagenowid"]);
                $pagenowid = $suxin1[0];
            } else {
                $pagenowid = 1;
            }

            paimai_show_fenye_one_list("pm.php",$wp_num,$dh_fl,$pagenowid);
        }
        elseif($dh_fl == 'b' || $dh_fl == 'ww'){
            //查看某件物品详细信息
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_num = $suxin1[0];

                require_once '../control/control.php';

                if($dh_fl == 'b'){
                    wp_info($wp_num,2);
                }else{
                    wp_info($wp_num,3);
                }
            }
        }
        elseif($dh_fl == 'n'){
            //收回拍卖行自己寄售的物品并发送至邮箱
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_num = $suxin1[0];

                echo "【拍售物品下架】<br/>";
                $sqlHelper = new SqlHelper();
                $sql = "select wp_num,wp_counts,wp_start_time from s_wj_paimai where s_name='$_SESSION[id]' and num=$wp_num";
                $res = $sqlHelper->execute_dql($sql);
                if ($res) {
                    require_once '../control/control.php';

                    $paimai_quxiao_time = paimai_quxiao_time();
                    $zhuanhuan_guoqu_time = zhuanhuan_guoqu_time($res["wp_start_time"]);
                    if($zhuanhuan_guoqu_time < $paimai_quxiao_time){
                        $sy_sec = $paimai_quxiao_time - $zhuanhuan_guoqu_time;
                        echo '<div>刚上架的物品需要'.floor($paimai_quxiao_time/60).'分钟后才能收回，还需等待'.$sy_sec.'秒。<div>';

                        $jiami1 = "x=n&id=".$wp_num;
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        echo "<div><a href='pm.php?$url1'>刷新查看</a><div>";
                    }else{
                        $sql = "delete from s_wj_paimai where s_name='$_SESSION[id]' and num=$wp_num";
                        $res1 = $sqlHelper->execute_dml($sql);
                        $wp_num = $res["wp_num"];
                        $wp_counts = $res["wp_counts"];
                        $now_time = date("Y-m-d H:i:s");

                        $sql = "insert into s_wj_youxiang(s_name,wp_num,wp_counts,yx_leixin,times)values('$_SESSION[id]','$wp_num','$wp_counts','pmqx','$now_time')";
                        $res1 = $sqlHelper->execute_dml($sql);
                        echo '<div>你已取消了本次拍卖，请到邮箱领取<div>';
                    }
                }else{
                    echo "<div>该交易不存在</div>";
                }

                $sqlHelper->close_connect();

                $jiami1 = "x=q";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<br/><div><a href='pm.php?$url1'>返回拍卖行</a></div>";
            }
        }
        elseif($dh_fl == 'm'){
            //购买物品
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_num = $suxin1[0];

                $sqlHelper=new SqlHelper();
                $sql = "select wp_num,wp_counts,wp_money,s_name from s_wj_paimai where num=$wp_num";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res){
                    if($res["s_name"] != $_SESSION["id"]){
                        $sqlHelper=new SqlHelper();
                        $wj_money = $sqlHelper->chaxun_wj_user_neirong("money");
                        $sqlHelper->close_connect();

                        if($wj_money >= $res["wp_money"]){
                            $sqlHelper=new SqlHelper();
                            $sqlHelper->jianshao_wj_user_neirong("money",$res["wp_money"]);
                            $sql = "delete from s_wj_paimai where num=$wp_num";
                            $res1 = $sqlHelper->execute_dml($sql);
                            $sqlHelper->close_connect();

                            $now_time = date("Y-m-d H:i:s");

                            $sqlHelper=new SqlHelper();
                            $sql = "insert into s_wj_youxiang(s_name,wp_num,wp_counts,yx_leixin,times) values('$_SESSION[id]','$res[wp_num]','$res[wp_counts]','pmgm','$now_time')";
                            $res1 = $sqlHelper->execute_dml($sql);

                            $sql = "insert into s_wj_youxiang(s_name,wp_num,wp_counts,money,yx_leixin,times) values('$res[s_name]','$res[wp_num]','$res[wp_counts]','$res[wp_money]','pmcg','$now_time')";
                            $res1 = $sqlHelper->execute_dml($sql);

                            $sqlHelper->close_connect();
                            echo '<div>恭喜你，成功购买了该物品，请到邮箱领取</div>';
                        }else{
                            echo '<div>你的灵石不足，不能购买该物品</div>';
                        }
                    }
                    else{
                        echo '<div>你不能购买自己寄售的物品哦</div>';
                    }
                }
                else{
                    echo '<div>你已购买成功或该拍卖信息不存在</div>';
                }
                $jiami1 = "x=q";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div><a href='pm.php?$url1'>返回拍卖行</a></div>";
            }
        }
        elseif($dh_fl == 'qq'){
            //查看我的拍卖物品
            echo '<div>【我的寄售物品】</div>';

            wj_pm_show_fenye('pm.php',$dh_fl);

            $jiami1 = "x=q";
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<div><a href='pm.php?$url1'>返回拍卖行</a></div>";
        }
        }
}


require_once '../include/time.php';

?>