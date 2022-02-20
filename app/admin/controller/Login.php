<?php


namespace app\admin\controller;


use Exception;
use think\facade\View;
use app\Request;
use app\admin\business\AdminBusiness;
use app\admin\validate\AdminValidate;
class Login extends AdminBase
{
    public function initialize()
    {
        /*if($this->isLogin()){

            return $this->redirect(url('index/index'),302);
        }*/
    }

    public function index()
    {
        return View::fetch();
    }

    public function md5()
    {

            //throw new HttpException(400,"用户不存在");


        //echo date("Y-m-d H:i:s");
        //halt(session(config('admin.session_admin')));
        return md5("123456");
    }
    public function check(Request $request)
    {
        if(!$request->isPost()){
            return msg(config('statusCode.error'),"请求方式不正确");
        }

        $username = $request->param('username','','trim');
        $password = $request->param('password','','trim');
        $captcha = $request->param('captcha','','trim');
        $data = [
            'username' => $username,
            'password' => $password,
            'captcha' => $captcha,
        ];
        $validate = new AdminValidate();
        if(!$validate->check($data)){
            return msg(config('statusCode.error'),$validate->getError());
        }
        /*if(empty($username) || empty($password) || empty($captcha)){
            return msg(config('statusCode.error'),"参数不能为空");
        }
        if(!captcha_check($captcha)){
            return msg(config('statusCode.error'),"验证码不正确");
        }*/

        try{
            $res = (new AdminBusiness())->login($data);

        }catch(Exception $e){
            return msg(config('statusCode.error'),$e->getMessage());
        }


        return msg(config('statusCode.success'),"登录成功");


    }
}