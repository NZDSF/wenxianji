<?php
/**
 * Author: by suxin
 * Date: 2019/12/21
 * Time: 13:57
 * Note: 加入机器人
 */

require_once 'include/SqlHelper.class.php';

$start = 1;
$stop = 20;
$j = $stop;

$sqlHelper = new SqlHelper();
for($i=0;$i<$stop;$i++){
    $robot_name = '战神'.($i+1);
    $robot_dj = ($j + 1) * 5 - 5;
    $j --;
    $robot_pk_pm = $i + 1;

    $sql = "insert into s_user(s_name,g_name,dj,robot,pk_pm) values('$robot_name','$robot_name','$robot_dj',1,'$robot_pk_pm')";
    $res = $sqlHelper->execute_dml($sql);

//    echo $sql.'<br/>';
}
$sqlHelper->close_connect();
?>