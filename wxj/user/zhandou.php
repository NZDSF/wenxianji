<?php
/**
 * Author: by suxin
 * Date: 2019/12/6
 * Time: 9:59
 * Note: 战斗系统
 */

require_once '../include/fzr.php';
require_once '../control/control.php';
require_once 'wj_all_zt.php';

$jn_id = 0; //默认的技能id号，0表示不进行攻击
$gw_zd_id = 0;  //初始化怪物的id
$gw_lx = 1; //默认攻击类型为怪物(1-怪物，2-玩家斗法，3-玩家竞技,4-闯塔怪物)

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["gw_lx"])) {
        $suxin1 = explode(".", $url_info["gw_lx"]);
        $gw_lx = $suxin1[0];

        $sqlHelper = new SqlHelper();
        $wj_state = $sqlHelper->chaxun_wj_user_neirong('state');
        $sqlHelper->close_connect();
        if($wj_state != 0 && $gw_lx != $wj_state){
            header("location: zhandou.php");
            exit;
        }

        if($gw_lx == 4){
            //检查闯塔怪物和当前玩家的层数是否对应
            $sqlHelper = new SqlHelper();
            $wj_ceng = $sqlHelper->chaxun_wj_user_neirong('ta_ceng');
            $sql = "select num from s_ta_wj_jilu where s_name='$_SESSION[id]' and skill=0 and ceng=$wj_ceng";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();
            if($res){
                $sqlHelper = new SqlHelper();
                $sql = "select gw_id from s_ta_guaiwu where ta_ceng=$wj_ceng";
                $res = $sqlHelper->execute_dql($sql);
                $sql = "select gw_name,gw_dj,gw_gj,gw_xq,gw_fy,gw_bj,gw_rx,gw_hp from s_guaiwu_all where num=$res[gw_id]";
                $res1 = $sqlHelper->execute_dql($sql);

                $sql = "select num from s_wj_guaiwu where gw_name='$res1[gw_name]' and s_name='$_SESSION[id]' and gw_lx=4";
                $res = $sqlHelper->execute_dql($sql);
                if(!$res){
                    $sql = "insert into s_wj_guaiwu(s_name,gw_name,gw_dj,gw_gj,gw_xq,gw_fy,gw_bj,gw_rx,gw_sy_hp,gw_hp,gw_lx) values ('$_SESSION[id]','$res1[gw_name]','$res1[gw_dj]','$res1[gw_gj]','$res1[gw_xq]','$res1[gw_fy]','$res1[gw_bj]','$res1[gw_rx]','$res1[gw_hp]','$res1[gw_hp]',4)";
                    $res = $sqlHelper->execute_dml($sql);

                    $sql = "select num from s_wj_guaiwu where gw_name='$res1[gw_name]' and s_name='$_SESSION[id]' and gw_lx=4";
                    $res = $sqlHelper->execute_dql($sql);
                    $gw_zd_id = $res["num"];
                }else{
                    $gw_zd_id = $res["num"];
                }

                $sqlHelper->close_connect();
            }else{
                echo '<div>当前层数怪物已被击杀</div>';
                require_once '../include/time.php';
                exit;
            }
        }
    }

    if (isset($url_info["gwid"])) {
        $suxin1 = explode(".", $url_info["gwid"]);
        $gw_id = $suxin1[0];

        if($gw_lx == 1){
            $sqlHelper = new SqlHelper();
            $sql = "select fb_zhandou_gw,fb_jieduan from s_wj_fuben where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            if($res){
                if($res["fb_zhandou_gw"]){
                    $gw_zd_id = $res["fb_zhandou_gw"];
                }else{
                    $fb_jieduan = $res["fb_jieduan"];
                    $fuben_tl = fuben_tl($fb_jieduan);
                    $sql = "select num from s_wj_guaiwu where s_name='$_SESSION[id]' and num=$gw_id";
                    $res = $sqlHelper->execute_dql($sql);
                    if($res){
                        $wj_sy_nl = $sqlHelper->chaxun_wj_user_neirong('sy_nl');
                        if($wj_sy_nl >= $fuben_tl){
                            $sqlHelper->jianshao_wj_user_neirong('sy_nl',$fuben_tl);
                            $sql = "update s_wj_fuben set fb_zhandou_gw=$gw_id where s_name='$_SESSION[id]'";
                            $res = $sqlHelper->execute_dml($sql);
                            $gw_zd_id = $gw_id;
                            echo '<div>挑战开始，耐力-'.$fuben_tl.'</div>';
                            echo '<div>剩余耐力:'.($wj_sy_nl - $fuben_tl).'</div><br/>';
                        }else{
                            echo '<div>体力不足，无法进行战斗！</div>';

                            $jiami1 = 'x=f';
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<div>马上<a href='info.php?$url1'>恢复</a>耐力!</div>";

                            require_once '../include/time.php';
                            exit;
                        }
                    }else{
                        $sqlHelper->close_connect();

                        echo '<div>该怪物不存在</div>';
                        require_once '../include/time.php';
                        exit;
                    }
                }
            }
            $sqlHelper->close_connect();
        }
        else{
            $sqlHelper = new SqlHelper();
            $sql = "select df_num,df_sname from s_wj_pk_wj where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();
            if($res){
                $gw_zd_id = $res["df_num"];
            }else{
                $sqlHelper = new SqlHelper();
                $sql = "select s_name,dj from s_user where num=$gw_id";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res){
                    if($res["s_name"] == $_SESSION["id"]){
                        echo '<div>您不能和自己进行战斗哦!</div>';
                        if($gw_lx == 3){
                            $jiami1 = 'x=q';
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<br/><div><a href='../xy/pk.php?$url1'>返回上页</a></div>";
                        }
                        require_once '../include/time.php';
                        exit;
                    }
                    else{
                        if($gw_lx == 2){
                            $sqlHelper = new SqlHelper();
                            $wj_sy_nl = $sqlHelper->chaxun_wj_user_neirong('sy_nl');
                            $sqlHelper->close_connect();

                            $wj_doufa_tl = wj_doufa_tl();

                            if($wj_sy_nl >= $wj_doufa_tl){
                                $sqlHelper = new SqlHelper();
                                $wj_dj = $sqlHelper->chaxun_wj_user_neirong('dj');
                                $sqlHelper->close_connect();

                                $dj_chaju = abs($wj_dj - $res["dj"]);

                                $doufa_dj_chaju = doufa_dj_chaju();

                                if($dj_chaju > $doufa_dj_chaju){
                                    echo '<div>【斗法】</div>';
                                    echo '<div style="margin-top: 10px;">双方等级差距大于'.$doufa_dj_chaju.'级，无法进行斗法~</div>';
                                    require_once '../include/time.php';
                                    exit;
                                }else{
                                    $next_time = date('Y-m-d ', strtotime("+1 day") ). "06:00:00";

                                    $sqlHelper = new SqlHelper();
                                    $sql = "select df_cs,df_stop_time from s_df_wj_cs where s_name='$_SESSION[id]' and df_num='$gw_id'";
                                    $res1 = $sqlHelper->execute_dql($sql);
                                    if($res1){
                                        $now_time = date("Y-m-d H:i:s");
                                        if($res1["df_stop_time"] < $now_time){
                                            $sql = "update s_df_wj_cs set df_stop_time='$next_time',df_cs=1 where s_name='$_SESSION[id]' and df_num='$gw_id'";
                                            $res1 = $sqlHelper->execute_dml($sql);
                                        }else{
                                            $doufa_wj_cs = doufa_wj_cs();
                                            if($res1["df_cs"] < $doufa_wj_cs){
                                                $sql = "update s_df_wj_cs set df_cs=df_cs+1 where s_name='$_SESSION[id]' and df_num='$gw_id'";
                                                $res1 = $sqlHelper->execute_dml($sql);
                                            }else{
                                                echo '<div>【斗法】</div>';
                                                echo '<div style="margin-top: 10px;">该玩家今日被斗法次数已满，请选择其他玩家~</div>';
                                                require_once '../include/time.php';
                                                exit;
                                            }
                                        }
                                    }else{
                                        $sql = "insert into s_df_wj_cs(s_name,df_num,df_stop_time) values('$_SESSION[id]',$gw_id,'$next_time')";
                                        $res1 = $sqlHelper->execute_dml($sql);
                                    }
                                    $sqlHelper->close_connect();


                                    $sqlHelper = new SqlHelper();
                                    $sqlHelper->jianshao_wj_user_neirong('sy_nl',$wj_doufa_tl);
                                    $sqlHelper->close_connect();

                                    echo '<div>挑战开始，耐力-'.$wj_doufa_tl.'</div>';
                                    echo '<div>剩余耐力:'.($wj_sy_nl - $wj_doufa_tl).'</div><br/>';
                                }
                            }else{
                                echo '<div>体力不足，无法进行战斗！</div>';

                                $jiami1 = 'x=f';
                                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                                echo "<div>马上<a href='info.php?$url1'>恢复</a>耐力!</div>";

                                require_once '../include/time.php';
                                exit;
                            }
                        }
                        elseif($gw_lx == 3){
                            $sqlHelper = new SqlHelper();
                            $wj_pk_cs = $sqlHelper->chaxun_wj_user_neirong('pk_cs');
                            $sqlHelper->close_connect();
                            $pk_cs = pk_cs();
                            if(($pk_cs - $wj_pk_cs) <= 0){
                                echo '<div>您的今日PK次数已满，请明日再来!</div>';
                                $jiami1 = 'x=q';
                                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                                echo "<br/><div><a href='../xy/pk.php?$url1'>返回上页</a></div>";
                                require_once '../include/time.php';
                                exit;
                            }
                        }

                        $wj_all_zt_add_zhi = wj_all_zt_add_zhi($res["s_name"],$res["dj"]);
                        $sqlHelper = new SqlHelper();
                        $sql = "insert into s_wj_pk_wj(s_name,df_sname,df_sy_hp,df_num) values('$_SESSION[id]','$res[s_name]','$wj_all_zt_add_zhi[3]','$gw_id')";
                        $res = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();
                        $gw_zd_id = $gw_id;
                    }
                }
            }
        }
    }

    if (isset($url_info["jnid"])) {
        $suxin1 = explode(".", $url_info["jnid"]);
        $jn_id = $suxin1[0];
    }
}

