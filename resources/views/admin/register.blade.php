<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Twitch - 一只程序猿的 Life style！</title>
    @include('admin.public.style')
</head>
<body>

<div class="wrapper-page">
    <div class="panel panel-color panel-inverse">
        <div class="panel-heading">
            <h3 class="text-center m-t-10"> 欢迎，加入 <strong>Twitch</strong> 的大家庭！ </h3>
        </div>

        <div class="panel-body">
            @include('admin.public.errors')
            <form id="signUpForm" class="form-horizontal m-t-10 p-20 p-b-0" action="{{url('/register')}}" method="post">

                {{csrf_field()}}

                <div class="form-group">
                    <div class="col-xs-12">
                        <input name="email" class="form-control" type="email" required="" placeholder="Email">
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <input name="username" class="form-control " type="text" required="" placeholder="Username">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input name="password" class="form-control " type="password" required="" placeholder="Password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input name="confirm_password" class="form-control " type="password" required="" placeholder="Confirm Password">
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <label class="cr-styled">
                            <input type="checkbox" checked>
                            <i class="fa"></i>
                            我已阅读并同意相关<strong><a href="#">服务条款和隐私政策</a></strong>
                        </label>
                    </div>
                </div>

                <div class="form-group text-right">
                    <div class="col-xs-12">
                        <button class="btn btn-success w-md" type="submit">Register</button>
                    </div>
                </div>

                <div class="form-group m-t-30">
                    <div class="col-sm-12 text-center">
                        <a href="{{url('login')}}">已经有帐户了吗？</a>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@include('admin.public.script')
@include('admin.validator.registerValidator')
</body>
</html>