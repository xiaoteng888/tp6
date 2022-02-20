<?php
/**
 * 该文件主要存放业务状态码相关配置
 */
return [
    'success' => 1,
    'edit_success' => 3,
    'error' => 0,
    'not_login' => -1,
    'user_is_register' => -2,
    'action_is_not_found' => -3,
    'controller_is_not_found' => -4,
    'is_login'   => 2,

    //mysql状态码
    "mysql" => [
        'table_normal' => 1,  //正常
        'table_pending' => 0, //待审核
        'table_delete' => 2, //已删除
        //redis token过期时间
        "stype_0"        => 7,// 缓存7天
        "stype_1"        => 30,// 缓存30天
    ],

];