$sqlHelper = new SqlHelper();
$wj_state = $sqlHelper->chaxun_wj_user_neirong('state');
if($wj_state && $wj_state != $gw_lx){
    $gw_lx = $wj_state;
    $gw_zd_id = 0;
}
$sqlHelper->close_connect();

if($gw_zd_id == 0){
    if($gw_lx == 1){
        $sqlHelper = new SqlHelper();
        $sql = "select fb_jindu,fb_zhandou_gw from s_wj_fuben where s_name='$_SESSION[id]'";
        $res = $sqlHelper->execute_dql($sql);
        if($res){
            if($res["fb_zhandou_gw"]){
                $gw_zd_id = $res["fb_zhandou_gw"];
            }else{
                $jiami1 = "x=e&id=".$res["fb_jindu"];
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                header("location: fuben.php?$url1");
                exit;
            }
        }
        $sqlHelper->close_connect();
    }
    elseif($gw_lx == 2 || $gw_lx == 3){
        $sqlHelper = new SqlHelper();
        $sql = "select df_num from s_wj_pk_wj where s_name='$_SESSION[id]'";
        $res = $sqlHelper->execute_dql($sql);
        if($res){
            $gw_zd_id = $res["df_num"];
        }else{
            echo '<div>不存在的对象</div>';
            require_once '../include/time.php';
            exit;
        }
        $sqlHelper->close_connect();
    }
    else{
        echo '<div>不存在的对象</div>';
        require_once '../include/time.php';
        exit;
    }
}

