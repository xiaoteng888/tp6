<?php

namespace app\common\lib;

class Key{
    public static function cartKey($userId)
    {
        return config('redis.cart_pre').$userId;
    }
}