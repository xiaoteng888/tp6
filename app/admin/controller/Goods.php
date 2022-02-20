<?php


namespace app\admin\controller;


use app\admin\validate\GoodsValidate;
use app\common\business\GoodsBusiness;
use app\Request;
use think\facade\View;

class Goods extends AdminBase
{
    public function index(Request $request)
    {
        $title = $request->param('title','','trim');
        $time = $request->param('time','','trim');
        $data = [];
        if(!empty($title)) {
            $data['title'] = $title;
        }
        if(!empty($time)) {
            $data['create_time'] = explode(" - ", $time);
        }
        $goods = (new GoodsBusiness())->getGoods($data,10);
        $status = \app\common\model\mysql\Goods::$statusMap;
        $recommentStatus = \app\common\model\mysql\Goods::$recommentMap;
//var_dump($goods);exit;
        return View::fetch('',[
            'goods' => $goods,
            'status'  => $status,
            'recomment_status' => $recommentStatus,
        ]);
    }

    public function add()
    {
        return View::fetch();
    }

    public function save(Request $request)
    {
        if(!$request->isPost()){
            return msg(config('statusCode.error'),'非法请求');
        }
        $data = $request->param();

        $data['cate_path'] = $data['category_id'];
        $arr = explode(',',$data['category_id']);
        $data['category_id'] = end($arr);
        $data['promotion'] = &$data['promotion_title'];
        unset($data['promotion_title']);
        $data['unit'] = $data['goods_unit'];
        unset($data['goods_unit']);
        $data['make_time'] = $data['production_time'];
        unset($data['production_time']);
        $data['goods_spec_type'] = $data['goods_specs_type'];
        unset($data['goods_specs_type']);
        $data['big_img'] = $data['big_image'];
        unset($data['big_image']);
        $data['carousel_img'] = $data['carousel_image'];
        unset($data['carousel_image']);
        $data['recommend_img'] = $data['recommend_image'];
        unset($data['recommend_image']);//var_dump($data);exit;
        $validate = new GoodsValidate();
        if(!$validate->check($data)){
            return msg(config('statusCode.error'),$validate->getError());
        }
        $token = $request->checkToken('__token__');
        if(!$token){
            return msg(config('statusCode.error'),'token不合法');
        }
        $res = (new GoodsBusiness())->addData($data);
        if(!$res){
            return msg(config('statusCode.error'), "商品新增失败");
        }
        return msg(config('statusCode.success'), "商品新增成功");
    }

    public function changeStatus(Request $request)
    {
        $id = $request->param('id',0,'intval');
        $status = $request->param('status',0,'intval');
        if(!$id){
            return msg(config('statusCode.error'),'参数不合法');
        }
        $res = (new GoodsBusiness())->changeGoodsStatus($id,['status' => $status]);
        if(!$res){
            return msg(config('statusCode.error'),'修改状态失败');
        }
        return msg(config('statusCode.success'),'修改状态成功');
    }

    public function changeRecomment(Request $request)
    {
        $id = $request->param('id',0,'intval');
        $recomment = $request->param('recomment',0,'intval');
        if(!$id){
            return msg(config('statusCode.error'),'参数不合法');
        }
        $res = (new GoodsBusiness())->changeGoodsStatus($id,['is_index_recommend' => $recomment]);
        if(!$res){
            return msg(config('statusCode.error'),'修改推荐失败');
        }
        return msg(config('statusCode.success'),'修改推荐成功');
    }

}