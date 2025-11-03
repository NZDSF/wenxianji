<?php
/**
 * Author: by suxin
 * Date: 2020/1/4
 * Time: 10:17
 * Note: 排行榜
 */

require_once '../include/fzr.php';


//排行分类导航
function rank_fenlei_daohang($dh_fl){
    $daohang_array = array(
        array('q','等级'),
        array('w','财富'),
        array('e','胜利'),
        array('r','成就'),
        array('t','战力'),
        array('y','天武积分'),
        array('u','送花榜'),
        array('i','收花榜'),
    );

    $count_daohang = count($daohang_array);
    global $date,$key_url_md_5;

    for($i=0;$i<$count_daohang;$i++){
        if($daohang_array[$i][0] == 'u' || $daohang_array[$i][0] == 'i'){
            $jiami1 = "x=".$daohang_array[$i][0].'&k=1';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
        }else{
            $jiami1 = "x=".$daohang_array[$i][0];
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
        }

        if($dh_fl == $daohang_array[$i][0]){
            echo $daohang_array[$i][1];
        }else{
            echo "<a href='rank.php?$url1'>".$daohang_array[$i][1].'</a>';
        }

        if((($i+1) % 6) == 0){
            echo '<br/>';
        }else{
            if(($i+1) < $count_daohang){
                echo ' ';
            }
        }
    }

    if($dh_fl == 'u' || $dh_fl == 'i') {
        if ($_SERVER["QUERY_STRING"]) {
            $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                if ($gn_fl == 1) {
                    $jiami1 = "x=" . $dh_fl . '&k=2';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    echo "<div>周榜 <a href='rank.php?$url1'>总榜</a></div>";
                } elseif ($gn_fl == 2) {
                    $jiami1 = "x=" . $dh_fl . '&k=1';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    echo "<div><a href='rank.php?$url1'>周榜</a> 总榜</div>";
                }
            }
        }
    }

    rank_show_fenye('rank.php',$dh_fl);
}

