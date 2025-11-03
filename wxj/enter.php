<?php
/**
 * Author: by suxin
 * Date: 2019/12/1
 * Time: 15:14
 * Note: 游戏开局对话
 */
?>

<meta charset="UTF-8">
<meta name="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">

<link rel="stylesheet" type="text/css" href="css/my.css">
<link rel="shortcut icon" href="../images/ico.png"/>


<?php


session_start();
error_reporting(0);

if(isset($_SESSION["id"]) && isset($_SESSION["pass"])){
    //不做任何操作
}else{
    header("location: ../index.php");
    exit;
}

require_once 'control/gamename.php';
require_once '../safe/jiami.php';

echo '<title>'.$game_name.'</title>';


if(isset($_SESSION['id']) && isset($_SESSION['pass'])) {
    if ($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["id"])) {
            $suxin1 = explode(".", $url_info["id"]);
            $dh_fl = $suxin1[0];

            require_once "include/SqlHelper.class.php";
            $sqlHelper = new SqlHelper();
            $sql = "select enter from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            if ($res && $res["enter"]) {
                header("location: main/main.php");
                exit;
            }

            if ($dh_fl == 1) {
                echo '<div>轰隆巨响,山石滚落...</div>';
                echo '<div>地,震,了?!</div>';
                echo '<div>一座大山形如五指,从天而降.</div>';
                echo '<div>"吱.吱吱吱..."</div>';
                echo '<div>呀,一只小猴子被压在山下,毛茸茸的爪子上下乱抓,惹人怜悯.</div>';

                $jiami1 = "id=2";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div><a href='enter.php?$url1'>拽它出来</a></div>";
            }
            elseif ($dh_fl == 2) {
                echo '<div>小猴子异常灵活,借力跳出.瞬间变大,将近一人高,拍拍胸脯道:</div>';
                echo '<div>"俺乃齐天大圣,多谢相救!为了报答你,可满足你一个心愿"</div>';
                echo '<div>"吓!孙,孙悟空?"</div>';

                $jiami1 = "id=3";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div><a href='enter.php?$url1'>想学习得成仙之术</a></div>";
            }
            elseif ($dh_fl == 3) {
                echo '<div>【猴】口气不小啊.想要修仙,得有仙缘,就让俺老孙先考考你:</div>';
                echo '<div>【问】修仙时要如何提高修为?</div>';

                $jiami1 = "id=4";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                $jiami2 = "id=10";
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                echo "<div><a href='enter.php?$url1'>上山打劫</a></div>";
                echo "<div><a href='enter.php?$url2'>闭关、双修都能聚集灵气,提高修为</a></div>";
            }
            elseif ($dh_fl == 4 || $dh_fl == 10) {
                if($dh_fl == 4){
                    echo '<div>猴儿一听,兴奋得抓耳挠腮:</div>';
                    echo '<div>见地非凡!当年俺也是这么想滴.</div>';
                    echo '<div>不过后来发现每日闭关、双修提高修为更加快捷.</div>';
                    echo '<div>【问】你可知洞天有何用处?</div>';
                }elseif($dh_fl == 10){
                    echo '<div>【猴】颇有仙家根骨嘛!</div>';
                    echo '<div>不过,偶尔打劫打劫副本里的小妖,也会有不小的收获嘞!</div>';
                    echo '<div>【问】你可知洞天有何用处?</div>';
                }

                $jiami1 = "id=11";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                $jiami2 = "id=5";
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                echo "<div><a href='enter.php?$url1'>培育宝物,聚集灵气</a></div>";
                echo "<div><a href='enter.php?$url2'>占地盖房,炒高房价</a></div>";
            }
            elseif ($dh_fl == 5 || $dh_fl == 11) {
                if($dh_fl == 5){
                    echo '<div>【猴】嘿,合老孙脾气!不过洞天福地灵气充裕,拿来炒房有点可惜.</div>';
                }else{
                    echo '<div>【猴】看你仙缘不错呀!</div>';
                }
                echo '<div style="margin-bottom: 10px;">【猴】对了,修仙之徒得有法号,你的法号是什么呢?</div>';

                if (isset($url_info["sex"])) {
                    $suxin1 = explode(".", $url_info["sex"]);
                    $sex = $suxin1[0];

                    if($sex != 1 && $sex != 2){
                        $sex = 1;
                    }
                }else{
                    $sex = 1;
                }

                echo '请选择你的性别: ';

                if($sex == 1){
                    $jiami1 = 'id='.$dh_fl.'&sex=2';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "男 <a href='enter.php?$url1'>女</a>";
                }else{
                    $jiami1 = 'id='.$dh_fl.'&sex=1';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<a href='enter.php?$url1'>男</a> 女";
                }


                $jiami2 = "id=20&sex=".$sex;
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                echo "<form action='enter.php?$url2' method='post'>";
                echo '请输入角色昵称(2-5位的中文):<br/>';
                echo '<input type="text" name="g_name"/><br/>';
                echo '<div style="margin-top: 8px;"></div>';
                echo '<input class="button_djy" type="submit" name="submit" value="确认昵称"/></form>';
            }
            elseif ($dh_fl == 20) {
                if(isset($_POST["g_name"])){
                    require_once '../safe/feifa.php';

                    $g_name = trim($_POST["g_name"]);
                    $g_name_state = feifa_state($g_name);

                    if($g_name_state){
                        $sqlHelper = new SqlHelper();
                        $sql = "select num from s_user where g_name='$g_name'";
                        $res = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();

                        if($res){
                            echo '<div>该昵称太火爆了,请换一个吧~</div>';
                            $jiami1 = "id=11";
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<a href='enter.php?$url1'>返回上页</a>";
                        }else{
                            if (isset($url_info["sex"])) {
                                $suxin1 = explode(".", $url_info["sex"]);
                                $sex = $suxin1[0];
                                if($sex == 2){
                                    $sex = '女';
                                }else{
                                    $sex = '男';
                                }
                            }else{
                                $sex = '男';
                            }

                            $sqlHelper = new SqlHelper();
                            $sql = "insert into s_user(s_name,g_name,enter,sex) values('$_SESSION[id]','$g_name',1,'$sex')";
                            $res = $sqlHelper->execute_dml($sql);
                            $sqlHelper->close_connect();

                            require_once 'include/give_zhuangbei.php';

                            give_zhuangbei(1);
                            give_zhuangbei(2);
                            give_zhuangbei(3);
                            give_zhuangbei(4);
                            give_zhuangbei(5);
                            give_zhuangbei(6);

                            echo '<div>'.$g_name.'? 嗯,不错不错~</div>';
                            echo '<div>随我来吧,先给你找一处洞府安置下来.</div>';
                            echo '<a href="main/main.php">跟上</a>';
                        }
                    }else{
                        echo '<div>请勿输入非法参数</div>';
                        $jiami1 = "id=11";
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        echo "<a href='enter.php?$url1'>返回上页</a>";
                    }
                }else{
                    $jiami1 = "id=1";
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    header("location: enter.php?$url1");
                    exit;
                }
            }else{
                $jiami1 = "id=1";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                header("location: enter.php?$url1");
                exit;
            }
        }
    }
    else{
        header("location: main/main.php");
        exit;
    }
}else {
    header("location: http://".$_SERVER['HTTP_HOST']."/index.php");
    exit;
}

?>