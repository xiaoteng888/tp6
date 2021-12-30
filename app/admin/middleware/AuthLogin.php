<?php

namespace app\admin\middleware;

use think\Response;

class AuthLogin {
    public function handle($request, \Closure $next)
    {
        //前置中间件

        if(empty(session(config('admin.session_admin'))) && !preg_match("/login/i", $request->pathinfo()) && !preg_match("/imgcaptcha/i", $request->pathinfo())){
            return redirect(url('login/index'),302);
        }elseif(!empty(session(config('admin.session_admin'))) && preg_match("/login/i", $request->pathinfo())){
            return redirect(url('index/index'),302);
        }
        $response =  $next($request);
        //后置中间件

        /*if(empty(session(config('admin.session_admin'))) && !in_array($request->controller(), ["Login","ImgCaptcha"])){
            return redirect(url('login/index'),302);
        }*/
        return $response;
    }

    /**
     * 中间件调度结束
     * @param Response $response
     */
    public function end(Response $response)
    {

    }
}