<?php
/**
 * Author: by suxin
 * Date: 2019/12/3
 * Time: 17:05
 * Note: 人物信息展示
 */

require_once '../include/fzr.php';
require_once '../control/control.php';
require_once 'wj_all_zt.php';
require_once '../include/func.php';

//玩家信息导航页
function daohang_array()
{
    return array(
        array('q', '状态'),
        array('w', '装备'),
        array('r', '仙术'),
        array('t', '天赋'),
    );
}

if(isset($_SESSION['id']) && isset($_SESSION['pass'])) {
    if ($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["x"])) {
            $suxin1 = explode(".", $url_info["x"]);
            $dh_fl = $suxin1[0];

            if($dh_fl == 'q' || $dh_fl == 'w' || $dh_fl == 'r' || $dh_fl == 't') {
                //玩家信息
                $sqlHelper = new SqlHelper();
                $sql = "select g_name,dj,num,gongxun,df_sl,df_sb,chenghao,mood,pk_pm,bangpai,sex,xianlv,cz_jf,yueka_stop_time,zhizun_vip from s_user where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                $jiami1 = "x=q";
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                if ($dh_fl == 'q') {
                    echo '<div>【我的状态】</div>';
                } elseif ($dh_fl == 'w') {
                    echo '<div>【我的装备】</div>';
                } elseif ($dh_fl == 'r') {
                    echo '<div>【我的仙术】</div>';
                } elseif ($dh_fl == 't') {
                    echo '<div>【我的天赋】</div>';
                }

                echo '<div>昵称:' . $res["g_name"].' ';
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

                echo ' (' . $res["dj"] . '级)';

                echo '</div>';
                $wj_vip = vip_dj($res["cz_jf"]);
                echo '<div>VIP:' . $wj_vip . '</div>';
                echo '<div>ID:' . $res["num"] . '</div>';

                $daohang_array = daohang_array();

                $count_daohang = count($daohang_array);

                for ($i = 0; $i < $count_daohang; $i++) {

                    $jiami1 = "x=" . $daohang_array[$i][0];
                    $url10 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    if ($dh_fl == $daohang_array[$i][0]) {
                        echo $daohang_array[$i][1];
                        $bag_url_fl = $daohang_array[$i][0];
                    } else {
                        echo "<a href='info.php?$url10'>" . $daohang_array[$i][1] . '</a>';
                    }

                    if (($i + 1) < $count_daohang) {
                        echo ' | ';
                    }
                }

                if ($dh_fl == 'q') {
                    echo '<div>性别:' . $res["sex"] . '</div>';
                    echo '<div>心情:';
                    if ($res["mood"]) {
                        $mood = $res["mood"];
                    } else {
                        $mood = '更改';
                    }
                    echo "<a href='xq.php?$url1'>" . $mood . "</a>";
                    echo '</div>';
                    echo '<div>胜利:' . ($res["df_sl"] + $res["df_sb"]) . '场' . $res["df_sl"] . '胜' . $res["df_sb"] . '败</div>';
                    echo "<div>称号:<a href='ch.php?$url1'>";
                    if ($res["chenghao"]) {
                        echo $res["chenghao"];
                    } else {
                        echo '暂无称号';
                    }
                    echo '</a></div>';
                    echo '<div>魅力:0</div>';
                    echo '<div>天武排名:' . $res["pk_pm"] . "名 <a href='../xy/pk.php?$url1'>去挑战</a></div>";
                    echo '<div>仙侣:';
                    if ($res["xianlv"]) {
                        $sqlHelper = new SqlHelper();
                        $sql = "select num,g_name,cz_jf,yueka_stop_time,zhizun_vip from s_user where s_name='$res[xianlv]'";
                        $res1 = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();

                        $jiami1 = 'id=' . $res1["num"];
                        $url2 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        echo "<a href='../xy/wjinfo.php?$url2'>" . $res1["g_name"] . "</a>";

                        if ($res1["zhizun_vip"]) {
                            echo '<img class="tx_img" src="../images/zz.gif">';
                            echo '<img class="tx_img" src="../images/yk.gif">';
                        } else {
                            $now_time = date("Y-m-d H:i:s");
                            if ($now_time < $res1["yueka_stop_time"]) {
                                echo '<img class="tx_img" src="../images/yk.gif">';
                            }
                        }
                        if ($res1["cz_jf"]) {
                            echo '<img class="tx_img" src="../images/vip.gif">';
                        }

                        echo '<img class="tx_img" src="../images/xl.gif">';

                    } else {
                        echo '无';
                    }
                    echo '</div>';
                    echo '<div>帮派:';
                    if ($res["bangpai"]) {
                        $bp_name = $res["bangpai"];
                    } else {
                        $bp_name = '无';
                    }
                    echo "<a href='../xy/bp.php?$url1'>" . $bp_name . "</a>";
                    echo '</div>';
                    echo '<div>功勋:' . $res["gongxun"] . '</div>';

                    echo '<br/>';

                    $wj_all_zt_add_zhi = wj_all_zt_add_zhi($_SESSION["id"], $res["dj"]);
                    echo '<div>人物属性</div>';
                    echo '<div>攻击:' . $wj_all_zt_add_zhi[0] . '</div>';
                    echo '<div>防御:' . $wj_all_zt_add_zhi[2] . '</div>';
                    echo '<div>生命:' . $wj_all_zt_add_zhi[3] . '</div>';
                    echo '<div>仙气:' . $wj_all_zt_add_zhi[1] . '</div>';
                    echo '<div>速度:' . $wj_all_zt_add_zhi[6] . '</div>';
                    echo '<div>暴击:' . $wj_all_zt_add_zhi[4] . '</div>';
                    echo '<div>韧性:' . $wj_all_zt_add_zhi[5] . '</div>';

                    echo '<br/>';
                } elseif ($dh_fl == 'w') {
                    //装备首页

                    $wuqi = chaxun_zhuangbei('wuqi');           //武器
                    $yifu = chaxun_zhuangbei('yifu');           //衣服
                    $yaodai = chaxun_zhuangbei('yaodai');       //腰带
                    $xuezi = chaxun_zhuangbei('xuezi');         //靴子
                    $maozi = chaxun_zhuangbei('maozi');         //帽子
                    $jiezhi = chaxun_zhuangbei('jiezhi');       //戒指


                    if ($maozi) {
                        $jiami1 = "x=y&id=" . $maozi["num"];
                        $jiami2 = "x=q&id=" . $maozi["num"];
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                        echo "<div>帽子: <a href='info.php?$url1'>" . $maozi['zb_pinzhi'] . $maozi['zb_name'] . '</a> ' . $maozi['zb_dj'] . "级</div>";
                    } else {
                        $jiami1 = "id=5";
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div>帽子: <a href='cdzb.php?$url1'>无</a></div>";
                    }

                    if ($jiezhi) {
                        $jiami1 = "x=y&id=" . $jiezhi["num"];
                        $jiami2 = "x=q&id=" . $jiezhi["num"];
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                        echo "<div>戒指: <a href='info.php?$url1'>" . $jiezhi['zb_pinzhi'] . $jiezhi['zb_name'] . '</a> ' . $jiezhi['zb_dj'] . "级</div>";
                    } else {
                        $jiami1 = "id=6";
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div>戒指: <a href='cdzb.php?$url1'>无</a></div>";
                    }

                    if ($wuqi) {
                        $jiami1 = "x=y&id=" . $wuqi["num"];
                        $jiami2 = "x=q&id=" . $wuqi["num"];
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                        echo "<div>武器: <a href='info.php?$url1'>" . $wuqi['zb_pinzhi'] . $wuqi['zb_name'] . '</a> ' . $wuqi['zb_dj'] . "级</div>";
                    } else {
                        $jiami1 = "id=1";
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div>武器: <a href='cdzb.php?$url1'>无</a></div>";
                    }

                    if ($yifu) {
                        $jiami1 = "x=y&id=" . $yifu["num"];
                        $jiami2 = "x=q&id=" . $yifu["num"];
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                        echo "<div>衣服: <a href='info.php?$url1'>" . $yifu['zb_pinzhi'] . $yifu['zb_name'] . '</a> ' . $yifu['zb_dj'] . "级</div>";
                    } else {
                        $jiami1 = "id=2";
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div>衣服: <a href='cdzb.php?$url1'>无</a></div>";
                    }

                    if ($yaodai) {
                        $jiami1 = "x=y&id=" . $yaodai["num"];
                        $jiami2 = "x=q&id=" . $yaodai["num"];
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                        echo "<div>腰带: <a href='info.php?$url1'>" . $yaodai['zb_pinzhi'] . $yaodai['zb_name'] . '</a> ' . $yaodai['zb_dj'] . "级</div>";
                    } else {
                        $jiami1 = "id=3";
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div>腰带: <a href='cdzb.php?$url1'>无</a></div>";
                    }

                    if ($xuezi) {
                        $jiami1 = "x=y&id=" . $xuezi["num"];
                        $jiami2 = "x=q&id=" . $xuezi["num"];
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                        echo "<div>靴子: <a href='info.php?$url1'>" . $xuezi['zb_pinzhi'] . $xuezi['zb_name'] . '</a> ' . $xuezi['zb_dj'] . "级</div>";
                    } else {
                        $jiami1 = "id=4";
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div>靴子: <a href='cdzb.php?$url1'>无</a></div>";
                    }
                    echo '<br/>';
                } elseif ($dh_fl == 'r') {
                    //仙术
                    $sqlHelper = new SqlHelper();
                    $sql = "select skill_num,skill_dj from s_wj_skill where s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dql2($sql);

                    echo '<div>【已学习】</div>';

                    $zhudong_skill_array = array();
                    $beidong_skill_array = array();

                    for ($j = 0; $j < count($res); $j++) {
                        $wj_skill_num = $res[$j]["skill_num"];
                        $skill_dj = $res[$j]["skill_dj"];
                        $sql = "select skill_fl,skill_name from s_skill_all where num=$wj_skill_num";
                        $res1 = $sqlHelper->execute_dql($sql);
                        $jiami1 = "x=d&id=" . $wj_skill_num;
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        if ($res1["skill_fl"] == 'zd') {
                            $zhudong_skill_array [] = "<div><a href='info.php?$url1'>" . $res1["skill_name"] . "</a> " . $skill_dj . "阶</div>";
                        } else {
                            $beidong_skill_array [] = "<div><a href='info.php?$url1'>" . $res1["skill_name"] . "</a> " . $skill_dj . "阶</div>";
                        }
                    }

                    echo '<div>主动技能</div>';
                    for ($i = 0; $i < count($zhudong_skill_array); $i++) {
                        echo $zhudong_skill_array[$i];
                    }
                    echo '<div style="margin-top: 10px;">被动技能</div>';
                    for ($i = 0; $i < count($beidong_skill_array); $i++) {
                        echo $beidong_skill_array[$i];
                    }

                    $sql = "select skill_fl,skill_name,num from s_skill_all";
                    $res1 = $sqlHelper->execute_dql2($sql);
                    $sqlHelper->close_connect();

                    echo '<div style="margin-top: 10px;">【未学习】</div>';

                    echo '<div>主动技能</div>';

                    for ($i = 0; $i < count($res1); $i++) {
                        $skill_num = $res1[$i]["num"];
                        $skill_name = $res1[$i]["skill_name"];
                        $skill_fl = $res1[$i]["skill_fl"];

                        if ($skill_fl == 'bd') {
                            continue;
                        }

                        if ($res1) {
                            $tiaoguo_state = 0;

                            for ($j = 0; $j < count($res); $j++) {
                                $wj_skill_num = $res[$j]["skill_num"];
                                if ($wj_skill_num == $skill_num) {
                                    $tiaoguo_state = 1;
                                    continue;
                                }
                            }

                            if ($tiaoguo_state == 0) {
                                $jiami1 = "x=d&id=" . $skill_num;
                                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                echo "<div><a href='info.php?$url1'>" . $skill_name . "</a></div>";
                            }
                        }
                    }

                    echo '<div style="margin-top: 10px;">被动技能</div>';

                    for ($i = 0; $i < count($res1); $i++) {
                        $skill_num = $res1[$i]["num"];
                        $skill_name = $res1[$i]["skill_name"];
                        $skill_fl = $res1[$i]["skill_fl"];

                        if ($skill_fl == 'zd') {
                            continue;
                        }

                        if ($res1) {
                            $tiaoguo_state = 0;

                            for ($j = 0; $j < count($res); $j++) {
                                $wj_skill_num = $res[$j]["skill_num"];
                                if ($wj_skill_num == $skill_num) {
                                    $tiaoguo_state = 1;
                                    continue;
                                }
                            }

                            if ($tiaoguo_state == 0) {
                                $jiami1 = "x=d&id=" . $skill_num;
                                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                echo "<div><a href='info.php?$url1'>" . $skill_name . "</a></div>";
                            }
                        }
                    }

                    echo '<br/>';
                } elseif ($dh_fl == 't') {
                    //玩家天赋
                    if (isset($url_info["id"]) && isset($url_info["d"])) {
                        $suxin1 = explode(".", $url_info["id"]);
                        $lb_fl = $suxin1[0];
                        $suxin2 = explode(".", $url_info["d"]);
                        $zj_ds = $suxin2[0];

                        if ($lb_fl == 1 || $lb_fl == 2 || $lb_fl == 3 || $lb_fl == 4 || $lb_fl == 5) {
                            if ($zj_ds == 1 || $zj_ds == 3 || $zj_ds == 5) {
                                $sqlHelper = new SqlHelper();
                                $wj_tianfu = $sqlHelper->chaxun_wj_user_neirong('tianfu');

                                if ($wj_tianfu >= $zj_ds) {
                                    $sqlHelper->jianshao_wj_user_neirong('tianfu', $zj_ds);
                                    if ($lb_fl == 1) {
                                        $sqlHelper->add_wj_user_neirong('tf_wx', $zj_ds);
                                    } elseif ($lb_fl == 2) {
                                        $sqlHelper->add_wj_user_neirong('tf_lq', $zj_ds);
                                    } elseif ($lb_fl == 3) {
                                        $sqlHelper->add_wj_user_neirong('tf_jg', $zj_ds);
                                    } elseif ($lb_fl == 4) {
                                        $sqlHelper->add_wj_user_neirong('tf_xm', $zj_ds);
                                    } elseif ($lb_fl == 5) {
                                        $sqlHelper->add_wj_user_neirong('tf_sf', $zj_ds);
                                    }
                                }
                                $sqlHelper->close_connect();
                            }
                        }
                    }


                    $sqlHelper = new SqlHelper();
                    $sql = "select tianfu,tf_wx,tf_lq,tf_jg,tf_xm,tf_sf,cz_jf from s_user where s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    echo '<div>天赋点可提升人物基础属性，10级后每升一级可获得3点天赋点</div>';
                    echo '<div>【可分配天赋】:' . $res["tianfu"] . '</div>';

                    $jiami11 = "x=s&id=1";
                    $url11 = encrypt_url("$jiami11.$date", $key_url_md_5);
                    $jiami12 = "x=s&id=2";
                    $url12 = encrypt_url("$jiami12.$date", $key_url_md_5);
                    $jiami13 = "x=s&id=3";
                    $url13 = encrypt_url("$jiami13.$date", $key_url_md_5);
                    $jiami14 = "x=s&id=4";
                    $url14 = encrypt_url("$jiami14.$date", $key_url_md_5);
                    $jiami15 = "x=s&id=5";
                    $url15 = encrypt_url("$jiami15.$date", $key_url_md_5);

                    echo "<div><a href='info.php?$url11'>悟性</a>:" . $res["tf_wx"];
                    if ($res["tianfu"] >= 1) {
                        $jiami3 = "x=t&id=1&d=1";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+1</a>";
                    }
                    if ($res["tianfu"] >= 3) {
                        $jiami3 = "x=t&id=1&d=3";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+3</a>";
                    }
                    if ($res["tianfu"] >= 5) {
                        $jiami3 = "x=t&id=1&d=5";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+5</a>";
                    }
                    echo '</div>';
                    echo "<div><a href='info.php?$url12'>灵气</a>:" . $res["tf_lq"];
                    if ($res["tianfu"] >= 1) {
                        $jiami3 = "x=t&id=2&d=1";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+1</a>";
                    }
                    if ($res["tianfu"] >= 3) {
                        $jiami3 = "x=t&id=2&d=3";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+3</a>";
                    }
                    if ($res["tianfu"] >= 5) {
                        $jiami3 = "x=t&id=2&d=5";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+5</a>";
                    }
                    echo '</div>';
                    echo "<div><a href='info.php?$url13'>筋骨</a>:" . $res["tf_jg"];
                    if ($res["tianfu"] >= 1) {
                        $jiami3 = "x=t&id=3&d=1";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+1</a>";
                    }
                    if ($res["tianfu"] >= 3) {
                        $jiami3 = "x=t&id=3&d=3";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+3</a>";
                    }
                    if ($res["tianfu"] >= 5) {
                        $jiami3 = "x=t&id=3&d=5";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+5</a>";
                    }
                    echo '</div>';
                    echo "<div><a href='info.php?$url14'>血脉</a>:" . $res["tf_xm"];
                    if ($res["tianfu"] >= 1) {
                        $jiami3 = "x=t&id=4&d=1";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+1</a>";
                    }
                    if ($res["tianfu"] >= 3) {
                        $jiami3 = "x=t&id=4&d=3";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+3</a>";
                    }
                    if ($res["tianfu"] >= 5) {
                        $jiami3 = "x=t&id=4&d=5";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+5</a>";
                    }
                    echo '</div>';
                    echo "<div><a href='info.php?$url15'>身法</a>:" . $res["tf_sf"];
                    if ($res["tianfu"] >= 1) {
                        $jiami3 = "x=t&id=5&d=1";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+1</a>";
                    }
                    if ($res["tianfu"] >= 3) {
                        $jiami3 = "x=t&id=5&d=3";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+3</a>";
                    }
                    if ($res["tianfu"] >= 5) {
                        $jiami3 = "x=t&id=5&d=5";
                        $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                        echo " <a href='info.php?$url3'>+5</a>";
                    }
                    echo '</div>';
                    echo '<br/>';
                }
            }
            elseif($dh_fl == 'y') {
                //装备详情
                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $zb_num = $suxin1[0];

                    zb_info($zb_num);

                    $jiami1 = "x=w";
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<div><a href='info.php?$url1'>返回装备</a></div>";
                }
            }
            elseif($dh_fl == 'u') {
                //装备升级
                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $zb_num = $suxin1[0];

                    echo '<div style="font-weight: bold;">装备升级</div>';

                    $sqlHelper=new SqlHelper();
                    $sql="select zb_name,zb_dj,zb_pinzhi from s_wj_zhuangbei where num='$zb_num' and s_name='$_SESSION[id]'";
                    $res=$sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    if($res){
                        $zb_dj = $res["zb_dj"];
                        $zb_next_dj = $zb_dj + 1;
                        $zb_name = $res["zb_name"];
                        $zb_pinzhi = $res["zb_pinzhi"];

                        if (isset($url_info["k"])) {
                            $suxin1 = explode(".", $url_info["k"]);
                            $gn_fl = $suxin1[0];
                            if($gn_fl == 1){
                                $sqlHelper=new SqlHelper();
                                $sql = "select wp_name,wp_count,xh_money from s_zhuangbei_shengji where zb_name='$res[zb_name]' and zb_min_dj >= $zb_dj and zb_max_dj >= $zb_dj";
                                $res2 = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if($res2){
                                    $sqlHelper=new SqlHelper();
                                    $wj_dj = $sqlHelper->chaxun_wj_user_neirong('dj');
                                    $wp_counts = $sqlHelper->chaxun_wp_counts($res2["wp_name"]);
                                    $wj_money = $sqlHelper->chaxun_wj_user_neirong('money');
                                    $sqlHelper->close_connect();


                                    if($res["zb_dj"] < $wj_dj){
                                        echo '<br/><div>';
                                        if($wp_counts >= $res2["wp_count"] && $wj_money >= $res2["xh_money"]){
                                            $use_state = use_wupin($res2["wp_name"],$res2["wp_count"]);
                                            if($use_state == 1){
                                                $sqlHelper=new SqlHelper();
                                                $sqlHelper->jianshao_wj_user_neirong('money',$res2["xh_money"]);
                                                $sql = "update s_wj_zhuangbei set zb_dj=zb_dj+1 where s_name='$_SESSION[id]' and num=$zb_num";
                                                $res1 = $sqlHelper->execute_dml($sql);
                                                $sqlHelper->close_connect();
                                                echo '升级成功，等级+1';
                                                $zb_dj += 1;
                                                $zb_next_dj += 1;
                                            }
                                        }else{
                                            echo '条件不足,无法升级！';
                                        }
                                        echo '</div><br/>';
                                    }
                                }
                            }
                        }

                        echo '<div>'.$zb_pinzhi.$res["zb_name"].' '.$zb_dj.'级</div>';


                        $sqlHelper=new SqlHelper();
                        $sql="select zb_gj,zb_xq,zb_fy,zb_hp,zb_bj,zb_rx,zb_sd from s_zhuangbei_all where zb_name='$zb_name' and zb_dj='$zb_dj'";
                        $res=$sqlHelper->execute_dql($sql);
                        $sql="select zb_gj,zb_xq,zb_fy,zb_hp,zb_bj,zb_rx,zb_sd from s_zhuangbei_all where zb_name='$zb_name' and zb_dj='$zb_next_dj'";
                        $res1=$sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();

                        $pinzhi_bili = zhuangbei_pinzhi_bili($zb_pinzhi);

                        if($res["zb_gj"]){
                            echo '<div>升级后 [攻击:'.$res["zb_gj"] * $pinzhi_bili.'→'.$res1["zb_gj"] * $pinzhi_bili.']</div>';
                        }
                        if($res["zb_xq"]){
                            echo '<div>升级后 [仙气:'.$res["zb_xq"] * $pinzhi_bili.'→'.$res1["zb_xq"] * $pinzhi_bili.']</div>';
                        }
                        if($res["zb_fy"]){
                            echo '<div>升级后 [防御:'.$res["zb_fy"] * $pinzhi_bili.'→'.$res1["zb_fy"] * $pinzhi_bili.']</div>';
                        }
                        if($res["zb_hp"]){
                            echo '<div>升级后 [生命:'.$res["zb_hp"] * $pinzhi_bili.'→'.$res1["zb_hp"] * $pinzhi_bili.']</div>';
                        }
                        if($res["zb_bj"]){
                            echo '<div>升级后 [暴击:'.$res["zb_bj"] * $pinzhi_bili.'→'.$res1["zb_bj"] * $pinzhi_bili.']</div>';
                        }
                        if($res["zb_rx"]){
                            echo '<div>升级后 [韧性:'.$res["zb_rx"] * $pinzhi_bili.'→'.$res1["zb_rx"] * $pinzhi_bili.']</div>';
                        }
                        if($res["zb_sd"]){
                            echo '<div>升级后 [速度:'.$res["zb_sd"] * $pinzhi_bili.'→'.$res1["zb_sd"] * $pinzhi_bili.']</div>';
                        }

                        echo '<br/><div>升级所需材料:</div>';
                        $sqlHelper=new SqlHelper();
                        $sql = "select wp_name,wp_count,xh_money from s_zhuangbei_shengji where zb_name='$zb_name' and zb_min_dj <= $zb_dj and zb_max_dj >= $zb_dj";
                        $res2 = $sqlHelper->execute_dql($sql);

                        if($res2){
                            $wp_counts = $sqlHelper->chaxun_wp_counts($res2["wp_name"]);
                            $wj_money = $sqlHelper->chaxun_wj_user_neirong('money');
                            $wj_dj = $sqlHelper->chaxun_wj_user_neirong('dj');
                            echo '<div>'.$res2["wp_name"].'x'.$res2["wp_count"].' 现有:'.$wp_counts.'</div>';
                            echo '<div>灵石x'.$res2["xh_money"].' 现有:'.$wj_money.'</div>';

                            echo '<br/><div>';
                            if($zb_dj >= $wj_dj){
                                echo '确认升级(当前装备已升至最高等级,请提升人物等级后再来升级装备!)';
                            }else{
                                $jiami1 = "x=u&id=".$zb_num.'&k=1';
                                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                echo "<a href='info.php?$url1'>确认升级</a>";
                            }
                            echo '</div><br/>';
                        }
                        $sqlHelper->close_connect();

                        $jiami1 = "x=y&id=".$zb_num;
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div><a href='info.php?$url1'>返回上页</a></div>";
                    }else{
                        echo '<div>该装备不存在</div>';
                    }
                }
            }
            elseif($dh_fl == 'i') {
                //装备洗炼

                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $zb_num = $suxin1[0];

                    echo '<div style="font-weight: bold;">装备洗炼</div>';

                    $sqlHelper=new SqlHelper();
                    $sql="select zb_name,zb_dj,zb_pinzhi,zb_fs_gj,zb_fs_xq,zb_fs_fy,zb_fs_hp,zb_fs_bj,zb_fs_rx,zb_fs_sd from s_wj_zhuangbei where num='$zb_num' and s_name='$_SESSION[id]'";
                    $res=$sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    if($res){
                        $zb_dj = $res["zb_dj"];
                        $zb_name = $res["zb_name"];
                        $zb_pinzhi = $res["zb_pinzhi"];

                        $fs_gj_state = 0;   $fs_xq_state = 0;
                        $fs_fy_state = 0;   $fs_hp_state = 0;
                        $fs_bj_state = 0;   $fs_rx_state = 0;
                        $fs_sd_state = 0;

                        $zb_gj_tmp = -1; $zb_xq_tmp = -1; $zb_fy_tmp = -1;
                        $zb_hp_tmp = -1; $zb_bj_tmp = -1; $zb_rx_tmp = -1;
                        $zb_sd_tmp = -1;

                        if($zb_name = '剑'){
                            $fs_fy_state = 1;   $fs_hp_state = 1;
                            $fs_bj_state = 1;   $fs_rx_state = 1;
                            $fs_sd_state = 1;
                        }elseif($zb_name = '衣'){
                            $fs_gj_state = 1;   $fs_xq_state = 1;
                            $fs_bj_state = 1;   $fs_rx_state = 1;
                            $fs_sd_state = 1;
                        }elseif($zb_name = '靴'){
                            $fs_gj_state = 1;   $fs_xq_state = 1;
                            $fs_fy_state = 1;   $fs_hp_state = 1;
                            $fs_bj_state = 1;
                        }elseif($zb_name = '带'){
                            $fs_gj_state = 1;   $fs_xq_state = 1;
                            $fs_fy_state = 1;   $fs_hp_state = 1;
                            $fs_rx_state = 1;   $fs_sd_state = 1;
                        }

                        if (isset($url_info["k"])) {
                            $suxin1 = explode(".", $url_info["k"]);
                            $gn_fl = $suxin1[0];
                            if($gn_fl == 1){
                                //开始洗炼
                                $zhuangbei_xilian_cailiao = zhuangbei_xilian_cailiao();

                                $sqlHelper=new SqlHelper();
                                $wp_counts = $sqlHelper->chaxun_wp_counts($zhuangbei_xilian_cailiao[0]);
                                $sqlHelper->close_connect();

                                if($wp_counts >= $zhuangbei_xilian_cailiao[1]){
                                    $use_state = use_wupin($zhuangbei_xilian_cailiao[0],$zhuangbei_xilian_cailiao[1]);
                                    if($use_state == 1){
                                        $renwu_shuxing = renwu_shuxing($zb_dj);
                                        $pinzhi_bili = zhuangbei_pinzhi_bili($zb_pinzhi);

                                        if($fs_gj_state == 1){
                                            $zb_gj_tmp = ceil(rand(0,$renwu_shuxing[0] * $pinzhi_bili));
                                        }
                                        if($fs_xq_state == 1){
                                            $zb_xq_tmp = ceil(rand(0,$renwu_shuxing[1] * $pinzhi_bili));
                                        }
                                        if($fs_fy_state == 1){
                                            $zb_fy_tmp = ceil(rand(0,$renwu_shuxing[2] * $pinzhi_bili));
                                        }
                                        if($fs_hp_state == 1){
                                            $zb_hp_tmp = ceil(rand(0,$renwu_shuxing[3] * $pinzhi_bili));
                                        }
                                        if($fs_bj_state == 1){
                                            $zb_bj_tmp = ceil(rand(0,$renwu_shuxing[4] * $pinzhi_bili));
                                        }
                                        if($fs_rx_state == 1){
                                            $zb_rx_tmp = ceil(rand(0,$renwu_shuxing[5] * $pinzhi_bili));
                                        }
                                        if($fs_sd_state == 1){
                                            $zb_sd_tmp = ceil(rand(0,$renwu_shuxing[6] * $pinzhi_bili));
                                        }

                                        if($zb_gj_tmp == -1){
                                            $zb_gj_tmp = 0;
                                        }
                                        if($zb_xq_tmp == -1){
                                            $zb_xq_tmp = 0;
                                        }
                                        if($zb_fy_tmp == -1){
                                            $zb_fy_tmp = 0;
                                        }
                                        if($zb_hp_tmp == -1){
                                            $zb_hp_tmp = 0;
                                        }
                                        if($zb_bj_tmp == -1){
                                            $zb_bj_tmp = 0;
                                        }
                                        if($zb_rx_tmp == -1){
                                            $zb_rx_tmp = 0;
                                        }
                                        if($zb_sd_tmp == -1){
                                            $zb_sd_tmp = 0;
                                        }

                                        $sqlHelper=new SqlHelper();
                                        $sql = "select num from s_wj_zhuangbei_xilian_tmp where s_name='$_SESSION[id]' and zb_num=$zb_num";
                                        $res1 = $sqlHelper->execute_dql($sql);
                                        if($res1){
                                            $sql = "update s_wj_zhuangbei_xilian_tmp set zb_gj_tmp=$zb_gj_tmp,zb_xq_tmp=$zb_xq_tmp,zb_fy_tmp=$zb_fy_tmp,zb_hp_tmp=$zb_hp_tmp,zb_rx_tmp=$zb_rx_tmp,zb_sd_tmp=$zb_sd_tmp,zb_bj_tmp=$zb_bj_tmp where s_name='$_SESSION[id]' and zb_num=$zb_num";
                                        }else{
                                            $sql = "insert into s_wj_zhuangbei_xilian_tmp(s_name,zb_num,zb_gj_tmp,zb_xq_tmp,zb_fy_tmp,zb_hp_tmp,zb_rx_tmp,zb_sd_tmp,zb_bj_tmp) values('$_SESSION[id]','$zb_num','$zb_gj_tmp','$zb_xq_tmp','$zb_fy_tmp','$zb_hp_tmp','$zb_rx_tmp','$zb_sd_tmp','$zb_bj_tmp')";
                                        }
                                        $res1 = $sqlHelper->execute_dml($sql);
                                        $sqlHelper->close_connect();
                                    }
                                }else{
                                    echo '<br/><div>条件不足,无法洗炼！</div><br/>';
                                }
                            }elseif($gn_fl == 2) {
                                //确认替换洗炼
                                $sqlHelper = new SqlHelper();
                                $sql = "select zb_gj_tmp,zb_xq_tmp,zb_fy_tmp,zb_hp_tmp,zb_rx_tmp,zb_sd_tmp,zb_bj_tmp from s_wj_zhuangbei_xilian_tmp where s_name='$_SESSION[id]' and zb_num=$zb_num";
                                $res1 = $sqlHelper->execute_dql($sql);
                                if ($res1) {
                                    $sql = "update s_wj_zhuangbei set zb_fs_gj='$res1[zb_gj_tmp]',zb_fs_xq='$res1[zb_xq_tmp]',zb_fs_fy='$res1[zb_fy_tmp]',zb_fs_hp='$res1[zb_hp_tmp]',zb_fs_rx='$res1[zb_rx_tmp]',zb_fs_sd='$res1[zb_sd_tmp]',zb_fs_bj='$res1[zb_bj_tmp]' where s_name='$_SESSION[id]' and num=$zb_num";
                                    $res1 = $sqlHelper->execute_dml($sql);
                                    $sql = "delete from s_wj_zhuangbei_xilian_tmp where s_name='$_SESSION[id]' and zb_num=$zb_num";
                                    $res1 = $sqlHelper->execute_dml($sql);
                                    $sql="select zb_name,zb_dj,zb_pinzhi,zb_fs_gj,zb_fs_xq,zb_fs_fy,zb_fs_hp,zb_fs_bj,zb_fs_rx,zb_fs_sd from s_wj_zhuangbei where num='$zb_num' and s_name='$_SESSION[id]'";
                                    $res=$sqlHelper->execute_dql($sql);
                                }
                                $sqlHelper->close_connect();
                            }elseif($gn_fl == 3) {
                                //维持现状洗炼
                                $sqlHelper = new SqlHelper();
                                $sql = "delete from s_wj_zhuangbei_xilian_tmp where s_name='$_SESSION[id]' and zb_num=$zb_num";
                                $res1 = $sqlHelper->execute_dml($sql);
                                $sqlHelper->close_connect();
                            }
                        }
                        else{
                            $sqlHelper = new SqlHelper();
                            $sql = "select zb_gj_tmp,zb_xq_tmp,zb_fy_tmp,zb_hp_tmp,zb_rx_tmp,zb_sd_tmp,zb_bj_tmp from s_wj_zhuangbei_xilian_tmp where s_name='$_SESSION[id]' and zb_num=$zb_num";
                            $res1 = $sqlHelper->execute_dql($sql);
                            if ($res1) {
                                $zb_gj_tmp = $res1["zb_gj_tmp"];    $zb_xq_tmp = $res1["zb_xq_tmp"];
                                $zb_fy_tmp = $res1["zb_fy_tmp"];    $zb_hp_tmp = $res1["zb_hp_tmp"];
                                $zb_bj_tmp = $res1["zb_bj_tmp"];    $zb_rx_tmp = $res1["zb_rx_tmp"];
                                $zb_sd_tmp = $res1["zb_sd_tmp"];
                            }
                            $sqlHelper->close_connect();
                        }

                        echo '<div>'.$zb_pinzhi.$res["zb_name"].' '.$zb_dj.'级</div>';

                        if($fs_gj_state == 1){
                            echo '<div>攻击:'.$res["zb_fs_gj"];
                            if($zb_gj_tmp != -1){
                                echo ' → '.$zb_gj_tmp;
                                if($zb_gj_tmp > $res["zb_fs_gj"]){
                                    echo ' ↑';
                                }elseif($zb_gj_tmp < $res["zb_fs_gj"]){
                                    echo ' ↓';
                                }
                            }
                            echo '</div>';
                        }
                        if($fs_xq_state == 1){
                            echo '<div>仙气:'.$res["zb_fs_xq"];
                            if($zb_xq_tmp != -1){
                                echo ' → '.$zb_xq_tmp;
                                if($zb_xq_tmp > $res["zb_fs_xq"]){
                                    echo ' ↑';
                                }elseif($zb_xq_tmp < $res["zb_fs_xq"]){
                                    echo ' ↓';
                                }
                            }
                            echo '</div>';
                        }
                        if($fs_fy_state == 1){
                            echo '<div>防御:'.$res["zb_fs_fy"];
                            if($zb_fy_tmp != -1){
                                echo ' → '.$zb_fy_tmp;
                                if($zb_fy_tmp > $res["zb_fs_fy"]){
                                    echo ' ↑';
                                }elseif($zb_fy_tmp < $res["zb_fs_fy"]){
                                    echo ' ↓';
                                }
                            }
                            echo '</div>';
                        }
                        if($fs_hp_state == 1){
                            echo '<div>生命:'.$res["zb_fs_hp"];
                            if($zb_hp_tmp != -1){
                                echo ' → '.$zb_hp_tmp;
                                if($zb_hp_tmp > $res["zb_fs_hp"]){
                                    echo ' ↑';
                                }elseif($zb_hp_tmp < $res["zb_fs_hp"]){
                                    echo ' ↓';
                                }
                            }
                            echo '</div>';
                        }
                        if($fs_bj_state == 1){
                            echo '<div>暴击:'.$res["zb_fs_bj"];
                            if($zb_bj_tmp != -1){
                                echo ' → '.$zb_bj_tmp;
                                if($zb_bj_tmp > $res["zb_fs_bj"]){
                                    echo ' ↑';
                                }elseif($zb_bj_tmp < $res["zb_fs_bj"]){
                                    echo ' ↓';
                                }
                            }
                            echo '</div>';
                        }
                        if($fs_rx_state == 1){
                            echo '<div>韧性:'.$res["zb_fs_rx"];
                            if($zb_rx_tmp != -1){
                                echo ' → '.$zb_rx_tmp;
                                if($zb_rx_tmp > $res["zb_fs_rx"]){
                                    echo ' ↑';
                                }elseif($zb_rx_tmp < $res["zb_fs_rx"]){
                                    echo ' ↓';
                                }
                            }
                            echo '</div>';
                        }
                        if($fs_sd_state == 1){
                            echo '<div>速度:'.$res["zb_fs_sd"];
                            if($zb_sd_tmp != -1){
                                echo ' → '.$zb_sd_tmp;
                                if($zb_sd_tmp > $res["zb_fs_sd"]){
                                    echo ' ↑';
                                }elseif($zb_sd_tmp < $res["zb_fs_sd"]){
                                    echo ' ↓';
                                }
                            }
                            echo '</div>';
                        }

                        if($zb_gj_tmp != -1 || $zb_xq_tmp != -1 || $zb_fy_tmp != -1 || $zb_hp_tmp != -1 || $zb_bj_tmp != -1 || $zb_rx_tmp != -1 || $zb_sd_tmp != -1){
                            $jiami1 = "x=i&id=".$zb_num.'&k=2';
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                            $jiami2 = "x=i&id=".$zb_num.'&k=3';
                            $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                            echo "<div><a href='info.php?$url1'>确认替换</a></div>";
                            echo "<div><a href='info.php?$url2'>维持现状</a></div>";
                        }

                        echo '<br/><div>洗炼所需材料:</div>';
                        $zhuangbei_xilian_cailiao = zhuangbei_xilian_cailiao();

                        $sqlHelper=new SqlHelper();
                        $wp_counts = $sqlHelper->chaxun_wp_counts($zhuangbei_xilian_cailiao[0]);
                        $sqlHelper->close_connect();

                        echo '<div>'.$zhuangbei_xilian_cailiao[0].'x'.$zhuangbei_xilian_cailiao[1].' 现有:'.$wp_counts.'</div>';

                        if($wp_counts >= $zhuangbei_xilian_cailiao[1]){
                            $jiami1 = "x=i&id=".$zb_num.'&k=1';
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                            if($zb_gj_tmp != -1 || $zb_xq_tmp != -1 || $zb_fy_tmp != -1 || $zb_hp_tmp != -1 || $zb_bj_tmp != -1 || $zb_rx_tmp != -1 || $zb_sd_tmp != -1){
                                echo "<div><a href='info.php?$url1'>继续洗炼</a></div><br/>";
                            }else{
                                echo "<div><a href='info.php?$url1'>开始洗炼</a></div><br/>";
                            }
                        }else{
                            echo "<div>开始洗炼</div><br/>";
                        }


                        $jiami1 = "x=y&id=".$zb_num;
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div><a href='info.php?$url1'>返回上页</a></div>";
                    }else{
                        echo '<div>该装备不存在</div>';
                    }
                }
            }
            elseif($dh_fl == 'o') {
                //装备飞升

                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $zb_num = $suxin1[0];

                    echo '<div style="font-weight: bold;">装备飞升</div>';

                    $sqlHelper=new SqlHelper();
                    $sql="select zb_name,zb_dj,zb_pinzhi from s_wj_zhuangbei where num='$zb_num' and s_name='$_SESSION[id]'";
                    $res=$sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    if($res){
                        $zb_dj = $res["zb_dj"];
                        $zb_name = $res["zb_name"];
                        $zb_pinzhi = $res["zb_pinzhi"];

                        if (isset($url_info["k"])) {
                            $suxin1 = explode(".", $url_info["k"]);
                            $gn_fl = $suxin1[0];
                            if($gn_fl == 1){
                                //开始洗炼
                                $zb_next_pinzhi = '';
                                $zhuangbei_pinzhi = zhuangbei_pinzhi();
                                $zhuangbei_pinzhi_name = 0;
                                for($i=0;$i<count($zhuangbei_pinzhi);$i++){
                                    if($zhuangbei_pinzhi[$i] == $zb_pinzhi){
                                        $zhuangbei_pinzhi_name = 1;
                                        continue;
                                    }
                                    if($zhuangbei_pinzhi_name == 1){
                                        $zb_next_pinzhi = $zhuangbei_pinzhi[$i];
                                        break;
                                    }
                                }

                                if($zb_next_pinzhi){
                                    $sqlHelper=new SqlHelper();
                                    $wp_name = $zb_next_pinzhi.$res["zb_name"].'图谱';
                                    $wp_counts = $sqlHelper->chaxun_wp_counts($wp_name);
                                    $sqlHelper->close_connect();
                                    if($wp_counts >= 1){
                                        $use_state = use_wupin($wp_name,1);
                                        if($use_state == 1){
                                            $sqlHelper=new SqlHelper();
                                            $sql = "update s_wj_zhuangbei set zb_pinzhi='$zb_next_pinzhi' where s_name='$_SESSION[id]' and num=$zb_num";
                                            $res = $sqlHelper->execute_dml($sql);
                                            $zb_pinzhi = $zb_next_pinzhi;
                                            $sqlHelper->close_connect();
                                            echo '<br/><div>飞升成功！</div><br/>';
                                        }
                                    }else{
                                        echo '<br/><div>条件不足,无法升级！</div><br/>';
                                    }
                                }
                            }
                        }

                        $zb_next_pinzhi = '';
                        $zhuangbei_pinzhi = zhuangbei_pinzhi();
                        $zhuangbei_pinzhi_name = 0;
                        for($i=0;$i<count($zhuangbei_pinzhi);$i++){
                            if($zhuangbei_pinzhi[$i] == $zb_pinzhi){
                                $zhuangbei_pinzhi_name = 1;
                                continue;
                            }
                            if($zhuangbei_pinzhi_name == 1){
                                $zb_next_pinzhi = $zhuangbei_pinzhi[$i];
                                break;
                            }
                        }

                        if($zb_next_pinzhi){
                            echo '<div>确认将'.$zb_pinzhi.$zb_name.'('.$zb_dj.'级)飞升成为 '.$zb_next_pinzhi.$zb_name.'('.$zb_dj.'级)么?</div>';
                            echo '<div>需要:</div>';
                            $wp_name = $zb_next_pinzhi.$zb_name.'图谱';
                            echo '<div>'.$wp_name.':1</div>';

                            $sqlHelper=new SqlHelper();
                            $wp_counts = $sqlHelper->chaxun_wp_counts($wp_name);
                            $sqlHelper->close_connect();

                            echo '<br/><div>已有:</div>';
                            echo '<div>'.$wp_name.':'.$wp_counts.'</div>';

                            if($wp_counts >= 1){
                                $jiami1 = "x=o&id=".$zb_num.'&k=1';
                                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                echo "<div><a href='info.php?$url1'>开始飞升</a></div><br/>";

                            }else{
                                echo "<div>开始飞升</div><br/>";
                            }
                        }else{
                            echo "<br/><div>该装备已达到最高品质</div><br/>";
                        }



                        $jiami1 = "x=y&id=".$zb_num;
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div><a href='info.php?$url1'>返回上页</a></div>";
                    }else{
                        echo '<div>该装备不存在</div>';
                    }
                }
            }
            elseif($dh_fl == 'p') {
                //境界
                echo '<div style="font-weight: bold;">境界</div>';

                $sqlHelper=new SqlHelper();
                $wj_jingjie = $sqlHelper->chaxun_wj_user_neirong('jingjie');
                $sqlHelper->close_connect();

                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];
                    if($gn_fl == 1){
                        //开始突破
                        $sqlHelper=new SqlHelper();
                        $sql = "select jj_dj,jj_tp_dj,jj_tp_money from s_jingjie_all where jj_name='$wj_jingjie'";
                        $res = $sqlHelper->execute_dql($sql);

                        $next_jj_dj = $res["jj_dj"] + 1;
                        $sql = "select jj_name from s_jingjie_all where jj_dj='$next_jj_dj'";
                        $res3 = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();

                        if($res3 && $res["jj_tp_dj"]){
                            $tupo_state = 1;
                            $sqlHelper=new SqlHelper();
                            $sql = "select dj,money from s_user where s_name='$_SESSION[id]'";
                            $res1 = $sqlHelper->execute_dql($sql);
                            $sqlHelper->close_connect();

                            if($res1["dj"] < $res["jj_tp_dj"]){
                                $tupo_state = 0;
                            }

                            if($tupo_state == 1){
                                if($res1["money"] < $res["jj_tp_money"]){
                                    $tupo_state = 0;
                                }

                                if($tupo_state == 1){
                                    $sqlHelper=new SqlHelper();
                                    $sql = "select wp_num,wp_counts from s_jingjie_cailiao where jj_dj='$res[jj_dj]'";
                                    $res1 = $sqlHelper->execute_dql2($sql);
                                    for($i=0;$i<count($res1);$i++){
                                        $wp_num = $res1[$i]["wp_num"];
                                        $wp_counts = $res1[$i]["wp_counts"];
                                        $sql = "select wp_name from s_wupin_all where num=$wp_num";
                                        $res2 = $sqlHelper->execute_dql($sql);
                                        if($res2){
                                            $yy_counts = $sqlHelper->chaxun_wp_counts($res2["wp_name"]);
                                            if($yy_counts < $wp_counts){
                                                $tupo_state = 0;
                                                break;
                                            }
                                        }
                                    }
                                    $sqlHelper->close_connect();

                                    if($tupo_state == 1){
                                        //开始扣除材料
                                        if($res["jj_tp_money"]){
                                            $sqlHelper=new SqlHelper();
                                            $sqlHelper->jianshao_wj_user_neirong('money',$res["jj_tp_money"]);
                                            $sqlHelper->close_connect();
                                        }

                                        for($i=0;$i<count($res1);$i++){
                                            $wp_num = $res1[$i]["wp_num"];
                                            $wp_counts = $res1[$i]["wp_counts"];
                                            $sqlHelper=new SqlHelper();
                                            $sql = "select wp_name from s_wupin_all where num=$wp_num";
                                            $res2 = $sqlHelper->execute_dql($sql);
                                            $sqlHelper->close_connect();
                                            if($res2){
                                                use_wupin($res2["wp_name"],$wp_counts);
                                            }
                                        }

                                        $sqlHelper=new SqlHelper();
                                        $sqlHelper->xiugai_wj_user_neirong('jingjie',$res3["jj_name"]);
                                        $sqlHelper->close_connect();

                                        $wj_jingjie = $res3["jj_name"];

                                        $message = '恭喜';
                                        $message1 = '冲击境界成功，修炼进阶为'.$wj_jingjie;
                                        insert_xitong_gonggao($_SESSION["id"],$message,'xt','',$message1);
                                    }
                                }
                            }
                        }
                    }
                }

                echo '<div>当前境界:'.$wj_jingjie.'</div><br/>';

                $sqlHelper=new SqlHelper();
                $sql = "select jj_dj,jj_gj,jj_xq,jj_fy,jj_hp,jj_bj,jj_rx,jj_sd,jj_tp_dj,jj_tp_money from s_jingjie_all where jj_name='$wj_jingjie'";
                $res = $sqlHelper->execute_dql($sql);

                if($res["jj_tp_dj"]){
                    $next_jj_dj = $res["jj_dj"] + 1;
                    $sql = "select jj_name from s_jingjie_all where jj_dj='$next_jj_dj'";
                    $res1 = $sqlHelper->execute_dql($sql);
                    if($res1){
                        echo '<div>下一境界:'.$res1["jj_name"].'</div>';
                    }
                }

                $sqlHelper->close_connect();

                echo '<div>当前境界加成:</div>';

                if($res["jj_gj"]){
                    echo '<div>攻击+'.$res["jj_gj"].'</div>';
                }
                if($res["jj_xq"]){
                    echo '<div>仙气+'.$res["jj_xq"].'</div>';
                }
                if($res["jj_fy"]){
                    echo '<div>防御+'.$res["jj_fy"].'</div>';
                }
                if($res["jj_hp"]){
                    echo '<div>生命+'.$res["jj_hp"].'</div>';
                }
                if($res["jj_bj"]){
                    echo '<div>暴击+'.$res["jj_bj"].'</div>';
                }
                if($res["jj_rx"]){
                    echo '<div>韧性+'.$res["jj_rx"].'</div>';
                }
                if($res["jj_sd"]){
                    echo '<div>速度+'.$res["jj_sd"].'</div>';
                }

                if($res["jj_tp_dj"]){
                    $tupo_state = 1;
                    echo '<br/><div>突破条件</div>';

                    $sqlHelper=new SqlHelper();
                    $sql = "select dj,money from s_user where s_name='$_SESSION[id]'";
                    $res1 = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    echo '<div>等级:'.$res["jj_tp_dj"].'级 当前:'.$res1["dj"].'级';
                    if($res1["dj"] >= $res["jj_tp_dj"]){
                        echo ' ( 已达成 )';
                    }else{
                        $tupo_state = 0;
                        echo ' ( 未达成 )';
                    }
                    echo '</div>';
                    echo '<div>灵石:'.$res["jj_tp_money"].' 现有:'.$res1["money"];
                    if($res1["money"] >= $res["jj_tp_money"]){
                        echo ' ( 已达成 )';
                    }else{
                        $tupo_state = 0;
                        echo ' ( 未达成 )';
                    }
                    echo '</div>';

                    $sqlHelper=new SqlHelper();
                    $sql = "select wp_num,wp_counts from s_jingjie_cailiao where jj_dj='$res[jj_dj]'";
                    $res1 = $sqlHelper->execute_dql2($sql);
                    for($i=0;$i<count($res1);$i++){
                        $wp_num = $res1[$i]["wp_num"];
                        $wp_counts = $res1[$i]["wp_counts"];
                        $sql = "select wp_name from s_wupin_all where num=$wp_num";
                        $res2 = $sqlHelper->execute_dql($sql);
                        if($res2){
                            echo '<div>'.$res2["wp_name"].':'.$wp_counts;
                            $yy_counts = $sqlHelper->chaxun_wp_counts($res2["wp_name"]);
                            echo ' 现有:'.$yy_counts;
                            if($yy_counts >= $wp_counts){
                                echo ' ( 已达成 )';
                            }else{
                                $tupo_state = 0;
                                echo ' ( 未达成 )';
                            }
                            echo '</div>';
                        }
                    }
                    $sqlHelper->close_connect();

                    if($tupo_state == 1){
                        $jiami1 = 'x=p&k=1';
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div><a href='info.php?$url1'>开始突破</a></div><br/>";
                    }else{
                        echo "<div>开始突破</div><br/>";
                    }
                }
            }
            elseif($dh_fl == 'a') {
                //升级前确认及升级
                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];
                    if($gn_fl == 1){
                        //开始升级
                        $sqlHelper=new SqlHelper();
                        $wj_dj = $sqlHelper->chaxun_wj_user_neirong('dj');
                        $wj_exp = $sqlHelper->chaxun_wj_user_neirong('exp');
                        $sqlHelper->close_connect();

                        $wj_max_dj = wj_max_dj();

                        if($wj_dj < $wj_max_dj){
                            $wj_shengji_exp = wj_shengji_exp($wj_dj);

                            if($wj_exp >= $wj_shengji_exp){
                                echo '<div style="font-weight: bold;">升级成功</div>';
                                echo '<div>恭喜你升级到'.($wj_dj + 1).'级.</div>';

                                $now_time = date("Y-m-d H:i:s");
                                $sqlHelper=new SqlHelper();

                                $z_nl = $sqlHelper->chaxun_wj_user_neirong('z_nl');
                                $cz_jf = $sqlHelper->chaxun_wj_user_neirong('cz_jf');

                                $vip_dj = vip_dj($cz_jf);
                                $vip_nlsx_hfcs = vip_nlsx_hfcs($vip_dj);
                                $wj_znl = $z_nl + $vip_nlsx_hfcs[0];

                                $sql = "update s_user set sy_nl=$wj_znl,exp=exp-$wj_shengji_exp,dj=dj+1,dj_up_time='$now_time' where s_name='$_SESSION[id]'";
                                $res = $sqlHelper->execute_dml($sql);

                                $sqlHelper->close_connect();

                                $wj_new_dj = $wj_dj + 1;
                                $wj_sy_exp = $wj_exp - $wj_shengji_exp;

                                $renwu_shuxing_old = renwu_shuxing($wj_dj);
                                $renwu_shuxing_new = renwu_shuxing($wj_new_dj);

                                echo '<div>耐力:'.$wj_znl.'/'.$wj_znl.'</div>';
                                echo '<div>攻击:+'.($renwu_shuxing_new[0] - $renwu_shuxing_old[0]).'</div>';
                                echo '<div>仙气:+'.($renwu_shuxing_new[1] - $renwu_shuxing_old[1]).'</div>';
                                echo '<div>防御:+'.($renwu_shuxing_new[2] - $renwu_shuxing_old[2]).'</div>';
                                echo '<div>生命:+'.($renwu_shuxing_new[3] - $renwu_shuxing_old[3]).'</div>';
                                echo '<div>暴击:+'.($renwu_shuxing_new[4] - $renwu_shuxing_old[4]).'</div>';
                                echo '<div>韧性:+'.($renwu_shuxing_new[5] - $renwu_shuxing_old[5]).'</div>';
                                echo '<div>速度:+'.($renwu_shuxing_new[6] - $renwu_shuxing_old[6]).'</div>';

                                if($wj_new_dj >= 10){
                                    $shengji_tianfu_dianshu = shengji_tianfu_dianshu();

                                    $sqlHelper=new SqlHelper();
                                    $sqlHelper->add_wj_user_neirong('tianfu',$shengji_tianfu_dianshu);
                                    $sqlHelper->close_connect();

                                    $jiami1 = "x=t";
                                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                                    echo "<div>你获得了".$shengji_tianfu_dianshu."点<a href='info.php?$url1'>天赋</a>,分配天赋可增加相应属性.</div>";
                                }

                                $wj_shengji_exp = wj_shengji_exp($wj_new_dj);
                                echo '<div>灵气:'.$wj_sy_exp.'/'.$wj_shengji_exp;
                                if($wj_new_dj < $wj_max_dj && $wj_sy_exp >= $wj_shengji_exp){
                                    $jiami1 = "x=a&k=1";
                                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                                    echo " <a href='info.php?$url1'>升级</a>";
                                }
                                echo '</div>';

                            }else{
                                echo '<div style="font-weight: bold;">升级</div>';
                                echo "<div>当前灵气不足，无法进行升级</div><br/>";
                            }
                        }else{
                            echo '<div style="font-weight: bold;">升级</div>';
                            echo "<div>您已达到了最高等级</div><br/>";
                        }
                        ##############  ##############
                        ############### ###########

                    }
                }
                else{
                    echo '<div style="font-weight: bold;">升级</div>';

                    $sqlHelper=new SqlHelper();
                    $wj_dj = $sqlHelper->chaxun_wj_user_neirong('dj');
                    $wj_exp = $sqlHelper->chaxun_wj_user_neirong('exp');
                    $sqlHelper->close_connect();

                    $wj_max_dj = wj_max_dj();

                    if($wj_dj < $wj_max_dj){
                        $wj_shengji_exp = wj_shengji_exp($wj_dj);

                        if($wj_exp >= $wj_shengji_exp){
                            echo '<div>等级:'.$wj_dj.'→'.($wj_dj + 1).'</div>';
                            echo '<div>>>升级后将回满耐力,建议您耗尽耐力再升级</div>';

                            $jiami1 = "x=a&k=1";
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<div><a href='info.php?$url1'>确认升级</a></div><br/>";
                        }else{
                            echo "<div>当前灵气不足，无法进行升级</div><br/>";
                        }
                    }else{
                        echo "<div>您已达到了最高等级</div><br/>";
                    }
                }
            }
            elseif($dh_fl == 's') {
                //天赋洗点
                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $tf_fl = $suxin1[0];

                    if($tf_fl == 1 || $tf_fl == 2 || $tf_fl == 3 || $tf_fl == 4 || $tf_fl == 5){

                        if (isset($url_info["k"])) {
                            $suxin1 = explode(".", $url_info["k"]);
                            $gn_fl = $suxin1[0];
                            if($gn_fl == 1){
                                //开始洗点

                                $sqlHelper=new SqlHelper();
                                $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');

                                if($wj_coin >= 200){
                                    if ($tf_fl == 1) {
                                        $tf_name = 'tf_wx';
                                    } elseif ($tf_fl == 2) {
                                        $tf_name = 'tf_lq';
                                    } elseif ($tf_fl == 3) {
                                        $tf_name = 'tf_jg';
                                    } elseif ($tf_fl == 4) {
                                        $tf_name = 'tf_xm';
                                    } elseif ($tf_fl == 5) {
                                        $tf_name = 'tf_sf';
                                    }
                                    $xy_ds = $sqlHelper->chaxun_wj_user_neirong($tf_name);
                                    if($xy_ds){
                                        $sql = "update s_user set coin=coin-200,$tf_name=0,tianfu=tianfu+$xy_ds where s_name='$_SESSION[id]'";
                                        $res = $sqlHelper->execute_dml($sql);
                                        echo '<div>洗点成功，当前点数已重置</div><br/>';
                                    }else{
                                        echo '<div>当前点数为0，无法进行洗点</div><br/>';
                                    }
                                }else{
                                    echo '<div>仙券不足，无法进行洗点</div><br/>';
                                }

                                $sqlHelper->close_connect();
                            }
                        }
                        else {
                            echo '<div style="font-weight: bold;">洗点</div>';

                            $sqlHelper = new SqlHelper();
                            $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');

                            $tianfu_shuxing_xishu = tianfu_shuxing_xishu();

                            if ($tf_fl == 1) {
                                $xy_ds = $sqlHelper->chaxun_wj_user_neirong('tf_wx');
                                echo '<div>悟性:' . $xy_ds . '点</div>';
                                echo '<div>(1点悟性可增加 '.$tianfu_shuxing_xishu[0].'点 攻击)</div>';
                            } elseif ($tf_fl == 2) {
                                $xy_ds = $sqlHelper->chaxun_wj_user_neirong('tf_lq');
                                echo '<div>灵气:' . $xy_ds . '点</div>';
                                echo '<div>(1点灵气可增加 '.$tianfu_shuxing_xishu[1].'点 仙气)</div>';
                            } elseif ($tf_fl == 3) {
                                $xy_ds = $sqlHelper->chaxun_wj_user_neirong('tf_jg');
                                echo '<div>筋骨:' . $xy_ds . '点</div>';
                                echo '<div>(1点筋骨可增加 '.$tianfu_shuxing_xishu[2].'点 防御)</div>';
                            } elseif ($tf_fl == 4) {
                                $xy_ds = $sqlHelper->chaxun_wj_user_neirong('tf_xm');
                                echo '<div>血脉:' . $xy_ds . '点</div>';
                                echo '<div>(1点血脉可增加 '.$tianfu_shuxing_xishu[3].'点 生命)</div>';
                            } elseif ($tf_fl == 5) {
                                $xy_ds = $sqlHelper->chaxun_wj_user_neirong('tf_sf');
                                echo '<div>身法:' . $xy_ds . '点</div>';
                                echo '<div>(1点身法可增加 '.$tianfu_shuxing_xishu[4].'点 速度)</div>';
                            }

                            $sqlHelper->close_connect();

                            $jiami1 = "x=s&id=" . $tf_fl . '&k=1';
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                            echo "<div><a href='info.php?$url1'>洗掉全部</a></div>";
                            echo '<div>需要200仙券(拥有' . $wj_coin . '仙券)</div><br/>';

                        }
                        $jiami1 = "x=t";
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        echo "<div><a href='info.php?$url1'>返回天赋</a></div>";
                    }
                }
            }
            elseif($dh_fl == 'd') {
                //未学习仙术介绍页面
                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $skill_id = $suxin1[0];

                        if (isset($url_info["k"])) {
                            $suxin1 = explode(".", $url_info["k"]);
                            $gn_fl = $suxin1[0];
                            if($gn_fl == 1){
                                //开始学习仙术

                                $sqlHelper=new SqlHelper();
                                $sql = "select skill_fl,skill_name,skill_money from s_skill_all where num=$skill_id";
                                $res = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if($res){
                                    $sqlHelper=new SqlHelper();
                                    $sql = "select skill_dj from s_wj_skill where s_name='$_SESSION[id]' and skill_num=$skill_id";
                                    $res1 = $sqlHelper->execute_dql($sql);
                                    $wj_money = $sqlHelper->chaxun_wj_user_neirong('money');
                                    $sqlHelper->close_connect();
                                    if($res1){
                                        echo '<div style="font-weight: bold;">仙术升级</div>';

                                        $jieduan = $res1["skill_dj"];
                                        $skill_shengji_cailiao = skill_shengji_cailiao($skill_id);
                                        if($skill_shengji_cailiao){
                                            if(isset($skill_shengji_cailiao[$jieduan-1])){
                                                $shengji_cailiao = explode('|',$skill_shengji_cailiao[$jieduan-1]);

                                                $shengji_state = 1;
                                                $shengji_cailiao_zz = array();

                                                for($i=1;$i<count($shengji_cailiao);$i++){
                                                    $xiaohao_cailiao = explode(',',$shengji_cailiao[$i]);
                                                    if($xiaohao_cailiao[0] == 'money'){

                                                        $sqlHelper=new SqlHelper();
                                                        $wj_money = $sqlHelper->chaxun_wj_user_neirong('money');
                                                        $sqlHelper->close_connect();
                                                        if($wj_money < $xiaohao_cailiao[1]){
                                                            $shengji_state = 0;
                                                            break;
                                                        }else{
                                                            $shengji_cailiao_zz []= 'money,'.$xiaohao_cailiao[1];
                                                        }

                                                    }elseif($xiaohao_cailiao[0] == 'wp'){

                                                        $sqlHelper=new SqlHelper();
                                                        $sql = "select wp_name from s_wupin_all where num=$xiaohao_cailiao[1]";
                                                        $res2 = $sqlHelper->execute_dql($sql);

                                                        $wp_counts = $sqlHelper->chaxun_wp_counts($res2["wp_name"]);
                                                        $sqlHelper->close_connect();
                                                        if($wp_counts < $xiaohao_cailiao[2]){
                                                            $shengji_state = 0;
                                                            break;
                                                        }else{
                                                            $shengji_cailiao_zz []= 'wp,'.$res2["wp_name"].','.$xiaohao_cailiao[2];
                                                        }
                                                    }
                                                }

                                                if($shengji_state == 1){
                                                    for($i=0;$i<count($shengji_cailiao_zz);$i++){
                                                        $xh_cailiao = explode(',',$shengji_cailiao_zz[$i]);
                                                        if($xh_cailiao[0] == 'money'){
                                                            $sqlHelper=new SqlHelper();
                                                            $sqlHelper->jianshao_wj_user_neirong('money',$xh_cailiao[1]);
                                                            $sqlHelper->close_connect();
                                                        }elseif($xh_cailiao[0] == 'wp'){
                                                            use_wupin($xh_cailiao[1],$xh_cailiao[2]);
                                                        }
                                                    }

                                                    $sqlHelper=new SqlHelper();
                                                    $sql = "update s_wj_skill set skill_dj=skill_dj+1 where s_name='$_SESSION[id]' and skill_num=$skill_id";
                                                    $res2 = $sqlHelper->execute_dml($sql);
                                                    $sqlHelper->close_connect();
                                                    echo '<div>'.$res["skill_name"].'成功升级到'.($res1["skill_dj"] + 1).'阶</div><br/>';

                                                }else{
                                                    echo '<div>材料不足，无法提升等级</div><br/>';
                                                }
                                            }else{
                                                echo '<div>该技能已到最高等级，无法继续提升</div><br/>';
                                            }
                                        }else{
                                            echo '<div>该技能已到最高等级，无法继续提升</div><br/>';
                                        }
                                    }else{
                                        echo '<div style="font-weight: bold;">仙术学习</div>';
                                        if($wj_money >= $res["skill_money"]){
                                            $sqlHelper=new SqlHelper();
                                            $sqlHelper->jianshao_wj_user_neirong('money',$res["skill_money"]);
                                            $sql = "insert into s_wj_skill(s_name,skill_num,skill_fl) values('$_SESSION[id]','$skill_id','$res[skill_fl]')";
                                            $res1 = $sqlHelper->execute_dml($sql);
                                            $sqlHelper->close_connect();
                                            echo '<div>成功学习了'.$res["skill_name"].'</div><br/>';
                                        }else{
                                            echo '<div>灵石不足，无法学习仙术</div><br/>';
                                        }
                                    }
                                }

                            }
                        }
                        else {
                            echo '<div style="font-weight: bold;">仙术</div>';

                            $sqlHelper = new SqlHelper();

                            $sql = "select skill_fl,skill_name,skill_lx,skill_zhi,skill_cx,skill_cd,skill_money from s_skill_all where num=$skill_id";
                            $res = $sqlHelper->execute_dql($sql);
                            if($res){
                                echo '<div>'.$res["skill_name"].'</div>';
                                if($res["skill_fl"] == 'zd'){
                                    echo '<div>类型: 主动技能</div>';
                                }else{
                                    echo '<div>类型: 被动技能</div>';
                                }

                                $sql = "select skill_dj from s_wj_skill where s_name='$_SESSION[id]' and skill_num=$skill_id";
                                $res1 = $sqlHelper->execute_dql($sql);
                                if($res1){
                                    $jieduan = $res1["skill_dj"];
                                    $tisheng_zhi = $res1["skill_dj"] * $res["skill_zhi"];
                                    $gn_name = '升级';
                                    $gn_state = 'sj';
                                }else{
                                    $jieduan = 1;
                                    $tisheng_zhi = $res["skill_zhi"];
                                    $gn_name = '学习';
                                    $gn_state = 'xx';
                                }

                                if($res["skill_fl"] == 'zd'){
                                    echo '<div>'.$jieduan.'阶: 连续'.$res["skill_cx"].'回合提升'.$tisheng_zhi.'点';
                                }else{
                                    echo '<div>'.$jieduan.'阶: 提升'.$tisheng_zhi.'点';
                                }


                                if($res["skill_lx"] == 'gj'){
                                    echo '攻击';
                                }elseif($res["skill_lx"] == 'fy'){
                                    echo '防御';
                                }elseif($res["skill_lx"] == 'sd'){
                                    echo '速度';
                                }elseif($res["skill_lx"] == 'hp'){
                                    echo '生命';
                                }

                                if($res["skill_fl"] == 'zd'){
                                    echo '，冷却时间'.$res["skill_cd"].'回合';
                                }

                                echo '</div>';

                                $gn_anniu = 1;
                                if($gn_state == 'xx'){
                                    echo '<div>需要灵石:'.$res["skill_money"].'</div>';
                                }else{
                                    $skill_shengji_cailiao = skill_shengji_cailiao($skill_id);
                                    if($skill_shengji_cailiao){
                                        if(isset($skill_shengji_cailiao[$jieduan-1])){
                                            echo '<div style="margin-top: 10px;">升级所需材料:</div>';

                                            $shengji_cailiao = explode('|',$skill_shengji_cailiao[$jieduan-1]);
                                            for($i=1;$i<count($shengji_cailiao);$i++){
                                                $xiaohao_cailiao = explode(',',$shengji_cailiao[$i]);
                                                if($xiaohao_cailiao[0] == 'money'){
                                                    echo '<div>灵石x'.$xiaohao_cailiao[1].'</div>';
                                                }elseif($xiaohao_cailiao[0] == 'wp'){
                                                    $sql = "select wp_name from s_wupin_all where num=$xiaohao_cailiao[1]";
                                                    $res = $sqlHelper->execute_dql($sql);
                                                    echo '<div>'.$res["wp_name"].'x'.$xiaohao_cailiao[2].'</div>';
                                                }
                                            }
                                        }else{
                                            $gn_anniu = 0;
                                        }
                                    }else{
                                        $gn_anniu = 0;
                                    }
                                }

                                if($gn_anniu == 1){
                                    $jiami1 = "x=d&id=".$skill_id.'&k=1';
                                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                    echo "<div><a href='info.php?$url1'>".$gn_name."</a></div><br/>";
                                }

                            }else{
                                echo '<div>该仙术不存在</div>';
                            }

                            $sqlHelper->close_connect();
                        }

                        $jiami1 = "x=r";
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        echo "<div><a href='info.php?$url1'>返回上页</a></div>";
                }
            }
            elseif($dh_fl == 'f'){
                //恢复耐力
                echo '<div>【恢复耐力】</div>';

                $use_nailidan_state = 0;

                if (isset($url_info["k"]) && isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];
                    $suxin1 = explode(".", $url_info["id"]);
                    $dj_id = $suxin1[0];

                    if($gn_fl == 1){
                        //开始恢复耐力
                        $naili_huifu_daoju = naili_huifu_daoju();
                        if(isset($naili_huifu_daoju[$dj_id][1])){
                            $naili_daoju_name = $naili_huifu_daoju[$dj_id][1];

                            $sqlHelper=new SqlHelper();
                            $wp_counts = $sqlHelper->chaxun_wp_counts($naili_daoju_name);
                            $sqlHelper->close_connect();

                            if($wp_counts){
                                $use_nailidan_state = 1;
                            }
                        }
                    }
                }

                $sqlHelper=new SqlHelper();
                $sql = "select sy_nl,z_nl,nld_cs,nld_next_time,cz_jf from s_user where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                $vip_dj = vip_dj($res["cz_jf"]);
                $vip_nlsx_hfcs = vip_nlsx_hfcs($vip_dj);

                $wj_znl = $res["z_nl"] + $vip_nlsx_hfcs[0];
                $wj_synl = $res["sy_nl"];
                $use_nld_cs = $res["nld_cs"];

                $now_time = date("Y-m-d H:i:s");
                if($res["nld_next_time"] == '' || $res["nld_next_time"] < $now_time){
                    $next_times = date('Y-m-d ', strtotime("+1 day") ). "06:00:00";
                    $sqlHelper=new SqlHelper();
                    $sqlHelper->xiugai_wj_user_neirong('nld_next_time',$next_times);
                    $sqlHelper->xiugai_wj_user_neirong('nld_cs',0);
                    $sqlHelper->close_connect();
                    $use_nld_cs = 0;
                }

                $nl_show_time = nl_show_time($vip_nlsx_hfcs[0]);

                $naili_cishu = naili_cishu();
                $z_naili_cishu = $naili_cishu + $vip_nlsx_hfcs[1];

                if($nl_show_time[0]) {
                    if($use_nailidan_state == 1){
                        if(($z_naili_cishu - $use_nld_cs) > 0){
                            $use_state = use_wupin($naili_daoju_name,1);
                            if($use_state == 1){
                                $naili_huifu_zhi = $naili_huifu_daoju[$dj_id][2];

                                if(($wj_synl + $naili_huifu_zhi) > $wj_znl){
                                    $naili_huifu_zhi = $wj_znl - $wj_synl;
                                }

                                $wj_synl += $naili_huifu_zhi;
                                $use_nld_cs += 1;

                                $sqlHelper=new SqlHelper();
                                $sqlHelper->add_wj_user_neirong('sy_nl',$naili_huifu_zhi);
                                $sqlHelper->add_wj_user_neirong('nld_cs',1);
                                $sqlHelper->close_connect();
                                echo '<div style="margin-top: 10px;margin-bottom: 10px;">使用成功，耐力+'.$naili_huifu_zhi.'</div>';
                            }
                        }else{
                            echo '<div style="margin-top: 10px;margin-bottom: 10px;">今日使用次数已满</div>';
                        }

                    }
                    echo '<div>耐力丹可使用次数: '.($z_naili_cishu - $use_nld_cs).'/'.$z_naili_cishu.'</div>';

                    echo '<div>我的耐力:' . $wj_synl . '/' . $wj_znl . '</div>';

                    $naili_huifu_daoju = naili_huifu_daoju();

                    $sqlHelper = new SqlHelper();

                    for ($i = 0; $i < count($naili_huifu_daoju); $i++) {
                        $wp_counts = 0;
                        $nld_name = $naili_huifu_daoju[$i][1];
                        $wp_counts = $sqlHelper->chaxun_wp_counts($nld_name);

                        echo "<div>" . $nld_name . "x" . $wp_counts;
                        if ($wp_counts) {
                            $nld_id = $naili_huifu_daoju[$i][0];

                            $jiami1 = "x=f&k=1&id=".$nld_id;
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo " <a href='info.php?$url1'>使用</a>";

                        }
                        echo '</div>';

                        $nld_zhi = $naili_huifu_daoju[$i][2];
                        echo '<div style="margin-bottom: 10px;">(每次使用恢复' . $nld_zhi . '点耐力)</div>';

                    }
                    echo " <a href='/wxj/xy/shop.php?$url1'>耐力丹可点此购买</a>";
                    $sqlHelper->close_connect();
                }else{
                    echo '<div>我的耐力:'.$wj_synl.'/'.$wj_znl.'</div>';
                    echo '<div>当前耐力已满，无需进行恢复</div>';
                }



                echo '<br/>';


            }
            elseif($dh_fl == 'h') {
                //装备猝练首页
                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $zb_num = $suxin1[0];

                    echo '<div>【装备淬炼】</div>';

                    $sqlHelper = new SqlHelper();
                    $sql = "select zb_name,zb_dj,zb_pinzhi,zb_cl_gj_dj,zb_cl_fy_dj,zb_cl_hp_dj,zb_cl_xq_dj,zb_cl_sd_dj from s_wj_zhuangbei where num=$zb_num and s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    if(!$res){
                        echo '<div>该装备不存在</div>';
                        require_once '../include/time.php';
                        exit;
                    }

                    $zb_gj_dj = $res["zb_cl_gj_dj"];
                    $zb_fy_dj = $res["zb_cl_fy_dj"];
                    $zb_hp_dj = $res["zb_cl_hp_dj"];
                    $zb_xq_dj = $res["zb_cl_xq_dj"];
                    $zb_sd_dj = $res["zb_cl_sd_dj"];

                    echo '<div>'.$res["zb_pinzhi"].$res["zb_name"].'('.$res["zb_dj"].'级)</div><br/>';

                    $zb_cl_name = zb_cl_name();

                    $sqlHelper = new SqlHelper();
                    $wp_counts = $sqlHelper->chaxun_wp_counts($zb_cl_name);
                    $sqlHelper->close_connect();

                    if (isset($url_info["k"])) {
                        $suxin1 = explode(".", $url_info["k"]);
                        $gn_fl = $suxin1[0];

                        if($gn_fl == 1 || $gn_fl == 2 || $gn_fl == 3 || $gn_fl == 4 || $gn_fl == 5){
                            if($gn_fl == 1){
                                $zb_cl_sl = zb_cl_sl($zb_gj_dj);
                            }elseif($gn_fl == 2){
                                $zb_cl_sl = zb_cl_sl($zb_fy_dj);
                            }elseif($gn_fl == 3){
                                $zb_cl_sl = zb_cl_sl($zb_hp_dj);
                            }elseif($gn_fl == 4){
                                $zb_cl_sl = zb_cl_sl($zb_xq_dj);
                            }elseif($gn_fl == 5){
                                $zb_cl_sl = zb_cl_sl($zb_sd_dj);
                            }

                            if($wp_counts >= $zb_cl_sl){
                                $use_state = use_wupin($zb_cl_name,$zb_cl_sl);
                                if($use_state == 1){
                                    $wp_counts -= $zb_cl_sl;
                                    $sqlHelper = new SqlHelper();
                                    if($gn_fl == 1){
                                        $zb_gj_dj += 1;
                                        $cl_sx_name = '攻击';
                                        $sql = "update s_wj_zhuangbei set zb_cl_gj_dj=zb_cl_gj_dj+1 where num=$zb_num and s_name='$_SESSION[id]'";
                                    }elseif($gn_fl == 2){
                                        $zb_fy_dj += 1;
                                        $cl_sx_name = '防御';
                                        $sql = "update s_wj_zhuangbei set zb_cl_fy_dj=zb_cl_fy_dj+1 where num=$zb_num and s_name='$_SESSION[id]'";
                                    }elseif($gn_fl == 3){
                                        $zb_hp_dj += 1;
                                        $cl_sx_name = '生命';
                                        $sql = "update s_wj_zhuangbei set zb_cl_hp_dj=zb_cl_hp_dj+1 where num=$zb_num and s_name='$_SESSION[id]'";
                                    }elseif($gn_fl == 4){
                                        $zb_xq_dj += 1;
                                        $cl_sx_name = '仙气';
                                        $sql = "update s_wj_zhuangbei set zb_cl_xq_dj=zb_cl_xq_dj+1 where num=$zb_num and s_name='$_SESSION[id]'";
                                    }elseif($gn_fl == 5){
                                        $zb_sd_dj += 1;
                                        $cl_sx_name = '速度';
                                        $sql = "update s_wj_zhuangbei set zb_cl_sd_dj=zb_cl_sd_dj+1 where num=$zb_num and s_name='$_SESSION[id]'";
                                    }
                                    $res = $sqlHelper->execute_dml($sql);
                                    $sqlHelper->close_connect();

                                    echo '<div>淬炼成功，装备'.$cl_sx_name.'星值+1</div><br/>';
                                }else{
                                    echo '<div>材料不足，无法淬炼装备！</div><br/>';
                                }
                            }else{
                                echo '<div>材料不足，无法淬炼装备！</div><br/>';
                            }
                        }
                    }

                    $jiami1 = 'x=h&id='.$zb_num.'&k=1';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    $jiami2 = 'x=h&id='.$zb_num.'&k=2';
                    $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);
                    $jiami3 = 'x=h&id='.$zb_num.'&k=3';
                    $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);
                    $jiami4 = 'x=h&id='.$zb_num.'&k=4';
                    $url4 = encrypt_url("$jiami4.$date", $key_url_md_5);
                    $jiami5 = 'x=h&id='.$zb_num.'&k=5';
                    $url5 = encrypt_url("$jiami5.$date", $key_url_md_5);

                    echo "<div><a href='info.php?$url1'>淬炼</a> ★攻击·淬炼值：".$zb_gj_dj."★</div>";
                    $zb_cl_sl = zb_cl_sl($zb_gj_dj);
                    echo "<div>消耗：".$zb_cl_name."x".$zb_cl_sl." 现有：".$wp_counts."</div>";
                    echo "<div><a href='info.php?$url2'>淬炼</a> ★防御·淬炼值：".$zb_fy_dj."★</div>";
                    $zb_cl_sl = zb_cl_sl($zb_fy_dj);
                    echo "<div>消耗：".$zb_cl_name."x".$zb_cl_sl." 现有：".$wp_counts."</div>";
                    echo "<div><a href='info.php?$url3'>淬炼</a> ★生命·淬炼值：".$zb_hp_dj."★</div>";
                    $zb_cl_sl = zb_cl_sl($zb_hp_dj);
                    echo "<div>消耗：".$zb_cl_name."x".$zb_cl_sl." 现有：".$wp_counts."</div>";
                    echo "<div><a href='info.php?$url4'>淬炼</a> ★仙气·淬炼值：".$zb_xq_dj."★</div>";
                    $zb_cl_sl = zb_cl_sl($zb_xq_dj);
                    echo "<div>消耗：".$zb_cl_name."x".$zb_cl_sl." 现有：".$wp_counts."</div>";
                    echo "<div><a href='info.php?$url5'>淬炼</a> ★速度·淬炼值：".$zb_sd_dj."★</div>";
                    $zb_cl_sl = zb_cl_sl($zb_sd_dj);
                    echo "<div>消耗：".$zb_cl_name."x".$zb_cl_sl." 现有：".$wp_counts."</div><br/>";



                    $jiami1 = 'x=y&id='.$zb_num;
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<div><a href='info.php?$url1'>返回上页</a></div>";
                }
            }
        }
    }
}


echo '<a href="../main/main.php">返回首页</a>';
?>