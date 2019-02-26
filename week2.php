<?php
echo "<pre>";
//1、求最后剩余数
function lastNum($n,$m){
    $boys = range(1,$n);
    $i = 0;
    $k = 0;
    $arr = [];
    while (count($boys) > 1){
        if(!isset($boys[$i])){
            $boys = $arr;
            $arr = [];
            $i = 0;
        }
        $k ++;
        if($k == $m){
            unset($boys[$i]);
            $k = 0;
        }else{
            $arr[] = $boys[$i];
        }
        $i++;
    }
    return $boys;
}
//var_dump(lastNum(9,7));

//2、数组分三组  和相近
function group($arr){
    rsort($arr);
    $array = [
        [array_shift($arr)],
        [array_shift($arr)],
        [array_shift($arr)],
    ];
    for ($i = 0; $i < count($arr); $i++){
        $array[2][] = $arr[$i];
        $sum = array_sum($array[2]);
        if($sum > array_sum($array[0])){
            $array = [
                $array[2],
                $array[0],
                $array[1],
            ];
        }else{
            $array = [
                $array[0],
                $array[2],
                $array[1],
            ];
        }
    }
    return $array;
}
//var_dump(group([50,5,21,23,7,15,30,9]));

//3、传入数组  返回最大值
function getMax($arr,$pow = 0){
    static $return = [];
    $t = [];
    for ($k = 0; $k < 10; $k++){
        $t[] = [];
    }
    $count = count($arr);
    $tt = [];
    for ($i = 0; $i < $count; $i++){
        $index = (string)$arr[$i];
        if(isset($index[$pow])){
            $t[$index[$pow]][] = $arr[$i];
        }else{
            $tt[$index[$pow - 1]][] = $arr[$i];
        }
    }
    for ($j = 0; $j < 10; $j++){
        if(count($t[$j]) == 1){
            array_unshift($return,array_pop($t[$j]));
        }else if(count($t[$j]) > 1){
            getMax($t[$j],$pow + 1);
        }
        if(isset($tt[$j])){
            $return = array_merge($tt[$j],$return);
        }
    }
    return $return;
    //return implode("",$return);
}
//var_dump(getMax([9,99,987,867,75,510,321,401,211,111]));

//4、银行柜台
function bank($active_time,$process_time){
    $windows = [];
    $num = count($active_time);
    $wait_time = 0;
    for ($i = 0; $i < $num; $i++){
        if(count($windows) < 4){
            $windows[] = $active_time[$i] + $process_time[$i];
            continue;
        }
        sort($windows);
        $bye_time = array_shift($windows);
        if($bye_time > $active_time[$i]){
            $wait_time += $bye_time - $active_time[$i];
            $now_time = $bye_time + $process_time[$i];
        }else{
            $now_time = $active_time[$i] + $process_time[$i];
        }
        $windows[] = $now_time;
    }
    return $wait_time / $num * 100;
}
$res =  bank(
    [9.15,9.25,9.33,9.42,9.24,10.00],
    [0.23,0.15,0.35,0.33,0.11,0.21]
);
var_dump($res);