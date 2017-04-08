<?php

namespace App\Http\Controllers\Home;

use App\Tools\Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService as UserServer;
use App\Services\UserRoleService as RoleServer;
use App\Services\UploadService as UploadServer;

class RoleController extends Controller
{
    protected static $userServer = null;
    protected static $roleServer = null;
    protected static $uploadServer = null;

    public function __construct(
        UserServer $userServer,
        RoleServer $roleServer,
        UploadServer $uploadServer
    ){
        self::$userServer = $userServer;
        self::$roleServer = $roleServer;
        self::$uploadServer = $uploadServer;
    }

    /**
     * 身份初始视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function index(Request $request)
    {
        if (isset($request->identity)) {
            return view('home.user.'.$request->identity);
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
     * 申请角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function store(Request $request)
    {
        // 获取数据
        $data = $request->all();
        $data['addtime'] = $_SERVER['REQUEST_TIME'];

        if (isset($request->role) && $request->role ==4 ) {
            $result = self::$roleServer->applyRole($data);
            return response()->json($result);
        }

        // 数据验证
        switch ($request->role) {
            case '2':
                $result = self::$roleServer->sybValidator($request);
                break;
            case '3':
                $result = self::$roleServer->investorValidator($request);
                break;
        }

        if ($result['StatusCode'] == '400') return response()->json($result);

        // 提交数据到业务服务层
        $info = self::$roleServer->applyRole($data);

        // 返回状态信息
        return response()->json($info);
    }

    /**
     * 获取用户角色信息
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function show(Request $request, $id)
    {
        if (empty($id)) return response()->json(['StatusCode' => '400', 'ResultData' => '缺少数据']);

        if (isset($request->role)) {
            $result = self::$userServer->roleInfo(['guid' => $id, 'role' => '4'], 'memeber');
        } else {
            $result = self::$userServer->roleInfo(['guid' => $id]);
        }

        return response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $role = '';
        switch ($request->identity) {
            case 'syb' :
                $role = '2';
                break;
            case 'investor' :
                $role = '3';
                break;
        }
        $result = self::$roleServer->userInfo(['guid' => $request->id, 'role' => $role]);

        if($result['StatusCode'] == '400') {
            $result['ResultData'] = [];
        }

        return view('home.user.edit.'.$request->identity, [
            'roleInfo' => $result['ResultData']
        ]);
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
        $validator = Validator::make($request->all(),[
            'role' => 'required',
            'scale' => 'required|numeric',
            'field' => 'required|',
        ],[
            'role.required' => '非法操作!<br>',
            'scale.required' => '请输入投资规模<br>',
            'scale.numeric:' => '必须输入数字<br>',
            'field.required' => '请选择行业领域<br>',
        ]);

        // 数据验证失败，响应信息
        if ($validator->fails()) return ['StatusCode' => '400','ResultData' => $validator->errors()->all()];

        $result = self::$roleServer->updateRoleInfo($id, $request->all());

        return response()->json($result);
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

    /**
     * 上传图片文件
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function cardPic(Request $request)
    {
        //数据验证过滤
        $validator = Validator::make($request->all(),[
            'avatar_file' => 'required|mimes:png,gif,jpeg,jpg,bmp'
        ],[
            'avatar_file.required' => '上传文件为空!',
            'avatar_file.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'

        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);
        //上传
        $info = Avatar::avatar($request);
        if ($info['status'] == '400') return response()->json(['StatusCode' => '400','ResultData' => '文件上传失败!']);
        $avatarName = $info['msg'];
        session(['picture_contri' => $avatarName]);
        Redis::set('picture_contri' . session('user')->guid, $avatarName);
        return response()->json(['StatusCode' => '200','ResultData' => $avatarName]);
    }
}
