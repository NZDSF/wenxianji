<?php
/**
 * Author: by suxin
 * Date: 2019/12/01
 * Time: 15:11
 * Note: 游戏账号注册成功提示页面
 */
?>
<!DOCTYPE html>
<head lang="en">
    <title>问仙纪</title>
    <meta name="description" content="问仙纪" />
    <meta name="keywords" content="问仙纪" />

    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <link rel="shortcut icon" href="images/ico.png"/>
    <link rel="stylesheet" type="text/css" href="css/my.css"/>

</head>
<body>


<?php


error_reporting(0);


echo '【游戏注册】';
echo '<div style="margin-top: 10px;"></div>';
if(isset($_GET["rg"]) && $_GET["rg"] == "false"){
    echo "<span style='color:red;'>注册失败,请重新输入</span>";
}else{
    echo "<span style='color:red;'>恭喜你注册成功</span>";
}


?>
<div style="margin-top: 10px;"></div>
<a href="index.php">账号登录</a>|账号注册



