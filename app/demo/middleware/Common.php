<?php
/*公共中间件*/
namespace app\demo\middleware;

class Common {
    public function handle($request,\Closure $next)
    {
        $request->name = "kobe";

        return $next($request);
    }
}