<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <title>坚固集团 后台管理系统 500错误</title>
    @include('admin.public.style')
    @yield('styles')
</head>
<body>

<div class="wrapper-page shadow-none">

    <div class="ex-page-content text-center">
        <h1>500</h1>
        <h2 class="font-light">内部服务器错误：</h2><br>
        <p>您可以尝试刷新您的页面？或者您可以联系<a href="#">技术支持</a></p>

        <a class="btn btn-success m-t-20" href="{{url('index')}}"><i class="fa fa-angle-left"></i> 返回到后台首页</a>
    </div>

</div>



</body>
@include('admin.public.script')
@yield('script')

</html>