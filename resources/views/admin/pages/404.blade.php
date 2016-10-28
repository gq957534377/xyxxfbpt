@extends('admin.layouts.master')
@section('content')
@section('title', '404')




<!-- Page Content Start -->
<!-- ================== -->

<div class="wrapper-page">

    <div class="ex-page-content text-center">
        <h1>404</h1>
        <h2 class="font-light">对不起,页面未找到!</h2><br>
        <p>您可以尝试着去搜索：</p>
        <div class="row">
            <div class="input-group">
                <input type="text" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">查找</button>
                                  </span>
            </div>
        </div><br>
        <a class="btn btn-purple" href="{{url('index')}}"><i class="fa fa-angle-left"></i>返回到后台首页</a>
    </div>

</div>


<!-- Page Content Ends -->
<!-- ================== -->

@endsection
@section('script')
@endsection
