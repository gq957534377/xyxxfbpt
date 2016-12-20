<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;
use App\Services\UserService as UserServer;


class SendController extends Controller
{
    protected  static $articleServer;
    protected  static $userServer;
    public function __construct(UserServer $userServer, ArticleServer $articleServer)
    {
        self::$articleServer = $articleServer;
        self::$userServer = $userServer;
    }

    /**
     * 展示我的投稿页面
     *
     * @return
     * @author 王通
     */
    public function index(Request $request)
    {

        // 判断有没有传递参数
        $data = $request->all();
        // 判断有没有传过来数据
        if (empty($request['status']) || $request['status'] >= 5) {
            $data["status"] = 5;
        } else {
            $data["status"] = $request["status"];// 文章状态：开始前 进行中  结束
        }
        $data["user_id"] =  session('user')->guid;
        // 分页查询 得到指定类型的数据
        $result = self::$articleServer->selectTypeData($data);

        switch ($data['status'])
        {
            case 1: case 2:
                return view('home.user.contribution.indexRelease', $result);
                break;
            case 3:case 4:
                return view('home.user.contribution.indexRejection', $result);
                break;
            default:
                $result['sesid'] = md5(session()->getId());
                return view('home.user.contribution.index', $result);
                break;
        }


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function create(Request $request)
    {

    }

    /**
     * 用户投稿
     *
     * @return array
     * @author 郭庆
     * @modify 王通
     */
    public function store(Request $request)
    {

        $data = $request->all();

        // 判断验证法是否在正确
        if ($data['verif_code'] != session('code')) {
            return response()->json(['StatusCode' => '400', 'ResultData' => '验证码错误']);
            // 判断图片是否正确

        } else if (empty(session('picture_contri'))) {
            return response()->json(['StatusCode' => '400', 'ResultData' => '图片上传失败']);
        }
        $data['banner'] = session('picture_contri');
        unset($data['verif_code']);

        $data['user_id'] = session('user')->guid;
        // 取出用户信息
        $res = self::$userServer->userInfo(['guid' => $data['user_id']]);
        if ($res['StatusCode'] ==  '200'){
            $data['author'] = $res['ResultData']->nickname;
            $data['headpic'] = $res['ResultData']->headpic;
        }else{
            $data['author'] = '佚名';
            $data['headpic'] = '/home/images/logo.jpg';
        }
        $result = self::$articleServer->addArticle($data);
        return response()->json($result);
    }


    /**
     * 展示预览（未发布）
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function show(Request $request, $id)
    {

        if($id == 1){
            if (is_string($request['data'])){
                $data = json_decode($request['data']);
            }else{
                $data = $request['data'];
            }
            $user_id = session('user')->guid;
            $res = self::$userServer->userInfo(['guid' => $user_id]);
            if ($res['status'] && $data){
                $data->author = $res['msg']->nickname;
                $data->headpic = $res['msg']->headpic;
            }elseif ($data){
                $data->author = '佚名';
                $data->headpic = '/home/images/logo.jpg';
            }
            return view('home.article.new',['data' => $data]);
        }
        $result = self::$articleServer->getData($id, 2);
        if ($result['status']) return view('home.article.new',['data' => $result['msg']]);
        return view('home.article.new',['data' => $result['msg']]);
    }

    /**
     * 给前台传出对应id的所有数据
     *
     * @param  int  $id
     * @return array
     * @author 郭庆
     */
    public function edit($id)
    {
        $result = self::$articleServer->getData($id, 2);
        if ($result['status']) return ['StatusCode' => 200, 'ResultData' => $result['msg']];
        return ['StatusCode' => 400, 'ResultData' => $result['msg']];
    }

    /**
     * 修改文稿内容
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['user'] = 2;
        $result = self::$articleServer->upDta(['guid' => $id], $data);
        if($result['status']) return ['StatusCode' => 200, 'ResultData' => $result['msg']];
        return ['StatusCode' => 400, 'ResultData' => $result['msg']];
    }

    /**
     * 用户来搞删除.
     *
     * @param $id
     * @return array
     * @author 郭庆
     */
    public function destroy($id, Request $request)
    {
        if (empty($request['id']) || !is_array($request['id'])) {
            return response()->json(['StatusCode' => '400', 'ResultData' => '参数错误！']);
        }
        $result = self::$articleServer->changeStatus($request['id'], 5, 2);
        return response()->json($result);
    }

    public function selUserArticleList ()
    {

    }
}
