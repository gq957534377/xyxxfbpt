<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\ProjectService as ProjectServer;
use App\Services\ActionService as ActionServer;
use App\Services\ArticleService as ArticleServer;
use App\Services\PictureService;
use App\Store\RollingPictureStore;
use App\Tools\Common;


class HomeController extends Controller
{
    protected static $projectServer = null;
    protected static $actionServer = null;
    protected static $pictureService = null;
    protected static $articleServer = null;
    protected static $rollingPictureStore = null;

    /**
     * 构造函数注入
     * HomeController constructor.
     * @param ProjectService $projectServer
     * @ author 郭庆
     */
    public function __construct(
        ProjectServer $projectServer,
        ActionServer $actionServer,
        PictureService $pictureService,
        ArticleServer $articleServer,
        RollingPictureStore $rollingPictureStore
    )
    {
        self::$projectServer = $projectServer;
        self::$actionServer = $actionServer;
        self::$pictureService = $pictureService;
        self::$articleServer = $articleServer;
        self::$rollingPictureStore = $rollingPictureStore;
    }

    /**
     * 首页渲染.
     *
     * @return \Illuminate\Http\Response
     * @ author 郭庆
     */
    public function index()
    {
        // 精选项目,随机拿取3条
        $projectResult = self::$projectServer->takeData();

        // 路演活动
        $roadShowResult = self::$actionServer->selectData(['type'=>1], 1, 3, 'action/create', false, false);
        // 创业大赛
        $sybResult = self::$actionServer->selectData(['type'=>2], 1, 3, 'action/create', false, false);
        // 学习培训活动
        $schollResult = self::$actionServer->selectData(['status'=>1], 1, 2, 'school/create', true, false);

        // 咨询
        $articles = self::$articleServer->getTakeArticles(1);

        // 投资合作机构管理，
        $picArr = self::$pictureService->getPictureIn([3, 5]);
        // 轮播图
        $rollingPic = self::$pictureService->getRollingPicture();
        // 设置cookie
        $cookie = Common::generateCookie('feedback');
        return response()->view('home.index.index', [
            'projects'      => $projectResult['ResultData'],
            'roadShows'     => $roadShowResult,
            'sybs'          => $sybResult,
            'schools'       => $schollResult,
            'picArr'        => $picArr['ResultData'],
            'rollingPic'    => $rollingPic['ResultData'],
            'articles'      => $articles['ResultData'],
        ])->withCookie($cookie);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function aboutWe(Request $request)
    {
        $type = $request->input('type');
        return view('home.about.index', ['type' => $type]);
    }
}
