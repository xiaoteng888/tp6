<?php

namespace app\common\business;

use app\common\model\mysql\User;

class UserBusiness {
    /**
     * 通过$category_id在User模型获取数据
     * @param $category_id 年龄
     * @return User|User[]|array|\think\Collection|\think\response\Json
     */
    public function getUserDataByAge($category_id)
    {
        $users = (new User())->getUserDataByAge($category_id);
        if(!$users){
            return [];
        }
        $categorys = config("category");
        foreach($users as $key=>$user){
            if($user->age > 0 && $user->age <= 12){
                $user->age = 1;
            }elseif($user->age > 12 && $user->age <= 18){
                $user->age = 2;
            }elseif($user->age > 18 && $user->age <= 30){
                $user->age = 3;
            }elseif($user->age > 30 && $user->age <= 45){
                $user->age = 4;
            }
            $users[$key]['category_name'] = $categorys[$user->age] ?? "其他年龄段";
        }
        return $users;
    }
}
