<?php

namespace app\common\business;

use app\common\lib\Str;
use app\common\lib\Time;
use app\common\model\mysql\User;
use think\Exception;
use think\facade\Cache;

class UserBusiness {

    public $userModel = null;
    public function __construct()
    {
        $this->userModel = new User();
    }



    public function login($data)
    {
        if($data['ltype'] == 1) {
            $redisCode = cache($data['code_key']);//var_dump($redisCode);exit;
            if (!$redisCode) {
                abort(403, '验证码已失效');
            }
            if (!hash_equals($redisCode['code'], $data['code'])) {
                throw new Exception('验证码不正确', 401);
            }
            $user = $this->userModel->getUserByPhone($data['phone_number']);
            try{
                    if(!$user){//var_dump($data);exit;
                        $data['nickname'] = "幸运用户".\think\helper\Str::random(6);
                        $data['sex'] = User::SEX_SECRET;
                        $this->userModel->save($data);
                        $userId = $this->userModel->id;
                        $nickname = $data['nickname'];
                    }else{
                        $user->save($data);
                        $userId = $user->id;
                        $nickname = $user->nickname;
                    }
              }catch (Exception $e) {
                    throw new Exception($e->getMessage());

            }
            $token = Str::getLoginToken($data['phone_number']);
            $token_exp = Time::getTokenExp($data['stype']);
            $data = [
                'id' => $userId,
                'phone' => $data['phone_number'],
            ];
            $res = cache(config('redis.token_pre').$token,$data,$token_exp);
            //var_dump($res);exit;
        }else{

        }
        return $res ? ['token' => $token,'username' => $nickname] : false;
    }

    public function getNormalUserById($id)
    {
        $user = $this->userModel->getUserById($id);
        if(!$user || $user['statu'] !== $this->userModel::STATUS_NORMAL){
            return false;
        }
        return $user;
    }

    public function update($id,$data,$token)
    {
        //unset($data['id']);
        $user = $this->getNormalUserById($id);
        if(!$user){
            throw new Exception('不存在该用户');
        }
        $res = $user->save($data);
        if($res) {
            $username = isset($user->username) ? $user->username : $user->phone_number;
            $data = [
                'id' => $user->id,
                'username' => $username,
            ];
            $key = config('redis.token_pre') . $token;
            Cache::set($key, $data);
        }
        return $res;
        //return $this->userModel->updateById($id,$data);
    }
}
