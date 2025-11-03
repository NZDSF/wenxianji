<?php
/**
 * Author: by suxin
 * Date: 2019/12/01
 * Time: 15:24
 * Note: 各属性控制
 */

//人物升级公式
function wj_shengji_exp($wj_dj){
    $sj_exp = ceil((($wj_dj-1)*($wj_dj-1)*($wj_dj-1)*65+($wj_dj-1)*40+200)/2);
    return $sj_exp;
}

//人物最高等级
function wj_max_dj(){
    return 100;
}

//玩家闭关经验公式
function wj_biguan_exp($wj_dj,$bg_hour){
    return ceil($wj_dj * 100 * $bg_hour);
}

//VIP对闭关经验加成
function vip_biguan_xishu($cz_jf){
    $jichu_zhi = 5;    //每级vip加成 5%，百分制
    $vip_dj = vip_dj($cz_jf);

    return $vip_dj * $jichu_zhi;
}

//双修对闭关经验加成
function shuangxiu_biguan_xishu($sx_state){
    if($sx_state == 1){
        //普通玩家双修
        return 20;    //20%，百分制
    }else{
        //仙侣双修
        return 50;    //50%，百分制
    }
}

//月卡对闭关经验加成
function yueka_biguan_xishu(){
    return 10;    //10%，百分制
}

//至尊VIP对闭关经验加成
function zhizunvip_biguan_xishu(){
    return 50;    //50%，百分制
}

//耐力恢复的分钟数（多少分钟恢复1点耐力）
function naili_hf_time(){
    return 10;
}

//标准人各等级初始属性
function renwu_shuxing($dj){

    $chushi_gj = 20;
    $chushi_xq = 10;
    $chushi_bj = 12;
    $chushi_rx = 2;
    $chushi_sd = 5;


    $dj_tisheng_bili = 0.2 + (floor($dj/10) * 0.05);  //各阶段提升的比例值
    $bj_tisheng_bili = 0.4;
    $rx_tisheng_bili = 2.4;

    $gj = ceil($chushi_gj+($chushi_gj*$dj_tisheng_bili*($dj-1)));
    $xq = ceil($chushi_xq+($chushi_xq*0.2*($dj-1)));
    $fy = ceil($gj/3);
    $bj = ceil($chushi_bj+$chushi_bj*$bj_tisheng_bili*($dj-1));
    $rx = ceil($chushi_rx+$chushi_rx*$rx_tisheng_bili*($dj-1));
    $hp = ceil(($gj * $xq) / $fy) * 5;

    $sd = ceil($chushi_sd+($chushi_sd*$dj_tisheng_bili*($dj-1)));
    return array($gj,$xq,$fy,$hp,$bj,$rx,$sd);
}

//装备品质提升的属性值
function zhuangbei_pinzhi_bili($zb_pinzhi){
    if($zb_pinzhi == '天绝'){
        return 1.5;
    }elseif($zb_pinzhi == '风雷'){
        return 1.2;
    }else{
        return 1;
    }
}

//装备洗炼所需材料及数量
function zhuangbei_xilian_cailiao(){
    return array('洗练符',1);
}

//装备品质提升
function zhuangbei_pinzhi(){
    return array('真武','风雷','天绝');
}

//从10级开始，增加的天赋点数
function shengji_tianfu_dianshu(){
    return 3;
}

//天赋所附加的属性计算
function tianfu_shuxing_xishu(){
    $gj_xs = 10;
    $xq_xs = 10;
    $fy_xs = 3;
    $hp_xs = 20;
    $sd_xs = 1;
    return array($gj_xs,$xq_xs,$fy_xs,$hp_xs,$sd_xs);
}

//拍卖行手续费
function paimai_shouxufei(){
    return 5;  //百分之五的手续费
}

//拍卖行取消拍卖的冷却时间
function paimai_quxiao_time(){
    return 120;     //120秒后可取消
}

//摇钱树每日总次数及每日免费次数
function yaoqianshu_cs(){
    //每日总次数，免费次数
    return array(10,1);
}

