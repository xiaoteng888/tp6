<?php


namespace app\admin\controller;


use app\admin\validate\CategoryValidate;
use app\common\lib\Arr;
use app\Request;
use think\Exception;
use think\facade\View;
use app\common\business\CategoryBusiness;
use app\common\model\mysql\Category as ModelCategory;

class Category extends AdminBase
{
    public function index(Request $request)
    {
        $pid = $request->param('pid',0,'intval');
        try {
            $categories = (new CategoryBusiness())->getNomarlByPid($pid,20);
            $nav = (new CategoryBusiness())->getNav($pid);
        }catch(\Exception $e){
            //return [];
            $categories =  Arr::getDefaultPaginate(2);
            $nav = '';
        }
        //var_dump($nav);exit;
//var_dump($categories);exit;
        return View::fetch('',[
            'categories' => $categories,
            'normal' => ModelCategory::STATUS_NORMAL,
            'del' => ModelCategory::STATUS_DEL,
            'pid' => $pid,
            'nav' => $nav,
        ]);
    }

    public function add(Request $request)
    {
        $field = "id,pid,name";
        $categories = (new CategoryBusiness())->getNomarlCategories($field);
        $id = $request->param('id',0,'intval');
        //$name = $request->param('name','','intval');var_dump($name);exit;
        if($id){
            try {
                $category = (new CategoryBusiness())->getById($id);
            }catch (\Exception $e){
                return msg(config('statusCode.error'),$e->getMessage());
            }

        }
        $res = isset($category) ? $category->toArray() : ['pid'=> 0,'name'=>'','id' => $id];//var_dump($category);exit;
        return View::fetch('',[
            'categories' => json_encode($categories),
            'category'  => $res,
        ]);
    }

    public function save(Request $request)
    {
        $name = $request->param('name','','trim');
        $pid = $request->param('pid',0,'intval');
        $id = $request->param('id',0,'intval');
        $data = [
            'name' => $name,
            'pid'  => $pid,
        ];
        $categoryValidate = (new CategoryValidate())->scene('add');
        if(!$categoryValidate->check($data)){
            return msg(config('statusCode.error'),$categoryValidate->getError());
        }
        if($id){
            $data['id'] = $id;
        }
        try {
            $res = (new CategoryBusiness())->add($data);
        }catch (\Exception $e){
            return msg(config('statusCode.error'),$e->getMessage());
        }

        if($res){
            if(isset($res['code']) && $res['code'] == config('statusCode.edit_success')){
                return msg(config('statusCode.success'),'编辑成功');
            }
            return msg(config('statusCode.success'),'添加成功');
        }
        return msg(config('statusCode.error'),'添加失败');
    }

    public function cateSort(Request $request)
    {
        $sort = $request->param('sort',0,'intval');
        $id = $request->param('id',0,'intval');
        if(!$id){
            return msg(config('statusCode.error'),'参数错误');
        }

        $data = [
            'sort' => $sort,
        ];
        try {
            $res = (new CategoryBusiness())->cateSort($id,$data);
        }catch (Exception $e){
            return msg(config('statusCode.error'),$e->getMessage());
        }
        if(!$res){
            return msg(config('statusCode.error'),'排序失败');
        }
        return msg(config('statusCode.success'),'排序成功');

    }

    public function changeStatus(Request $request)
    {
        $id = $request->param('id',0,'intval');
        $status = $request->param('status',0,'intval');

        if(!$id || !in_array($status,array_keys(\app\common\model\mysql\Category::$statusMap))){
            return msg(config('statusCode.error'),'参数错误');
        }

        $data = [
            'status' => $status,
        ];

        try {
            $res = (new CategoryBusiness())->changeStatus($id,$data);
        }catch (Exception $e){
            return msg(config('statusCode.error'),$e->getMessage());
        }

        if(!$res){
            return msg(config('statusCode.error'),'修改状态失败');
        }
        return msg(config('statusCode.success'),'修改状态成功');
    }

    public function dialog()
    {
        $categories = (new CategoryBusiness())->getCateByPid();
        return View::fetch('',[
            'categories' => json_encode($categories),
        ]);
    }

    public function getByPid(Request $request)
    {
        $pid = $request->param('pid',0,'intval');
        $categories = (new CategoryBusiness())->getCateByPid($pid);
        return msg(config('statusCode.success'),'OK',$categories);
    }

}