<?php


namespace app\api\controller;


class Logout extends AuthBase
{
    public function index()
    {
        //删除redis缓存
        $res = cache(config('redis.token_pre').$this->accessToken,null);
        if($res){
            return msg(config('statusCode.success'),'退出成功');
        }
        return msg(config('statusCode.error'),'退出失败');
    }
}