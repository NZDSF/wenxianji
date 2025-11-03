<?php
/**
 * Author: by suxin
 * Date: 2019/12/01
 * Time: 15:07
 * Note: 账号注册
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

function ip() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $cl_ip =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    return $cl_ip;
    //dump(phpinfo());//所有PHP配置信息
}


if(isset($_POST['submit'])) {
    $username = $_POST['name'];
    $password = $_POST['pwd'];
    $repassword = $_POST['repwd'];
    
    $sex = $_POST['sex'];

    if($username == "" || $password == "" || $repassword == "" ||$sex == "")
    {
        $tishi = "<span style='color:red;'>请确认信息的完整性</span><br/>";
    }else {
        require_once 'safe/feifa.php';

        $name_state = feifa_state($username);
        $pass_state = feifa_state($password);
        $rpas_state = feifa_state($repassword);
        

        if($name_state == 1 && $pass_state == 1 && $rpas_state == 1){
            if($password == $repassword){
                require_once "include/SqlHelper.class_comm.php";

                $sqlHelper=new SqlHelper();
                $sql = "select num from s_comm_user where comm_user='$username'";
                $res = $sqlHelper->execute_dql($sql);

                if($res){
                    $sqlHelper->close_connect();
                    $tishi = "<span style='color:red;'>对不起！这个昵称太火了换一个吧</span><br/>";
                }else{
                    $password = md5($password."byxiuzhen@#");
                    $anquanma = md5($anquanma."byxiuzhen@#");

                    $ip = ip();
                    $sql = "insert into s_comm_user(comm_user,comm_pass,comm_sex,comm_rgtime,comm_aqm,comm_rg_ip) values('$username','$password','$sex',now(),'$anquanma','$ip')";
                    $res = $sqlHelper->execute_dml($sql);

                    $sqlHelper->close_connect();

                    if($res){
                        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=regist_result.php">';
                    }else{
                        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=regist_result.php?rg=false">';
                    }
                }
            }else{
                $tishi = "<span style='color:red;'>两次密码输入不一致</span><br/>";
            }
        }else{
            $tishi = "<span style='color:red;'>请勿输入非法参数</span><br/>";
        }





    }
    echo $tishi;
}


?>


【账号注册】

<div style="margin-top: 10px;"></div>

<form method='post' action=''>
    登录账号: <input id='search' type='text' name='name' maxlength='15' placeholder="请输入你的账号"/><br/>
    账号密码: <input id='search' type='password' name='pwd' placeholder="请输入你的密码"/><br/>
    确认密码: <input id='search' type='password' name='repwd' placeholder="请确认你的密码"/><br/>

<?php

    if(isset($_GET["s"]) && $_GET["s"] == 2){
        echo "性别选择: &nbsp;&nbsp;";
        echo "<a href='regist.php?s=1' id='search'>";

        echo "<span style='font-size:18px;'>男</span></a> |<span style='font-size:18px;'>女</span><br/>
        <input type='hidden' name='sex' value='女' />";
    }
    else{
        echo "性别选择: &nbsp;&nbsp;<span style='font-size:18px;'>男</span>|";
        echo"<a href='regist.php?s=2' id='search'>";

        echo "<span style='font-size:18px;'>女</span></a><br/>
        <input type='hidden' name='sex' value='男' />";
    }
    ?>

    <input class="button_djy" type='submit' name="submit" value='注册账号'/>
</form>
<div style="margin-top: 10px;"></div>

<span style='color:red;'>请牢记注册的登录账号和密码，暂不支持找回</span><br/>

<a href="index.php">账号登录</a>|账号注册

</body>
</html>