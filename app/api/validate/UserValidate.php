<?php


namespace app\api\validate;

use think\Validate;
class UserValidate extends Validate
{
    protected $rule = [
        'nickname' => 'require|max:16|min:4',
        'sex'      => 'require|in:0,1,2',
        'username' => 'require|unique:user,username|min:6|max:16'
    ];

    protected $message = [
        'nickname.require' => '昵称不能为空',
        'nickname.max' => '昵称最多16位',
        'nickname.min' => '昵称最少4位',
        'sex.require' => '性别不能为空',
        'sex.in' => '性别错误',
        'username.require' => '帐号不能为空',
        'username.unique' => '帐号已经存在',
        'username.min' => '帐号最少4位',
        'username.max' => '帐号最多16位',
    ];

    protected $scene = [
        'update_user' => ['nickname','username','sex'],
    ];
}