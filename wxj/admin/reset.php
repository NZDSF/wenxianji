<title>问仙纪GM管理中心</title>
<head>
    <style>
        table{
            border-collapse: collapse;
        }
        td{
            border:solid black 1px;
        }
<?php

require_once "include/fzr.php";




echo "【问仙纪-清空数据管理】<br/><br/>";

if($_GET["x"] == "q"){
    echo "<span style='color:red;'>你确定要清空所有玩家数据吗？</span><br/><br/>";
    echo "<form action='reset.php?x=w' method='post'>";
    echo "请输入密码: <input type='password' name='password'><br/><br/>";
    echo "<input type='submit' name='submit' value='确定清空' style='margin-left: 80px;'>";
    echo "</form>";
}
elseif($_GET["x"] == "w"){
    if(isset($_POST["submit"])){
        $sqlHelper = new SqlHelper();
        $password = $_POST['password'];
        $sql = "select password from s_admin where username='$_SESSION[gm_id]'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();
        if(!empty($res['password']) && password_verify($password, $res['password'])){
            $qingkong_table = array(
            "s_bangpai_all","s_bangpai_sq","s_gonggao","s_ta_wj_jilu","s_user","s_wj_bag","s_wj_chenghao","s_wj_dongtai","s_wj_friends",
            "s_wj_fuben","s_wj_guaiwu","s_wj_paimai","s_wj_pk_wj","s_wj_qiandao","s_wj_qiuhun","s_wj_siliao","s_wj_skill","s_wj_talk","s_wj_youxiang",
            "s_wj_zhandou_skill","s_wj_zhandou_skill_pk","s_wj_zhuangbei","s_wj_zhuangbei_xilian_tmp"
            );

            $sqlHelper = new SqlHelper();
            $table_count = count($qingkong_table);
            for($i=0;$i<$table_count;$i++){
                $sql = "truncate $qingkong_table[$i]";
                $res = $sqlHelper->execute_dml($sql);
            }
            $sql = "ALTER TABLE s_user AUTO_INCREMENT = 90100";
            $res = $sqlHelper->execute_dml($sql);

            $sqlHelper->close_connect();
            echo "<span style='color:red;'>所有玩家数据已清空</span><br/><br/>";
        }else{
            echo "<span style='color:red;'>密码输入错误，请重新输入</span><br/><br/>";
        }

    }else{
        header("location: reset.php?x=q");
        exit;
    }
    echo "<a href='reset.php?x=q'>返回上页</a>";
}
elseif($_GET["x"] == "e"){
    echo "<form action='reset.php?x=r' method='post'>";
    echo "请输入旧密码: <input type='password' name='password'><br/><br/>";
    echo "请输入新密码: <input type='password' name='npassword'><br/><br/>";
    echo "请确认新密码: <input type='password' name='rpassword'><br/><br/>";
    echo "<input type='submit' name='submit' value='修改密码' style='margin-left: 80px;'>";
    echo "</form>";
}
elseif($_GET["x"] == "r"){
    if(isset($_POST["submit"])){
        $password = $_POST["password"];
        $npassword = $_POST["npassword"];
        $rpassword = $_POST["rpassword"];

        if($password != "" && $npassword != "" && $rpassword !=""){
            if($npassword == $rpassword){
                $sqlHelper = new SqlHelper();
                $password = md5($_POST['npassword']. "byxiuzhen");
                $sql = "update s_admin set password='$password' where username='$_SESSION[gm_id]'";
                $res = $sqlHelper->execute_dml($sql);
                $sqlHelper->close_connect();
                echo "<span style='color:red;'>密码已修改成功</span><br/><br/>";
            }else{
                echo "<span style='color:red;'>两次密码输入不一致</span><br/><br/>";
            }
        }else{
            echo "<span style='color:red;'>请确认信息完整性</span><br/><br/>";
        }

    }else{
        header("location: reset.php?x=e");
        exit;
    }
    echo "<a href='reset.php?x=q'>返回上页</a>";
}
?>









<br/><br/>
<a href='index.php'>返回GM首页</a><br/>
