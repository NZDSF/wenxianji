<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <style>
        a:visited{
            color:#1e5494;
        }
        a{
            color:#1e5494;
            text-decoration: none;
        }
        div{
            line-height: 30px;
        }
        .search{
            width:235px;
            height:32px;
            border-radius:10px;
            -moz-border-radius:10px;
            -webkit-border-radius:10px;
            margin-top:5px;
            margin-bottom:5px;
            border:1px solid#ccc;
            background-color:transparent;
            transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }
    </style>

</head>

<?php
/**
 * Author: by suxin
 * Date: 2020/1/15
 * Time: 14:19
 * Note: 
 */


error_reporting(0);
session_start();

if(isset($_SESSION['gm_id'])){
    require_once '../include/SqlHelper.class.php';
    require_once '../../safe/jiami.php';
} else{
    echo "<script>location.href='http://".$_SERVER['HTTP_HOST']."/wxj/admin/login.php'</script>";
    exit();
}
?>