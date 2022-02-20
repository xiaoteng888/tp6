<?php


namespace app\admin\validate;


use think\Validate;

class SpecValueValidate extends Validate
{
    protected $rule = [
        'name' => 'require|unique:spec_value',
        'spec_id' => 'require|integer',
    ];

    protected $message = [
        'name.require' => '名称不能为空',
        'name.unique'  => '名称已经存在',
        'spec_id.require' => '规格不能为空',
        'spec_id.integer' => '规格类型错误',
    ];
}