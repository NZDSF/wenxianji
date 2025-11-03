<?php
/**
 * Author: by suxin
 * Date: 2019/12/3
 * Time: 14:32
 * Note: 函数集合
 */

//耐力恢复时间检测
function nl_show_time($vip_zf_nl){
    $date = 0;
    $huifu_naili = 0;

    $sqlHelper=new SqlHelper();
    $sql="select nl_hf_time,sy_nl,z_nl from s_user where s_name='$_SESSION[id]'";
    $res=$sqlHelper->execute_dql($sql);

    $wj_znl = $res["z_nl"] + $vip_zf_nl;

    if($res["sy_nl"] < $wj_znl){
        $nl_hf_time = $res["nl_hf_time"];

        if($nl_hf_time){
            $now_time = date("Y-m-d H:i:s");
            if($nl_hf_time <= $now_time) {
                $naili_hf_time = naili_hf_time();
                $naili_hf_sec = $naili_hf_time * 60;

                $guoqu_sec = abs(strtotime($nl_hf_time) - strtotime($now_time)) + $naili_hf_sec;

                $huifu_naili = floor($guoqu_sec / $naili_hf_sec);

                if (($res["sy_nl"] + $huifu_naili) >= $wj_znl) {
                    $huifu_naili = $wj_znl - $res["sy_nl"];
                    $sql = "update s_user set sy_nl=$wj_znl,nl_hf_time=null where s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dml($sql);
                    $date = 0;
                } else {
                    $sql = "update s_user set sy_nl=sy_nl+$huifu_naili where s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dml($sql);

                    $shengyu_sec = $naili_hf_sec - ($guoqu_sec - $huifu_naili * $naili_hf_sec);
                    $next_time = (date('Y-m-d H:i:s', strtotime("+$shengyu_sec sec")));

                    $sql = "update s_user set nl_hf_time='$next_time' where s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dml($sql);

                    $min = floor($shengyu_sec / 60);
                    if ($min <= 0) {
                        $sec = $shengyu_sec;
                        $date = $sec . "秒";
                    } else {
                        $date = $min . "分";
                    }
                }
            }
            else{
                $show_time=strtotime($nl_hf_time) - strtotime($now_time);
                $h=floor($show_time/3600);
                if($h<=0){
                    $m=floor($show_time/60);
                    if($m<=0){
                        $s=$show_time;
                        $date=$s."秒";
                    }else{
                        $date=$m."分";
                    }
                }else{
                    $show_time=$show_time-($h*3600);
                    $m=floor($show_time/60);
                    $date=$h."时".$m."分";
                }
            }
        }else{
            $naili_hf_time = naili_hf_time();
            $next_time = (date('Y-m-d H:i:s', strtotime("+$naili_hf_time min")));
            $sql = "update s_user set nl_hf_time='$next_time' where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dml($sql);
            $date = $naili_hf_time.'分';
        }
    }
    else{
        if($res["nl_hf_time"]){
            $sql = "update s_user set nl_hf_time=null where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dml($sql);
        }
    }

    $sqlHelper->close_connect();
    return array($date,$huifu_naili);
}

//玩家聊天消息记录查询展示
function chat_show_fenye($gotourl,$pageSize,$next_xianshi,$dh_fl)
{
    require_once "../include/FenyePage.class.php";
    $fenyePage = new FenyePage();
    $fenyePage->gotoUrl = "$gotourl";
    $fenyePage->pageSize = $pageSize;

    if ($_SERVER["QUERY_STRING"]) {
        global $key_url_md_5;
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];
            if ($pagenowid > 20) {
                $fenyePage->pageNow = 20;
            } else {
                $fenyePage->pageNow = $pagenowid;
            }
        }
    }


    getFenyePage_chat($fenyePage, $dh_fl);

    $sqlHelper = new SqlHelper();

    global $date, $key_url_md_5;

    for ($i = 0; $i < count($fenyePage->res_array); $i++) {
        $row = $fenyePage->res_array[$i];

        //玩家普通发言
        $s_name = $row["s_name"];
        $sql = "select g_name,num,zhizun_vip,yueka_stop_time,cz_jf,xianlv from s_user where s_name='$s_name'";
        $res1 = $sqlHelper->execute_dql($sql);
        $res1_num = $res1["num"];
        $res1_g_name = $res1["g_name"];
        $zhizun_vip = $res1["zhizun_vip"];

        echo "<div>[" . substr($row['times'], 11, 5) . "]";

        if ($s_name == $_SESSION["id"]) {
            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<a href='../user/info.php?$url1'>" . $res1_g_name . '</a>';
        } else {
            $jiami1 = "id=$res1_num";
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<a href='../xy/wjinfo.php?$url1'>" . $res1_g_name . '</a>';
        }

        if ($zhizun_vip) {
            echo "<img class='tx_img' src='../images/zz.gif'>";
            echo "<img class='tx_img' src='../images/yk.gif'>";
        } else {
            $now_time = date("Y-m-d H:i:s");
            if ($now_time < $res1["yueka_stop_time"]) {
                echo "<img class='tx_img' src='../images/yk.gif'>";
            }
        }
        if ($res1["cz_jf"]) {
            echo '<img class="tx_img" src="../images/vip.gif">';
        }
        if ($res1["xianlv"]) {
            echo '<img class="tx_img" src="../images/xl.gif">';
        }

        echo ':' . $row["message"] . '</div>';

    }

    $sqlHelper->close_connect();

    //显示上一页和下一页
    if ($fenyePage->pageCount > 1 && $next_xianshi == 1) {
        echo $fenyePage->navigate;
    }
}

//查询玩家是否穿戴了该位置的装备
function chaxun_zhuangbei($col,$wj_sname=''){
    if($wj_sname == ''){
        $wj_sname = $_SESSION["id"];
    }
    $sqlHelper=new SqlHelper();
    $sql="select zb_name,num,zb_pinzhi,zb_dj from s_wj_zhuangbei where s_name='$wj_sname' and zb_used=1 and zb_col='$col'";
    $res=$sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();
    if($res){
        return $res;
    }else{
        return 0;
    }
}

