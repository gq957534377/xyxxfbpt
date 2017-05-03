@extends('home.layouts.master')

@section('title', '实时新闻')

@section('menu')
    @parent
@endsection

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <div class="content-block new-content">
                <ul class="min_title">
                    <li class=" btn @if($type == 'top')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=top') }}">头条</a></li>
                    <li class=" btn @if($type == 'shehui')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=shehui') }}">社会</a></li>
                    <li class=" btn @if($type == 'guonei')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=guonei') }}">国内</a></li>
                    <li class=" btn @if($type == 'guoji')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=guoji') }}">国际</a></li>
                    <li class=" btn @if($type == 'yule')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=yule') }}">娱乐</a></li>
                    <li class=" btn @if($type == 'tiyu')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=tiyu') }}">体育</a></li>
                    <li class=" btn @if($type == 'junshi')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=junshi') }}">军事</a></li>
                    <li class=" btn @if($type == 'keji')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=keji') }}">科技</a></li>
                    <li class=" btn @if($type == 'caijing')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=caijing') }}">财经</a></li>
                    <li class=" btn @if($type == 'shishang')btn-success @else btn-default @endif">
                        <a href="{{ url('/news?type=shishang') }}">时尚</a></li>
                </ul>
                <h2 class="title" id="action_type"><strong>
                        @if($type == 'top')头条@elseif($type == 'shehui')
                            社会@elseif($type == 'guonei')国内@elseif($type == 'guoji')
                            国际@elseif($type == 'yule')娱乐@elseif($type == 'tiyu')
                            体育@elseif($type == 'junshi')军事@elseif($type == 'keji')
                            科技@elseif($type == 'caijing')财经@elseif($type == 'shishang')
                            时尚@endif</strong></h2>
                <div class="row">
                    {{--{{ dd($news) }}--}}
                    @if(!empty($news) && empty($news->error_code))
                        @foreach($news->result->data as $val)
                            <div class="news-list">
                                <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank"
                                                                                    href="{{ $val->url }}"><img
                                                onerror="this.src='{{asset('home/img/zxz.png')}}'"
                                                src="{{ $val->thumbnail_pic_s }}" alt="{{ $val->title }}">
                                    </a></div>
                                <div class="news-info col-xs-7 col-sm-7 col-md-8">
                                    <dl>
                                        <dt>
                                            <a href="{{ $val->url }}" target="_blank">
                                                {{ $val->title }}
                                            </a>
                                        </dt>
                                        <dd>
                                        <span class="name">
                                            <a title="由 {{ $val->author_name }} 发布"
                                               rel="author">{{ $val->author_name }}</a>
                                        </span>
                                            <span class="identity"></span>
                                            <span class="time"> {{ $val->date }} </span>
                                        </dd>
                                        {{--<dd class="text">{{ $val->brief }}</dd>--}}
                                    </dl>
                                    <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                                    href=" {{ url('/') }}">本站</a> <a
                                                    href="{{ url('/') }}">校园信息发布平台</a> </span> <span
                                                class="look"><strong>{{ $val->category }}</strong> 新闻 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @if(empty($news))
                            <p>网络出错了！</p>
                        @else
                            <p>{{$news->reason}}</p>
                        @endif
                    @endif
                </div>
                <div id="url" style="display: none" data-type="{{ $type }}">
                    {{--<div class="quotes" style="margin-top:15px"><span class="disabled">首页</span><span class="disabled">上一页</span><span class="current">1</span><a href="index.html">2</a><a href="index.html">下一页</a><a href="index.html">尾页</a></div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

