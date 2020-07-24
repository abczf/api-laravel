<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->get('token')){

        }else{
            die("授权失败");
        }
        return $next($request);
    }
}
