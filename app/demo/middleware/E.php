<?php

namespace app\demo\middleware;

class E {
    public function handle($request,\Closure $next)
    {
        $request->name = "heman";
        return $next($request);
    }
}