<?php
/**
 * Author: by suxin
 * Date: 2019/12/19
 * Time: 17:01
 * Note: 摇钱树
 */

require_once '../include/fzr.php';
require_once '../control/control.php';

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //摇钱树首页
            $sqlHelper = new SqlHelper();
            $sql = "select yqs_cs,yqs_next_time,coin from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $ysy_cs = $res["yqs_cs"];

            if($res["yqs_next_time"]){
                $now_time = date('Y-m-d H:i:s');
                if($now_time > $res["yqs_next_time"]){
                    $next_time = (date('Y-m-d ', strtotime("+1 day") )). "06:00:00";
                    $sqlHelper = new SqlHelper();
                    $sql = "update s_user set yqs_cs=0,yqs_next_time='$next_time' where s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dml($sql);
                    $sqlHelper->close_connect();
                    $ysy_cs = 0;
                }
            }else{
                $next_time = (date('Y-m-d ', strtotime("+1 day") )). "06:00:00";
                $sqlHelper = new SqlHelper();
                $sql = "update s_user set yqs_cs=0,yqs_next_time='$next_time' where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dml($sql);
                $sqlHelper->close_connect();
                $ysy_cs = 0;
            }


            $yaoqianshu_cs = yaoqianshu_cs();
            $zcs = $yaoqianshu_cs[0];
            $mf_cs = $yaoqianshu_cs[1];


            $wj_coin = $res["coin"];
            $sy_cs = $zcs - $ysy_cs;

            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                if($gn_fl == 1){
                    //开始摇

                    if($ysy_cs < $zcs){
                        if($ysy_cs >= $mf_cs){
                            $yaoqianshu_xianquan = yaoqianshu_xianquan();
                            $xh_xq = $yaoqianshu_xianquan[0] + ($ysy_cs - $mf_cs) * $yaoqianshu_xianquan[1];
                        }else{
                            $xh_xq = 0;
                        }

                        if($wj_coin >= $xh_xq){

                            $wj_coin -= $xh_xq;

                            $sqlHelper = new SqlHelper();
                            $sql = "update s_user set yqs_cs=yqs_cs+1,coin=coin-$xh_xq where s_name='$_SESSION[id]'";
                            $res = $sqlHelper->execute_dml($sql);
                            $sqlHelper->close_connect();

                            $yaoqianshu_diaoluo = yaoqianshu_diaoluo();
                            $now_jilv = rand(1,10000);

                            $yaoqianshu_count = count($yaoqianshu_diaoluo);
                            for($i=0;$i<$yaoqianshu_count;$i++){
                                if($now_jilv <= $yaoqianshu_diaoluo[$i][1]){
                                    require_once '../include/func.php';

                                    $wp_num = $yaoqianshu_diaoluo[$i][0];

                                    $sqlHelper = new SqlHelper();
                                    $sql = "select wp_name from s_wupin_all where num=$wp_num";
                                    $res = $sqlHelper->execute_dql($sql);
                                    $sqlHelper->close_connect();

                                    if($res){

                                        give_wupin($wp_num,$yaoqianshu_diaoluo[$i][2]);

                                        $diaoluo_info = '<br/><div>从树上掉落：</div>';
                                        $diaoluo_info .= '<div>'.$res["wp_name"].'x'.$yaoqianshu_diaoluo[$i][2].'</div>';

                                        $ysy_cs += 1;
                                        $sy_cs -= 1;

                                    }

                                    break;
                                }
                            }
                        }else{
                            $diaoluo_info = '<br/><div>仙券数量不足</div>';
                        }
                    }else{
                        $diaoluo_info = '<br/><div>今日次数已满，请明日再来</div>';
                    }
                }
            }

            echo '<div style="font-weight: bold;">【摇钱树】</div>';
            echo '<img src="../images/tree.png">';
            echo '<div>树上琳琅满目的挂满了各种道具，似乎只要清风微抚，就会纷纷滑落。</div>';
            echo '<div>今天剩余次数：'.$sy_cs.'</div>';
            echo '<div>我的仙券: '.$wj_coin.'</div>';

            if($ysy_cs < $mf_cs){
                echo '<div>本次免费！</div>';
            }else{
                $yaoqianshu_xianquan = yaoqianshu_xianquan();
                $xh_xq = $yaoqianshu_xianquan[0] + ($ysy_cs - $mf_cs) * $yaoqianshu_xianquan[1];

                echo '<div>本次消耗:'.$xh_xq.'仙券</div>';
            }

            if(isset($diaoluo_info)){
                echo $diaoluo_info;
            }

            $jiami1 = 'x=q&k=1';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<br/><div><a href='yqs.php?$url1'>使劲摇</a></div>";

        }
    }
}

require_once '../include/time.php';
?>