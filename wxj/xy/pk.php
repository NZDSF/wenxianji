<?php
/**
 * Author: by suxin
 * Date: 2019/12/20
 * Time: 15:13
 * Note: 竞技场
 */

require_once '../include/fzr.php';
require_once '../control/control.php';

//PK排行列表查询
function pk_show_fenye($gotourl,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=10;

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

    getFenyePage_pk($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $g_name = $row['g_name'];
            $s_name = $row['s_name'];
            $dj = $row['dj'];
            $pk_pm = $row['pk_pm'];
            $robot = $row['robot'];

            $jiami1 = 'gwid='.$num.'&gw_lx=3';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            if($s_name == $_SESSION["id"]){
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                echo "<div>挑战 第".$pk_pm."名: <a href='../user/info.php?$url1'>".$g_name."</a> (".$dj."级)</div>";
            }else{
                echo "<div><a href='../user/zhandou.php?$url1'>挑战</a> 第".$pk_pm."名: ";
                if($robot){
                    echo $g_name.' ';
                }else{
                    $jiami1 = 'id='.$num;
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    echo "<a href='wjinfo.php?$url1'>".$g_name."</a>";
                }

                echo "(".$dj."级)</div>";
            }

            $xuhao += 1;
        }

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无人登榜</div>';
    }
}