//摇钱树首次消耗仙券的数量及每次递增的数量
function yaoqianshu_xianquan(){
    return array(100,50);
}

//摇钱树掉落的物品id号，几率(百分比,因为是万分之，所以几率在原有基础上乘以100)，数量 (排列顺序按几率从小到大排列)
function yaoqianshu_diaoluo(){
    return array(
        array(1,2000,1),
        array(2,3000,2),
        array(3,4000,3),
        array(4,5000,4),
        array(5,6000,5),
        array(6,10000,6),
    );
}

//竞技场每日可PK次数
function pk_cs(){
    return 10;
}

//竞技场排名积分奖励
function pk_jf($pk_pm){
    if($pk_pm == ''){
        $pk_jf = 0;
    }else{
        if($pk_pm > 100){
            $pk_jf = 1;
        }else{
            $pk_jf = 10 - $pk_pm + 1;
        }
        if($pk_jf <= 0){
            $pk_jf = 1;
        }
    }
    return $pk_jf;
}

//竞技场PK胜利增加的积分
function pk_sl_jf(){
    return 1;
}

//竞技场购买次数所需道具
function pk_gm_cs_daoju(){
    return '天梯挑战卷';
}

//竞技场购买次数消耗钻石数量
function pk_gm_cs_coin($y_gm_cs){
    $start = 100;    //消耗钻石初始值
    $add_bs = 1;    //新增每次增加的倍数
    return $start + $start * $add_bs * $y_gm_cs;
}

//创建帮派所需道具
function bp_create_daoju(){
    return '帮派令';
}

//帮派每级可容纳的人数
function bp_max_wj($bp_dj){
    if($bp_dj == 1){
        $max_wj = 20;
    }elseif($bp_dj == 2){
        $max_wj = 30;
    }elseif($bp_dj == 3){
        $max_wj = 40;
    }elseif($bp_dj == 4){
        $max_wj = 50;
    }elseif($bp_dj == 5){
        $max_wj = 60;
    }else{
        $max_wj = 60;
    }
    return $max_wj;
}

//副本打怪扣除体力
function fuben_tl($fb_jieduan){
    if($fb_jieduan == 4){
        return 2;   //副本boss扣除体力2
    }else{
        return 1;   //副本小怪扣除体力1
    }
}

//玩家斗法扣除体力
function wj_doufa_tl(){
    return 6;
}

//vip各等级的值
function vip_dj($cz_jf){
    if($cz_jf >= 2020){
        $vip = 12;
    }elseif($cz_jf >= 1600){
        $vip = 11;
    }elseif($cz_jf >= 1200){
        $vip = 10;
    }elseif($cz_jf >= 820){
        $vip = 9;
    }elseif($cz_jf >= 460){
        $vip = 8;
    }elseif($cz_jf >= 320){
        $vip = 7;
    }elseif($cz_jf >= 200){
        $vip = 6;
    }elseif($cz_jf >= 100){
        $vip = 5;
    }elseif($cz_jf >= 50){
        $vip = 4;
    }elseif($cz_jf >= 20){
        $vip = 3;
    }elseif($cz_jf >= 10){
        $vip = 2;
    }elseif($cz_jf >= 1){
        $vip = 1;
    }else{
        $vip = 0;
    }
    return $vip;
}

//VIP每级增加的体力上限及每日可恢复次数上限
function vip_nlsx_hfcs($vip_dj){
    $nl_sx = 10;    //每级VIP增加的耐力上限
    $hf_cs = 5;     //每级VIP每日可恢复的耐力次数

    $z_nl_sx = $nl_sx * $vip_dj;
    $z_hf_cs = $hf_cs * $vip_dj;

    return array($z_nl_sx,$z_hf_cs,$nl_sx,$hf_cs);
}

//默认耐力丹每日可使用次数
function naili_cishu(){
    return 40;
}

//恢复耐力的id号及道具名称、恢复的值
function naili_huifu_daoju(){
    return array(
        array(0,'耐力丹',10),
        array(1,'大耐力丹',30),
    );
}

