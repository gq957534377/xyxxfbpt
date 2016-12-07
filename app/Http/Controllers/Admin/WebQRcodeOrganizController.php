<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\WebAdminService;
use Validator;


class WebQRcodeOrganizController extends Controller
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
     * 显示二维码修改界面
     *
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function index()
    {
        // 取出界面数据
        $res = self::$webAdmin->getAllWebConf();
        return view('admin.webadminstrtion.webadminqrcode', ['info' => $res['msg']]);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function uploadQRcode (Request $request)
    {
        //数据验证过滤
        $validator = Validator::make($request->all(),[
            'avatar_file' => 'required|mimes:png,gif,jpeg,jpg,bmp'
        ],[
            'avatar_file.required' => '上传文件为空!',
            'avatar_file.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'

        ]);

        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['state' => 400,'result' => $validator->errors()->all()]);

        $info = self::$webAdmin->uploadImg($request, 'qrcode');

        // 判断上传是否成功
        if ($info['status'] == '200') {
            return response()->json(['state' => 200,'result' => $info['msg']]);
        } else {
            return response()->json(['state' => 400,'result' => $info['msg']]);
        }
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
     * 保存二维码相关介绍
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\
     * @author 王通
     */
    public function store(Request $request)
    {
        // 验证信息
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => '名称不能为空',
        ]);
        // 验证不通过 退回请求
        if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);

        // 管理页面文字信息
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
