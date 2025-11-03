<?php
/**
 * Author: by suxin
 * Date: 2019/12/01
 * Time: 15:24
 * Note: 游戏检查session值
 */
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" type="text/css" href="../css/my.css">
    <link rel="shortcut icon" href="../images/ico.png"/>

</head>

<?php

require_once '../control/gamename.php';
require_once '../../safe/jiami.php';

echo '<title>'.$game_name.'</title>';

error_reporting(0);
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['pass'])) {
    require_once "SqlHelper.class.php";

    $sqlHelper=new SqlHelper();
    $sql="select g_name from s_user where s_name='$_SESSION[id]'";
    $res=$sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();

    if($res && $res["g_name"]){
        //修改玩家当前活动时间
        $now = time();

        $sqlHelper = new SqlHelper();
        $sql = "update s_user set last_activity_time='$now' where s_name='$_SESSION[id]'";
        $res1 = $sqlHelper->execute_dml($sql);
        //$sql = "update s_misc set last_activity_time='$now' where s_name='$_SESSION[id]'";
        //$res1 = $sqlHelper->execute_dml($sql);
        $sqlHelper->close_connect();

    }else{
        $jiami1 = "id=1";
        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
        header("location: http://".$_SERVER['HTTP_HOST']."/wxj/enter.php?$url1");
        exit;
    }
    #######################################################


}
else {
    header("location: http://".$_SERVER['HTTP_HOST']."/index.php");
    exit;
}

?>
