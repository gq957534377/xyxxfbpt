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
            'birthday' => 'required',
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
            'sex.required' => '请选择您的性别<br>',
            'tel.required' => '请填写您的手机号码<br>',
            'tel.min' => '手机号码标准11位<br>',
            'card_pic_a.required' => '请上传您的出身份证正面照<br>',
            'card_pic_b.required' => '请上传您的出身份证反面照',
        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '404','ResultData' => $validator->errors()->all()]);

        //将申请者的提交数据转发到service层
        // 提取想要的数据
        $picInfo_a = self::$uploadServer->uploadFile($request->file('card_pic_a'));
        if($picInfo_a['status'] =='400') return response()->json(['StatusCode' => '400','ResultData' => '图片上传失败']);
        $picInfo_b = self::$uploadServer->uploadFile($request->file('card_pic_b'));
        if($picInfo_b['status'] =='400') return response()->json(['StatusCode' => '400','ResultData' => '图片上传失败']);
        $data['card_pic_a'] = $picInfo_a['msg'];
        $data['card_pic_b'] = $picInfo_b['msg'];
        $data['role'] = '2';
        unset($data['province']);
        unset($data['city']);
        unset($data['area']);

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
        if(!$info['status']) return response()->json(['StatusCode' => '404','ResultData' => '未查询到数据']);
        return response()->json(['StatusCode' => '200','ResultData' => $info]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
//        转交service 层，存储
        $info = self::$userServer->avatar($guid,$avatarName);

//         返回状态信息
        return $info;
        return response()->json(['StatusCode' => '200','ResultData' => $avatarName]);
    }

    /**
     * 申请成为投资者
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 刘峻廷
     */
    public function applyRole(Request $request)
    {
        $data = $request->all();
        //验证数据
        $validator = Validator::make($request->all(),[
            'guid' => 'required',
            'realname' => 'required|min:2',
            'sex' => 'required',
            'birthday' => 'required',
            'hometown' => 'required',
            'tel' => 'required|min:11|max:11',
            'card_number' => 'required|min:16|max:18',
            'orgname' => 'required',
            'orglocation' => 'required',
            'fundsize' => 'required',
            'field' => 'required',
            'orgdesc' => 'required|max:500',
            'workyear' => 'required|min:2',
            'scale' => 'required',
//            'card_pic_a' => 'required',
//            'card_pic_b' => 'required',
        ],[
            'guid.required' => '非法操作!<br>',
            'realname.required' => '请填写您的真实姓名<br>',
            'realname.min' => '真实姓名最少两位<br>',
            'card_number.required' => '请填写您的真实身份证件号<br>',
            'card_number.min' => '身份证件号16-18位<br>',
            'card_number.max' => '身份证件号16-18位<br>',
            'hometown.required' => '请填写您的籍贯<br>',
            'birthday.required' => '请填写您的出身年月<br>',
            'sex.required' => '请选择您的性别<br>',
            'tel.required' => '请填写您的手机号码<br>',
            'tel.min' => '手机号码标准11位<br>',
            'tel.max' => '手机号码标准11位<br>',
            'orgname.required' => '请填写机构名称<br>',
            'orglocation.required' => '请填写机构所在地<br>',
            'fundsize.required' => '请填写资金规模<br>',
            'field.required' => '请填写行业领域<br>',
            'orgdesc.required' => '请填写行业描述<br>',
            'workyear.required' => '请填写从业年限<br>',
            'workyear.max' => '2位内<br>',
            'scale.required' => '请填写投资规模<br>',
//            'card_pic_a.required' => '请上传您的出身份证正面照<br>',
//            'card_pic_b.required' => '请上传您的出身份证反面照',
        ]);
        if ($validator->fails()) return response()->json(['StatusCode' => '404','ResultData' => $validator->errors()->all()]);
        unset($data['province']);
        unset($data['city']);
        unset($data['area']);
        // 转交
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
     * 申请成为英雄会会员
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 刘峻廷
     */
    public function applyHeroMemeber(Request $request)
    {
        // 获取数据
        $data = $request->all();
        //验证数据
        $validator = Validator::make($request->all(),[
            'guid' => 'required',
            'realname' => 'required|min:2',
            'card_number' => 'required|min:16|max:18',
            'hometown' => 'required|min:2',
            'birthday' => 'required',
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
            'sex.required' => '请选择您的性别<br>',
            'tel.required' => '请填写您的手机号码<br>',
            'tel.min' => '手机号码标准11位<br>',
            'card_pic_a.required' => '请上传您的出身份证正面照<br>',
            'card_pic_b.required' => '请上传您的出身份证反面照',
        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '404','ResultData' => $validator->errors()->all()]);

        //将申请者的提交数据转发到service层
        // 提取想要的数据
        $picInfo_a = self::$uploadServer->uploadFile($request->file('card_pic_a'));
        if($picInfo_a['status'] =='400') return response()->json(['StatusCode' => '400','ResultData' => '图片上传失败']);
        $picInfo_b = self::$uploadServer->uploadFile($request->file('card_pic_b'));
        if($picInfo_b['status'] =='400') return response()->json(['StatusCode' => '400','ResultData' => '图片上传失败']);
        $data['card_pic_a'] = $picInfo_a['msg'];
        $data['card_pic_b'] = $picInfo_b['msg'];

        unset($data['province']);
        unset($data['city']);
        unset($data['area']);

        // 提交数据到业务服务层
        $info = self::$userServer->applyMemeber($data);

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

    /**
     * 用户中心的点赞与评论
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 张洵之
     */
    public function commentAndLike(Request $request)
    {
        //获得第一页的评论数据与被之被评论内容标题
        $nowPage = (int)$request->input('nowPage');
        $result = self::$commentServer->getCommentsTitles($nowPage,$request);
        if($result['StatusCode'] == '200') {
            //分页样式与数据分离
            $pageData = $result['ResultData']['pageData'];
            unset($result['ResultData']['pageData']);
            return view('home.user.commentAndLike',['data' => $result['ResultData'], 'pageData' => $pageData]);
        }else{
            return view('home.user.commentAndLike',['errinfo' => $result['ResultData']]);
        }

    }
}
