@extends('home.layouts.master')

@section('style')
    <link href="{{ asset('home/css/roading.css') }}" rel="stylesheet">
@endsection

@section('menu')
    @parent
@endsection

@section('content')
    <section class="bannerimg hang">
        <img src="{{ asset('home/img/demoimg/dd.jpg') }}">
    </section>
    <section class="container-fluid rodeing-type">
        <ul class="row">
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'>活动类型：</li>
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a class="active" href="#">创业大赛</a></li>
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a href="#">路演活动</a></li>
        </ul>
    </section>
    <section class="container-fluid">
        <div class="row rodeing-content">
            <div class="col-lg-9 col-md-9 col-s
            m-12 col-xs-12">
                <ul class="row rodeing-time">
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'>活动时间：</li>
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2 active'><a href="#">今天</a></li>
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a href="#">明天</a></li>
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a href="#">最近7天</a></li>
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a href="#">最近30天</a></li>
                </ul>
                <!--路演列表块开始-->
                <ul class="row rodeing-list">
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="rodeing-img col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt="">
                            </div>
                            <div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <h2>
                                    <a href="#">
                                        【奔跑吧,创客】天使有约2016医疗专场路演;天使有约2016医疗专场路演;天使有约2016医疗专场路演
                                    </a>
                                </h2>
                                <p>近日，“魏则西”事件不断发酵的莆田系被连根起底有专家预言在互联网尤其是对传统医疗产业颠覆的大背景下这一导火索或将倒逼整个医疗产业进入良性...
                                </p>
                                <div class="rodeing-class">
                                    <ul class="row">
                                        <li class="col-lg-6 col-md-6 col-sm-6 col-xs-3">路演活动</li>
                                        <li class="col-lg-6 col-md-6 col-sm-6 col-xs-9">搜钱网 好园区</li>
                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">2016-04-05——2016-04-30</li>
                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">浙江省杭州市西湖区省人力社保局江南大道39000号五楼303室</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="rodeing-img col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt="">
                            </div>
                            <div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <h2>
                                    <a href="#">
                                        【奔跑吧,创客】天使有约2016医疗专场路演;天使有约2016医疗专场路演;天使有约2016医疗专场路演
                                    </a>
                                </h2>
                                <p>近日，“魏则西”事件不断发酵的莆田系被连根起底有专家预言在互联网尤其是对传统医疗产业颠覆的大背景下这一导火索或将倒逼整个医疗产业进入良性...
                                </p>
                                <div class="rodeing-class">
                                    <ul class="row">
                                        <li class="col-lg-6 col-md-6 col-sm-6 col-xs-3">路演活动</li>
                                        <li class="col-lg-6 col-md-6 col-sm-6 col-xs-9">搜钱网 好园区</li>
                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">2016-04-05——2016-04-30</li>
                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">浙江省杭州市西湖区省人力社保局江南大道39000号五楼303室</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="rodeing-img col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt="">
                            </div>
                            <div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <h2>
                                    <a href="#">
                                        【奔跑吧,创客】天使有约2016医疗专场路演;天使有约2016医疗专场路演;天使有约2016医疗专场路演
                                    </a>
                                </h2>
                                <p>近日，“魏则西”事件不断发酵的莆田系被连根起底有专家预言在互联网尤其是对传统医疗产业颠覆的大背景下这一导火索或将倒逼整个医疗产业进入良性...
                                </p>
                                <div class="rodeing-class">
                                    <ul class="row">
                                        <li class="col-lg-6 col-md-6 col-sm-6 col-xs-3">路演活动</li>
                                        <li class="col-lg-6 col-md-6 col-sm-6 col-xs-9">搜钱网 好园区</li>
                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">2016-04-05——2016-04-30</li>
                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">浙江省杭州市西湖区省人力社保局江南大道39000号五楼303室</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <!--路演列表块结束-->
            </div>
            <!----广告位开始----->
            <div class="guanggao col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <a href="#"><img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt=""></a>
            </div>
            <!----广告位结束----->
        </div>
    </section>
@endsection

