@extends('home.layouts.master')

@section('title','欢迎来到英雄会登录中心!')

@section('menu')

@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('home/css/base.css') }}">
<link rel="stylesheet" href="{{ asset('home/css/register.css') }}">
@endsection


<!--登录主要内容 Start-->
@section('content')
    <!--登录主要内容 Start-->
    <div class="row content-login">
    	<div class="container loginpanel">
    		<div class="login_title">注册账号</div>

            <div id="error-info" class="alert alert-danger"></div>

    		<form id="signUpForm" class="form-inline" action="{{ url('/register') }}" method="post">
                <input name="stage" type="text" hidden value="1">
                <ul class="input_block_1">
                    <li>
                        <input type="text" name="tel" placeholder="请输入您的手机号" />
                    </li>
                    <li>
                        <input class="code" name="code" type="text"  placeholder="请输入验证码" />
                        <img id="captcha" data-sesid="{{ $sesid }}" src="{{url('/code/captcha/' . $sesid)}}">
                    </li>
                </ul>
                <div class="input_block_2">
                    <span>
                      点击“立即注册”，即表示您同意并愿意遵守<a href="#">注册用户协议</a>
                    </span>
                </div>
                <div class="btn_block">
                    <button type="submit" class="btn btn-warning btn-block btn-lg">立即注册</button>
                    <a href="{{url('/login')}}" type="button" class="btn btn-default btn-block btn-lg">返回登录</a>
                </div>
    		</form>

    	</div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('home/js/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('home/js/registerValidate.js') }}"></script>
@endsection