//背包分类导航
function bag_daohang(){
    $daohang_array = array(
        array('q','装备','zb'),
        array('w','物品','wp'),
        array('e','宝石','bs'),
        array('r','称号','ch'),
        array('t','礼包','lb'),
        array('y','婚恋','hl'),
    );
    return $daohang_array;
}

//拍卖行分类导航
function pm_daohang(){
    $daohang_array = array(
        array('q','物品','wp'),
        array('w','宝石','bs'),
        array('e','称号','ch'),
        array('r','礼包','lb'),
    );
    return $daohang_array;
}

//玩家背包上架拍卖行分类导航
function wj_bag_pm_daohang(){
    $daohang_array = array(
        array('a','物品','wp'),
        array('s','宝石','bs'),
        array('d','称号','ch'),
        array('f','礼包','lb'),
    );
    return $daohang_array;
}

//商城分类导航
function shop_daohang(){
    $daohang_array = array(
        array('q','道具','daoju'),
        array('w','宝石','baoshi'),
        array('e','称号','chenghao'),
        array('r','礼包','libao'),
    );
    return $daohang_array;
}

//背包物品列表查询
function bag_show_fenye($gotourl,$bag_url_fl,$bag_fenlei){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=15;

    global $key_url_md_5,$date;

    if($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];
            if($pagenowid > 20){
                $fenyePage->pageNow=20;
            }else{
                $fenyePage->pageNow=$pagenowid;
            }
            $xuhao = ($fenyePage->pageNow - 1) * 15 +1;
        }else{
            $xuhao = 1;
        }
    }

    getFenyePage_bag($fenyePage,$bag_url_fl,$bag_fenlei);

    if($fenyePage->res_array){
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num=$row['num'];
            echo '<div>'.$xuhao.".";

            $jiami1 = 'x=q&id='.$num.'&f='.$bag_fenlei;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            $jiami2 = 'x=w&id='.$num.'&f='.$bag_fenlei;
            $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

            if($bag_fenlei == 'zb'){
                echo "<a href='show.php?$url1'>".$row['zb_pinzhi'].$row['zb_name']."</a>".$row['zb_dj']."级</div>";
            }else{
                echo "<a href='show.php?$url2'>".$row['wp_name'];
                if($row["wp_counts"] > 1){
                    echo "(".$row["wp_counts"].")";
                }
                echo "</a></div>";
            }
            $xuhao += 1;
        }

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无物品</div>';
    }
}

//获取装备介绍函数
function zb_info($zb_num){
    echo '<div style="font-weight: bold;">装备</div>';
    echo '<div>装备属性</div>';

    $sqlHelper=new SqlHelper();
    $sql="select zb_name,zb_dj,zb_pinzhi,zb_fs_gj,zb_fs_xq,zb_fs_fy,zb_fs_hp,zb_fs_bj,zb_fs_rx,zb_fs_sd,zb_cl_gj_dj,zb_cl_fy_dj,zb_cl_hp_dj,zb_cl_xq_dj,zb_cl_sd_dj,zb_kw1,zb_kw2,zb_kw3,zb_kw4,zb_kw5,zb_kw6,zb_kw7,zb_kw8,zb_kw9,zb_kw10 from s_wj_zhuangbei where num='$zb_num' and s_name='$_SESSION[id]'";
    $res=$sqlHelper->execute_dql($sql);
    if($res){
        echo '<div>'.$res["zb_pinzhi"].$res['zb_name'].' '.$res["zb_dj"].'级</div>';

        global $date,$key_url_md_5;
        $jiami1 = "x=u&id=".$zb_num;
        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
        $jiami2 = "x=i&id=".$zb_num;
        $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);
        $jiami3 = "x=o&id=".$zb_num;
        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
        $jiami4 = "x=h&id=".$zb_num;
        $url4 = encrypt_url("$jiami4.$date", $key_url_md_5);

        echo "<div><a href='info.php?$url1'>升级</a> | <a href='info.php?$url2'>洗炼</a> | <a href='info.php?$url3'>飞升</a> | <a href='info.php?$url4'>淬炼</a></div>";

        $pinzhi_bili = zhuangbei_pinzhi_bili($res["zb_pinzhi"]);

        $sql = "select zb_gj,zb_xq,zb_fy,zb_hp,zb_bj,zb_rx,zb_sd from s_zhuangbei_all where zb_name='$res[zb_name]' and zb_dj='$res[zb_dj]'";
        $res1 = $sqlHelper->execute_dql($sql);

        if($res1["zb_gj"]){
            echo '<div>基础:攻击+'.ceil($res1["zb_gj"] * $pinzhi_bili).'</div>';
        }
        if($res1["zb_xq"]){
            echo '<div>基础:仙气+'.ceil($res1["zb_xq"] * $pinzhi_bili).'</div>';
        }
        if($res1["zb_fy"]){
            echo '<div>基础:防御+'.ceil($res1["zb_fy"] * $pinzhi_bili).'</div>';
        }
        if($res1["zb_hp"]){
            echo '<div>基础:生命+'.ceil($res1["zb_hp"] * $pinzhi_bili).'</div>';
        }
        if($res1["zb_bj"]){
            echo '<div>基础:暴击+'.ceil($res1["zb_bj"] * $pinzhi_bili).'</div>';
        }
        if($res1["zb_rx"]){
            echo '<div>基础:韧性+'.ceil($res1["zb_rx"] * $pinzhi_bili).'</div>';
        }
        if($res1["zb_sd"]){
            echo '<div>基础:速度+'.ceil($res1["zb_sd"] * $pinzhi_bili).'</div>';
        }

        echo '<div style="margin-top: 5px;"></div>';

        if($res["zb_fs_gj"]){
            echo '<div>附属:攻击+'.$res["zb_fs_gj"].'</div>';
        }
        if($res["zb_fs_xq"]){
            echo '<div>附属:仙气+'.$res["zb_fs_xq"].'</div>';
        }
        if($res["zb_fs_fy"]){
            echo '<div>附属:防御+'.$res["zb_fs_fy"].'</div>';
        }
        if($res["zb_fs_hp"]){
            echo '<div>附属:生命+'.$res["zb_fs_hp"].'</div>';
        }
        if($res["zb_fs_bj"]){
            echo '<div>附属:暴击+'.$res["zb_fs_bj"].'</div>';
        }
        if($res["zb_fs_rx"]){
            echo '<div>附属:韧性+'.$res["zb_fs_rx"].'</div>';
        }
        if($res["zb_fs_sd"]){
            echo '<div>附属:速度+'.$res["zb_fs_sd"].'</div>';
        }

        echo '<div style="margin-top: 5px;"></div>';

        if($res["zb_cl_gj_dj"]){
            $zb_cl_sx = zb_cl_sx('gj',$res["zb_cl_gj_dj"]);
            echo '<div>淬炼:攻击+'.$zb_cl_sx.'</div>';
        }
        if($res["zb_cl_fy_dj"]){
            $zb_cl_sx = zb_cl_sx('fy',$res["zb_cl_fy_dj"]);
            echo '<div>淬炼:防御+'.$zb_cl_sx.'</div>';
        }
        if($res["zb_cl_hp_dj"]){
            $zb_cl_sx = zb_cl_sx('hp',$res["zb_cl_hp_dj"]);
            echo '<div>淬炼:生命+'.$zb_cl_sx.'</div>';
        }
        if($res["zb_cl_xq_dj"]){
            $zb_cl_sx = zb_cl_sx('xq',$res["zb_cl_xq_dj"]);
            echo '<div>淬炼:仙气+'.$zb_cl_sx.'</div>';
        }
        if($res["zb_cl_sd_dj"]){
            $zb_cl_sx = zb_cl_sx('sd',$res["zb_cl_sd_dj"]);
            echo '<div>淬炼:速度+'.$zb_cl_sx.'</div>';
        }

        echo '<div style="margin-top: 5px;"></div>';

        for($i=1;$i<=10;$i++){
            $kw_state = 'zb_kw'.$i;

            if($i == 1){
                $last_state = 0;
            }else{
                $last_state = 'zb_kw'.($i - 1);

                if($res["$last_state"] == -1){
                    break;
                }
            }

            if($res["$kw_state"] == -1){
                //开孔
                $jiami1 = 'x=q&zbid='.$zb_num.'&kwid='.$i;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                echo "<div>孔".$i.":<a href='zbxq.php?$url1'>开孔</a></div>";
            }elseif($res["$kw_state"] == 0){
                //镶嵌
                $jiami1 = 'x=w&zbid='.$zb_num.'&kwid='.$i;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                echo "<div>孔".$i.":<a href='zbxq.php?$url1'>无</a></div>";
            }else{
                //查找镶嵌的宝石
                $sql = "select bs_name from s_baoshi_all where num=$res[$kw_state]";
                $res1 = $sqlHelper->execute_dql($sql);

                $jiami1 = 'x=w&zbid='.$zb_num.'&kwid='.$i;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                echo "<div>孔".$i.":<a href='zbxq.php?$url1'>".$res1["bs_name"]."</a></div>";
            }
        }

        echo '<div style="margin-top: 5px;"></div>';
    }
    else{
        echo '<div>该装备不存在</div>';
    }

    $sqlHelper->close_connect();
}

