<?php
/**
 * Author: by suxin
 * Date: 2019/12/01
 * Time: 15:07
 * Note: 游戏登录
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

<?php
session_start();
error_reporting(0);

if (isset($_GET['out'])){
    unset($_SESSION['id']);
    unset($_SESSION['pass']);
    setcookie("name1",'');
    setcookie("name2",'');
    header("location: index.php");
    exit;
}

if(isset($_POST['submit'])) {
    if(empty($_POST["username"]) || empty($_POST["password"])){
        echo "<span style='color:red;'>账号或密码不能为空</span>";
    }else{
        $username = $_POST['username'];
        $password = $_POST['password'];

        require_once 'safe/feifa.php';

        $name_state = feifa_state($username);
        $pass_state = feifa_state($password);

        if($name_state == 1 && $pass_state == 1){

        }else{
            echo "<span style='color:red;'>请勿输入非法参数</span>";
        }

        $password = md5($password."byxiuzhen@#");

        require_once "include/SqlHelper.class_comm.php";

        $sqlHelper = new SqlHelper();
        $sql = "select num from s_comm_user where comm_user='$username' and comm_pass='$password'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();

        if ($res) {
            $_SESSION["id"] = $username;
            $_SESSION["pass"] = $password;
            if(isset($_POST["auto"])){
                setcookie("name1","$_SESSION[id]",time()+3600*24*7);
                setcookie("name2","$password",time()+3600*24*7);
            }
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=/wxj/main/main.php'>";
        } else {
            echo "<span style='color:red;'>用户名或密码错误</span>";
        }
    }

    echo '<div style="margin-top: 10px;"></div>';
}

if(!isset($_SESSION["id"]) && !isset($_SESSION["pass"])){
    if(!empty($_COOKIE["name1"]) && !empty($_COOKIE["name2"])){
        $name = $_COOKIE["name1"];
        $pass = $_COOKIE["name2"];
        require_once 'include/SqlHelper.class_comm.php';
        $sqlHelper = new SqlHelper();
        $sql = "select num from s_comm_user where comm_user = '$name' and comm_pass = '$pass'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();
        if ($res) {
            $_SESSION["id"] = $name;
            $_SESSION["pass"] = $pass;
        }
        header("location: wxj/main/main.php");
        exit;
    }
}else{
    header("location: wxj/main/main.php");
    exit;
}

?>

<h3>问仙纪</h3>

<div style="margin-top: 10px;"></div>

<div><img src="/images/问仙纪.jpg"></div>

<div>简介：新款RPG仙侠游戏，经典的家园文字游戏，梦幻仙侣双修，斩妖除魔寻宝，助您成为修真界第一人，受万人敬仰膜拜，这里有满满的情怀，有温暖的回忆。。。</div><br>

<form  action='' method='POST'>
    账号: <input  type="text" name="username" placeholder="请输入你的账号"id='search'><br>
    密码: <input  type="password" name="password" placeholder="请输入你的密码"id='search'><br>
    <input style="margin-left:90px;" type="checkbox" name="auto" value="auto" />7天内自动登录<br/>
    <input style="margin-top: 5px;" class="button_djy" type='submit' name="submit" value='登录游戏'/>
</form>

<div style="margin-top: 10px;"></div>

登录|<a href='regist.php'>注册</a><br>