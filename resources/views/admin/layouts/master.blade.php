<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        .custom-date-style {
            background-color: red !important;
        }

        .input{
        }
        .input-wide{
            width: 500px;
        }

    </style>
    <title>@section('title')校园信息发布平台后台管理@show</title>
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
        {{--引入弹出表单，包含@yield--}}
        @include('admin.libs.alertForm')
        {{--引入弹出提示，包含@yield--}}
        @include('admin.libs.alertInfo')
        @include('admin.public.footer')
    </section>
</body>

@include('admin.public.script')
@yield('script')
</html>
