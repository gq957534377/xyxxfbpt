<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;
use App\Services\UserService as UserServer;

class ActionController extends Controller
{
    protected  static $actionServer;
    protected  static $userServer;
    public function __construct(ActionServer $actionServer, UserServer $userServer)
    {
        self::$actionServer = $actionServer;
        self::$userServer = $userServer;
    }
    /**
     * 根据所选活动类型导航，返回相应的列表页+数据.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function index(Request $request)
    {
        // 获取活动类型 -> 活动类型的所有数据
        $type = $request->type;
        $result = self::$actionServer->actionTypeData($type);

        if($result["StatusCode"] == '200'){
            foreach ($result['ResultData'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg']);
                        if (!$chage['status']){
                            Log::info("普通用户第一次请求更改活动状态失败".$v->guid.':'.$chage['msg']);
                        }else{
                            $v->status = $status['msg'];
                        }
                    }
                }
            }
            return view('home.action.index', ['actions' => $result['ResultData']]);
        }
        return view('home.action.index', ['actions' => $result['ResultData']]);
    }

    /**
     * 添加评论
     * @param $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $result = self::$actionServer->comment($data);
        if(!$result['status']) return response()->json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * 向活动表插入数据
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $result = self::$actionServer->actionOrder($data);
        if(!$result['status']) return response()->json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * 详情页.
     * @return array ：是否已经报名$isHas 活动详情$datas 登录状态$isLogin 点赞数量$likeNum 所有评论$comment+对应用户的信息
     * @param $request
     * @param $id
     * @author 郭庆
     */
    public function show($id)
    {
        //所需要数据的获取
        $data = self::$actionServer->getData($id);//活动详情
        $likeNum = self::$actionServer-> getLikeNum($id);//支持/不支持人数

        //$isHas（是否已经报名参加）的设置
        if (!isset(session('user')->guid)){
            $isLogin = false;
            $isHas = false;
        }else{
            $action = self::$actionServer->getAction(session('user')->guid);//当前用户报名参加的所有活动
            $isLogin = session('user')->guid;
            if ($action['status']){
                $isHas = in_array($data["msg"]->guid, $action['msg']);
            }else{
                $isHas = false;
            }
        }

        //返回详情页
        return view("home.action.details", [
            "data" => $data["msg"],
            'isLogin' => $isLogin,
            'isHas' => $isHas,
            'likeNum' => $likeNum['msg']
        ]);
    }

    /**
     * 点赞
     * @param $request
     * @param $id
     * @return array
     *
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {
        $support = $request->all();
        $user_id = session('user')->guid;

        //判断是否点赞了
        $isHas = self::$actionServer->getLike($user_id,$id);
        if($isHas['status']) {
            if ($isHas['msg']->support == $support['support']) return ['StatusCode' => 400,  'ResultData' => '已经参与'];
            $setLike = self::$actionServer->chargeLike($user_id, $id, $support);

            if ($setLike) return ['StatusCode' => 200,  'ResultData' => self::$actionServer-> getLikeNum($id)['msg']];
            return ['StatusCode' => 400,  'ResultData' => '点赞失败'];
        }else{

            //没有点赞则加一条新记录
            $result = self::$actionServer->setLike(['support' => $support['support'], 'action_id' => $id, 'user_id' => $user_id]);
            if($result['status']) return ['StatusCode' => 200,  'ResultData' => self::$actionServer-> getLikeNum($id)['msg']];
            return ['StatusCode' => 400, 'ResultData' => '点赞失败'];
        }
    }

    /**
     * 展示评论
     * @param $id
     * @return array
     * @author 郭庆
     */
    public function update($id)
    {
        $result = self::$actionServer->getComment($id);
        if (!$result['status']){
            return ['StatusCode' => 400, 'ResultData' => $result['msg']];
        }else{
            foreach ($result['msg'] as $v)
            {
                $res = self::$userServer->userInfo(['guid' => $v->user_id]);
                if($res['status']){
                    $v->user_name = $res['msg']->nickname;
                    $v->headpic = $res['msg']->headpic;
                }else{
                    $v->user_name = '无名英雄';
                    $v->headpic = '';
                }
            }
        }
        return ['StatusCode' => 200, 'ResultData' => $result['msg']];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * 上传图片
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file->isValid()){
            $realPath = $file->getRealPath();//临时文件的绝对路径
            $extension = $file->getClientOriginalName();//上传文件的后缀
            $hz = explode('.', $extension)[1];
            $newName = date('YmdHis').mt_rand(100,999).'.'.$hz;
            $path = $file->move(public_path('uploads/image/admin/road'), $newName);
            $result = 'uploads/image/admin/road/'.$newName;
            return response()->json(['res' => $result]);
        }
    }
}
