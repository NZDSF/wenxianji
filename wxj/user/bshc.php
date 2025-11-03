<?php
/**
 * Author: by suxin
 * Date: 2020/1/2
 * Time: 15:56
 * Note: 宝石合成
 */

require_once '../include/fzr.php';
require_once '../include/SqlHelper.class.php';
require_once '../control/control.php';
require_once '../include/func.php';

if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //宝石合成首页
            echo '<div>【宝石合成】</div>';

            $baoshi_max_dj = baoshi_max_dj();

            for($i=2;$i<=$baoshi_max_dj;$i++){
                $jiami1 = 'x=w&bsdj='.$i;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div><a href='bshc.php?$url1'>合成</a> ".$i."级宝石</div>";
            }

            echo '<br/>';
            $jiami1 = 'x=e';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<a href='bag.php?$url1'>返回上页</a>";
        }elseif($dh_fl == 'w'){
            //合成各级宝石页面
            if (isset($url_info["bsdj"])) {
                $suxin1 = explode(".", $url_info["bsdj"]);
                $bsdj = $suxin1[0];

                $baoshi_max_dj = baoshi_max_dj();
                if($baoshi_max_dj >= $bsdj){
                    echo '<div>【合成'.$bsdj.'级宝石】</div>';
                    $baoshi_zhonglei = baoshi_zhonglei();
                    for($i=0;$i<count($baoshi_zhonglei);$i++){
                        $jiami1 = 'x=e&bsdj='.$bsdj.'&bssx='.$i;
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        echo "<div><a href='bshc.php?$url1'>合成</a> ".$bsdj.'级'.$baoshi_zhonglei[$i]."宝石</div>";
                    }
                }
            }

            echo '<br/>';
            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<a href='bshc.php?$url1'>返回上页</a>";
        }
        elseif($dh_fl == 'e'){
            //合成各级宝石详情页面
            if (isset($url_info["bsdj"]) && isset($url_info["bssx"])) {
                $suxin1 = explode(".", $url_info["bsdj"]);
                $bsdj = $suxin1[0];
                $suxin1 = explode(".", $url_info["bssx"]);
                $bssx_id = $suxin1[0];

                $baoshi_max_dj = baoshi_max_dj();
                if($baoshi_max_dj >= $bsdj){
                    echo '<div>【宝石合成】</div>';
                    $baoshi_zhonglei = baoshi_zhonglei();

                    $next_baoshi_name = $bsdj.'级'.$baoshi_zhonglei[$bssx_id].'宝石';

                    echo '<div>合成'.$next_baoshi_name.'</div>';
                    echo '<div>需要:</div>';

                    $baoshi_hcsl = baoshi_hcsl();

                    $baoshi_name = ($bsdj-1).'级'.$baoshi_zhonglei[$bssx_id].'宝石';
                    echo '<div>'.$baoshi_name.'x'.$baoshi_hcsl.'</div>';

                    echo '<div>已有:</div>';

                    $sqlHelper = new SqlHelper();
                    $wp_counts = $sqlHelper->chaxun_wp_counts($baoshi_name);
                    $sqlHelper->close_connect();

                    $hc_tishi = '';
                    if (isset($url_info["k"])) {
                        $suxin1 = explode(".", $url_info["k"]);
                        $gn_fl = $suxin1[0];
                        if($gn_fl == 1){
                            if($wp_counts >= $baoshi_hcsl){
                                $use_state = use_wupin($baoshi_name,$baoshi_hcsl);
                                if($use_state == 1){
                                    $wp_counts -= $baoshi_hcsl;
                                    $sqlHelper = new SqlHelper();
                                    $sql = "select num from s_wupin_all where wp_name='$next_baoshi_name'";
                                    $res = $sqlHelper->execute_dql($sql);
                                    $sqlHelper->close_connect();
                                    if($res){
                                        give_wupin($res["num"],1);
                                        $hc_tishi = '<div style="margin-top: 10px;margin-bottom: 10px;">合成成功，获得了'.$next_baoshi_name.'x1</div>';
                                    }
                                }else{
                                    $hc_tishi = '<div style="margin-top: 10px;margin-bottom: 10px;">宝石数量不足，无法合成</div>';
                                }
                            }else{
                                $hc_tishi = '<div style="margin-top: 10px;margin-bottom: 10px;">宝石数量不足，无法合成</div>';
                            }
                        }
                    }

                    echo '<div>'.$baoshi_name.'x'.$wp_counts.'</div>';

                    echo $hc_tishi;

                    $jiami1 = 'x=e&bsdj='.$bsdj.'&bssx='.$bssx_id.'&k=1';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo "<div><a href='bshc.php?$url1'>合成</a></div>";

                    echo '<br/>';
                    $jiami1 = 'x=w&bsdj='.$bsdj;
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<a href='bshc.php?$url1'>返回上页</a>";
                }
            }
        }
    }
}

require_once '../include/time.php';
?>