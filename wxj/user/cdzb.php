<?php
/**
 * Author: by suxin
 * Date: 2019/12/10
 * Time: 09:45
 * Note: 装备操作界面
 */


require_once '../include/fzr.php';
require_once '../include/SqlHelper.class.php';
//require_once '../include/func.php';


//获取未穿戴的装备
function zb_nouse($zb_col){
    $sqlHelper=new SqlHelper();
    $sql = "select zb_name,num,zb_dj,zb_pinzhi from s_wj_zhuangbei where s_name='$_SESSION[id]' and zb_used=0 and zb_col='$zb_col'";
    $res = $sqlHelper->execute_dql2($sql);

    if($res){
        // 循环取出记录
        $zb_count = count($res);
        for($i=0;$i<$zb_count;$i++){
            $zb_num=$res[$i]['num'];
            echo ($i+1).". ";

            echo $res[$i]["zb_pinzhi"].$res[$i]['zb_name'].' '.$res[$i]["zb_dj"].'级';

            $jiami1 = "x=w&id=".$zb_num;
            global $date,$key_url_md_5;
            $url1 = encrypt_url("$jiami1.$date",$key_url_md_5);

            echo " <a href='cdzb.php?$url1'>穿戴</a><br>";
        }
    }
    else{
        echo "暂无可穿戴装备<br/>";
    }
    $sqlHelper->close_connect();
}

//玩家穿戴装备
function cd_zb($zb_num){
    $sqlHelper=new SqlHelper();
    $sql="select zb_col from s_wj_zhuangbei where num='$zb_num' and s_name='$_SESSION[id]'";
    $res2=$sqlHelper->execute_dql($sql);
    $sqlHelper->close_connect();

    if($res2) {
        $sqlHelper = new SqlHelper();
        $sql = "select num from s_wj_zhuangbei where zb_used=1 and s_name='$_SESSION[id]' and zb_col='$res2[zb_col]'";
        $res1 = $sqlHelper->execute_dql($sql);
        $sqlHelper->close_connect();

        if ($res1) {
            zb_xx($res1["num"]);
        }

        $sqlHelper = new SqlHelper();
        $strsql = "update s_wj_zhuangbei set zb_used=1 where s_name='$_SESSION[id]' and zb_col='$res2[zb_col]' and num=$zb_num";
        $result = $sqlHelper->execute_dml($strsql);
        $sqlHelper->close_connect();


    }
    else{
        echo '<div>该装备不存在</div>';
    }
}

//卸下装备
function zb_xx($zb_num){
    $sqlHelper=new SqlHelper();
    $sql = "update s_wj_zhuangbei set zb_used=0 where s_name='$_SESSION[id]' and num=$zb_num";
    $res = $sqlHelper->execute_dml($sql);
    $sqlHelper->close_connect();
}

$jiami1 = "x=w";
$url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

if($_SERVER["QUERY_STRING"]) {
    $url_info = geturl($_SERVER["QUERY_STRING"], $key_url_md_5);
    if (isset($url_info["x"]) && isset($url_info["id"])) {
        $suxin1 = explode(".", $url_info["x"]);
        $fenlei = $suxin1[0];
        $suxin2 = explode(".", $url_info["id"]);
        $zb_num = $suxin2[0];


        if ($fenlei == 'q') {
            //卸下装备
            zb_xx($zb_num);
            header("location: info.php?$url1");
        }
        elseif ($fenlei == 'w') {
            //穿戴装备
            cd_zb($zb_num);
            header("location: info.php?$url1");
        }
    }elseif (isset($url_info["id"])) {
        $suxin1 = explode(".", $url_info["id"]);
        $cz_id = $suxin1[0];

        if($cz_id == 1){
            echo '<div>【武器穿戴】</div>';
            zb_nouse('wuqi');
        }elseif($cz_id == 2){
            echo '<div>【衣服穿戴】</div>';
            zb_nouse('yifu');
        }elseif($cz_id == 3){
            echo '<div>【腰带穿戴】</div>';
            zb_nouse('yaodai');
        }elseif($cz_id == 4){
            echo '<div>【靴子穿戴】</div>';
            zb_nouse('xuezi');
        }elseif($cz_id == 5){
            echo '<div>【帽子穿戴】</div>';
            zb_nouse('maozi');
        }elseif($cz_id == 6){
            echo '<div>【戒指穿戴】</div>';
            zb_nouse('jiezhi');
        }
    }
}




echo "<a href=info.php?$url1>返回装备</a>";



require_once "../include/time.php";

?>