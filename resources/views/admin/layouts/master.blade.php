<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <title>@section('title')坚固集团-后台管理系统@show</title>
    @include('admin.public.style')
    @yield('styles')
</head>
<body>
    @include('admin.public.aside')
    <section class="content">
        @include('admin.public.header')
        <div class="wraper container-fluid">
            @yield('content')
        </div>
        {{--引入弹出表单--}}
        @include('admin.libs.alertForm')
        {{--引入弹出提示--}}
        @include('admin.libs.alertInfo')
        @include('admin.public.footer')
    </section>
</body>
@include('admin.public.script')
@yield('script')

</html>