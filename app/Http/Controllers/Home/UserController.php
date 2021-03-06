<?php

namespace App\Http\Controllers\Home;

use App\Store\ArticleStore;
use App\Store\GoodsStore;
use App\Tools\Common;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\UserService as UserServer;
use App\Services\UploadService as UploadServer;
use Illuminate\Support\Facades\Validator;
use App\Tools\Avatar;
use App\Tools\Upload;
use App\Services\CommentAndLikeService as CommentServer;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    protected static $userServer = null;
    protected static $uploadServer = null;
    protected static $commentServer = null;
    protected static $articleStore = null;
    protected static $goodsStore = null;

    public function __construct(
        UserServer $userServer,
        UploadServer $uploadServer,
        CommentServer $commentServer,
        ArticleStore $articleStore,
        GoodsStore $goodsStore
    )
    {
        self::$userServer = $userServer;
        self::$goodsStore = $goodsStore;
        self::$uploadServer = $uploadServer;
        self::$commentServer = $commentServer;
        self::$articleStore = $articleStore;
    }

    /**
     * 显示个人中心页
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function index()
    {


    }

    /**
     * 显示公司添加页.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.user.company');
    }

    /**
     * 添加公司信息
     * @param Request $request
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // 验证身份，角色判定，创业者才拥有权限
        if (empty($request->guid)) return ['StatusCode' => '400', 'ResultData' => '请求缺少必要参数'];
        $role = self::$userServer->userInfo(['guid' => $request->guid])['ResultData']->role;

        if ($role == 2 || $role == 23) {
            $validator = Validator::make($request->all(), [
                'company' => 'required|regex:/^[\x80-\xff_a-zA-Z0-9]+$/',
                'abbreviation' => 'required|regex:/^[\x80-\xff_a-zA-Z0-9]+$/',
                'address' => 'required',
                'founder_name' => 'required|regex:/^[\x80-\xff_a-zA-Z]+$/',
                'url' => 'required',
                'field' => 'required|regex:/^[\x80-\xff_\-\/_a-zA-Z0-9]+$/',
                'organize_card' => 'required',
            ], [
                'company.required' => '请输入公司名称',
                'company.regex' => '公司名称只允许输入中文、字母、数字、下划线',
                'abbreviation.required' => '请输入公司简称',
                'abbreviation.regex' => '公司简称只允许输入中文、字母、数字、下划线',
                'address.required' => '请选择公司所在地',
                'founder_name.required' => '请输入公司创始人姓名',
                'founder_name.regex' => '公司创始人姓名只允许输入中文、字母',
                'url.required' => '请输入公司网址',
                'field.required' => '请选择行业领域',
                'field.regex' => '行业领域格式不对',
                'organize_card.required' => '请上传组织机构代码证',
            ]);
            // 数据验证失败，响应信息
            if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);

            $data['addtime'] = $_SERVER['REQUEST_TIME'];
            $result = self::$userServer->addCompany($data);

            return response()->json($result);
        } else {
            return ['StatusCode' => '400', 'ResultData' => '请先成为创业者'];
        }

    }

    /**
     * 提取个人信息
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function show($id)
    {
        if (empty($id)) return view('errors.404');

        // 获取到用户的id，返回数据
        $info = self::$userServer->userInfo(['guid' => $id]);

        // 获取已发表文章数量
        $article = self::$articleStore->getCount(['user_id' => $id, 'status' => 1]);

        // 获取已发布商品的数量
        $goods = self::$goodsStore->getCount(['author' => $id, 'status' => 1]);

        if ($info['StatusCode'] != '200') return view('errors.500');
        // 返回视图
        return view('home.user.index', [
            'userInfo' => $info['ResultData'],
            'article' => $article,
            'goods' => $goods
        ]);
    }

    /**
     * 显示修改账号页面
     * @param $id
     * @author 郭庆
     * @modify 杨志宇
     */
    public function edit($id)
    {
        // 获取账号信息
        $result = self::$userServer->accountInfo(['guid' => $id]);

        if ($result['StatusCode'] != '200') {
            return view('home.user.accountSettings.index');
        };

        // 数据处理
        // 判断手机号跟邮箱是否为空
        $tel = null;
        $email = null;
        // 危险度
        $resk = 0;
        // 风险项
        $risk = 2;
        if (!empty($result['ResultData']->tel)) {
            $tel = substr_replace(trim($result['ResultData']->tel), '****', 3, 4);
            $resk += 50;
            $risk--;
        }
        if (!empty($result['ResultData']->email)) {
            $email = substr_replace(trim($result['ResultData']->email), '****', 2, 4);
            $resk += 50;
            $risk--;
        }


        $accountInfo = $result['ResultData'];
        $accountInfo->tel = $tel;
        $accountInfo->email = $email;
        $accountInfo->resk = $resk;
        $accountInfo->risk = $risk;

        return view('home.user.accountSettings.index', compact('accountInfo'));
    }

    /**
     * 更改用户信息
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {
        // 获取修改数据
        $data = $request->all();
        //数据验证过滤
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:10|regex:/^[\x80-\xff_a-zA-Z0-9]+$/',
        ], [
            'username.required' => '请输入昵称',
            'username.string' => '请输入正确的格式',
            'username.max' => '昵称长度不允许超过10个字符',
            'username.regex' => '只允许输入中文、字母、数字、下划线',
        ]);

        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);

        // 将验证后的数据交给Server层
        $info = self::$userServer->updataUserInfo(['guid' => $id], $data);

        return response()->json($info);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 修改个人头像
     * @param Request $request
     * @author 郭庆
     */
    public function headpic(Request $request)
    {
        //数据验证过滤
        $validator = Validator::make($request->all(), [
            'avatar_file' => 'required|mimes:png,gif,jpeg,jpg,bmp'
        ], [
            'avatar_file.required' => '上传文件为空!',
            'avatar_file.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'

        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);
        //上传
        $info = Avatar::avatar($request);
        if ($info['status'] == '400') return response()->json(['StatusCode' => '400', 'ResultData' => '文件上传失败!']);
        $avatarName = $info['msg'];

        $guid = $request->all()['guid'];
        // 转交service 层，存储
        $info = self::$userServer->avatar($guid, $avatarName);

        // 返回状态信息
        return response()->json($info);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function uploadCard(Request $request)
    {
        //数据验证过滤
        $validator = Validator::make($request->all(), [
            'card_pic' => 'required|mimes:png,gif,jpeg,jpg,bmp'
        ], [
            'card_pic.required' => '上传文件为空!',
            'card_pic.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'

        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);

        // 上传
        $result = Upload::UploadFile($request->file('card_pic'));

        return response()->json($result);

    }

    /**
     * 修改账号密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guid' => 'required',
            'password' => 'required',
            'new_password' => 'required|min:6',
        ], [
            'guid' => '缺少数据信息',
            'password' => '请输入原始密码',
            'new_password' => '请输入新密码',
            'new_password.min' => '新密码最少6位以上',

        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);

        // 提交数据给业务层
        $result = self::$userServer->changePassword($request);

        return response()->json($result);

    }

    /**
     * 更换邮箱绑定
     * @param Request $request
     * @param $guid
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function changeEmail(Request $request)
    {
        // 验证过滤数据
        $validator = Validator::make($request->all(), [
            'captcha_email' => 'required',
        ], [
            'captcha_email.requried' => '请输入验证码!',
        ]);

        if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);

        // 获取要更改的数据
        $newEmail = Session::get('email');

        // 数据判断
        if (trim($request->captcha_email) != $newEmail['code']) return response()->json(['StatusCode' => '400', 'RsultData' => '验证码错误']);

        // 简单数据验证后，提交给业务层
        $info = self::$userServer->changeEmail($request->guid, $newEmail['email']);

        // 返回状态信息
        return response()->json($info);

    }


    /**
     * 更改手机号绑定
     * @param Request $request
     * @param $guid
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     * @modify 杨志宇
     */
    public function changeTel(Request $request, $guid)
    {
        if (!isset($request->step) && empty(session('sms')['phone']) && session('sms')['phone'] != $request->tel) {
            return response()->json(['StatusCode' => '400', 'ResultData' => '非法请求！']);
        }

        switch ($request->step) {
            case '1':
                // 验证过滤数据
                $validator = Validator::make($request->all(), [
                    'captcha' => 'required',
                ], [
                    'captcha.required' => '请输入验证码',
                ]);

                if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);

                // 验证码比对
                // Session::get('sms')['smsCode']
                if (empty(Session::get('sms')['smsCode']) || $request->captcha != Session::get('sms')['smsCode']) {
                    return response()->json(['StatusCode' => '400', 'ResultData' => '输入的验证码错误！']);
                }

                // 看是否是第三步 验证新手机的验证码
                if (isset($request->tel)) {
                    $result = self::$userServer->changeTel($guid, $request->tel);

                    if (!$result) return response()->json(['StatusCode' => '400', 'ResultData' => '手机号改绑失败！']);

                    return response()->json(['StatusCode' => '200', 'ResultData' => '手机号改绑成功，请重新登录!']);

                } else {
                    session(['sms' => '']);
                    return response()->json(['StatusCode' => '200', 'ResultData' => '短信验证通过...']);
                }

                break;
            case '2':

                //验证数据，手机号校验
                $preg = '/^(1(([3578][0-9])|(47)|[8][0126789]))\d{8}$/';
                if (!preg_match($preg, $request->tel)) return response()->json(['StatusCode' => '400', 'ResultData' => '请输入正确的手机号!']);

                // 判断该手机是否已经存在
                $result = self::$userServer->checkUser(['tel' => $request->tel]);

                if ($result) return response()->json(['StatusCode' => '400', 'ResultData' => '该号码已存在！']);
                session(['sms' => '']);
                return response()->json(['StatusCode' => '200', 'ResultData' => $request->tel]);
                break;
        }

    }

    /**
     * 修改绑定手机，发送短信验证
     * @param $guid
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     * @author 杨志宇
     */
    public function sendSms(Request $request, $guid)
    {
        if (isset($request->phone)) {
            // 验证过滤数据
            $validator = Validator::make($request->all(), [
                'phone' => 'required|max:11|min:11',
                'code' => 'required'
            ], [
                'phone.required' => '请输入手机号',
                'phone.max' => '手机号最大为11位',
                'phone.min' => '手机号最少为11位',
                'code.required' => '请输入验证码',
            ]);
            if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);
            //验证数据，手机号校验
            $preg = '/^(1(([3578][0-9])|(47)|[8][0126789]))\d{8}$/';
            if (!preg_match($preg, $request->phone)) return response()->json(['StatusCode' => '400', 'ResultData' => '请输入正确的手机号!']);
            if ($request->code != session('code')) {
                return response()->json(['StatusCode' => '400', 'ResultData' => '请输入正确的验证码!']);
            } else {
                session(['code' => '']);
            }


            // 发送短信
            $info = self::$userServer->sendSmsCode($request->phone);

            return response()->json($info);
        }
        if (!isset($guid) || empty(session('user')->guid)) return response()->json(['StatusCode' => '400', 'ResultData' => '缺少数据']);

        // 拿到给用户的手机号
        $tel = self::$userServer->accountInfo(['guid' => session('user')->guid])['ResultData']->phone_number;
        // 发送短信
        $info = self::$userServer->sendSmsCode($tel);

        return response()->json($info);
    }

    /**
     * Send Email for user
     * @author 郭庆
     */
    public function sendEmail(Request $request)
    {
        if (!isset($request->guid) || !isset($request->newEmail)) return response()->json(['StatusCode' => '400', '缺少数据信息']);

        // 确认当前用户是否存在
        $userAccount = self::$userServer->accountInfo(['guid' => $request->guid]);

        if ($userAccount['StatusCode'] == '400') {
            \Log::error('查询账户信息失败', $userAccount);
            return response()->json(['StatusCode' => '400', 'ResultData' => '当前账号不存在!']);
        }

        $result = self::$userServer->sendEmail($request);

        return response()->json($result);
    }


    /**
     * 用户中心的点赞与评论
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 杨志宇
     */
    public function commentAndLike(Request $request)
    {
        $data = $request->all();
        //获得第一页的评论数据与被之被评论内容标题
        $nowPage = (int)$request->input('nowPage') ?? 1;
        $commentResult = self::$commentServer->selectComment(['user_id' => session('user')->guid], $nowPage, 5, 'user/commentandlike');

        return view('home.user.commentAndLike', $commentResult);
    }

    /**
     * 获取用户真实姓名
     * @param $guid
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function getRealName($guid)
    {
        if (!isset($guid)) return response()->json(['StatusCode' => '400', 'ResultData' => '请求参数缺失']);

        $result = self::$userServer->userInfo(['guid' => $guid]);

        return response()->json($result);

    }
}
