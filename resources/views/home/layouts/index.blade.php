<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>英雄会</title>
    @include('home.public.style')

    @yield('style')
</head><!--/head-->

<body class="homepage">

@include('home.public.head')

@yield('content')

@include('home.public.footer')

@include('home.public.script')

@yield('script')
</body>
</html>

