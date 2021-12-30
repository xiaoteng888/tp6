<?php


namespace app\admin\business;

use app\common\model\mysql\Admin;
use think\Exception;
class AdminBusiness
{
    public $adminModel = null;
    public function __construct()
    {
        $this->adminModel = new Admin();
    }

    public function getAdminByUsername($username)
    {
        $admin = $this->adminModel->getAdminByUsername($username);
        if(!$admin){
            return false;
        }
        return $admin;
    }

    public function updateById($id, $updateData)
    {
        $res = $this->adminModel->updateById($id, $updateData);
        //halt($res);
        return $res;
    }

    public function login($data)
    {

        $admin = $this->getAdminByUsername($data['username']);
        if (!$admin || $admin->status != config("statusCode.mysql.table_normal")) {
            //return msg(config('statusCode.error'), "用户不存在");
            throw new Exception("用户不存在");
        }
        if ($admin->password != md5($data['password'] . "_admin")) {
           // return msg(config('statusCode.error'), "帐号或密码不正确");
            throw new Exception("帐号或密码不正确");
        }

        //更新数据到数据库
        $updateData = [
            'last_login_time' => date("Y-m-d H:i:s") ,
            'last_login_ip' => request()->ip(),
        ];
        $res = $this->updateById($admin->id, $updateData);
        if (!$res) {
            //return msg(config('statusCode.error'), "登录失败");
            throw new Exception("登录失败");
        }

        //记录session
        session(config('admin.session_admin'),$admin->toArray());
        return true;
    }
}