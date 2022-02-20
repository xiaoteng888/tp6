<?php


namespace app\common\lib;


class ClassArr
{
    public static function getSmsClassArr()
    {
        return [
            'a' => 'app\common\lib\sms\A',
            'b' => 'app\common\lib\sms\B',
            'c' => 'app\common\lib\sms\C',
        ];
    }

    public static function getLibClassArr()
    {
        return [
            'a' => 'app\common\lib\A',
            'b' => 'app\common\lib\B',
            'num' => 'app\common\lib\Num',
        ];
    }

    public static function getClass($name,$classArr,$param=[],$needInstance=false)
    {
        if(!array_key_exists($name,$classArr)){
            return false;
        }
        $class = $classArr[$name];
        return $needInstance == true ? (new \ReflectionClass($class))->newInstanceArgs($param) : $class;
    }
}