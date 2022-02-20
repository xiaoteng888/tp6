<?php


namespace app\api\controller;

use app\common\business\UserBusiness;
use app\Request;
use app\api\validate\UserValidate;
use think\facade\Cache;

class User extends AuthBase
{
    public function index()
    {
        $user = (new UserBusiness())->getNormalUserById($this->userId);
        $user = $user->toArray();
        $user = [
            'nickname' => $user['nickname'],
            'sex' => $user['sex'],
            'id'  => $user['id'],
        ];
        return msg(config('statusCode.success'),'OK',$user);
    }

    public function update($id,Request $request)
    {
        /*if($id !== $this->userId){
            return msg(config('statusCode.error'),'非法请求');
        }*/
        $username = $request->param('username','','trim');
        $nickname = $request->param('nickname','kobe','trim');
        $sex = $request->param('sex','','intval');
        $data = [
            'id'       => $this->userId,
            'username' => $username,
            'nickname' => $nickname,
            'sex' => $sex,
        ];
        $userValidate = (new UserValidate())->scene('update_user');
        $res = $userValidate->check($data);
        if(!$res){
            return msg(config('statusCode.error'),$userValidate->getError());
        }
        $user = (new UserBusiness())->update($this->userId,$data,$this->accessToken);
        if(!$user){
            return msg(config('statusCode.error'),'修改失败');
        }

        return msg(config('statusCode.success'),'修改成功');
    }

    public function logout()
    {
        //删除redis缓存
        $res = cache(config('redis.token_pre').$this->accessToken,null);
        if($res){
            return msg(config('statusCode.success'),'退出成功');
        }
        return msg(config('statusCode.error'),'退出失败');
    }
}