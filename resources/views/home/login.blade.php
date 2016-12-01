<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset('img/favicon_1.ico')}}">
        <title>英雄会 - 大学生创业项目平台 </title>
        @include('home.login.style')
    </head>
    <body>
        <div class="wrapper-page">
            <div class="panel panel-color panel-inverse">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10"> 登录 <strong>Hero</strong> </h3>
                </div>

                <div class="panel-body">
                    @include('admin.public.errors')
                    @include('admin.public.success')
                    <form id="signOnForm" class="form-horizontal m-t-10 p-20 p-b-0" action="{{url('/login')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="email" placeholder="邮箱">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" placeholder="密码">
                            </div>
                        </div>
                        {{--验证码 Start--}}
                        <div class="form-group">
                            <div class="col-xs-7">
                                <input  name="captcha" class="form-control" type="text" placeholder="验证码...">
                            </div>
                            <div class="col-xs-5">
                                <img id="captcha" src="{{url('/code/captcha/1')}}">
                            </div>
                        </div>
                        {{--验证码 End--}}
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <label class="cr-styled">
                                    <input type="checkbox" checked>
                                    <i class="fa"></i> 
                                    记住我
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group text-right">
                            <div class="col-xs-12">
                                <button class="btn btn-success w-md" type="submit" id="login">登录</button>
                            </div>
                        </div>
                        <div class="form-group m-t-30">
                            <div class="col-sm-6">
                                <a href="pages-recoverpw.html"><i class="fa fa-lock m-r-5"></i>忘记密码</a>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{url('/register')}}">注册新用户</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @include('home.login.script')
    @include('home.validator.loginValidator')
    @include('home.layouts.promptModal')
    </body>
</html>
