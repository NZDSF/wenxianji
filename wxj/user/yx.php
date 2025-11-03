<?php
/**
 * Author: by suxin
 * Date: 2019/12/18
 * Time: 15:20
 * Note: 邮箱
 */

require_once "../include/fzr.php";
require_once "../include/SqlHelper.class.php";
require_once '../include/func.php';

//邮件列表查询，$yx_fenlei=1表示未读，$yx_fenlei=2表示已读
function yx_show_fenye($gotourl,$dh_fl,$yx_fenlei){
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

    getFenyePage_youxiang($fenyePage,$dh_fl,$yx_fenlei);

    if($fenyePage->res_array){
        for($i=0;$i<count($fenyePage->res_array);$i++){
            $row=$fenyePage->res_array[$i];

            $num=$row['num'];
            $yx_leixin=$row['yx_leixin'];

            if($yx_leixin == "pmgm"){
                $paimai_name = '物品购买成功';
            }elseif($yx_leixin == "pmqx"){
                $paimai_name = '物品寄售取消';
            }elseif($yx_leixin == "pmcg"){
                $paimai_name = '物品成功卖出';
            }elseif($yx_leixin == "pmgq"){
                $paimai_name = '物品寄售过期';
            }elseif($yx_leixin == "htfswp"){
                $paimai_name = $row["yx_biaoti"];
            }else{
                $paimai_name = "你收到一封邮件";
            }

            $jiami1 = 'x=w&id='.$num;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo '<div>'.$xuhao.".<a href='yx.php?$url1'>".$paimai_name."</a></div>";
            $xuhao ++;
        }

        //显示上一页和下一页
        if($fenyePage->pageCount > 1){
            echo $fenyePage->navigate;
        }
    }else{
        echo '<div>暂无邮件</div>';
    }
}

