<?php

namespace app\common\lib\sms;

use think\Service;
use Overtrue\EasySms\EasySms;

/**
 * 应用服务类
 */
class EasysmsService extends Service
{
    public function register()
    {
        // 短信配置服务注册
        $sms = new EasySms(config('easysms'));
        $this->app->bind('sms',$sms);
        //return

    }

    public function boot()
    {
        // 服务启动
    }
}
