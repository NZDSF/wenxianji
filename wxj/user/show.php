<?php
/**
 * Author: by suxin
 * Date: 2019/12/10
 * Time: 11:17
 * Note: 装备属性显示
 */


require_once '../include/fzr.php';
require_once '../include/SqlHelper.class.php';
require_once '../include/func.php';
require_once '../control/control.php';




if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);

    if (isset($url_info["id"]) && isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["id"]);
        $zb_num = $suxin1[0];
        $suxin2 = explode(".", $url_info["x"]);
        $dh_fl = $suxin2[0];

        if($dh_fl == 'q'){
            zb_info($zb_num);
        }elseif($dh_fl == 'w'){
            wp_info($zb_num);
        }


        if (isset($url_info["f"])) {
            $suxin1 = explode(".", $url_info["f"]);
            $bag_fl = $suxin1[0];

            $daohang_array = bag_daohang();

            $count_daohang = count($daohang_array);
            for($i=0;$i<$count_daohang;$i++){
                if($daohang_array[$i][2] == $bag_fl){
                    global $date,$key_url_md_5;
                    $jiami1 = "x=".$daohang_array[$i][0];
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo "<a href='bag.php?$url1'>返回".$daohang_array[$i][1]."</a>";
                    break;
                }
            }
        }

    }
}

require_once "../include/time.php";
?>