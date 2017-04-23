<?php

namespace App\Http\Controllers\Home;

use App\Services\GoodsService;
use App\Store\GoodsStore;
use App\Tools\Common;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserGoodsController extends Controller
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
        $data = self::$goodsService->selectData(['status' => 1, 'author' => session('user')->guid], $nowPage, 5, 'goods');
        return view('home.user.goods.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.user.goods.add');
    }

    /**
     * 说明: 个人中心发布商品
     *
     * @param Request $request
     * @return mixed
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        // 数据验证过滤
        $validator = \Validator::make($data, [
            'name' => 'required|max:64',
            'price' => 'required|integer',
            'content' => 'required',
            'brief' => 'required|max:120',
            'qq' => 'required|integer',
            'tel' => 'required|integer',
            'wechat' => 'required',
            'banner' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all());
        }

        $data['addtime'] = time();
        $data['author'] = session('user')->guid;
        $data['guid'] = Common::getUuid();
        $result = self::$goodsStore->insertData($data);
        if (empty($result)) return back()->withErrors('添加失败');
        return back()->withErrors('发布成功', 'success');
    }

    /**
     * 说明: 修改页面展示
     *
     * @param $id
     * @return mixed
     * @author 郭庆
     */
    public function show($id)
    {
        if (empty($id)) return view('errors.404');
        $data = self::$goodsStore->getOneData(['guid' => $id]);
        if (empty($data)) return view('errors.404');
        return view('home.user.goods.edit', ['data' => $data]);
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
     * 说明: 修改提交操作
     *
     * @param Request $request
     * @param $id
     * @return $mixed
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        // 数据验证过滤
        $validator = \Validator::make($data, [
            'name' => 'required|max:64',
            'price' => 'required|integer',
            'content' => 'required',
            'brief' => 'required|max:120',
            'qq' => 'required|integer',
            'tel' => 'required|integer',
            'wechat' => 'required',
            'banner' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all());
        }

        $result = self::$goodsStore->upload(['guid' => $id], $data);
        if (!empty($result)) return back()->withErrors('修改成功！', 'success');

        if ($result == 0) return back()->withErrors('未作任何更改！');
        return back()->withErrors('修改失败！');
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

    /**
     * 返回七牛存储Token
     * @return \Illuminate\Http\JsonResponse
     * author guoqing
     */
    public function getToken()
    {
        $token = Common::getToken();
        $result = ['uptoken' => $token];
        return response()->json($result);
    }
}
