<?php


namespace app\demo\controller;


use app\BaseController;
use app\Request;
use think\exception\HttpException;

class E extends BaseController
{
    public function index()
    {
        //throw new HttpException(404,'找不到数据');



    }

    public function demo(Request $request)
    {
        echo $request->name;
        return $request->name;
    }
    public function middle(Request $request)
    {
        echo $request->name;
        return $request->name;
    }
}