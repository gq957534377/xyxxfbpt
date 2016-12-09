<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>琦立英雄会--@yield('title','首页')</title>
    @include('home.public.style')

    @yield('style')
</head>
<body>

@include('home.public.header')

@include('home.public.nav')

@yield('content')

@include('home.public.footer')

@include('home.public.script')

@yield('script')
{{--sa--}}
</body>
</html>
