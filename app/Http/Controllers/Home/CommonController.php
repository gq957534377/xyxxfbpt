<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    /**
     * 错误处理,返回对应的错误视图
     * @param
     * @return array
     * @author 郭庆
     */
    public function errors($status)
    {
        return view('errors.'.$status);
    }
}