//pk增加次数及下次重置时间
function pk(){
    $sqlHelper = new SqlHelper();
    $wj_pk_next_time = $sqlHelper->chaxun_wj_user_neirong('pk_next_time');
    if($wj_pk_next_time == ''){
        $next_time = (date('Y-m-d ', strtotime("+1 day") )). "06:00:00";
        $sqlHelper->xiugai_wj_user_neirong('pk_next_time',$next_time);
    }else{
        $now_time = date("Y-m-d H:i:s");
        if($wj_pk_next_time <= $now_time){
            $next_time = (date('Y-m-d ', strtotime("+1 day") )). "06:00:00";
            $sqlHelper->xiugai_wj_user_neirong('pk_next_time',$next_time);
        }
    }
    $sqlHelper->add_wj_user_neirong('pk_cs',1);
    $sqlHelper->close_connect();
}

//玩家攻击
function wj_gj_gw($wj_gj,$wj_xq,$gw_fy,$gw_sy_hp,$gw_lx,$gw_id,$gw_dj=0,$wj_bj,$gw_rx){
    $wj_shanghai = $wj_gj * $wj_xq / $gw_fy;
    $wj_shanghai = ceil(rand($wj_shanghai * 0.7,$wj_shanghai));

    $baoji = ceil(($wj_bj - $gw_rx) / 200) * 100;
    $rand_baoji = rand(1,100);

    if($rand_baoji <= $baoji){
        $wj_shanghai = ceil($wj_shanghai * 1.5);
    }

    $gw_sy_hp = $gw_sy_hp - $wj_shanghai;

    if($gw_lx == 1) {
        if ($gw_sy_hp <= 0) {
            $gw_sy_hp = 0;

            $sqlHelper = new SqlHelper();
            $sql = "update s_wj_fuben set fb_zhandou_gw=null where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->xiugai_wj_user_neirong('state', 0);
            $sqlHelper->close_connect();

            echo '<div>击杀成功！</div>';
            echo '<div>获得:</div>';

            //开始计算怪物掉落
            $give_wupin_state = 0;

            $exp = 100 + floor($gw_dj/10);
            echo '<div>灵气x'.$exp.'</div>';

            $sqlHelper = new SqlHelper();
            $sqlHelper->add_wj_user_neirong('exp',$exp);
            $sqlHelper->close_connect();

            $sqlHelper = new SqlHelper();
            $sql = "select fb_jindu,fb_jieduan from s_wj_fuben where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            if($res){
                $sql = "select wp_num,wp_sl,wp_jilv from s_fuben_diaoluo where fb_jindu='$res[fb_jindu]' and fb_jieduan='$res[fb_jieduan]'";
                $res = $sqlHelper->execute_dql2($sql);
                if($res){
                    $now_jilv = rand(1,10000);
                    for($i=0;$i<count($res);$i++){
                        $jilv = $res[$i]["wp_jilv"];
                        if($now_jilv <= $jilv){
                            $give_wupin_state = 1;
                            $wp_num = $res[$i]["wp_num"];
                            $wp_sl = $res[$i]["wp_sl"];
                            $sql = "select wp_name from s_wupin_all where num=$wp_num";
                            $res = $sqlHelper->execute_dql($sql);
                            echo '<div>'.$res["wp_name"].'x'.$wp_sl.'</div>';
                        }
                    }
                }
            }
            $sqlHelper->close_connect();

            if($give_wupin_state == 1){
                require_once '../include/func.php';
                give_wupin($wp_num,$wp_sl);
            }

            //开始检测主线任务是否完成
            $sqlHelper = new SqlHelper();
            $wj_zx_jd = $sqlHelper->chaxun_wj_user_neirong('rw_zx_jd');
            $sql = "select rw_skill_gw_num1 from s_renwu where rw_jindu=$wj_zx_jd";
            $res = $sqlHelper->execute_dql($sql);

            $sql = "select gw_name from s_wj_guaiwu where num=$gw_id";
            $res1 = $sqlHelper->execute_dql($sql);

            $sql = "select num from s_guaiwu_all where gw_name='$res1[gw_name]'";
            $res1 = $sqlHelper->execute_dql($sql);

            if($res1["num"] == $res["rw_skill_gw_num1"]){
                $sqlHelper->xiugai_wj_user_neirong('rw_zx_skill',1);
            }
            $sqlHelper->close_connect();
        }

        $sqlHelper = new SqlHelper();
        $sql = "update s_wj_guaiwu set gw_sy_hp=$gw_sy_hp where num=$gw_id and s_name='$_SESSION[id]' and gw_lx=$gw_lx";
        $res = $sqlHelper->execute_dml($sql);
        $sqlHelper->close_connect();
    }
    elseif($gw_lx == 2 || $gw_lx == 3) {
        if ($gw_sy_hp <= 0) {
            $gw_sy_hp = 0;

            echo '<div>挑战胜利！</div>';

            $sqlHelper = new SqlHelper();
            $sql = "delete from s_wj_pk_wj where s_name='$_SESSION[id]' and df_num=$gw_id";
            $res = $sqlHelper->execute_dml($sql);
            $sql = "delete from s_wj_zhandou_skill_pk where s_name='$_SESSION[id]' and df_num=$gw_id";
            $res = $sqlHelper->execute_dml($sql);

            $sqlHelper->xiugai_wj_user_neirong('state', 0);
            $sqlHelper->close_connect();

            if($gw_lx == 2){
                //写入斗法动态
                $sqlHelper = new SqlHelper();
                $sql = "select s_name from s_user where num=$gw_id";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                require_once '../include/func.php';
                insert_wj_dongtai($res["s_name"],$_SESSION["id"],'dfcg','');

                $exp = 100 + floor($gw_dj/10);
                echo '<div>获得灵气x'.$exp.',功勋+1</div>';

                $sqlHelper = new SqlHelper();
                $sql = "update s_user set exp=exp+$exp,gongxun=gongxun+1,df_sl=df_sl+1 where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dml($sql);
                $sql = "update s_user set df_sb=df_sb+1 where num='$gw_id'";
                $res = $sqlHelper->execute_dml($sql);
                $sqlHelper->close_connect();

                global $date,$key_url_md_5;
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div style='margin-top: 10px;'><a href='../xy/df.php?$url1'>继续斗法</a></div>";

                $jiami1 = 'x=w&k=1&id='.$gw_id;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                $jiami2 = 'x=w&k=2&id='.$gw_id;
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
                $jiami3 = 'x=w&k=3&id='.$gw_id;
                $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);
                $jiami4 = 'x=w&k=4&id='.$gw_id;
                $url4 = encrypt_url("$jiami4.$date",$key_url_md_5);

                $songhua_daoju = songhua_daoju();

                echo "<div>捉弄一下TA吧~</div>";
                echo "<div><a href='../xy/df.php?$url1'>踢TA的屁股</a> (1".$songhua_daoju."花)</div>";
                echo "<div><a href='../xy/df.php?$url2'>摸摸TA的小脑袋</a> (1".$songhua_daoju."花)</div>";
                echo "<div><a href='../xy/df.php?$url3'>踩TA</a> (1".$songhua_daoju."花)</div>";
                echo "<div><a href='../xy/df.php?$url4'>用眼神杀死TA</a> (1".$songhua_daoju."花)</div>";
            }
            elseif($gw_lx == 3){
                $pk_sl_jf = pk_sl_jf();

                $sqlHelper = new SqlHelper();
                $sql = "select pk_pm from s_user where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dql($sql);
                $wj_pk_pm = $res["pk_pm"];
                $sqlHelper->close_connect();

                $sqlHelper = new SqlHelper();
                $sql = "select pk_pm,s_name from s_user where num='$gw_id'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                $df_pk_pm = $res["pk_pm"];

                if($df_pk_pm){
                    echo '<div>获得'.$pk_sl_jf.'点天武积分！</div>';

                    if(!$wj_pk_pm || $wj_pk_pm > $df_pk_pm){
                        $df_sname = $res["s_name"];
                        $sqlHelper = new SqlHelper();
                        $sql = "update s_user set pk_pm=$df_pk_pm,pk_max_pm=$df_pk_pm,pk_jf=pk_jf+$pk_sl_jf,pk_zjf=pk_zjf+$pk_sl_jf where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dml($sql);
                        if(!$wj_pk_pm){
                            $sql = "update s_user set pk_pm=null where num='$gw_id'";
                        }else{
                            $sql = "update s_user set pk_pm=$wj_pk_pm where num='$gw_id'";
                        }
                        $res = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();
                        echo '<div>您的天武排名上升为: 第'.$df_pk_pm.'名</div>';

                        //写入斗法动态
                        if(!$wj_pk_pm){
                            $message = '在天武榜中将你打败，你跌出了天武榜~';
                        }else{
                            $message = '在天武榜中将你打败，你跌落到了第'.$wj_pk_pm.'名~';
                        }

                        require_once '../include/func.php';
                        insert_wj_dongtai($df_sname,$_SESSION["id"],'pkup',$message);
                    }else{
                        $sqlHelper = new SqlHelper();
                        $sql = "update s_user set pk_jf=pk_jf+$pk_sl_jf,pk_zjf=pk_zjf+$pk_sl_jf where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();
                    }
                }

                pk();

                if($df_pk_pm){
                    if(!$wj_pk_pm || $wj_pk_pm > $df_pk_pm){
                        if($df_pk_pm <= 10){
                            require_once '../include/func.php';
                            $message1 = '获得了天武榜第'.$df_pk_pm.'名';
                            insert_xitong_gonggao($_SESSION["id"],'打败了','pk_top10',$df_sname,$message1);
                        }
                    }
                }
            }

        }else{
            $sqlHelper = new SqlHelper();
            $sql = "update s_wj_pk_wj set df_sy_hp=$gw_sy_hp where df_num=$gw_id and s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }
    }
    elseif($gw_lx == 4) {
        if ($gw_sy_hp <= 0) {
            $gw_sy_hp = 0;

            echo '<div>击杀成功！</div>';
            echo '<div>获得:</div>';

            $sqlHelper = new SqlHelper();

            $sqlHelper->xiugai_wj_user_neirong('state', 0);

            $wj_ceng = $sqlHelper->chaxun_wj_user_neirong('ta_ceng');
            $ta_max_ceng = $sqlHelper->chaxun_wj_user_neirong('ta_max_ceng');

            $sql = "select jl_sl from s_ta_jiangli where ta_ceng=$wj_ceng and jl_lx='exp'";
            $res = $sqlHelper->execute_dql($sql);
            if($res){
                $sqlHelper->add_wj_user_neirong('exp',$res["jl_sl"]);
                echo '<div>灵气x'.$res["jl_sl"].'</div>';
            }

            $sqlHelper->close_connect();

            $sqlHelper = new SqlHelper();
            $sql = "update s_ta_wj_jilu set skill=1 where s_name='$_SESSION[id]' and ceng=$wj_ceng";
            $res = $sqlHelper->execute_dml($sql);
            if($wj_ceng == $ta_max_ceng){
                $sqlHelper->add_wj_user_neirong('ta_max_ceng',1);
            }
            $sql = "delete from s_wj_guaiwu where num=$gw_id and s_name='$_SESSION[id]' and gw_lx=$gw_lx";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();

            global $date,$key_url_md_5;
            $jiami1 = 'x=e';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<div style='margin-top: 10px;'><a href='../xy/ct.php?$url1'>继续闯塔</a></div>";
        }else{
            $sqlHelper = new SqlHelper();
            $sql = "update s_wj_guaiwu set gw_sy_hp=$gw_sy_hp where num=$gw_id and s_name='$_SESSION[id]' and gw_lx=$gw_lx";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }
    }

    if($gw_sy_hp == 0){
        //清空玩家技能使用记录
        $sqlHelper = new SqlHelper();
        $sql = "delete from s_wj_zhandou_skill where s_name='$_SESSION[id]'";
        $res = $sqlHelper->execute_dml($sql);
        $sqlHelper->close_connect();
    }

    return array($gw_sy_hp,$wj_shanghai);
}

