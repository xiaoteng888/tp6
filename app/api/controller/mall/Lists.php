<?php


namespace app\api\controller\mall;


use app\api\controller\ApiBase;
use app\common\business\GoodsBusiness;
use app\common\lib\Msg;
use app\Request;

class Lists extends ApiBase
{
    public function index(Request $request)
    {
        $category_id = $request->param('category_id',0,'intval');
        $page_size = $request->param('page_size',0,'intval');
        if(!$category_id){
            return Msg::success();
        }
        $data = [
            'cate_path' => $category_id,
        ];
        $field = $request->param('field','sortid','trim');
        $order = $request->param('order',2,'intval');
        $order = $order == 1 ? 'asc' : 'desc';
        $order = [$field => $order];
        $goods = (new GoodsBusiness())->getGoodsList($data,$page_size,$order);
        return Msg::success($goods);
    }
}