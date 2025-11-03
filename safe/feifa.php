<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2019/09/24
 * Time: 09:34
 * 判断是否存在非法字符
 */

//判断字符是否非法，0表示非法，1表示正常
function feifa_state($str){
    $feifa = array('\'','"','#','=');
    $feifa_state = 1;

    $str_panduan = str_split($str);
    for($i=0;$i<count($str_panduan);$i++){
        if(in_array($str_panduan[$i],$feifa)){
            $feifa_state = 0;
            break;
        }
    }

    return $feifa_state;
}

//判断参数是否为正整数，0表示非法，1表示正常
function feifa_shuzi($str){
    $state = 1;
    if(is_numeric($str)){
        if($str <= 0){
            $state = 0;
        }
        if($str != floor($str)){
            $state = 0;
        }
    }else{
        $state = 0;
    }

    return $state;
}

function feifa_username($str)
{
    return preg_match('/^[0-9a-zA-Z][0-9a-zA-Z_]{4,}$/', $str);
}