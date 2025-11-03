<?php
/**
 * Author: by suxin
 * Date: 2020/1/3
 * Time: 14:48
 * Note: 签到
 */

require_once '../include/fzr.php';
require_once '../include/SqlHelper.class.php';
require_once '../control/control.php';
require_once '../include/func.php';

if(isset($_SESSION['id']) && isset($_SESSION['pass'])) {
    if ($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["x"])) {
            $suxin1 = explode(".", $url_info["x"]);
            $dh_fl = $suxin1[0];

            if ($dh_fl == 'q') {
                //签到首页面

                $sqlHelper = new SqlHelper();
                $sql = "select qd_next_time,qd_month,qd_cs_dy,qd_bq_cs from s_wj_qiandao where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                $month = date("m");

                if ($res) {

                    if ($month != $res["qd_month"]) {
                        $sqlHelper = new SqlHelper();
                        $sql = "delete from s_wj_qiandao where s_name='$_SESSION[id]'";
                        $res1 = $sqlHelper->execute_dml($sql);

                        $sql = "insert into s_wj_qiandao(s_name,qd_month) values('$_SESSION[id]','$month')";
                        $res1 = $sqlHelper->execute_dml($sql);

                        $sqlHelper->close_connect();

                        $qd_next_time = '';
                        $qd_cs_dy = 0;
                        $qd_bq_cs = 0;
                    } else {
                        $qd_next_time = $res["qd_next_time"];
                        $qd_cs_dy = $res["qd_cs_dy"];
                        $qd_bq_cs = $res["qd_bq_cs"];
                    }
                } else {
                    $qd_next_time = '';
                    $qd_cs_dy = 0;
                    $qd_bq_cs = 0;

                    $sqlHelper = new SqlHelper();
                    $sql = "insert into s_wj_qiandao(s_name,qd_month) values('$_SESSION[id]','$month')";
                    $res1 = $sqlHelper->execute_dml($sql);
                    $sqlHelper->close_connect();
                }

                echo "<div class='module-title'>【本月签到】</div>";

                $monty = date("m") * 1;
                $day = date("d") * 1;
                echo "<div>今天日期: " . $monty . "月" . $day . "日</div>";
                $now_time = date("Y-m-d H:i:s");

                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];

                    if ($gn_fl == 1) {
                        if ($qd_next_time == '' || $now_time > $qd_next_time) {
                            $qiandao_coumn = "qd_" . $day;
                            $qd_next_time = date('Y-m-d ', strtotime("+1 day")) . "06:00:00";

                            $sqlHelper = new SqlHelper();
                            $sql = "update s_wj_qiandao set $qiandao_coumn=1,qd_next_time='$qd_next_time',qd_cs_dy=qd_cs_dy+1 where s_name='$_SESSION[id]'";
                            $res = $sqlHelper->execute_dml($sql);
                            $sqlHelper->close_connect();

                            echo '<div style="margin-top: 10px;">签到成功，获得</div>';
                            $qiandao_jiangli = qiandao_jiangli();
                            $qiandao_jiangli = explode('|', $qiandao_jiangli[$day - 1][1]);

                            $qiandao_jiangli_count = count($qiandao_jiangli);
                            for ($i = 0; $i < $qiandao_jiangli_count; $i++) {
                                $jiangli = explode(',', $qiandao_jiangli[$i]);
                                $sqlHelper = new SqlHelper();
                                $sql = "select wp_name from s_wupin_all where num=$jiangli[0]";
                                $res = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();

                                give_wupin($jiangli[0], $jiangli[1]);

                                echo '<div>' . $res["wp_name"] . 'x' . $jiangli[1] . '</div>';
                            }

                            echo '<div style="margin-bottom: 10px;"></div>';
                            $qd_cs_dy += 1;
                        }

                    }
                }

                echo "<div>签到状态: ";

                if ($qd_next_time == '' || $now_time > $qd_next_time) {
                    $jiami1 = 'x=q&k=1';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<a href='qd.php?$url1'>签到</a>";
                } else {
                    echo '已签到';
                }
                echo "</div>";
                echo "<div>本月签到: " . $qd_cs_dy . "次</div>";
                $qiandao_bq_cs = qiandao_bq_cs();
                echo "<div>本月补签: " . $qd_bq_cs . "/".$qiandao_bq_cs."次</div>";
                echo "<div>今日签到奖励: ";
                $qiandao_jiangli = qiandao_jiangli();
                $qiandao_jiangli = explode('|', $qiandao_jiangli[$day - 1][1]);

                $sqlHelper = new SqlHelper();
                $qiandao_jiangli_count = count($qiandao_jiangli);
                for ($i = 0; $i < $qiandao_jiangli_count; $i++) {
                    $jiangli = explode(',', $qiandao_jiangli[$i]);
                    $sql = "select wp_name from s_wupin_all where num=$jiangli[0]";
                    $res = $sqlHelper->execute_dql($sql);

                    echo $res["wp_name"] . 'x' . $jiangli[1];
                    if (($i + 1) < $qiandao_jiangli_count) {
                        echo ',';
                    }
                }
                $sqlHelper->close_connect();

                echo "</div>";

                echo "<ul class='faceul'>";

                $day = date("t");
                $first_dayxq = date("w", strtotime(date("Y-m" . "-01")));  //获取本月第一天星期几
                echo "<li class='font_jiacu'>周天</li>";
                echo "<li class='font_jiacu'>周一</li>";
                echo "<li class='font_jiacu'>周二</li>";
                echo "<li class='font_jiacu'>周三</li>";
                echo "<li class='font_jiacu'>周四</li>";
                echo "<li class='font_jiacu'>周五</li>";
                echo "<li class='font_jiacu'>周六</li>";

                $d = 1; //初始化日期
                $hh_br = 0; //初始化换行
                $first_day = date("Y-m" . "-01"); //本月第一天的日期
                $zongday = 0;   //初始化总天数
                $today_riqi = date("d");

                $sqlHelper = new SqlHelper();
                while ($d <= $day) {
                    if ($d == 1 && $first_dayxq != 0) {
                        for ($i = $first_dayxq; $i > 0; $i--) {
                            $last_monty_day = date("d", strtotime("-$i day,$first_day"));
                            echo "<li class='juwai'>" . $last_monty_day . "</li>";
                            $hh_br++;
                            $zongday++;
                        }
                    }

                    if ($d <= $today_riqi) {

                        $today_column = "qd_" . $d;
                        $sql = "select $today_column from s_wj_qiandao where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dql($sql);

                        if ($d == $today_riqi) {
                            echo "<li><span style='color:red;'>" . $d . "</span><br/>";
                        } else {
                            echo "<li>" . $d . "<br/>";
                        }
                        if ($res && $res["$today_column"]) {
                            echo "<span style='color:green;'>已签</span></li>";
                        } else {
                            if ($d == $today_riqi) {
                                $jiami1 = 'x=q&k=1';
                                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                echo "<a href='qd.php?$url1'>可签</a></li>";
                            } else {
                                $jiami1 = 'x=w&day=' . $d;
                                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                echo "<a href='qd.php?$url1'>补签</a></li>";
                            }
                        }
                    } else {
                        echo "<li class='juwai_li'>" . $d . "</li>";
                    }

                    $hh_br++;
                    $zongday++;
                    $d++;
                    if ($hh_br == 7) {
                        $hh_br = 0;
                        echo "<br/>";
                    }
                }
                $sqlHelper->close_connect();
                $sy_day = 35 - $zongday;

                if ($sy_day) {
                    for ($i = 1; $i <= $sy_day; $i++) {
                        echo "<li class='juwai'>" . $i . "</li>";
                    }
                }

                echo "</ul>";

                echo "<div class='module-title'>【温馨提示】</div>";
                echo "1.每天签到可以领取奖励。<br>";
                echo "2.每天可以签到1次，每天06:00重置签到时间。<br>";
                echo "3.每个月可以补签5次，每次补签需要花费一定的仙券，补签成功后可获得当天的奖励。补签点击本月日历的“补”即可。<br>";
                echo "4.本月日历根据现实实际时间来定，页面显示“签”则已经签到成功，显示“补”则可以进行补签。<br>";

            }
            elseif ($dh_fl == 'w') {
                //补签页面前页

                if (isset($url_info["day"])) {
                    $suxin1 = explode(".", $url_info["day"]);
                    $bq_day = $suxin1[0];

                    echo '<div>【签到补签】</div>';

                    $bq_day = floor($bq_day);
                    $today_day = date("d");

                    if ($bq_day < $today_day) {
                        echo "<div class='module-title'></div>";

                        $sqlHelper = new SqlHelper();
                        $bq_day_name = "qd_" . $bq_day;
                        $sql = "select qd_bq_cs,$bq_day_name from s_wj_qiandao where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();

                        if($res["$bq_day_name"] == 1){
                            echo '<div>当日无需补签</div><br/>';
                        }else{
                            $qiandao_bq_cs = qiandao_bq_cs();

                            echo "<div>本月补签次数:" . $res["qd_bq_cs"] . "/" . $qiandao_bq_cs . "次</div>";

                            echo "<div>当日签到奖励: ";
                            $qiandao_jiangli = qiandao_jiangli();
                            $qiandao_jiangli = explode('|', $qiandao_jiangli[$bq_day - 1][1]);

                            $sqlHelper = new SqlHelper();
                            $qiandao_jiangli_count = count($qiandao_jiangli);
                            for ($i = 0; $i < $qiandao_jiangli_count; $i++) {
                                $jiangli = explode(',', $qiandao_jiangli[$i]);
                                $sql = "select wp_name from s_wupin_all where num=$jiangli[0]";
                                $res1 = $sqlHelper->execute_dql($sql);

                                echo $res1["wp_name"] . 'x' . $jiangli[1];
                                if (($i + 1) < $qiandao_jiangli_count) {
                                    echo ',';
                                }
                            }
                            $sqlHelper->close_connect();

                            echo "</div><br/>";

                            if ($res["qd_bq_cs"] >= $qiandao_bq_cs) {
                                echo '<div>本月签到次数已满.</div>';
                            }
                            else {
                                $qiandao_bq_xq = qiandao_bq_xq();
                                $qiandao_bq_xq *= ($res["qd_bq_cs"] + 1);

                                echo '<div>补签所需' . $qiandao_bq_xq . '仙券，补签成功后，可以获得对应补签奖励</div>';
                                echo '<div>是否确认对本月' . $bq_day . '日进行补签？</div>';

                                $jiami1 = 'x=e&day=' . $bq_day;
                                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                                $jiami2 = 'x=q';
                                $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                                echo "<a href='qd.php?$url1'>确定</a>.<a href='qd.php?$url2'>取消</a><br>";
                            }
                            echo '<br/>';
                        }


                    } else {
                        echo '<div>当日无需补签</div>';
                    }

                    $jiami1 = 'x=q';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<a href='qd.php?$url1'>返回上页</a></li>";
                }
            }
            elseif ($dh_fl == 'e') {
                //补签执行页面

                if (isset($url_info["day"])) {
                    $suxin1 = explode(".", $url_info["day"]);
                    $bq_day = $suxin1[0];

                    echo '<div>【签到补签】</div>';

                    $bq_day = floor($bq_day);
                    $today_day = date("d");

                    if ($bq_day < $today_day) {
                        echo "<div class='module-title'></div>";

                        $sqlHelper = new SqlHelper();
                        $bq_day_name = "qd_" . $bq_day;
                        $sql = "select qd_bq_cs,$bq_day_name from s_wj_qiandao where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();

                        if($res["$bq_day_name"] == 1){
                            echo '<div>当日无需补签</div><br/>';
                        }else{
                            $qiandao_bq_cs = qiandao_bq_cs();

                            if ($res["qd_bq_cs"] >= $qiandao_bq_cs) {
                                echo '<div>本月签到次数已满.</div>';
                            }
                            else {
                                $qiandao_bq_xq = qiandao_bq_xq();
                                $qiandao_bq_xq *= ($res["qd_bq_cs"] + 1);

                                        $sqlHelper = new SqlHelper();
                                        $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');
                                        $sqlHelper->close_connect();
                                        if($wj_coin >= $qiandao_bq_xq){
                                            $qiandao_coumn = "qd_" . $bq_day;
                                            $sqlHelper = new SqlHelper();
                                            $sqlHelper->jianshao_wj_user_neirong('coin',$qiandao_bq_xq);
                                            $sql = "update s_wj_qiandao set $qiandao_coumn=1,qd_cs_dy=qd_cs_dy+1,qd_bq_cs=qd_bq_cs+1 where s_name='$_SESSION[id]'";
                                            $res = $sqlHelper->execute_dml($sql);
                                            $sqlHelper->close_connect();

                                            echo '<div style="margin-top: 10px;">补签成功，获得</div>';
                                            $qiandao_jiangli = qiandao_jiangli();
                                            $qiandao_jiangli = explode('|', $qiandao_jiangli[$bq_day - 1][1]);
                                            $qiandao_jiangli_count = count($qiandao_jiangli);

                                            for ($i = 0; $i < $qiandao_jiangli_count; $i++) {
                                                $jiangli = explode(',', $qiandao_jiangli[$i]);
                                                $sqlHelper = new SqlHelper();
                                                $sql = "select wp_name from s_wupin_all where num=$jiangli[0]";
                                                $res = $sqlHelper->execute_dql($sql);
                                                $sqlHelper->close_connect();

                                                give_wupin($jiangli[0], $jiangli[1]);

                                                echo '<div>' . $res["wp_name"] . 'x' . $jiangli[1] . '</div>';
                                            }

                                            echo '<div style="margin-bottom: 10px;"></div>';

                                        }else{
                                            echo '<div>仙券不足，无法进行补签</div>';
                                        }


                            }
                            echo '<br/>';
                        }


                    } else {
                        echo '<div>当日无需补签</div>';
                    }

                    $jiami1 = 'x=q';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<a href='qd.php?$url1'>返回上页</a></li>";
                }
            }
        }
    }
}

require_once '../include/time.php';
?>