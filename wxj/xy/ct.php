<?php
/**
 * Author: by suxin
 * Date: 2020/1/18
 * Time: 10:10
 * Note: 闯塔
 */

require_once '../include/fzr.php';
require_once '../control/control.php';

//每日闯塔可挖宝的总次数
function wabao_cishu(){
    $wabao_cishu = 0;

    $wabao_gdcishu = wabao_gdcishu();

    $wabao_cishu += $wabao_gdcishu;

    $sqlHelper = new SqlHelper();
    $sql = "select yueka_stop_time,zhizun_vip,cz_jf from s_user where s_name='$_SESSION[id]'";
    $res = $sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();

    if($res["zhizun_vip"]){
        $wabao_zzcishu = wabao_zzcishu();
        $wabao_cishu += $wabao_zzcishu;

        $wabao_ykcishu = wabao_ykcishu();
        $wabao_cishu += $wabao_ykcishu;
    }else{
        $now_time = date("Y-m-d H:i:s");
        if($now_time > $res["yueka_stop_time"]){
            $wabao_ykcishu = wabao_ykcishu();
            $wabao_cishu += $wabao_ykcishu;
        }
    }
    if($res["cz_jf"]){
        $vip_dj = vip_dj($res["cz_jf"]);
        $wabao_vipcishu = wabao_vipcishu();
        $wabao_vipcishu = $wabao_vipcishu * $vip_dj;
        $wabao_cishu += $wabao_vipcishu;
    }

    return $wabao_cishu;
}

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //闯塔首页
            echo '<div>【闯塔】</div>';
            echo '<img src="../images/ta.png">';

            $jiami1 = 'x=e';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            $jiami2 = 'x=w';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

            echo "<div><a href='ct.php?$url1'>进入大雁塔</a> <a href='ct.php?$url2'>规则</a></div>";
            echo '<br/><div>塔顶直入云宵,曾有传言,建成之日,有神仙下凡.塔内多由妖怪镇守稀世珍宝,数千年来，吸引着无数修炼之士的踏入.</div>';
        }elseif($dh_fl == 'w'){
            //闯塔规则
            echo '<div>【闯塔规则】</div>';

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            $wabao_daoju = wabao_daoju();
            $wabao_gdcishu = wabao_gdcishu();
            $wabao_ykcishu = wabao_ykcishu();
            $wabao_zzcishu = wabao_zzcishu();
            $wabao_vipcishu = wabao_vipcishu();

            echo '<div>1. 大雁塔层数越高，打败守塔boss获得的灵气越高</div>';
            echo '<div>2. 每层都有一个宝箱，打败守塔boss可打开宝箱获得大量奖励</div>';
            echo '<div>3. 每层都有一个挖宝点，可消耗'.$wabao_daoju.'进行挖宝</div>';
            echo '<div>4. 每层挖宝固定'.$wabao_gdcishu.'次，月卡玩家额外加'.$wabao_ykcishu.'次，至尊卡玩家额外加'.$wabao_zzcishu.'次，vip每级加'.$wabao_vipcishu.'次</div>';
            echo '<div>5. 每天06:00:00进行闯塔重置</div>';

            echo "<br/><div><a href='ct.php?$url1'>返回大雁塔首页</a></div>";
        }elseif($dh_fl == 'e'){
            //闯塔层数页面

            $wabao_cishu = wabao_cishu();
            $wabao_daoju = wabao_daoju();

            $sqlHelper = new SqlHelper();

            $wp_count = $sqlHelper->chaxun_wp_counts($wabao_daoju);

            $sql = "select ta_ceng,ta_max_ceng,ta_next_time from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);

            $now_time = date("Y-m-d H:i:s");
            if($now_time > $res["ta_next_time"]){
                $next_time = date('Y-m-d ', strtotime("+1 day") ). "06:00:00";
                $sql = "update s_user set ta_ceng=1,ta_max_ceng=1,ta_next_time='$next_time' where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dml($sql);

                $sql = "delete from s_ta_wj_jilu where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dml($sql);

                $sql = "insert into s_ta_wj_jilu(s_name,ceng) values('$_SESSION[id]',1)";
                $res = $sqlHelper->execute_dml($sql);

                $ceng = 1;
                $ta_max_ceng = 1;
                $wabao = 0;
                $xiangzi = 0;
                $skill = 0;
            }
            else{
                $ceng = $res["ta_ceng"];
                $ta_max_ceng = $res["ta_max_ceng"];

                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $ceng_id = $suxin1[0];

                    if($ceng_id <= $ta_max_ceng){
                        $sqlHelper->xiugai_wj_user_neirong('ta_ceng',$ceng_id);
                        $ceng = $ceng_id;

                        $sql = "select num from s_ta_wj_jilu where s_name='$_SESSION[id]' and ceng=$ceng";
                        $res = $sqlHelper->execute_dql($sql);
                        if(!$res){
                            $sql = "insert into s_ta_wj_jilu(s_name,ceng) values('$_SESSION[id]',$ceng)";
                            $res = $sqlHelper->execute_dml($sql);
                        }
                    }
                }

                $sql = "select wabao,skill,xiangzi from s_ta_wj_jilu where s_name='$_SESSION[id]' and ceng=$ceng";
                $res = $sqlHelper->execute_dql($sql);

                $wabao = $res["wabao"];
                $xiangzi = $res["xiangzi"];
                $skill = $res["skill"];
            }

            $sqlHelper->close_connect();

            echo '<div>大雁塔</div>';
            echo '<div>大雁塔'.$ceng.'层</div>';

            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                if($gn_fl == 1){
                    //挖宝
                    if($wp_count > 1){
                        if(($wabao_cishu - $wabao) >= 1){
                            require_once '../include/func.php';
                            $use_state = use_wupin($wabao_daoju,1);
                            if($use_state == 1){
                                $wp_count -= 1;
                                $sqlHelper = new SqlHelper();
                                $sql = "update s_ta_wj_jilu set wabao=wabao+1 where s_name='$_SESSION[id]' and ceng=$ceng";
                                $res = $sqlHelper->execute_dml($sql);
                                $wabao += 1;

                                $sql = "select jl_lx,jl_id,jl_sl,jl_jl from s_ta_jiangli where ta_ceng=$ceng and jl_lx != 'exp'";
                                $res = $sqlHelper->execute_dql2($sql);
                                $sqlHelper->close_connect();
                                if($res){
                                    $note = '';
                                    $count_jiangli = count($res);
                                    for($i=0;$i<$count_jiangli;$i++){
                                        $jl_lx = $res[$i]["jl_lx"];
                                        $jl_id = $res[$i]["jl_id"];
                                        $jl_sl = $res[$i]["jl_sl"];
                                        $jl_jl = $res[$i]["jl_jl"];
                                        $now_rand = rand(1,10000);
                                        if($now_rand < $jl_jl){
                                            if($jl_lx == 'wp'){
                                                $sqlHelper = new SqlHelper();
                                                $sql = "select wp_name from s_wupin_all where num=$jl_id";
                                                $res1 = $sqlHelper->execute_dql($sql);
                                                $note .= '<div>'.$res1["wp_name"].'x'.$jl_sl.'</div>';
                                                $sqlHelper->close_connect();
                                                give_wupin($jl_id,$jl_sl);
                                            }
                                        }
                                    }
                                    if($note){
                                        echo '<div style="margin-top: 10px;">挖宝成功，获得:</div>';
                                        echo '<div style="color:green;">'.$note.'</div>';
                                        echo '<div style="margin-bottom: 10px;"></div>';
                                    }else{
                                        echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">很遗憾，你什么都没挖到~</div>';
                                    }
                                }else{
                                    echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">很遗憾，你什么都没挖到~</div>';
                                }
                            }else{
                                echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">'.$wabao_daoju.'数量不足，无法挖宝</div>';
                            }
                        }else{
                            echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">该层已达到挖宝上限，无法挖宝</div>';
                        }
                    }else{
                        echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">'.$wabao_daoju.'数量不足，无法挖宝</div>';
                    }
                }
                elseif($gn_fl == 2){
                    //开箱子
                    if($xiangzi == 0){
                            if($skill == 1){
                                $xiangzi = 1;
                                $sqlHelper = new SqlHelper();
                                $sql = "update s_ta_wj_jilu set xiangzi=1 where s_name='$_SESSION[id]' and ceng=$ceng";
                                $res = $sqlHelper->execute_dml($sql);

                                $sql = "select jl_lx,jl_id,jl_sl,jl_jl from s_ta_jiangli_box where ta_ceng=$ceng";
                                $res = $sqlHelper->execute_dql2($sql);
                                $sqlHelper->close_connect();
                                if($res){
                                    $note = '';
                                    $count_jiangli = count($res);
                                    for($i=0;$i<$count_jiangli;$i++){
                                        $jl_lx = $res[$i]["jl_lx"];
                                        $jl_id = $res[$i]["jl_id"];
                                        $jl_sl = $res[$i]["jl_sl"];
                                        $jl_jl = $res[$i]["jl_jl"];
                                        $now_rand = rand(1,10000);
                                        if($now_rand < $jl_jl){
                                            if($jl_lx == 'wp'){
                                                $sqlHelper = new SqlHelper();
                                                $sql = "select wp_name from s_wupin_all where num=$jl_id";
                                                $res1 = $sqlHelper->execute_dql($sql);
                                                $note .= '<div>'.$res1["wp_name"].'x'.$jl_sl.'</div>';
                                                $sqlHelper->close_connect();

                                                require_once '../include/func.php';
                                                give_wupin($jl_id,$jl_sl);
                                            }
                                        }
                                    }
                                    if($note){
                                        echo '<div style="margin-top: 10px;">打开了宝箱，获得:</div>';
                                        echo '<div style="color:green;">'.$note.'</div>';
                                        echo '<div style="margin-bottom: 10px;"></div>';
                                    }else{
                                        echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">很遗憾，你打开了一个空箱子~</div>';
                                    }
                                }else{
                                    echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">很遗憾，你打开了一个空箱子~</div>';
                                }
                            }else{
                                echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">打败守塔boss才能开启宝箱哦~</div>';
                            }

                    }
                    else{
                        echo '<div style="margin-bottom: 10px;margin-top: 10px;color:red;">你已经打开过了该箱子</div>';
                    }
                }
            }


            echo '<div>';
            if($ceng != 1){
                $jiami1 = 'x=e&id='.($ceng - 1);
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<a href='ct.php?$url1'>去".($ceng - 1)."层</a>";
            }
            if($ceng < $ta_max_ceng){
                $sqlHelper = new SqlHelper();
                $sql = "select ta_ceng from s_ta_guaiwu order by ta_ceng desc limit 1";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($ceng < $res["ta_ceng"]){
                    if($ceng != 1){
                        echo ' ';
                    }
                    $jiami1 = 'x=e&id='.($ceng + 1);
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<a href='ct.php?$url1'>去".($ceng + 1)."层</a>";
                }
            }
            echo '</div>';


            $sqlHelper = new SqlHelper();
            $sql = "select gw_id from s_ta_guaiwu where ta_ceng=$ceng";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();
            if($res){
                $sqlHelper = new SqlHelper();
                $sql = "select gw_name from s_guaiwu_all where num=$res[gw_id]";
                $res1 = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                if($skill == 0){
                    $jiami1 = 'gw_lx=4';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo "<div><a href='../user/zhandou.php?$url1'>挑战 ".$res1["gw_name"]."</a></div>";
                    echo '<div>闯塔宝箱(击败boss后可开启)</div>';
                }
                else{
                    echo '<div>'.$res1["gw_name"].'(已死亡)</div>';
                    if($xiangzi == 0){
                        $jiami1 = 'x=e&k=2';
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                        echo "<div><a href='ct.php?$url1'>闯塔宝箱</a></div>";
                    }else{
                        echo '<div>闯塔宝箱(已开启)</div>';
                    }
                }

                $jiami1 = 'x=e&k=1';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo '<div>藏宝点:(消耗'.$wabao_daoju.'x1)剩'.($wabao_cishu - $wabao)."次 <a href='ct.php?$url1'>挖宝</a></div>";
                echo '<div>当前拥有:'.$wabao_daoju.'x'.$wp_count.'</div>';
                echo '<div>打败boss可以爬上更高一层。每层可以免费打开闯塔宝箱一次.</div>';
            }else{
                echo '<div style="margin-top: 10px;color:red;">该层数不存在</div>';
            }


            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<br/><div><a href='ct.php?$url1'>返回大雁塔首页</a></div>";
        }
    }
}


require_once '../include/time.php';
?>