<?php


namespace app\common\business;


use think\Exception;
use think\facade\Log;

class BusinessBase
{
    public function add($data)
    {
        try {
            $res = $this->model->save($data);
        }catch (Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }

    public function getPaginateData($keys,$data,$num,$order)
    {
        try {
            $res = $this->model->getPaginateData($keys,$data,$num,$order);
        }catch (\Exception $e){
            //echo $e->getMessage();
            Log::error($e->getMessage());
            return false;
        }
        //echo $this->model->getLastSql();exit;
        return $res;
    }

    public function updateById($id,$status)
    {
        try {
            $res = $this->model->updateById($id,$status);
        }catch (Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }

    public function getData($where,$field=true)
    {
        try {
            $res = $this->model->getModelData($where,$field);
        }catch (Exception $e){
            Log::info($e->getMessage());//echo $e->getMessage();exit;
            return false;
        }
        return $res;
    }

    public function getFindInSet($id,$field)
    {
        try {
            $res = $this->model->getFindInSet($id,$field);
        }catch (Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }

    public function getwhereInId($id,$field)
    {
        try {
            $res = $this->model->getwhereInId($id,$field);
        }catch (Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }

    public function getNormalById($id,$field)
    {
        try {
            $res = $this->model->getNormalById($id,$field);
        }catch (Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }
}