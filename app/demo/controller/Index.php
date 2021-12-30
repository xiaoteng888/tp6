<?php


namespace app\demo\controller;


use app\BaseController;
use app\Request;
use app\common\business\UserBusiness;

class Index extends BaseController
{
    public function abc(Request $request,UserBusiness $userBusiness)
    {
        $category_id = $request->param('category_id',0,"intval");
        /*if(empty($category_id)){
            return msg(config("statusCode.error"),"参数错误",null,422);
        }*/
        $users = $userBusiness->getUserDataByAge($category_id);
        return msg(config("statusCode.success"),"OK获取成功",$users,200);
    }
}