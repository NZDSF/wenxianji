<?php
/**
 * Author: by suxin
 * Date: 2019/12/7
 * Time: 10:30
 * Note: 聊天系统
 */

require_once '../include/fzr.php';
require_once '../include/SqlHelper.class.php';
require_once '../include/func.php';


//聊天分类导航
function chat_fenlei_daohang($dh_fl){
    $daohang_array = array(
        array('q','世界'),
        array('w','系统'),
        array('e','私聊'),
        array('r','动态'),
    );

    global $date,$key_url_md_5;

    $count_daohang = count($daohang_array);
    for($i=0;$i<$count_daohang;$i++){
        if($dh_fl == $daohang_array[$i][0]){
            echo $daohang_array[$i][1];
        }else{
            $jiami1 = "x=".$daohang_array[$i][0];
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo "<a href='chat.php?$url1'>".$daohang_array[$i][1].'</a>';
        }

        if((($i+1) % 3) == 0){
            echo '<br/>';
        }else{
            if(($i+1) < $count_daohang){
                echo ' ';
            }
        }
    }
    echo '<br/>';
}

if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        echo '<div>【交流中心】</div>';

        chat_fenlei_daohang($dh_fl);

        if($dh_fl == 'q'){
            //世界聊天
            if (isset($_POST['talk']) && $_POST["talk"] != '') {
                require_once '../../safe/feifa.php';

                $talk = $_POST["talk"];
                $talk_state = feifa_state($talk);

                if($talk_state == 1){
                    $insert_state = 1;

                    $sqlHelper=new SqlHelper();
                    $sql="select message,s_name from s_wj_talk order by num desc limit 1";
                    $res=$sqlHelper->execute_dql($sql);

                    if($res){
                        if($res["message"] == $talk && $res["s_name"] == $_SESSION["id"]){
                            echo '<div><span style="color:red;">请勿输入重复内容</span></div>';
                            $insert_state = 0;
                        }
                    }

                    if($insert_state == 1){
                        $now_time = date("Y-m-d H:i:s");
                        $sql = "insert into s_wj_talk(s_name,message,times) values('$_SESSION[id]','$talk','$now_time')";
                        $res = $sqlHelper->execute_dml($sql);
                    }

                    $sqlHelper->close_connect();
                }
                else{
                    echo '<div><span style="color:red;">请勿输入非法参数</span></div>';
                }
            }

            echo "<div style='margin-top: 10px;'><a href=''> 刷新</a></div>";
            echo "<div>请输入你要说的话:</div>";

            echo "<form  action='' method='POST'>
                <input type='text' name='talk' placeholder='请输入你要说的话' id='search'>
                <input  type='submit' name='submit'  value='发送'><br>
                </form>";

            chat_show_fenye('chat.php',10,1,$dh_fl);
        }
        elseif($dh_fl == 'w'){
            //系统公告
            xtgg_show_fenye('chat.php',10,1,$dh_fl);
        }elseif($dh_fl == 'e'){
            //玩家私聊信息
            $sqlHelper = new SqlHelper();
            $sql = "update s_wj_siliao set yd_state=1 where s_name1='$_SESSION[id]'";
            $res = $sqlHelper->execute_dml($sql);
            $sqlHelper->close_connect();
            siliao_show_fenye('chat.php',10,1,$dh_fl);
        }elseif($dh_fl == 'r'){
            //个人动态
            wjdt_show_fenye('chat.php',10,1,$dh_fl);
        }
    }
}

require_once "../include/time.php";
?>