<?php
/**
 * Author: by suxin
 * Date: 2019/12/20
 * Time: 10:00
 * Note: 商城页面
 */

require_once '../include/fzr.php';
require_once '../include/SqlHelper.class.php';
require_once '../include/func.php';

//商城物品列表查询
function shop_show_fenye($gotourl,$bag_url_fl,$bag_fenlei){
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

    getFenyePage_shop($fenyePage,$bag_url_fl,$bag_fenlei);

    if($fenyePage->res_array){
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $wp_name = $row['wp_name'];
            $wp_coin = $row['wp_coin'];

            $jiami1 = 'y=q&id='.$num.'&f='.$bag_url_fl;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            echo '<div>'.$xuhao.".<a href='shop.php?$url1'>".$wp_name.'</a>('.$wp_coin.'仙券)</div>';

            $xuhao += 1;
        }

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无物品</div>';
    }
}

//商城物品分类导航
function shop_fenlei_daohang($fenlei_x)
{
    $daohang_array = shop_daohang();

    $count_daohang = count($daohang_array);
    for ($i = 0; $i < $count_daohang; $i++) {
        global $date, $key_url_md_5;
        $jiami1 = "x=" . $daohang_array[$i][0];
        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

        if ($fenlei_x == $daohang_array[$i][0]) {
            echo $daohang_array[$i][1];
            $bag_url_fl = $daohang_array[$i][0];
            $bag_fenlei = $daohang_array[$i][2];
        } else {
            echo "<a href='shop.php?$url1'>" . $daohang_array[$i][1] . '</a>';
        }

        if ((($i + 1) % 4) == 0) {
            echo '<br/>';
        } else {
            if (($i + 1) < $count_daohang) {
                echo '|';
            }
        }
    }

    shop_show_fenye('shop.php', "$bag_url_fl", "$bag_fenlei");
}

if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $fenlei = $suxin1[0];
        echo '<div>【商城】</div>';
        $sqlHelper = new SqlHelper();
        $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');
        echo '<div>我的仙券:'.$wj_coin.'</div>';
        $sqlHelper->close_connect();
        shop_fenlei_daohang($fenlei);
    }
    if (isset($url_info["y"]) && isset($url_info["id"]) && isset($url_info["f"])) {
        $suxin1 = explode(".", $url_info["y"]);
        $dh_fl = $suxin1[0];
        $suxin1 = explode(".", $url_info["id"]);
        $wp_num = $suxin1[0];
        $suxin1 = explode(".", $url_info["f"]);
        $shop_fl = $suxin1[0];

        if ($dh_fl == 'q') {
            //物品信息
            wp_info($wp_num,4);

            global $date,$key_url_md_5;
            $jiami1 = "x=".$shop_fl;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<div><a href='shop.php?$url1'>返回上页</a></div>";

        } elseif ($dh_fl == 'w') {
            //购买页面
            echo '<div>【物品购买】</div>';

            require_once '../../safe/feifa.php';
            $gm_sl = trim($_POST["sl"]);
            $gm_sl_state = feifa_shuzi($gm_sl);
            if ($gm_sl_state == 1) {
                $sqlHelper = new SqlHelper();
                $sql = "select wp_coin,wp_name from s_wupin_all where num=$wp_num and wp_shop=1 and wp_coin !=''";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if ($res) {
                    $wp_z_coin = $res["wp_coin"] * $gm_sl;
                    $sqlHelper = new SqlHelper();
                    $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');
                    $sqlHelper->close_connect();
                    if ($wj_coin >= $wp_z_coin) {
                        $sqlHelper = new SqlHelper();
                        $sqlHelper->jianshao_wj_user_neirong('coin', $wp_z_coin);
                        $sqlHelper->close_connect();

                        give_wupin($wp_num, $gm_sl);
                        echo '<div><span style="color:red;">消耗了仙券x' . $wp_z_coin . '</span><br/><span style="color:green;">您购买了' . $res["wp_name"] . 'x' . $gm_sl . '</span></div>';
                    } else {
                        echo '<div>仙券数量不足，无法购买</div>';
                    }
                } else {
                    echo '<div>该物品不存在</div>';
                }
            } else {
                echo '<div>请勿输入非法参数</div>';
            }

            global $date, $key_url_md_5;
            $jiami1 = 'x=' . $shop_fl;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<a href='shop.php?$url1'>返回上页</a>";
        }
    }
}

require_once '../include/time.php';
?>