<?php
/**
 * Author: by suxin
 * Date: 2019/12/31
 * Time: 12:49
 * Note: 
 */

require_once '../include/fzr.php';
require_once '../control/control.php';
require_once '../include/func.php';

//好友双修异性列表查询
function hy_show_shuangxiu_fenye($gotourl,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=15;

    global $key_url_md_5,$date;

    $shuangxiu_qinmidu = shuangxiu_qinmidu();


    getFenyePage_friends_shuangxiu($fenyePage,$dh_fl,$shuangxiu_qinmidu);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();
        $wj_sex = $sqlHelper->chaxun_wj_user_neirong('sex');

        $g_name = array();
        $dj = array();
        $sex = array();
        $qinmidu = array();
        $num = array();

        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $df_num = $row['df_num'];

            $sql = "select g_name,dj,sex from s_user where num=$df_num";
            $res = $sqlHelper->execute_dql($sql);

            if($res["sex"] == $wj_sex){
                continue;
            }

            $sql = "select qinmidu from s_wj_friends where s_name='$_SESSION[id]' and df_num=$df_num";
            $res1 = $sqlHelper->execute_dql($sql);

            $g_name []= $res["g_name"];
            $dj []= $res["dj"];
            $sex []= $res["sex"];
            $qinmidu []= $res1["qinmidu"];
            $num []= $df_num;
        }

        $sqlHelper->close_connect();

        if(count($g_name)){
            for($i=0;$i<count($g_name);$i++){
                echo '<div>';

                $jiami1 = 'id='.$num[$i];
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                $jiami2 = 'x=g&k=7&num='.$num[$i];
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                echo "<a href='mishi.php?$url2'>双修</a> <a href='../xy/wjinfo.php?$url1'>".$g_name[$i].'</a>('.$dj[$i]."级)";

                echo ' 亲密度:'.$qinmidu[$i];
            }

            //显示上一页和下一页
            if($fenyePage->pageCount > 1){
                echo $fenyePage->navigate;
            }
        }else{
            echo '<div>暂无可双修的仙友</div>';
        }
    }else{
        echo '<div>暂无可双修的仙友</div>';
    }

    echo '<div style="margin-top: 10px;">双修说明:</div>';
    echo '<div>1.亲密度大于'.$shuangxiu_qinmidu.'的异性玩家可双修</div>';
    $shuangxiu_biguan_xishu = shuangxiu_biguan_xishu(1);
    echo '<div>2.和普通玩家双修有'.$shuangxiu_biguan_xishu.'%的加成</div>';
    $shuangxiu_biguan_xishu = shuangxiu_biguan_xishu(2);
    echo '<div style="margin-bottom: 10px;">3.和自己仙侣双修有'.$shuangxiu_biguan_xishu.'%的加成</div>';
}


