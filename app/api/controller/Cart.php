<?php


namespace app\api\controller;


use app\common\business\CartBusiness;
use app\common\lib\Msg;
use app\Request;
use think\facade\Cache;

class Cart extends AuthBase
{
    public function add(Request $request)
    {
        $sku_id = $request->param('id',0,'intval');
        $num = $request->param('num',0,'intval');
        if(!$sku_id || !$num){
            return Msg::error();
        }

        $res = (new CartBusiness())->addRedisCart($sku_id,$num,$this->userId);
        if($res === FALSE){
            return Msg::error();
        }
        return Msg::success();
    }
}