<?php


namespace app\common\business;


use app\common\model\mysql\Category;
use think\Exception;
use think\facade\Log;

class CategoryBusiness extends BusinessBase
{
    public $model = null;
    public function __construct()
    {
        $this->model = new Category();
    }

    public function add($data)
    {
        if(isset($data['id'])){
            $category = $this->getById($data['id']);
            try {
                $category->save($data);
            }catch (Exception $e){
                Log::record($e->getMessage());
                return false;
            }
            return ['id' => $category->id,'code' => config("statusCode.edit_success")];
        }
        $data['status'] = Category::STATUS_NORMAL;
        $this->model->save($data);
        return $this->model->id;
    }

    public function getNomarlCategories($field,$order='')
    {
        $categories = $this->model->getNomarlCategories($field,$order);
        if(!$categories){
            return $categories;
        }

        return $categories->toArray();
    }

    public function getNomarlByPid($pid,$num)
    {
        $categories = $this->model->getNomarlByPid($pid,$num);
        //throw new Exception('abc');
        if(!$categories){
            return $categories;
        }

        $res = $categories->toArray();
        $res['render'] = $categories->render();

        $pids = array_column($res['data'],'id');
        $cate_total = $this->model->getTotalByPid($pids);
        $arr = [];
        foreach ($cate_total as $k => $v){

            $arr[$v['pid']] = $v['total'];
        }

        foreach($res['data'] as $k => $v){
            $res['data'][$k]['total'] = $arr[$v['id']] ?? 0;
        }
        return $res;
    }

    public function cateSort($id,$data)
    {
        $category = $this->getById($id);
        /*if(!$category){
            throw new Exception('不存在该条记录');
        }*/
        try {
            $res = $category->save($data);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }

    public function getById($id)
    {
        $category = $this->model->find($id);
        if(!$category){
            throw new Exception('不存在该条记录');
        }
        return $category;
    }

    public function changeStatus($id,$data)
    {
        $category = $this->getById($id);
        try {
            $res = $category->save($data);
        }catch (Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }

    public function getNav($pid,&$arr = [])
    {
        if($pid > 0){
            $category = $this->getById($pid);//var_dump($category->toArray());exit;
            $arr[] = $category->toArray();
            $this->getNav($category->pid,$arr);
        }
        return array_reverse($arr);
    }

    public function getCateByPid($pid=0,$field='id,name,pid')
    {
        try {
            $categories = $this->model->getCateByPid($pid,$field);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return [];
        }
        return $categories->toArray();
    }

    public function getCategoriesByPid($pid)
    {
        $data = [];
        try {
            $category = $this->getById($pid);
        }catch (Exception $e){
            return [];
        }

        $data['name'] = $category->name;
        if($category->level == 2){
            $pid = $category->pid;
        }
        $twoCate = '';
        if($category->level == 3){
            $pid = $category->pid;
            $twoCate = $this->getById($pid);
        }
        $categories = $this->getCateByPid($pid);
        if(!$categories){
            $data['focus_ids'] = [];
            $data['list'] = [];
        }

        if($twoCate){
            $pid = $twoCate->pid;
            $twoData = $this->getCateByPid($pid);
            if(!$twoData){
                $data['focus_ids'] = [];
                $data['list'] = [];
            }
            $data['list'][] = $twoData;
            $data['focus_ids'][] = $twoCate['id'];
        }
        $data['list'][] = $categories;
        $data['focus_ids'][] = $category['id'];
        return $data;
    }

    public function getSubByPid($pid)
    {
        $subs = $this->getCateByPid($pid);
        return $subs;
    }
}