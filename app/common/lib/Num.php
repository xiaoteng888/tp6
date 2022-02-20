<?php


namespace app\common\lib;


class Num
{
    public static function getCode($len = 4)
    {
        if($len == 4){
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
        }else{
            $code = str_pad(random_int(1, 999999), 6, 0, STR_PAD_LEFT);
        }
        return $code;
    }
}