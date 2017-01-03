<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;
use App\Services\UserService as UserServer;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;


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

//        // 判断有没有传递参数

        $data = $request->all();
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $forPages = 5;//一页的数据条数
        // 判断现在查询的是哪一类数据
        if (empty(session('status'))) {
            if (empty($data["status"])) {
                session(['status' => '2']);
            } else {
                session(['status' => $data["status"]]);
            }
        } else {
            if (!empty($data["status"])) {
                session(['status' => $data["status"]]);
            }
        }
        // 设置索要查询的类型
        $data["status"] = session('status');
        $status = session('status');//文章状态：已发布 待审核 已下架
        $type = 1;//获取文章类型


        $where = [];
        if($status){
            $where["status"] = $status;
        }
        if($type!="null"){
            if ($type != 3){
                $where["type"] = $type;
            }
        }
        $where['user_id'] = session('user')->guid;

        // 分页查询 得到指定类型的数据
        $result = self::$articleServer->selectData($where, $nowPage, $forPages, "/send");
        $result['TypeDataNum'] = self::$articleServer->selectTypeDataNum($where)['ResultData'];
        $result['status'] = $data['status'];
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
                if (empty($data['write'])) {
                    return view('home.user.contribution.index', $result);
                } else {
                    $result['write'] = $data['write'];
                    return view('home.user.contribution.index', $result);
                }

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
        }
        // 验证过滤数据
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:80',
            'brief' => 'required|max:150',
            'describe' => 'required',
            'source' => 'required|max:80',
            'verif_code' => 'required',
            'banner' => 'required',
            'status' => 'required',
        ],[
            'title.required' => '标题不能为空',
            'title.max' => '标题过长',
            'brief.required' => '导语不能为空',
            'brief.max' => '简介过长',
            'describe.required' => '内容不能为空',
            'source.required' => '来源不能为空',
            'source.max' => '来源过长',
            'verif_code.required' => '验证码不能为空',
            'banner.required' => '图片不能为空',
            'status.required' => '参数错误',
        ]);
        if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);
//        if (empty(Redis::get('picture_contri' . session('user')->guid))) {
//            return response()->json(['StatusCode' => '400', 'ResultData' => '图片上传失败']);
//        }
//        $data['banner'] = Redis::get('picture_contri' . session('user')->guid);
//

        //Redis::set('picture_contri' . session('user')->guid, null);

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
     * @modify 王通
     */
    public function show($id)
    {
        $result = self::$articleServer->getCacheContribution($id);
        return view('home.user.contribution.browse', $result);

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
        $result = self::$articleServer->getData($id);
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
        $result = self::$articleServer->upDta([' ' => $id], $data);
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

    public function selUserArticleList()
    {

    }

    /**
     * js得到文章信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 王通
     */
    public function getArticleInfo(Request $request)
    {
        if (!empty($request['guid'])) {
            $result = self::$articleServer->getData($request['guid']);

        } else {
            $result = ['StatusCode' => '400', 'ResultData' => "参数错误！"];
        }

        return response()->json($result);

    }

}
