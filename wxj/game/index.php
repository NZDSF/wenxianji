<?php
/**
 * Author: by suxin
 * Date: 2019/12/01
 * Time: 15:24
 * Note: 游戏主页
 */

require_once '../include/fzr.php';
require_once '../include/func.php';
require_once '../control/control.php';

$sqlHelper = new SqlHelper();
$sql = "select g_name,sy_nl,z_nl,dj,exp,jingjie,cz_jf,xl_stop_time,zhizun_vip,xianlv,yueka_stop_time from s_user where s_name='$_SESSION[id]'";
$res = $sqlHelper->execute_dql($sql);
$sqlHelper->close_connect();

$wj_shengji_exp = wj_shengji_exp($res["dj"]);

$jiami1 = 'x=q';
$url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
$jiami2 = 'x=w';
$url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
$jiami3 = 'x=p';
$url3 = encrypt_url("$jiami3.$date",$key_url_md_5);
$jiami4 = 'x=a';
$url4 = encrypt_url("$jiami4.$date",$key_url_md_5);
$jiami5 = 'x=f';
$url5 = encrypt_url("$jiami5.$date",$key_url_md_5);
$jiami6 = 'x=e';
$url6 = encrypt_url("$jiami6.$date",$key_url_md_5);
$jiami7 = 'x=g';
$url7 = encrypt_url("$jiami7.$date",$key_url_md_5);
$jiami8 = 'x=u';
$url8 = encrypt_url("$jiami8.$date",$key_url_md_5);
$jiami9 = 'x=r';
$url9 = encrypt_url("$jiami9.$date",$key_url_md_5);
echo "<a href='http://jy.dyhsbj.cn'><img src='../images/home.jpg'/>家园</a>&nbsp;&nbsp;";
echo "<a href='http://jy.dyhsbj.cn'><img src='../images/message.jpg'/>(1)</a>&nbsp;&nbsp;";
echo "<a href='http://jy.dyhsbj.cn'><img src='../images/chat.gif'/>好友</a>&nbsp;&nbsp;";
echo "<a href='http://jy.dyhsbj.cn'><img src='../images/sign.jpg'/>论坛</a><br>";

echo "<div><a href='../user/fuben.php?$url1'>活动</a>  |  <a href='../xy/chat.php?$url6'>聊天</a> | <a href='../xy/bp.php?$url1'>群修</a> | <a href='../user/hy.php?$url2'>仙友</a> | <a href='../../index.php?out'>退出</a></div>";
echo "<div><img src='../images/laba.gif'/><a href='http://jy.dyhsbj.cn'>签到仙币免费领</a></div>";
echo "<div><img src='../images/laba.gif'/><a href='http://jy.dyhsbj.cn'>内测冲榜公测送豪礼</a></div>";
echo "<a href='../user/renwu.php?$url1'>任务</a>每日任务0/9 ";
echo "<img src='../images/tan.gif' /> <a href='../user/qd.php?$url1'>签到</a><br>";

echo '<br/>';

echo "<div><a href='../user/fuben.php?$url1'>副本</a> | <a href='../xy/ct.php?$url1'>闯塔</a> | <a href='../xy/df.php?$url1'>斗法</a> | <img src='../images/tan.gif' /> <a href='../user/yqs.php?$url1'>摇钱树</a></div>";
echo "<div><a href='../user/mishi.php?$url7'>密室</a> | <a href='../xy/pm.php?$url1'>拍卖</a> | <a href='../xy/pk.php?$url1'>竞技</a> | 护送</div>";

echo "<div>昵称: ";

echo "<a href='../user/info.php?$url1'>" .$res["g_name"]."</a> ";

if ($res["zhizun_vip"]) {
    echo '<img class="tx_img" src="../images/zz.gif">';
    echo '<img class="tx_img" src="../images/yk.gif">';
} else {
    $now_time = date("Y-m-d H:i:s");
    if ($now_time < $res["yueka_stop_time"]) {
        echo '<img class="tx_img" src="../images/yk.gif">';
    }
}
if ($res["cz_jf"]) {
    echo '<img class="tx_img" src="../images/vip.gif">';
}
if ($res["xianlv"]) {
    echo '<img class="tx_img" src="../images/xl.gif">';
}

$vip_dj = vip_dj($res["cz_jf"]);
if($vip_dj){
    //echo ' V'.$vip_dj.' ';
}

echo '('.$res["dj"]."级 . <a href='../user/info.php?$url3'>".$res["jingjie"]."</a>)</div>";
echo '<div>灵气: '.$res["exp"].'/'.$wj_shengji_exp;
if($res["exp"] >= $wj_shengji_exp){
    echo " <a href='../user/info.php?$url4'>升级</a> <img src='../images/shengji.gif'>";
}
echo '</div>';


$vip_nlsx_hfcs = vip_nlsx_hfcs($vip_dj);

$wj_znl = $res["z_nl"] + $vip_nlsx_hfcs[0];

$nl_show_time = nl_show_time($vip_nlsx_hfcs[0]);

echo '<div>耐力: '.($res["sy_nl"] + $nl_show_time[1]).'/'.$wj_znl;
if($nl_show_time[0]){
    echo " <a href='../user/info.php?$url5'>恢复</a>(".$nl_show_time[0]."后恢复1点)";
}
echo '</div>';
echo "<div><a href='../user/info.php?$url2'>锻造</a> | ";
//echo "<a href='../user/info.php?$url7'>仙术</a> | ";

echo "元神 | 熔炼</div>";

//echo '<br/>';

echo "<div> <a href='../xy/vip.php?$url8'>充值</a>  | <a href='../xy/vip.php?$url8'>VIP特权</a> | VIP礼包</div><br>";


echo "<div style='margin-top: 5px;'><div><img src='../images/laba.gif'/><a href='../xy/chat.php?$url1'>世界</a> |";

$sqlHelper = new SqlHelper();
$sql = "select num from s_wj_siliao where s_name1='$_SESSION[id]' and yd_state=0";
$res = $sqlHelper->execute_dql($sql);
$sqlHelper->close_connect();
if($res){
    echo " <img src='../images/tan.gif'/>";
}

echo " <a href='../xy/chat.php?$url6'>私聊</a> | ";
echo "<a href='../xy/chat.php?$url9'>动态</a></div>";
wjdt_show_fenye('',1,0,0);
xtgg_show_fenye('',1,0,0);
chat_show_fenye('',2,0,0);

//echo '<br/>';

//获取未读邮件的数量
$sqlHelper = new SqlHelper();
$sql = "select count(num) from s_wj_youxiang where s_name='$_SESSION[id]' and dq_state=0";
$res = $sqlHelper->execute_dql($sql);
$wd_sl = $res["count(num)"];
$sqlHelper->close_connect();

echo "<div><a href='../user/info.php?$url2'>装备</a> | <a href='../user/bag.php?$url1'>背包</a> | <a href='../xy/shop.php?$url1'>商城</a> | <a href='../user/yx.php?$url1'>邮箱</a>";
if($wd_sl){
    echo '('.$wd_sl.')';
}
echo "</div>";
echo "<div><a href='../xy/xl.php?$url1'>仙侣</a> | <a href='../xy/rank.php?$url1'>排行</a> | <a href='../xy/dh.php?$url1'>兑换</a> | <a href='../xy/xl.php?$url1'>客服</a></div>";

?>

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2019/1/4
 * Time: 11:51
 */



$date=(date('H:i'));
echo "游玩WAP社区版权©";
echo "<div><a href='../game/index.php'>返回游戏首页</a></div>";
echo "QQ报时:(".$date.")";

?>