<?php
/**
 * Author: by suxin
 * Date: 2019/12/22
 * Time: 9:35
 * Note: 帮派
 */

require_once '../include/fzr.php';
require_once '../control/control.php';

//帮派排行列表查询
function bp_show_fenye($gotourl,$dh_fl){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=10;

    global $key_url_md_5,$date;

    if($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];

            $fenyePage->pageNow=$pagenowid;

            $xuhao = ($fenyePage->pageNow - 1) * $fenyePage->pageSize +1;
        }else{
            $xuhao = 1;
        }
    }

    getFenyePage_bp($fenyePage,$dh_fl);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();
        $wj_bp = $sqlHelper->chaxun_wj_user_neirong('bangpai');
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $bp_name = $row['bp_name'];
            $bp_dj = $row['bp_dj'];

            $jiami1 = 'x=r&id='.$num;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            $sql = "select count(num) from s_user where bangpai='$bp_name'";
            $res = $sqlHelper->execute_dql($sql);

            echo "<div>".$xuhao.". <a href='bp.php?$url1'>".$bp_name."</a>(".$bp_dj."级. ".$res["count(num)"]."人)";
            if($wj_bp != $bp_name){
                $jiami2 = 'x=w&id='.$num.'&pagenowid='.$fenyePage->pageNow;
                $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);
                echo " . <a href='bp.php?$url2'>加入</a>";
            }

            echo "</div>";

            $xuhao += 1;
        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>偌大神州，竟无人敢开宗立派!</div>';
    }
}

//帮派入会申请排行列表查询
function bp_sq_show_fenye($gotourl,$dh_fl,$bp_num){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=10;

    global $key_url_md_5,$date;

    if($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];

            $fenyePage->pageNow=$pagenowid;

            $xuhao = ($fenyePage->pageNow - 1) * $fenyePage->pageSize +1;
        }else{
            $xuhao = 1;
        }
    }

    getFenyePage_bp_sq($fenyePage,$dh_fl,$bp_num);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();

        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $s_name = $row['s_name'];

            $sql = "select num,g_name,dj from s_user where s_name='$s_name'";
            $res = $sqlHelper->execute_dql($sql);

            $jiami1 = 'id='.$res["num"];
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            $jiami2 = 'x=t&k=1&id='.$num;
            $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);
            $jiami3 = 'x=t&k=2&id='.$num;
            $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);

            echo "<div>".$xuhao.". <a href='wjinfo.php?$url1'>".$res["g_name"]."</a>(".$res["dj"]."级) . <a href='bp.php?$url2'>同意</a> . <a href='bp.php?$url3'>拒绝</a></div>";

            echo "</div>";

            $xuhao += 1;
        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂时没有申请入帮的玩家</div>';
    }
}

