<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use zgldh\QiniuStorage\QiniuStorage;
use App\Services\WebAdminService;
use Validator;

class WebAdminstrationController extends Controller
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
     * 网站管理页面
     *
     * @author 王通
     */
    public function index()
    {
        $disk = QiniuStorage::disk('qiniu');

        return view('admin.webadminstrtion.webadmin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
dd('asdfdsa');
    }

    /**
     *  管理界面文字信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'time' => 'required',
            'tel' => 'required',
            'record' => 'required',
        ], [
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱不能为空',
            'time.required' => '邮箱不能为空',
            'tel.required' => '邮箱不能为空',
            'time.required' => '邮箱不能为空',
            'record.required' => '邮箱不能为空',
        ]);
        if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);
       self::$webAdmin->saveWebText($validator->all());

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
        //
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
