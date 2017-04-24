<?php

namespace App\Http\Controllers\Home;

use App\Store\ArticleStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;
use App\Services\UserService as UserServer;
use Illuminate\Support\Facades\Validator;
use App\Tools\Common;


class SendController extends Controller
{
    protected static $articleServer;
    protected static $userServer;
    protected static $articleStore;

    public function __construct(UserServer $userServer, ArticleServer $articleServer, ArticleStore $articleStore)
    {
        self::$articleServer = $articleServer;
        self::$userServer = $userServer;
        self::$articleStore = $articleStore;
    }

    /**
     * 展示我的投稿页面
     *
     * @return
     * @author 杨志宇
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"] : 1;//获取当前页
        $forPages = 5;//一页的数据条数
        $where = [];
        $url = "send";
        if (!empty($data['status'])) {
            $where['status'] = $data['status'];
            $url = $url . "?status=" . $data['status'];
        }
        $where['user_id'] = session('user')->guid;

        $num[1] = self::$articleStore->getCount(['status' => 1, 'user_id' => $where['user_id']]);
        $num[2] = self::$articleStore->getCount(['status' => 2, 'user_id' => $where['user_id']]);
        $num[3] = self::$articleStore->getCount(['status' => 3, 'user_id' => $where['user_id']]);
        $num[4] = self::$articleStore->getCount(['status' => 4, 'user_id' => $where['user_id']]);

        // 分页查询 得到指定类型的数据
        $result = self::$articleServer->select($where, $nowPage, $forPages, $url);
        if (empty($data['status'])) {
            $result['status'] = null;
        } else {
            $result['status'] = $data['status'];
        }
        $result['num'] = $num;

        return view('home.user.article.index', $result);
    }

    /**
     * 返回投稿页面
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function create()
    {
        return view('home.user.article.add');
    }

    /**
     * 说明: 投稿
     *
     * @param Request $request
     * @return mixed
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data)) return back()->withErrors('数据参数有误');

        // 验证过滤数据
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:80',
            'brief' => 'required|max:150',
            'describe' => 'required',
            'source' => 'required|max:80',
            'banner' => 'required',
            'status' => 'required',
        ], [
            'title.required' => '标题不能为空',
            'title.max' => '标题过长',
            'brief.required' => '导语不能为空',
            'brief.max' => '简介过长',
            'describe.required' => '内容不能为空',
            'source.required' => '来源不能为空',
            'source.max' => '来源过长',
            'banner.required' => '图片不能为空',
            'status.required' => '参数错误',
        ]);
        if ($validator->fails()) return back()->withErrors($validator->errors()->all());

        $data['user_id'] = session('user')->guid;
        // 取出用户信息
        $res = self::$userServer->userInfo(['guid' => $data['user_id']]);
        if ($res['StatusCode'] == '200') {
            $data['author'] = $res['ResultData']->username;
            $data['headpic'] = $res['ResultData']->headpic;
        } else {
            $data['author'] = '佚名';
            $data['headpic'] = '/home/images/logo.jpg';
        }
        $data['addtime'] = time();

        if ($data['status'] == 'yl') return view('home.article.articlecontent', ['data' => json_decode(collect($data)->toJson())]);

        $data['guid'] = Common::getUuid();
        $data['user'] = 2;
        $result = self::$articleStore->insertData($data);
        if (empty($result)) return back()->withErrors('操作失败');
        return back()->withErrors('操作成功！', 'success');
    }


    /**
     * 修改页面旧数据展示
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @author 郭庆
     * @modify 杨志宇
     */
    public function show($id)
    {
        if (empty($id)) return view('errors.404');

        $result = self::$articleStore->getOneData(['guid' => $id]);
        if (empty($result)) return view('errors.404');
        return view('home.user.article.edit', ['data' => $result]);
    }

    /**
     * 修改文章状态
     *
     * @param  int $id
     * @return array
     * @author 郭庆
     */
    public function edit($id, Request $request)
    {
        $data = $request->all();
        if (empty($id) || empty($data['status'])) return response()->json(['StatusCode' => '400', 'ResultData' => '参数有误']);

        $result = self::$articleStore->upload(['guid' => $id], ['status' => $data['status']]);
        if (empty($result)) return response()->json(['StatusCode' => '500', 'ResultData' => '操作失败']);
        return response()->json(['StatusCode' => '200', 'ResultData' => '操作成功']);
    }

    /**
     * 修改文稿内容 or 预览
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return mixed
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method');
        // 验证过滤数据
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:80',
            'brief' => 'required|max:150',
            'describe' => 'required',
            'source' => 'required|max:80',
            'banner' => 'required',
            'status' => 'required',
        ], [
            'title.required' => '标题不能为空',
            'title.max' => '标题过长',
            'brief.required' => '导语不能为空',
            'brief.max' => '简介过长',
            'describe.required' => '内容不能为空',
            'source.required' => '来源不能为空',
            'source.max' => '来源过长',
            'banner.required' => '图片不能为空',
            'status.required' => '参数错误',
        ]);
        if ($validator->fails()) return back()->withErrors($validator->errors()->all());

        if ($data['status'] == 'yl'){
            $data['user_id'] = session('user')->guid;
            // 取出用户信息
            $res = self::$userServer->userInfo(['guid' => $data['user_id']]);
            if ($res['StatusCode'] == '200') {
                $data['author'] = $res['ResultData']->username;
                $data['headpic'] = $res['ResultData']->headpic;
            } else {
                $data['author'] = '佚名';
                $data['headpic'] = '/home/images/logo.jpg';
            }
            $data['addtime'] = time();

            return view('home.article.articlecontent', ['data' => json_decode(collect($data)->toJson())]);
        }else{
            $result = self::$articleStore->upload(['guid'=>$id],$data);
            if (!empty($result)) return back()->withErrors('操作成功！','success');
            if ($result == 0) return back()->withErrors('未作任何更改！');
            return back()->withErrors('操作失败');
        }
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
     * @author 杨志宇
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
