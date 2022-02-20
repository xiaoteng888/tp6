<?php


namespace app\api\controller\mall;


use app\api\controller\ApiBase;
use app\common\business\GoodsSkuBusiness;
use app\common\lib\Msg;

class Detail extends ApiBase
{
    public function index($id)
    {
        $sku_id = intval($id);
        $sku_data = (new GoodsSkuBusiness())->detailData($sku_id);
        //halt($sku_data);
        return Msg::success($sku_data);
    }
}