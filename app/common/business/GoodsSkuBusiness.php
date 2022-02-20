<?php


namespace app\common\business;


use app\common\model\mysql\Goods;
use app\common\model\mysql\GoodsSku;
use think\Exception;
use think\facade\Cache;
use think\facade\Log;

class GoodsSkuBusiness extends BusinessBase
{
    protected $model = null;

    public function __construct()
    {
        $this->model = new GoodsSku();
    }

    public function saveAll($data)
    {
        if(!$data['skus']){
            return false;
        }
        foreach ($data['skus'] as $v){
            $dataArr[] = [
                'goods_id' => $data['goods_id'],
                'spec_val_ids' => $v['propvalnames']['propvalids'],
                'price' => $v['propvalnames']['skuSellPrice'],
                'old_price' => $v['propvalnames']['skuMarketPrice'],
                'stock' => $v['propvalnames']['skuStock'],
            ];
        }
        try {
            $res = $this->model->saveAll($dataArr);

        }catch (Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res->toArray();
    }

    public function getNormalGoodsAndSku($sku_id)
    {
        try {
            $sku_goods = $this->model->with('goods')->find($sku_id);
            //$sku_goods->load(['goods']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [];
        }
        if (!$sku_goods || $sku_goods->status !== GoodsSku::STATUS_NORMAL) {
            return [];
        }
        if (!$sku_goods['goods']) {
            return [];
        }
        return $sku_goods;
    }

    public function detailData($sku_id)
    {
        $sku_goods= $this->getNormalGoodsAndSku($sku_id);
        $sku_goods = $sku_goods->toArray();
        $goods = $sku_goods['goods'];
        $skus = $this->model->getNormalSkusByGoodsId($goods['id']);
        if(!$skus){
            return [];
        }
        $gids = array_column($skus->toArray(),'id','spec_val_ids');
        if($goods['goods_spec_type'] == Goods::SPEC_TYPE_ONE){
            $sku = [];
        }else{

            $sku = (new SpecsValueBusiness())->getSkuSpeValue($gids,$sku_goods['spec_val_ids']);
        }
        $key = "tp_pv_".$goods['id'];
        Cache::inc($key);
        return [
            'title' => $goods['title'],
            'price' => $sku_goods['price'],
            'cost_price' => $sku_goods['old_price'],
            'sales_count' => $goods['sold_count'],
            'stock' => $sku_goods['stock'],
            'gids' => $gids,
            'image' => $goods['carousel_img'],
            'sku' => $sku,
            'detail' => [
                'd1' => [
                    '商品编码' => '',
                    '上架时间' => $goods['make_time'],
                ],
                'd2' => preg_replace('/(<img.+?src=")(.*?)/','$1'.$_SERVER["SERVER_NAME"].'$2',$goods['description']),
            ],
        ];
    }
}