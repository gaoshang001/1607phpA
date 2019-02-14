<?php
//header("content-type:text/html;charset=utf-8");
/*
 * Created by PhpStorm.
 * User: GS
 * Date: 2019/2/12
 * Time: 16:02
 */

    /*
     * 编写一个程序，实现1+2+3+...+100的和；
     * 方法一  for循环从1加到max的和
     */
    function sum1($max){
        $sum=0;
        for ($i=1; $i<=$max; $i++){
            $sum += $i;
        }
        return $sum;
    }
    //方法二  递归
    function sum2($max, $i=1, $sum=0){
        if($i>$max){
            return $sum;
        }else{
            $sum += $i;
            $i++;
            return sum2($max, $i++, $sum);
        }
    }
    //方法三 函数生成数组 然后求和
    function sum3($max){
        $arr = range(1,$max);
        return array_sum($arr);
    }

    //$num = sum3(100);
    //echo $num;

    /*
     * 编写一个程序，实现N的阶乘，公式为：N! = N *（N-1）*（N-2）*...*1
     *
     */
    function jc($n){
        $sum = $n;
        for ($i=1; $i<$n; $i++){
            $sum *= ($n-$i);
        }
        return $sum;
    }
//    $num = jc(5);
//    echo $num;

    /*
     * 判断是否是回文字符串 "abba" 反转后 "abba"
     * 方法一
     */
    function str1($str){
        $res = "";
        for ($i = strlen($str)-1; $i>=0; $i--){
            $res .= $str[$i];
        }
        return $str = $res;
    }

    //方法二
    function str2($str){
        $arr = [];
        for ($i = strlen($str)-1; $i>=0; $i--){
            $arr[] = $str[$i];
        }

        for ($i=0; $i<strlen($str); $i++ ){
            if($arr[$i] != $str[$i]){
                echo "不是回文字符串";
                die;
            }
        }

        echo "是回文字符串";
        die;
    }
    //方法三
    //首位+1 末位-1 再次进行对比
    function str3($str){
        $len = strlen($str);
        $start = 0;
        $end = $len-1;
        $count = floor($len/2);
        for ($i=0; $i<$count; $i++){
            if($str[$start] == $str[$end]){
                $start++;
                $end--;
            }else{
                return false;
            }
        }
        return true;
    }

//    var_dump(str3("abba"));

    /*
     * 排序
     * 方法一  冒泡排序
     */
    function sort1($arr){
        $len = count($arr);
        for ($i=1; $i<=$len; $i++){
            for ($j=0; $j<$len-$i; $j++){
                if($arr[$j]>$arr[$j+1]){
                    $arr[$j] = $arr[$j] ^ $arr[$j+1];
                    $arr[$j+1] = $arr[$j] ^ $arr[$j+1];
                    $arr[$j] = $arr[$j] ^ $arr[$j+1];
                }
            }
        }
        return $arr;
    }

    //方法二 快速排序
    function sort2($arr){
        $len = count($arr);
        if($len<=1){
            //如果数组长度小于等于1 不需要排序，直接返回
            return $arr;
        }
        //取出数组中的一个值，作为判断条件
        $middle = $arr[0];
        $left = []; //存储比中间值小的值
        $right = []; //存储比中间值大的值
        for ($i=1; $i<$len; $i++){
            if($arr[$i]>$middle){
                //大于中间值 放入right
                $right[] = $arr[$i];
            }else{
                //小于中间值 放入left
                $left[] = $arr[$i];
            }
        }
        $left = sort2($left);
        $right = sort2($right);
        //将数组合并并返回
        return array_merge($left,[$middle],$right);
    }
    var_dump(sort2([5,8,9,6,1,44,66]));
?>

