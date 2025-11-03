<?php
/**
 * Author: by suxin
 * Date: 2020/1/5
 * Time: 16:55
 * Note: 斗法
 */

require_once '../include/fzr.php';
require_once '../control/control.php';

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //斗法首页
            echo '<div>【斗法】</div>';

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<div><a href='df.php?$url1'>刷新</a></div>";

            $sqlHelper = new SqlHelper();
            $wj_dj = $sqlHelper->chaxun_wj_user_neirong('dj');
            $max_dj = $wj_dj;
            $min_dj = $wj_dj;

            $df_wj_list = array();
            $count_wj = 0;
            $wj_max_dj = wj_max_dj();

            while($count_wj < 5 ){
                $max_dj += 10;
                $min_dj -= 5;

                if($min_dj <= 0){
                    $min_dj = 1;
                }

                $sql = "select num,g_name,dj from s_user where dj <= $max_dj and dj >= $min_dj and s_name !='$_SESSION[id]'";
                $res = $sqlHelper->execute_dql2($sql);

                $count_wj = count($res);

                if($count_wj > 5){
                    $max_num = 5;
                }else{
                    $max_num = $count_wj;
                }

                if($min_dj == 1 && $max_dj >= $wj_max_dj){
                    //防止找不到数据进入死循环
                    break;
                }
            }

            $sqlHelper->close_connect();

            for($i=0;$i<$max_num;$i++){
                $rand_num = rand(0,($count_wj - 1));

                if($count_wj > 5){
                    while(in_array($rand_num,$df_wj_list)){
                        $rand_num = rand(0,($count_wj - 1));
                    }
                }

                $df_wj_list []= $rand_num;

                $jiami1 = 'id='.$res[$rand_num]["num"];
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                $jiami2 = 'gwid='.$res[$rand_num]["num"].'&gw_lx=2';
                $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                echo "<div><a href='../user/zhandou.php?$url2'>斗法</a> <a href='wjinfo.php?$url1'>".$res[$rand_num]["g_name"]."</a> (".$res[$rand_num]["dj"]."级)</div>";
            }
        }
        elseif($dh_fl == 'w'){
            //斗法互动
            if (isset($url_info["k"]) && isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["k"]);
                $gn_fl = $suxin1[0];
                $suxin1 = explode(".", $url_info["id"]);
                $wj_id = $suxin1[0];

                echo '<div>【斗法互动】</div>';

                $sqlHelper = new SqlHelper();
                $now_time = date("Y-m-d H:i:s");
                $sql = "select num from s_df_wj_cs where s_name='$_SESSION[id]' and df_num=$wj_id and df_stop_time>'$now_time'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res){
                    $songhua_daoju = songhua_daoju();

                    require_once '../include/func.php';
                    $use_state = use_wupin($songhua_daoju,1);
                    if($use_state == 1){
                        $sqlHelper = new SqlHelper();
                        $sql = "select g_name from s_user where num=$wj_id";
                        $res = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();

                        $jiami1 = 'id='.$wj_id;
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        if($gn_fl == 1){
                            echo "<div>你踢了[ <a href='wjinfo.php?$url1'>".$res["g_name"]."</a> ]的屁股,口中念念有词\"败者向前一小步,仙界文明一大步\"</div>";
                        }elseif($gn_fl == 2){
                            echo "<div>你摸了摸[ <a href='wjinfo.php?$url1'>".$res["g_name"]."</a> ]的头,语重心长的说\"小鬼,你妈喊你回家吃饭\"</div>";
                        }elseif($gn_fl == 3){
                            echo "<div>你脚踩[ <a href='wjinfo.php?$url1'>".$res["g_name"]."</a> ],肆无忌惮地笑道\"落后就要挨打,回去再练五百年吧!\"</div>";
                        }elseif($gn_fl == 4){
                            echo "<div>你犀利的看着[ <a href='wjinfo.php?$url1'>".$res["g_name"]."</a> ],看的TA无地自容</div>";
                        }
                        echo '<div>互动成功!'.$songhua_daoju.'花-1</div>';
                    }else{
                        echo '<div>'.$songhua_daoju.'花数量不足，无法互动~</div>';
                    }

                }else{
                    echo '<div>该玩家不是你的斗法玩家，无法互动~</div>';
                }

                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div style='margin-top: 10px;'><a href='../xy/df.php?$url1'>继续斗法</a></div>";

            }
        }
    }
}
$jiami1 = 'x=t';
$url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
$sqlHelper = new SqlHelper();
require_once '../include/time.php';
?>