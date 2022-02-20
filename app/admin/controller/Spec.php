<?php


namespace app\admin\controller;


use think\facade\View;

class Spec extends AdminBase
{
    public function dialog()
    {
        return View::fetch('',[
            'specs' => json_encode(config('spec')),
        ]);
    }
}