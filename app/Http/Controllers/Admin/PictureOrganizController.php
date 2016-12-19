<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PictureService;
use Validator;


class PictureOrganizController extends Controller
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
     * 轮播图管理界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 王通
     */
    public function carousel ()
    {

    }

    /**
     * 轮播图管理Ajax请求
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 王通
     */
    public function carouselAjax ()
    {

    }

    /**
     * 更新轮播图
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 王通
     */
    public function uploadCarousel (Request $request)
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

        $res = self::$pictureservice->saveCarousel($request);
        return response()->json(['state' => 200, 'result' => '成功']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return self::$pictureservice->updatePicture($id, $request->all());
    }

    /**
     * 删除指定id数据
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function destroy($id)
    {
        return self::$pictureservice->delPicture($id);
    }
}
