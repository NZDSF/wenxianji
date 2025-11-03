<?php
/**
 * Author: by suxin
 * Date: 2020/1/5
 * Time: 8:50
 * Note: VIP特权
 */

require_once '../include/fzr.php';
require_once '../control/control.php';
require_once '../include/func.php';

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            echo '<div>【VIP特权】</div>';

            $jiami1 = 'x=r';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            $jiami2 = 'x=u';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

            echo "<div style='margin-bottom: 10px;'><a href='vip.php?$url2'>VIP</a> 月卡 <a href='vip.php?$url1'>至尊VIP</a></div>";

            $sqlHelper = new SqlHelper();
            $sql = "select zhizun_vip,yueka_next_time,yueka_stop_time from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $now_time = date("Y-m-d H:i:s");
            if($res["zhizun_vip"] || $now_time < $res["yueka_stop_time"]){
                if($res["zhizun_vip"]){
                    echo '<div>月卡状态: 永久</div>';
                }else{
                    $zhuanhuan_sy_time_day = zhuanhuan_sy_time_day($res["yueka_stop_time"]);
                    echo '<div>月卡状态: '.$zhuanhuan_sy_time_day.'后到期</div>';
                }

                echo '<div style="margin-top: 5px;">每日奖励:';
                if($res["yueka_next_time"] == '' || $now_time > $res["yueka_next_time"]){
                    $jiami1 = 'x=e';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo " <a href='vip.php?$url1'>领取</a>";
                }else{
                    echo ' 已领取';
                }
                echo '</div>';
            }else{
                $jiami1 = 'x=w';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div>月卡状态: 未开通 <a href='vip.php?$url1'>开通</a></div>";

                echo '<div style="margin-top: 5px;">每日奖励: </div>';
            }

            $yueka_jiangli = yueka_jiangli();
            $yueka_jiangli = explode("|",$yueka_jiangli);
            $yueka_jiangli_count = count($yueka_jiangli);

            $sqlHelper = new SqlHelper();
            for($i=0;$i<$yueka_jiangli_count;$i++){
                $jiangli = explode(",",$yueka_jiangli[$i]);
                if($jiangli[0] == 'money'){
                    echo '<div>灵石x'.$jiangli[1].'</div>';
                }elseif($jiangli[0] == 'coin'){
                    echo '<div>仙券x'.$jiangli[1].'</div>';
                }elseif($jiangli[0] == 'wp'){
                    $sql = "select wp_name from s_wupin_all where num=$jiangli[1]";
                    $res = $sqlHelper->execute_dql($sql);
                    echo '<div>'.$res["wp_name"].'x'.$jiangli[2].'</div>';
                }
            }
            $sqlHelper->close_connect();

            echo '<div style="margin-top: 10px;">月卡说明:</div>';
            echo '<div>1.开通月卡则获得月卡专属头衔<img class="tx_img" src="../images/yk.gif"></div>';
            $yueka_biguan_xishu = yueka_biguan_xishu();
            echo '<div>2.开通月卡则永久加成'.$yueka_biguan_xishu.'%修炼经验</div>';
            $wabao_ykcishu = wabao_ykcishu();
            echo '<div>2.开通月卡则永久增加'.$wabao_ykcishu.'次大雁塔挖宝次数</div>';

        }
        elseif($dh_fl == 'w'){
            //开通月卡前页
            echo '<div>【开通月卡】</div>';

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            $jiami2 = 'x=w&k=1';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
            $jiami3 = 'x=w';
            $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);

            $sqlHelper = new SqlHelper();
            $sql = "select zhizun_vip,yueka_next_time,yueka_stop_time from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $kaitong_tishi_state = 1;

            $now_time = date("Y-m-d H:i:s");
            if($res["zhizun_vip"] || $now_time < $res["yueka_stop_time"]){
                $kaitong_tishi_state = 0;
                echo "<div>你当前已开通月卡，无需重复开通！</div>";
            }

            if($kaitong_tishi_state == 1){
                $yueka_daoju = yueka_daoju();

                $sqlHelper = new SqlHelper();
                $wp_count = $sqlHelper->chaxun_wp_counts($yueka_daoju);
                $sqlHelper->close_connect();

                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];

                    if($gn_fl == 1){
                        if($wp_count > 0){
                            $use_state = use_wupin($yueka_daoju,1);
                            if($use_state == 1){
                                $stop_time = date('Y-m-d H:i:s', strtotime("+30 day") );
                                $sqlHelper = new SqlHelper();
                                $sqlHelper->xiugai_wj_user_neirong('yueka_stop_time',$stop_time);
                                $sqlHelper->close_connect();
                                echo "<div>恭喜你，成功开通月卡！</div>";
                            }else{
                                echo "<div>所需道具数量不足，无法开通月卡！<a href='shop.php?$url1'>购买</a></div>";
                            }
                        }else{
                            echo "<div>所需道具数量不足，无法开通月卡！<a href='shop.php?$url1'>购买</a></div>";
                        }

                        echo "<div><a href='vip.php?$url3'>返回上页</a></div>";
                    }

                    require_once '../include/time.php';
                    exit;
                }

                echo "<div>开通月卡需要消耗:</div>";
                echo '<div style="margin-bottom: 5px;">'.$yueka_daoju.'x1</div>';
                echo "<div>当前拥有:</div>";

                echo '<div>'.$yueka_daoju.'x'.$wp_count;
                if($wp_count == 0){
                    echo " <a href='shop.php?$url1'>购买</a>";
                }
                echo '</div>';

                if($wp_count > 0){
                    echo "<div><a href='vip.php?$url2'>确认开通</a></div>";
                }
            }

            echo "<div style='margin-top: 10px;'><a href='vip.php?$url1'>返回上页</a></div>";
        }
        elseif($dh_fl == 'e') {
            //领取月卡奖励
            echo '<div>【VIP特权】</div>';

            $sqlHelper = new SqlHelper();
            $sql = "select zhizun_vip,yueka_next_time,yueka_stop_time from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $now_time = date("Y-m-d H:i:s");
            if ($res["zhizun_vip"] || $now_time < $res["yueka_stop_time"]) {
                if ($res["yueka_next_time"] == '' || $now_time > $res["yueka_next_time"]) {

                    $next_time = date('Y-m-d ', strtotime("+1 day")) . "06:00:00";

                    $sqlHelper = new SqlHelper();
                    $sqlHelper->xiugai_wj_user_neirong('yueka_next_time',"$next_time");
                    $sqlHelper->close_connect();

                    echo '<div>领取成功，获得</div>';
                    $yueka_jiangli = yueka_jiangli();
                    $yueka_jiangli = explode("|", $yueka_jiangli);
                    $yueka_jiangli_count = count($yueka_jiangli);

                    for ($i = 0; $i < $yueka_jiangli_count; $i++) {
                        $jiangli = explode(",", $yueka_jiangli[$i]);
                        if ($jiangli[0] == 'money') {
                            $sqlHelper = new SqlHelper();
                            $sqlHelper->add_wj_user_neirong('money', $jiangli[1]);
                            $sqlHelper->close_connect();

                            echo '<div>灵石x' . $jiangli[1] . '</div>';
                        } elseif ($jiangli[0] == 'coin') {
                            $sqlHelper = new SqlHelper();
                            $sqlHelper->add_wj_user_neirong('coin', $jiangli[1]);
                            $sqlHelper->close_connect();

                            echo '<div>仙券x' . $jiangli[1] . '</div>';
                        } elseif ($jiangli[0] == 'wp') {
                            $sqlHelper = new SqlHelper();
                            $sql = "select wp_name from s_wupin_all where num=$jiangli[1]";
                            $res = $sqlHelper->execute_dql($sql);
                            $sqlHelper->close_connect();
                            echo '<div>' . $res["wp_name"] . 'x' . $jiangli[2] . '</div>';
                            give_wupin($jiangli[1], $jiangli[2]);
                        }
                    }
                } else {
                    echo '<div>你已领取过了今日奖励</div>';
                }
            }else{
                echo '<div>你的月卡已到期，无法领取奖励</div>';
            }

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<div style='margin-top: 5px;'><a href='vip.php?$url1'>返回上页</a></div>";
        }
        elseif($dh_fl == 'r'){
            //至尊VIP
            echo '<div>【VIP特权】</div>';

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            $jiami2 = 'x=u';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

            echo "<div style='margin-bottom: 10px;'><a href='vip.php?$url2'>VIP</a> <a href='vip.php?$url1'>月卡</a> 至尊VIP</div>";

            $sqlHelper = new SqlHelper();
            $sql = "select zhizun_vip,zhizun_vip_lq_jiangli from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $now_time = date("Y-m-d H:i:s");
            if($res["zhizun_vip"]){
                echo '<div style="margin-top: 5px;">至尊VIP奖励:';
                if($res["zhizun_vip_lq_jiangli"]){
                    echo ' 已领取';

                }else{
                    $jiami1 = 'x=y';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo " <a href='vip.php?$url1'>领取</a>";
                }
                echo '</div>';
            }else{
                $jiami1 = 'x=t';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div>至尊VIP状态: 未开通 <a href='vip.php?$url1'>开通</a></div>";

                echo '<div style="margin-top: 5px;">至尊VIP奖励: 未领取</div>';
            }

            $yueka_jiangli = zzvip_jiangli();
            $yueka_jiangli = explode("|",$yueka_jiangli);
            $yueka_jiangli_count = count($yueka_jiangli);

            $sqlHelper = new SqlHelper();
            for($i=0;$i<$yueka_jiangli_count;$i++){
                $jiangli = explode(",",$yueka_jiangli[$i]);
                if($jiangli[0] == 'money'){
                    echo '<div>灵石x'.$jiangli[1].'</div>';
                }elseif($jiangli[0] == 'coin'){
                    echo '<div>仙券x'.$jiangli[1].'</div>';
                }elseif($jiangli[0] == 'wp'){
                    $sql = "select wp_name from s_wupin_all where num=$jiangli[1]";
                    $res = $sqlHelper->execute_dql($sql);
                    echo '<div>'.$res["wp_name"].'x'.$jiangli[2].'</div>';
                }
            }
            $sqlHelper->close_connect();

            echo '<div style="margin-top: 10px;">至尊VIP属性加成:</div>';
            $zzvip_shuxing = zzvip_shuxing();
            $zzvip_shuxing = explode("|",$zzvip_shuxing);
            for($i=0;$i<count($zzvip_shuxing);$i++){
                $shuxing = explode(",",$zzvip_shuxing[$i]);
                if($shuxing[0] == 'gj'){
                    echo '<div>攻击+'.$shuxing[1].'</div>';
                }elseif($shuxing[0] == 'fy'){
                    echo '<div>防御+'.$shuxing[1].'</div>';
                }elseif($shuxing[0] == 'hp'){
                    echo '<div>生命+'.$shuxing[1].'</div>';
                }
            }

            echo '<div style="margin-top: 10px;">至尊VIP说明:</div>';
            echo '<div>1.开通至尊VIP则永久开通月卡服务</div>';
            echo '<div>2.开通至尊VIP则获得至尊专属头衔<img class="tx_img" src="../images/zz.gif"></div>';
            $zhizunvip_biguan_xishu = zhizunvip_biguan_xishu();
            echo '<div>3.开通至尊VIP则永久加成'.$zhizunvip_biguan_xishu.'%修炼经验</div>';
            $wabao_zzcishu = wabao_zzcishu();
            echo '<div>3.开通至尊VIP则永久增加'.$wabao_zzcishu.'次大雁塔挖宝次数</div>';
        }
        elseif($dh_fl == 't'){
            //开通至尊VIP月卡前页
            echo '<div>【开通至尊VIP】</div>';

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            $jiami2 = 'x=r';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);
            $jiami3 = 'x=t&k=1';
            $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);

            $sqlHelper = new SqlHelper();
            $sql = "select zhizun_vip from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $kaitong_tishi_state = 1;

            $now_time = date("Y-m-d H:i:s");
            if($res["zhizun_vip"]){
                $kaitong_tishi_state = 0;
                echo "<div>你当前已开通至尊VIP，无需重复开通！</div>";
            }

            if($kaitong_tishi_state == 1){
                $yueka_daoju = zzvip_daoju();

                $sqlHelper = new SqlHelper();
                $wp_count = $sqlHelper->chaxun_wp_counts($yueka_daoju);
                $sqlHelper->close_connect();

                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];

                    if($gn_fl == 1){
                        if($wp_count > 0){
                            $use_state = use_wupin($yueka_daoju,1);
                            if($use_state == 1){
                                $sqlHelper = new SqlHelper();
                                $sqlHelper->xiugai_wj_user_neirong('zhizun_vip',1);
                                $sqlHelper->close_connect();
                                echo "<div>恭喜你，成功开通至尊VIP！</div>";
                            }else{
                                echo "<div>所需道具数量不足，无法开通至尊VIP！<a href='shop.php?$url1'>购买</a></div>";
                            }
                        }else{
                            echo "<div>所需道具数量不足，无法开通至尊VIP！<a href='shop.php?$url1'>购买</a></div>";
                        }

                        echo "<div><a href='vip.php?$url2'>返回上页</a></div>";
                    }

                    require_once '../include/time.php';
                    exit;
                }

                echo "<div>开通至尊VIP需要消耗:</div>";
                echo '<div style="margin-bottom: 5px;">'.$yueka_daoju.'x1</div>';
                echo "<div>当前拥有:</div>";

                echo '<div>'.$yueka_daoju.'x'.$wp_count;
                if($wp_count == 0){
                    echo " <a href='shop.php?$url1'>购买</a>";
                }
                echo '</div>';

                if($wp_count > 0){
                    echo "<div><a href='vip.php?$url3'>确认开通</a></div>";
                }
            }

            echo "<div style='margin-top: 10px;'><a href='vip.php?$url2'>返回上页</a></div>";
        }
        elseif($dh_fl == 'y') {
            //领取至尊VIP奖励
            echo '<div>【VIP特权】</div>';

            $sqlHelper = new SqlHelper();
            $sql = "select zhizun_vip,zhizun_vip_lq_jiangli from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $now_time = date("Y-m-d H:i:s");
            if ($res["zhizun_vip"]) {
                if ($res["zhizun_vip_lq_jiangli"] == 0) {
                    $sqlHelper = new SqlHelper();
                    $sqlHelper->xiugai_wj_user_neirong('zhizun_vip_lq_jiangli',1);
                    $sqlHelper->close_connect();

                    echo '<div>领取成功，获得</div>';
                    $yueka_jiangli = zzvip_jiangli();
                    $yueka_jiangli = explode("|", $yueka_jiangli);
                    $yueka_jiangli_count = count($yueka_jiangli);

                    for ($i = 0; $i < $yueka_jiangli_count; $i++) {
                        $jiangli = explode(",", $yueka_jiangli[$i]);
                        if ($jiangli[0] == 'money') {
                            $sqlHelper = new SqlHelper();
                            $sqlHelper->add_wj_user_neirong('money', $jiangli[1]);
                            $sqlHelper->close_connect();

                            echo '<div>灵石x' . $jiangli[1] . '</div>';
                        } elseif ($jiangli[0] == 'coin') {
                            $sqlHelper = new SqlHelper();
                            $sqlHelper->add_wj_user_neirong('coin', $jiangli[1]);
                            $sqlHelper->close_connect();

                            echo '<div>仙券x' . $jiangli[1] . '</div>';
                        } elseif ($jiangli[0] == 'wp') {
                            $sqlHelper = new SqlHelper();
                            $sql = "select wp_name from s_wupin_all where num=$jiangli[1]";
                            $res = $sqlHelper->execute_dql($sql);
                            $sqlHelper->close_connect();
                            echo '<div>' . $res["wp_name"] . 'x' . $jiangli[2] . '</div>';
                            give_wupin($jiangli[1], $jiangli[2]);
                        }
                    }
                } else {
                    echo '<div>你已领取过了至尊VIP奖励</div>';
                }
            }else{
                echo '<div>你当前未开通至尊VIP，无法领取奖励</div>';
            }

            $jiami1 = 'x=r';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<div style='margin-top: 5px;'><a href='vip.php?$url1'>返回上页</a></div>";
        }
        elseif($dh_fl == 'u'){
            //普通vip特权说明
            echo '<div>【VIP特权】</div>';

            $jiami1 = 'x=r';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            $jiami2 = 'x=q';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

            echo "<div style='margin-bottom: 10px;'>VIP <a href='vip.php?$url2'>月卡</a> <a href='vip.php?$url1'>至尊VIP</a></div>";

            $sqlHelper = new SqlHelper();
            $sql = "select cz_jf from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $vip_dj = vip_dj($res["cz_jf"]);
            $vip_nlsx_hfcs = vip_nlsx_hfcs($vip_dj);
            $vip_biguan_xishu = vip_biguan_xishu($vip_dj);
            $wabao_vipcishu = wabao_vipcishu();

            echo '<div>我的VIP等级: '.$vip_dj.'</div>';
            echo '<div>当前已增加耐力: '.$vip_nlsx_hfcs[0].'点</div>';
            echo '<div>当前已增加耐力恢复次数: '.$vip_nlsx_hfcs[1].'次</div>';
            echo '<div>当前已增加修炼经验: '.$vip_biguan_xishu.'%</div>';
            echo '<div>当前已增加挖宝次数: '.$wabao_vipcishu * $vip_dj.'次</div>';

            echo '<div style="margin-top: 10px;">VIP说明:</div>';
            echo '<div>1.每级VIP可额外增加'.$vip_nlsx_hfcs[2].'点耐力</div>';
            echo '<div>2.每级VIP可额外使用耐力丹次数'.$vip_nlsx_hfcs[3].'次</div>';
            $vip_biguan_xishu = vip_biguan_xishu(1);
            echo '<div>3.每级VIP则永久加成'.$vip_biguan_xishu.'%修炼经验</div>';
            echo '<div>4.每级VIP则永久增加'.$wabao_vipcishu.'次大雁塔挖宝次数</div>';

        }
    }
}


require_once '../include/time.php';
?>