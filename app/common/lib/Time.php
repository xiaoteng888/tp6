<?php


namespace app\common\lib;


class Time
{
    public static function getTokenExp($stype)
    {
        $stype = "stype_".$stype;
        $token_exp = 3600 * 24 * config('statusCode.mysql.'.$stype);
        return $token_exp;
    }
}