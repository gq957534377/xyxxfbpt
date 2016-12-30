<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\TestService;

use App\Redis\ArticleCache;

class TestController extends Controller
{
    private static $article;    //文章service

    public function __construct(TestService $testService)
    {
        self::$article = $testService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //dd(HASH_PROJECT_INFO_);
        $nums = 5;  //一次获取数据的条数

        $pages= $request->page ? $request->page : 1; //获取当前的偏移量

        $list = self::$article->getArticleList($nums,$pages);
        //dd($list);
        return view('article', ['data'=>$list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = \DB::table('data_picture')->whereIn('type',[2,3,5])->where('status','<>',4)->get();
        dd($data);

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
        dd('store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $data = self::$article->getOneArticle($request->guid);
        //dd($data);
        return view('articledetail',['ResultData'=>$data]);


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
        dd('update');

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
        dd('destory');
    }
}
