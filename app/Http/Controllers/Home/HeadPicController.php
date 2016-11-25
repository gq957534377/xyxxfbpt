<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tools\CropAvatar as Crop;

class HeadPicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.user.headpic.index');
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
       
        //判断上传文件是否存在
        if (!$request->hasFile('avatar_file'))  return response()->json(['StatusCode' => '400','ResultData' => '上传文件为空!']);
        $file = $request->file('avatar_file');
        
       
        $newFile['name'] = $file->getClientOriginalName();
        $newFile['type'] = $file->getClientMimeType();
        $newFile['tmp_name'] = $file->getRealPath();
        $newFile['error'] = $file->getError();
        $newFile['size'] = $file->getClientSize();

        $data = $request->all();
        $info = new Crop($data['avatar_src'],$data['avatar_data'],$newFile);

        if (empty($info)) return response()->json(['state' => 400,'result' => '上传文件失败!']);

        return response()->json(['state' => 200,'result' => $info->getResult()]);

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
