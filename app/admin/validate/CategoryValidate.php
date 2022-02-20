<?php


namespace app\admin\validate;


use think\Validate;

class CategoryValidate extends Validate
{
    protected $rule = [
        'name' => 'require|unique:category,name',
        'pid'  => 'require|number',
    ];

    protected $message = [
        'name.require' => '分类名不能为空',
        'name.unique' => '分类名已经存在',
        'pid.require'  => '父类不能为空',
        'pid.number'   => '父类错误',
    ];

    protected $scene = [
        'add' => ['name','pid'],
    ];
}