<?php

function test($n,$m){
    $sum = 0;
    for ($i=$n; $i<=$m; $i++){
        $str = strval($i);
        for ($k=0; $k<strlen($str); $k++){
            if($str[$k] == 1){
                $sum++;
            }
        }
    }
    return $sum;
}

echo test(100,1300);