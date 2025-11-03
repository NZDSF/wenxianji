<?php
/**
 * Author: by suxin
 * Date: 2020/1/6
 * Time: 14:01
 * Note: 心情
 */

require_once '../include/fzr.php';

if(isset($_SESSION['id']) && isset($_SESSION['pass'])) {
    if ($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["x"])) {
            $suxin1 = explode(".", $url_info["x"]);
            $dh_fl = $suxin1[0];

            if($dh_fl == 'q'){
                //心情
                echo '<div>【心情】</div>';

                if(isset($_POST["mood"]) && $_POST["mood"] != ''){
                    $mood = trim($_POST["mood"]);
                    require_once '../../safe/feifa.php';
                    $mood_state = feifa_state($mood);
                    if($mood_state == 1){
                        $sqlHelper = new SqlHelper();
                        $sqlHelper->xiugai_wj_user_neirong('mood',$mood);
                        $sqlHelper->close_connect();
                    }
                }

                $jiami1 = "x=q";
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                $sqlHelper = new SqlHelper();
                $wj_mood = $sqlHelper->chaxun_wj_user_neirong('mood');
                $sqlHelper->close_connect();

                echo '<div>当前心情:</div>';
                echo '<div>'.$wj_mood.'</div>';
                echo '<div style="margin-top: 20px;">更改心情:</div>';
                echo "<form action='xq.php?$url1' method='post'>";
                echo "<div><input type='text' name='mood'>";
                echo "<input style='margin-left:5px;' type='submit' name='submit' value='确定'>";
                echo '</div>';
                echo '</form>';
                echo "<div style='margin-top: 10px;'><a href='info.php?$url1'>返回上页</a></div>";
            }
        }
    }
}

require_once '../include/time.php';
?>