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
     * 编辑个人中心
     *
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
        if($info['status'] == '400') return response()->json(['StatusCode'=>400,'ResultData'=>'修改失败']);
        return response()->json(['Status'=>200,'ResultData'=>'修改成功']);
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
                return response()->json(['StatusCode'=>'200','ResultData'=>$info['msg'],'headpic'=>$info['data']]);
                break;
        }
    }

    /**
     * 申请成为创业者
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 刘峻廷
     */
    public function applyRole(Request $request)
    {
        // 获取数据
        $data = $request->all();
        //验证数据
        $validator = Validator::make($request->all(),[
            'guid' => 'required',
            'realname' => 'required|min:2',
            'card_number' => 'required|min:16|max:18',
            'email' => 'required|email',
            'hometown' => 'required|min:2',
            'birthday' => 'required|min:4',
            'sex' => 'required',
            'tel' => 'required|min:11',
            'card_pic_a' => 'required',
            'card_pic_b' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['StatusCode' => 400,'ResultData' => $validator->errors()->all()]);
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
            case '404':
                return response()->json(['StatusCode'=>'404','ResultData'=>$info['msg']]);
            break;
            case '400':
                return response()->json(['StatusCode'=>'400','ResultData'=>$info['msg']]);
            break;
            case '200':
                return response()->json(['StatusCode'=>'200','ResultData'=>$info['msg']]);
            break;
        }

    }
}
