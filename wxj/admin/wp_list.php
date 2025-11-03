<?php
/**
 * Author: by suxin
 * Date: 2020/1/15
 * Time: 19:45
 * Note: 
 */

require_once "include/fzr.php";

//物品列表查询
function wp_show_fenye($gotourl,$dh_fl){
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

    getFenyePage_wp($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        echo '<div>序号 名称</div>';
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $wp_num = $row['num'];
            $wp_name = $row['wp_name'];

            echo '<div>'.$wp_num.' '.$wp_name.'</div>';

        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无物品</div>';
    }
}



//查询物品
wp_show_fenye('wp_list.php','w');

?>