//技能升级所耗材料
function skill_shengji_cailiao($skill_id){
    if($skill_id == 101){
        return array(
            '2|money,100|wp,1,1|wp,2,1|wp,3,1',
            '3|money,200|wp,1,2|wp,2,2|wp,3,2',
        );
    }elseif($skill_id == 102){
        return array(
            '2|money,300|wp,4,1|wp,5,1|wp,6,1',
            '3|money,400|wp,4,2|wp,5,2|wp,6,2',
        );
    }elseif($skill_id == 103){
        return array(
            '2|money,500|wp,7,1|wp,8,1|wp,9,1',
            '3|money,600|wp,7,2|wp,8,2|wp,9,2',
        );
    }else{
        return 0;
    }
}

//装备淬炼消耗的物品名称
function zb_cl_name(){
    return '五行石';
}

//装备淬炼消耗的物品数量
function zb_cl_sl($cl_dj){
    $xh_sl = ceil($cl_dj/10);
    if($xh_sl <= 0){
        $xh_sl = 1;
    }
    return $xh_sl;
}

//装备淬炼星值增幅的属性
function zb_cl_sx($cl_sx,$cl_dj){
    if($cl_sx == 'gj'){
        $sx_zhi = 3;
    }elseif($cl_sx == 'fy'){
        $sx_zhi = 1;
    }elseif($cl_sx == 'hp'){
        $sx_zhi = 20;
    }elseif($cl_sx == 'xq'){
        $sx_zhi = 2;
    }elseif($cl_sx == 'sd'){
        $sx_zhi = 1;
    }

    return $sx_zhi * $cl_dj;
}

//宝石合成的最大等级
function baoshi_max_dj(){
    return 9;
}

//宝石合成的属性种类
function baoshi_zhonglei(){
    return array('攻击','防御','仙气','生命','暴击','韧性','速度');
}

//宝石合成高等级所需的数量
function baoshi_hcsl(){
    return 5;
}

//装备开孔消耗的道具
function zb_kk_daoju(){
    return '开孔符';
}

//装备开孔消耗的道具数量
function zb_kk_daoju_sl($kw){
    if($kw == 1){
        $sl = 1;
    }elseif($kw == 2){
        $sl = 2;
    }elseif($kw == 3){
        $sl = 4;
    }elseif($kw == 4){
        $sl = 8;
    }elseif($kw == 5){
        $sl = 16;
    }elseif($kw == 6){
        $sl = 32;
    }elseif($kw == 7){
        $sl = 64;
    }elseif($kw == 8){
        $sl = 128;
    }elseif($kw == 9){
        $sl = 256;
    }elseif($kw == 10){
        $sl = 512;
    }else{
        $sl = 99999999999;
    }
    return $sl;
}

//装备开孔成功率
function zb_kk_cgl($kw){
    if($kw == 1){
        $cgl = 100;
    }elseif($kw == 2){
        $cgl = 90;
    }elseif($kw == 3){
        $cgl = 80;
    }elseif($kw == 4){
        $cgl = 70;
    }elseif($kw == 5){
        $cgl = 60;
    }elseif($kw == 6){
        $cgl = 50;
    }elseif($kw == 7){
        $cgl = 40;
    }elseif($kw == 8){
        $cgl = 30;
    }elseif($kw == 9){
        $cgl = 20;
    }elseif($kw == 10){
        $cgl = 10;
    }else{
        $cgl = 0;
    }
    return $cgl;
}

//装备开孔增加成功率的道具和几率
function zb_kk_xyc(){
    return array('幸运草','5');
}

