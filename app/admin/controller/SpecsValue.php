<?php


namespace app\admin\controller;

use app\admin\validate\SpecValueValidate;
use app\Request;
use app\common\business\SpecsValueBusiness;
use think\Exception;

class SpecsValue extends AdminBase
{
    public function getBySpecsId(Request $request)
    {
        $spec_id = $request->param('spec_id',0,'intval');
        if(!$spec_id){
            return msg('statusCode.error','没有数据哦');
        }
        $values = (new SpecsValueBusiness())->getValuesBySpecid($spec_id);
        return msg(config('statusCode.success'),'OK',$values);
    }

    public function save(Request $request)
    {
        $name = $request->param('name','','string');
        $spec_id = $request->param('spec_id',0,'intval');
        $data = [
            'name' => $name,
            'spec_id' => $spec_id,
        ];
        $spec_value_validate = new SpecValueValidate();
        if(!$spec_value_validate->check($data)){
            return msg(config('statusCode.error'),$spec_value_validate->getError());
        }

        $res = (new SpecsValueBusiness())->add($data);

        if(!$res){
            return msg(config('statusCode.error'),'新增失败');
        }
        return msg(config('statusCode.success'),'新增成功');
    }

    public function del(Request $request)
    {
        $id = $request->param('id',0,'intval');
        if(!$id){
            return msg(config('statusCode.error'),'数据不存在');
        }
        $res = (new SpecsValueBusiness())->del($id);
        if(!$res){
            return msg(config('statusCode.error'),'删除失败');
        }
        return msg(config('statusCode.success'),'删除成功');
    }
}