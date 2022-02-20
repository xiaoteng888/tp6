<?php


namespace app\admin\validate;


use think\Validate;

class GoodsValidate extends Validate
{
    protected $rule = [
        'title' => 'require',
        'category_id' => 'require|integer',
        'promotion' => 'require',
        //'goods_unit' => 'require',
        'make_time' => 'require',
        'goods_spec_type' => 'require|in:1,2',
        'carousel_img' => 'require',
        'recommend_img' => 'require',
        'sub_title' => 'require',
        // 当goods_specs_type的值等于2的时候 skus必须
        'skus'=>'requireIf:goods_spec_type,2',
        'description' => 'require',
    ];

    protected $message = [
        'title.require' => '请输入商品名称',
        'category_id.require' => '请选择商品分类',
        'promotion.require' => '请输入商品促销语',
        //'goods_unit.require' => '',
        'make_time.require' => '请输入商品生成日期',
        'goods_spec_type.require' => '请选择商品规格',
        'goods_spec_type.in' => '商品规格错误',
        'carousel_img.require' => '请上传轮播图',
        'recommend_img.require' => '请上传推荐图',
        'skus.requireIf' => '商品SKU不能为空',
        'sub_title.require' => '请输入商品副标题',
        'description.require' => '请输入商品详情',
    ];
}