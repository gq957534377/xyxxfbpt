<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>校园信息发布平台--@yield('title','个人中心')</title>

    <!--[if lt IE 9]>
    <script src="{{asset('home/js/html5shiv.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('home/js/respond.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('home/js/selectivizr-min.js')}}" type="text/javascript"></script>
    <![endif]-->

    @include('home.public.style')

    <meta name="Keywords" content=""/>
    <meta name="description" content=""/>
    <script type="text/javascript">
        //判断浏览器是否支持HTML5
        window.onload = function () {
            if (!window.applicationCache) {
                window.location.href = "{{ url('errors/ie') }}";
            }
        }
    </script>
    <style>
        .zxz-class{
            max-width: 770px;
            margin-right:320px;
            margin-left: 190px;
        }
        @media screen and (max-width: 1200px) {
            .zxz-class{
                margin-right: 0;
            }
        }
        @media screen and (max-width: 767px) {
            .zxz-class{
                margin-left: 0;
            }
        }
    </style>
    @yield('style')
</head>
<body>

{{--@include('home.public.header')--}}
<section class="container user-select">

    @section('menu')

        @include('home.public.userCenterNav')

    @show
<div class="zxz-class">
    @yield('content')
</div>


    @include('home.public.right')
    @include('home.public.footer')

</section>
<div><a href="javascript:;" class="gotop" style="display:none;"></a></div>
<!--/返回顶部-->
<script src="{{asset('home/js/jquery-2.1.4.min.js')}}" type="text/javascript"></script>
<script src="{{asset('home/js/nprogress.js')}}" type="text/javascript"></script>
<script src="{{asset('home/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('home/js/jquery.leanModal.min.js')}}"></script>

@yield('script')
</body>
</html>
