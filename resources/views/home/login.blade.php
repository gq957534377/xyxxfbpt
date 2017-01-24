<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>校园信息发布平台-欢迎您的加入</title>
	<link rel="stylesheet" href="{{asset('home/css/register.css')}}">
</head>
<body>

<div class="login-container">
	<h1>校园信息发布平台</h1>

	<div class="connect">
		<p style="left: 0%;">Link the school. Share to shool.</p>
	</div>

	<form action="http://www.jq22.com/demo/jquery-Sharelink20151012/index.html" method="post" id="loginForm" novalidate="novalidate">
		<div>
			<input type="text" name="username" class="username" placeholder="用户名/手机号" autocomplete="off">
		</div>
		<div>
			<input type="password" name="password" class="password" placeholder="密码" oncontextmenu="return false" onpaste="return false">
		</div>
		<button id="submit" type="submit">登 陆</button>
	</form>

	<a href="{{url('/register')}}">
		<button type="button" class="register-tis">还有没有账号？</button>
	</a>

</div>
@include('home.public.footer')

<script src="{{asset('home/js/jquery-2.1.4.min.js')}}" type="text/javascript"></script>
<script src="{{asset('home/js/loginRegister.js')}}" type="text/javascript"></script>
<script src="{{asset('home/js/nprogress.js')}}" type="text/javascript"></script>
<script src="{{asset('home/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('home/js/jquery.leanModal.min.js')}}"></script>

<!--背景图片自动更换-->
<script src="{{asset('home/js/supersized.3.2.7.min.js')}}"></script>
<script src="{{asset('home/js/supersized-init.js')}}"></script>
<!--表单验证-->
<script src="{{asset('home/js/jquery.validate.min.js')}}"></script>
</body>
</html>
