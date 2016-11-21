<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;

class ActionController extends Controller
{
    protected static $request;
    protected  static $actionServer;
    public function __construct(Request $request,ActionServer $actionServer)
    {
        self::$actionServer = $actionServer;
        self::$request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = self::$request->all()['type'];
        $result = self::$actionServer->selectByType($type);
        if ($result['status'])return view('Home.action.index',['msg'=>$result['msg']]);
        return view('Home.action.index',['msg'=>$result['msg']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *向活动表插入数据
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function store()
    {
        $data = self::$request->all();
        $result = self::$actionServer->actionOrder($data);
        if(!$result['status'])return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $session = self::$request->session()->all();
        $data = self::$actionServer->getData($id);
        if($data["status"]){
            $action = self::$actionServer->getAction($session['user']->guid);
            $isHas = in_array($data["msg"]["data"][0]->guid,$action);
            return view("home.action.xiangqing",["data"=>$data["msg"]["data"][0],'session'=>$session,'id'=>$id,'isHas'=>$isHas]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


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
