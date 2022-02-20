<?php


namespace app\common\business;

use Overtrue\EasySms\EasySms;
use think\facade\Log;
use think\helper\Str;
use app\common\lib\ClassArr;
class SmsBusiness
{
    public function send($phone,$len,$type)
    {
        $sms = app('sms');
        $classArr = ClassArr::getLibClassArr();
        $numClass = ClassArr::getClass('num',$classArr);
        if (env('appenv.app_env') !== 'production') {

            $code = $numClass::getCode($len);
            $msg =  "测试环境发送成功";
            Log::info("sendSmsCode-res-{$phone}".$msg);
        } else {

            $code = $numClass::getCode($len);
            try {
                $data = $sms->send($phone, [
                    'template' => 'SMS_174806102',
                    'data' => [
                        'code' => $code,
                    ],
                ],$type);
                Log::info("sendSmsCode-res-{$phone}".json_encode($data->toArray()));
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('aliyun')->getMessage();
                Log::error("sendSmsCode-error-{$phone}".$message);
                abort(500, $message ?: '短信发送异常');
            }
        }
        $key = config('redis.code_pre').Str::random(15);
        $exp = config('redis.code_exp');
        cache($key,['phone'=> $phone,'code' => $code],$exp);
        cache(config('redis.code_pre').$phone,$phone,config('redis.send_limit_exp'));
        return [
            'key' => $key,
            'expired_at' => date('Y-m-d H:i:s',time() + $exp),
        ];
    }
}