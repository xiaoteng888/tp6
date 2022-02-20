<?php


namespace app\api\controller;

use app\BaseController;
use app\common\business\SmsBusiness;
use app\Request;
use app\api\validate\SmsValidate;
class Sms extends ApiBase
{
    public function send(Request $request)
    {
        $phone = $request->param('phone_number','','trim');
        //$have = cache(config('redis.code_pre').$phone);//var_dump($have);exit;
        if(!empty($have)){
            return msg(config('statusCode.error'),'请勿频繁请求');
        }
        $data = ['phone_number' => $phone];
        try{
            validate(SmsValidate::class)->scene('only_phone')->check($data);
        }catch(\think\exception\ValidateException $e){
            return msg(config('statusCode.error'),$e->getError());
        }
        $smsBusiness = new SmsBusiness();
        if(random_int(0,99) < 80){
            $type = ['aliyun'];
        }else{
            $type = ['yunpian'];
        }
        $data = $smsBusiness->send($phone,7,$type);
        if($data){
            return msg(config('statusCode.success'),'发送验证码成功',$data,201);
        }
        return msg(config('statusCode.error'),'发送验证码失败');
    }
}