//玩家使用物品相应减少物品数量系统
function use_wupin($wp_name,$shuliang=1,$wj_sname=''){
    if($wj_sname == ''){
        $wj_sname = $_SESSION["id"];
    }
    $sqlHelper=new SqlHelper();
    $sql="select wp_counts from s_wj_bag where wp_name='$wp_name' and s_name='$wj_sname'";
    $res=$sqlHelper->execute_dql($sql);

    if($res) {
        if ($res["wp_counts"] > $shuliang) {
            $sql = "update s_wj_bag set wp_counts=wp_counts-$shuliang where wp_name='$wp_name' and s_name='$wj_sname'";
            $res = $sqlHelper->execute_dml($sql);
        } elseif ($res["wp_counts"] == $shuliang) {
            $sql = "delete from s_wj_bag where wp_name='$wp_name' and s_name='$wj_sname'";
            $res = $sqlHelper->execute_dml($sql);
        } else {
            return 0;//如果没有该物品，则返回失败
        }

        $sqlHelper->close_connect();

        return 1;   //表示完成
    }
    else{
        $sqlHelper->close_connect();
        return 0;//如果没有该物品，则返回失败
    }
}

//发送物品
function give_wupin($id,$shuliang=1,$wj_sname=''){
    if($wj_sname == ''){
        $wj_sname = $_SESSION["id"];
    }

    $sqlHelper=new SqlHelper();

    $strsql="select wp_name,wp_zfl,wp_bd from s_wupin_all where num=$id";
    $result=$sqlHelper->execute_dql($strsql);
    if($result){
        $wp_name=$result['wp_name'];
        $wp_zfl=$result['wp_zfl'];
        $wp_bd=$result['wp_bd'];

        $strsql="select num from s_wj_bag where wp_name='$wp_name' and s_name='$wj_sname'";
        $result=$sqlHelper->execute_dql($strsql);

        if($result){
            $strsql="update s_wj_bag set wp_counts=wp_counts+$shuliang where num=$result[num] and s_name='$wj_sname'";
            $result=$sqlHelper->execute_dml($strsql);
        }else{
            $strsql="insert into s_wj_bag(s_name,wp_name,wp_counts,wp_fenlei,wp_bd) values('$wj_sname','$wp_name','$shuliang','$wp_zfl','$wp_bd')";
            $result=$sqlHelper->execute_dml($strsql);
        }
    }

    $sqlHelper->close_connect();
}

//物品信息查询
//$wp_info_state = 1，表示玩家上架拍卖前物品信息展示
//$wp_info_state = 2，表示拍卖中的物品信息展示，并显示返回拍卖行的链接
//$wp_info_state = 3，表示拍卖中的物品信息展示，并显示返回玩家上架中的物品列表的链接
//$wp_info_state = 4，表示商城物品信息页面
//$wp_info_state = 5，表示仙侣商城物品信息页面

