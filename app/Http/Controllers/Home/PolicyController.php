<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;


class PolicyController extends Controller
{
    protected  static $articleServer;
    protected  static $userServer;

    /**
     * 注入
     * @param \App\Http\Controllers\\ArticleServer $articleServer
     * @param \App\Http\Controllers\\UserServer $userServer
     * @author 王通
     */
    public function __construct(ArticleServer $articleServer)
    {
        self::$articleServer = $articleServer;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = self::$articleServer->selectByType(2);
        return view('home.article.market', $res);
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
     * 显示文章详情
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function show($id)
    {
        $res = self::$articleServer->getData($id);

        return view('home.article.articlecontent', $res);
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
