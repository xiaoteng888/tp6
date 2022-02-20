<?php
/*登录限制中间件*/
namespace app\api\middleware;

class AuthLogin {
    public function handle($request,\Closure $next)
    {
        //前置中间件
        $token = $request->header('access_token');
        if(empty(cache(config('redis.token_pre').$token)) && !preg_match("/login/i", $request->pathinfo()) && !preg_match("/smscode/i", $request->pathinfo()) && !preg_match("/index/i", $request->pathinfo()) && !preg_match("/category/i", $request->pathinfo()) && !preg_match("/lists/i", $request->pathinfo()) && !preg_match("/detail/i", $request->pathinfo())){
            //return redirect(url('login/index'),302);
            return msg(config('statusCode.not_login'),'没有登录');
        }elseif(!empty(cache(config('redis.token_pre').$token)) && (preg_match("/login/i", $request->pathinfo()) || preg_match("/smsSend/i",$request->pathinfo()))){
            //return redirect(url('index/index'),302);
            return msg(config('statusCode.is_login'),'已经登录');
        }
        $response =  $next($request);
        //后置中间件
        return $response;
    }
}