if ($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //邮件收取首页面
            echo '<div>【玩家邮箱】</div>';

            $jiami1 = 'x=e';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<div>未读邮件 | <a href='yx.php?$url1'>已读邮件</a></div>";

            yx_show_fenye('yx.php','q',1);
        }
        elseif($dh_fl == 'w'){
            //邮件详情页面
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $yx_id = $suxin1[0];

                $sqlHelper=new SqlHelper();
                $sql =  "select yx_leixin,wp_num,wp_counts,dq_state,lq_state,money,yx_biaoti,yx_message from s_wj_youxiang where s_name='$_SESSION[id]' and num=$yx_id";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res){
                    echo '<div>【邮件详情】</div>';

                    if($res["dq_state"] == 0){
                        $sqlHelper=new SqlHelper();
                        $sql = "update s_wj_youxiang set dq_state=1 where s_name='$_SESSION[id]' and num=$yx_id";
                        $res1 = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();
                    }

                    if($res["yx_leixin"] != 'htfswp'){
                        $sqlHelper=new SqlHelper();
                        $sql = "select wp_name from s_wupin_all where num=$res[wp_num]";
                        $res1 = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();
                        $wp_name = $res1["wp_name"];

                        $wp_lq_state = $res["lq_state"];

                        if($res["yx_leixin"] == "pmgm"){
                            echo "类型: 购买物品成功<br/>";
                            echo "发件人: 拍卖行<br/>";
                            echo "附件: ".$wp_name."x".$res["wp_counts"]."<br/>";
                        }
                        elseif($res["yx_leixin"] == "pmqx"){
                            echo "类型: 寄售物品取消<br/>";
                            echo "发件人: 拍卖行<br/>";
                            echo "附件: ".$wp_name."x".$res["wp_counts"]."<br/>";
                        }
                        elseif($res["yx_leixin"] == "pmcg"){
                            echo "类型: 成功卖出物品<br/>";
                            echo "发件人: 拍卖行<br/>";

                            echo "汇款: 灵石".$res["money"]."<br/>";
                            echo "内容: 你的".$wp_name."以灵石".$res["money"]."的价格被拍下<br/>";

                        }
                        elseif($res["yx_leixin"] == "pmgq"){
                            echo "类型: 寄售物品过期<br/>";
                            echo "发件人: 拍卖行<br/>";
                            echo "附件: ".$wp_name."x".$res["wp_counts"]."<br/>";
                        }
                        else{
//                        $sql = "select num,g_name from s_user where s_name='$res[s_df_sname]'";
//                        $res1 = $sqlHelper->execute_dql($sql);
//                        require_once "../control/yl_zh.php";
//                        $fs_yl = zhuanhuan_yl($res["money"]);
//                        echo "<a href='../xy/wjinfo.php?id=$res1[num]'>".$res1["g_name"]."</a>向你发送了".$fs_yl."！<br/><br/>";
                        }
                    }else{
                        echo '<div>邮件名称: '.$res["yx_biaoti"].'</div>';
                        echo '<div>邮件内容: 奖励已发放至你的背包</div>';
                        echo '<div>奖励内容如下:</div>';
                        echo '<div>'.$res["yx_message"].'</div>';
                    }



                    if (isset($url_info["k"])) {
                        $suxin1 = explode(".", $url_info["k"]);
                        $cz_fl = $suxin1[0];
                        if($cz_fl == 1){
                            //开始领取附件
                            if($res["wp_num"] && $wp_lq_state == 0){
                                $sqlHelper=new SqlHelper();
                                $sql = "update s_wj_youxiang set lq_state=1 where s_name='$_SESSION[id]' and num=$yx_id";
                                $res1 = $sqlHelper->execute_dml($sql);
                                $sqlHelper->close_connect();

                                if($res["money"]){
                                    $sqlHelper=new SqlHelper();
                                    $sqlHelper->add_wj_user_neirong('money',$res["money"]);
                                    $sqlHelper->close_connect();
                                    echo '<br/><div>成功领取了灵石'.$res["money"].'</div><br/>';
                                }else{
                                    give_wupin($res["wp_num"],$res["wp_counts"]);
                                    echo '<br/><div>成功领取了'.$wp_name.'x'.$res["wp_counts"].'</div><br/>';
                                }
                                $wp_lq_state = 1;
                            }
                        }
                    }

                    if($res["wp_num"]){
                        if($wp_lq_state == 0){
                            $jiami1 = 'x=w&id='.$yx_id.'&k=1';
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<div><a href='yx.php?$url1'>领取附件</a></div>";
                        }else{
                            echo '<div style="color:red;">附件已领取</div>';
                        }
                    }

                    $jiami1 = 'x=r&id='.$yx_id;
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo "<div style='margin-top: 10px;'><a href='yx.php?$url1'>删除该邮件</a></div>";

                }else{
                    echo '<div>该邮件不存在</div>';
                }

                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<br/><div><a href='yx.php?$url1'>返回邮箱首页</a></div>";
            }
        }
        elseif($dh_fl == 'e'){
            echo '<div>【玩家邮箱】</div>';

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<div><a href='yx.php?$url1'>未读邮件</a> | 已读邮件</div>";

            yx_show_fenye('yx.php','e',2);
        }
        elseif($dh_fl == 'r'){
            //删除邮件
            echo '<div>【邮件删除】</div>';

            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $yx_id = $suxin1[0];

                $sqlHelper=new SqlHelper();
                $sql = "select wp_num,lq_state from s_wj_youxiang where s_name='$_SESSION[id]' and num=$yx_id";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                if($res){
                    $shanchu_state = 1;
                    if($res["wp_num"]){
                        if($res["lq_state"] == 0){
                            $shanchu_state = 0;
                            echo '<div>该邮件有附件未领取，无法删除</div>';

                            $jiami1 = 'x=w&id='.$yx_id;
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                            echo "<div><a href='yx.php?$url1'>返回上页</a></div>";
                        }
                    }
                    if($shanchu_state == 1){
                        $sqlHelper=new SqlHelper();
                        $sql = "delete from s_wj_youxiang where s_name='$_SESSION[id]' and num=$yx_id";
                        $res = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();
                        echo '<div>已成功删除该邮件</div>';
                    }
                }else{
                    echo '<div>已成功删除该邮件</div>';
                }
            }

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<br/><div><a href='yx.php?$url1'>返回邮箱首页</a></div>";
        }
    }
}

require_once '../include/time.php';
?>