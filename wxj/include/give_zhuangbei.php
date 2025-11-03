<?php
/**
 * Author: by suxin
 * Date: 2019/12/9
 * Time: 11:28
 * Note: 发送装备
 */


//require_once "../include/fzr.php";
//require_once "../include/SqlHelper.class.php";


function give_zhuangbei($zb_id,$wj_sname=''){
    if($wj_sname == ''){
        $wj_sname = $_SESSION["id"];
    }

    $sqlHelper=new SqlHelper();
    $strsql = "select zb_name,zb_dj,zb_col from s_zhuangbei_all where num = $zb_id";
    $res = $sqlHelper->execute_dql($strsql);

    $zb_name = $res["zb_name"];
    $zb_dj = $res["zb_dj"];
    $zb_col = $res["zb_col"];

    $sql = "insert into s_wj_zhuangbei(s_name,zb_name,zb_dj,zb_col) values('$wj_sname','$zb_name','$zb_dj','$zb_col')";
    $res = $sqlHelper->execute_dml($sql);

    $sqlHelper->close_connect();
}
?>