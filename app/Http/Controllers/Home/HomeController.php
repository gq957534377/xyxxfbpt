<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ProjectService as ProjectServer;
use App\Services\ActionService as ActionServer;
use App\Services\ArticleService as ArticleServer;
use App\Services\PictureService;


class HomeController extends Controller
{
    protected static $projectServer = null;
    protected static $actionServer = null;
    protected static $pictureService = null;
    protected static $articleServer = null;

    /**
     * 构造函数注入
     * HomeController constructor.
     * @param ProjectService $projectServer
     * @ author 刘峻廷
     */
    public function __construct(
        ProjectServer $projectServer,
        ActionServer $actionServer,
        PictureService $pictureService,
        ArticleServer $articleServer
    ){
        self::$projectServer = $projectServer;
        self::$actionServer = $actionServer;
        self::$pictureService = $pictureService;
        self::$articleServer = $articleServer;
    }

    /**
     * 首页渲染.
     *
     * @return \Illuminate\Http\Response
     * @ author 刘峻廷
     */
    public function index()
    {
        // 精选项目,随机拿取3条
        $projectResult = self::$projectServer->takeData();

        if ($projectResult['StatusCode'] == '200') {
            // 推送内容限定字数
            self::$actionServer->wordLimit($projectResult['ResultData'], 'content',60);
        }

        // 路演活动
        $roadShowResult = self::$actionServer->takeActions(1);
        // 创业大赛
        $sybResult = self::$actionServer->takeActions(2);
        // 学习培训活动
        $schollResult = self::$actionServer->takeSchoolData(2);

        // 咨询
        $articles = self::$articleServer->getTakeArticles(1);

        // 轮播图，投资合作管理，
        $cooperResult = self::$pictureService->getPicture(2);
        // 合作机构
        $carouselResult = self::$pictureService->getPicture(3);
        // 投资机构
        $investResult = self::$pictureService->getPicture(5);
        // 设置cookie
        $cookie = \App\Tools\Common::generateCookie('feedback');
        return response()->view('home.index.index', [
            'projects'      => $projectResult['ResultData'],
            'roadShows'     => $roadShowResult['ResultData'],
            'sybs'          => $sybResult['ResultData'],
            'schools'        => $schollResult['ResultData'],
            'cooper'        => $cooperResult['ResultData'],
            'carousel'      => $carouselResult['ResultData'],
            'invest'        => $investResult['ResultData'],
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
