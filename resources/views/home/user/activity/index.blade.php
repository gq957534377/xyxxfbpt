@extends('home.layouts.userCenter')

@section('title','参加的活动')

@section('style')
    <link href="{{ asset('home/css/user_center_my_road.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!--我参加的路演列表开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10  mar-clr my-road">
        <div>
            <span>我参加的活动</span>
        </div>
        <div class="row mar-clr bb-2 pad-b15px-xs">
            <div class="col-sm-3 col-md-3 col-lg-2 pad-cl">
                <p>活动类型：</p>
            </div>
            <ul class="col-sm-9 col-md-9 col-lg-10 road-type mar-clr mar-cb pad-clr">
                <li class=""><a class="active" href="#">创业大赛</a></li>
                <li class=""><a href="#">路演活动</a></li>
            </ul>
        </div>
        <div class="row mar-clr bb-3">
            <div class="col-sm-3 col-md-3 col-lg-2 pad-cl">
                <p>活动时间：</p>
            </div>
            <ul class="col-sm-9 col-md-9 col-lg-10 road-time mar-clr pad-clr">
                <li class='pad-r2-xs active'><a href="#">全部</a></li>
                <li class='pad-r2-xs'><a href="#">今天</a></li>
                <li class='pad-r2-xs'><a href="#">明天</a></li>
                <li class='pad-r2-xs'><a href="#">最近7天</a></li>
                <li class='pad-r2-xs'><a href="#">最近30天</a></li>
            </ul>
        </div>

        <!--活动列表块开始-->
        @foreach($data as $action)
            <div class="row mar-clr bb-3">
                <div class="road-img col-lg-5 col-md-12 col-sm-12 pad-clr">
                    <img src="{{ $action->banner }}" alt="">
                </div>
                <div class="road-font col-lg-7 col-md-12 col-sm-12 pad-clr">
                    <h2>
                        <a href="#">
                            {{ $action->title }}
                        </a>
                    </h2>
                    <p class="indent">
                        {{ $action->brief }}
                    </p>
                    <div class="row mar-clr road-class-u">
                        <p class="col-sm-6 col-xs-12 pad-clr">
                            @if($action->type == 1)
                                路演活动
                            @elseif($action->type == 2)
                                创业大赛
                            @elseif($action->type == 3)
                                英雄学院
                            @endif
                        </p>
                        <p class="col-sm-6 col-xs-12 pad-clr">{{ $action->author }}</p>
                    </div>
                    <div class="road-class-d">
                        <p class="col-xs-12 pad-clr">{{ $action->start_time }}--{{ $action->end_time }}</p>
                        <p class="col-xs-12 pad-clr">{{ $action->address }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        <!--活动列表块结束-->
    </div>
    <!--我参加的路演列表结束-->
@endsection

@section('script')

@endsection