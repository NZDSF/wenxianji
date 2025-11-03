<?php
/**
 * Author: by suxin
 * Date: 2020/1/15
 * Time: 14:36
 * Note: 后台登录页
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>问仙纪后台登录</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="iconfont/style.css" type="text/css" rel="stylesheet">
    <style>
        body{color:#fff; font-family:"微软雅黑"; font-size:14px;}
        .wrap1{position:absolute; top:0; right:0; bottom:0; left:0; margin:auto }/*把整个屏幕真正撑开--而且能自己实现居中*/
        .main_content{background:url(images/main_bg.png) repeat; margin-left:auto; margin-right:auto; text-align:left; float:none; border-radius:8px;}
        .form-group{position:relative;}
        .login_btn{display:block; background:#3872f6; color:#fff; font-size:15px; width:100%; line-height:50px; border-radius:3px; border:none; }
        .login_input{width:100%; border:1px solid #3872f6; border-radius:3px; line-height:40px; padding:2px 5px 2px 30px; background:none;}
        .icon_font{position:absolute; bottom:15px; left:10px; font-size:18px; color:#3872f6;}
        .font16{font-size:16px;}
        .mg-t20{margin-top:20px;}
        @media (min-width:200px){.pd-xs-20{padding:20px;}}
        @media (min-width:768px){.pd-sm-50{padding:50px;}}
    </style>

</head>

<body style="background:url(images/bg.jpg) no-repeat;">



<div class="container wrap1" style="height:450px;">
    <h2 class="mg-b20 text-center">问仙纪后台登录</h2>
    <div class="col-sm-8 col-md-5 center-auto pd-sm-50 pd-xs-20 main_content">

        <?php
        session_start();
        if(isset($_POST['username'])) {

            if (empty($_POST["username"]) || empty($_POST["password"])) {
                $tishi = "<span style='color:red;'>账号或密码不能为空</span>";
            } else {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);

                require_once '../../safe/feifa.php';

                $username_state = feifa_username($username);

                if ($username_state == 1 && !empty($password)) {
                    require_once "../include/SqlHelper.class.php";
                    $sqlHelper = new SqlHelper();
                    $sql = "select num, password from s_admin where username='$username'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();
                    if (!empty($res['password']) && password_verify($password, $res['password'])) {
                        $_SESSION["gm_id"] = $username;
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=index.php'>";
                    } else {
                        $tishi = "<span style='color:red;'>用户名或密码错误</span>";
                    }
                } else if (strlen($username) < 5) {
                    $tishi = "<span style='color:red;'>用户名或密码错误</span>";
                } else {
                    $tishi = "<span style='color:red;'>请勿输入特殊字符</span>";
                }
            }

            if (!empty($tishi)) {
                echo '<div style="margin-top: -20px;text-align: center;margin-bottom: 20px;">' . $tishi . '</div>';
            }
        }
        ?>

        <p class="text-center font16">用户登录</p>
        <form action="login.php" method="post">
            <div class="form-group mg-t20">
                <i class="icon-user icon_font"></i>
                <input type="text" name="username" class="login_input" placeholder="请输入用户名" />
            </div>
            <div class="form-group mg-t20">
                <i class="icon-lock icon_font"></i>
                <input type="password" name="password" class="login_input" placeholder="请输入密码" />
            </div>
            <div class="checkbox mg-b25">
            </div>
            <button style="submit" class="login_btn">登 录</button>
        </form>
        <a href="register.php">注 册</a>
    </div>
</div>
</body>
</html>