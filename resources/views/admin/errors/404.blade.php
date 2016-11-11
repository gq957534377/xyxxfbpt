<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <title>坚固集团 后台管理系统 404错误</title>
    @include('admin.public.style')
    @yield('styles')
</head>
<body>

<div class="wrapper-page shadow-none">

    <div class="ex-page-content text-center">
        <h1>404</h1>
        <h2 class="font-light">对不起,页面不存在</h2><br>
        <p>您可以尝试着去搜索：</p>
        <div class="row">
            <div class="input-group">
                <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">搜索</button>
                          </span>
            </div>
        </div><br>
        <a class="btn btn-success" href="{{url('index')}}"><i class="fa fa-angle-left"></i> 返回到首页 </a>
    </div>

</div>
</body>
@include('admin.public.script')
@yield('script')

</html>