<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService as UserServer;
use App\Services\UploadService as UploadServer;

class RoleController extends Controller
{
    protected static $userServer = null;
    protected static $uploadServer = null;

    public function __construct(UserServer $userServer, UploadServer $uploadServer)
    {
        self::$userServer = $userServer;
        self::$uploadServer = $uploadServer;
    }

    /**
     * 身份初始视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 刘峻廷
     */
    public function index()
    {
        return view('home.user.identity');
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
     *申请角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 刘峻廷
     */
    public function store(Request $request)
    {
        // 获取数据
        $data = $request->all();
        //验证数据
        $validator = Validator::make($request->all(),[
            'guid' => 'required',
            'role' => 'required',
            'realname' => 'required|min:2',
            'subject' => 'required',
            'tel' => 'required|min:11',
            'card_number' => 'required|min:16|max:18',
            'field' => 'required',
            'stage' => 'required',
            'card_pic_a' => 'required',
        ],[
            'guid.required' => '非法操作!<br>',
            'role.required' => '非法操作!<br>',
            'realname.required' => '请填写您的真实姓名<br>',
            'realname.min' => '真实姓名最少两位<br>',
            'subject' => '请选择主体<br>',
            'tel.required' => '请填写您的手机号码<br>',
            'tel.min' => '手机号码标准11位<br>',
            'card_number.required' => '请填写您的真实身份证件号<br>',
            'card_number.min' => '身份证件号16-18位<br>',
            'card_number.max' => '身份证件号16-18位<br>',
            'field.required' => '请选择领域<br>',
            'stage.required' => '请选择阶段<br>',
            'card_pic_a.required' => '请上传您的出身份证正面照<br>',
        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '404','ResultData' => $validator->errors()->all()]);

        //将申请者的提交数据转发到service层
        // 提取想要的数据
//        $picInfo_a = self::$uploadServer->uploadFile($request->file('syb_card_pic'));
//        if($picInfo_a['status'] =='400') return response()->json(['StatusCode' => '400','ResultData' => '图片上传失败']);

//        $data['card_pic_a'] = $picInfo_a['msg'];

        // 提交数据到业务服务层
        $info = self::$userServer->applyRole($data);
        // 返回状态信息
        switch ($info['status']){
            case '400':
                return response()->json(['StatusCode' => '400','ResultData' => $info['msg']]);
                break;
            case '200':
                return response()->json(['StatusCode' => '200','ResultData' => $info['msg']]);
                break;
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
