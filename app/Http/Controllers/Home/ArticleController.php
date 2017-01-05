<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use Validator;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;
use App\Services\UserService as UserServer;
use App\Services\CommentAndLikeService as CommentServer;

class ArticleController extends Controller
{
    protected  static $articleServer;
    protected  static $userServer;
    protected  static $commentServer;
    protected static $forPages = 5;

    public function __construct(ArticleServer $articleServer, UserServer $userServer, CommentServer $commentServer)
    {
        self::$articleServer = $articleServer;
        self::$userServer = $userServer;
        self::$commentServer = $commentServer;
    }
    /**
     * 根据所选文章类型导航，返回相应的列表页+数据.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     * @modify 王通
     */
    public function index(Request $request)
    {

        if (!empty($request['type'])) {
            $where["status"] = 1;
            $where['type'] = $request['type'];
            $result = self::$articleServer->selectArticle($where, 1, self::$forPages, "/article/create", false);
            dd($result);
            $result['type'] = $request['type'];
            $randomList = self::$articleServer->getRandomArticles($where['type'], 4, 1);
            $result['ResultData']['RandomList'] = $randomList;

            return view('home.article.index', $result);
        }

        return view('errors.404');
    }

    public function waterfall(Request $request)
    {

    }
    /**
     *  查询分页数据，瀑布流
     *
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:2;   // 获取当前页
        $forPages = self::$forPages;                      // 一页的数据条数
        $type = $data["type"];              // 获取文章类型
        $where = [];
        $where["status"] = 1;

        if($type!="null"){
            if ($type != 3){
                $where["type"] = $type;
            }
        }
        $result = self::$articleServer->selectArticle($where, $nowPage, $forPages, "/article/create",false);
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     * 向文章表插入数据
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request -> all();
        $result = self::$articleServer -> articleOrder($data);
        if(!$result['status']) return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * 显示文章详情
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王通
     * @modify 张洵之
     */
    public function show($id)
    {
        $result = self::$articleServer->getData($id);

        $result['ResultData']->likeNum = self::$commentServer->likeCount($id);
        // 判断有没有文章信息
        if ($result['StatusCode'] == '200') {
            $randomList = self::$articleServer->getRandomArticles($result['ResultData']->type, 4, 1);
            $result['RandomList'] = $randomList;

            // 获取评论表+like表中某一个文章的评论
            $comment = self::$commentServer->getComent($id, 1);
            // 判断有没有评论信息
            $result['ResultData']->comment = $comment;
        }
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

        if($isHas['status']) {
            if ($isHas['msg']->support == 1) {
                $setLike = self::$articleServer->chargeLike($user_id, $id, ['support' => 2]);
            } else {
                $setLike = self::$articleServer->chargeLike($user_id, $id, ['support' => 1]);
            }

            if ($setLike) return ['StatusCode' => '200',  'ResultData' => self::$articleServer-> getLikeNum($id)['msg']];
            return ['StatusCode' => '400',  'ResultData' => '点赞失败'];
        }else{

            //没有点赞则加一条新记录
            $result = self::$articleServer -> setLike(['support' => 1, 'action_id' => $id, 'user_id' => $user_id]);
            if($result['status']) return ['StatusCode' => '200',  'ResultData' => self::$articleServer-> getLikeNum($id)['msg']];
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
     * @param  int  $id
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
     * @modify 王通
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王通
     * @modify 张洵之
     */
    public function setComment(Request $request)
    {
        if(!isset(session('user')->guid)) return response()->json(['StatusCode' => '401','ResultData' => '请登录后在评论']);

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
            return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);
        }

        $data['user_id'] = session('user')->guid;

        // 保存评论
        $result = self::$commentServer->comment($data);

        return response()->json($result);
    }

    /**
     * 评论详情页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 张洵之
     */
    public function commentShow()
    {
       return view('home.comment.index');
    }


}