//签到奖励的物品id及数量（用|隔开表示多个物品）
function qiandao_jiangli(){
    //格式为 当月的第几号，物品id，数量，下一轮
    return array(
        array('1','1,1|2,1|3,1|4,1'),
        array('2','1,1|2,1|3,1|4,1'),
        array('3','1,1|2,1|3,1|4,1'),
        array('4','1,1|2,1|3,1|4,1'),
        array('5','1,1|2,1|3,1|4,1'),
        array('6','1,1|2,1|3,1|4,1'),
        array('7','1,1|2,1|3,1|4,1'),
        array('8','1,1|2,1|3,1|4,1'),
        array('9','1,1|2,1|3,1|4,1'),
        array('10','1,1|2,1|3,1|4,1'),
        array('11','1,1|2,1|3,1|4,1'),
        array('12','1,1|2,1|3,1|4,1'),
        array('13','1,1|2,1|3,1|4,1'),
        array('14','1,1|2,1|3,1|4,1'),
        array('15','1,1|2,1|3,1|4,1'),
        array('16','1,1|2,1|3,1|4,1'),
        array('17','1,1|2,1|3,1|4,1'),
        array('18','1,1|2,1|3,1|4,1'),
        array('19','1,1|2,1|3,1|4,1'),
        array('20','1,1|2,1|3,1|4,1'),
        array('21','1,1|2,1|3,1|4,1'),
        array('22','1,1|2,1|3,1|4,1'),
        array('23','1,1|2,1|3,1|4,1'),
        array('24','1,1|2,1|3,1|4,1'),
        array('25','1,1|2,1|3,1|4,1'),
        array('26','1,1|2,1|3,1|4,1'),
        array('27','1,1|2,1|3,1|4,1'),
        array('28','1,1|2,1|3,1|4,1'),
        array('29','1,1|2,1|3,1|4,1'),
        array('30','1,1|2,1|3,1|4,1'),
        array('31','1,1|2,1|3,1|4,1')
    );
}

//每月签到补签次数
function qiandao_bq_cs(){
    return 5;
}

//每月签到补签消耗的基本仙券(每次都增加该值)
function qiandao_bq_xq(){
    return 100;
}

//开通月卡需要消耗的道具名称
function yueka_daoju(){
    return '月卡';
}

//月卡每日领取的道具名称
function yueka_jiangli(){
    return "money,100|wp,1,1|wp,2,1|wp,3,1";
}

//至尊VIP开通奖励的道具名称
function zzvip_jiangli(){
    return "money,10000|coin,200|wp,4,1|wp,5,1|wp,6,1";
}

//至尊VIP开通需要消耗的道具名称
function zzvip_daoju(){
    return '至尊卡';
}

//至尊vip属性增幅
function zzvip_shuxing(){
    return "gj,100|fy,20|hp,500";
}

//战力测定评分设定
function zhanli_pingfen($gj,$xq,$fy,$hp,$sd,$bj,$rx){
    $gj_xs = 0.7;
    $xq_xs = 0.7;
    $fy_xs = 0.3;
    $hp_xs = 0.5;
    $sd_xs = 0.1;
    $bj_xs = 0.3;
    $rx_xs = 0.2;

    return ceil($gj * $gj_xs + $xq * $xq_xs + $fy * $fy_xs + $hp * $hp_xs + $sd * $sd_xs + $bj * $bj_xs + $rx * $rx_xs);
}

//斗法限制双方等级差距
function doufa_dj_chaju(){
    return 5;
}

//相同玩家每日可被斗法次数
function doufa_wj_cs(){
    return 3;
}

//送花消耗的道具名称
function songhua_daoju(){
    return '玫瑰';
}

//送花获得功勋数
function songhua_gongxun(){
    return 1;
}

//结婚的开放等级
function jiehun_dj(){
    return 15;
}

//结婚所需的亲密度
function jiehun_qinmidu(){
    return 100;
}

