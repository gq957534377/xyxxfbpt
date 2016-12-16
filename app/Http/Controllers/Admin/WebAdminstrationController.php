<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\WebAdminService;
use Validator;
use App\Tools\Avatar;

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
    public function index(Request $request)
    {

        if (empty($request['type'])) {
            return response()->json(['StatusCode' => '400','ResultData' => '参数错误']);
        }
        switch ($request['type'])
        {
            case '1':
                // 取出界面数据
                $res = self::$webAdmin->getAllWebConf();
                return view('admin.webadminstrtion.index', ['info' => $res['msg']]);
                break;
            case '2':       // 合作机构管理界面
                return view('admin.webadminstrtion.web_cooper_organiz');
                break;
            case '3':
                // 投资机构
                return view('admin.webadminstrtion.web_investment_organiz');
                break;
            case '4':
                // 轮播图管理
                return view('admin.webadminstrtion.carousel_organiz');
                break;
            default:

                break;
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (empty($request['type'])) {
            return response()->json(['StatusCode' => '400','ResultData' => '参数错误']);
        }
        // 合作机构Ajax请求
        $res = self::$pictureservice->getPicture(3);
        return response()->json($res);

        // 投资机构Ajax请求
        $res = self::$pictureservice->getPicture(5);
        return response()->json($res);

        // 轮播图管理Ajax请求
        $res = self::$pictureservice->getPicture(2);
        return response()->json($res);
    }

    /**
     *  管理界面文字信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // 验证信息
        $validator = Validator::make($data, [
            'email' => 'required',
            'time' => 'required',
            'tel' => 'required',
            'record' => 'required',
        ], [
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'time.required' => '时间不能为空',
            'tel.required' => '联系方式不能为空',
            'record.required' => '备案内容不能为空',
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
     * 上传 更改 logo
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 王通
     */
    public function uploadLogo (Request $request)
    {
        //数据验证过滤
        $validator = Validator::make($request->all(), [
            'avatar_file' => 'required|mimes:png,gif,jpeg,jpg,bmp'
        ],[
            'avatar_file.required' => '上传文件为空!',
            'avatar_file.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'

        ]);

        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['state' => 400, 'result' => $validator->errors()->all()]);

        $info = self::$webAdmin->uploadImg($request, 'logo');

        // 判断上传是否成功
        if ($info['status'] == '200') {
            return response()->json(['state' => 200, 'result' => $info['msg']]);
        } else {
            return response()->json(['state' => 400, 'result' => $info['msg']]);
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
