<?php


namespace app\admin\controller;


use app\BaseController;
use think\exception\HttpResponseException;

class AdminBase extends BaseController
{
    public $adminUser;
    public function initialize()
    {
        parent::initialize();

        /*if(!$this->isLogin()){
            return $this->redirect(url('login/index'),302);
        }*/
    }

    public function isLogin()
    {
        $this->adminUser = session(config('admin.session_admin'));
        if(!$this->adminUser){
            return false;
        }
        return true;
    }

    public function redirect(...$args)
    {
        throw new HttpResponseException(redirect(...$args));
    }
}