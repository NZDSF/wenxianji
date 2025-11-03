<?php
/**
 * Author: by suxin
 * Date: 2020/1/17
 * Time: 19:45
 * Note: 怪物列表
 */

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
        echo '<div>序号 名称 等级</div>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $wp_num = $row['num'];
            $gw_name = $row['gw_name'];
            $gw_dj = $row['gw_dj'];

            echo '<div>'.$wp_num.' '.$gw_name.' '.$gw_dj.'</div>';

        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无怪物</div>';
    }
}

//查询物品
gw_show_fenye('gw_list.php','w');

?>