<?php


namespace app\common\model\mysql;


use think\Model;

class Goods extends BaseModel
{
    //推荐状态
    const STATUS_RECOMMEND_OPEN = 1;
    const STATUS_RECOMMEND_OFF = 2;
    //规格
    const SPEC_TYPE_ONE = 1;
    const SPEC_TYPE_MANY = 2;

    public static $recommentMap = [
        'open' => self::STATUS_RECOMMEND_OPEN,
        'off' => self::STATUS_RECOMMEND_OFF,
    ];

    public function getImageAttr($value)
    {
        //return request()->domain().$value;
        return 'http://'.$_SERVER["SERVER_NAME"].$value;
    }

    public function getCarouselImgAttr($value)
    {
        $value = explode(',',$value);
        $value = array_map(function($v){
            return 'http://'.$_SERVER["SERVER_NAME"].$v;
        },$value);
        return $value;
    }

    public function getFindInSet($id,$field,$limit=10)
    {
        $order = ['id => desc'];
        return $this->whereFindInSet('cate_path',$id)
            ->where('status',self::STATUS_NORMAL)
            ->field($field)
            ->order($order)
            ->limit($limit)
            ->select();
    }

    public function getGoodsList($data,$num,$field=true,$order)
    {
        $res = $this;
        if(isset($data['cate_path'])){
            $res = $res->whereFindInSet('cate_path',$data['cate_path']);
        }else{
            $res = $res->where($data);
        }
        return $res->where('status',self::STATUS_NORMAL)->field($field)->order($order)->paginate($num);
    }
}