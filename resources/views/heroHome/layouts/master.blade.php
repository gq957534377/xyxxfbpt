<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>琦立英雄会--@yield('title','首页')</title>
    @include('heroHome.public.style')

    @yield('style')
</head>
<body>

@include('heroHome.public.header')

@section('menu')
    @include('heroHome.public.menu')
@show

@yield('content')

@include('heroHome.public.footer')

@include('heroHome.public.script')

@yield('script')

</body>
</html>
