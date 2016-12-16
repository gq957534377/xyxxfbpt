<?php

namespace App\Http\Middleware\Home;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Tools\Safety;

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
//        $checkBlackList = Safety::checkIpBlackList($request->getClientIp());
//        dd($checkBlackList);
//        if ($checkBlackList) {
//            return view('welcome');
//        }
//        // 防止快速刷新
//        $res4 = Safety::addIpBlackList($request->getClientIp());
//        if ($res4) {
//            return view('welcome');
//        }
        // 判断用户session是否存在
        if(empty(Session::get('user'))) return redirect('/login');
        return $next($request);
    }
}
