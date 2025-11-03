<?php
/**
 * Author: by suxin
 * Date: 2020/1/5
 * Time: 23:25
 * Note: 称号
 */

require_once '../include/fzr.php';

//称号列表查询
function chenghao_show_fenye($gotourl,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=15;

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

    getFenyePage_chenghao($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();
        $wj_chenghao = $sqlHelper->chaxun_wj_user_neirong('chenghao');
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $ch_name = $row['ch_name'];
            echo '<div>'.$xuhao.".";

            $jiami1 = 'x=e&id='.$num;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            echo "<a href='ch.php?$url1'>".$ch_name."</a>";

            $sql = "select num from s_wj_chenghao where s_name='$_SESSION[id]' and ch_name='$ch_name'";
            $res = $sqlHelper->execute_dql($sql);
            if($res){
                echo '(<span style="color:green;">已拥有</span>)';
                if($ch_name == $wj_chenghao){
                    echo " <span style='color: red;'>展示中</span>";
                }else{
                    $jiami1 = 'x='.$dh_fl.'&id='.$res["num"];
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    echo " <a href='ch.php?$url1'>展示</a>";
                }

            }else{
                echo '(未获得)';
            }

            echo '</div>';

            $xuhao += 1;
        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无称号</div>';
    }
}

if(isset($_SESSION['id']) && isset($_SESSION['pass'])) {
    if ($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["x"])) {
            $suxin1 = explode(".", $url_info["x"]);
            $dh_fl = $suxin1[0];

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            if($dh_fl == 'q' || $dh_fl == 'w'){
                //称号首页
                echo '<div>【称号】</div>';

                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $ch_num = $suxin1[0];

                    $sqlHelper = new SqlHelper();
                    $sql = "select ch_name from s_wj_chenghao where s_name='$_SESSION[id]' and num=$ch_num";
                    $res = $sqlHelper->execute_dql($sql);
                    if($res){
                        $sqlHelper->xiugai_wj_user_neirong('chenghao',$res["ch_name"]);
                        echo '<div style="margin-top: 5px;margin-bottom: 5px;">称号更改成功</div>';
                    }
                    $sqlHelper->close_connect();
                }

                if($dh_fl == 'q'){
                    $jiami2 = 'x=w';
                    $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                    echo "<div>普通称号 <a href='ch.php?$url2'>活动称号</a></div>";
                }else{
                    $jiami2 = 'x=w';
                    $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                    echo "<div><a href='ch.php?$url1'>普通称号</a> 活动称号</div>";

                }

                $sqlHelper = new SqlHelper();
                $sql = "select ch_jf,chenghao from s_user where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                echo '<div>当前称号: '.$res["chenghao"].'</div>';
                echo '<div>成就点数: '.$res["ch_jf"].'</div>';
                chenghao_show_fenye('ch.php',$dh_fl);

                echo '<div>总加成:</div>';
                $sqlHelper = new SqlHelper();
                $sql = "select ch_gj,ch_xq,ch_fy,ch_hp,ch_sd,ch_bj,ch_rx from s_user where s_name='$_SESSION[id]'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res["ch_gj"]){
                    echo '<div>攻击 +'.$res["ch_gj"].'</div>';
                }
                if($res["ch_xq"]){
                    echo '<div>仙气 +'.$res["ch_xq"].'</div>';
                }
                if($res["ch_fy"]){
                    echo '<div>防御 +'.$res["ch_fy"].'</div>';
                }
                if($res["ch_hp"]){
                    echo '<div>生命 +'.$res["ch_hp"].'</div>';
                }
                if($res["ch_sd"]){
                    echo '<div>速度 +'.$res["ch_sd"].'</div>';
                }
                if($res["ch_bj"]){
                    echo '<div>暴击 +'.$res["ch_bj"].'</div>';
                }
                if($res["ch_rx"]){
                    echo '<div>韧性 +'.$res["ch_rx"].'</div>';
                }

                echo "<div style='margin-top: 10px;'><a href='info.php?$url1'>返回上页</a></div>";
            }elseif($dh_fl == 'e'){
                //称号说明
                if (isset($url_info["id"])) {
                    $suxin1 = explode(".", $url_info["id"]);
                    $ch_id = $suxin1[0];

                    echo '<div>【称号】</div>';

                    $sqlHelper = new SqlHelper();
                    $sql = "select ch_name,ch_fl,ch_gj,ch_xq,ch_fy,ch_hp,ch_sd,ch_bj,ch_rx,ch_jf,ch_note from s_chenghao_all where num=$ch_id";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();
                    if($res){
                        echo '<div>'.$res["ch_name"].'</div>';
                        echo '<div>成就值:'.$res["ch_jf"].'</div>';
                        if($res["ch_gj"]){
                            echo '<div>攻击 +'.$res["ch_gj"].'</div>';
                        }
                        if($res["ch_xq"]){
                            echo '<div>仙气 +'.$res["ch_xq"].'</div>';
                        }
                        if($res["ch_fy"]){
                            echo '<div>防御 +'.$res["ch_fy"].'</div>';
                        }
                        if($res["ch_hp"]){
                            echo '<div>生命 +'.$res["ch_hp"].'</div>';
                        }
                        if($res["ch_sd"]){
                            echo '<div>速度 +'.$res["ch_sd"].'</div>';
                        }
                        if($res["ch_bj"]){
                            echo '<div>暴击 +'.$res["ch_bj"].'</div>';
                        }
                        if($res["ch_rx"]){
                            echo '<div>韧性 +'.$res["ch_rx"].'</div>';
                        }
                        echo '<div>说明:</div>';
                        echo '<div>'.$res["ch_note"].'</div>';

                        if($res["ch_fl"] == 'pt'){
                            $jiami1 = 'x=q';
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                        }elseif($res["ch_fl"] == 'hd'){
                            $jiami1 = 'x=w';
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                        }
                        echo "<div><a href='ch.php?$url1'>返回上页</a></div>";
                    }
                }
            }
        }
    }
}



require_once '../include/time.php';
?>