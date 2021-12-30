<?php


namespace app\admin\validate;


use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha' => 'require|captchaCheck',
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'password.require' => '密码不能为空',
        'captcha.require' => '验证码不能为空',
    ];

    protected function captchaCheck($value,$rule,$data = [])
    {
        if(!captcha_check($value)){
            return "验证码不正确";
        }
        return true;
    }
}