function wp_info($wp_num,$wp_info_state=0){
    global $date,$key_url_md_5;

    $sqlHelper = new SqlHelper();

    if($wp_info_state == 0 || $wp_info_state == 1){
        $sql = "select wp_name,wp_counts,wp_bd from s_wj_bag where s_name='$_SESSION[id]' and num=$wp_num";
        $res = $sqlHelper->execute_dql($sql);
        if($res){
            $wp_name = $res["wp_name"];
        }
    }
    elseif($wp_info_state == 2 || $wp_info_state == 3){
        $sql = "select s_name,wp_num,wp_counts,wp_money,wp_expire_time,wp_start_time from s_wj_paimai where num=$wp_num";
        $res = $sqlHelper->execute_dql($sql);

        if($res){
            $wp_counts = $res["wp_counts"];

            $sql = "select wp_name from s_wupin_all where num=$res[wp_num]";
            $res1 = $sqlHelper->execute_dql($sql);

            if($res1){
                $wp_name = $res1["wp_name"];
            }
        }
    }
    elseif($wp_info_state == 4 || $wp_info_state == 5){
        $res = true;
    }

    echo '<div>【物品信息】</div>';

    if($res){
        if($wp_info_state == 4){
            $sql = "select wp_name,wp_coin,wp_bd,wp_note,wp_xfl from s_wupin_all where num=$wp_num and wp_shop=1 and wp_coin !=''";
            $res = $sqlHelper->execute_dql($sql);
            if($res){
                $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');
                echo '<div>名称:' . $res["wp_name"] . '</div>';
                echo '<div>描述:';

                if($res["wp_xfl"] == 'baoshi'){
                    $sql = "select bs_sx,bs_zhi from s_baoshi_all where bs_name='$res[wp_name]'";
                    $res1 = $sqlHelper->execute_dql($sql);
                    if($res1){
                        if($res1["bs_sx"] == 'gj'){
                            $sx_name = '攻击';
                        }elseif($res1["bs_sx"] == 'fy'){
                            $sx_name = '防御';
                        }elseif($res1["bs_sx"] == 'hp'){
                            $sx_name = '生命';
                        }elseif($res1["bs_sx"] == 'xq'){
                            $sx_name = '仙气';
                        }elseif($res1["bs_sx"] == 'sd'){
                            $sx_name = '速度';
                        }elseif($res1["bs_sx"] == 'bj'){
                            $sx_name = '暴击';
                        }elseif($res1["bs_sx"] == 'rx'){
                            $sx_name = '韧性';
                        }
                        echo '增加'.$res1["bs_zhi"].'点'.$sx_name;
                    }
                }else{
                    echo $res["wp_note"];
                }
                echo '</div>';
                echo '<div>绑定:';
                if ($res["wp_bd"] == 0) {
                    echo '否<br/>';
                }else{
                    echo '是<br/>';
                }
                echo '<div style="margin-top:10px;">价格:' . $res["wp_coin"] . '仙券</div>';
                echo '<div>现有:' . $wj_coin . '仙券</div><br/>';

                global $shop_fl;
                $jiami1 = 'y=w&id='.$wp_num.'&f='.$shop_fl;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<form action='shop.php?$url1' method='post'>";
                echo "购买数量: <input style='width:100px;' name='sl' value='1' id='search' onkeyup=\"this.value=this.value.replace(/\D/g,'')\" onafterpaste=\"this.value=this.value.replace(/\D/g,'')\">
                    <input  type=\"submit\" name=\"submit\"  value=\"购买\" id=\"search1\"><br>";
                echo '</form>';

            }else{
                echo "<div>该物品不存在</div>";
            }
        }
        elseif($wp_info_state == 5){
            $sql = "select wp_name,wp_note,wp_xfl from s_wupin_all where num=$wp_num";
            $res = $sqlHelper->execute_dql($sql);
            if($res){
                $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');
                echo '<div>名称:' . $res["wp_name"] . '</div>';
                echo '<div>描述:'.$res["wp_note"].'</div>';

                if($res["wp_xfl"] == 'baoshi'){
                    $sql = "select bs_sx,bs_zhi from s_baoshi_all where bs_name='$res[wp_name]'";
                    $res1 = $sqlHelper->execute_dql($sql);
                    if($res1){
                        if($res1["bs_sx"] == 'gj'){
                            $sx_name = '攻击';
                        }elseif($res1["bs_sx"] == 'fy'){
                            $sx_name = '防御';
                        }elseif($res1["bs_sx"] == 'hp'){
                            $sx_name = '生命';
                        }elseif($res1["bs_sx"] == 'xq'){
                            $sx_name = '仙气';
                        }elseif($res1["bs_sx"] == 'sd'){
                            $sx_name = '速度';
                        }elseif($res1["bs_sx"] == 'bj'){
                            $sx_name = '暴击';
                        }elseif($res1["bs_sx"] == 'rx'){
                            $sx_name = '韧性';
                        }
                        echo '增加'.$res1["bs_zhi"].'点'.$sx_name;
                    }
                }
            }else{
                echo "<div>该物品不存在</div>";
            }
        }
        else{
            $sql="select wp_note,wp_xfl,wp_canuse from s_wupin_all where wp_name='$wp_name'";
            $res1=$sqlHelper->execute_dql($sql);
            if($res) {
                $wp_counts = $res["wp_counts"];

                echo '<div>名称:' . $wp_name . '</div>';
                echo '<div>数量:' . $wp_counts . '</div>';
                echo '<div>描述:';

                if($res1["wp_xfl"] == 'baoshi'){
                    $sql = "select bs_sx,bs_zhi from s_baoshi_all where bs_name='$wp_name'";
                    $res1 = $sqlHelper->execute_dql($sql);
                    if($res1){
                        if($res1["bs_sx"] == 'gj'){
                            $sx_name = '攻击';
                        }elseif($res1["bs_sx"] == 'fy'){
                            $sx_name = '防御';
                        }elseif($res1["bs_sx"] == 'hp'){
                            $sx_name = '生命';
                        }elseif($res1["bs_sx"] == 'xq'){
                            $sx_name = '仙气';
                        }elseif($res1["bs_sx"] == 'sd'){
                            $sx_name = '速度';
                        }elseif($res1["bs_sx"] == 'bj'){
                            $sx_name = '暴击';
                        }elseif($res1["bs_sx"] == 'rx'){
                            $sx_name = '韧性';
                        }
                        echo '增加'.$res1["bs_zhi"].'点'.$sx_name;
                    }
                }
                else{
                    echo $res1["wp_note"];
                }
                echo '</div>';
                if($wp_info_state == 0 || $wp_info_state == 1){
                    echo '<div>绑定:';
                    if ($res["wp_bd"] == 0) {
                        echo "否<br/>";
                        if($wp_info_state == 1){
                            $jiami1 = "x=x";
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<form action='pm.php?$url1' method='post'>";

                            ?>
                            <br/><div>设定拍卖数量</div>
                            <input type="tel" name="shuliang" placeholder="请输入拍卖数量" value=1 id='search'
                                   onkeyup="this.value=this.value.replace(/\D/g,'')"
                                   onafterpaste="this.value=this.value.replace(/\D/g,'')">

                            <div>设定拍卖灵石价格</div>
                            <input type="tel" name="money" placeholder="请输入拍卖铜币价格" value=1 id='search'
                                   onkeyup="this.value=this.value.replace(/\D/g,'')"
                                   onafterpaste="this.value=this.value.replace(/\D/g,'')">

                            <?php
                            echo "<input type='hidden' name='wp_num' value='$wp_num'><br/>";
                            echo "<div style='margin-top: 10px;'><input  type='submit' name='submit' class='button_djy' value='确认上架'></div>";
                            echo "</form>";

                            require_once '../control/control.php';
                            $paimai_shouxufei = paimai_shouxufei("jinbi");

                            echo '<div><span style="color:red;">请注意，拍卖物品将会收取拍卖价格的' . $paimai_shouxufei . '%作为手续费，请合理设定拍卖价格。</span><div>';
                        }
                        elseif($wp_info_state == 0){
                            if($res1["wp_canuse"] == 1){
                                $jiami1 = 'x=q&id='.$wp_num;
                                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                                echo "<div style='margin-bottom: 5px;'><a href='../user/use_wp.php?$url1'>使用物品</a></div>";
                            }
                        }
                    } else {
                        echo "是<br/>";
                    }
                    echo '</div>';
                }

                if($wp_info_state == 2 || $wp_info_state == 3){

                    echo '<div>价格:'.$res["wp_money"].'灵石</div>';

                    $sy_time = zhuanhuan_sy_time($res["wp_expire_time"]);
                    echo '<div>出售期限: '.$sy_time."</div>";

                    if($res["s_name"] == $_SESSION['id']){
                        $zhuanhuan_guoqu_time = zhuanhuan_guoqu_time($res["wp_start_time"]);
                        $paimai_quxiao_time = paimai_quxiao_time();
                        if($zhuanhuan_guoqu_time < $paimai_quxiao_time){
                            $sy_sec = $paimai_quxiao_time - $zhuanhuan_guoqu_time;
                            echo '<div>刚上架的物品需要'.floor($paimai_quxiao_time / 60).'分钟后才能收回，还需等待'.$sy_sec.'秒。</div>';

                            $jiami1 = 'x=b&id='.$wp_num;
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<div><a href='pm.php?$url1'>刷新查看</a></div>";
                        }else{
                            $jiami1 = 'x=n&id='.$wp_num;
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<div><a href='pm.php?$url1'>收回物品</a></div>";
                        }
                    }else{
                        $jiami1 = 'x=m&id='.$wp_num;
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        echo "<a href='pm.php?$url1'>确认购买</a><br/>";
                    }

                    if($wp_info_state == 2){
                        $jiami1 = 'x=v&id='.$res["wp_num"];
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                        echo "<div><a href='pm.php?$url1'>返回上页</a></div>";
                    }elseif($wp_info_state == 3){
                        $jiami1 = 'x=qq&id='.$res["wp_num"];
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                        echo "<div><a href='pm.php?$url1'>返回上页</a></div>";
                    }
                }
            }
            else{
                echo "<div>该物品不存在</div>";
            }
        }
    }
    else{
        echo "<div>该物品不存在</div>";
    }

    $sqlHelper->close_connect();
}

