<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\UserService as UserServer;
use App\Services\UploadService as UploadServer;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected static $userServer = null;
    protected static $uploadServer = null;

    public function __construct(UserServer $userServer,UploadServer $uploadServer)
    {
        self::$userServer = $userServer;
        self::$uploadServer = $uploadServer;
    }
    /**
     * 显示个人中心页
     *
     * @return \Illuminate\Http\Response
     * @author 刘峻廷
     */
    public function index()
    {
        return view('home.user.index');
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
     * 申请成为创业者
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
            'realname' => 'required|min:2',
            'card_number' => 'required|min:16|max:18',
            'hometown' => 'required|min:2',
            'birthday' => 'required|min:4|max:6',
            'sex' => 'required',
            'tel' => 'required|min:11',
            'card_pic_a' => 'required',
            'card_pic_b' => 'required',
        ],[
            'guid.required' => '非法操作!<br>',
            'realname.required' => '请填写您的真实姓名<br>',
            'realname.min' => '真实姓名最少两位<br>',
            'card_number.required' => '请填写您的真实身份证件号<br>',
            'card_number.min' => '身份证件号16-18位<br>',
            'card_number.max' => '身份证件号16-18位<br>',
            'hometown.required' => '请填写您的籍贯<br>',
            'hometown.min' => '籍贯最少两位<br>',
            'birthday.required' => '请填写您的出身年月<br>',
            'birthday.min' => '出生年月4-6位<br>',
            'birthday.max' => '出生年月4-6位<br>',
            'sex.required' => '请选择您的性别<br>',
            'tel.required' => '请填写您的手机号码<br>',
            'tel.min' => '手机号码标准11位<br>',
            'card_pic_a.required' => '请上传您的出身份证正面照<br>',
            'card_pic_b.required' => '请上传您的出身份证反面照',
        ]);
        if ($validator->fails()) return response()->json(['StatusCode' => '404','ResultData' => $validator->errors()->all()]);
        //将申请者的提交数据转发到service层
        // 提取想要的数据
        $picInfo_a = self::$uploadServer->uploadFile($request->file('card_pic_a'));
        if($picInfo_a['status'] =='400') return response()->json(['StatusCode'=>'400','ResultData'=>'图片上传失败']);
        $picInfo_b = self::$uploadServer->uploadFile($request->file('card_pic_b'));
        if($picInfo_b['status'] =='400') return response()->json(['StatusCode'=>'400','ResultData'=>'图片上传失败']);
        $data['card_pic_a'] = $picInfo_a['msg'];
        $data['card_pic_b'] = $picInfo_b['msg'];
        // 提交数据到业务服务层
        $info = self::$userServer->applyRole($data);
        // 返回状态信息
        switch ($info['status']){
            case '400':
                return response()->json(['StatusCode'=>'400','ResultData'=>$info['msg']]);
                break;
            case '200':
                return response()->json(['StatusCode'=>'200','ResultData'=>$info['msg']]);
                break;
        }
    }

    /**
     * 提取个人信息
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(empty($id)) return response()->json(['StatusCode'=>500,'ResultData'=>'服务器数据异常']);
      // 获取到用户的id，返回数据
        $info = self::$userServer->userInfo(['guid'=>$id]);
        if(!$info['status']) return response()->json(['StatusCode'=>404,'ResultData'=>'未查询到数据']);
        return response()->json(['StatusCode'=>200,'ResultData'=>$info]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        // 获取修改数据
        $data = $request->all();
        // 将验证后的数据交给Server层
        $info = self::$userServer->updataUserInfo(['guid'=>$id],$data);
        // 返回信息做处理
        if($info['status'] == '400') return response()->json(['StatusCode'=>'400','ResultData'=>'修改失败']);
        return response()->json(['StatusCode'=>'200','ResultData'=>'修改成功']);
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
     * 修改个人头像
     * @param Request $request
     * @author 刘峻廷
     */
    public function headpic(Request $request)
    {
        $data = $request->all();
        // 验证数据
        $this->validate($request,[
            'guid' => 'required',
            'headpic' => 'required'
        ]);
       // 转发业务服务层
       $info = self::$userServer->updataUserInfo2($request);
        // 返回状态信息
        switch ($info['status']){
            case '400':
                return response()->json(['StatusCode'=>'400','ResultData'=>$info['msg']]);
                break;
            case '200':
                return response()->json(['StatusCode'=>'200','ResultData'=>$info['msg']]);
                break;
        }
    }
}
