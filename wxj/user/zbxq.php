<?php
/**
 * Author: by suxin
 * Date: 2020/1/2
 * Time: 17:14
 * Note: 装备镶嵌
 */

require_once '../include/fzr.php';
require_once '../control/control.php';
require_once '../include/func.php';


if(isset($_SESSION['id']) && isset($_SESSION['pass'])) {
    if ($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["x"])) {
            $suxin1 = explode(".", $url_info["x"]);
            $dh_fl = $suxin1[0];

            if($dh_fl == 'q'){
                //装备开孔
                if (isset($url_info["kwid"]) && isset($url_info["zbid"])) {
                    $suxin1 = explode(".", $url_info["kwid"]);
                    $kwid = $suxin1[0];
                    $suxin1 = explode(".", $url_info["zbid"]);
                    $zbid = $suxin1[0];

                    $sqlHelper=new SqlHelper();
                    $sql = "select zb_kw1,zb_kw2,zb_kw3,zb_kw4,zb_kw5,zb_kw6,zb_kw7,zb_kw8,zb_kw9,zb_kw10 from s_wj_zhuangbei where num=$zbid and s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    if($res){
                        echo '<div>【装备开孔】</div>';

                        $kw_cunzai = 1;
                        if($kwid == 1){
                            $kw_state = $res["zb_kw1"];
                            $last_state = 0;
                        }elseif($kwid == 2){
                            $kw_state = $res["zb_kw2"];
                            $last_state = $res["zb_kw1"];
                        }elseif($kwid == 3){
                            $kw_state = $res["zb_kw3"];
                            $last_state = $res["zb_kw2"];
                        }elseif($kwid == 4){
                            $kw_state = $res["zb_kw4"];
                            $last_state = $res["zb_kw3"];
                        }elseif($kwid == 5){
                            $kw_state = $res["zb_kw5"];
                            $last_state = $res["zb_kw4"];
                        }elseif($kwid == 6){
                            $kw_state = $res["zb_kw6"];
                            $last_state = $res["zb_kw5"];
                        }elseif($kwid == 7){
                            $kw_state = $res["zb_kw7"];
                            $last_state = $res["zb_kw6"];
                        }elseif($kwid == 8){
                            $kw_state = $res["zb_kw8"];
                            $last_state = $res["zb_kw7"];
                        }elseif($kwid == 9){
                            $kw_state = $res["zb_kw9"];
                            $last_state = $res["zb_kw8"];
                        }elseif($kwid == 10){
                            $kw_state = $res["zb_kw10"];
                            $last_state = $res["zb_kw9"];
                        }else{
                            $kw_cunzai = 0;
                        }

                        if($kw_cunzai == 1){
                            if($last_state == -1){
                                echo '<div>需要先开启上一孔位哦！</div>';
                            }else{
                                if($kw_state == -1){
                                    $zb_kk_daoju = zb_kk_daoju();
                                    $zb_kk_daoju_sl = zb_kk_daoju_sl($kwid);

                                    $sqlHelper=new SqlHelper();
                                    $wp_counts = $sqlHelper->chaxun_wp_counts($zb_kk_daoju);
                                    $sqlHelper->close_connect();

                                    $zb_kk_cgl = zb_kk_cgl($kwid);

                                    if (isset($url_info["k"])) {
                                        $suxin1 = explode(".", $url_info["k"]);
                                        $gn_fl = $suxin1[0];

                                        $sqlHelper=new SqlHelper();
                                        $wp_counts = $sqlHelper->chaxun_wp_counts($zb_kk_daoju);
                                        $sqlHelper->close_connect();

                                        if (isset($url_info["xycsl"])) {
                                            $suxin1 = explode(".", $url_info["xycsl"]);
                                            $xyc_sl = $suxin1[0];
                                            $zb_kk_xyc = zb_kk_xyc();
                                            $sqlHelper=new SqlHelper();
                                            $xyc_wj_sl = $sqlHelper->chaxun_wp_counts($zb_kk_xyc[0]);
                                            $sqlHelper->close_connect();
                                            if($xyc_wj_sl >= $xyc_sl){
                                                $xyc_state = 1;
                                            }else{
                                                $xyc_state = 0;
                                            }
                                        }else{
                                            $xyc_state = 1;
                                            $xyc_sl = 0;
                                        }

                                        if($wp_counts >= $zb_kk_daoju_sl && $xyc_state == 1){
                                            if($xyc_sl){
                                                $use_state = use_wupin($zb_kk_xyc[0],$xyc_sl);
                                                $zb_kk_cgl += $xyc_sl * $zb_kk_xyc[1];
                                            }
                                            $use_state = use_wupin($zb_kk_daoju,$zb_kk_daoju_sl);
                                            if($use_state == 1){
                                                $now_rand = rand(1,100);

                                                if($now_rand <= $zb_kk_cgl){
                                                    $kw_name = 'zb_kw'.$kwid;

                                                    $sqlHelper=new SqlHelper();
                                                    $sql = "update s_wj_zhuangbei set $kw_name=0 where s_name='$_SESSION[id]' and num=$zbid";
                                                    $res = $sqlHelper->execute_dml($sql);
                                                    $sqlHelper->close_connect();

                                                    echo '<div style="margin-top: 10px;margin-bottom: 10px;">恭喜你，开孔成功了！</div>';

                                                    $jiami1 = 'x=y&id='.$zbid;
                                                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                                                    echo "<div style='margin-top: 10px;'><a href='info.php?$url1'>返回上页</a></div>";

                                                    require_once '../include/time.php';
                                                    exit;
                                                }else{
                                                    echo '<div style="margin-top: 10px;margin-bottom: 10px;">很遗憾，开孔失败了！</div>';
                                                    $wp_counts -= $zb_kk_daoju_sl;
                                                }
                                            }
                                        }
                                    }

                                    echo '<div>当前开孔消耗:</div>';
                                    echo '<div>'.$zb_kk_daoju.'x'.$zb_kk_daoju_sl.'</div>';

                                    echo '<div style="margin-top: 3px;">已有:</div>';

                                    echo '<div>'.$zb_kk_daoju.'x'.$wp_counts.'</div>';

                                    $zb_kk_xyc = zb_kk_xyc();

                                    $sqlHelper=new SqlHelper();
                                    $xyc_counts = $sqlHelper->chaxun_wp_counts($zb_kk_xyc[0]);
                                    $sqlHelper->close_connect();

                                    if (isset($url_info["xyc"])) {
                                        $suxin1 = explode(".", $url_info["xyc"]);
                                        $xyc_sl = $suxin1[0];
                                        $xyc_sl = floor($xyc_sl);
                                        if($xyc_sl <= 0){
                                            $xyc_sl = 0;
                                        }

                                        $xyc_sl += 1;

                                        if($xyc_counts < $xyc_sl){
                                            $xyc_sl -= 1;
                                        }
                                    }else{
                                        $xyc_sl = 0;
                                    }

                                    if($xyc_sl){
                                        $zb_kk_cgl += $xyc_sl * $zb_kk_xyc[1];
                                    }

                                    if($zb_kk_cgl > 100){
                                        $xyc_sl -= 1;
                                        $zb_kk_cgl = 100;
                                    }

                                    $jiami1 = 'x=q&zbid='.$zbid.'&kwid='.$kwid.'&xyc='.$xyc_sl;
                                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                    echo '<div>成功率'.$zb_kk_cgl."% <a href='zbxq.php?$url1'>增加</a>(消耗".$zb_kk_xyc[0]."x1增加".$zb_kk_xyc[1]."%几率)</div>";
                                    if($xyc_sl){
                                        echo '<div>(已增加'.$zb_kk_xyc[0].'x'.$xyc_sl.")</div>";
                                    }


                                    echo '<div>(当前拥有'.$zb_kk_xyc[0].'x'.$xyc_counts.")</div>";

                                    if($wp_counts >= $zb_kk_daoju_sl){
                                        $jiami1 = 'x=q&zbid='.$zbid.'&kwid='.$kwid.'&k=1&xycsl='.$xyc_sl;
                                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                                        echo "<div><a href='zbxq.php?$url1'>开孔</a></div>";
                                    }else{
                                        echo "<div>开孔</div>";
                                    }
                                }else{
                                    echo '<div>当前孔位已处于开启状态！</div>';
                                }
                            }
                        }


                        $jiami1 = 'x=y&id='.$zbid;
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        echo "<div style='margin-top: 10px;'><a href='info.php?$url1'>返回上页</a></div>";
                    }
                }
            }
            elseif($dh_fl == 'w'){
                //选择宝石镶嵌
                if (isset($url_info["kwid"]) && isset($url_info["zbid"])) {
                    $suxin1 = explode(".", $url_info["kwid"]);
                    $kwid = $suxin1[0];
                    $suxin1 = explode(".", $url_info["zbid"]);
                    $zbid = $suxin1[0];

                    echo '<div>【宝石镶嵌】</div>';

                    $sqlHelper=new SqlHelper();
                    $sql = "select zb_kw1,zb_kw2,zb_kw3,zb_kw4,zb_kw5,zb_kw6,zb_kw7,zb_kw8,zb_kw9,zb_kw10 from s_wj_zhuangbei where num=$zbid and s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    if($res){
                        $kw_cunzai = 1;
                        if($kwid == 1){
                            $kw_state = $res["zb_kw1"];
                        }elseif($kwid == 2){
                            $kw_state = $res["zb_kw2"];
                        }elseif($kwid == 3){
                            $kw_state = $res["zb_kw3"];
                        }elseif($kwid == 4){
                            $kw_state = $res["zb_kw4"];
                        }elseif($kwid == 5){
                            $kw_state = $res["zb_kw5"];
                        }elseif($kwid == 6){
                            $kw_state = $res["zb_kw6"];
                        }elseif($kwid == 7){
                            $kw_state = $res["zb_kw7"];
                        }elseif($kwid == 8){
                            $kw_state = $res["zb_kw8"];
                        }elseif($kwid == 9){
                            $kw_state = $res["zb_kw9"];
                        }elseif($kwid == 10){
                            $kw_state = $res["zb_kw10"];
                        }else{
                            $kw_cunzai = 0;
                        }

                        if (isset($url_info["k"])) {
                            $suxin1 = explode(".", $url_info["k"]);
                            $gn_fl = $suxin1[0];

                            if($gn_fl == 1 && $kw_state != 0 && $kw_state != -1){
                                $kw_weizhi = 'zb_kw'.$kwid;

                                $sqlHelper=new SqlHelper();
                                $sql = "select bs_name from s_baoshi_all where num=$kw_state";
                                $res = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if($res){
                                    $sqlHelper=new SqlHelper();
                                    $sql = "select num from s_wupin_all where wp_name='$res[bs_name]'";
                                    $res = $sqlHelper->execute_dql($sql);
                                    $sqlHelper->close_connect();
                                    give_wupin($res["num"],1);
                                }

                                $sqlHelper=new SqlHelper();
                                $sql = "update s_wj_zhuangbei set $kw_weizhi=0 where s_name='$_SESSION[id]' and num=$zbid";
                                $res = $sqlHelper->execute_dml($sql);
                                $sqlHelper->close_connect();

                                $kw_state = 0;
                            }
                        }

                        if($kw_cunzai == 1){
                            if($kw_state == -1){
                                echo '<div>当前孔位未开启！</div>';
                            }else{
                                if($kw_state == 0){
                                    if (isset($url_info["bsid"])) {
                                        $suxin1 = explode(".", $url_info["bsid"]);
                                        $bs_id = $suxin1[0];

                                        $sqlHelper=new SqlHelper();
                                        $sql = "select wp_name from s_wj_bag where num=$bs_id and s_name='$_SESSION[id]'";
                                        $res = $sqlHelper->execute_dql($sql);
                                        $sqlHelper->close_connect();
                                        if($res){
                                            $use_state = use_wupin($res["wp_name"],1);
                                            if($use_state == 1){
                                                $sqlHelper=new SqlHelper();
                                                $sql = "select num from s_baoshi_all where bs_name='$res[wp_name]'";
                                                $res = $sqlHelper->execute_dql($sql);
                                                $sqlHelper->close_connect();
                                                if($res){
                                                    $kw_weizhi = 'zb_kw'.$kwid;
                                                    $sqlHelper=new SqlHelper();
                                                    $sql = "update s_wj_zhuangbei set $kw_weizhi='$res[num]' where s_name='$_SESSION[id]' and num=$zbid";
                                                    $res = $sqlHelper->execute_dml($sql);
                                                    $sqlHelper->close_connect();

                                                    $jiami1 = 'x=y&id='.$zbid;
                                                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                                    header("location: info.php?$url1");
                                                    exit;
                                                }
                                            }
                                        }
                                    }

                                    echo '<div>当前镶嵌:无</div>';

                                    $sqlHelper=new SqlHelper();
                                    $sql = "select wp_name,wp_counts,num from s_wj_bag where s_name='$_SESSION[id]' and wp_fenlei='bs'";
                                    $res = $sqlHelper->execute_dql2($sql);
                                    $sqlHelper->close_connect();

                                    for($i=0;$i<count($res);$i++){
                                        $bs_num = $res[$i]["num"];
                                        $jiami1 = 'x=w&zbid='.$zbid.'&kwid='.$kwid.'&bsid='.$bs_num;
                                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                                        echo '<div>'.$res[$i]["wp_name"].'x'.$res[$i]["wp_counts"]." <a href='zbxq.php?$url1'>选择</a></div>";
                                    }
                                }
                                else{
                                    $sqlHelper=new SqlHelper();
                                    $sql = "select bs_name from s_baoshi_all where num=$kw_state";
                                    $res = $sqlHelper->execute_dql($sql);
                                    $sqlHelper->close_connect();

                                    echo '<div>当前镶嵌:'.$res["bs_name"].'</div>';
                                    $jiami1 = 'x=w&zbid='.$zbid.'&kwid='.$kwid.'&k=1';
                                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                                    echo "<div><a href='zbxq.php?$url1'>取下宝石</a></div>";
                                }
                            }
                        }
                    }

                    $jiami1 = 'x=y&id='.$zbid;
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    echo "<div style='margin-top: 10px;'><a href='info.php?$url1'>返回上页</a></div>";
                }
            }
        }
    }
}

require_once '../include/time.php';
?>