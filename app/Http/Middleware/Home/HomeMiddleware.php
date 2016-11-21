<?php

namespace App\Http\Middleware\Home;

use Closure;
use Illuminate\Support\Facades\Session;

class HomeMiddleware
{
    /**
     * 验证前台用户登录状态
     * @param $request
     * @param Closure $next
     * @return mixed
     * @author 刘峻廷
     */
    public function handle($request, Closure $next)
    {
        // 判断用户session是否存在
        if(empty(Session::get('user'))) return redirect('/login');
        return $next($request);
    }
}
