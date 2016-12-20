<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ProjectService as ProjectServer;
use App\Services\ActionService as ActionServer;
use App\Services\PictureService;


class HomeController extends Controller
{
    protected static $projectServer = null;
    protected static $actionServer = null;
    protected static $pictureService = null;

    /**
     * 构造函数注入
     * HomeController constructor.
     * @param ProjectService $projectServer
     * @ author 刘峻廷
     */
    public function __construct(ProjectServer $projectServer, ActionServer $actionServer, PictureService $pictureService)
    {
        self::$projectServer = $projectServer;
        self::$actionServer = $actionServer;
        self::$pictureService = $pictureService;
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
        $trainResult = self::$actionServer->takeActions(3, null, 2);

        if ($trainResult['StatusCode'] == '200') {
            // 推送内容限定字数
            self::$actionServer->wordLimit($trainResult['ResultData'], 'brief',60);
        }

        // 轮播图，投资合作管理，
        $cooperResult = self::$pictureService->getPicture(2);
        // 合作机构
        $carouselResult = self::$pictureService->getPicture(3);

        // 投资机构
        $investResult = self::$pictureService->getPicture(5);

        $cooper = $cooperResult['ResultData'];

        $carousel = $carouselResult['ResultData'];
        $invest = $investResult['ResultData'];
        $projects = $projectResult['ResultData'];
        $roadShows  = $roadShowResult['ResultData'];
        $sybs = $sybResult['ResultData'];
        $trains = $trainResult['ResultData'];

        return view('home.index.index', compact('projects','roadShows', 'sybs', 'trains', 'cooper', 'carousel', 'invest'));
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
