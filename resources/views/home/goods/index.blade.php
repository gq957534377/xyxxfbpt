@extends('home.layouts.master')

@section('title', '校园二手交易')

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <div class="content-block new-content">
                <h2 class="title" id="action_type"><strong>校园二手交易</strong></h2>
                <div class="row">
                    @if(!empty($StatusCode) && $StatusCode == '200')
                        <div class="row">
                            @foreach($ResultData['data'] as $goods)
                                <div class="col-md-6">
                                    <div class="news-list">
                                        <div class="news-img col-xs-5 col-sm-5 col-md-4">
                                            <a target="_blank" href="{{ url('goods/'.$goods->guid) }}">
                                                <img title="电话： {{ $goods->tel }} QQ: {{ $goods->qq }} 微信：{{ $goods->wechat }}" src="{{ $goods->banner }}" style="height: 100px;" alt="{{ $goods->name }}">
                                            </a>
                                        </div>
                                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                                            <dl>
                                                <dt>
                                                    <a href="{{ url('goods/'.$goods->guid) }}" target="_blank">
                                                        {{ $goods->name }}
                                                    </a>
                                                <h3 style="color: red">{{ $goods->price }}元</h3>
                                                </dt>
                                                {{--<dd>--}}
                                        {{--<span class="name">--}}
                                            {{--<strong>QQ:</strong><span>{{ $goods->qq }}</span>&nbsp&nbsp <strong>电话:</strong><span>{{ $goods->tel }}</span>&nbsp&nbsp <strong>微信:</strong><span>{{ $goods->wechat }}</span>&nbsp&nbsp--}}
                                        {{--</span>--}}
                                                {{--</dd>--}}
                                                <dt>
                                                    <span class="time"> {{ date('Y-m-d H:m', $goods->addtime) }} </span></dt>
                                                <dd class="text" title="{{ $goods->brief }}">{{ str_limit($goods->brief, 35, '...') }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span><center><h2>{{$ResultData}}</h2></center></span>
                    @endif
                </div>
                @if(!empty($StatusCode) && $StatusCode == '200')
                    <div id="pages">{!! $ResultData['pages'] !!}</div>
                @endif

            </div>
        </div>
    </div>
@endsection