//怪物攻击
function gw_gj_wj($gw_gj,$gw_xq,$wj_fy,$wj_sy_hp,$wj_hp,$gw_lx,$gw_id,$gw_bj,$wj_rx){
    $gw_shanghai = $gw_gj * $gw_xq / $wj_fy;
    $gw_shanghai = ceil(rand($gw_shanghai * 0.7,$gw_shanghai));

    $baoji = ceil(($gw_bj - $wj_rx) / 200) * 100;
    $rand_baoji = rand(1,100);

    if($rand_baoji <= $baoji){
        $gw_shanghai = ceil($gw_shanghai * 1.5);
    }

    $wj_sy_hp = $wj_sy_hp - $gw_shanghai;
    if ($wj_sy_hp <= 0) {
        $wj_sy_hp = 0;
        echo '<div>挑战失败！</div>';

        $sqlHelper = new SqlHelper();
        $sql = "update s_user set sy_hp=$wj_hp,state=0 where s_name='$_SESSION[id]'";
        $res = $sqlHelper->execute_dml($sql);
        $sqlHelper->close_connect();

        if($gw_lx == 1){
            $sqlHelper = new SqlHelper();
            $sql = "update s_wj_fuben set fb_zhandou_gw=null where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dml($sql);
            $sql = "update s_wj_guaiwu set gw_sy_hp=gw_hp where s_name='$_SESSION[id]' and gw_sy_hp != 0";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
        }elseif($gw_lx == 2 || $gw_lx == 3){
            if($gw_lx == 2){
                $sqlHelper = new SqlHelper();
                $sql = "update s_user set df_sb=df_sb+1 where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dml($sql);
                $sql = "update s_user set df_sl=df_sl+1 where num='$gw_id'";
                $res = $sqlHelper->execute_dml($sql);
                $sqlHelper->close_connect();

                //写入斗法
                $sqlHelper = new SqlHelper();
                $sql = "select s_name from s_user where num=$gw_id";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                require_once '../include/func.php';
                insert_wj_dongtai($res["s_name"],$_SESSION["id"],'dfsb','');
            }

            $sqlHelper = new SqlHelper();
            $sql = "delete from s_wj_pk_wj where s_name='$_SESSION[id]' and df_num=$gw_id";
            $res = $sqlHelper->execute_dml($sql);
            $sql = "delete from s_wj_zhandou_skill_pk where s_name='$_SESSION[id]' and df_num=$gw_id";
            $res = $sqlHelper->execute_dml($sql);

            $sqlHelper->xiugai_wj_user_neirong('state', 0);
            $sqlHelper->close_connect();
            if($gw_lx == 3){
                pk();
            }
        }

    } else {
        $sqlHelper = new SqlHelper();
        $sqlHelper->xiugai_wj_user_neirong('sy_hp', $wj_sy_hp);
        $sqlHelper->close_connect();
    }

    if($wj_sy_hp == 0){
        //清空玩家技能使用记录
        $sqlHelper = new SqlHelper();
        $sql = "delete from s_wj_zhandou_skill where s_name='$_SESSION[id]'";
        $res = $sqlHelper->execute_dml($sql);
        $sqlHelper->close_connect();
    }

    return array($wj_sy_hp,$gw_shanghai);
}

