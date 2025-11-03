<?php
/**
 * Author: by suxin
 * Date: 2019/12/10
 * Time: 10:54
 * Note: 玩家背包信息
 */


require_once '../include/fzr.php';
require_once '../include/SqlHelper.class.php';
require_once '../include/func.php';

//背包物品分类导航
function bag_fenlei_daohang($fenlei_x){
    $daohang_array = bag_daohang();

    $count_daohang = count($daohang_array);
    global $date,$key_url_md_5;

    for($i=0;$i<$count_daohang;$i++){

        $jiami1 = "x=".$daohang_array[$i][0];
        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

        if($fenlei_x == $daohang_array[$i][0]){
            echo $daohang_array[$i][1];
            $bag_url_fl = $daohang_array[$i][0];
            $bag_fenlei = $daohang_array[$i][2];
        }else{
            echo "<a href='bag.php?$url1'>".$daohang_array[$i][1].'</a>';
        }

        if((($i+1) % 3) == 0){
            echo '<br/>';
        }else{
            if(($i+1) < $count_daohang){
                echo '|';
            }
        }
    }

    if($fenlei_x == 'e'){
        $jiami1 = 'x=q';
        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

        echo "<div><a href='bshc.php?$url1'>合成</a></div>";
    }

    bag_show_fenye('bag.php',"$bag_url_fl","$bag_fenlei");
}

if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $fenlei = $suxin1[0];

        $sqlHelper = new SqlHelper();
        $sql = "select money,coin from s_user where s_name='$_SESSION[id]'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();

        echo "<span style='margin-left: -6px;'>【玩家背包】</span>";
        echo "<div>拥有灵石: ".$res["money"]."</div>";
        echo "<div>拥有仙券: ".$res["coin"]."</div>";

        if($fenlei == 'q' || $fenlei == 'w' || $fenlei == 'e' || $fenlei == 'r' || $fenlei == 't' || $fenlei == 'y'){
            bag_fenlei_daohang($fenlei);
        }
    }
}


require_once "../include/time.php";
?>