//向世界公告写入信息
function insert_xitong_gonggao($s_name,$message,$xx_leixin,$df_sname='',$message1=''){
    $times = date("Y-m-d H:i:s");
    $sqlHelper = new SqlHelper();
    $sql="insert into s_gonggao(s_name,message,xx_leixin,s_name1,message1,times) values('$s_name','$message','$xx_leixin','$df_sname','$message1','$times')";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();
}

//系统消息记录查询展示
function xtgg_show_fenye($gotourl,$pageSize,$next_xianshi,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=$pageSize;

    if($_SERVER["QUERY_STRING"]) {
        global $key_url_md_5;
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];
            if($pagenowid > 20){
                $fenyePage->pageNow=20;
            }else{
                $fenyePage->pageNow=$pagenowid;
            }
        }
    }



    getFenyePage_sjtg($fenyePage,$dh_fl);

    $sqlHelper=new SqlHelper();

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        if ($row["xx_leixin"] == "xt") {
            //系统信息
            $s_name = $row["s_name"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $zhizun_vip = $res1["zhizun_vip"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>";
            $jiami1 = "id=$res1_num";
            global $date,$key_url_md_5;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo $row["message"];

            echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

            if($zhizun_vip){
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo "<img class='tx_img' src='../images/yk.gif'>";
            }else{
                $now_time = date("Y-m-d H:i:s");
                if($now_time < $res1["yueka_stop_time"]){
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo $row["message1"];
            echo "<br/>";
        }elseif ($row["xx_leixin"] == "cjbp") {
            //系统信息
            $s_name = $row["s_name"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $zhizun_vip = $res1["zhizun_vip"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>";

            global $date,$key_url_md_5;

            $bp_name = $row["message"];
            $sql = "select num from s_bangpai_all where bp_name='$bp_name'";
            $res2 = $sqlHelper->execute_dql($sql);

            $jiami2 = 'x=r&id='.$res2["num"];
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

            if($s_name == $_SESSION["id"]){
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo '玩家';

                echo "<a href='../user/info.php?$url1'>".$res1_g_name."</a>";
                if($zhizun_vip){
                    echo '<img class="tx_img" src="../images/zz.gif">';
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }else{
                    $now_time = date("Y-m-d H:i:s");
                    if($now_time < $res1["yueka_stop_time"]){
                        echo "<img class='tx_img' src='../images/yk.gif'>";
                    }
                }
                if ($res1["cz_jf"]) {
                    echo '<img class="tx_img" src="../images/vip.gif">';
                }
                if ($res1["xianlv"]) {
                    echo '<img class="tx_img" src="../images/xl.gif">';
                }
                echo "成功创建了帮派<a href='../xy/bp.php?$url2'>".$row["message"].'</a>';
            }else{
                $jiami1 = "id=$res1_num";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo '玩家';

                echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name."</a>";

                if($zhizun_vip){
                    echo '<img class="tx_img" src="../images/zz.gif">';
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }else{
                    $now_time = date("Y-m-d H:i:s");
                    if($now_time < $res1["yueka_stop_time"]){
                        echo "<img class='tx_img' src='../images/yk.gif'>";
                    }
                }
                if ($res1["cz_jf"]) {
                    echo '<img class="tx_img" src="../images/vip.gif">';
                }
                if ($res1["xianlv"]) {
                    echo '<img class="tx_img" src="../images/xl.gif">';
                }

                echo "成功创建了帮派<a href='../xy/bp.php?$url2'>".$row["message"].'</a>';
            }

            echo "<br/>";
        }
        elseif ($row["xx_leixin"] == "pk_top10") {
            //进入天武榜前十
            $s_name = $row["s_name"];
            $s_name1 = $row["s_name1"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name1'";
            $res2 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $res2_num = $res2["num"];
            $res2_g_name = $res2["g_name"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>玩家";


            global $date,$key_url_md_5;

            if($s_name == $_SESSION["id"]){
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<a href='../user/info.php?$url1'>".$res1_g_name.'</a>';
            }else{
                $jiami1 = "id=$res1_num";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';
            }

            if ($res1["zhizun_vip"]) {
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo '<img class="tx_img" src="../images/yk.gif">';
            } else {
                $now_time = date("Y-m-d H:i:s");
                if ($now_time < $res1["yueka_stop_time"]) {
                    echo '<img class="tx_img" src="../images/yk.gif">';
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo $row["message"];

            if($s_name1 == $_SESSION["id"]){
                $jiami2 = 'x=q';
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
                echo "<a href='../user/info.php?$url2'>" . $res2_g_name . '</a>，';
            }else{
                $jiami2 = "id=$res2_num";
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
                echo "<a href='../xy/wjinfo.php?$url2'>" . $res2_g_name . '</a>，';
            }

            if ($res2["zhizun_vip"]) {
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo '<img class="tx_img" src="../images/yk.gif">';
            } else {
                $now_time = date("Y-m-d H:i:s");
                if ($now_time < $res2["yueka_stop_time"]) {
                    echo '<img class="tx_img" src="../images/yk.gif">';
                }
            }
            if ($res2["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res2["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo $row["message1"];

            echo "<br/>";
        }elseif ($row["xx_leixin"] == "qhcg") {
            //求婚成功
            $s_name = $row["s_name"];
            $s_name1 = $row["s_name1"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name1'";
            $res2 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $res2_num = $res2["num"];
            $res2_g_name = $res2["g_name"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>恭喜玩家";


            global $date,$key_url_md_5;

            if($s_name == $_SESSION["id"]){
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<a href='../user/info.php?$url1'>".$res1_g_name.'</a>';
            }else{
                $jiami1 = "id=$res1_num";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';
            }

            if ($res1["zhizun_vip"]) {
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo '<img class="tx_img" src="../images/yk.gif">';
            } else {
                $now_time = date("Y-m-d H:i:s");
                if ($now_time < $res1["yueka_stop_time"]) {
                    echo '<img class="tx_img" src="../images/yk.gif">';
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo '和';

            if($s_name1 == $_SESSION["id"]){
                $jiami2 = 'x=q';
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
                echo "<a href='../user/info.php?$url2'>" . $res2_g_name . '</a>';
            }else{
                $jiami2 = "id=$res2_num";
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
                echo "<a href='../xy/wjinfo.php?$url2'>" . $res2_g_name . '</a>';
            }

            if ($res2["zhizun_vip"]) {
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo '<img class="tx_img" src="../images/yk.gif">';
            } else {
                $now_time = date("Y-m-d H:i:s");
                if ($now_time < $res2["yueka_stop_time"]) {
                    echo '<img class="tx_img" src="../images/yk.gif">';
                }
            }
            if ($res2["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res2["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo $row["message"];

            echo "<br/>";
        }
    }

    $sqlHelper->close_connect();

    //显示上一页和下一页
    if($fenyePage->pageCount > 1 && $next_xianshi == 1){
        echo $fenyePage->navigate;
    }
}

//玩家个人动态私聊查询展示
function wjdt_show_fenye($gotourl,$pageSize,$next_xianshi,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=$pageSize;

    if($_SERVER["QUERY_STRING"]) {
        global $key_url_md_5;
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];
            if($pagenowid > 20){
                $fenyePage->pageNow=20;
            }else{
                $fenyePage->pageNow=$pagenowid;
            }
        }
    }

    getFenyePage_wjdt($fenyePage,$dh_fl);

    $sqlHelper=new SqlHelper();

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        if ($row["xx_lx"] == "dfcg") {
            //对方斗法成功
            $s_name = $row["s_name1"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $zhizun_vip = $res1["zhizun_vip"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>";
            $jiami1 = "id=$res1_num";
            global $date,$key_url_md_5;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

            if($zhizun_vip){
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo "<img class='tx_img' src='../images/yk.gif'>";
            }else{
                $now_time = date("Y-m-d H:i:s");
                if($now_time < $res1["yueka_stop_time"]){
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo '向你发起了斗法，你失败了~';
            echo "<br/>";
        }elseif ($row["xx_lx"] == "dfsb") {
            //对方斗法失败
            $s_name = $row["s_name1"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $zhizun_vip = $res1["zhizun_vip"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>";
            $jiami1 = "id=$res1_num";
            global $date,$key_url_md_5;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

            if($zhizun_vip){
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo "<img class='tx_img' src='../images/yk.gif'>";
            }else{
                $now_time = date("Y-m-d H:i:s");
                if($now_time < $res1["yueka_stop_time"]){
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo '向你发起了斗法，但技不如你~';
            echo "<br/>";
        }elseif ($row["xx_lx"] == "pkup") {
            //对方竞技排名上升
            $s_name = $row["s_name1"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $zhizun_vip = $res1["zhizun_vip"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>";
            $jiami1 = "id=$res1_num";
            global $date,$key_url_md_5;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

            if($zhizun_vip){
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo "<img class='tx_img' src='../images/yk.gif'>";
            }else{
                $now_time = date("Y-m-d H:i:s");
                if($now_time < $res1["yueka_stop_time"]){
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo $row["message"];
            echo "<br/>";
        }elseif ($row["xx_lx"] == "shuangxiu") {
            //双修
            $s_name = $row["s_name1"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $zhizun_vip = $res1["zhizun_vip"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>";
            $jiami1 = "id=$res1_num";
            global $date,$key_url_md_5;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

            if($zhizun_vip){
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo "<img class='tx_img' src='../images/yk.gif'>";
            }else{
                $now_time = date("Y-m-d H:i:s");
                if($now_time < $res1["yueka_stop_time"]){
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }
            echo '和你进行了双修~';
            echo "<br/>";
        }elseif ($row["xx_lx"] == "songhua") {
            //双修
            $s_name = $row["s_name1"];
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];
            $zhizun_vip = $res1["zhizun_vip"];

            echo "[" . substr($row['times'], 11, 5) . "]";
            echo "<span style='color:red'>系统:</span>";
            $jiami1 = "id=$res1_num";
            global $date,$key_url_md_5;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

            if($zhizun_vip){
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo "<img class='tx_img' src='../images/yk.gif'>";
            }else{
                $now_time = date("Y-m-d H:i:s");
                if($now_time < $res1["yueka_stop_time"]){
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }
            echo $row["message"];
            echo "<br/>";
        }
    }

    $sqlHelper->close_connect();

    //显示上一页和下一页
    if($fenyePage->pageCount > 1 && $next_xianshi == 1){
        echo $fenyePage->navigate;
    }
}

//私聊消息记录查询展示
function siliao_show_fenye($gotourl,$pageSize,$next_xianshi,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=$pageSize;

    if($_SERVER["QUERY_STRING"]) {
        global $key_url_md_5;
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];
            if($pagenowid > 20){
                $fenyePage->pageNow=20;
            }else{
                $fenyePage->pageNow=$pagenowid;
            }
        }
    }



    getFenyePage_siliao($fenyePage,$dh_fl);

    $sqlHelper=new SqlHelper();

    global $date,$key_url_md_5;

    for($i=0;$i<count($fenyePage->res_array);$i++){
        $row=$fenyePage->res_array[$i];

        $s_name = $row["s_name"];
        $s_name1 = $row["s_name1"];
        $xx_leixin = $row["xx_leixin"];

        $times = str_replace('-','.',substr($row['times'], 5, 11));

        echo "<div>[" . $times . "]";
        if($s_name == $_SESSION["id"]){
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name1'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];

            $jiami1 = 'id='.$res1_num;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            $jiami2 = 'id='.$res1_num.'&k=1';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
            echo ' 我对 '."<a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

            if ($res1["zhizun_vip"]) {
                echo '<img class="tx_img" src="../images/zz.gif">';
                echo '<img class="tx_img" src="../images/yk.gif">';
            } else {
                $now_time = date("Y-m-d H:i:s");
                if ($now_time < $res1["yueka_stop_time"]) {
                    echo '<img class="tx_img" src="../images/yk.gif">';
                }
            }
            if ($res1["cz_jf"]) {
                echo '<img class="tx_img" src="../images/vip.gif">';
            }
            if ($res1["xianlv"]) {
                echo '<img class="tx_img" src="../images/xl.gif">';
            }

            echo ' 说:'.$row["message"]." <a href='wjinfo.php?$url2'>私聊</a></div>";
        }elseif($s_name1 == $_SESSION["id"]){
            $sql = "select g_name,num,zhizun_vip,yueka_stop_time,xianlv,cz_jf from s_user where s_name='$s_name'";
            $res1 = $sqlHelper->execute_dql($sql);
            $res1_num = $res1["num"];
            $res1_g_name = $res1["g_name"];

            $jiami1 = 'id='.$res1_num;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            $jiami2 = 'id='.$res1_num.'&k=1';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

            if($xx_leixin == 'hysq'){
                //好友申请
                $hysq_num = $row["num"];

                $jiami3 = 'x=q&id='.$hysq_num;
                $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);

                echo "系统: 玩家 <a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

                if ($res1["zhizun_vip"]) {
                    echo '<img class="tx_img" src="../images/zz.gif">';
                    echo '<img class="tx_img" src="../images/yk.gif">';
                } else {
                    $now_time = date("Y-m-d H:i:s");
                    if ($now_time < $res1["yueka_stop_time"]) {
                        echo '<img class="tx_img" src="../images/yk.gif">';
                    }
                }
                if ($res1["cz_jf"]) {
                    echo '<img class="tx_img" src="../images/vip.gif">';
                }
                if ($res1["xianlv"]) {
                    echo '<img class="tx_img" src="../images/xl.gif">';
                }

                echo ' '.$row["message"]." <a href='../user/hy.php?$url3'>同意</a></div>";
            }else{
                //玩家私聊
                echo " <a href='../xy/wjinfo.php?$url1'>".$res1_g_name.'</a>';

                if ($res1["zhizun_vip"]) {
                    echo '<img class="tx_img" src="../images/zz.gif">';
                    echo '<img class="tx_img" src="../images/yk.gif">';
                } else {
                    $now_time = date("Y-m-d H:i:s");
                    if ($now_time < $res1["yueka_stop_time"]) {
                        echo '<img class="tx_img" src="../images/yk.gif">';
                    }
                }
                if ($res1["cz_jf"]) {
                    echo '<img class="tx_img" src="../images/vip.gif">';
                }
                if ($res1["xianlv"]) {
                    echo '<img class="tx_img" src="../images/xl.gif">';
                }

                echo ' 对我说:'.$row["message"]." <a href='wjinfo.php?$url2'>回复</a></div>";
            }
        }

    }

    $sqlHelper->close_connect();

    //显示上一页和下一页
    if($fenyePage->pageCount > 1 && $next_xianshi == 1){
        echo $fenyePage->navigate;
    }
}

//剩余时间转换-用于显示剩下的时间
function zhuanhuan_sy_time($sy_time){
    $now_time = date("Y-m-d H:i:s");
    if($sy_time > $now_time){
        $stop_time = strtotime($sy_time) - strtotime($now_time);

        $h = floor($stop_time / 3600);
        if ($h <= 0) {
            $m = floor($stop_time / 60);
            if ($m <= 0) {
                $s = $stop_time;
                $date = $s . "秒";
            } else {
                $s = $stop_time - ($m * 60);
//                $date = $m . "分" . $s . "秒";
                $date = $m . "分";
            }
        } else {
            $stop_time = $stop_time - ($h * 3600);
            $m = floor($stop_time / 60);
            $s = $stop_time - ($m * 60);
//            $date = $h . "时" . $m . "分" . $s . "秒";
            $date = $h . "时" . $m . "分";
        }
        return $date;
        exit;
    }
}

//剩余时间转换-用于显示剩下的时间(带秒数)
function zhuanhuan_sy_time_sec($sy_time){
    $now_time = date("Y-m-d H:i:s");
    if($sy_time > $now_time){
        $stop_time = strtotime($sy_time) - strtotime($now_time);

        $h = floor($stop_time / 3600);
        if ($h <= 0) {
            $m = floor($stop_time / 60);
            if ($m <= 0) {
                $s = $stop_time;
                $date = $s . "秒";
            } else {
                $s = $stop_time - ($m * 60);
                $date = $m . "分" . $s . "秒";
//                $date = $m . "分";
            }
        } else {
            $stop_time = $stop_time - ($h * 3600);
            $m = floor($stop_time / 60);
            $s = $stop_time - ($m * 60);
            $date = $h . "时" . $m . "分" . $s . "秒";
//            $date = $h . "时" . $m . "分";
        }
        return $date;
        exit;
    }
}

//剩余时间转换-用于显示剩下的时间(带天数)
function zhuanhuan_sy_time_day($sy_time){
    $now_time = date("Y-m-d H:i:s");
    if($sy_time > $now_time){
        $stop_time = strtotime($sy_time) - strtotime($now_time);

        $d = floor($stop_time / 86400);
        if($d){
            $stop_time = $stop_time - ($d * 86400);

            $h = floor($stop_time / 3600);
            if ($h <= 0) {
                $m = floor($stop_time / 60);
                if ($m <= 0) {
                    $s = $stop_time;
                    $date = $d . '天'.$s . "秒";
                } else {
                    $s = $stop_time - ($m * 60);
                    $date = $d . '天'.$m . "分" . $s . "秒";
                }
            } else {
                $stop_time = $stop_time - ($h * 3600);
                $m = floor($stop_time / 60);
                $s = $stop_time - ($m * 60);
                $date = $d . '天' .$h . "时" . $m . "分" . $s . "秒";
            }
        }else{
            $h = floor($stop_time / 3600);
            if ($h <= 0) {
                $m = floor($stop_time / 60);
                if ($m <= 0) {
                    $s = $stop_time;
                    $date = $d . '天'.$s . "秒";
                } else {
                    $s = $stop_time - ($m * 60);
                    $date = $d . '天'.$m . "分" . $s . "秒";
                }
            } else {
                $stop_time = $stop_time - ($h * 3600);
                $m = floor($stop_time / 60);
                $s = $stop_time - ($m * 60);
                $date = $d . '天' .$h . "时" . $m . "分" . $s . "秒";
            }
        }

        return $date;
        exit;
    }
}

//已过去的时间计算
function zhuanhuan_guoqu_time($stop_time){
    $now_time = date("Y-m-d H:i:s");
    $sec = strtotime($now_time) - strtotime($stop_time);
    return $sec;
    exit;
}

//检测送花、收花周榜的过期时间
function jiance_hua_week(){
    $stop_time = date("Y-m-d ",strtotime("next Monday"))."00:00:01";
    $hd_name = 'songshouhua';

    $sqlHelper = new SqlHelper();
    $sql = "select hd_stop_time from s_huodong_time where hd_name='$hd_name'";
    $res = $sqlHelper->execute_dql($sql);
    if($res){
        $now_time = date("Y-m-d H:i:s");
        if($res["hd_stop_time"] < $now_time){
            $sql = "update s_user set songhb_week=0,shouhb_week=0 where songhb_week > 0 or shouhb_week > 0";
            $res = $sqlHelper->execute_dml($sql);
            $sql = "update s_huodong_time set hd_stop_time='$stop_time' where hd_name='$hd_name'";
            $res = $sqlHelper->execute_dml($sql);
        }
    }else{
        $sql = "insert into s_huodong_time(hd_name,hd_stop_time) values('$hd_name','$stop_time')";
        $res = $sqlHelper->execute_dml($sql);
    }
    $sqlHelper->close_connect();
}

//写入玩家动态
function insert_wj_dongtai($s_name,$s_name1,$xx_lx,$message){
    $now_time = date("Y-m-d H:i:s");
    $sqlHelper = new SqlHelper();
    $sql = "insert into s_wj_dongtai(s_name,s_name1,xx_lx,message,times) values ('$s_name','$s_name1','$xx_lx','$message','$now_time')";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();
}
?>