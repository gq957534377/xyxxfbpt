<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\WebAdminService;

class WebAdminsSeoController extends Controller
{
    protected static $webAdmin;
    /** 单例引入
     *
     * @param WebAdminService $webAdminService
     * @author 王通
     */
    public function __construct(WebAdminService $webAdminService)
    {
        self::$webAdmin = $webAdminService;
    }

    /**
     * SEO维护界面
     *
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function index()
    {
        // 得到界面显示数据
        $res = self::$webAdmin->getAllWebConf();
        return view('admin.webadminstrtion.web_admin_seo', ['info' => $res['msg']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 接收要修改的SEO优化数据
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function store(Request $request)
    {
        // 更新SEO优化的数据
        $info = self::$webAdmin->saveWebAdmin($request->all());
        if ($info['status'] == '200') {
            return ['StatusCode' => '200', 'ResultData' => $info['msg']];
        } else {
            return ['StatusCode' => '400', 'ResultData' => $info['msg']];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
