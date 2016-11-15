<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="img/favicon_1.ico">
        <title>英雄会 - 大学生创业项目平台</title>
        @include('home.login.style')
    </head>
    <body>

        <div class="wrapper-page">
            <div class="panel panel-color panel-inverse">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10"> Welcome to join Hero</h3>
                </div> 

                <div class="panel-body">
                    @include('admin.public.errors')
                    <form id="signUpForm" class="form-horizontal m-t-10 p-20 p-b-0" action="{{url('/register')}}" method="post">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" type="email" required="" placeholder="邮箱">
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control " name="nickname" type="text" required="" placeholder="昵称">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control " id="password" name="password" type="password" required="" placeholder="密码">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control " name="confirm_password" type="password" required="" placeholder="确认密码">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-7">
                                <input class="form-control " name="phone" type="text" required="" placeholder="手机号">
                            </div>
                            <div class="col-xs-5">
                                <a id="sendCode" class="btn btn-info xs" style="height: 36px;margin-left: 12px;">获取验证码</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control " name="code" type="text" required="" placeholder="短信验证码">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <label class="cr-styled">
                                    <input type="checkbox" checked>
                                    <i class="fa"></i>
                                    阅读<strong><a href="#">英雄会</a>条款和条件</strong>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group text-right">
                            <div class="col-xs-12">
                                <button class="btn btn-success w-md" type="submit" id="register">注册</button>
                            </div>
                        </div>

                        <div class="form-group m-t-30">
                            <div class="col-sm-12 text-center">
                                <a href="{{url('/login')}}">已经有帐户了吗？</a>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    @include('home.login.script')
    @include('home.validator.registerValidator')
    </body>
</html>
