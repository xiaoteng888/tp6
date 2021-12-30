<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use app\common\model\mysql\User;
use app\Request;

class Index extends BaseController
{
    public function index()
    {
        /*$res = [
            'message' => '你好',
            'code' => 1,
            'data' => [
                'id' => 1,
                'name' => 'kobe',
            ],
        ];*/

        return msg(1,'你好',[
            'id' => 1,
            'name' => 'kobe',
        ],201);
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

    public function request()
    {
        dump($this->request->param());
    }

    public function user()
    {
        //$res = Db::name('user')->where('id',2)->find();
        $res = app('db')->name('user')->where('id',3)->find();
        dump($res);
    }

    public function page()
    {
        $res = Db::name('user')
            //->order('id','desc')
            //->page(1,2)
            ->where('id','>',1)
            ->select();
        dump($res);
    }

    public function sql()
    {
        //第一种获取sql方式
        /*$res = Db::name('user')
            ->where('id',10)
            ->fetchSql()
            ->find();
           dump($res);
        */
        //第二种方式
        $res = Db::name('user')
            ->where('id',10)
            ->find();
        echo Db::getLastSql();exit();
    }
    public function demo()
    {
        $data = [
            'name' => 'tom',
            'age'  => 23,
        ];
        //新增操作
        //$res = Db::name('user')->insert($data);
        $res = Db::name('user')->delete(1);
        echo Db::getLastSql();
        dump($res);
    }
    public function model()
    {
        $res = User::find(4);
        dump($res->toArray());
        dump($res->full_name);
    }
}
