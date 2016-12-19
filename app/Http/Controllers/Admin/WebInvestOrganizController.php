<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PictureService;
use Validator;

class WebInvestOrganizController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * 投资机构Ajax请求
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 王通
     */
    public function create()
    {

    }

    /**
     * 保存投资机构信息
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
            'invesname' => 'required|max:20',
            'invesurl' => 'required|max:50',
        ],[
            'avatar_file.required' => '上传文件为空!',
            'invesname.required' => '上传文件名为空!',
            'invesurl.required' => '上传文件URL为空!',
            'invesname.max' => '名字过长!',
            'invesurl.max' => 'url过长!',
            'avatar_file.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'
        ]);

        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['state' => 400,'result' => $validator->errors()->all()]);

        $res = self::$pictureservice->saveInvest($request);
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
