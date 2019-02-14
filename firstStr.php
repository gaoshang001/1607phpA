<?php
    function newStr($str){
        $arr = [];
        $len = strlen($str);
        //遍历字符串
        for($i=0; $i<$len; $i++){
            //将字符串中的字符作为空数组中的下标，以此来判断是否出现
            if(isset($arr[$str[$i]])){
                //出现则加一
                $arr[$str[$i]]++;
            }else{
                //未出现则默认为一
                $arr[$str[$i]]=1;
            }

            //如果某个下标出现次数>=3 则输出该字符串
            if($arr[$str[$i]]>=3){
                return $str[$i];
            }
        }
    }

    $str = "Have you ever gone shopping and";
    var_dump(newStr($str));
?>
