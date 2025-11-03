<?php
/**
 * Author: by suxin
 * Date: 2020/1/7
 * Time: 8:46
 * Note: 好友
 */

require_once '../include/fzr.php';

//好友列表查询
function hy_show_fenye($gotourl,$dh_fl){
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
            $xuhao = ($fenyePage->pageNow - 1) * 15 +1;
        }else{
            $xuhao = 1;
        }
    }

    getFenyePage_friends($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $df_num = $row['df_num'];

            $sql = "select g_name,dj from s_user where num=$df_num";
            $res = $sqlHelper->execute_dql($sql);

            echo '<div>'.$xuhao.".";

            $jiami1 = 'id='.$df_num;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            $jiami2 = 'x=e&id='.$df_num;
            $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

            echo "<a href='../xy/wjinfo.php?$url1'>".$res['g_name'].'</a>('.$res['dj']."级)";

            $sql = "select qinmidu from s_wj_friends where s_name='$_SESSION[id]' and df_num=$df_num";
            $res = $sqlHelper->execute_dql($sql);

            echo ' 亲密度:'.$res["qinmidu"];

            echo " <a href='hy.php?$url2'>删除</a></div>";

            $xuhao += 1;
        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无仙友</div>';
    }
}

if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if ($dh_fl == 'q') {
            //玩家添加好友同意界面
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $hysq_num = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $sql = "select s_name from s_wj_siliao where num=$hysq_num and s_name1='$_SESSION[id]' and xx_leixin='hysq'";
                $res = $sqlHelper->execute_dql($sql);
                if ($res) {
                    $df_sname = $res["s_name"];
                    $sql = "select num,g_name from s_user where s_name='$df_sname'";
                    $res = $sqlHelper->execute_dql($sql);
                    if ($res) {
                        echo '<div>【好友申请】</div>';
                        $sql = "select num from s_wj_friends where s_name='$_SESSION[id]' and df_num=$res[num]";
                        $res1 = $sqlHelper->execute_dql($sql);
                        if ($res1) {
                            echo '<div>你们已经是好友了,无需重复添加哦~</div>';
                        } else {
                            $now_time = date("Y-m-d H:i:s");
                            $sql = "insert into s_wj_friends(s_name,df_num,times) values('$_SESSION[id]','$res[num]','$now_time')";
                            $res1 = $sqlHelper->execute_dml($sql);

                            $wj_num = $sqlHelper->chaxun_wj_user_neirong('num');
                            $sql = "insert into s_wj_friends(s_name,df_num,times) values('$df_sname','$wj_num','$now_time')";
                            $res1 = $sqlHelper->execute_dml($sql);

                            echo '<div>你已成功添加' . $res["g_name"] . '为好友</div>';
                        }

                        $jiami1 = 'x=e';
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                        echo "<div style='margin-top: 5px;'><a href='../xy/chat.php?$url1'>返回上页</a></div>";
                        require_once '../include/time.php';
                        exit;
                    }
                }
                $sqlHelper->close_connect();
            }
        }
        elseif ($dh_fl == 'w') {
            //好友列表
            echo '<div>【我的仙友】</div>';

            hy_show_fenye('hy.php',$dh_fl);
        }
        elseif($dh_fl == 'e'){
            //删除好友确认
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $df_num = $suxin1[0];

                echo '<div>【仙友删除】</div>';

                $jiami1 = 'x=w';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                $sqlHelper = new SqlHelper();

                $sql = "select num from s_wj_friends where s_name='$_SESSION[id]' and df_num=$df_num";
                $res1 = $sqlHelper->execute_dql($sql);
                if ($res1) {
                    $sql = "select s_name,g_name,xianlv from s_user where num=$df_num";
                    $res = $sqlHelper->execute_dql($sql);
                    if ($res) {

                        if (isset($url_info["k"])) {
                            $suxin1 = explode(".", $url_info["k"]);
                            $gn_fl = $suxin1[0];
                            if ($gn_fl == 1) {
                                $sql = "select s_name from s_user where num=$df_num";
                                $res1 = $sqlHelper->execute_dql($sql);
                                if($_SESSION["id"] == $res["xianlv"]){
                                    echo '<div>对方和你是仙侣关系，需先解除仙侣才能删除好友哦~</div>';
                                }else{
                                    $wj_num = $sqlHelper->chaxun_wj_user_neirong('num');

                                    $sql = "delete from s_wj_friends where s_name='$_SESSION[id]' and df_num=$df_num";
                                    $res1 = $sqlHelper->execute_dml($sql);
                                    $sql = "delete from s_wj_friends where s_name='$res[s_name]' and df_num=$wj_num";
                                    $res1 = $sqlHelper->execute_dml($sql);

                                    echo '<div>你已成功删除好友' . $res["g_name"] . '</div>';
                                }
                            }
                        } else {
                            echo '<div>你确定要删除' . $res["g_name"] . '好友吗？</div>';
                            $jiami2 = 'x=e&id=' . $df_num . '&k=1';
                            $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

                            echo "<div><a href='hy.php?$url2'>确定删除</a></div>";
                            echo "<div style='margin-bottom: 10px;'><a href='hy.php?$url1'>取消操作</a></div>";
                        }
                    }
                } else {
                    echo '<div>该玩家不是你的好友哦~</div>';
                }

                echo "<div style='margin-top: 5px;'><a href='hy.php?$url1'>返回上页</a></div>";

                $sqlHelper->close_connect();
            }
        }
    }
}

require_once "../include/time.php";
?>