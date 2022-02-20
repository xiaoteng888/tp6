<?php
namespace app\common\model\mysql;

use think\Model;

class User extends BaseModel {

    //用户性别
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;
    const SEX_SECRET = 0;


    public static $userSexMap = [
        self::SEX_MALE => '男',
        self::SEX_FEMALE => '女',
        self::SEX_SECRET => '保密',
    ];

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

    /**
     * 通过$phone在User模型获取数据
     * @param $phone 手机号
     * @return User|User[]|array|\think\Collection|\think\response\Json
     */
    public function getUserByPhone($phone)
    {
        return $this->where('phone_number',$phone)->find();

    }

    public function getUserById($id)
    {
        return $this->where('id',$id)->find();
    }

    public function updateById($id,$data)
    {
        $where = [
            'id' => $id,
        ];
        return $this->where($where)->update($data);
    }
}