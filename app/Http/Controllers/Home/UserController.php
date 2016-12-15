<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\UserService as UserServer;
use App\Services\UploadService as UploadServer;
use Illuminate\Support\Facades\Validator;
use App\Tools\Avatar;
use App\Services\CommentAndLikeService as CommentServer;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected static $userServer = null;
    protected static $uploadServer = null;
    protected  static $commentServer = null;

    public function __construct(UserServer $userServer, UploadServer $uploadServer, CommentServer $commentServer)
    {
        self::$userServer = $userServer;
        self::$uploadServer = $uploadServer;
        self::$commentServer = $commentServer;
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
        // 获取账号信息
        $result = self::$userServer->accountInfo(['guid' => $id ]);

        if ($result['StatusCode'] == '400') {
            return view('home.user.accountSettings.index');
        };

        // 数据处理
        $tel = substr_replace(trim($result['ResultData']->tel), '****', 3, 4);
        $email = substr_replace(trim($result['ResultData']->email), '****', 2, 4);

        $accountInfo = $result['ResultData'];
        $accountInfo->tel = $tel;
        $accountInfo->email = $email;

        return view('home.user.accountSettings.index', compact('accountInfo'));
    }

    /**
     * 更改用户信息
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
        if (!isset($request->step)) return response()->json(['StatusCode' => '400','ResultData' => '数据缺失！']);

        switch ($request->step) {
            case '1':
                // 验证过滤数据
                $validator = Validator::make($request->all(),[
                    'captcha' => 'required',
                ],[
                    'captcha.required' => '请输入验证码',
                ]);

                if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);

                // 验证码比对
                // Session::get('sms')
                if ($request->captcha != '342766475') return response()->json(['StatusCode' => '400','ResultData' => '输入的验证码错误！']);

                // 看是否是第三步 验证新手机的验证码
                if (isset($request->tel)) {
                    $result = self::$userServer->changeAccountInfo(['guid' => $guid], ['tel' => $request->tel], 'tel');

                    if (!$result) return response()->json(['StatusCode' => '400','ResultData' => '手机号改绑失败！']);

                    return response()->json(['StatusCode' => '200','ResultData' => '手机号改绑成功，请重新登录!']);

                } else {
                    return response()->json(['StatusCode' => '200','ResultData' => '短信验证通过...']);
                }

            break;
            case '2':
                //验证数据，手机号校验
                $preg = '/^(1(([3578][0-9])|(47)|[8][0126789]))\d{8}$/';
                if(!preg_match($preg,$request->tel)) return response()->json(['StatusCode' => '400','ResultData' => '请输入正确的手机号!']);

                // 判断该手机是否已经存在
                $result = self::$userServer->checkUser(['tel' => $request->tel]);

                if ($result) return response()->json(['StatusCode' => '400','ResultData' => '该号码已存在！']);

                return response()->json(['StatusCode' => '200','ResultData' => $request->tel]);
            break;
            case '3':

            break;

        }

    }

    /**
     * 修改绑定手机，发送短信验证
     * @param $guid
     * @return \Illuminate\Http\JsonResponse
     * @author 刘峻廷
     */
    public function sendSms(Request $request, $guid)
    {
        if (isset($request->phone)) {
            // 发送短信
            return ['StatusCode' => '200', 'ResultData' => 'OK'];
            $info = self::$userServer->sendSmsCode($request->phone);
        }

        // 发送直接返回
        return ['StatusCode' => '200', 'ResultData' => 'OK'];

        if (!isset($guid)) return response()->json(['StatusCode' => '400', 'ResultData' => '缺少数据']);

        // 拿到给用户的手机号
        $tel = self::$userServer->accountInfo(['guid' => $guid])['ResultData']->tel;
        // 发送短信
        $info = self::$userServer->sendSmsCode($tel);

        return response()->json($info);
    }

     /**
     * 用户中心的点赞与评论
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 张洵之
     */
    public function commentAndLike(Request $request)
    {
        //获得第一页的评论数据与被之被评论内容标题
        $nowPage = (int)$request->input('nowPage');
        $commentResult = self::$commentServer->getCommentsTitles($nowPage,$request);
        //去除评论干扰项
        unset($request['nowPage']);
        $likeResult = self::$commentServer->getLikesTitles(1,$request);

        if ($commentResult['StatusCode'] == '200') {
            $commentPage = $commentResult['ResultData']['pageData'];
            unset($commentResult['ResultData']['pageData']);
            $commentData = $commentResult['ResultData'];
        }else{
            $commentData = false;
            $commentPage = false;
        }

        if ($likeResult['StatusCode'] == '200') {
            $likePage = $likeResult['ResultData']['pageData'];
            unset($likeResult['ResultData']['pageData']);
            $likeData = $likeResult['ResultData'];
        }else{
            $likeData = false;
            $likePage = false;
        }

        return view('home.user.commentAndLike',['commentData' => $commentData, 'likeData'  => $likeData, 'commentPage' => $commentPage, 'likePage' => $likePage]);
    }

    /**
     * 我的点赞ajax数据请求接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
     */
    public function getLike(Request $request)
    {
        $nowPage = $request->input('nowPage');
        $likeResult = self::$commentServer->getLikesTitles($nowPage,$request);
        return response()->json($likeResult);
    }
}
