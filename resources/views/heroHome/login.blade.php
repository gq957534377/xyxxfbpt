﻿@extends('heroHome.layouts.master')

@section('title','欢迎来到英雄会登录中心!')


@section('style')
          <link rel="stylesheet" href="{{ asset('heroHome/css/base.css') }}">
          <link rel="stylesheet" href="{{ asset('heroHome/css/login.css') }}">
      @endsection


		<!--登录主要内容 Start-->
@section('content')

    <div class="content-login">
		@include('admin.public.errors')
		@include('admin.public.success')
    	<div class="container loginpanel">
    		<div class="login_title">登录</div>
    		<form id="signOnForm" class="form-inline" action="{{url('/login')}}" method="post">
	    		<ul class="input_block_1">
	    			<li>
	    				<input type="text" name="tel"  placeholder="输入手机号" />
	    			</li>
	    			<li>
	    				<input type="password" name="password" placeholder="输入密码" />
	    			</li>
	    		</ul>
	    		<div class="input_block_2">
	    			<div class="checkbox select_block">
	    				<label >
	    					<input type="checkbox"/>
	    					<span class="input_checkbox"><i class="fa fa-check"></i></span>
	    					<span class="input_checkbox_title">记住密码</span>
	    				</label>
	    			</div>
	    			<span class="link_pwd"><a href="pages-recoverpw.html">忘记密码？</a></span>
	    		</div>
				<div class="btn_block">
					<button type="submit" id="login" class="btn btn-warning btn-block btn-lg">立即登录</button>
					<a href="{{url('/register')}}" type="button" class="btn btn-default btn-block btn-lg">注册账号</a>
				</div>
    		</form>

    	</div>
    </div>
	@include('home.login.script')
	@include('home.validator.loginValidator')
	@include('home.layouts.promptModal')
    @endsection

@section('script')

@endsection



