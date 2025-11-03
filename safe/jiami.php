<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2019/3/12
 * Time: 23:07
 * 加密函数
 */

//---------------以下为加密函数（复制过去就行了）-----------------
function keyED($txt,$encrypt_key){
    $encrypt_key =    md5($encrypt_key);
    $ctr=0;
    $tmp = "";
    for($i=0;$i<strlen($txt);$i++)
    {
        if ($ctr==strlen($encrypt_key))
            $ctr=0;
        $tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1);
        $ctr++;
    }
    return $tmp;
}
function encrypt($txt,$key)   {
    $encrypt_key = md5(mt_rand(0,100));
    $ctr=0;
    $tmp = "";
    for ($i=0;$i<strlen($txt);$i++)
    {
        if ($ctr==strlen($encrypt_key))
            $ctr=0;
        $tmp.=substr($encrypt_key,$ctr,1) . (substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1));
        $ctr++;
    }
    return keyED($tmp,$key);
}
function decrypt($txt,$key){
    $txt = keyED($txt,$key);
    $tmp = "";
    for($i=0;$i<strlen($txt);$i++)
    {
        $md5 = substr($txt,$i,1);
        $i++;
        $tmp.= (substr($txt,$i,1) ^ $md5);
    }
    return $tmp;
}
function encrypt_url($url,$key){
    return rawurlencode(base64_encode(encrypt($url,$key)));
}
function decrypt_url($url,$key){
    return decrypt(base64_decode(rawurldecode($url)),$key);
}
function geturl($str,$key){
    $str = decrypt_url($str,$key);
    $url_array = explode('&',$str);
    if (is_array($url_array))
    {
        foreach ($url_array as $var)
        {
            $var_array = explode("=",$var);
            if(isset($var_array[1])){
                $vars[$var_array[0]]=$var_array[1];
            }else{
                return 0;
            }
        }
    }
    return $vars;
}

$key_url_md_5 = 'suxin.com-wmtfyl-!@3*'; //可以更换为其它的加密标记，可以自由发挥
$date = date("Y-m-d H:i:s");
?>