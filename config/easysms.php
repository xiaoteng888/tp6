<?php

return [
    // HTTP 请求的超时时间（秒）
    'timeout' => 10.0,

    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            'access_key_id' => env('sms.sms_aliyun_access_key_id'),
            'access_key_secret' => env('sms_aliyun_access_key_secret'),
            'sign_name' => '高并发商城',
        ],
        'yunpian' => [
            'api_key' => '',
            'signature' => '【默认签名】', // 内容中无签名时使用
        ],
    ],
];