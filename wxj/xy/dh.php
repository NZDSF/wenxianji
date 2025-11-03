<?php
/**
 * Author: by suxin
 * Date: 2020/1/14
 * Time: 12:30
 * Note: 兑换功能
 */

require_once '../include/fzr.php';

function dh_show_fenye($gotourl,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=10;

    global $key_url_md_5,$date;

    getFenyePage_dh($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $dh_wp = $row['dh_wp'];

            $jiami1 = 'x=w&id='.$num;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            $sql = "select wp_name from s_wupin_all where num='$dh_wp'";
            $res = $sqlHelper->execute_dql($sql);

            echo "<div><a href='dh.php?$url1'>".$res["wp_name"]."兑换</a>";

            echo "</div>";
        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无兑换列表!</div>';
    }
}



if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //兑换首页
            echo '<div style="margin-bottom: 10px;">【兑换】</div>';
            dh_show_fenye('dh.php',$dh_fl);
        }elseif($dh_fl == 'w'){
            //兑换详情
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_id = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $sql = "select wp_name from s_wupin_all where num=$wp_id";
                $res = $sqlHelper->execute_dql($sql);

                echo '<div style="margin-bottom: 10px;">兑换'.$res["wp_name"].'</div>';

                echo '<div>兑换所需:</div>';

                $sql = "select nd_fl,nd_wp,nd_sl from s_duihuan_all_list where dh_wp=$wp_id";
                $res1 = $sqlHelper->execute_dql2($sql);

                $dh_state = 1;
                for($i=0;$i<count($res1);$i++){
                    $nd_fl = $res1[$i]["nd_fl"];
                    $nd_wp = $res1[$i]["nd_wp"];
                    $nd_sl = $res1[$i]["nd_sl"];

                    if($nd_fl == 'wp'){

                        $sql = "select wp_name from s_wupin_all where num=$nd_wp";
                        $res2 = $sqlHelper->execute_dql($sql);

                        $wp_count = $sqlHelper->chaxun_wp_counts($res2["wp_name"]);

                        if($dh_state == 1 && $wp_count < $nd_sl){
                            $dh_state = 0;
                        }

                        echo '<div>需要: '.$res2["wp_name"].'x'.$nd_sl.'&nbsp;&nbsp;&nbsp;现有: '.$res2["wp_name"].'x'.$wp_count.'</div>';

                    }elseif($nd_fl == 'money'){

                        $wj_money = $sqlHelper->chaxun_wj_user_neirong('money');

                        if($dh_state == 1 && $wj_money < $nd_sl){
                            $dh_state = 0;
                        }

                        echo '<div>需要: 灵石x'.$nd_sl.'&nbsp;&nbsp;&nbsp;现有: 灵石x'.$wp_count.'</div>';

                    }elseif($nd_fl == 'coin'){

                        $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');

                        if($dh_state == 1 && $wj_coin < $nd_sl){
                            $dh_state = 0;
                        }

                        echo '<div>需要: 仙券x'.$nd_sl.'&nbsp;&nbsp;&nbsp;现有: 仙券x'.$wp_count.'</div>';

                    }
                }

                $sqlHelper->close_connect();

                if($dh_state == 1){
                    $jiami1 = 'x=e&id='.$wp_id;
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<div><a href='dh.php?$url1'>确认兑换</a></div>";
                }

                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                echo "<div style='margin-top: 5px;'><a href='dh.php?$url1'>返回上页</a></div>";
            }
        }elseif($dh_fl == 'e'){
            //兑换执行
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_id = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $sql = "select wp_name from s_wupin_all where num=$wp_id";
                $res = $sqlHelper->execute_dql($sql);

                echo '<div style="margin-bottom: 10px;">兑换'.$res["wp_name"].'</div>';

                $sql = "select nd_fl,nd_wp,nd_sl from s_duihuan_all_list where dh_wp=$wp_id";
                $res1 = $sqlHelper->execute_dql2($sql);

                $dh_state = 1;
                for($i=0;$i<count($res1);$i++){
                    $nd_fl = $res1[$i]["nd_fl"];
                    $nd_wp = $res1[$i]["nd_wp"];
                    $nd_sl = $res1[$i]["nd_sl"];

                    if($nd_fl == 'wp'){

                        $sql = "select wp_name from s_wupin_all where num=$nd_wp";
                        $res2 = $sqlHelper->execute_dql($sql);

                        $wp_count = $sqlHelper->chaxun_wp_counts($res2["wp_name"]);

                        if($dh_state == 1 && $wp_count < $nd_sl){
                            $dh_state = 0;
                        }
                    }elseif($nd_fl == 'money'){
                        $wj_money = $sqlHelper->chaxun_wj_user_neirong('money');

                        if($dh_state == 1 && $wj_money < $nd_sl){
                            $dh_state = 0;
                        }
                    }elseif($nd_fl == 'coin'){
                        $wj_coin = $sqlHelper->chaxun_wj_user_neirong('coin');

                        if($dh_state == 1 && $wj_coin < $nd_sl){
                            $dh_state = 0;
                        }
                    }
                }

                $sqlHelper->close_connect();

                if($dh_state == 1){
                    for($i=0;$i<count($res1);$i++){
                        $nd_fl = $res1[$i]["nd_fl"];
                        $nd_wp = $res1[$i]["nd_wp"];
                        $nd_sl = $res1[$i]["nd_sl"];

                        if($nd_fl == 'wp'){
                            $sqlHelper = new SqlHelper();
                            $sql = "select wp_name from s_wupin_all where num=$nd_wp";
                            $res2 = $sqlHelper->execute_dql($sql);
                            $sqlHelper->close_connect();

                            require_once '../include/func.php';

                            use_wupin($res2["wp_name"],$nd_sl);

                        }elseif($nd_fl == 'money'){
                            $sqlHelper = new SqlHelper();
                            $sqlHelper->jianshao_wj_user_neirong('money',$nd_sl);
                            $sqlHelper->close_connect();
                        }elseif($nd_fl == 'coin'){
                            $sqlHelper = new SqlHelper();
                            $sqlHelper->jianshao_wj_user_neirong('coin',$nd_sl);
                            $sqlHelper->close_connect();
                        }
                    }

                    give_wupin($wp_id,1);

                    echo '<div>兑换成功，获得'.$res["wp_name"].'x1</div>';
                }else{
                    echo '<div>兑换材料不足，兑换失败</div>';
                }

                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                echo "<div style='margin-top: 5px;'><a href='dh.php?$url1'>返回上页</a></div>";
            }
        }
    }
}

require_once '../include/time.php';

?>