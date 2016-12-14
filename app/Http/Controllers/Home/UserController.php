<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\UserService as UserServer;
use App\Services\UploadService as UploadServer;
use Illuminate\Support\Facades\Validator;
use App\Tools\Avatar;

class UserController extends Controller
{
    protected static $userServer = null;
    protected static $uploadServer = null;

    public function __construct(UserServer $userServer, UploadServer $uploadServer)
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

    }

    public function store(Request $request)
    {

    }

    /**
     * 提取个人信息
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 刘峻廷
     */
    public function show($id)
    {
        if(empty($id)) return response()->json(['StatusCode' => '500','ResultData' => '服务器数据异常']);
      // 获取到用户的id，返回数据
        $info = self::$userServer->userInfo(['guid'=>$id]);
        return response()->json($info);
    }

    /**
     * 获取角色信息
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author 刘峻廷
     */
    public function roleInfo($id)
    {
        if(empty($id)) return response()->json(['StatusCode' => '500','ResultData' => '服务器数据异常']);

        // 获取当前用的角色，判断该查那张表
        $userInfo = self::$userServer->userInfo(['guid' => $id]);

        // 判断当前用户的数据
        if (!$userInfo['status']) return response()->json(['StatusCode' => '400','ResultData' => '未查询到数据']);

        if ($userInfo['msg']->role == 1) {
            if(!$userInfo['status']) return response()->json(['StatusCode' => '400','ResultData' => '未查询到数据']);
            return response()->json(['StatusCode' => '200','ResultData' => $userInfo]);
        }else{
            // 获取到用户的id，返回数据
            $info = self::$userServer->roleInfo(['guid' => $id]);
            if(!$info['status']) return response()->json(['StatusCode' => '400','ResultData' => '未查询到数据']);
            return response()->json(['StatusCode' => '200','ResultData' => $info]);
        }
    }

    /**
     * 显示修改账号页面
     * @param $id
     * @author 刘峻廷
     */
    public function edit($id)
    {
        $result = self::$userServer->userInfo(['guid' => $id ]);
//        dd($result);
        return view('home.user.accountSettings.index');
    }

    /**
     * 更改用户信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 刘峻廷
     */
    public function update(Request $request, $id)
    {
        // 获取修改数据
        $data = $request->all();
        // 将验证后的数据交给Server层
        $info = self::$userServer->updataUserInfo(['guid' => $id],$data);

        return $info;
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

        $guid = $request->all()['guid'];
        // 转交service 层，存储
        $info = self::$userServer->avatar($guid,$avatarName);

        // 返回状态信息
        return response()->json($info);
    }

    /**
     * 更换邮箱绑定
     * @param Request $request
     * @param $guid
     * @return \Illuminate\Http\JsonResponse
     * @author 刘峻廷
     */
    public function changeEmail(Request $request,$guid)
    {
        $data = $request->all();
        // 验证过滤数据
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'newEmail' => 'required|email',
            'password' => 'required',
        ],[
            'email.requried' => '请填写您的原始邮箱!<br>',
            'email.email' => '您输入的邮箱格式不正确<br>',
            'newEmail.requried' => '请填写您的新邮箱<br>',
            'newEmail.email' => '您输入的新邮箱格式不正确<br>',
            'password.requried' => '请输入您的密码',

        ]);

        if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);

        // 简单数据验证后，提交给业务层
        $info = self::$userServer->changeEmail($data,$guid);

        // 返回状态信息
        switch ($info['status']){
            case '400':
                return response()->json(['StatusCode' => '400','ResultData' => $info['msg']]);
                break;
            case '200':
                return response()->json(['StatusCode' => '200','ResultData' => $info['msg'] ,'Email' => $data['newEmail']]);
                break;
        }

    }


    /**
     * 更改手机号绑定
     * @param Request $request
     * @param $guid
     * @return \Illuminate\Http\JsonResponse
     * @author 刘峻廷
     */
    public function changeTel(Request $request,$guid)
    {
        $data = $request->all();
        // 验证过滤数据
        $validator = Validator::make($request->all(),[
            'tel' => 'required|min:11|regex:/^1[34578][0-9]{9}$/',
            'newTel' => 'required|min:11|regex:/^1[34578][0-9]{9}$/',
            'password' => 'required',
        ],[
            'tel.required' => '请填写您的原始手机号<br>',
            'tel.min' => '确认手机不能小于11个字符<br>',
            'tel.regex' => '请正确填写您的手机号码<br>',
            'newTel.required' => '请填写您的新手机号<br>',
            'newTel.min' => '确认手机不能小于11个字符<br>',
            'newTel.regex' => '请正确填写您的新手机号码<br>',
            'password.required' => '请输入您的密码',

        ]);

        if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);

        // 简单数据验证后，提交给业务层
        $info = self::$userServer->changeTel($data,$guid);

        // 返回状态信息
        switch ($info['status']){
            case '400':
                return response()->json(['StatusCode' => '400','ResultData' => $info['msg']]);
                break;
            case '200':
                return response()->json(['StatusCode' => '200','ResultData' => $info['msg'] ,'Tel' => $data['newTel']]);
                break;
        }

    }
}
