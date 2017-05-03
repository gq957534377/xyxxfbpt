<?php

namespace App\Http\Controllers\Home;

use App\Store\ActionStore;
use App\Store\ArticleStore;
use App\Store\GoodsStore;
use App\Store\NoticeStore;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Store\RollingPictureStore;


class HomeController extends Controller
{
    protected static $rollingPictureStore = null;
    protected static $actionStore = null;
    protected static $articleStore = null;
    protected static $noticeStore = null;
    protected static $goodsStore = null;

    public function __construct(
        ActionStore $actionStore,
        ArticleStore $articleStore,
        NoticeStore $noticeStore,
        RollingPictureStore $rollingPictureStore,
        GoodsStore $goodsStore
    )
    {
        self::$rollingPictureStore = $rollingPictureStore;
        self::$actionStore = $actionStore;
        self::$articleStore = $articleStore;
        self::$noticeStore = $noticeStore;
        self::$goodsStore = $goodsStore;
    }

    /**
     * 说明: 首页渲染
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function index()
    {
        // 活动
        $action = self::$actionStore->forPage(1, 3, []);
        $article = self::$articleStore->forPage(1, 3, ['status' => 1]);
        $notice = self::$noticeStore->forPage(1, 3, ['status' => 1]);
        $pic = self::$rollingPictureStore->getAllPic();
        $goods = self::$goodsStore->forPage(1,3,['status'=>1]);
        return response()->view('home.index.index', [
            'action' => $action,
            'article' => $article,
            'notice' => $notice,
            'pic' => $pic,
            'goods'=>$goods
        ]);
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