if(isset($_SESSION['id']) && isset($_SESSION['pass'])) {
    if ($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["x"])) {
            $suxin1 = explode(".", $url_info["x"]);
            $dh_fl = $suxin1[0];

            if($dh_fl == 'q'){
//                双修选择异性玩家
                echo '<div>【双修】</div>';

                hy_show_shuangxiu_fenye('mishi.php',$dh_fl);

                $jiami1 = 'x=g';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div style='margin-top: 5px;'><a href='mishi.php?$url1'>返回上页</a></div>";
            }
            elseif($dh_fl == 'g'){
                //密室
                echo '<div>【密室】</div>';

                $sqlHelper = new SqlHelper();
                $sql = "select exp,dj,xl_hour,xl_start_time,xl_stop_time,cz_jf,sy_nl,z_nl,xl_sx_dfsname,zhizun_vip,yueka_stop_time,cz_jf,xianlv from s_user where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                $sy_nl = $res["sy_nl"];
                $z_nl = $res["z_nl"];
                $wj_exp = $res["exp"];
                $cz_jf = $res["cz_jf"];
                $wj_dj= $res["dj"];
                $xl_hour = $res["xl_hour"];
                $xl_start_time = $res["xl_start_time"];
                $xl_stop_time = $res["xl_stop_time"];
                $xl_sx_dfsname = $res["xl_sx_dfsname"];


                $xh_nl1 = 20;
                $xh_nl2 = 40;
                $xh_nl3 = 80;
                $xh_nl4 = 120;

                if($cz_jf){
                    $xh_nl1 /= 2;
                    $xh_nl2 /= 2;
                    $xh_nl3 /= 2;
                    $xh_nl4 /= 2;
                }

                $wj_shengji_exp = wj_shengji_exp($wj_dj);

                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];

                    if($gn_fl == 1){
                        $xh_nl = $xh_nl1;
                        $hour = 2;
                    }
                    elseif($gn_fl == 2){
                        $xh_nl = $xh_nl2;
                        $hour = 4;
                    }
                    elseif($gn_fl == 3){
                        if($cz_jf){
                            $xh_nl = $xh_nl3;
                            $hour = 8;
                        }else{
                            $hour = 0;
                        }
                    }
                    elseif($gn_fl == 4){
                        if($cz_jf){
                            $xh_nl = $xh_nl4;
                            $hour = 12;
                        }else{
                            $hour = 0;
                        }
                    }
                    elseif($gn_fl == 5){
                        //提前闭关确认
                        $guoqu_time = zhuanhuan_guoqu_time($xl_start_time);

                        if($guoqu_time > 3600){
                            echo '<div>你确定要结束闭关吗？</div>';
                        }else{
                            echo '<div>闭关未到1小时,中途结束闭关,将无法获得任何灵气.</div>';
                        }

                        $jiami1 = 'x=g&k=6';
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);


                        echo "<div><a href='mishi.php?$url1'>确定中止</a></div>";

                        $jiami1 = 'x=g';
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        echo "<div style='margin-top: 10px;'><a href='mishi.php?$url1'>返回上页</a></div>";
                        require_once '../include/time.php';
                        exit;
                    }
                    elseif($gn_fl == 6) {
                        //结束闭关
                        $hour = 0;
                        if ($xl_hour) {
                            $now_time = date("Y-m-d H:i:s");
                            if ($now_time > $xl_stop_time) {
                                //正常闭关结束
                                $wj_biguan_exp = wj_biguan_exp($wj_dj, $xl_hour);
                            } else {
                                $guoqu_time = zhuanhuan_guoqu_time($xl_start_time);

                                if ($guoqu_time > 3600) {
                                    //获得部分经验
                                    $wj_biguan_exp = wj_biguan_exp($wj_dj, $xl_hour);
                                    $sec_exp = $wj_biguan_exp / ($xl_hour * 60 * 60);
                                    $wj_biguan_exp = ceil($guoqu_time * $sec_exp);
                                } else {
                                    $wj_biguan_exp = 0;
                                    //无法获得经验，不提示任何信息
                                }

                            }

                            if ($wj_biguan_exp) {
                                $zong_jiacheng = 100;
                                if($res["cz_jf"]){
                                    $vip_biguan_xishu = vip_biguan_xishu($res["cz_jf"]);
                                    $zong_jiacheng += $vip_biguan_xishu;
                                }
                                if($res["xl_sx_dfnum"]){
                                    if($xl_sx_dfsname){
                                        if($xl_sx_dfsname == $res["xianlv"]){
                                            $sx_state = 2;
                                        }else{
                                            $sx_state = 1;
                                        }
                                        $shuangxiu_biguan_xishu = shuangxiu_biguan_xishu($sx_state);
                                        $zong_jiacheng += $shuangxiu_biguan_xishu;
                                    }
                                }
                                if($res["zhizun_vip"]){
                                    $yueka_biguan_xishu = yueka_biguan_xishu();
                                    $zong_jiacheng += $yueka_biguan_xishu;

                                    $zhizunvip_biguan_xishu = zhizunvip_biguan_xishu();
                                    $zong_jiacheng += $zhizunvip_biguan_xishu;
                                }else{
                                    $now_time = date("Y-m-d H:i:s");
                                    if($now_time < $res["yueka_stop_time"]){
                                        $yueka_biguan_xishu = yueka_biguan_xishu();
                                        $zong_jiacheng += $yueka_biguan_xishu;
                                    }
                                }

                                $wj_biguan_exp = ceil($wj_biguan_exp * ($zong_jiacheng / 100));

                                $wj_exp += $wj_biguan_exp;

                                echo '<div style="margin-top: 10px;">闭关结束！</div>';
                                echo '<div style="margin-bottom: 10px;">获得灵气x' . $wj_biguan_exp . '</div>';
                                $sqlHelper = new SqlHelper();
                                $sql = "update s_user set exp=exp+$wj_biguan_exp,xl_hour=null,xl_start_time=null,xl_stop_time=null,xl_sx_dfsname=null where s_name='$_SESSION[id]'";
                                $res1 = $sqlHelper->execute_dml($sql);
                                $sqlHelper->close_connect();
                            } else {
                                $sqlHelper = new SqlHelper();
                                $sql = "update s_user set xl_hour=null,xl_start_time=null,xl_stop_time=null,xl_sx_dfsname=null where s_name='$_SESSION[id]'";
                                $res1 = $sqlHelper->execute_dml($sql);
                                $sqlHelper->close_connect();
                            }

                            $xl_hour = '';
                        }
                    }
                    elseif($gn_fl == 7){
                        $xh_nl = $xh_nl3;
                        $hour = 8;
                    }
                    else{
                        $hour = 0;
                    }


                    if($hour && $res["xl_hour"] == ''){
                        if($res["sy_nl"] >= $xh_nl){
                            if(!$res["xl_hour"]){
                                if($gn_fl == 7){
                                    if (isset($url_info["num"])) {
                                        $suxin1 = explode(".", $url_info["num"]);
                                        $wj_num = $suxin1[0];

                                        $sqlHelper = new SqlHelper();
                                        $sql = "select qinmidu from s_wj_friends where s_name='$_SESSION[id]' and df_num=$wj_num";
                                        $res1 = $sqlHelper->execute_dql($sql);
                                        $sqlHelper->close_connect();
                                        if($res1){
                                            $shuangxiu_qinmidu = shuangxiu_qinmidu();
                                            if($res1["qinmidu"] < $shuangxiu_qinmidu){
                                                echo '<div>亲密度不足，无法进行双修哦~</div>';
                                                $jiami1 = 'x=g';
                                                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                                                echo "<div style='margin-top: 5px;'><a href='mishi.php?$url1'>返回上页</a></div>";
                                                require_once '../include/time.php';
                                                exit;
                                            }else{
                                                $sqlHelper = new SqlHelper();
                                                $wj_sex = $sqlHelper->chaxun_wj_user_neirong('sex');
                                                $sql = "select sex,s_name from s_user where num=$wj_num";
                                                $res1 = $sqlHelper->execute_dql($sql);
                                                $sqlHelper->close_connect();
                                                if($res1["sex"] == $wj_sex){
                                                    echo '<div>同性之间，无法进行双修哦~</div>';
                                                    $jiami1 = 'x=g';
                                                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                                                    echo "<div style='margin-top: 5px;'><a href='mishi.php?$url1'>返回上页</a></div>";
                                                    require_once '../include/time.php';
                                                    exit;
                                                }else{
                                                    $sqlHelper = new SqlHelper();
                                                    $sqlHelper->xiugai_wj_user_neirong('xl_sx_dfsname',$res1["s_name"]);
                                                    $sqlHelper->close_connect();
                                                    $xl_sx_dfsname = $res1["s_name"];

                                                    //写入个人动态

                                                    require_once '../include/func.php';
                                                    insert_wj_dongtai($xl_sx_dfsname,$_SESSION["id"],'shuangxiu','');
                                                }
                                            }
                                        }else{
                                            echo '<div>你们不是好友，无法进行双修哦~</div>';
                                            $jiami1 = 'x=g';
                                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                                            echo "<div style='margin-top: 5px;'><a href='mishi.php?$url1'>返回上页</a></div>";
                                            require_once '../include/time.php';
                                            exit;
                                        }
                                    }else{
                                        require_once '../include/time.php';
                                        exit;
                                    }
                                }

                                $now_time = date("Y-m-d H:i:s");
                                $stop_time = date('Y-m-d H:i:s', strtotime("+$hour hour") );

                                $sqlHelper = new SqlHelper();
                                $sql = "update s_user set sy_nl=sy_nl-$xh_nl,xl_hour='$hour',xl_start_time='$now_time',xl_stop_time='$stop_time' where s_name='$_SESSION[id]'";
                                $res1 = $sqlHelper->execute_dml($sql);
                                $sqlHelper->close_connect();

                                echo '<div style="margin-top: 10px;">闭关成功！</div>';
                                echo '<div style="margin-bottom: 10px;">耐力-'.$xh_nl.'</div>';

                                $sy_nl -= $xh_nl;
                                $xl_hour = $hour;
                                $xl_stop_time = $stop_time;
                            }
                        }else{
                            echo '<div style="margin-top: 10px;margin-bottom: 10px;">耐力不足，无法进行闭关！</div>';
                        }
                    }
                }

                $vip_dj = vip_dj($cz_jf);
                $vip_nlsx_hfcs = vip_nlsx_hfcs($vip_dj);

                $z_nl += $vip_nlsx_hfcs[0];

                echo '<div>灵气:'.$wj_exp.'/'.$wj_shengji_exp.'</div>';
                echo '<div>耐力:'.$sy_nl.'/'.$z_nl.'</div>';

                echo '<br/><div>状态:';
                if($xl_hour){
                    $zhuanhuan_sy_time_sec = zhuanhuan_sy_time_sec($xl_stop_time);

                    if($zhuanhuan_sy_time_sec){
                        echo $zhuanhuan_sy_time_sec;

                        $jiami1 = 'x=g&k=5';
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        echo "后可出关 <a href='mishi.php?$url1'>中止</a></div>";
                    }
                    else{
                        $jiami1 = 'x=g&k=6';
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        echo "闭关完成 <a href='mishi.php?$url1'>中止</a></div>";
                    }

                    echo '<div style="margin-top: 5px;margin-bottom: 5px;">加成状态:</div>';
                    $zong_jiacheng = 100;
                    if($res["cz_jf"]){
                        $vip_biguan_xishu = vip_biguan_xishu($res["cz_jf"]);
                        $zong_jiacheng += $vip_biguan_xishu;
                        echo '<div>VIP加成中...</div>';
                    }
                    if($xl_sx_dfsname){
                        if($xl_sx_dfsname == $res["xianlv"]){
                            $sx_state = 2;
                        }else{
                            $sx_state = 1;
                        }
                        $shuangxiu_biguan_xishu = shuangxiu_biguan_xishu($sx_state);
                        $zong_jiacheng += $shuangxiu_biguan_xishu;
                        echo '<div>双修加成中...</div>';
                    }
                    if($res["zhizun_vip"]){
                        echo '<div>月卡加成中...</div>';
                        $yueka_biguan_xishu = yueka_biguan_xishu();
                        $zong_jiacheng += $yueka_biguan_xishu;

                        $zhizunvip_biguan_xishu = zhizunvip_biguan_xishu();
                        $zong_jiacheng += $zhizunvip_biguan_xishu;

                        echo '<div>至尊VIP加成中...</div>';
                    }else{
                        $now_time = date("Y-m-d H:i:s");
                        if($now_time < $res["yueka_stop_time"]){
                            $yueka_biguan_xishu = yueka_biguan_xishu();
                            $zong_jiacheng += $yueka_biguan_xishu;
                            echo '<div>月卡加成中...</div>';
                        }
                    }
                    echo '<div style="margin-top: 5px;">总加成:'.$zong_jiacheng.'%</div>';

                }
                else{
                    echo '未闭关</div>';
                    echo '<div>[双修]</div>';
                    $jiami1 = 'x=q';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo "<div><a href='mishi.php?$url1'>双修8小时</a>(消耗".$xh_nl3."耐力,VIP消耗减半)</div>";

                    echo '<div>[闭关]</div>';
                    $jiami1 = 'x=g&k=1';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    $jiami2 = 'x=g&k=2';
                    $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                    echo "<div><a href='mishi.php?$url1'>2小时</a>(消耗".$xh_nl1."耐力,VIP消耗减半)</div>";
                    echo "<div><a href='mishi.php?$url2'>4小时</a>(消耗".$xh_nl2."耐力,VIP消耗减半)</div>";

                    if($cz_jf){
                        $jiami3 = 'x=g&k=3';
                        $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);
                        $jiami4 = 'x=g&k=4';
                        $url4 = encrypt_url("$jiami4.$date",$key_url_md_5);

                        echo "<div><a href='mishi.php?$url3'>8小时</a>(vip开启,消耗".$xh_nl3."耐力,VIP消耗减半)</div>";
                        echo "<div><a href='mishi.php?$url4'>12小时</a>(vip开启,消耗".$xh_nl4."耐力,VIP消耗减半)</div>";
                    }else{
                        echo "<div>8小时(vip开启,消耗".$xh_nl3."耐力,VIP消耗减半)</div>";
                        echo "<div>12小时(vip开启,消耗".$xh_nl4."耐力,VIP消耗减半)</div>";
                    }
                }
                echo '<br/>';
            }

        }
    }
}

echo '<a href="../main/main.php">返回首页</a>';
?>