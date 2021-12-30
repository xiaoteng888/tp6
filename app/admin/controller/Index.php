<?php


namespace app\admin\controller;


use think\facade\View;

class Index extends AdminBase
{
    public function index()
    {
        return View::fetch();
    }

    public function welcome()
    {
        return View::fetch();
    }

    public function logout()
    {
        //清除session
        session(config('admin.session_admin'),null);
        return redirect(url('login/index'),302);
    }
    public function md5()
    {
        echo date("Y-m-d H:i:s");
        halt(session(config('admin.session_admin')));
        return md5("admin_admin");
    }
}