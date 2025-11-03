<?php
/**
 * Author: by suxin
 * Date: 2020/1/10
 * Time: 21:25
 * Note: 仙侣
 */

require_once "../include/fzr.php";
require_once "../control/control.php";

//仙侣商城出售的物品(格式为 购买id号，物品id，物品名称，售卖分类，售卖价格)
function xianlv_shop(){
    return array(
        '1,33,草戒,money,3344',
        '2,34,金戒指,coin,520',
        '3,35,钻石戒指,coin,1314',
        '4,36,一纸休书,money,3344',
    );
}

if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $dh_fl = $suxin1[0];

        if($dh_fl == 'q'){
            //仙侣首页
            $sqlHelper = new SqlHelper();
            $sql = "select xianlv,eaz,love_time,jiezhi,jiezhi_dj from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            echo '<div>【仙侣】</div>';

            $jiami1 = 'x=w';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<div>仙侣首页 <a href='xl.php?$url1'>仙侣商城</a></div>";

            echo '<div style="margin-top: 10px;">我的仙侣:';
            if($res["xianlv"]){
                $sqlHelper = new SqlHelper();
                $sql = "select num,g_name from s_user where s_name='$res[xianlv]'";
                $res1 = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();

                $jiami1 = 'id='.$res1["num"];
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<a href='wjinfo.php?$url1'>".$res1["g_name"]."</a></div>";
                echo '<div>恩爱值:'.$res["eaz"].'</div>';

                $jiami1 = 'x=i';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div>结婚戒指:<a href='xl.php?$url1'>".$res["jiezhi"].'</a> '.$res["jiezhi_dj"]."级</div>";
                echo '<div>结婚纪念日:'.substr($res["love_time"], 0, 16).'</div>';

                $jiami1 = 'x=p';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div style='margin-top: 5px;'><a href='xl.php?$url1'>我要离婚</div>";
            }else{
                echo '无</div>';

                echo "<div style='margin-top: 5px;'>我的求婚状态:</div>";

                $sqlHelper = new SqlHelper();
                $sql = "select s_name1 from s_wj_qiuhun where s_name='$_SESSION[id]' and state=0";
                $res = $sqlHelper->execute_dql($sql);

                if($res){
                    $sql = "select num,g_name from s_user where s_name='$res[s_name1]'";
                    $res = $sqlHelper->execute_dql($sql);

                    $jiami1 = 'id='.$res["num"];
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                    echo "<div>你当前正在追求 <a href='../xy/wjinfo.php?$url1'>".$res["g_name"]."</a> 哦~(请等待对方同意)</div>";
                }else{
                    echo '<div>生活看淡，谁也不爱~</div>';
                }

                echo "<div style='margin-top: 10px;'>我发出的求婚:</div>";

                $sql = "select num,s_name1,times,jiezhi,state from s_wj_qiuhun where s_name='$_SESSION[id]' order by state asc,times desc";
                $res = $sqlHelper->execute_dql2($sql);
                if($res){
                    for($i=0;$i<count($res);$i++){
                        $s_name = $res[$i]["s_name1"];
                        $jiezhi = $res[$i]["jiezhi"];
                        $num = $res[$i]["num"];

                        $sql = "select num,g_name from s_user where s_name='$s_name'";
                        $res1 = $sqlHelper->execute_dql($sql);

                        echo '<div>[' . substr($res[$i]['times'], 5, 11) . ']';
                        echo "<span style='color:red'>系统:</span>";

                        $jiami1 = 'id='.$res1["num"];
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        $jiami2 = 'x=t&id='.$num;
                        $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                        echo "你手持<a href='xl.php?$url2'>".$jiezhi."</a>向<a href='wjinfo.php?$url1'>".$res1["g_name"]."</a>求婚 ";

                        if($res[$i]["state"] == 2){
                            echo '(<span style="color:red;">被拒绝</span>)';
                        }else{
                            echo '(<span style="color:green;">求婚中</span>)';
                        }

                        echo '</div>';
                    }
                }else{
                    echo '<div>当前你没有求婚哦~</div>';
                }

                echo "<div style='margin-top: 10px;'>我收到的求婚:</div>";

                $sql = "select num,s_name,times,jiezhi,state from s_wj_qiuhun where s_name1='$_SESSION[id]' order by state asc,times desc";
                $res = $sqlHelper->execute_dql2($sql);
                if($res){
                    for($i=0;$i<count($res);$i++){
                        $s_name = $res[$i]["s_name"];
                        $jiezhi = $res[$i]["jiezhi"];
                        $num = $res[$i]["num"];

                        $sql = "select num,g_name from s_user where s_name='$s_name'";
                        $res1 = $sqlHelper->execute_dql($sql);

                        echo '<div>[' . substr($res[$i]['times'], 5, 11) . ']';
                        echo "<span style='color:red'>系统: </span>";

                        $jiami1 = 'id='.$res1["num"];
                        $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                        $jiami2 = 'x=t&id='.$num;
                        $url2 = encrypt_url("$jiami2.$date",$key_url_md_5);

                        $jiami3 = 'x=y&id='.$num;
                        $url3 = encrypt_url("$jiami3.$date",$key_url_md_5);

                        $jiami4 = 'x=u&id='.$num;
                        $url4 = encrypt_url("$jiami4.$date",$key_url_md_5);

                        echo "<a href='wjinfo.php?$url1'>".$res1["g_name"]."</a>手持<a href='xl.php?$url2'>".$jiezhi."</a>向你求婚 ";

                        if($res[$i]["state"] == 2){
                            echo '(<span style="color:red;">已拒绝</span>)';
                        }else{
                            echo "<a href='xl.php?$url3'>同意</a> <a href='xl.php?$url4'>拒绝</a>";
                        }

                        echo '</div>';
                    }
                }else{
                    echo '<div>当前没有人向你求婚~</div>';
                }

                $sqlHelper->close_connect();
            }

        }
        elseif($dh_fl == 'w'){
            //仙侣商城
            echo '<div>【仙侣】</div>';

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo "<div><a href='xl.php?$url1'>仙侣首页</a> 仙侣商城</div>";

            $sqlHelper = new SqlHelper();
            $sql = "select money,coin from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();

            echo '<div style="margin-top: 5px;">我的灵石:'.$res["money"].'</div>';
            echo '<div>我的仙券:'.$res["coin"].'</div>';

            echo '<div style="margin-top: 5px;">婚恋道具:</div>';

            $xianlv_shop = xianlv_shop();
            $count_xianlv_shop = count($xianlv_shop);
            for($i=0;$i<$count_xianlv_shop;$i++){
                $shop_wp = explode(',',$xianlv_shop[$i]);

                $jiami1 = 'x=e&id='.$shop_wp[0];
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo "<div>".($i + 1).".<a href='xl.php?$url1'>".$shop_wp[2]."</a>(".$shop_wp[4];
                if($shop_wp[3] == 'coin'){
                    echo '仙券';
                }else{
                    echo '灵石';
                }

                $jiami1 = 'x=r&id='.$shop_wp[0];
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                echo ") <a href='xl.php?$url1'>购买</a></div>";
            }

            echo '<br/>';
            $jiehun_dj = jiehun_dj();
            echo '<div>1.双方等级大于'.$jiehun_dj.'级才可以结婚</div>';
            echo '<div>2.求婚需要戒指才可以进行</div>';
        }
        elseif($dh_fl == 'e'){
            //仙侣商城物品信息

            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_id = $suxin1[0];

                $wp_id -= 1;

                $xianlv_shop = xianlv_shop();
                if(isset($xianlv_shop[$wp_id])){
                    require_once '../include/func.php';
                    $shop_wp = explode(',',$xianlv_shop[$wp_id]);
                    wp_info($shop_wp[1],5);

                    if($shop_wp[2] != '一纸休书') {
                        echo '<div>附加属性:</div>';
                        $jiezhi_shuxing = jiezhi_shuxing($shop_wp[2], 1);
                        if ($jiezhi_shuxing[0]) {
                            echo '<div>攻击+' . $jiezhi_shuxing[0] . '</div>';
                        }
                        if ($jiezhi_shuxing[1]) {
                            echo '<div>防御+' . $jiezhi_shuxing[1] . '</div>';
                        }
                        if ($jiezhi_shuxing[2]) {
                            echo '<div>仙气+' . $jiezhi_shuxing[2] . '</div>';
                        }
                        if ($jiezhi_shuxing[3]) {
                            echo '<div>生命+' . $jiezhi_shuxing[3] . '</div>';
                        }
                        if ($jiezhi_shuxing[4]) {
                            echo '<div>暴击+' . $jiezhi_shuxing[4] . '</div>';
                        }
                        if ($jiezhi_shuxing[5]) {
                            echo '<div>韧性+' . $jiezhi_shuxing[5] . '</div>';
                        }
                        if ($jiezhi_shuxing[6]) {
                            echo '<div>速度+' . $jiezhi_shuxing[6] . '</div>';
                        }
                    }
                    $jiami1 = 'x=w';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<div style='margin-top: 5px;'><a href='xl.php?$url1'>返回上页</a></div>";
                }
            }
        }
        elseif($dh_fl == 'r'){
            //仙侣商城物品信息

            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $wp_id = $suxin1[0];

                $wp_id -= 1;

                $xianlv_shop = xianlv_shop();
                if(isset($xianlv_shop[$wp_id])){
                    $shop_wp = explode(',',$xianlv_shop[$wp_id]);
                    $sqlHelper = new SqlHelper();
                    $sql = "select money,coin from s_user where s_name='$_SESSION[id]'";
                    $res = $sqlHelper->execute_dql($sql);
                    $sqlHelper->close_connect();

                    if($shop_wp[3] == 'money'){
                        if($res["money"] >= $shop_wp[4]){
                            $sqlHelper = new SqlHelper();
                            $sqlHelper->jianshao_wj_user_neirong('money',$shop_wp[4]);
                            $sqlHelper->close_connect();

                            require_once '../include/func.php';
                            give_wupin($shop_wp[1],1);
                            echo '<div>购买成功，获得'.$shop_wp[2].'x1</div>';
                        }else{
                            echo '<div>灵石数量不足，购买失败</div>';
                        }
                    }
                    else{
                        if($res["coin"] >= $shop_wp[4]){
                            $sqlHelper = new SqlHelper();
                            $sqlHelper->jianshao_wj_user_neirong('coin',$shop_wp[4]);
                            $sqlHelper->close_connect();

                            require_once '../include/func.php';
                            give_wupin($shop_wp[1],1);
                            echo '<div>购买成功，获得'.$shop_wp[2].'x1</div>';
                        }else{
                            echo '<div>仙券数量不足，购买失败</div>';
                        }
                    }

                    $jiami1 = 'x=w';
                    $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                    echo "<div><a href='xl.php?$url1'>返回上页</a></div>";
                }
            }
        }
        elseif($dh_fl == 't'){
            //求婚查看戒指属性
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $qh_num = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $sql = "select jiezhi from s_wj_qiuhun where s_name1='$_SESSION[id]' and num=$qh_num or s_name='$_SESSION[id]' and num=$qh_num";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res){
                    echo '<div>【'.$res["jiezhi"].'】</div>';
                    echo '<div>附加属性:</div>';
                    $jiezhi_shuxing = jiezhi_shuxing($res["jiezhi"],1);
                    if($jiezhi_shuxing[0]){
                        echo '<div>攻击+'.$jiezhi_shuxing[0].'</div>';
                    }
                    if($jiezhi_shuxing[1]){
                        echo '<div>防御+'.$jiezhi_shuxing[1].'</div>';
                    }
                    if($jiezhi_shuxing[2]){
                        echo '<div>仙气+'.$jiezhi_shuxing[2].'</div>';
                    }
                    if($jiezhi_shuxing[3]){
                        echo '<div>生命+'.$jiezhi_shuxing[3].'</div>';
                    }
                    if($jiezhi_shuxing[4]){
                        echo '<div>暴击+'.$jiezhi_shuxing[4].'</div>';
                    }
                    if($jiezhi_shuxing[5]){
                        echo '<div>韧性+'.$jiezhi_shuxing[5].'</div>';
                    }
                    if($jiezhi_shuxing[6]){
                        echo '<div>速度+'.$jiezhi_shuxing[6].'</div>';
                    }
                }else{
                    echo '<div>当前戒指信息不存在</div>';
                }

                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div style='margin-top: 5px;'><a href='xl.php?$url1'>返回上页</a></div>";
            }
        }
        elseif($dh_fl == 'y'){
            //同意求婚
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $qh_num = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $sql = "select s_name,jiezhi from s_wj_qiuhun where s_name1='$_SESSION[id]' and num=$qh_num and state = 0";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res){
                    $sqlHelper = new SqlHelper();
                    $sql = "select g_name from s_user where s_name='$res[s_name]'";
                    $res1 = $sqlHelper->execute_dql($sql);

                    echo '<div>你同意了'.$res1["g_name"].'的求婚</div>';

                    $now_time = date("Y-m-d H:i:s");
                    $sql = "update s_user set xianlv='$res[s_name]',love_time='$now_time',jiezhi='$res[jiezhi]' where s_name='$_SESSION[id]'";
                    $res1 = $sqlHelper->execute_dml($sql);

                    $sql = "update s_user set xianlv='$_SESSION[id]',love_time='$now_time',jiezhi='$res[jiezhi]' where s_name='$res[s_name]'";
                    $res1 = $sqlHelper->execute_dml($sql);

                    $sql = "delete from s_wj_qiuhun where s_name='$_SESSION[id]'";
                    $res1 = $sqlHelper->execute_dml($sql);

                    $sql = "delete from s_wj_qiuhun where s_name='$res[s_name]'";
                    $res1 = $sqlHelper->execute_dml($sql);

                    $sql = "update s_wj_qiuhun set state=2 where s_name1='$_SESSION[id]' and state=0";
                    $res1 = $sqlHelper->execute_dml($sql);
                    $sqlHelper->close_connect();

                    require_once '../include/func.php';
                    insert_xitong_gonggao($_SESSION["id"],'喜结良缘，共度余生~','qhcg',$res["s_name"],$message1='');
                }else{
                    echo '<div>当前求婚信息不存在</div>';
                }

                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div><a href='xl.php?$url1'>返回上页</a></div>";
            }
        }
        elseif($dh_fl == 'u'){
            //拒绝求婚
            if (isset($url_info["id"])) {
                $suxin1 = explode(".", $url_info["id"]);
                $qh_num = $suxin1[0];

                $sqlHelper = new SqlHelper();
                $sql = "select s_name from s_wj_qiuhun where s_name1='$_SESSION[id]' and state=0 and num=$qh_num";
                $res = $sqlHelper->execute_dql($sql);
                $sqlHelper->close_connect();
                if($res){
                    $sqlHelper = new SqlHelper();
                    $sql = "select g_name from s_user where s_name='$res[s_name]'";
                    $res = $sqlHelper->execute_dql($sql);
                    echo '<div>你拒绝了'.$res["g_name"].'的求婚</div>';

                    $sql = "update s_wj_qiuhun set state=2 where s_name1='$_SESSION[id]' and state=0 and num=$qh_num";
                    $res = $sqlHelper->execute_dml($sql);
                    $sqlHelper->close_connect();
                }else{
                    echo '<div>当前求婚信息不存在</div>';
                }

                $jiami1 = 'x=q';
                $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);
                echo "<div><a href='xl.php?$url1'>返回上页</a></div>";
            }
        }
        elseif($dh_fl == 'i') {
            //结婚后查看戒指属性

            $sqlHelper = new SqlHelper();
            $sql = "select jiezhi,jiezhi_dj,eaz from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();
            if ($res) {
                if ($res["jiezhi"]) {
                    echo '<div>【' . $res["jiezhi"] . ' ' . $res["jiezhi_dj"] . '级】</div>';
                    echo '<div>附加属性:</div>';
                    $jiezhi_shuxing = jiezhi_shuxing($res["jiezhi"], $res["jiezhi_dj"]);
                    if ($jiezhi_shuxing[0]) {
                        echo '<div>攻击+' . $jiezhi_shuxing[0] . '</div>';
                    }
                    if ($jiezhi_shuxing[1]) {
                        echo '<div>防御+' . $jiezhi_shuxing[1] . '</div>';
                    }
                    if ($jiezhi_shuxing[2]) {
                        echo '<div>仙气+' . $jiezhi_shuxing[2] . '</div>';
                    }
                    if ($jiezhi_shuxing[3]) {
                        echo '<div>生命+' . $jiezhi_shuxing[3] . '</div>';
                    }
                    if ($jiezhi_shuxing[4]) {
                        echo '<div>暴击+' . $jiezhi_shuxing[4] . '</div>';
                    }
                    if ($jiezhi_shuxing[5]) {
                        echo '<div>韧性+' . $jiezhi_shuxing[5] . '</div>';
                    }
                    if ($jiezhi_shuxing[6]) {
                        echo '<div>速度+' . $jiezhi_shuxing[6] . '</div>';
                    }

                    echo '<div style="margin-top: 10px;">戒指升级所需:</div>';
                    $shengji_cailiao = jiezhi_shengji_cailiao($res["jiezhi"],$res["jiezhi_dj"]);

                    if($shengji_cailiao){
                        $shengji_state = 1;
                        for($i=0;$i<count($shengji_cailiao);$i++){
                            $cailiao = explode(',',$shengji_cailiao[$i]);
                            if($cailiao[0] == 'eaz'){
                                echo '<div>恩爱值达到:'.$cailiao[1].'点</div>';
                                echo '<div>当前恩爱值:'.$res["eaz"].'点</div>';
                                if($shengji_state == 1 && $res["eaz"] < $cailiao[1]){
                                    $shengji_state = 0;
                                }
                            }elseif($cailiao[0] == 'wp'){
                                $sqlHelper = new SqlHelper();
                                $sql = "select wp_name from s_wupin_all where num=$cailiao[1]";
                                $res1 = $sqlHelper->execute_dql($sql);

                                echo '<div style="margin-top: 5px;">消耗物品:'.$res1["wp_name"].'x'.$cailiao[2].'</div>';
                                $wp_count = $sqlHelper->chaxun_wp_counts($res1["wp_name"]);
                                echo '<div>当前拥有:'.$res1["wp_name"].'x'.$wp_count.'</div>';
                                $sqlHelper->close_connect();

                                if($shengji_state == 1 && $wp_count < $cailiao[2]){
                                    $shengji_state = 0;
                                }
                            }
                        }

                        if($shengji_state == 1){
                            $jiami1 = 'x=o';
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<div><a href='xl.php?$url1'>确认升级</a></div>";
                        }

                    }else{
                        echo '<div>当前已达最高等级~</div>';
                    }

                } else {
                    echo '<div>你还没有结婚哦~</div>';
                }
            }

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<div style='margin-top: 5px;'><a href='xl.php?$url1'>返回上页</a></div>";

        }
        elseif($dh_fl == 'o') {
            //结婚后升级戒指等级

            $sqlHelper = new SqlHelper();
            $sql = "select jiezhi,jiezhi_dj,xianlv,eaz from s_user where s_name='$_SESSION[id]'";
            $res = $sqlHelper->execute_dql($sql);
            $sqlHelper->close_connect();
            if ($res) {
                if ($res["jiezhi"]) {
                    $shengji_cailiao = jiezhi_shengji_cailiao($res["jiezhi"],$res["jiezhi_dj"]);

                    if($shengji_cailiao){
                        $shengji_state = 1;
                        for($i=0;$i<count($shengji_cailiao);$i++){
                            $cailiao = explode(',',$shengji_cailiao[$i]);
                            if($cailiao[0] == 'eaz'){
                                if($shengji_state == 1 && $res["eaz"] < $cailiao[1]){
                                    $shengji_state = 0;
                                }
                            }elseif($cailiao[0] == 'wp'){
                                $sqlHelper = new SqlHelper();
                                $sql = "select wp_name from s_wupin_all where num=$cailiao[1]";
                                $res1 = $sqlHelper->execute_dql($sql);

                                $wp_count = $sqlHelper->chaxun_wp_counts($res1["wp_name"]);
                                $sqlHelper->close_connect();

                                if($shengji_state == 1 && $wp_count < $cailiao[2]){
                                    $shengji_state = 0;
                                }
                            }
                        }

                        if($shengji_state == 1){
                            for($i=0;$i<count($shengji_cailiao);$i++){
                                $cailiao = explode(',',$shengji_cailiao[$i]);
                                if($cailiao[0] == 'wp'){
                                    $sqlHelper = new SqlHelper();
                                    $sql = "select wp_name from s_wupin_all where num=$cailiao[1]";
                                    $res1 = $sqlHelper->execute_dql($sql);
                                    $sqlHelper->close_connect();

                                    require_once '../include/func.php';
                                    use_wupin($res1["wp_name"],$cailiao[2]);
                                }
                            }

                            echo '<div>升级成功，戒指等级+1</div>';

                            $sqlHelper = new SqlHelper();
                            $sqlHelper->add_wj_user_neirong('jiezhi_dj',1);
                            $sql = "update s_user set jiezhi_dj=jiezhi_dj+1 where s_name='$res[xianlv]'";
                            $res = $sqlHelper->execute_dml($sql);
                            $sqlHelper->close_connect();

                            $jiami1 = 'x=q';
                            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

                            echo "<div><a href='xl.php?$url1'>返回上页</a></div>";
                        }else{
                            echo '<div>不满足戒指升级条件~</div>';
                        }
                    }else{
                        echo '<div>当前已达最高等级~</div>';
                    }

                } else {
                    echo '<div>你还没有结婚哦~</div>';
                }
            }

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<div style='margin-top: 5px;'><a href='xl.php?$url1'>返回上页</a></div>";

        }
        elseif($dh_fl == 'p') {
            //离婚确认页
            echo '<div>【仙侣】</div>';
            $sqlHelper = new SqlHelper();
            $wj_xianlv = $sqlHelper->chaxun_wj_user_neirong('xianlv');
            if ($wj_xianlv) {
                $sql = "select num,g_name from s_user where s_name='$wj_xianlv'";
                $res = $sqlHelper->execute_dql($sql);

                echo '<div>善缘孽缘终是缘 世事难料遂人愿</div>';

                $jiami1 = 'id='.$res["num"];
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                echo "<div style='margin-top: 10px;'>你确定要和<a href='wjinfo.php?$url1'>".$res["g_name"]."</a>离婚吗？</div>";

                $lihun_daoju = lihun_daoju();
                echo '<div>离婚消耗:</div>';
                echo '<div>'.$lihun_daoju.'x1</div>';

                echo '<div style="margin-top: 5px;">拥有:</div>';
                $wp_count = $sqlHelper->chaxun_wp_counts($lihun_daoju);
                echo '<div>'.$lihun_daoju.'x'.$wp_count.'</div>';

                if($wp_count >= 1){
                    $jiami1 = 'x=a';
                    $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
                    echo "<div style='margin-bottom: 10px;'><a href='xl.php?$url1'>确认离婚</a></div>";
                }

                echo '<div>离婚说明:</div>';
                echo '<div>离婚后，戒指所加属性将消失，两人恩爱值将清空</div>';
            } else {
                echo '<div>你当前未结婚，无需离婚</div>';
            }

            $sqlHelper->close_connect();


            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<div style='margin-top: 5px;'><a href='xl.php?$url1'>返回上页</a></div>";

        }
        elseif($dh_fl == 'a') {
            //离婚执行页
            echo '<div>【仙侣】</div>';
            $sqlHelper = new SqlHelper();
            $wj_xianlv = $sqlHelper->chaxun_wj_user_neirong('xianlv');
            $sqlHelper->close_connect();

            if ($wj_xianlv) {

                $lihun_daoju = lihun_daoju();

                $sqlHelper = new SqlHelper();
                $wp_count = $sqlHelper->chaxun_wp_counts($lihun_daoju);
                $sqlHelper->close_connect();

                if($wp_count >= 1){
                    require_once '../include/func.php';
                    $use_state = use_wupin($lihun_daoju,1);
                    if($use_state == 1){
                        $sqlHelper = new SqlHelper();
                        $sql = "update s_user set xianlv=null,eaz=0,love_time=null,jiezhi=null,jiezhi_dj=1 where s_name='$_SESSION[id]'";
                        $res = $sqlHelper->execute_dml($sql);
                        $sql = "update s_user set xianlv=null,eaz=0,love_time=null,jiezhi=null,jiezhi_dj=1 where s_name='$wj_xianlv'";
                        $res = $sqlHelper->execute_dml($sql);
                        $sqlHelper->close_connect();

                        echo '<div>有缘相聚无缘散 聚散之间莫生怨</div>';
                    }else{
                        echo '<div>离婚所需道具不足，无法离婚</div>';
                    }
                }else{
                    echo '<div>离婚所需道具不足，无法离婚</div>';
                }
            } else {
                echo '<div>你当前未结婚，无需离婚</div>';
            }

            $jiami1 = 'x=q';
            $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);
            echo "<div style='margin-top: 5px;'><a href='xl.php?$url1'>返回上页</a></div>";

        }
    }
}


require_once '../include/time.php';
?>