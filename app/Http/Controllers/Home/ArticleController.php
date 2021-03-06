<?php

namespace App\Http\Controllers\Home;

use App\Redis\ArticleCache;
use App\Tools\CustomPage;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;
use App\Services\UserService as UserServer;
use App\Services\CommentAndLikeService as CommentServer;

class ArticleController extends Controller
{
    protected static $articleServer;
    protected static $userServer;
    protected static $commentServer;
    protected static $articleCache;
    protected static $forPages = 5;

    public function __construct(
        ArticleServer $articleServer,
        UserServer $userServer,
        CommentServer $commentServer,
        ArticleCache $articleCache
    )
    {
        self::$articleServer = $articleServer;
        self::$userServer = $userServer;
        self::$commentServer = $commentServer;
        self::$articleCache = $articleCache;
    }

    /**
     * 根据所选文章类型导航，返回相应的列表页+数据.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function index(Request $request)
    {
        // 获取活动类型 -> 活动类型的对应状态的所有数据
        $data = $request->all();
        if (empty($data['type'])) return view('errors.404');
        $where['type'] = $data['type'];
        $where['status'] = 1;
        $nowPage = 1;
        $result = self::$articleServer->selectData($where, $nowPage, self::$forPages, '/article/create');
        $result['type'] = $data['type'];
        return view('home.article.index', $result);
    }

    /**
     *  查询分页数据，瀑布流
     *
     * @return \Illuminate\Http\Response
     * @author 杨志宇
     */
    public function create(Request $request)
    {
        // 获取活动类型 -> 活动类型的对应状态的所有数据
        $data = $request->all();
        $where = [];
        if (!empty($data['type'])) {
            $where['type'] = $data['type'];
        }
        $where['status'] = 1;
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"] : 2;   // 获取当前页

        $result = self::$articleServer->selectData($where, $nowPage, self::$forPages, '/article/create');
        $result['type'] = $data['type'];
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     * 向文章表插入数据
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $result = self::$articleServer->articleOrder($data);
        if (!$result['status']) return response()->json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * 显示文章详情
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @author 杨志宇
     * @modify 杨志宇
     */
    public function show($id)
    {
        $data = CustomPage::arrayToObject(self::$articleCache->getOneArticle($id));
        if (!$data) return view('errors.404');

        $rand = self::$articleServer->getRandomArticles($data->type, 4, 1);

        $likeNum = self::$commentServer->likeCount($id);//点赞人数
        // 获取评论表+like表中某一个文章的评论
        $comment = self::$commentServer->getComent($id, 1);
        $pageStyle = self::$commentServer->getPageStyle($id, 1);

        if (empty(session('user')->guid)) {
            $likeStatus = 2;
            $isLogin = false;
        } else {
            $likeStatus = self::$commentServer->likeStatus(session('user')->guid, $id);//当前用户点赞状态
            $isLogin = session('user')->guid;
        }
        $result = [
            'data' => $data,
            'isLogin' => $isLogin,
            'likeNum' => $likeNum,
            'likeStatus' => $likeStatus,
            'comment' => $comment,
            'contentId' => $id,
            'rand' => $rand,
            'pageStyle' => $pageStyle
        ];
        // 判断有没有评论信息
        return view('home.article.articlecontent', $result);
    }

    /**
     * 点赞
     * @param $request
     * @param $id
     * @return array
     * @author 郭庆
     */
    public function edit($id)
    {
        if (empty(session('user'))) {
            return view('home.login');
        }
        $user_id = session('user')->guid;

        //判断是否点赞了
        $isHas = self::$articleServer->getLike($user_id, $id);

        if ($isHas['status']) {
            if ($isHas['msg']->support == 1) {
                $setLike = self::$articleServer->chargeLike($user_id, $id, ['support' => 2]);
            } else {
                $setLike = self::$articleServer->chargeLike($user_id, $id, ['support' => 1]);
            }

            if ($setLike) return ['StatusCode' => '200', 'ResultData' => self::$articleServer->getLikeNum($id)['msg']];
            return ['StatusCode' => '400', 'ResultData' => '点赞失败'];
        } else {

            //没有点赞则加一条新记录
            $result = self::$articleServer->setLike(['support' => 1, 'action_id' => $id, 'user_id' => $user_id]);
            if ($result['status']) return ['StatusCode' => '200', 'ResultData' => self::$articleServer->getLikeNum($id)['msg']];
            return ['StatusCode' => '400', 'ResultData' => '点赞失败'];
        }
    }

    /**
     * 展示评论
     * @param $id
     * @return array
     *
     * @author 郭庆
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * 点赞
     * @param $request
     * @param $id
     * @return array
     * @author 郭庆
     * @modify 杨志宇
     */
    public function like(Request $request)
    {
        if (empty(session('user')) || empty($request['art_guid'])) {
            return view('home.login');
        }
        $id = $request['art_guid'];
        $user_id = session('user')->guid;

        $result = self::$articleServer->like($user_id, $id);
        return response()->json($result);

    }

    /**
     * 新增评论
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @author 杨志宇
     * @modify 杨志宇
     */
    public function setComment(Request $request)
    {
        if (!isset(session('user')->guid)) return response()->json(['StatusCode' => '401', 'ResultData' => '请登录后在评论']);

        $data = $request->all();
        // 验证参数
        $validator = Validator::make($data, [
            'content' => 'required|max:60',
            'action_id' => 'required',
            'type' => 'required'
        ], [
            'content.required' => '评论内容不能为空',
            'action_id.required' => '非法请求',
            'type.required' => '缺少重要参数',
            'content.max' => '评论过长',
        ]);
        if ($validator->fails()) {
            return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);
        }

        $data['user_id'] = session('user')->guid;

        // 保存评论
        $result = self::$commentServer->comment($data);

        return response()->json($result);
    }

    /**
     * 评论详情页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 杨志宇
     */
    public function commentShow()
    {
        return view('home.comment.index');
    }


}