//帮派排行列表查询
function bp_wj_show_fenye($gotourl,$dh_fl,$bp_name,$bp_zw){
    require_once "../include/FenyePage.class.php";
    $fenyePage=new FenyePage();
    $fenyePage->gotoUrl="$gotourl";
    $fenyePage->pageSize=10;

    global $key_url_md_5,$date;

    if($_SERVER["QUERY_STRING"]) {
        $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
        if (isset($url_info["pagenowid"])) {
            $suxin1 = explode(".", $url_info["pagenowid"]);
            $pagenowid = $suxin1[0];

            $fenyePage->pageNow=$pagenowid;

            $xuhao = ($fenyePage->pageNow - 1) * $fenyePage->pageSize +1;
        }else{
            $xuhao = 1;
        }
    }

    getFenyePage_bp_wj($fenyePage,$dh_fl,$bp_name);

    if($fenyePage->res_array){
        $sqlHelper = new SqlHelper();
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num = $row['num'];
            $g_name = $row['g_name'];
            $s_name = $row['s_name'];
            $dj = $row['dj'];
            $bangpai_zw = $row['bangpai_zw'];

            echo "<div>".$xuhao.". ";
            if($s_name == $_SESSION["id"]){
                echo $g_name;
            }else{
                $jiami1 = 'id='.$num;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                echo "<a href='wjinfo.php?$url1'>".$g_name."</a>";
            }

            echo "(".$dj."级) ";

            if($bangpai_zw == 1){
                echo '帮主';
            }elseif($bangpai_zw == 2){
                echo '副帮主';
            }else{
                echo '帮众';
            }

            if($bp_zw < $bangpai_zw){
                $jiami2 = 'x=y&k=1&id='.$num.'&pagenowid='.$fenyePage->pageNow;
                $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);
                echo " . <a href='bp.php?$url2'>踢出</a>";
            }

            echo "</div>";

            $xuhao += 1;
        }
        $sqlHelper->close_connect();

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        if($fenyePage->pageNow != 1){
            $pagenowid = $fenyePage->pageNow - 1;
            $jiami1 = 'x=y&pagenowid='.$pagenowid;
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            header("location: bp.php?$url1");
            exit;
        }else{
            echo '<div>暂无帮派成员</div>';
        }
    }
}

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //帮派首页

            $jiami1 = 'x=w';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            $jiami2 = 'x=e';
            $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

            echo '<div>【帮派】</div>';
            echo "<div>我的帮派 <a href='bp.php?$url1'>其他帮派</a></div>";

            $sqlHelper = new SqlHelper();
            $sql = "select bangpai,bangpai_zw,bangpai_qd,bangpai_gx from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $wj_bp = $res["bangpai"];
            $wj_bp_zw = $res["bangpai_zw"];
            $bangpai_qd = $res["bangpai_qd"];
            $bangpai_gx = $res["bangpai_gx"];

            if($wj_bp){
                $sql = "select num,bp_dj from s_bangpai_all where bp_name='$wj_bp'";
                $res1 = $sqlHelper->execute_dql($sql);
                $bp_num = $res1["num"];

                $bangpai_qd_state = 0;
                $now_time = date("Y-m-d H:i:s");

                if(!$bangpai_qd || $bangpai_qd < $now_time){
                    $bangpai_qd_state = 1;
                }

                if (isset($url_info["k"])) {
                    $suxin1 = explode(".", $url_info["k"]);
                    $gn_fl = $suxin1[0];

                    if($gn_fl == 1){
                        //签到
                        if($bangpai_qd_state == 1){
                            $next_times = date('Y-m-d ', strtotime("+1 day") ). "06:00:00";
                            $sql = "update s_user set bangpai_qd='$next_times',bangpai_gx=bangpai_gx+1 where s_name='$_SESSION[id]'";
                            $res = $sqlHelper->execute_dml($sql);
                            $bangpai_qd_state = 0;
                            echo "<div style='margin-top: 10px;'>签到成功</div>";
                            echo "<div style='margin-bottom: 10px;'>帮派贡献+1</div>";
                        }
                    }

                }

                echo "<div>帮派名称:<a href=''>".$wj_bp."</a>(".$res1["bp_dj"]."级)";

                if($bangpai_qd_state == 1){
                    $jiami5 = 'x=q&k=1';
                    $url5 = encrypt_url("$jiami5.$date", $key_url_md_5);
                    echo " <a href='bp.php?$url5'>签到</a>";
                }

                echo "</div>";


                echo "<div>我的贡献:".$bangpai_gx."</div>";

                $bp_max_wj = bp_max_wj($res1["bp_dj"]);

                $jiami4 = 'x=y';
                $url4 = encrypt_url("$jiami4.$date", $key_url_md_5);

                $sql = "select count(num) from s_user where bangpai='$wj_bp'";
                $res = $sqlHelper->execute_dql($sql);

                echo "<div>成员:".$res["count(num)"]."/".$bp_max_wj." <a href='bp.php?$url4'>列表</a>";
                if($wj_bp_zw == 1 || $wj_bp_zw == 2){
                    $sql = "select count(num) from s_bangpai_sq where bp_num=$bp_num";
                    $res2 = $sqlHelper->execute_dql($sql);

                    $jiami3 = 'x=t';
                    $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);

                    echo " <a href='bp.php?$url3'>入会申请</a>(".$res2["count(num)"].")";
                }

                echo "</div>";

                $jiami6 = 'x=u';
                $url6 = encrypt_url("$jiami6.$date", $key_url_md_5);

                echo "<div><a href='bp.php?$url6'>帮派神兽</a> 1级</div>";
            }else{
                echo "<div>您目前没有加入任何群修会 <a href='bp.php?$url1'>去申请</a></div>";
                echo "<div><a href='bp.php?$url2'>创建帮派</a></div>";
            }

            $sqlHelper->close_connect();
        }
        elseif($dh_fl == 'w'){
            //其他帮派列表

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            echo '<div>【帮派】</div>';
            echo "<div><a href='bp.php?$url1'>我的帮派</a> 其他帮派</div>";
            echo '<div>序号 | 名称 | 等级 | 人数</div>';

            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $bp_id = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $wj_bp = $sqlHelper->chaxun_wj_user_neirong('bangpai');
                if($wj_bp){
                    echo '<div style="margin-top: 10px;margin-bottom: 10px;">您已加入了帮派，无法进行申请</div>';
                }else{
                    $sql = "select bp_name,bp_dj from s_bangpai_all where num=$bp_id";
                    $res = $sqlHelper->execute_dql($sql);
                    if($res){
                        $bp_max_wj = bp_max_wj($res["bp_dj"]);
                        $sql = "select count(num) from s_user where bangpai='$res[bp_name]'";
                        $res =  $sqlHelper->execute_dql($sql);
                        if($res["count(num)"] >= $bp_max_wj){
                            echo '<div style="margin-top: 10px;margin-bottom: 10px;">当前帮派人数已满，无法进行申请</div>';
                        }else{
                            $sql = "select num from s_bangpai_sq where s_name='$_SESSION[id]' and bp_num=$bp_id";
                            $res = $sqlHelper->execute_dql($sql);
                            if($res){
                                echo '<div style="margin-top: 10px;margin-bottom: 10px;">您已提交过入帮申请，请等待帮派管理员审核</div>';
                            }else{
                                $now_time = date("Y-m-d H:i:s");
                                $sql = "insert into s_bangpai_sq(s_name,bp_num,times) values('$_SESSION[id]','$bp_id','$now_time')";
                                $res = $sqlHelper->execute_dml($sql);
                                echo '<div style="margin-top: 10px;margin-bottom: 10px;">您的入帮申请已提交，请等待帮派管理员审核</div>';
                            }
                        }
                    }
                }
                $sqlHelper->close_connect();
            }

            bp_show_fenye('bp.php',$dh_fl);
        }
        elseif($dh_fl == 'e'){
            //创建帮派
            $sqlHelper = new SqlHelper();
            $wj_bp = $sqlHelper->chaxun_wj_user_neirong('bangpai');
            $sqlHelper->close_connect();
            if($wj_bp){
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                header("location: bp.php?$url1");
                exit;
            }else{
                echo '<div>【创建帮派】</div>';
                $bp_create_daoju = bp_create_daoju();
                $sqlHelper = new SqlHelper();
                $wp_counts = $sqlHelper->chaxun_wp_counts($bp_create_daoju);
                $sqlHelper->close_connect();
                if($wp_counts){

                    if (isset($url_info["k"])) {
                        $suxin1 = explode(".", $url_info["k"]);
                        $gn_fl = $suxin1[0];

                        if($gn_fl == 1){
                            //创建帮派执行
                            require_once '../../safe/feifa.php';
                            $bp_name = trim($_POST["bp_name"]);
                            $bp_name_state = feifa_state($bp_name);
                            if($bp_name_state == 1 && $bp_name != ''){
                                $sqlHelper = new SqlHelper();
                                $sql = "select bp_name from s_bangpai_all where bp_name='$bp_name'";
                                $res = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if($res){
                                    echo '<div style="margin-top: 10px;margin-bottom: 10px;">该名称已使用，请重新输入</div>';
                                }else{
                                    require_once '../include/func.php';
                                    $use_state = use_wupin($bp_create_daoju,1);
                                    if($use_state == 1){
                                        $sqlHelper = new SqlHelper();
                                        $now_time = date("Y-m-d H:i:s");
                                        $sql = "insert into s_bangpai_all(bp_name,s_name,times) values('$bp_name','$_SESSION[id]','$now_time')";
                                        $res = $sqlHelper->execute_dml($sql);

                                        $sql = "update s_user set bangpai='$bp_name',bangpai_zw=1 where s_name='$_SESSION[id]'";
                                        $res = $sqlHelper->execute_dml($sql);

                                        $sqlHelper->close_connect();

                                        insert_xitong_gonggao($_SESSION["id"],$bp_name,'cjbp','');

                                        $jiami1 = 'x=q';
                                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                                        header("location: bp.php?$url1");
                                        exit;
                                    }
                                }
                            }
                        }
                    }

                    echo '<div>请输入帮派名称:</div>';

                    $jiami1 = 'x=e&k=1';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo "<form action='bp.php?$url1' method='post'>";
                    echo "帮派名称: <input style='width:170px;' type='text' name='bp_name' id='search'>
                    <input  type=\"submit\" name=\"submit\"  value=\"创建\" id=\"search1\"><br>";
                    echo '</form>';

                }else{
                    $sqlHelper = new SqlHelper();
                    $sql = "select num from s_wupin_all where wp_name='$bp_create_daoju'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    $jiami1 = 'y=q&id='.$res["num"].'&f=q';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                    echo '<div>物品不足，创建失败</div>';
                    echo "<div>创建帮派需要<a href='shop.php?$url1'>".$bp_create_daoju."</a></div>";
                }
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                echo "<div><a href='bp.php?$url1'>返回上页</a></div>";
            }
        }
        elseif($dh_fl == 'r'){
            //其他帮派信息页
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $bp_id = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $sql = "select bp_name,s_name,bp_dj,bp_ss_dj from s_bangpai_all where num=$bp_id";
                $res = $sqlHelper->execute_dql($sql);

                if($res){
                    $sql = "select count(num) from s_user where bangpai='$res[bp_name]'";
                    $res1 = $sqlHelper->execute_dql($sql);

                    echo '<div>【帮派信息】</div>';
                    echo '<div>群修会名:'.$res["bp_name"].'</div>';
                    echo '<div>等级:'.$res["bp_dj"].'</div>';
                    echo '<div>神兽等级:'.$res["bp_ss_dj"].'级</div>';

                    $sql = "select num,g_name from s_user where s_name='$res[s_name]'";
                    $res2 = $sqlHelper->execute_dql($sql);

                    if($res["s_name"] == $_SESSION["id"]){
                        $jiami1 = 'x=q';
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div>会长: <a href='../user/info.php?$url1'>".$res2["g_name"]."</a></div>";
                    }else{
                        $jiami1 = 'id='.$res2["num"];
                        $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                        echo "<div>会长: <a href='wjinfo.php?$url1'>".$res2["g_name"]."</a></div>";
                    }


                    $bp_max_wj = bp_max_wj($res["bp_dj"]);

                    echo '<div>成员:'.$res1["count(num)"].'/'.$bp_max_wj.'</div>';
                }

                $sqlHelper->close_connect();

            }

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<br/><div><a href='bp.php?$url1'>返回帮派</a></div>";
        }
        elseif($dh_fl == 't'){
            //入会申请列表
            $sqlHelper = new SqlHelper();
            $sql = "select bangpai,bangpai_zw from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $wj_bangpai = $res["bangpai"];
            $wj_bangpai_zw = $res["bangpai_zw"];

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            if($wj_bangpai){
                if($wj_bangpai_zw == 1 || $wj_bangpai_zw == 2){
                    echo '<div>【入帮申请】</div>';
                    $sqlHelper = new SqlHelper();
                    $sql = "select num from s_bangpai_all where bp_name='$wj_bangpai'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    $bp_num = $res["num"];

                    echo '<div>序号 | 名称 | 等级 | 操作</div>';

                    if (isset($url_info["k"]) && isset($url_info["id"])) {
                        $suxin1 = explode(".", $url_info["k"]);
                        $gn_fl = $suxin1[0];
                        $suxin1 = explode(".", $url_info["id"]);
                        $sq_id = $suxin1[0];

                        $sqlHelper = new SqlHelper();
                        $sql = "select s_name,num from s_bangpai_sq where bp_num='$bp_num'";
                        $res = $sqlHelper->execute_dql($sql);
                        if($res){
                            if($gn_fl == 1){
                                $sql = "select bangpai from s_user where s_name='$res[s_name]'";
                                $res1 = $sqlHelper->execute_dql($sql);
                                if($res1["bangpai"] == ''){
                                    $sql = "update s_user set bangpai='$wj_bangpai',bangpai_zw=10 where s_name='$res[s_name]'";
                                    $res1 = $sqlHelper->execute_dml($sql);
                                    $sql = "delete from s_bangpai_sq where num=$res[num]";
                                    $res1 = $sqlHelper->execute_dml($sql);
                                    echo '<div style="margin-top: 10px;margin-bottom: 10px;">该玩家已加入了本帮会</div>';
                                }else{
                                    echo '<div style="margin-top: 10px;margin-bottom: 10px;">该玩家已加入了其他帮派</div>';
                                }
                            }elseif($gn_fl == 2){
                                $sql = "delete from s_bangpai_sq where num=$res[num]";
                                $res1 = $sqlHelper->execute_dml($sql);
                                echo '<div style="margin-top: 10px;margin-bottom: 10px;">您拒绝了该玩家的入帮申请</div>';
                            }
                        }
                        $sqlHelper->close_connect();
                    }


                    bp_sq_show_fenye('bp.php',$dh_fl,$bp_num);

                    echo "<br/><div><a href='bp.php?$url1'>返回帮派</a></div>";
                }else{
                    header("location: bp.php?$url1");
                    exit;
                }
            }else{
                header("location: bp.php?$url1");
                exit;
            }
        }
        elseif($dh_fl == 'y'){
            //帮派列表

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            $sqlHelper = new SqlHelper();
            $sql = "select bangpai,bangpai_zw from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $wj_bangpai = $res["bangpai"];
            $wj_bangpai_zw = $res["bangpai_zw"];

            if($wj_bangpai){
                echo '<div>【帮派成员列表】</div>';
                echo '<div>序号 | 名称 | 等级 | 职位 | 操作</div>';

                if (isset($url_info["k"]) && isset($url_info["id"])) {
                    if($wj_bangpai_zw == 1 || $wj_bangpai_zw == 2){
                        $suxin1 = explode(".", $url_info["k"]);
                        $gn_fl = $suxin1[0];
                        $suxin1 = explode(".", $url_info["id"]);
                        $wj_id = $suxin1[0];

                        if($gn_fl == 1){
                            //踢出玩家确认页
                            $sqlHelper = new SqlHelper();
                            $sql = "select bangpai_zw,g_name from s_user where num='$wj_id' and bangpai='$wj_bangpai'";
                            $res = $sqlHelper->execute_dql($sql);
                            if($res){
                                if($wj_bangpai_zw < $res["bangpai_zw"]){
                                    if (isset($url_info["pagenowid"])) {
                                        $suxin1 = explode(".", $url_info["pagenowid"]);
                                        $pagenowid = $suxin1[0];
                                    }else{
                                        $pagenowid = 1;
                                    }

                                    $jiami2 = 'x=y&id='.$wj_id.'&k=2&pagenowid='.$pagenowid;
                                    $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);
                                    $jiami3 = 'x=y&pagenowid='.$pagenowid;
                                    $url3 = encrypt_url("$jiami3.$date", $key_url_md_5);

                                    echo "<div style='margin-top: 10px;margin-bottom: 10px;'>您确认要将 ".$res["g_name"]." 踢出帮会吗？. <a href='bp.php?$url2'>确认</a> . <a href='bp.php?$url3'>取消</a></div>";
                                }
                            }
                            $sqlHelper->close_connect();
                        }elseif($gn_fl == 2){
                            //踢出玩家执行
                            $sqlHelper = new SqlHelper();
                            $sql = "select bangpai_zw,g_name from s_user where num='$wj_id' and bangpai='$wj_bangpai'";
                            $res = $sqlHelper->execute_dql($sql);
                            if($res){
                                if($wj_bangpai_zw < $res["bangpai_zw"]){

                                    $sql = "update s_user set bangpai=null,bangpai_zw=null where num=$wj_id";
                                    $res = $sqlHelper->execute_dml($sql);

                                    echo "<div style='margin-top: 10px;margin-bottom: 10px;'>您已成功踢出了该玩家</div>";
                                }
                            }
                            $sqlHelper->close_connect();
                        }
                    }
                }

                bp_wj_show_fenye('bp.php',$dh_fl,$wj_bangpai,$wj_bangpai_zw);

                echo "<div><a href='bp.php?$url1'>返回帮派</a></div>";
            }else{
                header("location: bp.php?$url1");
                exit;
            }
        }
        elseif($dh_fl == 'u'){
            //帮派神兽
            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

            $sqlHelper = new SqlHelper();
            $sql = "select bangpai,bangpai_zw from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            $wj_bangpai = $res["bangpai"];
            $wj_bangpai_zw = $res["bangpai_zw"];

            if($wj_bangpai){
                $sqlHelper = new SqlHelper();
                $sql = "select bp_ss_dj from s_bangpai_all where bp_name='$wj_bangpai'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                echo '<div>【帮派神兽】</div>';
                echo '<div>当前等级:'.$res["bp_ss_dj"].'</div>';
                echo '<div>神兽属性</div>';
                echo '<div>增加所有成员攻击力'.$res["bp_ss_dj"].'%</div>';
                echo "<div><a href='bp.php?$url1'>返回帮派</a></div>";
            }else{
                header("location: bp.php?$url1");
                exit;
            }
        }
    }
}

require_once '../include/time.php';
?>