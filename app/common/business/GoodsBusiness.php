<?php


namespace app\common\business;


use app\common\lib\Arr;
use app\common\model\mysql\Goods;
use think\Exception;
use think\facade\Log;

class GoodsBusiness extends BusinessBase
{
    protected $model = null;

    public function __construct()
    {
        return $this->model = new Goods();
    }

    public function addData($data)
    {
        try {
            $this->model->startTrans();
            $goods = $this->add($data);
            if (!$goods) {
                return $goods;
            }
            if ($data['goods_spec_type'] == 1) {
                return true;
            }
            $data['goods_id'] = $this->model->id;
            $res = (new GoodsSkuBusiness())->saveAll($data);

            if ($res) {
                $data = [
                    'stock' => array_sum(array_column($res, 'stock')),
                    'price' => min(array_column($res, 'price')),
                    'old_price' => max(array_column($res, 'old_price')),
                ];

                $goods = $this->add($data);
                if (!$goods) {
                    throw new Exception('更新主表失败');
                }
            } else {
                throw new Exception('SKU新增失败');
            }
            $this->model->commit();
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $this->model->rollback();
            return false;
        }
        return true;
    }

    public function getGoods($data,$num,$order = 'id desc')
    {
        $keys = [];
        if($data){
            $keys = array_keys($data);
        }
        $goods = $this->getPaginateData($keys,$data,$num,$order);
        if(!$goods){
            return Arr::getDefaultPaginate($num);
        }
        return $goods->toArray();
    }

    public function changeGoodsStatus($id,$status)
    {
        return $this->updateById($id,$status);
    }

    public function getRecommendImg()
    {
        $where = [
            'status' => Goods::STATUS_NORMAL,
            'is_index_recommend' => Goods::STATUS_RECOMMEND_OPEN,
        ];
        $field = "sku_id as id,title,big_img as image";
        $recommend_imgs = $this->getData($where,$field);
        if(!$recommend_imgs){
            return [];
        }
        return $recommend_imgs->toArray();
    }

    public function getRecommendGoods()
    {
        $cate_ids = [
            1,
            2,
        ];
        $goods = [];
        $field = 'id as category_id,name,pid';
        foreach ($cate_ids as $k => $cate_id){
            $data = (new CategoryBusiness())->getNormalById($cate_id,$field);
            if(!$data){
                $goods[$k]['categorys'] = [];
            }else{
                $goods[$k]['categorys'] = $data->toArray();
            }
        } //var_dump($goods[1]);exit;
        $field = 'sku_id as id,title,price,recommend_img as image';
        foreach ($cate_ids as $k => $cate_id){
            $data = $this->getFindInSet($cate_id,$field);
            if(!$data){
                $goods[$k]['goods'] = [];
            }else{
                $goods[$k]['goods'] = $data->toArray();
            }

        }
        return $goods;
    }

    public function getGoodsList($category_id,$page_size,$order)
    {
        try {
            $field = "id as sortid,sku_id as id, title, recommend_img as image,price";
            $goods = $this->model->getGoodsList($category_id,$page_size,$field,$order);
        }catch (Exception $e){
            Log::error($e->getMessage());
            return [];
        }
        if(!$goods){
            return [];
        } //echo $this->model->getLastSql();exit;
        $res = $goods->toArray();
        return [
            'total_page_num' => $res['last_page'],
            'count' => $res['total'],
            'page' => $res['current_page'],
            'page_size' => $res['per_page'],
            'list' => $res['data'],
        ];
    }

}