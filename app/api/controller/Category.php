<?php


namespace app\api\controller;


use app\common\business\CategoryBusiness;
use app\common\lib\Arr;
use app\common\lib\Msg;
use app\Request;
use think\Exception;
use think\facade\View;

class Category extends ApiBase
{
    public function index()
    {
        try {
            $categories = (new CategoryBusiness())->getNomarlCategories('id as category_id,name,pid',["sort" => "desc",
                "id" => "desc"]);
        }catch (Exception $e){
            return $this->msg(config('statusCode.success'),'内部错误');
        }

        if(!$categories){
            return $this->msg(config('statusCode.success'),'数据为空');
        }

        $cateArr = Arr::getCateTree($categories);
        $cateArr = Arr::sliceCateTree($cateArr);
        return msg(config('statusCode.success'),'OK',$cateArr);
    }

    public function search($id=0)
    {
        $categories = (new CategoryBusiness())->getCategoriesByPid($id);
        return Msg::success($categories);
    }

    public function sub($id=0)
    {
        $subs = (new CategoryBusiness())->getSubByPid($id);
        return Msg::success($subs);
    }
}