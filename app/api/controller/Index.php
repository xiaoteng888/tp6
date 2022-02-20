<?php


namespace app\api\controller;

use app\BaseController;
use app\common\business\GoodsBusiness;
use app\common\lib\Msg;

class Index extends ApiBase
{
    public function getRotationChart()
    {
        $recommend_imgs = (new GoodsBusiness())->getRecommendImg();
        return Msg::success($recommend_imgs);
    }

    public function cagegoryGoodsRecommend()
    {
        $recommend_goods = (new GoodsBusiness())->getRecommendGoods();
        return Msg::success($recommend_goods);
    }
}