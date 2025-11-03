<?php
/**
 * Author: by suxin
 * Date: 2020/1/15
 * Time: 15:06
 * Note: 发送物品
 */
?>

<title>问仙纪GM管理中心</title>
<head>
    <style>
        table{
            border-collapse: collapse;
        }
        td{
            border:solid black 1px;
        }
    </style>
    <script type="text/javascript" src="http://wap.wmtgame.com/js/jquery.min.js"></script>
</head>
<?php

if (isset($_GET['out'])){
    unset($_SESSION['id']);
    unset($_SESSION['pass']);
    header("location: ../index.php");
    exit;
}

require_once "include/fzr.php";


echo "<div>【发送物品】</div>";


if($_SERVER["QUERY_STRING"]) {

    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];
    }else{
        $dh_fl = $_GET["x"];
    }
}


if($dh_fl == 'q'){
    echo"<form action='fswp.php?x=w' method='post'>";

    echo '<div>请选择要操作的玩家:</div>';
    echo "<div>玩家登录账号: <input style='width:200px;' class='search' type='text' id='div1' name='username' placeholder='请输入玩家登录账号' /><input style='margin-left:10px;' type='submit' value='确定'></div>";

    echo "</form>";

    echo '<br/>';

    echo '<div>请输入玩家的游戏昵称进行搜索(支持模糊搜索)</div>';
    echo "<form action='' method='post'>";

    echo "<div>玩家游戏昵称: <input style='width:200px;' class='search' type='text' placeholder='请输入玩家游戏昵称' name='sousuo_name' /><input style='margin-left:10px;' type='submit' value='搜索'></div>";
    echo "</form>";

    if(isset($_POST["sousuo_name"]) && $_POST["sousuo_name"] != ""){
        $sqlHelper = new SqlHelper();
        $sql = "select s_name,g_name,money,coin,cz_jf from s_user where g_name like '%$_POST[sousuo_name]%'";
        $res = $sqlHelper->execute_dql2($sql);
        $sqlHelper->close_connect();
        if($res){
            echo "<table id='mytable_sousuo' style='width:350px';>";
            echo "<tr style='background-color:cadetblue'><td >序号</td><td>登录账号</td><td>游戏昵称</td><td style='width:70px;'>灵石</td><td style='width:40px;'>仙券</td><td>充值积分</td><td>操作</td></tr>";
            $xuhao = 1;
            for($i=0;$i<count($res);$i++){
                $btn_js = "btn_sousuo$xuhao";
                $txt_js = "txt_sousuo$xuhao";
                $wj_sname = $res[$i]["s_name"];
                echo "<tr>"."<td>".$xuhao."</td>"."<td>"."<input style='color:blue;font-size:15px;width:80px' disabled='disabled' id='$txt_js' type='text' value='$wj_sname'/>"."</td>"."<td>".$res[$i]["g_name"]."</td>"."<td>".$res[$i]["money"]."</td>"."<td>".$res[$i]["coin"]."</td>"."<td>".$res[$i]["cz_jf"]."</td>"."<td><input id='$btn_js' type='button' value='选中' /></td></tr>";
                $xuhao ++;
            }
            echo "</table>";
        }else{
            echo "<span style='color:red'>抱歉,没有搜索到该玩家</span>";
        }
        echo '<div style="margin-bottom: 10px;"></div>';
    }
}
elseif($dh_fl == 'w'){
    if(isset($_POST["username"])){
        $username = $_POST["username"];

        $sqlHelper = new SqlHelper();
        $sql = "select g_name from s_user where s_name='$username'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();

        echo '<div>玩家登录账号: '.$username.'</div>';
        echo '<div>玩家游戏昵称: '.$res["g_name"].'</div>';

        echo "<form action='fswp.php?x=e' method='post'>";
        echo '<div>充值的灵石数: <input class="search" type="text" placeholder="请输入纯数字" name="lingshi"></div>';
        echo '<div>充值的仙券数: <input class="search" type="text" placeholder="请输入纯数字" name="xianquan"></div>';
        echo '<div>发送邮箱标题: <input class="search" type="text" placeholder="请输入邮箱标题" name="biaoti"></div>';
        echo '<br/>';
        echo '<div>请输入要发送的物品id号和数量</div>';
        echo '<div>发送的物品1: <input class="search" style="width:50px;" type="text" name="wp_num1" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl1" placeholder="物品数量"></div>';
        echo '<div>发送的物品2: <input class="search" style="width:50px;" type="text" name="wp_num2" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl2" placeholder="物品数量"></div>';
        echo '<div>发送的物品3: <input class="search" style="width:50px;" type="text" name="wp_num3" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl3" placeholder="物品数量"></div>';
        echo '<div>发送的物品4: <input class="search" style="width:50px;" type="text" name="wp_num4" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl4" placeholder="物品数量"></div>';
        echo '<div>发送的物品5: <input class="search" style="width:50px;" type="text" name="wp_num5" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl5" placeholder="物品数量"></div>';
        echo '<div>发送的物品6: <input class="search" style="width:50px;" type="text" name="wp_num6" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl6" placeholder="物品数量"></div>';
        echo '<div>发送的物品7: <input class="search" style="width:50px;" type="text" name="wp_num7" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl7" placeholder="物品数量"></div>';
        echo '<div>发送的物品8: <input class="search" style="width:50px;" type="text" name="wp_num8" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl8" placeholder="物品数量"></div>';
        echo '<div>发送的物品9: <input class="search" style="width:50px;" type="text" name="wp_num9" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl9" placeholder="物品数量"></div>';
        echo '<div>发送的物品10: <input class="search" style="width:50px;" type="text" name="wp_num10" placeholder="物品id"><input class="search" style="margin-left:10px;width:60px;" type="text" name="wp_sl10" placeholder="物品数量"></div>';

        echo "<input type='hidden' name='username' value='$username'>";
        echo '<input style="margin-top: 10px;height:30px;border-radius: 25px;" type="submit" value="确认发送">';
        echo "</form>";

        echo '<div style="color:green;font-weight: bold;">物品序列号查询</div>';
        echo '<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" width="100%px;" height="380px;" src="wp_list.php"></iframe>';
    }
}elseif($dh_fl == 'e'){
    if(isset($_POST["username"])){
        $username = $_POST["username"];

        $sqlHelper = new SqlHelper();
        $sql = "select g_name from s_user where s_name='$username'";
        $res = $sqlHelper->execute_dql($sql);

        echo '<div>玩家登录账号: '.$username.'</div>';
        echo '<div>玩家游戏昵称: '.$res["g_name"].'</div>';
        echo '<div>发送邮箱标题: '.$_POST["biaoti"].'</div>';

        echo '<div style="margin-top: 10px;margin-bottom: 10px;">你确定要发送以下物品吗？</div>';

        echo "<form action='fswp.php?x=r' method='post'>";

        if($_POST["lingshi"] && $_POST["lingshi"] != ''){
            echo '<div>灵石x'.$_POST["lingshi"].'</div>';
            echo "<input type='hidden' name='lingshi' value='$_POST[lingshi]'>";
        }
        if($_POST["xianquan"] && $_POST["xianquan"] != ''){
            echo '<div>仙券x'.$_POST["xianquan"].'</div>';
            echo "<input type='hidden' name='xianquan' value='$_POST[xianquan]'>";
        }

        if($_POST["wp_num1"] && $_POST["wp_num1"] != '' && $_POST["wp_sl1"] && $_POST["wp_sl1"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num1]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl1"].'</div>';
            echo "<input type='hidden' name='wp_num1' value='$_POST[wp_num1]'>";
            echo "<input type='hidden' name='wp_sl1' value='$_POST[wp_sl1]'>";
        }
        if($_POST["wp_num2"] && $_POST["wp_num2"] != '' && $_POST["wp_sl2"] && $_POST["wp_sl2"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num2]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl2"].'</div>';
            echo "<input type='hidden' name='wp_num2' value='$_POST[wp_num2]'>";
            echo "<input type='hidden' name='wp_sl2' value='$_POST[wp_sl2]'>";
        }
        if($_POST["wp_num3"] && $_POST["wp_num3"] != '' && $_POST["wp_sl3"] && $_POST["wp_sl3"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num3]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl3"].'</div>';
            echo "<input type='hidden' name='wp_num3' value='$_POST[wp_num3]'>";
            echo "<input type='hidden' name='wp_sl3' value='$_POST[wp_sl3]'>";
        }
        if($_POST["wp_num4"] && $_POST["wp_num4"] != '' && $_POST["wp_sl4"] && $_POST["wp_sl4"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num4]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl4"].'</div>';
            echo "<input type='hidden' name='wp_num4' value='$_POST[wp_num4]'>";
            echo "<input type='hidden' name='wp_sl4' value='$_POST[wp_sl4]'>";
        }
        if($_POST["wp_num5"] && $_POST["wp_num5"] != '' && $_POST["wp_sl5"] && $_POST["wp_sl5"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num5]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl5"].'</div>';
            echo "<input type='hidden' name='wp_num5' value='$_POST[wp_num5]'>";
            echo "<input type='hidden' name='wp_sl5' value='$_POST[wp_sl5]'>";
        }
        if($_POST["wp_num6"] && $_POST["wp_num6"] != '' && $_POST["wp_sl6"] && $_POST["wp_sl6"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num6]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl6"].'</div>';
            echo "<input type='hidden' name='wp_num6' value='$_POST[wp_num6]'>";
            echo "<input type='hidden' name='wp_sl6' value='$_POST[wp_sl6]'>";
        }
        if($_POST["wp_num7"] && $_POST["wp_num7"] != '' && $_POST["wp_sl7"] && $_POST["wp_sl7"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num7]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl7"].'</div>';
            echo "<input type='hidden' name='wp_num7' value='$_POST[wp_num7]'>";
            echo "<input type='hidden' name='wp_sl7' value='$_POST[wp_sl7]'>";
        }
        if($_POST["wp_num8"] && $_POST["wp_num8"] != '' && $_POST["wp_sl8"] && $_POST["wp_sl8"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num8]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl8"].'</div>';
            echo "<input type='hidden' name='wp_num8' value='$_POST[wp_num8]'>";
            echo "<input type='hidden' name='wp_sl8' value='$_POST[wp_sl8]'>";
        }
        if($_POST["wp_num9"] && $_POST["wp_num9"] != '' && $_POST["wp_sl9"] && $_POST["wp_sl9"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num9]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl9"].'</div>';
            echo "<input type='hidden' name='wp_num9' value='$_POST[wp_num9]'>";
            echo "<input type='hidden' name='wp_sl9' value='$_POST[wp_sl9]'>";
        }
        if($_POST["wp_num10"] && $_POST["wp_num10"] != '' && $_POST["wp_sl10"] && $_POST["wp_sl10"] != ''){
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num10]";
            $res = $sqlHelper->execute_dql($sql);
            echo '<div>'.$res["wp_name"].'x'.$_POST["wp_sl10"].'</div>';
            echo "<input type='hidden' name='wp_num10' value='$_POST[wp_num10]'>";
            echo "<input type='hidden' name='wp_sl10' value='$_POST[wp_sl10]'>";
        }

        echo "<input type='hidden' name='username' value='$username'>";
        echo "<input type='hidden' name='biaoti' value='$_POST[biaoti]'>";
        echo '<input style="margin-top: 10px;height:30px;border-radius: 25px;margin-bottom: 10px;" type="submit" value="确认发送">';
        echo "</form>";

        $sqlHelper->close_connect();
    }
}elseif($dh_fl == 'r'){
    if(isset($_POST["username"])){
        $username = $_POST["username"];
        $biaoti = $_POST["biaoti"];

        $sqlHelper = new SqlHelper();
        $sql = "select g_name from s_user where s_name='$username'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();

        echo '<div>玩家登录账号: '.$username.'</div>';
        echo '<div>玩家游戏昵称: '.$res["g_name"].'</div>';

        echo '<div style="margin-top: 10px;margin-bottom: 10px;color:green;">成功发送了以下物品:</div>';

        require_once '../include/func.php';

        $message = '';

        if(isset($_POST["lingshi"]) && $_POST["lingshi"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "update s_user set money=money+$_POST[lingshi] where s_name='$username'";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();

            $note = '<div>灵石x'.$_POST["lingshi"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["xianquan"]) && $_POST["xianquan"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "update s_user set coin=coin+$_POST[xianquan] where s_name='$username'";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();

            $note = '<div>仙券x'.$_POST["xianquan"].'</div>';
            $message .= $note;
            echo $note;
        }

        if(isset($_POST["wp_num1"]) && $_POST["wp_num1"] != '' && isset($_POST["wp_sl1"]) && $_POST["wp_sl1"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num1]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num1"],$_POST["wp_sl1"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl1"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num2"]) && $_POST["wp_num2"] != '' && isset($_POST["wp_sl2"]) && $_POST["wp_sl2"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num2]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num2"],$_POST["wp_sl2"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl2"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num3"]) && $_POST["wp_num3"] != '' && isset($_POST["wp_sl3"]) && $_POST["wp_sl3"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num3]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num3"],$_POST["wp_sl3"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl3"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num4"]) && $_POST["wp_num4"] != '' && isset($_POST["wp_sl4"]) && $_POST["wp_sl4"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num4]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num4"],$_POST["wp_sl4"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl4"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num5"]) && $_POST["wp_num5"] != '' && isset($_POST["wp_sl5"]) && $_POST["wp_sl5"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num5]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num5"],$_POST["wp_sl5"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl5"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num6"]) && $_POST["wp_num6"] != '' && isset($_POST["wp_sl6"]) && $_POST["wp_sl6"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num6]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num6"],$_POST["wp_sl6"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl6"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num7"]) && $_POST["wp_num7"] != '' && isset($_POST["wp_sl7"]) && $_POST["wp_sl7"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num7]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num7"],$_POST["wp_sl7"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl7"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num8"]) && $_POST["wp_num8"] != '' && isset($_POST["wp_sl8"]) && $_POST["wp_sl8"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num8]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num8"],$_POST["wp_sl8"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl8"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num9"]) && $_POST["wp_num9"] != '' && isset($_POST["wp_sl9"]) && $_POST["wp_sl9"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num9]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num9"],$_POST["wp_sl9"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl9"].'</div>';
            $message .= $note;
            echo $note;
        }
        if(isset($_POST["wp_num10"]) && $_POST["wp_num10"] != '' && isset($_POST["wp_sl10"]) && $_POST["wp_sl10"] != ''){
            $sqlHelper = new SqlHelper();
            $sql = "select wp_name from s_wupin_all where num=$_POST[wp_num10]";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            give_wupin($_POST["wp_num10"],$_POST["wp_sl10"],$username);

            $note = '<div>'.$res["wp_name"].'x'.$_POST["wp_sl10"].'</div>';
            $message .= $note;
            echo $note;
        }

        $now_time = date("Y-m-d H:i:s");
        $sqlHelper = new SqlHelper();
        $sql = "insert into s_wj_youxiang(s_name,yx_biaoti,yx_message,yx_leixin,times) values('$username','$biaoti','$message','htfswp','$now_time')";
        $res = $sqlHelper->execute_dml($sql);
        $sqlHelper->close_connect();

        echo '<div style="margin-bottom: 10px;"><a href="fswp.php?x=q">继续发送</a></div>';

    }
}

?>


<div><a href='index.php'>返回GM首页</a></div>
<div><a href='index.php?out=out'>退出登录</a></div>

<script>
    $("#mytable input").click(function(){
//        console.log($(this).attr("id"))
        btnid=$(this).attr("id")
        num=btnid.replace(/[^0-9]/ig,"");
//        console.log(num);

        //获取对应input的值
        txtval=$("#txt"+num).val();
        //赋值给
        $("#div1").val(txtval);

    });
    //################################################
    $("#mytable_sousuo input").click(function(){
//        console.log($(this).attr("id"))
        btnid=$(this).attr("id")
        num=btnid.replace(/[^0-9]/ig,"");
//        console.log(num);

        //获取对应input的值
        txtval=$("#txt_sousuo"+num).val();
        //赋值给
        $("#div1").val(txtval);

    });
</script>