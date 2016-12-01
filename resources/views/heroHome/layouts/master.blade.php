<!DOCTYPE html>
<html>
<head>
    <title>崎立英雄会 - @yield('title') </title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--必须，否则bootstrap媒体查询不能执行-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('heroHome.public.style')

    @yield('style')
</head>

<body>

@include('heroHome.public.header')
@include('admin.public.errors')
@include('admin.public.success')
@yield('content')

@include('heroHome.public.footer')

@include('heroHome.public.script')



@yield('script')
</body>
</html>
