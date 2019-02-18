<?php

//水仙花数
function flower($n,$m){
    for ($i=$n; $i<$m; $i++){
        $b = floor($i/100);
        $s = floor(($i%100)/10);
        $g = $i%10;
        if($i == pow($b,3)+pow($s,3)+pow($g,3)){
            echo $i."<br>";
        }
    }
}
//echo flower(100,999);

//首先出现三次的字符
function firstShow($str){
    $len = strlen($str);
    //echo $len;
    $arr = [];
    $brr = [];
    for ($i=0; $i<$len; $i++){
        //$arr[$str[$i]] = 1;
        if(isset($arr[$str[$i]])){
            $arr[$str[$i]]++;
        }else{
            $arr[$str[$i]] = 1;
        }
        if($arr[$str[$i]] >= 3){
            return $str[$i];
        }
    }
    return $arr;
}
var_dump(firstShow("hello peace and love"));

//回文字符串
function huiwen($str){
    $len = strlen($str);
    $res = "";
    for ($i=$len-1; $i>=0; $i--){
        $res .= $str[$i];
    }
    if($str == $res){
       return "yes";
    }else{
        return "no";
    }
}
//echo huiwen("abba");

//斐波那契
function test($num){
    if($num == 0) return 0;
    if($num ==1 || $num ==2) return 1;
    return test($num-1) + test($num-2);
}
/*for ($i=1; $i<=20; $i++){
    echo test($i)."<br>";
}*/

//数字转字母
function numSwitch($num){
    $list = range('a','z');
    $count = count($list);
    $arr = [];
    while ($num){
        $tem = floor($num / $count);
        $rem = $num % $count;
        if($rem == 0){
            $tem--;
            array_unshift($arr,$list[$count-1]);
        }else{
            array_unshift($arr,$list[$rem-1]);
        }
        $num = $tem;
    }
    return implode('',$arr);
}
//echo numSwitch(703);

//走台阶
function taiJie($num){
    if($num==0) return 0;
    if($num==1) return 1;
    return taiJie($num-1) + taiJie($num-2);
}
//echo taiJie(20);
