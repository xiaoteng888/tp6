<?php


namespace app\api\validate;

use think\Validate;

class SmsValidate extends Validate
{
    protected $rule = [
        'phone_number' => 'require|mobile',
        'username'     => 'require',
        'code'         => 'require|min:4|max:6',
        'ltype'        => 'require|in:0,1',
        'stype'        => 'require|in:0,1',
        'code_key'     => 'require',
        'password'     => 'require',
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'phone_number.require'  => '电话号不能为空',
        'phone_number.mobile'  => '电话号不正确',
        'code.require'  => '验证码不能为空',
        'code.min'  => '验证码最短4位',
        'code.max'  => '验证码最长6位',
        'ltype.require'  => '登录类型不能为空',
        'ltype.in'  => '登录类型不存在',
        'stype.require'  => '保存类型不能为空',
        'stype.in'  => '保存类型不存在',
        'code_key.require'  => '验证码KEY不能为空',
        'password.require'  => '密码不能为空',

    ];

    protected $scene = [
        'only_phone' => ['phone_number'],
        'phone_login'      => ['phone_number','code','ltype','stype','code_key'],
        'login'      => ['username','password','ltype','stype'],
    ];
}