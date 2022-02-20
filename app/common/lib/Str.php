<?php


namespace app\common\lib;


class Str
{
    public static function getLoginToken($str)
    {
        //生成token
        $string = md5(uniqid(md5(microtime(true)),true));//生成不会重复的字符串
        $token = sha1($str.$string);//加密
        return $token;
    }
}