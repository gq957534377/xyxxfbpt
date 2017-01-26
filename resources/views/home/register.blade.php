<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>校园信息发布平台-欢迎您的加入</title>
    <link rel="stylesheet" href="{{asset('home/css/register.css')}}">
</head>
<body>

<div class="register-container">
    <a href="{{ url('/') }}" style="text-decoration:none;color: white"><h1>校园信息发布平台</h1></a>

    <div class="connect">
        <p style="left: 0%;">欢迎您的加入</p>
    </div>

    <form action="{{ url('/register') }}" method="post" id="registerForm" novalidate="novalidate">
        {{csrf_field()}}
        <div>
            <input type="text" name="username" id="nickname" class="username" placeholder="您的用户名" autocomplete="off">
        </div>
        <div>
            <input type="password" name="password" class="password" placeholder="输入密码" oncontextmenu="return false"
                   onpaste="return false">
        </div>
        <div>
            <input type="password" name="confirm_password" class="confirm_password" placeholder="再次输入密码"
                   oncontextmenu="return false" onpaste="return false">
        </div>
        <div>
            <input type="text" name="phone_number" class="phone_number" placeholder="输入手机号码" autocomplete="off"
                   id="number">
        </div>
        <div>
            <img id="captcha" style="margin-bottom: -17px;" data-sesid="{{ $sesid }}" src="{{url('/code/captcha/' . $sesid)}}">
            <input class="code" id="codes" name="code" type="text" style="width: 50%; margin-left: -3px;" placeholder="请输入验证码"/>
        </div>

        <div>
            <button type="button" style="width:118px;margin-bottom: -17px;" id="sendCode" class="btn btn-defult">发送验证码
            </button>
            <input class="code" name="phone_code" type="text" style="width: 50%; margin-left: -3px;"
                   placeholder="请输入手机验证码"/>
        </div>

        <button id="submit" type="submit">注 册</button>
    </form>
    <a href="{{url('/login')}}">
        <button type="button" class="register-tis">已经有账号？</button>
    </a>

</div>

@include('home.public.footer')
<script src="{{asset('home/js/jquery-2.1.4.min.js')}}" type="text/javascript"></script>
<script src="{{asset('home/js/nprogress.js')}}" type="text/javascript"></script>
<script src="{{asset('home/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('home/js/jquery.leanModal.min.js')}}"></script>

<!--背景图片自动更换-->
<script src="{{asset('home/js/supersized.3.2.7.min.js')}}"></script>
<script src="{{asset('home/js/supersized-init.js')}}"></script>
<!--表单验证-->
<script src="{{asset('home/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('home/js/registerValidate.js')}}"></script>
</body>
</html>