//婚戒的属性加成
function jiezhi_shuxing($jiezhi_name,$jiezhi_dj){
    if($jiezhi_dj == 1){
        $gj = 10; $fy = 10; $hp = 10;
        $sd = 10; $bj = 10; $rx = 10;
        $xq = 10;
    }elseif($jiezhi_dj == 2){
        $gj = 20; $fy = 20; $hp = 20;
        $sd = 20; $bj = 20; $rx = 20;
        $xq = 20;
    }elseif($jiezhi_dj == 3){
        $gj = 30; $fy = 30; $hp = 30;
        $sd = 30; $bj = 30; $rx = 30;
        $xq = 30;
    }elseif($jiezhi_dj == 4){
        $gj = 40; $fy = 40; $hp = 40;
        $sd = 40; $bj = 40; $rx = 40;
        $xq = 40;
    }else{
        $gj = 40; $fy = 40; $hp = 40;
        $sd = 40; $bj = 40; $rx = 40;
        $xq = 40;
    }

    if($jiezhi_name == '草戒'){
        $bili = 1;
    }elseif($jiezhi_name == '金戒指'){
        $bili = 1.5;
    }elseif($jiezhi_name == '钻石戒指'){
        $bili = 2;
    }

    $gj = ceil($gj * $bili); $fy = ceil($fy * $bili); $hp = ceil($hp * $bili);
    $sd = ceil($sd * $bili); $bj = ceil($bj * $bili); $rx = ceil($rx * $bili);
    $xq = ceil($xq * $bili);

    return array($gj,$fy,$xq,$hp,$bj,$rx,$sd);
}

//婚戒升级所需消耗材料
function jiezhi_shengji_cailiao($jiezhi_name,$jiezhi_dj){
    if($jiezhi_name == '草戒'){
        if($jiezhi_dj == 1){
            $xiaohao_cailiao = array(
                'eaz,100',
                'wp,32,10'
            );
        }elseif($jiezhi_dj == 2){
            $xiaohao_cailiao = array(
                'eaz,200',
                'wp,32,20'
            );
        }elseif($jiezhi_dj == 3){
            $xiaohao_cailiao = array(
                'eaz,300',
                'wp,32,30'
            );
        }elseif($jiezhi_dj == 4){
            $xiaohao_cailiao = array(
                'eaz,400',
                'wp,32,40'
            );
        }elseif($jiezhi_dj == 5){
            $xiaohao_cailiao = array(
                'eaz,500',
                'wp,32,50'
            );
        }else{
            $xiaohao_cailiao = 0;
        }
    }elseif($jiezhi_name == '金戒指'){
        if($jiezhi_dj == 1){
            $xiaohao_cailiao = array(
                'eaz,100',
                'wp,32,10'
            );
        }elseif($jiezhi_dj == 2){
            $xiaohao_cailiao = array(
                'eaz,200',
                'wp,32,20'
            );
        }elseif($jiezhi_dj == 3){
            $xiaohao_cailiao = array(
                'eaz,300',
                'wp,32,30'
            );
        }elseif($jiezhi_dj == 4){
            $xiaohao_cailiao = array(
                'eaz,400',
                'wp,32,40'
            );
        }elseif($jiezhi_dj == 5){
            $xiaohao_cailiao = array(
                'eaz,500',
                'wp,32,50'
            );
        }else{
            $xiaohao_cailiao = 0;
        }
    }elseif($jiezhi_name == '钻石戒指'){
        if($jiezhi_dj == 1){
            $xiaohao_cailiao = array(
                'eaz,100',
                'wp,32,10'
            );
        }elseif($jiezhi_dj == 2){
            $xiaohao_cailiao = array(
                'eaz,200',
                'wp,32,20'
            );
        }elseif($jiezhi_dj == 3){
            $xiaohao_cailiao = array(
                'eaz,300',
                'wp,32,30'
            );
        }elseif($jiezhi_dj == 4){
            $xiaohao_cailiao = array(
                'eaz,400',
                'wp,32,40'
            );
        }elseif($jiezhi_dj == 5){
            $xiaohao_cailiao = array(
                'eaz,500',
                'wp,32,50'
            );
        }else{
            $xiaohao_cailiao = 0;
        }
    }
    return $xiaohao_cailiao;
}

//离婚所需消耗道具
function lihun_daoju(){
    return '一纸休书';
}

//双修亲密度所需的值
function shuangxiu_qinmidu(){
    return 60;
}

//挖宝消耗道具
function wabao_daoju(){
    return '藏宝图';
}

//挖宝每层固定次数
function wabao_gdcishu(){
    return 3;
}

//月卡额外挖宝次数
function wabao_ykcishu(){
    return 2;
}

//至尊卡额外挖宝次数
function wabao_zzcishu(){
    return 5;
}

//vip每级增加的挖宝次数
function wabao_vipcishu(){
    return 2;
}
?>