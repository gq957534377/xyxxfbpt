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
                    @if(isset($actions))
                        @foreach($actions as $action)
                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="rodeing-img col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <img src="{{ $action->banner }}" alt="">
                            </div>
                            <div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <h2>
                                    <a href="{{ route('action.show', $action->guid) }}">
                                        {{ $action->title }}
                                    </a>
                                </h2>
                                <p>{{ $action->brief }}</p>
                                <div class="rodeing-class">
                                    <ul class="row">
                                        <li class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                                            @if($action->type == 1)
                                                路演活动
                                            @elseif($action->type == 2)
                                                创业大赛
                                            @else
                                                英雄学院
                                            @endif
                                        </li>
                                        <li class="col-lg-6 col-md-6 col-sm-6 col-xs-9">{{ $action->author }}</li>
                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ $action->start_time }}——{{ $action->end_time }}</li>
                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ $action->address }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                        @endforeach
                    @endif
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