//PK积分兑换列表查询
function pk_duihuan_show_fenye($gotourl,$dh_fl,$wj_pk_jf){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=10;

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

    getFenyePage_pk_duihuan($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $wp_id = $row['wp_id'];
            $xh_jf = $row['xh_jf'];

            $sql = "select wp_name from s_wupin_all where num=$wp_id";
            $res = $sqlHelper->execute_dql($sql);

            if($res){
                if($wj_pk_jf >= $xh_jf){
                    $jiami1 = 'x=w&k=1&id='.$num;
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<div><a href='pk.php?$url1'>兑换</a> ";
                }else{
                    echo '<div>兑换</a> ';
                }
                echo $res["wp_name"].' '.$xh_jf.'积分</div>';
            }





            $xuhao += 1;
        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无兑换物品</div>';
    }
}

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //竞技场首页

            $sqlHelper = new SqlHelper();
            $sql = "select pk_pm,pk_cs,pk_next_time,pk_max_pm,pk_jf,pk_zjf,pk_jf_next_time from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);

            $wj_sy_pk_cs = $res["pk_cs"];
            $wj_pk_jf = $res['pk_jf'];
            $wj_pk_zjf = $res['pk_zjf'];

            $now_time = date("Y-m-d H:i:s");

            if($res["pk_next_time"] == '' || $res["pk_next_time"] < $now_time){
                $next_time = (date('Y-m-d ', strtotime("+1 day") )). "06:00:00";
                $sql = "update s_user set pk_cs=0,pk_next_time='$next_time',pk_gm_cs=0 where s_name='$_SESSION[id]'";
                $res1 = $sqlHelper->execute_dml($sql);
                $wj_sy_pk_cs = 0;
            }

            if($res["pk_jf_next_time"] == ''){
                $lingqu_state = 1;  //领取每日排名积分的状态
            }elseif($res["pk_jf_next_time"] < $now_time){
                $sql = "update s_user set pk_jf_next_time=null where s_name='$_SESSION[id]'";
                $res1 = $sqlHelper->execute_dml($sql);
                $wj_sy_pk_cs = 0;
                $lingqu_state = 1;  //领取每日排名积分的状态
            }else{
                $lingqu_state = 0;  //领取每日排名积分的状态
            }

            $sqlHelper->close_connect();

            $pk_pm = $res["pk_pm"];
            $pk_max_pm = $res["pk_max_pm"];
            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                if($gn_fl == 1){
                    //登榜
                    if(!$pk_pm){
                        $sqlHelper = new SqlHelper();
                        $sql = "select pk_pm from s_user where pk_pm !='' order by pk_pm desc limit 1";
                        $res = $sqlHelper->execute_dql($sql);
                        if($res){
                            $pk_pm = $res["pk_pm"] + 1;
                        }else{
                            $pk_pm = 1;
                        }
                        $pk_max_pm = $pk_pm;
                        $sql = "update s_user set pk_pm='$pk_pm',pk_max_pm='$pk_pm' where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();
                    }
                }
                elseif($gn_fl == 2){
                    //领取每日积分排名奖励

                    if($res["pk_jf_next_time"]){
                        $now_time = date("Y-m-d H:i:s");
                        if($res["pk_jf_next_time"] >= $now_time){
                            $lingqu_state = 0;
                        }
                    }

                    if($lingqu_state == 1){
                        $pk_jf = pk_jf($pk_pm);
                        $next_time = (date('Y-m-d ', strtotime("+1 day") )). "06:00:00";

                        $sqlHelper = new SqlHelper();
                        $sql = "update s_user set pk_jf=pk_jf+$pk_jf,pk_zjf=pk_zjf+$pk_jf,pk_jf_next_time='$next_time' where s_name='$_SESSION[id]'";
                        $res1 = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();

                        $wj_pk_zjf ++;
                        $wj_pk_jf ++;
                        $lingqu_state = 0;

                        $lq_pm_jf = '<div style="margin-top: 10px;margin-bottom: 10px;">获得了排名每日奖励积分x'.$pk_jf.'</div>';
                    }

                }
            }

            $pk_cs = pk_cs();
            $sy_cs = $pk_cs - $wj_sy_pk_cs;

            echo '<div>【天武榜】</div>';
            echo "<img src='../images/pk.png'>";

            $jiami1 = 'x=e';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo '<div>今日剩余次数:'.$sy_cs." <a href='pk.php?$url1'>购买</a></div>";
            echo '<div>我的当前排名: ';
            if($pk_pm){
                echo $pk_pm;
            }else{
                echo '无';

                $jiami1 = 'x=q&k=1';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo " <a href='pk.php?$url1'>我要登榜</a>";
            }

            echo '</div>';
            echo '<div>历史最高排名: ';
            if($pk_max_pm){
                echo $pk_max_pm;
            }else{
                echo '无';
            }

            echo '</div>';

            $jiami1 = 'x=w';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            echo "<div>我的当前积分:".$wj_pk_jf." <a href='pk.php?$url1'>兑换</a></div>";
            echo '<div>我的赛季总积分:'.$wj_pk_zjf.'</div>';

            $pk_jf = pk_jf($pk_pm);

            $jiami1 = 'x=q&k=2';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            echo '<div>当前排名每日奖励:'.$pk_jf.'积分 ';
            if($lingqu_state == 1){
                echo "<a href='pk.php?$url1'>领取</a></div>";
            }else{
                echo '已领取</div>';
            }

            if(isset($lq_pm_jf)){
                echo $lq_pm_jf;
            }

            $sqlHelper = new SqlHelper();
            $sql = "select num,s_name,g_name,pk_zjf from s_user where pk_zjf != 0 order by pk_zjf desc limit 3";
            $res = $sqlHelper->execute_dql2($sql);
            $sqlHelper->close_connect();

            for($i=0;$i<3;$i++){
                if($i == 0){
                    echo '<div>【冠军】: ';
                    if(isset($res[$i]["num"])){
                        if($res[$i]["s_name"] == $_SESSION["id"]){
                            $jiami1 = 'x=q';
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                            echo "<a href='../user/info.php?$url1'>".$res[$i]["g_name"].'</a>';
                        }else{
                            $num = $res[$i]["num"];
                            $jiami1 = 'id='.$num;
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                            echo "<a href='wjinfo.php?$url1'>".$res[$i]["g_name"].'</a>';
                        }
                    }
                    echo '</div>';
                }elseif($i == 1){
                    echo '<div>【亚军】: ';
                    if(isset($res[$i]["num"])){
                        if($res[$i]["s_name"] == $_SESSION["id"]){
                            $jiami1 = 'x=q';
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                            echo "<a href='../user/info.php?$url1'>".$res[$i]["g_name"].'</a>';
                        }else{
                            $num = $res[$i]["num"];
                            $jiami1 = 'id='.$num;
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                            echo "<a href='wjinfo.php?$url1'>".$res[$i]["g_name"].'</a>';
                        }
                    }
                    echo '</div>';
                }elseif($i == 2){
                    echo '<div>【季军】: ';
                    if(isset($res[$i]["num"])){
                        if($res[$i]["s_name"] == $_SESSION["id"]){
                            $jiami1 = 'x=q';
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                            echo "<a href='../user/info.php?$url1'>".$res[$i]["g_name"].'</a>';
                        }else{
                            $num = $res[$i]["num"];
                            $jiami1 = 'id='.$num;
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                            echo "<a href='wjinfo.php?$url1'>".$res[$i]["g_name"].'</a>';
                        }
                    }
                    echo '</div>';
                }
            }


            pk_show_fenye('pk.php',"$dh_fl");
        }
        elseif($dh_fl == 'w'){
            //兑换页面
            echo '<div>【天武榜】</div>';

            if (isset($url_info["k"]) && isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];

                if($gn_fl == 1){
                    $suxin1 = explode(".", $url_info["id"]);
                    $wp_id = $suxin1[0];

                    $sqlHelper = new SqlHelper();
                    $sql = "select wp_id,xh_jf from s_pk_duihuan where num=$wp_id";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();
                    if($res){
                        $sqlHelper = new SqlHelper();
                        $sql = "select wp_name from s_wupin_all where num=$res[wp_id]";
                        $res1 = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();
                        if($res1){
                            $sqlHelper = new SqlHelper();
                            $wj_pk_jf = $sqlHelper->chaxun_wj_user_neirong('pk_jf');
                            $sqlHelper->close_connect();

                            if($wj_pk_jf >= $res["xh_jf"]){
                                $sqlHelper = new SqlHelper();
                                $wj_pk_jf = $sqlHelper->jianshao_wj_user_neirong('pk_jf',$res["xh_jf"]);
                                $sqlHelper->close_connect();

                                require_once '../include/func.php';
                                give_wupin($res["wp_id"],1);
                                echo '<div style="margin-top: 10px;">兑换成功!</div>';
                                echo '<div style="margin-bottom: 10px;">获得'.$res1["wp_name"].'x1</div>';
                            }else{
                                echo '<div style="margin-top: 10px;margin-bottom: 10px;">积分不足，无法兑换该物品</div>';
                            }
                        }else{
                            echo '<div style="margin-top: 10px;margin-bottom: 10px;">该兑换物品不存在</div>';
                        }
                    }else{
                        echo '<div style="margin-top: 10px;margin-bottom: 10px;">该兑换物品不存在</div>';
                    }
                }
            }
            $sqlHelper = new SqlHelper();
            $wj_pk_jf = $sqlHelper->chaxun_wj_user_neirong('pk_jf');
            $sqlHelper->close_connect();

            echo '<div>我的当前积分:'.$wj_pk_jf.'</div>';

            pk_duihuan_show_fenye('pk.php',$dh_fl,$wj_pk_jf);

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<br/><a href='pk.php?$url1'>返回上页</a>";
        }
        elseif($dh_fl == 'e'){
            //竞技场购买次数
            echo '【购买竞技次数】';

            $sqlHelper = new SqlHelper();
            $sql = "select coin,pk_cs,pk_gm_cs from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $wj_pk_cs = $res["pk_cs"];
            $y_gm_cs = $res["pk_gm_cs"];
            $wj_coin = $res["coin"];

            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];

                if($gn_fl == 1){
                    //使用挑战卷购买次数
                    $pk_gm_cs_daoju = pk_gm_cs_daoju();
                    $sqlHelper = new SqlHelper();
                    $wp_counts = $sqlHelper->chaxun_wp_counts($pk_gm_cs_daoju);
                    $sqlHelper->close_connect();

                    if($wp_counts > 0){
                        require_once '../include/func.php';
                        $use_state = use_wupin($pk_gm_cs_daoju,1);
                        if($use_state == 1){
                            $sqlHelper = new SqlHelper();
                            $sql = "update s_user set pk_cs=pk_cs-1,pk_gm_cs=pk_gm_cs+1 where s_name='$_SESSION[id]'";
                            $res = $sqlHelper->execute_dml($sql);
                            $sqlHelper->close_connect();
                            echo '<div style="margin-top: 10px;">购买成功，次数+1</div>';
                            echo '<div style="margin-bottom: 10px;">消耗了'.$pk_gm_cs_daoju.'x1</div>';

                            $wj_pk_cs -= 1;
                            $y_gm_cs += 1;

                        }else{
                            echo '<div style="margin-top: 10px;margin-bottom: 10px;">'.$pk_gm_cs_daoju.'数量不足，购买失败</div>';
                        }
                    }else{
                        echo '<div style="margin-top: 10px;margin-bottom: 10px;">'.$pk_gm_cs_daoju.'数量不足，购买失败</div>';
                    }
                }elseif($gn_fl == 2){
                    //使用仙券购买次数
                    $pk_gm_cs_coin = pk_gm_cs_coin($y_gm_cs);
                    if($wj_coin >= $pk_gm_cs_coin){
                        $sqlHelper = new SqlHelper();
                        $sql = "update s_user set pk_cs=pk_cs-1,pk_gm_cs=pk_gm_cs+1,coin=coin-$pk_gm_cs_coin where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();

                        $wj_pk_cs -= 1;
                        $y_gm_cs += 1;
                        $wj_coin -= $pk_gm_cs_coin;

                    }else{
                        echo '<div style="margin-top: 10px;margin-bottom: 10px;">仙券数量不足，购买失败</div>';
                    }
                }
            }

            $pk_cs = pk_cs();
            $sy_cs = $pk_cs - $wj_pk_cs;
            echo '<div style="margin-bottom: 10px;">今日剩余次数:'.$sy_cs.'</div>';
            echo '<div>请选择购买方式:</div>';

            $jiami1 = 'x=e&k=1';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            $jiami2 = 'x=e&k=2';
            $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

            $pk_gm_cs_daoju = pk_gm_cs_daoju();
            echo '<div>1.'.$pk_gm_cs_daoju."x1 <a href='pk.php?$url1'>购买</a></div>";

            $pk_gm_cs_coin = pk_gm_cs_coin($y_gm_cs);
            echo '<div>2.仙券x'.$pk_gm_cs_coin." <a href='pk.php?$url2'>购买</a></div>";

            echo '<div style="margin-top: 10px;">当前拥有:</div>';
            $sqlHelper = new SqlHelper();
            $wp_counts = $sqlHelper->chaxun_wp_counts($pk_gm_cs_daoju);
            $sqlHelper->close_connect();
            echo '<div>1.'.$pk_gm_cs_daoju.'x'.$wp_counts.'</div>';
            echo '<div>2.仙券x'.$wj_coin.'</div>';

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<br/><a href='pk.php?$url1'>返回上页</a>";
        }
    }
}

require_once '../include/time.php';
?>