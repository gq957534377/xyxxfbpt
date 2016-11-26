<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;
use App\Services\UserService as UserServer;

class SendController extends Controller
{
    protected  static $articleServer;
    protected  static $userServer;
    public function __construct(UserServer $userServer, ArticleServer $articleServer)
    {
        self::$articleServer = $articleServer;
        self::$userServer = $userServer;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if ($request['status']){
            $status = $request['status'];
        }else{
            $status = 1;
        }
        $user_id = $request -> session() -> get('user') -> guid;
        $result = self::$articleServer->getArticleByUser($user_id, $status);
        if ($result['status'] || empty($result['msg'])) return view('home.article.grzx', ['article' => $result['msg'], 'status' => $status]);
        return view('home.article.grzx')->withErrors('获取文稿信息失败');
    }

    /**
     * 展示详情
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request->all());
        if(!$request['id']){
            return view('home.article.new',['data' => $request->all()]);
        }
        $id = $request['id'];
        $result = self::$articleServer->getData($id, 2);
        if ($result['status']) return view('home.article.new',['data' => $result['msg']]);
        return view('home.article.new',['data' => $result['msg']]);
    }

    /**
     * 用户投稿
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $data = $request->all();

        //预览
        if($data['status']==5){
            dd($request['data']);
            return view('home.article.new',['data' => $data]);
        }


        $data['user_id'] = $request -> session() -> get('user') -> guid;
        $res = self::$userServer -> userInfo(['guid' => $data['user_id']]);
        if ($res['status']){
            $data['author'] = $res['msg'] -> nickname;
            $data['headpic'] = $res['msg'] -> headpic;
        }else{
            $data['author'] = '佚名';
            $data['headpic'] = '/home/images/logo.jpg';
        }
        $result = self::$articleServer->addSend($data);
        if ($result['status']) return ['StatusCode' => 200, 'ResultData' => $result['msg']];
        return ['StatusCode' => 400, 'ResultData' => $result['msg']];
    }

    /**
     * 展示详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = self::$articleServer->getData($id, 2);
        if ($result['status']) return view('home.article.new',['data' => $result['msg']]);
        return view('home.article.new',['data' => $result['msg']]);
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
