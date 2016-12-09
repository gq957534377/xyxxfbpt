<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>琦立英雄会--@yield('title','用户中心')</title>

    @include('home.public.style')
    <link href="{{ asset('home/css/user_center_aside.css') }}" rel="stylesheet">
    @yield('style')

</head>
<body>

@include('home.public.header')

<!--移动设备menu开始-->
@include('home.user.mobileSidebar')
<!--移动设备menu结束-->

<!--用户中心基本信息开始-->
<section class="container-fluid">
    <div class="container">
        <div class="row user-center">
        @include('home.user.pcSideBar')
        @yield('content')
        </div>
    </div>
</section>


<!--用户中心基本信息结束-->

@include('home.public.footer')

@include('home.public.script')

@yield('script')

</body>
</html>
