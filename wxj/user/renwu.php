<?php
/**
 * Author: by suxin
 * Date: 2019/12/21
 * Time: 20:49
 * Note: 任务
 */

require_once '../include/fzr.php';

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //主线任务首页
            echo '<div>【主线任务】</div>';

            if (isset($url_info["k"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];

                if ($gn_fl == 1) {
                    //领取主线奖励
                    $sqlHelper = new SqlHelper();
                    $sql = "select rw_zx_jd,rw_zx_skill from s_user where s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    $sqlHelper = new SqlHelper();
                    $sql = "select rw_biaoti,rw_mubiao,rw_jiangli_money,rw_jiangli_exp,rw_jiangli_wp1_id,rw_jiangli_wp1_sl,rw_jiangli_wp2_id,rw_jiangli_wp2_sl,rw_jiangli_wp3_id,rw_jiangli_wp3_sl,rw_jiangli_wp4_id,rw_jiangli_wp4_sl,rw_jiangli_wp5_id,rw_jiangli_wp5_sl from s_renwu where rw_jindu=$res[rw_zx_jd]";
                    $res1 = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    if ($res1) {

                        if ($res["rw_zx_skill"] == 1) {
                            $sqlHelper = new SqlHelper();
                            $sql = "update s_user set rw_zx_jd=rw_zx_jd+1,rw_zx_skill=0 where s_name='$_SESSION[id]'";
                            $res2 = $sqlHelper->execute_dml($sql);
                            $sqlHelper->close_connect();

                            $jiangli_array = array();

                            if ($res1["rw_jiangli_money"]) {
                                $sqlHelper = new SqlHelper();
                                $sqlHelper->add_wj_user_neirong('money', $res1["rw_jiangli_money"]);
                                $sqlHelper->close_connect();
                                $jiangli_array [] = '灵石x' . $res1["rw_jiangli_money"];
                            }
                            if ($res1["rw_jiangli_exp"]) {
                                $sqlHelper = new SqlHelper();
                                $sqlHelper->add_wj_user_neirong('exp', $res1["rw_jiangli_exp"]);
                                $sqlHelper->close_connect();
                                $jiangli_array [] = '灵气x' . $res1["rw_jiangli_exp"];
                            }
                            if ($res1["rw_jiangli_wp1_id"]) {
                                $sqlHelper = new SqlHelper();
                                $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp1_id]";
                                $res2 = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if ($res2) {
                                    require_once '../include/func.php';
                                    give_wupin($res1["rw_jiangli_wp1_id"], $res1["rw_jiangli_wp1_sl"]);
                                    $jiangli_array [] = $res2["wp_name"] . 'x' . $res1["rw_jiangli_wp1_sl"];
                                }
                            }
                            if ($res1["rw_jiangli_wp2_id"]) {
                                $sqlHelper = new SqlHelper();
                                $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp2_id]";
                                $res2 = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if ($res2) {
                                    require_once '../include/func.php';
                                    give_wupin($res1["rw_jiangli_wp2_id"], $res1["rw_jiangli_wp2_sl"]);
                                    $jiangli_array [] = $res2["wp_name"] . 'x' . $res1["rw_jiangli_wp2_sl"];
                                }
                            }
                            if ($res1["rw_jiangli_wp3_id"]) {
                                $sqlHelper = new SqlHelper();
                                $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp3_id]";
                                $res2 = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if ($res2) {
                                    require_once '../include/func.php';
                                    give_wupin($res1["rw_jiangli_wp3_id"], $res1["rw_jiangli_wp3_sl"]);
                                    $jiangli_array [] = $res2["wp_name"] . 'x' . $res1["rw_jiangli_wp3_sl"];
                                }
                            }
                            if ($res1["rw_jiangli_wp4_id"]) {
                                $sqlHelper = new SqlHelper();
                                $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp4_id]";
                                $res2 = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if ($res2) {
                                    require_once '../include/func.php';
                                    give_wupin($res1["rw_jiangli_wp4_id"], $res1["rw_jiangli_wp4_sl"]);
                                    $jiangli_array [] = $res2["wp_name"] . 'x' . $res1["rw_jiangli_wp4_sl"];
                                }
                            }
                            if ($res1["rw_jiangli_wp5_id"]) {
                                $sqlHelper = new SqlHelper();
                                $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp5_id]";
                                $res2 = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if ($res2) {
                                    require_once '../include/func.php';
                                    give_wupin($res1["rw_jiangli_wp5_id"], $res1["rw_jiangli_wp5_sl"]);
                                    $jiangli_array [] = $res2["wp_name"] . 'x' . $res1["rw_jiangli_wp5_sl"];
                                }
                            }

                            $jiangli_count = count($jiangli_array);
                            echo '<div>领取成功!获得:</div>';
                            for ($i = 0; $i < $jiangli_count; $i++) {
                                echo '<div>' . $jiangli_array[$i] . '</div>';
                            }
                            echo '<br/>';
                        }
                    }
                }
            }

            $sqlHelper=new SqlHelper();
            $sql = "select rw_zx_jd,rw_zx_skill from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);

            $sql = "select rw_biaoti,rw_mubiao,rw_jiangli_money,rw_jiangli_exp,rw_jiangli_wp1_id,rw_jiangli_wp1_sl,rw_jiangli_wp2_id,rw_jiangli_wp2_sl,rw_jiangli_wp3_id,rw_jiangli_wp3_sl,rw_jiangli_wp4_id,rw_jiangli_wp4_sl,rw_jiangli_wp5_id,rw_jiangli_wp5_sl from s_renwu where rw_jindu=$res[rw_zx_jd]";
            $res1 = $sqlHelper->execute_dql($sql);

            if($res1){
                echo '<div>【'.$res1["rw_biaoti"].'】</div>';
                echo '<div>目标:'.$res1["rw_mubiao"].'</div>';
                echo '<div>奖励:[';

                $jiangli_array = array();

                if($res1["rw_jiangli_money"]){
                    $jiangli_array []= '灵石x'.$res1["rw_jiangli_money"];
                }
                if($res1["rw_jiangli_exp"]){
                    $jiangli_array []= '灵气x'.$res1["rw_jiangli_exp"];
                }
                if($res1["rw_jiangli_wp1_id"]){
                    $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp1_id]";
                    $res2 = $sqlHelper->execute_dql($sql);
                    if($res2){
                        $jiangli_array []= $res2["wp_name"].'x'.$res1["rw_jiangli_wp1_sl"];
                    }
                }
                if($res1["rw_jiangli_wp2_id"]){
                    $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp2_id]";
                    $res2 = $sqlHelper->execute_dql($sql);
                    if($res2){
                        $jiangli_array []= $res2["wp_name"].'x'.$res1["rw_jiangli_wp2_sl"];
                    }
                }
                if($res1["rw_jiangli_wp3_id"]){
                    $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp3_id]";
                    $res2 = $sqlHelper->execute_dql($sql);
                    if($res2){
                        $jiangli_array []= $res2["wp_name"].'x'.$res1["rw_jiangli_wp3_sl"];
                    }
                }
                if($res1["rw_jiangli_wp4_id"]){
                    $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp4_id]";
                    $res2 = $sqlHelper->execute_dql($sql);
                    if($res2){
                        $jiangli_array []= $res2["wp_name"].'x'.$res1["rw_jiangli_wp4_sl"];
                    }
                }
                if($res1["rw_jiangli_wp5_id"]){
                    $sql = "select wp_name from s_wupin_all where num=$res1[rw_jiangli_wp5_id]";
                    $res2 = $sqlHelper->execute_dql($sql);
                    if($res2){
                        $jiangli_array []= $res2["wp_name"].'x'.$res1["rw_jiangli_wp5_sl"];
                    }
                }

                $jiangli_count = count($jiangli_array);
                for($i=0;$i<$jiangli_count;$i++){
                    echo $jiangli_array[$i];
                    if(($i + 1) < $jiangli_count){
                        echo ', ';
                    }
                }

                echo ']</div>';

                echo '<div>任务状态:';
                if($res["rw_zx_skill"] == 1){
                    $jiami1 = "x=q&k=1";
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo "<a href='renwu.php?$url1'>领取奖励</a>";
                }else{
                    echo '进行中';
                }
                echo '</div>';
            }else{
                echo '<div>暂无任务，请耐心等待开放</div>';
            }

            $sqlHelper->close_connect();
        }
    }
}

require_once '../include/time.php';
?>