//战斗系统
function zhandou($gw_id,$jn_id,$gw_lx,$shangye_url=''){
    $sqlHelper = new SqlHelper();

    if($gw_lx == 1 || $gw_lx == 4){
        $sql = "select gw_name,gw_dj,gw_gj,gw_xq,gw_fy,gw_bj,gw_rx,gw_sy_hp,gw_hp from s_wj_guaiwu where num=$gw_id and s_name='$_SESSION[id]' and gw_lx=$gw_lx";
        $res = $sqlHelper->execute_dql($sql);

        $gw_name = $res["gw_name"];
        $gw_dj = $res["gw_dj"];
        $gw_fy = $res["gw_fy"];
        $gw_gj = $res["gw_gj"];
        $gw_xq = $res["gw_xq"];
        $gw_bj = $res["gw_bj"];
        $gw_rx = $res["gw_rx"];
        $gw_sy_hp = $res["gw_sy_hp"];
        $gw_hp = $res["gw_hp"];
        $gw_sd = 0; //怪物的速度默认为0
    }else{
        $sql = "select df_sname,df_sy_hp from s_wj_pk_wj where df_num=$gw_id";
        $res = $sqlHelper->execute_dql($sql);

        $gw_sy_hp = $res["df_sy_hp"];
    }

    $sqlHelper->close_connect();

    if($res && $gw_sy_hp) {

        if($gw_lx == 2 || $gw_lx == 3){
            $df_sname = $res["df_sname"];
        }

        $sqlHelper = new SqlHelper();
        $sql = "select dj,sy_hp,state,g_name from s_user where s_name='$_SESSION[id]'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();

        $wj_dj = $res['dj'];
        $state = $res['state'];
        $wj_sy_hp = $res['sy_hp'];
        $wj_gname = $res['g_name'];

        $wj_all_zt_add_zhi = wj_all_zt_add_zhi($_SESSION["id"], $wj_dj);
        $wj_gj = $wj_all_zt_add_zhi[0];
        $wj_xq = $wj_all_zt_add_zhi[1];
        $wj_fy = $wj_all_zt_add_zhi[2];
        $wj_hp = $wj_all_zt_add_zhi[3];
        $wj_bj = $wj_all_zt_add_zhi[4];
        $wj_rx = $wj_all_zt_add_zhi[5];
        $wj_sd = $wj_all_zt_add_zhi[6];

        if ($wj_sy_hp != $wj_hp && $state == 0) {
            $sqlHelper = new SqlHelper();
            $sqlHelper->xiugai_wj_user_neirong('sy_hp', $wj_hp);
            $sqlHelper->close_connect();
            $wj_sy_hp = $wj_hp;
        }

        if($wj_sy_hp > 0){
            if($gw_lx == 2 || $gw_lx == 3){
                $sqlHelper = new SqlHelper();
                $sql = "select g_name,dj from s_user where s_name='$df_sname'";
                $res = $sqlHelper->execute_dql($sql);

                $sqlHelper->close_connect();
                $gw_name = $res["g_name"];
                $gw_dj = $res["dj"];

                $wj_all_zt_add_zhi = wj_all_zt_add_zhi($df_sname,$gw_dj);

                $gw_gj = $wj_all_zt_add_zhi[0];
                $gw_xq = $wj_all_zt_add_zhi[1];
                $gw_fy = $wj_all_zt_add_zhi[2];
                $gw_hp = $wj_all_zt_add_zhi[3];
                $gw_bj = $wj_all_zt_add_zhi[4];
                $gw_rx = $wj_all_zt_add_zhi[5];
                $gw_sd = $wj_all_zt_add_zhi[6];
            }

            $df_sy_tishi = '';

            if ($jn_id != 0) {
                $sqlHelper = new SqlHelper();
                $sqlHelper->xiugai_wj_user_neirong('state', $gw_lx);
                $sqlHelper->close_connect();

                $jineng_cunzai_state = 1;   //默认该技能存在
                $gj_state = 1;  //默认攻击状态为开启
                $wj_sy_tishi = '<div>你使用了普通攻击</div>';

                if ($jn_id != 1) {
                    //使用技能
                    $sqlHelper = new SqlHelper();
                    $sql = "select skill_dj from s_wj_skill where s_name='$_SESSION[id]' and skill_num=$jn_id and skill_fl='zd'";
                    $res = $sqlHelper->execute_dql($sql);
                    if ($res) {
                        $sql = "select skill_fl,skill_name,skill_lx,skill_zhi,skill_cx,skill_cd from s_skill_all where num=$jn_id";
                        $res1 = $sqlHelper->execute_dql($sql);

                        if($res1) {

                            $sql = "select skill_cd from s_wj_zhandou_skill where s_name='$_SESSION[id]' and skill_num=$jn_id";
                            $res2 = $sqlHelper->execute_dql($sql);
                            if ($res2) {
                                if ($res2["skill_cd"] == 0) {
                                    //更新数据库技能的持续回合和CD

                                    $wj_sy_tishi = '<div>你使用了' . $res1["skill_name"] . '</div>';

                                    $sql = "update s_wj_zhandou_skill set skill_cx='$res1[skill_cx]',skill_cd='$res1[skill_cd]' where s_name='$_SESSION[id]'";
                                    $res = $sqlHelper->execute_dml($sql);
                                } else {
                                    $gj_state = 0;
                                    $wj_sy_tishi = '<div>' . $res1["skill_name"] . '冷却中，剩余' . $res2["skill_cd"] . '回合</div>';
                                }
                            } else {
                                //技能增幅写入数据库
                                $skill_zhi = $res1["skill_zhi"] * $res["skill_dj"];
                                $sql = "insert into s_wj_zhandou_skill(s_name,skill_num,skill_lx,skill_zhi,skill_cx,skill_cd) values('$_SESSION[id]','$jn_id','$res1[skill_lx]','$skill_zhi','$res1[skill_cx]','$res1[skill_cd]')";
                                $res = $sqlHelper->execute_dml($sql);

                                $wj_sy_tishi = '<div>你使用了' . $res1["skill_name"] . '</div>';
                            }

                        }else {
                            //技能不存在
                            $jineng_cunzai_state = 0;
                        }
                    } else {
                        //技能不存在
                        $jineng_cunzai_state = 0;
                    }
                    $sqlHelper->close_connect();
                }

                if ($jineng_cunzai_state == 1) {
                    if ($gj_state == 1) {
                        //如果对手是玩家，则玩家随机释放已学习的技能
                        if($gw_lx == 2 || $gw_lx == 3){
                            $df_sy_tishi = '<div>对方使用了普通攻击</div>';

                            $sqlHelper = new SqlHelper();
                            $sql = "select skill_num,skill_dj from s_wj_skill where s_name='$df_sname' and skill_fl='zd'";
                            $res = $sqlHelper->execute_dql2($sql);
                            $ky_skill = array();
                            $dj_skill = array();
                            for($i=0;$i<count($res);$i++){
                                $skill_num = $res[$i]["skill_num"];
                                $skill_dj = $res[$i]["skill_dj"];

                                $sql = "select num,skill_cd from s_wj_zhandou_skill_pk where s_name='$_SESSION[id]' and skill_num=$skill_num and df_sname='$df_sname'";
                                $res1 = $sqlHelper->execute_dql($sql);

                                if($res1){
                                    if ($res1["skill_cd"] == 0) {
                                        //更新数据库技能的持续回合和CD
                                        $sql = "delete from s_wj_zhandou_skill_pk where num=$res1[num]";
                                        $res1 = $sqlHelper->execute_dml($sql);
                                        $ky_skill []= $skill_num;
                                        $dj_skill []= $skill_dj;
                                    }
                                }else{
                                    $ky_skill []= $skill_num;
                                    $dj_skill []= $skill_dj;
                                }
                            }

                            $ky_skill_count = count($ky_skill);
                            if($ky_skill_count){
                                $skill_rand = rand(0,($ky_skill_count - 1));
                                $skill_num = $ky_skill[$skill_rand];
                                $skill_dj = $dj_skill[$skill_rand];

                                $sql = "select skill_name,skill_lx,skill_zhi,skill_cx,skill_cd from s_skill_all where num=$skill_num";
                                $res1 = $sqlHelper->execute_dql($sql);

                                //技能增幅写入数据库
                                $skill_zhi = $res1["skill_zhi"] * $skill_dj;
                                $sql = "insert into s_wj_zhandou_skill_pk(s_name,df_num,df_sname,skill_num,skill_lx,skill_zhi,skill_cx,skill_cd) values('$_SESSION[id]','$gw_id','$df_sname','$skill_num','$res1[skill_lx]','$skill_zhi','$res1[skill_cx]','$res1[skill_cd]')";
                                $res = $sqlHelper->execute_dml($sql);

                                $df_sy_tishi = '<div>对方使用了' . $res1["skill_name"] . '</div>';
                            }

                            $sqlHelper->close_connect();

                            //获取对方的技能增幅属性
                            $sqlHelper = new SqlHelper();
                            $sql = "select num,skill_lx,skill_cx,skill_cd,skill_zhi from s_wj_zhandou_skill_pk where s_name='$_SESSION[id]' and df_sname='$df_sname'";
                            $res = $sqlHelper->execute_dql2($sql);
                            for ($i = 0; $i < count($res); $i++) {
                                $zhandou_skill_num = $res[$i]["num"];
                                $skill_cd = $res[$i]["skill_cd"];
                                $skill_cx = $res[$i]["skill_cx"];

                                if ($skill_cd == 0 && $skill_cx == 0) {
                                    $sql = "delete from s_wj_zhandou_skill where s_name='$_SESSION[id]' and num=$zhandou_skill_num";
                                    $res1 = $sqlHelper->execute_dml($sql);
                                    continue;
                                }

                                if ($skill_cx != 0) {
                                    $skill_lx = $res[$i]["skill_lx"];
                                    $skill_zhi = $res[$i]["skill_zhi"];
                                    if ($skill_lx == 'gj') {
                                        $gw_gj += $skill_zhi;
                                    } elseif ($skill_lx == 'fy') {
                                        $gw_fy += $skill_zhi;
                                    } elseif ($skill_lx == 'sd') {
                                        $gw_sd += $skill_zhi;
                                    }
                                }

                                if ($skill_cx != 0) {
                                    $skill_cx = $skill_cx - 1;
                                }

                                if ($skill_cd != 0) {
                                    $skill_cd = $skill_cd - 1;
                                }

                                //减少技能的持续回合和冷却CD
                                $sql = "update s_wj_zhandou_skill_pk set skill_cx=$skill_cx,skill_cd=$skill_cd where s_name='$_SESSION[id]' and num=$zhandou_skill_num and df_sname='$df_sname'";
                                $res1 = $sqlHelper->execute_dml($sql);
                            }
                            $sqlHelper->close_connect();
                        }


                        //获取玩家的技能增幅属性
                        $sqlHelper = new SqlHelper();
                        $sql = "select num,skill_lx,skill_cx,skill_cd,skill_zhi from s_wj_zhandou_skill where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dql2($sql);
                        for ($i = 0; $i < count($res); $i++) {
                            $zhandou_skill_num = $res[$i]["num"];
                            $skill_cd = $res[$i]["skill_cd"];
                            $skill_cx = $res[$i]["skill_cx"];

                            if ($skill_cd == 0 && $skill_cx == 0) {
                                $sql = "delete from s_wj_zhandou_skill where s_name='$_SESSION[id]' and num=$zhandou_skill_num";
                                $res1 = $sqlHelper->execute_dml($sql);
                                continue;
                            }

                            if ($skill_cx != 0) {
                                $skill_lx = $res[$i]["skill_lx"];
                                $skill_zhi = $res[$i]["skill_zhi"];
                                if ($skill_lx == 'gj') {
                                    $wj_gj += $skill_zhi;
                                } elseif ($skill_lx == 'fy') {
                                    $wj_fy += $skill_zhi;
                                } elseif ($skill_lx == 'sd') {
                                    $wj_sd += $skill_zhi;
                                }
                            }

                            if ($skill_cx != 0) {
                                $skill_cx = $skill_cx - 1;
                            }

                            if ($skill_cd != 0) {
                                $skill_cd = $skill_cd - 1;
                            }

                            //减少技能的持续回合和冷却CD
                            $sql = "update s_wj_zhandou_skill set skill_cx=$skill_cx,skill_cd=$skill_cd where s_name='$_SESSION[id]' and num=$zhandou_skill_num";
                            $res1 = $sqlHelper->execute_dml($sql);
                        }
                        $sqlHelper->close_connect();

                        //开始进行伤害计算

//                        $wj_sd = 3;
//                        $gw_sd = 20;

                        if($wj_sd > $gw_sd){
                            $wj_gj_gw = wj_gj_gw($wj_gj,$wj_xq,$gw_fy,$gw_sy_hp,$gw_lx,$gw_id,$gw_dj,$wj_bj,$gw_rx);
                            $gw_sy_hp = $wj_gj_gw[0];
                            $wj_shanghai = $wj_gj_gw[1];

                            if ($gw_sy_hp) {
                                $gw_gj_wj = gw_gj_wj($gw_gj,$gw_xq,$wj_fy,$wj_sy_hp,$wj_hp,$gw_lx,$gw_id,$gw_bj,$wj_rx);
                                $wj_sy_hp = $gw_gj_wj[0];
                                $gw_shanghai = $gw_gj_wj[1];
                            }
                        }else{
                            $gw_gj_wj = gw_gj_wj($gw_gj,$gw_xq,$wj_fy,$wj_sy_hp,$wj_hp,$gw_lx,$gw_id,$gw_bj,$wj_rx);
                            $wj_sy_hp = $gw_gj_wj[0];
                            $gw_shanghai = $gw_gj_wj[1];

                            if ($wj_sy_hp) {
                                $wj_gj_gw = wj_gj_gw($wj_gj,$wj_xq,$gw_fy,$gw_sy_hp,$gw_lx,$gw_id,$gw_dj,$wj_bj,$gw_rx);
                                $gw_sy_hp = $wj_gj_gw[0];
                                $wj_shanghai = $wj_gj_gw[1];
                            }
                        }
                    }
                }
                else {
                    echo '<div>该技能不存在！</div><br/>';
                }
            }
        }

        if($jn_id != 0){
            if($gw_sy_hp > 0 && $wj_sy_hp){
                if($wj_sd > $gw_sd){
                    echo $wj_sy_tishi;
                    echo $df_sy_tishi;
                }else{
                    echo $df_sy_tishi;
                    echo $wj_sy_tishi;
                }
            }
            echo '<br/>';
        }


        echo '<div>' . $gw_name . ' ' . $gw_dj . '级</div>';

        echo '<div>生命: ' . $gw_sy_hp . '/' . $gw_hp;
        if (isset($wj_shanghai)) {
            echo ' -' . $wj_shanghai;
        }
        echo '</div>';

        $shixin_geshu = ceil($gw_sy_hp / $gw_hp * 10);
        echo '<div class="zd_fangkuang_div">';
        for ($i = 0; $i < 10; $i++) {
            if ($i < $shixin_geshu) {
                echo '<span class="zd_fangkuang_shixin">■</span>';
            } else {
                echo '<span class="zd_fangkuang_kongxin">□</span>';
            }
        }
        echo '</div>';

        echo '<div style="margin-top: 10px;">' . $wj_gname . '</div>';
        echo '<div>生命: ' . $wj_sy_hp . '/' . $wj_hp;
        if (isset($gw_shanghai)) {
            echo ' -' . $gw_shanghai;
        }
        echo '</div>';

        $shixin_geshu = ceil($wj_sy_hp / $wj_hp * 10);
        echo '<div class="zd_fangkuang_div">';
        for ($i = 0; $i < 10; $i++) {
            if ($i < $shixin_geshu) {
                echo '<span class="zd_fangkuang_shixin">■</span>';
            } else {
                echo '<span class="zd_fangkuang_kongxin">□</span>';
            }
        }
        echo '</div>';

        global $date, $key_url_md_5;

        if($gw_sy_hp && $wj_sy_hp){
            $jiami1 = "jnid=1&gw_lx=".$gw_lx;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<div><a href='zhandou.php?$url1'>普攻</a>";

            $sqlHelper = new SqlHelper();
            $sql = "select skill_num from s_wj_skill where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql2($sql);
            for ($i = 0; $i < count($res); $i++) {
                $skill_num = $res[$i]["skill_num"];
                $sql = "select skill_name,skill_fl from s_skill_all where num=$skill_num";
                $res1 = $sqlHelper->execute_dql($sql);

                if($res1["skill_fl"] == 'bd'){
                    continue;
                }

                $jiami1 = "jnid=" . $skill_num.'&gw_lx='.$gw_lx;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                echo " | <a href='zhandou.php?$url1'>" . $res1["skill_name"] . "</a>";
            }
            $sqlHelper->close_connect();

            echo "</div>";
        }

        if($gw_lx == 1){
            $jiami1 = "x=q&fq_state=1";
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            if($gw_sy_hp){
                echo "<br/><div><a href='fuben.php?$url1'>放弃挑战</a></div>";
            }else{
                echo "<br/><div><a href='fuben.php?$shangye_url'>继续挑战</a></div>";
            }
        }
    }
}

$shangye_url = '';

if($gw_lx == 1){
    $sqlHelper = new SqlHelper();

    $sql = "select fb_jindu,fb_zhandou_gw from s_wj_fuben where s_name='$_SESSION[id]'";
    $res = $sqlHelper->execute_dql($sql);
    if($res){
        $jiami1 = "x=e&id=".$res["fb_jindu"];
        $shangye_url = encrypt_url("$jiami1.$date",$key_url_md_5);
    }

    $sqlHelper->close_connect();
}

zhandou($gw_zd_id,$jn_id,$gw_lx,$shangye_url);

if($gw_lx == 1){
    echo "<div><a href='https://3gqqw.com/bbs/forum.aspx?id=397'>查看攻略</a></div>";
}elseif($gw_lx == 3){
    $jiami1 = 'x=q';
    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

    echo "<br/><div><a href='../xy/pk.php?$url1'>返回上页</a></div>";
}


require_once '../include/time.php';
?>