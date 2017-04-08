<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    /**
     * 检测后台登录状态
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author 郭庆
     */
    public function handle($request, Closure $next)
    {
        // manager session 在App\Services\AdminService服务层被加入
        if (empty(Session::get('manager'))) return redirect('/login');
        return $next($request);
    }
}
