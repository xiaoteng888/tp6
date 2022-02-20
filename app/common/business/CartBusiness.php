<?php


namespace app\common\business;



use app\common\lib\Key;
use think\facade\Cache;
use think\Log;

class CartBusiness extends BusinessBase
{
    public function addRedisCart($sku_id,$num,$userId)
    {
        $goods_sku = (new GoodsSkuBusiness())->getNormalGoodsAndSku($sku_id);
        if(!$goods_sku){
            return FALSE;
        }
        $data = [
            'title' => $goods_sku['goods']['title'],
            'image' => $goods_sku['goods']['recommend_img'],
            'num'  => $num,
            'goods_id' => $goods_sku['goods']['id'],
            'create_time' => time(),
        ];
        try {
            $getData = Cache::hGet(Key::cartKey($userId),$sku_id);
            if($getData){
                $getData = json_decode($getData,true);
                $data['num'] = $getData['num'] + $data['num'];
            }
            $res = Cache::hSet(Key::cartKey($userId),$sku_id,json_encode($data));
        }catch (\Exception $e){
            \think\facade\Log::record($e->getMessage());
            return FALSE;
        }

        return $res;
    }
}