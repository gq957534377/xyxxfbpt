@extends('heroHome.layouts.master')

@section('title','欢迎来到英雄会登录中心!')


@section('style')
<link rel="stylesheet" href="{{ asset('heroHome/css/base.css') }}">
<link rel="stylesheet" href="{{ asset('heroHome/css/login.css') }}">
@endsection

@section('content')
    <!--登录主要内容 Start-->
    <div class="content-login">
        <div class="container loginpanel">
            <div class="login_title">登录</div>
            <form class="form-inline">
                <ul class="input_block_1">
                    <li>
                        <input type="text" placeholder="输入手机号/邮箱" />
                    </li>
                    <li>
                        <input type="password"  placeholder="输入密码" />
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
                    <span class="link_pwd"><a href="#">忘记密码？</a></span>
                </div>
            </form>
            <div class="btn_block">
                <button type="button" class="btn btn-warning btn-block btn-lg">立即登录</button>
                <button type="button" class="btn btn-default btn-block btn-lg">注册账号</button>
            </div>
        </div>
    </div>
    <!--登录主要内容 End-->
@endsection

