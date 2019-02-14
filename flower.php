<?php


function flower($num){
    $b = floor($num/100);      //计算百位
    $s = floor(($num%100)/10); //计算十位
    $g = $num%10;                     //计算个位
    
    if($num == $g*$g*$g + $s*$s*$s + $b*$b*$b){
        return true;
    }else{
        return false;
    }
}

var_dump(flower(153));