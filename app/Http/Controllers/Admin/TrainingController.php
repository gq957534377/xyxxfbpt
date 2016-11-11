<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\TrainingService as TrainingService;

class TrainingController extends Controller
{
    protected static $TrainingService = null;

    /**
     * TrainingController constructor.
     * @param TrainingService $trainingService
     * @author 王拓
     */
    public function __construct(TrainingService $trainingService)
    {
        self::$TrainingService = $trainingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = self::$TrainingService->getAllTraining();
        switch ($result['status']) {
            case 500:
                return view('admin.training.list', ['status' => 500, 'msg' => $result['msg']]);
                break;
            case 200:
                return view('admin.training.list', ['status' => 200, 'msg' => $result['msg']]);
        }
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
        $data = $request->all();
        //验证
        $this->validate($request, [
            'title' => 'required',
            'groupname' => 'required',
        ]);
        $result = self::$TrainingService->addTraining($data);
        switch ($result) {
            case 'error';
                return back()->withErrors("写入失败");
                break;
            case 'yes':
                return redirect('/training');
                break;
        }
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
