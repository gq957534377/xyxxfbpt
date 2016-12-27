<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\TestService;

use App\Redis\ArticleCache;

class TestController extends Controller
{
    private static $article;    //项目service

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

        $pages= $request->page; //获取当前的偏移量

        $list = self::$article->getArticleList($nums,$pages);

        dd($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        //dd($request->input('id'));

       return view('welcome');
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
    public function show($id)
    {
        //
        $article = new ArticleCache();
        $data = $article->getArticleList();

        dd($data);

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
        //dd('edit');

        //dd($postUrl);
        $csrf_field = csrf_field();
        $html = <<<UPDATE
        <form action="/test/1" method="POST">
            $csrf_field
            <input type="hidden" name="_method" value="delete"/>
            <input type="text" name="title" value=""><br/><br/>
            
            <input type="submit" value="update"/>
        </form>
UPDATE;
        return $html;

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
