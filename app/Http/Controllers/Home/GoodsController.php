<?php

namespace App\Http\Controllers\Home;

use App\Services\GoodsService;
use App\Store\GoodsStore;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    private static $goodsService;
    private static $goodsStore;
    public function __construct(GoodsService $goodsService, GoodsStore $goodsStore)
    {
        self::$goodsService = $goodsService;
        self::$goodsStore = $goodsStore;
    }
    /**
     * 说明: 商品列表页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $nowPage = $data['nowPage'] ?? 1;//获取当前页
        $data = self::$goodsService->selectData(['status' => 1], $nowPage, 10, 'goods');
        return view('home.goods.index', $data);
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
     * 说明: 展示详情页面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 郭庆
     */
    public function show($id)
    {
        if (empty($id)) return view('errors.404');

        $data = self::$goodsStore->getOneData(['guid'=>$id]);
        if (empty($data) || $data->status != 1) view('errors.404');

        return view('home.goods.details',[
            'data'=>$data
        ]);
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
}
