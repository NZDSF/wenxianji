<?php
/**
 * Author: by suxin
 * Date: 2019/12/01
 * Time: 15:24
 * Note: 页面数据分页功能
 */

require_once "../include/fzr.php";

//这是一个用于保存分页信息的类
class FenyePage{
    public $pageSize=6;     //每页要显示的数据记录条数
    public $res_array;	     //这是显示数据
    public $rowCount;	     //这是从数据库中获取
    public $pageNow=1;	     //用户指定的
    public $pageCount;	     //这个是计算得到的
    public $navigate;	     //分页导航
    public $gotoUrl;	     //表示把分页请求提交给哪个页面
    public $leibie;		//用户指定的，表示物品的种类
}

//世界通告记录查询
function getFenyePage_sjtg($fenyePage,$dh_fl){
    require_once '../include/SqlHelper.class.php';
    $sqlHelper=new SqlHelper();
    $sql1="select s_name,s_name1,message,message1,xx_leixin,times from (select s_name,s_name1,message,message1,xx_leixin,times from s_gonggao order by num desc limit 200) as tmp limit "
        .($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;;

    $sql2="select count(num) from s_gonggao";
    $sqlHelper->exectue_dql_fenye_bag($sql1,$sql2,$fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//个人动态记录查询
function getFenyePage_wjdt($fenyePage,$dh_fl){
    require_once '../include/SqlHelper.class.php';
    $sqlHelper=new SqlHelper();
    $sql1="select s_name,s_name1,message,xx_lx,times from (select s_name,s_name1,message,xx_lx,times from s_wj_dongtai where s_name='$_SESSION[id]' order by num desc limit 200) as tmp limit "
        .($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;;

    $sql2="select count(num) from s_wj_dongtai where s_name='$_SESSION[id]'";
    $sqlHelper->exectue_dql_fenye_bag($sql1,$sql2,$fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//世界聊天记录查询
function getFenyePage_chat($fenyePage,$dh_fl){
    require_once '../include/SqlHelper.class.php';
    $sqlHelper=new SqlHelper();
    $sql1="select s_name,message,times,zb_num from (select s_name,message,times,zb_num from s_wj_talk order by num desc limit 200) as tmp limit "
        .($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;;

    $sql2="select count(num) from s_wj_talk";
    $sqlHelper->exectue_dql_fenye_bag($sql1,$sql2,$fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//私聊记录查询
function getFenyePage_siliao($fenyePage,$dh_fl){
    require_once '../include/SqlHelper.class.php';
    $sqlHelper=new SqlHelper();
    $sql1="select num,s_name,s_name1,message,times,xx_leixin from (select num,s_name,s_name1,message,yd_state,times,xx_leixin from s_wj_siliao where s_name='$_SESSION[id]' or s_name1='$_SESSION[id]' order by num desc limit 200) as tmp limit "
        .($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;;

    $sql2="select count(num) from s_wj_siliao where s_name='$_SESSION[id]' or s_name1='$_SESSION[id]'";
    $sqlHelper->exectue_dql_fenye_bag($sql1,$sql2,$fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//背包物品查询
function getFenyePage_bag($fenyePage,$bag_url_fl,$bag_fenlei)
{
    require_once '../include/SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    if($bag_fenlei == 'zb'){
        $sql1 = "select zb_pinzhi,zb_dj,zb_name,num from s_wj_zhuangbei where zb_used=0 and s_name='$_SESSION[id]' order by num desc  limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_wj_zhuangbei where zb_used=0 and s_name='$_SESSION[id]'";
    }else{
        $sql1 = "select wp_name,num,wp_counts from s_wj_bag where wp_fenlei='$bag_fenlei' and s_name='$_SESSION[id]' order by num desc  limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_wj_bag where wp_fenlei='$bag_fenlei' and s_name='$_SESSION[id]'";
    }


    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$bag_url_fl);
    $sqlHelper->close_connect();
}

//好友列表查询
function getFenyePage_friends($fenyePage,$dh_fl)
{
    require_once '../include/SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    $sql1 = "select df_num from s_wj_friends where s_name='$_SESSION[id]' order by num desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_wj_friends where s_name='$_SESSION[id]'";


    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//可双修的好友列表查询
function getFenyePage_friends_shuangxiu($fenyePage,$dh_fl,$shuangxiu_qinmidu)
{
    require_once '../include/SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    $sql1 = "select df_num from s_wj_friends where s_name='$_SESSION[id]' and qinmidu >= $shuangxiu_qinmidu order by num desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_wj_friends where s_name='$_SESSION[id]' and qinmidu >= $shuangxiu_qinmidu";


    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//称号列表查询
function getFenyePage_chenghao($fenyePage,$dh_fl)
{
    require_once '../include/SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    if($dh_fl == 'q'){
        $ch_fl = 'pt';
    }elseif($dh_fl == 'w'){
        $ch_fl = 'hd';
    }

    $sql1 = "select num,ch_name from s_chenghao_all where ch_fl='$ch_fl' order by num desc  limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_chenghao_all where ch_fl='$ch_fl'";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//排行列表查询
function getFenyePage_rankd($fenyePage,$dh_fl)
{
    require_once '../include/SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    if($dh_fl == 'q'){
        $sql1 = "select num,s_name,g_name,dj from s_user where dj>1 and robot=0 order by dj desc,exp desc,dj_up_time desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_user where dj>1 and robot=0";
    }elseif($dh_fl == 'w'){
        $sql1 = "select num,s_name,g_name,money from s_user where money>0 and robot=0 order by money desc,dj desc,exp desc,dj_up_time desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_user where money>0 and robot=0";
    }elseif($dh_fl == 'e'){
        $sql1 = "select num,s_name,g_name,df_sl from s_user where df_sl>0 and robot=0 order by df_sl desc,dj desc,exp desc,dj_up_time desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_user where df_sl>0 and robot=0";
    }elseif($dh_fl == 'r'){
        $sql1 = "select num,s_name,g_name,ch_jf from s_user where ch_jf>0 and robot=0 order by ch_jf desc,dj desc,exp desc,dj_up_time desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_user where ch_jf>0 and robot=0";
    }elseif($dh_fl == 't'){
        $sql1 = "select num,s_name,g_name,zhanli from s_user where zhanli>0 and robot=0 order by zhanli desc,dj desc,exp desc,dj_up_time desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_user where zhanli>0 and robot=0";
    }elseif($dh_fl == 'y'){
        $sql1 = "select num,s_name,g_name,pk_zjf from s_user where pk_zjf>0 and robot=0 order by pk_zjf desc,dj desc,exp desc,dj_up_time desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_user where pk_zjf>0 and robot=0";
    }elseif($dh_fl == 'u'){
        if ($_SERVER["QUERY_STRING"]) {
            global $key_url_md_5;
            $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                if($gn_fl == 1){
                    $sql1 = "select num,s_name,g_name,songhb_week from s_user where songhb_week>0 and robot=0 order by songhb_week desc,dj desc,exp desc,dj_up_time desc limit
                    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

                    $sql2 = "select count(num) from s_user where songhb_week>0 and robot=0";
                }else{
                    $sql1 = "select num,s_name,g_name,songhb from s_user where songhb>0 and robot=0 order by songhb desc,dj desc,exp desc,dj_up_time desc limit
                    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

                    $sql2 = "select count(num) from s_user where songhb>0 and robot=0";
                }
            }
        }
    }elseif($dh_fl == 'i'){
        if ($_SERVER["QUERY_STRING"]) {
            global $key_url_md_5;
            $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                if($gn_fl == 1){
                    $sql1 = "select num,s_name,g_name,shouhb_week from s_user where shouhb_week>0 and robot=0 order by shouhb_week desc,dj desc,exp desc,dj_up_time desc limit
                    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

                    $sql2 = "select count(num) from s_user where shouhb_week>0 and robot=0";
                }else{
                    $sql1 = "select num,s_name,g_name,shouhb from s_user where shouhb>0 and robot=0 order by shouhb desc,dj desc,exp desc,dj_up_time desc limit
                    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

                    $sql2 = "select count(num) from s_user where shouhb>0 and robot=0";
                }
            }
        }
    }


    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//拍卖行上架的物品列表查询（去重）
function getFenyePage_paimai_shangjia($fenyePage,$pm_wp_zfl,$dh_fl)
{

    require_once 'SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();
    $now_time = date("Y-m-d H:i:s");

    if($pm_wp_zfl == 'wp' || $pm_wp_zfl == 'bs' || $pm_wp_zfl == 'ch' || $pm_wp_zfl == 'lb'){
        $sql1 = "select distinct wp_num from s_wj_paimai where wp_zfl='$pm_wp_zfl' and wp_expire_time>'$now_time' and wp_money !='' order by num desc  limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;
        $sql2 = "select count(distinct wp_num) from s_wj_paimai where wp_zfl='$pm_wp_zfl' and wp_expire_time>'$now_time' and wp_money !=''";
    }

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//可被拍卖的背包物品列表查询
function getFenyePage_bag_paimai($fenyePage,$bag_fenlei,$dh_fl)
{
    require_once 'SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    if($bag_fenlei == "wp" || $bag_fenlei == "bs" || $bag_fenlei == "ch" || $bag_fenlei == "lb"){
        $sql1 = "select wp_name,num,wp_counts from s_wj_bag where wp_fenlei='$bag_fenlei' and s_name='$_SESSION[id]' and wp_bd=0 order by num asc  limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_wj_bag where wp_fenlei='$bag_fenlei' and s_name='$_SESSION[id]'  and wp_bd=0";
    }

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//拍卖行上架的物品列表查询（某个物品的所有列表）
function getFenyePage_paimai_one_list($fenyePage,$wp_num,$dh_fl)
{
    require_once 'SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();
    $now_time = date("Y-m-d H:i:s");

    $sql1 = "select num,wp_money,wp_counts from s_wj_paimai where wp_num='$wp_num' and wp_expire_time>'$now_time' and wp_money !='' order by wp_money asc  limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;
    $sql2 = "select count(num) from s_wj_paimai where wp_num='$wp_num' and wp_expire_time>'$now_time' and wp_money !=''";

    $sqlHelper->exectue_dql_fenye_pm_wplist($sql1, $sql2, $fenyePage,$dh_fl,$wp_num);
    $sqlHelper->close_connect();
}

//邮箱列表查询
function getFenyePage_youxiang($fenyePage,$dh_fl,$yx_fenlei)
{
    require_once '../include/SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    if($yx_fenlei == 1){
        $sql1 = "select num,yx_leixin,yx_biaoti from s_wj_youxiang where s_name='$_SESSION[id]' and dq_state=0 order by num desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_wj_youxiang where s_name='$_SESSION[id]' and dq_state=0";
    }else{
        $sql1 = "select num,yx_leixin,yx_biaoti from s_wj_youxiang where s_name='$_SESSION[id]' and dq_state=1 order by num desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

        $sql2 = "select count(num) from s_wj_youxiang where s_name='$_SESSION[id]' and dq_state=1";
    }

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//玩家已上架拍卖的列表查询
function getFenyePage_wj_pm($fenyePage,$dh_fl)
{
    require_once '../include/SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    $sql1 = "select num,wp_num,wp_counts,wp_money from s_wj_paimai where s_name='$_SESSION[id]' order by num desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_wj_paimai where s_name='$_SESSION[id]'";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//商城物品查询
function getFenyePage_shop($fenyePage,$bag_url_fl,$bag_fenlei)
{
    require_once '../include/SqlHelper.class.php';
    //创建一个SqlHelper对象实例
    $sqlHelper = new SqlHelper();

    $sql1 = "select wp_name,num,wp_coin from s_wupin_all where wp_shop=1 and wp_coin !='' and wp_shop_fl='$bag_fenlei' order by num desc limit
		" . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_wupin_all where wp_shop=1 and wp_coin !='' and wp_shop_fl='$bag_fenlei'";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$bag_url_fl);
    $sqlHelper->close_connect();
}

//竞技场排名查询
function getFenyePage_pk($fenyePage,$dh_fl)
{
    require_once '../include/SqlHelper.class.php';

    $sqlHelper = new SqlHelper();

    $sql1 = "select num,s_name,g_name,dj,pk_pm,robot from s_user where pk_pm !='' order by pk_pm asc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_user where pk_pm !=''";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//竞技场积分兑换列表查询
function getFenyePage_pk_duihuan($fenyePage,$dh_fl)
{
    require_once '../include/SqlHelper.class.php';

    $sqlHelper = new SqlHelper();

    $sql1 = "select num,wp_id,xh_jf from s_pk_duihuan order by num asc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_pk_duihuan";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//帮派列表大全查询
function getFenyePage_bp($fenyePage,$dh_fl)
{
    require_once '../include/SqlHelper.class.php';

    $sqlHelper = new SqlHelper();

    $sql1 = "select num,bp_name,bp_dj from s_bangpai_all order by bp_dj desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_bangpai_all";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//帮派入帮申请列表大全查询
function getFenyePage_bp_sq($fenyePage,$dh_fl,$bp_num)
{
    require_once '../include/SqlHelper.class.php';

    $sqlHelper = new SqlHelper();

    $sql1 = "select num,s_name from s_bangpai_sq where bp_num='$bp_num' order by times desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_bangpai_sq where bp_num='$bp_num'";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//帮派成员列表列表大全查询
function getFenyePage_bp_wj($fenyePage,$dh_fl,$bp_name)
{
    require_once '../include/SqlHelper.class.php';

    $sqlHelper = new SqlHelper();

    $sql1 = "select num,s_name,g_name,dj,bangpai_zw from s_user where bangpai='$bp_name' order by bangpai_zw asc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_user where bangpai='$bp_name'";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//兑换列表大全查询
function getFenyePage_dh($fenyePage,$dh_fl)
{
    require_once '../include/SqlHelper.class.php';

    $sqlHelper = new SqlHelper();

    $sql1 = "select num,dh_wp from s_duihuan_all order by num desc limit
    " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . "," . $fenyePage->pageSize;

    $sql2 = "select count(num) from s_duihuan_all";

    $sqlHelper->exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

?>