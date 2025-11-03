<?php
/**
 * Author: by suxin
 * Date: 2019/12/6
 * Time: 11:10
 * Note: 获取玩家所有状态增加的属性值
 */


//获取玩家各种状态属性加成
function wj_all_zt_add_zhi($wj_sname,$wj_dj){
    $gj = 0;    $xq = 0;
    $fy = 0;    $hp = 0;
    $bj = 0;    $rx = 0;
    $sd = 0;

    //获取人物当前等级自身属性
    $renwu_shuxing = renwu_shuxing($wj_dj);

    $gj += $renwu_shuxing[0];
    $xq += $renwu_shuxing[1];
    $fy += $renwu_shuxing[2];
    $hp += $renwu_shuxing[3];
    $bj += $renwu_shuxing[4];
    $rx += $renwu_shuxing[5];
    $sd += $renwu_shuxing[6];

    $sqlHelper=new SqlHelper();

    ###############################
    //获取装备附加属性
    $sql="select zb_name,zb_dj,zb_pinzhi,zb_fs_gj,zb_fs_xq,zb_fs_fy,zb_fs_hp,zb_fs_bj,zb_fs_rx,zb_fs_sd,zb_cl_gj_dj,zb_cl_fy_dj,zb_cl_hp_dj,zb_cl_xq_dj,zb_cl_sd_dj,zb_kw1,zb_kw2,zb_kw3,zb_kw4,zb_kw5,zb_kw6,zb_kw7,zb_kw8,zb_kw9,zb_kw10 from s_wj_zhuangbei where s_name='$wj_sname' and zb_used=1";
    $res=$sqlHelper->execute_dql2($sql);
    for($i=0;$i<count($res);$i++){
        $gj += $res[$i]["zb_fs_gj"];
        $xq += $res[$i]["zb_fs_xq"];
        $fy += $res[$i]["zb_fs_fy"];
        $hp += $res[$i]["zb_fs_hp"];
        $bj += $res[$i]["zb_fs_bj"];
        $rx += $res[$i]["zb_fs_rx"];
        $sd += $res[$i]["zb_fs_sd"];

        $zb_name = $res[$i]["zb_name"];
        $zb_dj = $res[$i]["zb_dj"];
        $zb_pinzhi = $res[$i]["zb_pinzhi"];

        $pinzhi_bili = zhuangbei_pinzhi_bili($zb_pinzhi);

        $sql = "select zb_gj,zb_xq,zb_fy,zb_hp,zb_bj,zb_rx,zb_sd from s_zhuangbei_all where zb_name='$zb_name' and zb_dj='$zb_dj'";
        $res1 = $sqlHelper->execute_dql($sql);

        $gj += ceil($res1["zb_gj"] * $pinzhi_bili);
        $xq += ceil($res1["zb_xq"] * $pinzhi_bili);
        $fy += ceil($res1["zb_fy"] * $pinzhi_bili);
        $hp += ceil($res1["zb_hp"] * $pinzhi_bili);
        $bj += ceil($res1["zb_bj"] * $pinzhi_bili);
        $rx += ceil($res1["zb_rx"] * $pinzhi_bili);
        $sd += ceil($res1["zb_sd"] * $pinzhi_bili);

        //获取装备淬炼附加属性
        $cl_gj_dj = $res[$i]["zb_cl_gj_dj"];
        if($cl_gj_dj){
            $zb_cl_sx = zb_cl_sx('gj',$cl_gj_dj);
            $gj += $zb_cl_sx;
        }
        $cl_xq_dj = $res[$i]["zb_cl_xq_dj"];
        if($cl_xq_dj){
            $zb_cl_sx = zb_cl_sx('gj',$cl_xq_dj);
            $xq += $zb_cl_sx;
        }
        $cl_fy_dj = $res[$i]["zb_cl_fy_dj"];
        if($cl_fy_dj){
            $zb_cl_sx = zb_cl_sx('gj',$cl_fy_dj);
            $fy += $zb_cl_sx;
        }
        $cl_hp_dj = $res[$i]["zb_cl_hp_dj"];
        if($cl_hp_dj){
            $zb_cl_sx = zb_cl_sx('gj',$cl_hp_dj);
            $hp += $zb_cl_sx;
        }
        $cl_sd_dj = $res[$i]["zb_cl_sd_dj"];
        if($cl_sd_dj){
            $zb_cl_sx = zb_cl_sx('gj',$cl_sd_dj);
            $sd += $zb_cl_sx;
        }

        //获取装备镶嵌宝石属性
        $zb_kw1 = $res[$i]["zb_kw1"];
        $zb_kw2 = $res[$i]["zb_kw2"];
        $zb_kw3 = $res[$i]["zb_kw3"];
        $zb_kw4 = $res[$i]["zb_kw4"];
        $zb_kw5 = $res[$i]["zb_kw5"];
        $zb_kw6 = $res[$i]["zb_kw6"];
        $zb_kw7 = $res[$i]["zb_kw7"];
        $zb_kw8 = $res[$i]["zb_kw8"];
        $zb_kw9 = $res[$i]["zb_kw9"];
        $zb_kw10 = $res[$i]["zb_kw10"];

        for($j=1;$j<=10;$j++){
            $kw_name = 'zb_kw'.$j;
            $kw_bs_num = $res[$i]["$kw_name"];
            if($kw_bs_num != 0 && $kw_bs_num != -1){
                $sql = "select bs_sx,bs_zhi from s_baoshi_all where num=$kw_bs_num";
                $res1 = $sqlHelper->execute_dql($sql);
                if($res1){
                    if($res1["bs_sx"] == 'gj'){
                        $gj += $res1["bs_zhi"];
                    }elseif($res1["bs_sx"] == 'fy'){
                        $fy += $res1["bs_zhi"];
                    }elseif($res1["bs_sx"] == 'xq'){
                        $xq += $res1["bs_zhi"];
                    }elseif($res1["bs_sx"] == 'hp'){
                        $hp += $res1["bs_zhi"];
                    }elseif($res1["bs_sx"] == 'sd'){
                        $sd += $res1["bs_zhi"];
                    }elseif($res1["bs_sx"] == 'bj'){
                        $bj += $res1["bs_zhi"];
                    }elseif($res1["bs_sx"] == 'rx'){
                        $rx += $res1["bs_zhi"];
                    }
                }
            }
        }
    }


    ###############################
    //获取境界附加属性
    $sql = "select jingjie from s_user where s_name='$wj_sname'";
    $res = $sqlHelper->execute_dql($sql);
    $sql = "select jj_gj,jj_xq,jj_fy,jj_hp,jj_bj,jj_rx,jj_sd from s_jingjie_all where jj_name='$res[jingjie]'";
    $res = $sqlHelper->execute_dql($sql);
    if($res){
        $gj += $res["jj_gj"];   $xq += $res["jj_xq"];   $fy += $res["jj_fy"];
        $hp += $res["jj_hp"];   $bj += $res["jj_bj"];   $rx += $res["jj_rx"];
        $sd += $res["jj_sd"];
    }

    ###############################
    //获取天赋附加属性及至尊VIP属性加成，称号属性加成，戒指加成
    $tianfu_shuxing_xishu = tianfu_shuxing_xishu();

    $sql = "select tf_wx,tf_lq,tf_jg,tf_xm,tf_sf,zhizun_vip,ch_gj,ch_xq,ch_fy,ch_hp,ch_sd,ch_bj,ch_rx,jiezhi,jiezhi_dj from s_user where s_name='$wj_sname'";
    $res = $sqlHelper->execute_dql($sql);
    $gj += ceil($res["tf_wx"] * $tianfu_shuxing_xishu[0]);
    $xq += ceil($res["tf_lq"] * $tianfu_shuxing_xishu[1]);
    $fy += ceil($res["tf_jg"] * $tianfu_shuxing_xishu[2]);
    $hp += ceil($res["tf_xm"] * $tianfu_shuxing_xishu[3]);
    $sd += ceil($res["tf_sf"] * $tianfu_shuxing_xishu[4]);

    $gj += $res["ch_gj"];   $xq += $res["ch_xq"];
    $fy += $res["ch_fy"];   $hp += $res["ch_hp"];
    $bj += $res["ch_bj"];   $rx += $res["ch_rx"];
    $sd += $res["ch_sd"];

    if($res["zhizun_vip"] == 1){
        $zzvip_shuxing = zzvip_shuxing();
        $zzvip_shuxing = explode("|",$zzvip_shuxing);
        for($i=0;$i<count($zzvip_shuxing);$i++){
            $shuxing = explode(",",$zzvip_shuxing[$i]);
            if($shuxing[0] == 'gj'){
                $gj += $shuxing[1];
            }elseif($shuxing[0] == 'fy'){
                $fy += $shuxing[1];
            }elseif($shuxing[0] == 'hp'){
                $hp += $shuxing[1];
            }
        }
    }

    if($res["jiezhi"]){
        $jiezhi_shuxing = jiezhi_shuxing($res["jiezhi"], $res["jiezhi_dj"]);
        if ($jiezhi_shuxing[0]) {
            $gj += $jiezhi_shuxing[0];
        }
        if ($jiezhi_shuxing[1]) {
            $fy += $jiezhi_shuxing[1];
        }
        if ($jiezhi_shuxing[2]) {
            $xq += $jiezhi_shuxing[2];
        }
        if ($jiezhi_shuxing[3]) {
            $hp += $jiezhi_shuxing[3];
        }
        if ($jiezhi_shuxing[4]) {
            $bj += $jiezhi_shuxing[4];
        }
        if ($jiezhi_shuxing[5]) {
            $rx += $jiezhi_shuxing[5];
        }
        if ($jiezhi_shuxing[6]) {
            $sd += $jiezhi_shuxing[6];
        }
    }

    ###############################
    //获取被动技能附加属性
    $sql = "select skill_num,skill_dj from s_wj_skill where s_name='$wj_sname' and skill_fl='bd'";
    $res = $sqlHelper->execute_dql2($sql);
    $wj_skill_count = count($res);
    for($i=0;$i<$wj_skill_count;$i++){
        $skill_num = $res[$i]["skill_num"];
        $skill_dj = $res[$i]["skill_dj"];
        $sql = "select skill_lx,skill_zhi from s_skill_all where num=$skill_num";
        $res1 = $sqlHelper->execute_dql($sql);
        if($res1){
            $add_zhi = $res1["skill_zhi"] * $skill_dj;
            if($res1["skill_lx"] == 'gj'){
                $gj += $add_zhi;
            }elseif($res1["skill_lx"] == 'fy'){
                $fy += $add_zhi;
            }elseif($res1["skill_lx"] == 'hp'){
                $hp += $add_zhi;
            }
        }
    }





    ##################################
    $sqlHelper->close_connect();

//    $hp = 999999999;
//    $hp = 1;
//    $sd = 99999;
//    $gj = 1000000;
//    $gj = 1;


    return array($gj,$xq,$fy,$hp,$bj,$rx,$sd);
}

?>