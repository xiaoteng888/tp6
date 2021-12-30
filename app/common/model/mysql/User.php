<?php
namespace app\common\model\mysql;

use think\Model;

class User extends Model{
    public function getFullNameAttr($value,$data)
    {
        return $data['name'].'年龄'.$data['age'];
    }

    public function getUserDataByAge($age,$limit = 10)
    {
        if(empty($age)){
            return $this;
        }
        $users = $this->where('age',$age)
            ->limit($limit)
            ->order('id','desc')
            ->select();
        return $users;
    }
}