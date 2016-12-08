<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PictureService;
use Validator;

class WebCooperOrganizController extends Controller
{
    protected static $pictureservice;
    /** 单例引入
     *
     * @param WebAdminService $webAdminService
     * @author 王通
     */
    public function __construct(PictureService $pictureservice)
    {
        self::$pictureservice = $pictureservice;
    }

    /**
     * 合作机构管理界面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.webadminstrtion.web_cooper_organiz');
    }

    /**
     * 合作机构Ajax请求
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 王通
     */
    public function create()
    {
        $res = self::$pictureservice->getPicture(3);
        return response()->json($res);
    }

    /**
     * 保存合作机构信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function store(Request $request)
    {
        //数据验证过滤
        $validator = Validator::make($request->all(),[
            'avatar_file' => 'required|mimes:png,gif,jpeg,jpg,bmp',
            'coopname' => 'required|max:20',
            'coopurl' => 'required|max:50',
        ],[
            'avatar_file.required' => '上传文件为空!',
            'coopname.required' => '上传文件名为空!',
            'coopurl.required' => '上传文件URL为空!',
            'coopname.max' => '名字过长!',
            'coopurl.max' => 'url过长!',
            'avatar_file.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'
        ]);

        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['state' => 400,'result' => $validator->errors()->all()]);

        $res = self::$pictureservice->saveCooper($request);
        return response()->json(['state' => 200, 'result' => '成功']);
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
