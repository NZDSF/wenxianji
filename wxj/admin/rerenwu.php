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

//任务列表查询
function renwu_show_fenye($gotourl){
    require_once "include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_renwu($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $rw_biaoti=$row['rw_biaoti'];
        $rw_jindu=$row['rw_jindu'];

        echo $rw_jindu.". ";
        if($rw_biaoti == ""){
            $rw_biaoti = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$rw_biaoti."</span>-<a href='rerenwu.php?x=w&id=$rw_jindu'>管理</a><br/>";


    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}

################
################
################




//发布npc列表查询
function npc_show_fenye($gotourl){
    require_once "include/FenyePage.class_xiyou_1.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_npc($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $npc_name=$row['npc_name'];
//        echo $xuhao.".";
        echo $num.". ";
        if($npc_name == ""){
            $npc_name = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$npc_name."</span>-<a href='rerenwu.php?x=y&id=$_GET[id]&sid=$num'>选定</a><br/>";

//        $xuhao += 1;
    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}

//交付npc列表查询
function npc_jiaofu_show_fenye($gotourl){
    require_once "include/FenyePage.class_xiyou_1.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_npc($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $npc_name=$row['npc_name'];
//        echo $xuhao.".";
        echo $num.". ";
        if($npc_name == ""){
            $npc_name = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$npc_name."</span>-<a href='rerenwu.php?x=p&id=$_GET[id]&sid=$num'>选定</a><br/>";

//        $xuhao += 1;
    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}

//所有物品查询-任务需求
function all_wupin_show_fenye_xuqiu($gotourl){
    require_once "include/FenyePage.class_xiyou_1.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_all_wupin($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $wp_name=$row['wp_name'];
//        echo $xuhao.".";
        echo $num.". ";
        if($wp_name == ""){
            $wp_name = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$wp_name."</span>-<a href='rerenwu.php?x=d&id=$_GET[id]&sid=$num'>新增</a><br/>";

//        $xuhao += 1;
    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}

//怪物列表查询-任务所需物品掉落怪物
function gw_show_fenye_renwu_diaoluo($gotourl){
    require_once "include/FenyePage.class_xiyou_1.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_gw($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $gw_name=$row['gw_name'];
        $gw_dj=$row['gw_dj'];

        echo $num.". ";
        if($gw_name == ""){
            $gw_name = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$gw_name."</span>- ".$gw_dj."级 <a href='rerenwu.php?x=h&id=$_GET[id]&sid=$num'>选定</a><br/>";

//        $xuhao += 1;
    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}

//怪物列表查询-任务所需击杀怪物
function gw_show_fenye_renwu_jisha($gotourl){
    require_once "include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_gw($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $gw_name=$row['gw_name'];
        $gw_dj=$row['gw_dj'];

        echo $num.". ";
        if($gw_name == ""){
            $gw_name = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$gw_name."</span>- ".$gw_dj."级 <a href='rerenwu.php?x=l&id=$_GET[id]&sid=$num'>选定</a><br/>";

//        $xuhao += 1;
    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}

//所有物品查询-任务奖励
function all_wupin_show_fenye_jiangli($gotourl){
    require_once "include/FenyePage.class_xiyou_1.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_all_wupin($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $wp_name=$row['wp_name'];
//        echo $xuhao.".";
        echo $num.". ";
        if($wp_name == ""){
            $wp_name = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$wp_name."</span>-<a href='rerenwu.php?x=c&id=$_GET[id]&sid=$num'>新增</a><br/>";

//        $xuhao += 1;
    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}

//所有药品查询-任务奖励
function all_yappin_show_fenye_jiangli($gotourl){
    require_once "include/FenyePage.class_xiyou_1.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_all_yaopin($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $yp_name=$row['yp_name'];
//        echo $xuhao.".";
        echo $num.". ";
        if($yp_name == ""){
            $yp_name = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$yp_name."</span>-<a href='rerenwu.php?x=n&id=$_GET[id]&sid=$num'>新增</a><br/>";

//        $xuhao += 1;
    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}

//所有药品查询-任务需求
function all_yappin_show_fenye_xuqiu($gotourl){
    require_once "include/FenyePage.class_xiyou_1.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=30;

    if(!empty($_GET["pageNow"])){
        $fenyePage->pageNow=$_GET["pageNow"];
    }

    getFenyePage_all_yaopin($fenyePage);

    if(isset($_GET["pageNow"])){
//        $xuhao = ($_GET["pageNow"] - 1) * 30 +1;
    }else{
//        $xuhao = 1;
    }

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $num=$row['num'];
        $yp_name=$row['yp_name'];
//        echo $xuhao.".";
        echo $num.". ";
        if($yp_name == ""){
            $yp_name = "<span style='color:red'>无内容</span>";
        }
        echo "<span style='color:green;'>".$yp_name."</span>-<a href='rerenwu.php?x=ww&id=$_GET[id]&sid=$num'>新增</a><br/>";

//        $xuhao += 1;
    }


    //显示上一页和下一页
    if($fenyePage->pageCount > 1){
        echo $fenyePage->navigate;
        echo "<br/>";
    }
}








echo "【问仙纪-任务管理】<br/><br/>";

if($_GET["x"] == "q"){
    echo "<a href='rerenwu.php?x=e'>新增任务</a><br/><br/>";

    echo "任务列表:<br/>";
    echo "<span style='color:red;'>任务进度|任务名称|操作</span><br/>";
    renwu_show_fenye("rerenwu.php?x=q");
}
elseif($_GET["x"] == "w"){
    //任务详情
    $sqlHelper = new SqlHelper();
    $sql = "select rw_biaoti,rw_mubiao,rw_skill_gw_num1,rw_jiangli_money,rw_jiangli_exp,rw_jiangli_wp1_id,rw_jiangli_wp1_sl,rw_jiangli_wp2_id,rw_jiangli_wp2_sl,rw_jiangli_wp3_id,rw_jiangli_wp3_sl,rw_jiangli_wp4_id,rw_jiangli_wp4_sl,rw_jiangli_wp5_id,rw_jiangli_wp5_sl from s_renwu where rw_jindu=$_GET[id]";
    $res = $sqlHelper->execute_dql($sql);

    if($res){
        echo "<a href='rerenwu.php?x=r&id=$_GET[id]'>删除该任务</a><br/><br/>";

        echo "<form action='rerenwu.php?x=w&id=$_GET[id]' method='post'>";

        echo "任务进度: <span style='color:green;'>".$_GET["id"]."</span><br/>";
        echo "任务标题: <span style='color:green;'>".$res["rw_biaoti"]."</span> <input type='text' name='rw_biaoti'><br/>";
        echo "任务目标: <span style='color:green;'>".$res["rw_mubiao"]."</span> <input type='text' name='rw_mubiao'><br/>";

        echo "任务所需击杀的怪物: <span style='color:green;'>".$res["rw_skill_gw_num1"]."</span> <input type='text' name='rw_skill_gw_num1'><br/>";
        echo "任务奖励金钱: <span style='color:green;'>".$res["rw_jiangli_money"]."</span> <input type='text' name='rw_jiangli_money'><br/>";
        echo "任务奖励经验: <span style='color:green;'>".$res["rw_jiangli_exp"]."</span> <input type='text' name='rw_jiangli_exp'><br/>";
        echo "任务奖励物品1: <span style='color:green;'>".$res["rw_jiangli_wp1_id"]."</span> <input type='text' name='rw_jiangli_wp1_id'><br/>";
        echo "任务奖励物品1数量: <span style='color:green;'>".$res["rw_jiangli_wp1_sl"]."</span> <input type='text' name='rw_jiangli_wp1_sl'><br/>";
        echo "任务奖励物品2: <span style='color:green;'>".$res["rw_jiangli_wp2_id"]."</span> <input type='text' name='rw_jiangli_wp2_id'><br/>";
        echo "任务奖励物品2数量: <span style='color:green;'>".$res["rw_jiangli_wp2_sl"]."</span> <input type='text' name='rw_jiangli_wp2_sl'><br/>";
        echo "任务奖励物品3: <span style='color:green;'>".$res["rw_jiangli_wp3_id"]."</span> <input type='text' name='rw_jiangli_wp3_id'><br/>";
        echo "任务奖励物品3数量: <span style='color:green;'>".$res["rw_jiangli_wp3_sl"]."</span> <input type='text' name='rw_jiangli_wp3_sl'><br/>";
        echo "任务奖励物品4: <span style='color:green;'>".$res["rw_jiangli_wp4_id"]."</span> <input type='text' name='rw_jiangli_wp4_id'><br/>";
        echo "任务奖励物品4数量: <span style='color:green;'>".$res["rw_jiangli_wp4_sl"]."</span> <input type='text' name='rw_jiangli_wp4_sl'><br/>";
        echo "任务奖励物品5: <span style='color:green;'>".$res["rw_jiangli_wp5_id"]."</span> <input type='text' name='rw_jiangli_wp5_id'><br/>";
        echo "任务奖励物品5数量: <span style='color:green;'>".$res["rw_jiangli_wp5_sl"]."</span> <input type='text' name='rw_jiangli_wp5_sl'><br/>";

        echo "<input type='submit' name='submit' value='修改任务信息' style='margin-left: 50px;margin-top: 8px;'><br/>";

        echo "</form>";

        echo '<div style="color:green;font-weight: bold; margin-top: 10px;">物品序列号查询</div>';
        echo '<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" width="100%px;" height="380px;" src="wp_list.php"></iframe>';
        echo '<div style="color:green;font-weight: bold; margin-top: 10px;">怪物序列号查询</div>';
        echo '<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" width="100%px;" height="380px;" src="gw_list.php"></iframe>';

    }else{
        echo "该任务不存在<br/><br/>";
    }
    $sqlHelper->close_connect();
    echo "<a href='rerenwu.php?x=q'>返回任务列表</a>";

    if(isset($_POST["submit"])){
        $sqlHelper = new SqlHelper();
        $rw_jindu=$_GET["id"];
        $rw_biaoti=$_POST["rw_biaoti"];
        $rw_mubiao=$_POST["rw_mubiao"];
        $rw_skill_gw_num1=$_POST["rw_skill_gw_num1"];
        $rw_jiangli_money=$_POST["rw_jiangli_money"];
        $rw_jiangli_exp=$_POST["rw_jiangli_exp"];
        $rw_jiangli_wp1_id=$_POST["rw_jiangli_wp1_id"];
        $rw_jiangli_wp1_sl=$_POST["rw_jiangli_wp1_sl"];
        $rw_jiangli_wp2_id=$_POST["rw_jiangli_wp2_id"];
        $rw_jiangli_wp2_sl=$_POST["rw_jiangli_wp2_sl"];
        $rw_jiangli_wp3_id=$_POST["rw_jiangli_wp3_id"];
        $rw_jiangli_wp3_sl=$_POST["rw_jiangli_wp3_sl"];
        $rw_jiangli_wp4_id=$_POST["rw_jiangli_wp4_id"];
        $rw_jiangli_wp4_sl=$_POST["rw_jiangli_wp4_sl"];
        $rw_jiangli_wp5_id=$_POST["rw_jiangli_wp5_id"];
        $rw_jiangli_wp5_sl=$_POST["rw_jiangli_wp5_sl"];

        if($rw_biaoti != ""){
            $sql = "update s_renwu set rw_biaoti='$rw_biaoti' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_mubiao != ""){
            $sql = "update s_renwu set rw_mubiao='$rw_mubiao' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_skill_gw_num1 != ""){
            $sql = "update s_renwu set rw_skill_gw_num1='$rw_skill_gw_num1' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_money != ""){
            $sql = "update s_renwu set rw_jiangli_money='$rw_jiangli_money' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_exp != ""){
            $sql = "update s_renwu set rw_jiangli_exp='$rw_jiangli_exp' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp1_id != ""){
            $sql = "update s_renwu set rw_jiangli_wp1_id='$rw_jiangli_wp1_id' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp1_sl != ""){
            $sql = "update s_renwu set rw_jiangli_wp1_sl='$rw_jiangli_wp1_sl' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp2_id != ""){
            $sql = "update s_renwu set rw_jiangli_wp2_id='$rw_jiangli_wp2_id' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp2_sl != ""){
            $sql = "update s_renwu set rw_jiangli_wp2_sl='$rw_jiangli_wp2_sl' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp3_id != ""){
            $sql = "update s_renwu set rw_jiangli_wp3_id='$rw_jiangli_wp3_id' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp3_sl != ""){
            $sql = "update s_renwu set rw_jiangli_wp3_sl='$rw_jiangli_wp3_sl' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp4_id != ""){
            $sql = "update s_renwu set rw_jiangli_wp4_id='$rw_jiangli_wp4_id' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp4_sl != ""){
            $sql = "update s_renwu set rw_jiangli_wp4_sl='$rw_jiangli_wp4_sl' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp5_id != ""){
            $sql = "update s_renwu set rw_jiangli_wp5_id='$rw_jiangli_wp5_id' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }
        if($rw_jiangli_wp5_sl != ""){
            $sql = "update s_renwu set rw_jiangli_wp5_sl='$rw_jiangli_wp5_sl' where rw_jindu=$rw_jindu";
            $res = $sqlHelper->execute_dml($sql);
        }

        $sqlHelper->close_connect();
        header("location: rerenwu.php?x=w&id=$_GET[id]");
        exit;
    }
}
elseif($_GET["x"] == "e"){
    //新增主线任务

    echo "<span style='color:red;'>添加标题和简介后，请返回任务列表修改其他选项</span><br/><br/>";
    echo "<form action='rerenwu.php?x=u' method='post'>";

    echo "任务标题: <span style='color:green;'></span> <input type='text' name='renwu_biaoti'><br/>";
    echo "任务目标: <span style='color:green;'></span> <input type='text' name='renwu_mubiao'><br/>";

    echo "<input type='submit' name='submit' value='添加任务' style='margin-left: 50px;margin-top: 8px;'><br/>";

    echo "</form>";

    echo "<a href='rerenwu.php?x=q'>返回任务列表</a>";
}
elseif($_GET["x"] == "r"){
    //删除该任务
    $sid = $_GET["id"];
    $sqlHelper = new SqlHelper_xiyou1();
    $sql = "delete from s_renwu where rw_jindu=$sid";
    $res = $sqlHelper->execute_dml($sql);
    $sql = "update s_renwu set rw_jindu=rw_jindu-1 where rw_jindu>$sid";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();
    echo '你已成功删除该任务<br/>';
    echo "<a href='rerenwu.php?x=q'>返回任务列表</a>";
}
elseif($_GET["x"] == "t"){
    //任务新增发布npc
    $sqlHelper = new SqlHelper_xiyou1();
    $sql = "select renwu_fb_npc from sx_renwu where renwu_jindu=$_GET[id]";
    $res = $sqlHelper->execute_dql($sql);
    if($res){
        if($res["renwu_fb_npc"] != ""){
            $sql = "select npc_name from sx_npc_all where num=$res[renwu_fb_npc]";
            $res1 = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();
            echo "任务发布npc名称: <span style='color:green;'>".$res1["npc_name"]."</span> <a href='rerenwu.php?x=i&id=$_GET[id]&sid=$res[renwu_fb_npc]'>删除</a><br/>";
        }else{
            echo "任务发布npc名称: <span style='color:red;'>无</span><br/>";
        }

        echo "<br/><span style='color:red;'>☆☆☆分割线☆☆☆</span><br/><br/>";
        ?>
        -----------------<span style='color:red;'>模糊搜索NPC名称功能分割线</span>---------------------------
        <form id='form3' action='' method='post'>

            搜索NPC名称:<input type='text'  name='sousuo_name' /><br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href='javascript:void(0)' onclick='form3.submit();';>搜索</a>
        </form>
        <?php

        if(isset($_POST["sousuo_name"]) && $_POST["sousuo_name"] != ""){
            $sqlHelper = new SqlHelper_xiyou1();
            $sql = "select num,npc_name from sx_npc_all where npc_name like '%$_POST[sousuo_name]%'";
            $res = $sqlHelper->execute_dql2($sql);
            $sqlHelper->close_connect();
            if($res){

                echo "<table style='text-align: center'>";
                echo "<tr><td>NPCID</td><td>NPC名称</td><td>操作</td></tr>";
                for($i=0;$i<count($res);$i++){
                    $num = $res[$i]["num"];
                    $name = $res[$i]["npc_name"];
                    echo "<tr><td>$num</td><td><span style='color:green;'>$name</span></td><td><a href='rerenwu.php?x=y&id=$_GET[id]&sid=$num'>选定</a></td></tr>";
                }
                echo "</table>";
            }else{
                echo "<span style='color:red'>抱歉,没有搜索到该NPC</span><br/>";
            }
        }

        ?>
        -----------------<span style='color:red;'>模糊搜索NPC名称功能分割线</span>---------------------------<br/>
        <?php
        npc_show_fenye("rerenwu.php?x=t&id=$_GET[id]");
        echo "<a href='rerenwu.php?x=w&id=$_GET[id]'>返回任务详情</a><br/>";
    }else{
        echo "该任务不存在<br/>";
    }
   echo "<a href='rerenwu.php?x=q'>返回任务列表</a>";

}
elseif($_GET["x"] == "y"){
    //任务替换发布npc执行页
    $sqlHelper = new SqlHelper_xiyou1();
    $sql = "select num from sx_renwu where num=$_GET[id]";
    $res = $sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();
    if($res){
        $sqlHelper = new SqlHelper_xiyou1();
        $sql = "select num from sx_npc_all where num=$_GET[sid]";
        $res1 = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();
        if($res1){
            $sqlHelper = new SqlHelper_xiyou1();
            $sql = "update sx_renwu set renwu_fb_npc='$_GET[sid]' where renwu_jindu=$_GET[id]";
            $res2 = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
            header("location: rerenwu.php?x=w&id=$_GET[id]");
            exit;
        }else{
            echo "该npc不存在<br/>";
            echo "<a href='rerenwu.php?x=q'>返回任务列表</a>";
        }

    }
    else{
        echo "该任务不存在<br/>";
        echo "<a href='rerenwu.php?x=q'>返回任务列表</a>";
    }

}
elseif($_GET["x"] == "u"){
    //新增任务执行页
    if(isset($_POST["submit"])){
        $renwu_biaoti = $_POST["renwu_biaoti"];
        $renwu_mubiao = $_POST["renwu_mubiao"];

        $sqlHelper = new SqlHelper();
        $sql = "select rw_jindu from s_renwu order by rw_jindu desc limit 1";
        $res = $sqlHelper->execute_dql($sql);
        if($res){
            $renwu_jindu = $res["rw_jindu"] + 1;
        }else{
            $renwu_jindu = 1;
        }
        $sql = "insert into s_renwu(rw_jindu,rw_biaoti,rw_mubiao) values('$renwu_jindu','$renwu_biaoti','$renwu_mubiao')";
        $res = $sqlHelper->execute_dml($sql);
        echo "新增任务成功<br/><br/>";
        $sqlHelper->close_connect();

        echo "<a href='rerenwu.php?x=e'>继续新增任务<br/>";
        echo "<a href='rerenwu.php?x=q'>返回任务首页</a>";
    }
}
?>










<br/><br/>
<a href='index.php'>返回GM首页</a><br/>
