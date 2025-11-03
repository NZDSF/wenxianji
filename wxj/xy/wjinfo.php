<?php
/**
 * Author: by suxin
 * Date: 2019/12/19
 * Time: 10:08
 * Note: 其它玩家信息
 */

require_once "../include/fzr.php";
require_once "../control/control.php";

//获取玩家基本信息
function info($wj_num){
    $sqlHelper=new SqlHelper();
    $sql="select num,dj,g_name,s_name,sex,cz_jf,mood,df_sl,df_sb,bangpai,pk_pm,jingjie,zhizun_vip,yueka_stop_time,chenghao,meili,xianlv from s_user where num='$wj_num'";
    $res=$sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();
    if($res){
        return $res;
    }else{
        echo '<div>该玩家不存在！</div>';
        require_once '../include/time.php';
        exit;
    }
}

if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["id"])) {
        $suxin1 = explode(".", $url_info["id"]);
        $wj_num = $suxin1[0];

        $info = info($wj_num);

        if (isset($url_info["k"])) {
            $suxin1 = explode(".", $url_info["k"]);
            $gn_fl = $suxin1[0];

            if($gn_fl == 1){
                //私聊
                echo '<div>【玩家信息】</div>';

                echo '<div>【私聊】</div>';

                if(isset($_POST["talk"])){
                    $talk = trim($_POST["talk"]);

                    require_once '../../safe/feifa.php';
                    $talk_state = feifa_state($talk);

                    if($talk_state == 1){
                        $sqlHelper = new SqlHelper();
                        $sql = "select message from s_wj_siliao where s_name='$_SESSION[id]' and s_name1='$info[s_name]' order by num desc limit 1";
                        $res = $sqlHelper->execute_dql($sql);
                        $sqlHelper->close_connect();

                        if($res["message"] == $talk){
                            echo '<div style="margin-top: 10px;color:red;">请勿输入相同内容！</div>';
                        }else{
                            $sqlHelper = new SqlHelper();
                            $now_time = date("Y-m-d H:i:s");
                            $sql = "insert into s_wj_siliao(s_name,xx_leixin,s_name1,message,times) values('$_SESSION[id]','siliao','$info[s_name]','$talk','$now_time')";
                            $res = $sqlHelper->execute_dml($sql);
                            $sqlHelper->close_connect();

                            $jiami1 = 'x=e';
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                            header("location: chat.php?$url1");
                            exit;
                        }
                    }else{
                        echo '<div style="margin-top: 10px;color:red;">请勿输入非法参数！</div>';
                    }
                }

                echo '<div style="margin-top: 10px;">请输入你要说的话:</div>';

                echo "<form  action='' method='POST'>
                    <input type='text' name='talk' placeholder='请输入你要说的话' id='search'  >
                    <input  type='submit' name='submit'  value='发送'><br>
                    </form>";

                $jiami1 = 'id='.$wj_num;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div><a href='wjinfo.php?$url1'>返回上页</a></div>";

                require_once '../include/time.php';
                exit;
            }
            elseif($gn_fl == 2){
                //加好友
                echo '<div>【玩家信息】</div>';

                echo '<div>【好友申请】</div>';

                $sqlHelper = new SqlHelper();
                $sql = "select num from s_wj_friends where s_name='$_SESSION[id]' and df_num=$wj_num";
                $res = $sqlHelper->execute_dql($sql);
                if($res){
                    echo '<div>你们已经是好友了,无需重复添加哦~</div>';
                }else{
                    $sql = "select message from s_wj_siliao where s_name='$_SESSION[id]' and s_name1='$info[s_name]' order by num desc limit 1";
                    $res = $sqlHelper->execute_dql($sql);

                    $talk = '想加你为好友,通过一下哦~';

                    if($res && $res["message"] == $talk){
                        echo '<div style="margin-top: 10px;color:red;">好友申请已发送,请勿重复申请！</div>';
                    }else{
                        $now_time = date("Y-m-d H:i:s");
                        $sql = "insert into s_wj_siliao(s_name,xx_leixin,s_name1,message,times) values('$_SESSION[id]','hysq','$info[s_name]','$talk','$now_time')";
                        $res = $sqlHelper->execute_dml($sql);
                        echo '<div>好友申请已发送,请等待对方通过哦~</div>';
                    }

                }
                $sqlHelper->close_connect();



                $jiami1 = 'id='.$wj_num;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div style='margin-top: 5px;'><a href='wjinfo.php?$url1'>返回上页</a></div>";

                require_once '../include/time.php';
                exit;
            }
            elseif($gn_fl == 3){
                //送花
                echo '<div>【送花】</div>';

                $meili = $info["meili"];

                $songhua_daoju = songhua_daoju();
                $songhua_gongxun = songhua_gongxun();

                $sqlHelper = new SqlHelper();
                $wp_count = $sqlHelper->chaxun_wp_counts($songhua_daoju);
                $sqlHelper->close_connect();

                if(isset($_POST["wp_sl"]) && $_POST["wp_sl"] != 0){
                    if($wp_count > 0){
                        $wp_sl = trim($_POST["wp_sl"]);
                        require_once '../../safe/feifa.php';
                        $wp_sl_state = feifa_shuzi($wp_sl);
                        if($wp_sl_state == 1){
                            if($wp_count < $wp_sl){
                                $wp_sl = $wp_count;
                            }

                            require_once '../include/func.php';
                            $use_state = use_wupin($songhua_daoju,$wp_sl);
                            if($use_state == 1){
                                $meili += $wp_sl;
                                $wp_count -= $wp_sl;

                                $sqlHelper = new SqlHelper();
                                $sql = "update s_user set meili=meili+$wp_sl where num=$wj_num";
                                $res = $sqlHelper->execute_dml($sql);
                                $sqlHelper->add_wj_user_neirong('gongxun',($songhua_gongxun * $wp_sl));
                                $sqlHelper->close_connect();
                                echo '<div>'.$info["g_name"].'已经收到你的'.$songhua_daoju.'，魅力+'.$wp_sl.'</div>';
                                echo '<div>你获得'.($songhua_gongxun * $wp_sl).'功勋奖励</div>';

                                //写入个人动态
                                $sqlHelper = new SqlHelper();
                                $sql = "select s_name from s_user where num=$wj_num";
                                $res = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();

                                require_once '../include/func.php';
                                $message = '向你赠送了'.$wp_sl.'朵'.$songhua_daoju;
                                insert_wj_dongtai($res["s_name"],$_SESSION["id"],'songhua',$message);

                                //检测送花丶收花周榜的时间
                                jiance_hua_week();

                                //开始写入送花 收花 总榜，周榜
                                $sqlHelper = new SqlHelper();
                                $sql = "update s_user set shouhb=shouhb+$wp_sl,shouhb_week=shouhb_week+$wp_sl where num=$wj_num";
                                $res = $sqlHelper->execute_dml($sql);
                                $sqlHelper->add_wj_user_neirong('songhb',$wp_sl);
                                $sqlHelper->add_wj_user_neirong('songhb_week',$wp_sl);
                                $sqlHelper->close_connect();

                                //开始计算亲密度
                                $sqlHelper = new SqlHelper();
                                $sql = "select num from s_wj_friends where s_name='$_SESSION[id]' and df_num='$wj_num'";
                                $res = $sqlHelper->execute_dql($sql);

                                if($res){
                                    $wj_zj_num = $sqlHelper->chaxun_wj_user_neirong('num');
                                    $sql = "update s_wj_friends set qinmidu=qinmidu+$wp_sl where s_name='$_SESSION[id]' and df_num='$wj_num' or s_name='$info[s_name]' and df_num='$wj_zj_num'";
                                    $res = $sqlHelper->execute_dml($sql);
                                    echo '<div>双方亲密度+'.$wp_sl.'</div>';
                                }
                                $sqlHelper->close_connect();

                                //开始计算恩爱值
                                $sqlHelper = new SqlHelper();
                                $wj_xianlv = $sqlHelper->chaxun_wj_user_neirong('xianlv');
                                if($wj_xianlv == $info["s_name"]){
                                    $sqlHelper->add_wj_user_neirong('eaz',$wp_sl);
                                    $sql = "update s_user set eaz=eaz+$wp_sl where s_name='$info[s_name]'";
                                    $res = $sqlHelper->execute_dml($sql);
                                    echo '<div>双方恩爱值+'.$wp_sl.'</div>';
                                }

                                $sqlHelper->close_connect();

                                echo '<br/>';
                            }
                        }
                    }
                }

                echo '<div>你当前拥有的'.$songhua_daoju.'数:'.$wp_count.'朵</div>';
                echo '<div style="margin-top: 10px;">['.$info["g_name"].']当前已收到的玫瑰花:'.$meili.'朵</div>';

                echo '<div>(每赠送给他人1朵'.$songhua_daoju.'花可以获得'.$songhua_gongxun.'功勋)</div>';
                echo '<div>请输入您要送出的玫瑰数量:</div>';

                $jiami1 = 'id='.$wj_num.'&k=3';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<form action='wjinfo.php?$url1' method='post'>";
                echo "<input type='text' name='wp_sl' value='1'>";
                echo '<input style="margin-left: 5px;" type="submit" name="submit" value="确定送出">';
                echo '</form>';

                $jiami1 = 'id='.$wj_num;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div><a href='wjinfo.php?$url1'>返回上页</a></div>";

                require_once '../include/time.php';
                exit;
            }
            elseif($gn_fl == 4){
                //求婚
                echo '<div>【求婚】</div>';

                $meili = $info["meili"];

                $sqlHelper = new SqlHelper();
                $wj_sex = $sqlHelper->chaxun_wj_user_neirong('sex');
                $sqlHelper->close_connect();

                if($wj_sex == $info["sex"]){
                    echo '<div>异性之间才能结婚哦~</div>';
                }else{
                    $jiehun_dj = jiehun_dj();

                    $sqlHelper = new SqlHelper();
                    $wj_dj = $sqlHelper->chaxun_wj_user_neirong('dj');
                    $sqlHelper->close_connect();

                    if($wj_dj >= $jiehun_dj && $info["dj"] >= $jiehun_dj){
                        $sqlHelper = new SqlHelper();
                        $wj_xianlv = $sqlHelper->chaxun_wj_user_neirong('xianlv');
                        $sqlHelper->close_connect();

                        if($wj_xianlv){
                            if($wj_xianlv == $info["s_name"]){
                                echo '<div>该玩家已经是你的仙侣了哦~</div>';
                            }else{
                                echo '<div>你已经有仙侣了，无法再次求婚~</div>';
                            }
                        }else{
                            if($info["xianlv"]){
                                echo '<div>该玩家已经有仙侣了，无法求婚哦~</div>';
                            }else{
                                $sqlHelper = new SqlHelper();
                                $sql = "select qinmidu from s_wj_friends where s_name='$_SESSION[id]' and df_num='$wj_num'";
                                $res = $sqlHelper->execute_dql($sql);
                                $sqlHelper->close_connect();
                                if($res){
                                    $jiehun_qinmidu = jiehun_qinmidu();
                                    if($res["qinmidu"] >= $jiehun_qinmidu){
                                        $sqlHelper = new SqlHelper();
                                        $sql = "select num,wp_name from s_wj_bag where s_name='$_SESSION[id]' and wp_fenlei='hl'";
                                        $res = $sqlHelper->execute_dql2($sql);
                                        $sqlHelper->close_connect();

                                        if(count($res)){
                                            if (isset($url_info["j"])) {
                                                $suxin1 = explode(".", $url_info["j"]);
                                                $jiezhi_num = $suxin1[0];

                                                $sqlHelper = new SqlHelper();
                                                $sql = "select s_name1 from s_wj_qiuhun where s_name='$_SESSION[id]' and state=0";
                                                $res = $sqlHelper->execute_dql($sql);
                                                $sqlHelper->close_connect();
                                                if($res){
                                                    if($res["s_name1"] == $info["s_name"]){
                                                        echo '<div>你已经向'.$info["g_name"].'发起了求婚，无需重复求婚~</div>';
                                                    }else{
                                                        echo '<div>你已经向其他玩家发起了求婚，不能继续求婚哦~</div>';
                                                    }
                                                }else{
                                                    $sqlHelper = new SqlHelper();
                                                    $sql = "select wp_name from s_wj_bag where s_name='$_SESSION[id]' and wp_fenlei='hl' and num=$jiezhi_num";
                                                    $res = $sqlHelper->execute_dql($sql);
                                                    $sqlHelper->close_connect();

                                                    if($res){
                                                        require_once '../include/func.php';
                                                        use_wupin($res["wp_name"],1);
                                                        $sqlHelper = new SqlHelper();
                                                        $now_time = date("Y-m-d H:i:s");
                                                        $sql = "insert into s_wj_qiuhun(s_name,s_name1,times,jiezhi) values('$_SESSION[id]','$info[s_name]','$now_time','$res[wp_name]')";
                                                        $res = $sqlHelper->execute_dml($sql);
                                                        $sqlHelper->close_connect();
                                                        echo '<div>你向'.$info["g_name"].'发起了求婚，请等待对方同意~</div>';
                                                    }else{
                                                        echo '<div>你当前没有求婚戒指，无法发起求婚~</div>';
                                                    }
                                                }

                                            }else{
                                                echo '<div>求婚对象:'.$info["g_name"].'</div>';
                                                echo '<div>请选择你的求婚信物:</div>';

                                                for($i=0;$i<count($res);$i++){
                                                    $jiami1 = 'id='.$wj_num.'&k=4&j='.$res[$i]["num"];
                                                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                                                    echo "<div><a href='wjinfo.php?$url1'>".$res[$i]["wp_name"]."</a></div>";
                                                }

                                                echo '<br/>';
                                            }
                                        }else{
                                            echo '<div>你当前没有求婚戒指，无法发起求婚~</div>';
                                        }

                                    }else{
                                        echo '<div>双方亲密度不足，无法发起求婚~</div>';
                                    }
                                }
                                else{
                                    echo '<div>对方不是你的好友，不能求婚哦~</div>';
                                }
                            }
                        }
                    }
                    else{
                        echo '<div>双方等级不满足结婚条件，不能求婚哦~</div>';
                    }
                }

                $jiami1 = 'id='.$wj_num;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div><a href='wjinfo.php?$url1'>返回上页</a></div>";

                require_once '../include/time.php';
                exit;
            }
        }

        echo '<div>【玩家信息】</div>';

        echo '<div>昵称:'.$info["g_name"];
        if($info["zhizun_vip"] == 1){
            echo "<img class='tx_img' src='../images/zz.gif'>";
            echo "<img class='tx_img' src='../images/yk.gif'>";
        }else{
            $now_time = date("Y-m-d H:i:s");
            if($info["yueka_stop_time"] > $now_time){
                echo "<img class='tx_img' src='../images/yk.gif'>";
            }
        }
        if($info["cz_jf"]){
            echo "<img class='tx_img' src='../images/vip.gif'>";
        }
        if($info["xianlv"]){
            echo "<img class='tx_img' src='../images/xl.gif'>";
        }

        echo '('.$info["sex"].'.'.$info["dj"].'级.'.$info["jingjie"].')</div>';

        $vip = vip_dj($info["cz_jf"]);
        echo '<div>VIP:'.$vip.'</div>';

        echo '<div>ID:'.$info['num'].'</div>';

        if (isset($url_info["x"])) {
            $suxin1 = explode(".", $url_info["x"]);
            $dh_fl = $suxin1[0];

            if($dh_fl == 'q'){
                //装备
                $jiami1 = 'id='.$wj_num;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                $jiami3 = 'x=e&id='.$wj_num;
                $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);
                $jiami4 = 'x=r&id='.$wj_num;
                $url4 = encrypt_url("$jiami4.$date",$key_url_md_5);

                echo "<div><a href='wjinfo.php?$url1'>状态</a> | 装备 | <a href='wjinfo.php?$url3'>仙术</a> | <a href='wjinfo.php?$url4'>天赋</a></div>";

                require_once '../include/func.php';

                $wuqi = chaxun_zhuangbei('wuqi',$info["s_name"]);           //武器
                $yifu = chaxun_zhuangbei('yifu',$info["s_name"]);           //衣服
                $yaodai = chaxun_zhuangbei('yaodai',$info["s_name"]);       //腰带
                $xuezi = chaxun_zhuangbei('xuezi',$info["s_name"]);         //靴子
                $maozi = chaxun_zhuangbei('maozi',$info["s_name"]);         //帽子
                $jiezhi = chaxun_zhuangbei('jiezhi',$info["s_name"]);       //戒指


                if ($maozi) {
                    $jiami1 = "x=y&id=" . $maozi["num"];
                    $jiami2 = "x=q&id=" . $maozi["num"];
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

//                    echo "<div>帽子: <a href='info.php?$url1'>" . $maozi['zb_pinzhi'].$maozi['zb_name'].'</a> '.$maozi['zb_dj'] . "级</div>";
                    echo "<div>帽子: " . $maozi['zb_pinzhi'].$maozi['zb_name'].' '.$maozi['zb_dj'] . "级</div>";
                } else {
                    $jiami1 = "id=5";
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

//                    echo "<div>帽子: <a href='cdzb.php?$url1'>无</a></div>";
                    echo "<div>帽子: 无</div>";
                }

                if ($jiezhi) {
                    $jiami1 = "x=y&id=" . $jiezhi["num"];
                    $jiami2 = "x=q&id=" . $jiezhi["num"];
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

//                    echo "<div>戒指: <a href='info.php?$url1'>" . $jiezhi['zb_pinzhi'].$jiezhi['zb_name'].'</a> '.$jiezhi['zb_dj'] . "级</div>";
                    echo "<div>戒指: " . $jiezhi['zb_pinzhi'].$jiezhi['zb_name'].' '.$jiezhi['zb_dj'] . "级</div>";
                } else {
                    $jiami1 = "id=6";
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

//                    echo "<div>戒指: <a href='cdzb.php?$url1'>无</a></div>";
                    echo "<div>戒指: 无</div>";
                }

                if ($wuqi) {
                    $jiami1 = "x=y&id=" . $wuqi["num"];
                    $jiami2 = "x=q&id=" . $wuqi["num"];
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

//                    echo "<div>武器: <a href='info.php?$url1'>" . $wuqi['zb_pinzhi'].$wuqi['zb_name'].'</a> '.$wuqi['zb_dj'] . "级</div>";
                    echo "<div>武器: " . $wuqi['zb_pinzhi'].$wuqi['zb_name'].' '.$wuqi['zb_dj'] . "级</div>";
                } else {
                    $jiami1 = "id=1";
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

//                    echo "<div>武器: <a href='cdzb.php?$url1'>无</a></div>";
                    echo "<div>武器: 无</div>";
                }

                if ($yifu) {
                    $jiami1 = "x=y&id=" . $yifu["num"];
                    $jiami2 = "x=q&id=" . $yifu["num"];
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

//                    echo "<div>衣服: <a href='info.php?$url1'>" . $yifu['zb_pinzhi'].$yifu['zb_name'].'</a> '.$yifu['zb_dj'] . "级</div>";
                    echo "<div>衣服: " . $yifu['zb_pinzhi'].$yifu['zb_name'].' '.$yifu['zb_dj'] . "级</div>";
                } else {
                    $jiami1 = "id=2";
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

//                    echo "<div>衣服: <a href='cdzb.php?$url1'>无</a></div>";
                    echo "<div>衣服: 无</div>";
                }

                if ($yaodai) {
                    $jiami1 = "x=y&id=" . $yaodai["num"];
                    $jiami2 = "x=q&id=" . $yaodai["num"];
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

//                    echo "<div>腰带: <a href='info.php?$url1'>" . $yaodai['zb_pinzhi'].$yaodai['zb_name'].'</a> '.$yaodai['zb_dj'] . "级</div>";
                    echo "<div>腰带: " . $yaodai['zb_pinzhi'].$yaodai['zb_name'].' '.$yaodai['zb_dj'] . "级</div>";
                } else {
                    $jiami1 = "id=3";
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

//                    echo "<div>腰带: <a href='cdzb.php?$url1'>无</a></div>";
                    echo "<div>腰带: 无</div>";
                }

                if ($xuezi) {
                    $jiami1 = "x=y&id=" . $xuezi["num"];
                    $jiami2 = "x=q&id=" . $xuezi["num"];
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    $url2 = encrypt_url("$jiami2.$date", $key_url_md_5);

//                    echo "<div>靴子: <a href='info.php?$url1'>" . $xuezi['zb_pinzhi'].$xuezi['zb_name'].'</a> '.$xuezi['zb_dj'] . "级</div>";
                    echo "<div>靴子: " . $xuezi['zb_pinzhi'].$xuezi['zb_name'].' '.$xuezi['zb_dj'] . "级</div>";
                } else {
                    $jiami1 = "id=4";
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

//                    echo "<div>靴子: <a href='cdzb.php?$url1'>无</a></div>";
                    echo "<div>靴子: 无</div>";
                }
            }
            elseif($dh_fl == 'e'){
                //仙术
                $jiami10 = 'id='.$wj_num;
                $url10 = encrypt_url("$jiami10.$date",$key_url_md_5);

                $jiami1 = 'x=q&id='.$wj_num;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                $jiami4 = 'x=r&id='.$wj_num;
                $url4 = encrypt_url("$jiami4.$date",$key_url_md_5);

                echo "<div><a href='wjinfo.php?$url10'>状态</a> | <a href='wjinfo.php?$url1'>装备</a> | 仙术 | <a href='wjinfo.php?$url4'>天赋</a></div>";

                $sqlHelper = new SqlHelper();
                $sql = "select skill_num,skill_dj from s_wj_skill where s_name='$info[s_name]'";
                $res = $sqlHelper->execute_dql2($sql);

                $zhudong_skill_array = array();
                $beidong_skill_array = array();

                for($j=0;$j<count($res);$j++){
                    $wj_skill_num = $res[$j]["skill_num"];
                    $skill_dj = $res[$j]["skill_dj"];
                    $sql = "select skill_fl,skill_name from s_skill_all where num=$wj_skill_num";
                    $res1 = $sqlHelper->execute_dql($sql);
                    $jiami1 = "x=d&id=".$wj_skill_num;
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    if($res1["skill_fl"] == 'zd'){
//                        $zhudong_skill_array []= "<div><a href='info.php?$url1'>".$res1["skill_name"]."</a> ".$skill_dj."阶</div>";
                        $zhudong_skill_array []= "<div>".$res1["skill_name"]."(".$skill_dj."阶)</div>";
                    }else{
//                        $beidong_skill_array []= "<div><a href='info.php?$url1'>".$res1["skill_name"]."</a> ".$skill_dj."阶</div>";
                        $beidong_skill_array []= "<div>".$res1["skill_name"]."(".$skill_dj."阶)</div>";
                    }
                }

                $sqlHelper->close_connect();

                echo '<div>主动技能</div>';
                for($i=0;$i<count($zhudong_skill_array);$i++){
                    echo $zhudong_skill_array[$i];
                }
                echo '<div style="margin-top: 10px;">被动技能</div>';
                for($i=0;$i<count($beidong_skill_array);$i++){
                    echo $beidong_skill_array[$i];
                }

            }
            elseif($dh_fl == 'r'){
                //天赋
                $jiami10 = 'id='.$wj_num;
                $url10 = encrypt_url("$jiami10.$date",$key_url_md_5);

                $jiami1 = 'x=q&id='.$wj_num;
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                $jiami3 = 'x=e&id='.$wj_num;
                $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);

                echo "<div><a href='wjinfo.php?$url10'>状态</a> | <a href='wjinfo.php?$url1'>装备</a> | <a href='wjinfo.php?$url3'>仙术</a> | 天赋</div>";

                $sqlHelper = new SqlHelper();
                $sql = "select tf_wx,tf_lq,tf_jg,tf_xm,tf_sf from s_user where num=$wj_num";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                echo '<div>悟性:'.$res["tf_wx"].'</div>';
                echo '<div>灵气:'.$res["tf_lq"].'</div>';
                echo '<div>筋骨:'.$res["tf_jg"].'</div>';
                echo '<div>血脉:'.$res["tf_xm"].'</div>';
                echo '<div>身法:'.$res["tf_sf"].'</div>';
            }
        }
        else{
            $jiami1 = 'x=q&id='.$wj_num;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            $jiami3 = 'x=e&id='.$wj_num;
            $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);
            $jiami4 = 'x=r&id='.$wj_num;
            $url4 = encrypt_url("$jiami4.$date",$key_url_md_5);

            echo "<div>状态 | <a href='wjinfo.php?$url1'>装备</a> | <a href='wjinfo.php?$url3'>仙术</a> | <a href='wjinfo.php?$url4'>天赋</a></div>";

            echo '<div>心情:'.$info["mood"].'</div>';
            echo '<div>胜利:'.($info["df_sl"] + $info["df_sb"]).'场'.$info["df_sl"].'胜'.$info["df_sb"].'败</div>';
            echo '<div>称号:';
            if($info["chenghao"]){
                echo $info["chenghao"];
            }else{
                echo '暂无称号';
            }
            echo '</div>';
            $jiami1 = 'id='.$wj_num.'&k=3';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
            echo '<div>魅力:'.$info["meili"]." <a href='wjinfo.php?$url1'>送花</a></div>";
            echo '<div>仙侣:';
            if($info["xianlv"]){
                $sqlHelper = new SqlHelper();
                $sql = "select num,g_name,zhizun_vip,yueka_stop_time,cz_jf from s_user where s_name='$info[xianlv]'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                if($info["xianlv"] == $_SESSION["id"]){
                    $jiami1 = 'x=q';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<a href='../user/info.php?$url1'>".$res["g_name"]."</a>";
                }else{
                    $jiami1 = 'id='.$res["num"];
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<a href='wjinfo.php?$url1'>".$res["g_name"]."</a>";
                }

                if($res["zhizun_vip"] == 1){
                    echo "<img class='tx_img' src='../images/zz.gif'>";
                    echo "<img class='tx_img' src='../images/yk.gif'>";
                }else{
                    $now_time = date("Y-m-d H:i:s");
                    if($res["yueka_stop_time"] > $now_time){
                        echo "<img class='tx_img' src='../images/yk.gif'>";
                    }
                }
                if($res["cz_jf"]){
                    echo "<img class='tx_img' src='../images/vip.gif'>";
                }
                echo "<img class='tx_img' src='../images/xl.gif'>";

            }else{
                echo '无';
            }
            echo '</div>';
            if($info["pk_pm"]){
                $jiami1 = 'gwid='.$wj_num.'&gw_lx=3';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                echo "<div>天武排名:".$info["pk_pm"]." <a href='../user/zhandou.php?$url1'>去挑战</a></div>";
            }else{
                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                echo "<div>天武排名:未上榜 <a href='../xy/pk.php?$url1'>去挑战</a></div>";
            }
            echo '<div>帮派:';
            if($info["bangpai"]){
                $sqlHelper = new SqlHelper();
                $sql = "select num from s_bangpai_all where bp_name='$info[bangpai]'";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                $jiami1 = 'x=r&id='.$res["num"];
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<a href='bp.php?$url1'>".$info["bangpai"]."</a>";
            }else{
                echo '无';
            }
            echo '</div>';

            $sqlHelper = new SqlHelper();
            $sql = "select qinmidu from s_wj_friends where s_name='$_SESSION[id]' and df_num='$wj_num'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();
            if($res){
                $hy_state = 1;
            }else{
                $hy_state = 0;
            }

            if($hy_state == 1){
                echo '<div>亲密度:'.$res["qinmidu"];

                if(!$info["xianlv"]){
                    $jiehun_qinmidu = jiehun_qinmidu();
                    if($res["qinmidu"] >= $jiehun_qinmidu){
                        $sqlHelper = new SqlHelper();
                        $wj_sex = $sqlHelper->chaxun_wj_user_neirong('sex');
                        $sqlHelper->close_connect();

                        if($wj_sex != $info["sex"]){
                            $jiami4 = 'id='.$wj_num.'&k=4';
                            $url4 = encrypt_url("$jiami4.$date",$key_url_md_5);

                            echo " <a href='wjinfo.php?$url4'>求婚</a>";
                        }
                    }
                }

                echo '</div>';
            }

            $jiami1 = 'id='.$wj_num.'&k=1';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            $jiami2 = 'gwid='.$wj_num.'&gw_lx=2';
            $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

            echo "<div><a href='wjinfo.php?$url1'>私聊</a> <a href='../user/zhandou.php?$url2'>斗法</a>";

            if($hy_state == 0){
                $jiami3 = 'id='.$wj_num.'&k=2';
                $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);
                echo " <a href='wjinfo.php?$url3'>加友</a>";
            }else{
                $jiami3 = 'x=e&id='.$wj_num;
                $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);
                echo " <a href='../user/hy.php?$url3'>删友</a>";
            }

            echo '</div>';

            echo '<div>人物属性</div>';

            require_once '../user/wj_all_zt.php';

            $wj_all_zt_add_zhi = wj_all_zt_add_zhi($info["s_name"],$info["dj"]);

            echo '<div>攻击:'.$wj_all_zt_add_zhi[0].'</div>';
            echo '<div>防御:'.$wj_all_zt_add_zhi[2].'</div>';
            echo '<div>生命:'.$wj_all_zt_add_zhi[3].'</div>';
            echo '<div>仙气:'.$wj_all_zt_add_zhi[1].'</div>';
            echo '<div>速度:'.$wj_all_zt_add_zhi[6].'</div>';
            echo '<div>暴击:'.$wj_all_zt_add_zhi[4].'</div>';
            echo '<div>韧性:'.$wj_all_zt_add_zhi[5].'</div>';
        }
    }
}




require_once "../include/time.php";

?>