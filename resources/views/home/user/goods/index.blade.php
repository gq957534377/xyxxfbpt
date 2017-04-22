@extends('home.layouts.userCenter')

@section('title','我的二手')

@section('style')
    <link href="{{ asset('home/css/user_center_my_road.css') }}" rel="stylesheet">
    <style>
        .pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #ff9600;
            border-color: #ff9600;
        }
    </style>
@endsection

@section('content')
    <!--我参加的路演列表开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10  mar-clr my-road">
        <div>
            <span>我的二手交易</span>
        </div>
        <a href="{{ url('userGoods/create') }}" class="btn-success">发布商品</a>
        <!--活动列表块开始-->
        @if($StatusCode === '204')
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <center><span style="color: #999999">你还未发表任何商品呦~亲 O(∩_∩)O~</span></center>
            </li>
        @elseif($StatusCode == '200')
            <div id="list">
                @foreach($ResultData['data'] as $goods)
                    <div class="row mar-clr bb-3 mar-b15 pad-b15">
                        <div class="road-img col-lg-5 col-md-12 col-sm-12 pad-clr">
                            <a target="_blank" href="{{asset('/userGoods/'.$goods->guid)}}"><img
                                        src="{{ $goods->banner }}" alt=""></a>
                        </div>
                        <div class="road-font col-lg-7 col-md-12 col-sm-12 pad-clr">
                            <h2>
                                <a target="_blank" href="{{asset('/goods/'.$goods->guid)}}">
                                    {{ $goods->name }}
                                </a>
                            </h2>
                            <div class="row mar-clr road-class-u mar-b5">
                                <p class="col-sm-6 col-xs-12 pad-clr">{{ $goods->author }}</p>
                            </div>
                            <div class="row mar-clr road-class-u mar-b5">
                                <p class="col-sm-6 col-xs-12 pad-clr">{{ date('Y-m-d H:m:s',$goods->addtime) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="panel pull-right" id="data">{!! $ResultData['pages'] !!}</div>
        @else
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span style="color: #999999">出错了呦~亲 /(ㄒoㄒ)/~~ 错误信息：{{$ResultData['data']}}错误码：{{$StatusCode}}</span>
            </li>
    @endif

    <!--活动列表块结束-->
    </div>
    <!--我参加的路演列表结束-->
@endsection
