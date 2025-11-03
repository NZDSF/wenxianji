<?php
/**
 * Author: by suxin
 * Date: 2019/12/5
 * Time: 12:41
 * Note: 副本
 */

require_once '../include/fzr.php';
require_once '../control/control.php';

//检测玩家副本战斗状态
function check_fuben_state(){
    $sqlHelper = new SqlHelper();
    $wj_state = $sqlHelper->chaxun_wj_user_neirong('state');
    $sqlHelper->close_connect();
    if($wj_state){
        header("location: zhandou.php");
        exit;
    }else{
        $sqlHelper = new SqlHelper();
        $sql = "select fb_jindu,fb_jieduan,fb_zhandou_gw from s_wj_fuben where s_name='$_SESSION[id]'";
        $res = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();
        if($res){
            if($res["fb_zhandou_gw"]){
                header("location: zhandou.php");
                exit;
            }else{
                $jiami1 = "x=e&id=" . $res["fb_jindu"];
                global $date,$key_url_md_5;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                header("location: fuben.php?$url1");
                exit;
            }
        }
    }
}

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //副本大厅
            if (isset($url_info["fq_state"])) {
                $suxin1 = explode(".", $url_info["fq_state"]);
                $fq_state = $suxin1[0];
                if($fq_state == 1){
                    $sqlHelper = new SqlHelper();
                    $sql = "delete from s_wj_fuben where s_name='$_SESSION[id]'";
                    $res1 = $sqlHelper->execute_dml($sql);
                    $sql = "delete from s_wj_guaiwu where s_name='$_SESSION[id]'";
                    $res1 = $sqlHelper->execute_dml($sql);
                    $sqlHelper->close_connect();
                }
            }

            check_fuben_state();

            echo '<div>【副本大厅】</div>';
            echo '<img src="../images/map.png">';
            $sqlHelper = new SqlHelper();
            $wj_fuben_jindu = $sqlHelper->chaxun_wj_user_neirong('fb_jindu');
            $sql = "select num,fb_name,fb_min_dj,fb_max_dj from s_fuben_info1";
            $res = $sqlHelper->execute_dql2($sql);
            $sqlHelper->close_connect();

            $fb_name_count = count($res);

            for($i=0;$i<$fb_name_count;$i++){
                echo '<div>';
                $dafuben_num = $res[$i]["num"];
                $sqlHelper = new SqlHelper();
                $sql = "select fb_jindu from s_fuben_info2 where fb_info1_num=$dafuben_num order by fb_jindu asc limit 1";
                $res1 = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                $fuben_jindu = $res1["fb_jindu"];

                if($fuben_jindu > $wj_fuben_jindu){
                    echo '未开启 ';
                }else{
                    $jiami1 = "x=w&id=".$res[$i]["num"];
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<a href='fuben.php?$url1'>探索</a> ";
                }
                echo $res[$i]["fb_name"].''.$res[$i]["fb_min_dj"].'-'.$res[$i]["fb_max_dj"].'级</div>';
            }
            require_once '../include/time.php';
        }
        elseif($dh_fl == 'w') {
            //副本列表
            check_fuben_state();

            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $fb_id = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $wj_fuben_jindu = $sqlHelper->chaxun_wj_user_neirong('fb_jindu');
                $sql = "select num,fb_name,fb_min_dj,fb_max_dj from s_fuben_info1 where num=$fb_id";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res){
                    echo '<div style="font-weight: bold;">'.$res["fb_name"].$res["fb_min_dj"].'-'.$res["fb_max_dj"].'级</div>';

                    $sqlHelper = new SqlHelper();
                    $sql = "select num,fb_name,fb_jindu,fb_min_dj,fb_max_dj from s_fuben_info2 where fb_info1_num=$fb_id";
                    $res1 = $sqlHelper->execute_dql2($sql);
                    $sqlHelper->close_connect();

                    $fb_name_count = count($res1);
                    for ($i = 0; $i < $fb_name_count; $i++) {
                        echo '<div>';
                        echo $res1[$i]["fb_name"] . '(' . $res1[$i]["fb_min_dj"] . '-' . $res1[$i]["fb_max_dj"] . ')';
                        $fuben_jindu = $res1[$i]["fb_jindu"];
                        if ($fuben_jindu > $wj_fuben_jindu) {
                            echo ' 进入';
                        } else {
                            $jiami1 = "x=e&id=" . $res1[$i]["fb_jindu"];
                            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                            echo " <a href='fuben.php?$url1'>进入</a>";
                        }
                        echo '</div>';
                    }
                }
            }

            $jiami1 = "x=q";
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<a href='fuben.php?$url1'>返回上页</a>";
            require_once '../include/time.php';
        }
        elseif($dh_fl == 'e') {
            //副本进度

            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $fb_id = $suxin1[0];
            }

            $sqlHelper = new SqlHelper();
            $sql = "select num,fb_jindu,fb_jieduan from s_wj_fuben where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            if($res){
                $fb_jindu = $res["fb_jindu"];
                $fb_jieduan = $res["fb_jieduan"];

                if (isset($url_info["qj_state"])) {
                    $suxin1 = explode(".", $url_info["qj_state"]);
                    $qj_state = $suxin1[0];
                    if($qj_state == 1){
                        $sql = "select num from s_wj_guaiwu where s_name='$_SESSION[id]' and gw_sy_hp > 0";
                        $res = $sqlHelper->execute_dql($sql);
                        if(!$res){
                            $fb_jieduan += 1;
                            $sql = "delete from s_wj_guaiwu where s_name='$_SESSION[id]'";
                            $res = $sqlHelper->execute_dml($sql);
                            $sql = "update s_wj_fuben set fb_jieduan=$fb_jieduan where s_name='$_SESSION[id]'";
                            $res = $sqlHelper->execute_dml($sql);
                        }
                    }
                }
            }
            else{
                $wj_fb_jindu = $sqlHelper->chaxun_wj_user_neirong('fb_jindu');
                if($wj_fb_jindu >= $fb_id){
                    $fb_jindu = $fb_id;
                }else{
                    $fb_jindu = $wj_fb_jindu;
                }
                $sql = "insert into s_wj_fuben(s_name,fb_jindu,fb_jieduan) values('$_SESSION[id]','$fb_jindu',1)";
                $res = $sqlHelper->execute_dml($sql);

                $fb_jieduan = 1;
            }

            $sql = "select fb_name,fb_info1_num from s_fuben_info2 where fb_jindu=$fb_jindu";
            $res1 = $sqlHelper->execute_dql($sql);
            $fb_info1_num = $res1["fb_info1_num"];

            $sql = "select fb_gw_num from s_fuben_info3 where fb_info2_num=$fb_jindu and fb_jindu=$fb_jieduan";
            $res2 = $sqlHelper->execute_dql2($sql);

            echo '<div style="font-weight: bold;">副本</div>';
            echo '<div>['.$res1["fb_name"].']-'.$fb_jieduan.'</div>';

            $gw_skill_all_state = 0;
            $gw_count = count($res2);
            for($i=0;$i<$gw_count;$i++){
                $gw_num = $res2[$i]["fb_gw_num"];
                $sql = "select gw_name,gw_dj,gw_gj,gw_xq,gw_fy,gw_bj,gw_rx,gw_hp from s_guaiwu_all where num=$gw_num";
                $res3 = $sqlHelper->execute_dql($sql);
                $gw_name = $res3["gw_name"];

                $sql = "select num,gw_sy_hp from s_wj_guaiwu where gw_name='$gw_name' and s_name='$_SESSION[id]'";
                $res4 = $sqlHelper->execute_dql($sql);
                if(!$res4 && $fb_jieduan == 4 || $res4 && $res4["gw_sy_hp"] && $fb_jieduan == 4){
                    echo '<div>禁制破除,你面前出现了本关BOSS</div>';
                }
                echo '<div>';
                if($res4){
                    if($res4["gw_sy_hp"]){
                        $gw_skill_all_state = 1;

                        $jiami1 = "gwid=".$res4["num"].'&gw_lx=1';
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                        echo "<a href='zhandou.php?$url1'>击杀</a> ";
                    }else{
                        echo '击杀 ';
                    }
                }else{
                    $gw_skill_all_state = 1;

                    $sql = "insert into s_wj_guaiwu(s_name,gw_name,gw_dj,gw_gj,gw_xq,gw_fy,gw_bj,gw_rx,gw_sy_hp,gw_hp,gw_lx) values('$_SESSION[id]','$gw_name','$res3[gw_dj]','$res3[gw_gj]','$res3[gw_xq]','$res3[gw_fy]','$res3[gw_bj]','$res3[gw_rx]','$res3[gw_hp]','$res3[gw_hp]',1)";
                    $res1 = $sqlHelper->execute_dml($sql);
                    $sql = "select num from s_wj_guaiwu where s_name='$_SESSION[id]' and gw_name='$gw_name'";
                    $res1 = $sqlHelper->execute_dql($sql);
                    $jiami1 = "gwid=".$res1["num"].'&gw_lx=1';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<a href='zhandou.php?$url1'>击杀</a> ";
                }

                echo $gw_name.' '.$res3["gw_dj"].'级</div>';
                if(!$res4 && $fb_jieduan == 4 || $res4 && $res4["gw_sy_hp"] && $fb_jieduan == 4){
                    echo '<div>金闪闪就是我,我就是金光上人</div>';
                }
            }
            if($gw_skill_all_state == 0){
                if($fb_jieduan == 4){
                    $sql = "delete from s_wj_fuben where s_name='$_SESSION[id]'";
                    $res1 = $sqlHelper->execute_dml($sql);
                    $sql = "delete from s_wj_guaiwu where s_name='$_SESSION[id]'";
                    $res1 = $sqlHelper->execute_dml($sql);
                    $wj_fb_jindu = $sqlHelper->chaxun_wj_user_neirong('fb_jindu');

                    if($wj_fb_jindu == $fb_jindu && ($wj_fb_jindu + 1) == ($fb_jindu + 1)){
                        $sqlHelper->add_wj_user_neirong('fb_jindu',1);
                    }

                    $jiami1 = "x=e&id=".$fb_jindu;
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    $jiami2 = "x=w&id=".$fb_info1_num;
                    $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                    echo "<a href='fuben.php?$url1'>再次挑战</a> | <a href='fuben.php?$url2'>返回</a><br/>";
                }else{
                    $jiami1 = "x=e&qj_state=1";
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<a href='fuben.php?$url1'>继续前进</a><br/>";
                }
            }
            echo '<br/>';
            $sqlHelper->close_connect();

            $jiami1 = "x=q&fq_state=1";
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<a href='fuben.php?$url1'>返回上页</a>";

            require_once '../include/time.php';
        }
    }
}

?>
