<?php
/**
 * Author: by suxin
 * Date: 2020/1/6
 * Time: 11:06
 * Note: 使用物品
 */

require_once '../include/fzr.php';
require_once '../include/func.php';

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_num = $suxin1[0];

                //选择使用的数量
                $sqlHelper = new SqlHelper();
                $sql = "select wp_name,wp_counts from s_wj_bag where s_name='$_SESSION[id]' and num=$wp_num";
                $res = $sqlHelper->execute_dql($sql);

                if($res){
                    $sql = "select wp_canuse from s_wupin_all where wp_name='$res[wp_name]'";
                    $res1 = $sqlHelper->execute_dql($sql);

                    if($res1){
                        echo '<div>【物品使用】</div>';
                        if($res1["wp_canuse"] == 1){
                            echo $res["wp_name"]."(".$res["wp_counts"].")<br/>";
                            echo "<div>请输入要使用的数量: </div>";

                            $jiami1 = 'x=w&id='.$wp_num;
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<form  action='use_wp.php?$url1' method='POST'>";
                            ?>

                            <input type="tel" name="counts" placeholder="请输入使用数量" value=1 id='search' onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"><br>

                            <?php

                            echo "<input  type='submit' name='submit'  value='使用' id='search1'><br>";
                            echo "</form>";
                        }else{
                            echo '<div style="margin-top: 5px;">该物品不可使用！</div>';
                        }
                    }
                }

                $sqlHelper ->close_connect();
            }
        }
        elseif($dh_fl == 'w' && isset($_POST["counts"])){
            //使用物品
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_num = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $sql = "select wp_name,wp_counts from s_wj_bag where s_name='$_SESSION[id]' and num=$wp_num";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper ->close_connect();

                if($res){
                    $wp_name = $res["wp_name"];
                    $sqlHelper = new SqlHelper();
                    $sql = "select wp_canuse,wp_xfl,wp_list from s_wupin_all where wp_name='$wp_name'";
                    $res1 = $sqlHelper->execute_dql($sql);
                    $sqlHelper ->close_connect();

                    if($res1){
                        echo '<div>【物品使用】</div>';
                        if($res1["wp_canuse"] == 1){
                            $count = trim($_POST["counts"]);
                            require_once '../../safe/feifa.php';
                            $count_state = feifa_shuzi($count);

                            if($count_state == 1){
                                if($res1["wp_xfl"] == 'chenghao'){
                                    $count = 1;
//                                    echo '<div>称号类物品,只能使用一个</div>';
                                }

                                if($res["wp_counts"] < $count){
                                    $count = $res["wp_counts"];
                                }

                                $use_wupin_state = 1;

                                if($res1["wp_xfl"] == 'chenghao'){
                                    $sqlHelper = new SqlHelper();
                                    $sql = "select num from s_wj_chenghao where s_name='$_SESSION[id]' and ch_name='$wp_name'";
                                    $res = $sqlHelper->execute_dql($sql);
                                    $sqlHelper->close_connect();

                                    if($res){
                                        $use_wupin_state = 0;
                                        echo '<div>你已经获得了该称号,无法重复使用</div>';
                                    }
                                }

                                if($use_wupin_state == 1){
                                    $use_state = use_wupin($wp_name,$count);
                                    if($use_state == 1){
                                        echo '<div style="margin-bottom: 5px;">消耗了'.$wp_name.'x'.$count.'</div>';
                                        echo '<div>使用成功,获得</div>';

                                        if($res1["wp_xfl"] == 'chenghao'){
                                            $sqlHelper = new SqlHelper();

                                            $sql = "select ch_gj,ch_xq,ch_fy,ch_hp,ch_sd,ch_bj,ch_rx,ch_jf from s_chenghao_all where ch_name='$wp_name'";
                                            $res = $sqlHelper->execute_dql($sql);
                                            if($res){
                                                $sql = "update s_user set ch_gj=ch_gj+$res[ch_gj],ch_xq=ch_xq+$res[ch_xq],ch_fy=ch_fy+$res[ch_fy],ch_hp=ch_hp+$res[ch_hp],ch_sd=ch_sd+$res[ch_sd],ch_bj=ch_bj+$res[ch_bj],ch_rx=ch_rx+$res[ch_rx],ch_jf=ch_jf+$res[ch_jf] where s_name='$_SESSION[id]'";
                                                $res1 = $sqlHelper->execute_dml($sql);

                                                $now_time = date("Y-m-d H:i:s");
                                                $sql = "insert into s_wj_chenghao(s_name,ch_name,ch_time) values('$_SESSION[id]','$wp_name','$now_time')";
                                                $res = $sqlHelper->execute_dml($sql);
                                                echo '<div>称号: '.$wp_name.'</div>';
                                               }

                                            $sqlHelper->close_connect();
                                        }
                                        elseif($res1["wp_xfl"] == 'xiangzi'){
                                            $wp_list = explode('|',$res1["wp_list"]);
                                            $count_wp_list = count($wp_list);

                                            $wp_num_array = array();
                                            $wp_sl_array = array();

                                            for($j=0;$j<$count;$j++){
                                                for($i=0;$i<$count_wp_list;$i++){
                                                    $jiangli = explode(',',$wp_list[$i]);
                                                    $now_rand = rand(1,10000);
                                                    if($now_rand <= $jiangli[3]){
                                                        if($jiangli[0] == 'wp'){
                                                            $shuliang = explode('~',$jiangli[2]);
                                                            $shuliang = rand($shuliang[0],$shuliang[1]);

                                                            if(in_array($jiangli[1],$wp_num_array)){
                                                                for($k=0;$k<count($wp_num_array);$k++){
                                                                    if($wp_num_array[$k] == $jiangli[1]){
                                                                        $wp_sl_array[$k] = $wp_sl_array[$k] + $shuliang;
                                                                        break;
                                                                    }
                                                                }
                                                            }else{
                                                                $wp_num_array []= $jiangli[1];
                                                                $wp_sl_array []= $shuliang;
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            for($i=0;$i<count($wp_num_array);$i++){
                                                $wp_num = $wp_num_array[$i];
                                                give_wupin($wp_num,$wp_sl_array[$i]);

                                                $sqlHelper = new SqlHelper();
                                                $sql = "select wp_name from s_wupin_all where num=$wp_num";
                                                $res = $sqlHelper->execute_dql($sql);
                                                $sqlHelper->close_connect();
                                                echo '<div>'.$res["wp_name"].'x'.$wp_sl_array[$i].'</div>';
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            echo '<div style="margin-top: 5px;">该物品不可使用！</div>';
                        }
                    }
                }
            }

            $jiami1 = 'x=r';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<div><a href='bag.php?$url1'>返回背包</a></div>";
        }
    }
}

require_once '../include/time.php';
?>