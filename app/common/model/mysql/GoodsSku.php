<?php


namespace app\common\model\mysql;


use think\Model;

class GoodsSku extends BaseModel
{

    public function goods()
    {
        return $this->BelongsTo(Goods::class,'goods_id','id');
    }

    public function getNormalSkusByGoodsId($goods_id,$field = true)
    {
        $where = [
            'goods_id' => $goods_id,
            'status' => self::STATUS_NORMAL,
        ];
        return $this->where($where)->field($field)->select();
    }
}