//排行榜列表查询
function rank_show_fenye($gotourl,$dh_fl){
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
            $xuhao = ($fenyePage->pageNow - 1) * $fenyePage->pageSize +1;
        }else{
            $xuhao = 1;
        }
    }

    getFenyePage_rankd($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();

        if($dh_fl == 'q'){
            $sql = "select s_name from s_user where dj>1 and robot=0 order by dj desc,exp desc,dj_up_time desc limit 100";
        }elseif($dh_fl == 'w'){
            $sql = "select s_name from s_user where money>0 and robot=0 order by money desc,dj desc,exp desc,dj_up_time desc limit 100";
        }elseif($dh_fl == 'e'){
            $sql = "select s_name from s_user where df_sl>0 and robot=0 order by df_sl desc,dj desc,exp desc,dj_up_time desc limit 100";
        }elseif($dh_fl == 'r'){
            $sql = "select s_name from s_user where ch_jf>0 and robot=0 order by ch_jf desc,dj desc,exp desc,dj_up_time desc limit 100";
        }elseif($dh_fl == 't'){
            $sql = "select s_name from s_user where zhanli>0 and robot=0 order by zhanli desc,dj desc,exp desc,dj_up_time desc limit 100";
        }elseif($dh_fl == 'y'){
            $sql = "select s_name from s_user where pk_zjf>0 and robot=0 order by pk_zjf desc,dj desc,exp desc,dj_up_time desc limit 100";
        }elseif($dh_fl == 'u'){
            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                if ($gn_fl == 1) {
                    $sql = "select s_name from s_user where songhb_week>0 and robot=0 order by songhb_week desc,dj desc,exp desc,dj_up_time desc limit 100";
                }elseif ($gn_fl == 2) {
                    $sql = "select s_name from s_user where songhb>0 and robot=0 order by songhb desc,dj desc,exp desc,dj_up_time desc limit 100";
                }
            }
        }elseif($dh_fl == 'i'){
            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                if ($gn_fl == 1) {
                    $sql = "select s_name from s_user where shouhb_week>0 and robot=0 order by shouhb_week desc,dj desc,exp desc,dj_up_time desc limit 100";
                }elseif ($gn_fl == 2) {
                    $sql = "select s_name from s_user where shouhb>0 and robot=0 order by shouhb desc,dj desc,exp desc,dj_up_time desc limit 100";
                }
            }
        }

        $res = $sqlHelper->execute_dql2($sql);
        $count_rank = count($res);
        $rank_chuxian = 0;

        echo '<div>你的当前排名:';
        for($i=0;$i<$count_rank;$i++){
            if($res[$i]["s_name"] == $_SESSION["id"]){
                $rank_chuxian = 1;
                echo '第'.($i+1).'名';
            }
        }
        if($rank_chuxian == 0){
            echo '100名以外';
        }
        echo '</div>';

        if($dh_fl == 't'){
            $wj_zhanli = $sqlHelper->chaxun_wj_user_neirong('zhanli');

            $jiami1 = 'x=z';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            echo "<div>我的战力: ".$wj_zhanli." <a href='rank.php?$url1'>测定</a></div>";
        }

        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $s_name = $row['s_name'];
            $g_name = $row['g_name'];

            echo '<div>'.$xuhao.".";

            if($s_name == $_SESSION["id"]){
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                echo "<a href='../user/info.php?$url1'>".$g_name."</a>";
            }else{
                $jiami1 = 'id='.$num;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                echo "<a href='wjinfo.php?$url1'>".$g_name."</a>";
            }

            if($dh_fl == 'q'){
                echo '('.$row['dj'].')';
            }elseif($dh_fl == 'w'){
                echo '('.$row['money'].')';
            }elseif($dh_fl == 'e'){
                echo '('.$row['df_sl'].'场)';
            }elseif($dh_fl == 'r'){
                echo '('.$row['ch_jf'].')';
            }elseif($dh_fl == 't'){
                echo '('.$row['zhanli'].')';
            }elseif($dh_fl == 'y'){
                echo '('.$row['pk_zjf'].')';
            }elseif($dh_fl == 'u'){
                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];
                    if ($gn_fl == 1) {
                        echo '('.$row['songhb_week'].')';
                    }elseif ($gn_fl == 2) {
                        echo '('.$row['songhb'].')';
                    }
                }
            }elseif($dh_fl == 'i'){
                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];
                    if ($gn_fl == 1) {
                        echo '('.$row['shouhb_week'].')';
                    }elseif ($gn_fl == 2) {
                        echo '('.$row['shouhb'].')';
                    }
                }
            }

            echo '</div>';
            $xuhao += 1;
        }

        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div style="margin-top: 10px;">暂无人登榜</div>';
    }
}

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q' || $dh_fl == 'w' || $dh_fl == 'e' || $dh_fl == 'r' || $dh_fl == 't' || $dh_fl == 'y' || $dh_fl == 'u' || $dh_fl == 'i'){
            //排行首页
            //等级排行 财富排行
            echo '<div>【龙虎榜】</div>';

            rank_fenlei_daohang($dh_fl);
        }
        elseif($dh_fl == 'z'){
            //测定战力
            echo '<div>【战力评定】</div>';

            require_once '../user/wj_all_zt.php';
            require_once '../control/control.php';

            $sqlHelper = new SqlHelper();
            $wj_dj = $sqlHelper->chaxun_wj_user_neirong('dj');
            $sqlHelper->close_connect();

            $wj_all_zt_add_zhi = wj_all_zt_add_zhi($_SESSION["id"],$wj_dj);

            $zhanli = zhanli_pingfen($wj_all_zt_add_zhi[0],$wj_all_zt_add_zhi[1],$wj_all_zt_add_zhi[2],$wj_all_zt_add_zhi[3],$wj_all_zt_add_zhi[6],$wj_all_zt_add_zhi[4],$wj_all_zt_add_zhi[5]);

            echo '<div>评定成功，你的当前战力为:'.$zhanli.'</div>';

            $sqlHelper = new SqlHelper();
            $sqlHelper->xiugai_wj_user_neirong('zhanli',$zhanli);
            $sqlHelper->close_connect();

            $jiami1 = "x=t";
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<a href='rank.php?$url1'>返回上页</a>";
        }


    }
}



require_once '../include/time.php';
?>