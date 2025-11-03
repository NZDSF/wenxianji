<?php
/**
 * Author: by suxin
 * Date: 2020/1/15
 * Time: 15:00
 * Note: 后台首页文件
 */

require_once "include/fzr.php";


if (isset($_GET['out'])){
    unset($_SESSION['gm_id']);
    unset($_SESSION['gm_pass']);
    header("location: login.php");
    exit;
}
?>

<head>
    <title>问仙纪_GM后台</title>
    <style>
        .list1{
            padding-top: 10px;;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../css/my.css">
    <link rel="shortcut icon" href="../images/ico.png"/>
</head>


【GM开发后台】<br/><br/>

<div class="list1">1.<a href="fswp.php?x=q">【充值发放】</a><br/></div>
<div class="list1">2.<a href="regw.php?x=q">【怪物管理】</a><br/></div>
<div class="list1">3.<a href="refuben.php?x=q">【副本管理】</a><br/></div>
<div class="list1">4.<a href="redyt.php?x=q">【大雁塔管理】</a><br/></div>
<div class="list1">5.<a href="rewupin.php?x=q">【物品管理】</a><br/></div>
<div class="list1">6.<a href="rerenwu.php?x=q">【任务管理】</a><br/></div>
<div class="list1">7.<a href="reset.php?x=q" style="color:red;">【清空数据】</a><br/></div>

<br/><br/><a href='index.php?out=out'>退出登录</a>



