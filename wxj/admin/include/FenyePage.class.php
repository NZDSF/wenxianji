<?php
/*
==========
=页面数据分页功能
=公元2020年01月15日
==========
*/

//这是一个用于保存分页信息的类
class FenyePage{
    public $pageSize=6;	//每页要显示的数据记录条数
    public $res_array;	//这是显示数据
    public $rowCount;	//这是从数据库中获取
    public $pageNow=1;	//用户指定的
    public $pageCount;	//这个是计算得到的
    public $navigate;	//分页导航
    public $gotoUrl;	//表示把分页请求提交给哪个页面
    public $leibie;		//用户指定的，表示物品的种类
}


//物品列表查询
function getFenyePage_wp($fenyePage,$dh_fl){
    $sqlHelper=new SqlHelper();
    $sql1="select num,wp_name,wp_coin,wp_shop from s_wupin_all order by num desc limit
		".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;

    $sql2="select count(num) from s_wupin_all";
    $sqlHelper->exectue_dql_fenye_bag($sql1,$sql2,$fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//物品列表查询(针对箱子增加物品)
function getFenyePage_wp_xiangzi($fenyePage,$dh_fl,$xiangzi_num){
    $sqlHelper=new SqlHelper();
    $sql1="select num,wp_name from s_wupin_all order by num desc limit
		".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;

    $sql2="select count(num) from s_wupin_all";
    $sqlHelper->exectue_dql_fenye_pm_wplist($sql1,$sql2,$fenyePage,$dh_fl,$xiangzi_num);
    $sqlHelper->close_connect();
}

//怪物列表查询
function getFenyePage_gw($fenyePage,$dh_fl){
    $sqlHelper=new SqlHelper();
    $sql1="select num,gw_name,gw_dj from s_guaiwu_all order by num desc limit
		".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;

    $sql2="select count(num) from s_guaiwu_all";
    $sqlHelper->exectue_dql_fenye_bag($sql1,$sql2,$fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//怪物列表查询(针对后台大雁塔)
function getFenyePage_gw_dyt($fenyePage,$dh_fl,$ta_ceng){
    $sqlHelper=new SqlHelper();
    $sql1="select num,gw_name,gw_dj from s_guaiwu_all order by num desc limit
		".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;

    $sql2="select count(num) from s_guaiwu_all";
    $sqlHelper->exectue_dql_fenye_pm_wplist($sql1,$sql2,$fenyePage,$dh_fl,$ta_ceng);
    $sqlHelper->close_connect();
}

//物品列表查询(针对后台大雁塔)
function getFenyePage_wp_dyt($fenyePage,$dh_fl,$ta_ceng){
    $sqlHelper=new SqlHelper();
    $sql1="select num,wp_name from s_wupin_all order by num desc limit
		".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;

    $sql2="select count(num) from s_wupin_all";
    $sqlHelper->exectue_dql_fenye_pm_wplist($sql1,$sql2,$fenyePage,$dh_fl,$ta_ceng);
    $sqlHelper->close_connect();
}

//大副本列表查询
function getFenyePage_fb_name1($fenyePage,$dh_fl){
    $sqlHelper=new SqlHelper();
    $sql1="select num,fb_name,fb_min_dj,fb_max_dj from s_fuben_info1 order by num desc limit
		".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;

    $sql2="select count(num) from s_fuben_info1";
    $sqlHelper->exectue_dql_fenye_bag($sql1,$sql2,$fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//大雁塔列表查询
function getFenyePage_dyt_name1($fenyePage,$dh_fl){
    $sqlHelper=new SqlHelper();
    $sql1="select ta_ceng,gw_id from s_ta_guaiwu order by ta_ceng desc limit
		".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;

    $sql2="select count(ta_ceng) from s_ta_guaiwu";
    $sqlHelper->exectue_dql_fenye_bag($sql1,$sql2,$fenyePage,$dh_fl);
    $sqlHelper->close_connect();
}

//任务大全列表查询
function getFenyePage_renwu($fenyePage){
    $sqlHelper=new SqlHelper();
    $sql1="select rw_jindu,rw_biaoti from s_renwu order by rw_jindu desc limit
		".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;

    $sql2="select count(num) from s_renwu";
    $sqlHelper->exectue_dql_fenye($sql1,$sql2,$fenyePage);
    $sqlHelper->close_connect();
}
?>