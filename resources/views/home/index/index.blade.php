@extends('home.layouts.master')

{{--@section('style')--}}
{{--<link href="{{{ asset('home/css/index.css') }}" rel="stylesheet">--}}

{{--@endsection--}}

@section('menu')
    @parent
@endsection

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> <!--banner-->
                <ol class="carousel-indicators">
                    @if(empty($pic))
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    @else
                        @foreach($pic as $i=>$v)
                            <li data-target="#carousel-example-generic" data-slide-to="{{$i}}"
                                @if($i==0) class="active" @endif></li>
                        @endforeach
                    @endif
                </ol>
                <div class="carousel-inner" role="listbox">
                    @if(empty($pic))
                        <div class="item active"><a href="" target="_blank"><img
                                        src="{{asset('home/images/img1.jpg')}}" alt=""/></a>
                            <div class="carousel-caption"> 欢迎来到校园信息发布平台，在这里可以看到校园最新信息的发布等</div>
                            <span class="carousel-bg"></span></div>
                    @else
                        @foreach($pic as $i=>$v)
                            <div class="item @if($i==0) active @endif"><a><img
                                            src="{{ $v->url }}" alt=""/></a>
                                <div class="carousel-caption"> 欢迎来到校园信息发布平台，在这里可以看到校园最新信息的发布等</div>
                                <span class="carousel-bg"></span></div>
                        @endforeach
                    @endif
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span
                            class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span>
                </a> <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span>
                </a></div>
            <!--/banner-->
            <div class="content-block hot-content hidden-xs">
                <h2 class="title"><strong>本周热门排行</strong></h2>
                <ul>
                    <li class="large"><a href="" target="_blank"><img
                                    src="{{ asset('home/images/img3.jpg') }}" alt="">
                            <h3> 欢迎来到校园信息发布平台 </h3>
                        </a></li>
                    <li><a href="" target="_blank"><img src="{{ asset('home/images/logo.jpg') }}" alt="">
                            <h3> 欢迎来到校园信息发布平台,在这里可以看到校园最新信息的发布等 </h3>
                        </a></li>
                    <li><a href="" target="_blank"><img src="{{ asset('home/images/img2.jpg') }}" alt="">
                            <h3> 欢迎来到校园信息发布平台,在这里可以看到校园最新信息的发布等 </h3>
                        </a></li>
                    <li><a href="" target="_blank"><img src="{{ asset('home/images/img1.jpg') }}" alt="">
                            <h3> 欢迎来到校园信息发布平台，在这里可以看到校园最新信息的发布等 </h3>
                        </a></li>
                    <li><a href="" target="_blank"><img src="{{ asset('home/images/logo.jpg') }}" alt="">
                            <h3> 欢迎来到校园信息发布平台，在这里可以看到校园最新信息的发布等 </h3>
                        </a></li>
                </ul>
            </div>
            <div class="content-block new-content">
                @if(!empty($article))
                    <h2 class="title"><strong>最新文章</strong></h2>
                    <div class="row">
                        @foreach($article as $v)
                            <div class="news-list">
                                <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank"
                                                                                    href="{{ url('article/'.$v->guid) }}"><img
                                                src="{{ $v->banner }}" alt=""> </a></div>
                                <div class="news-info col-xs-7 col-sm-7 col-md-8">
                                    <dl>
                                        <dt><a href="{{ url('article/'.$v->guid) }}" target="_blank">{{ $v->title }}</a>
                                        </dt>
                                        <dd><span class="name"><a href="" title="由 {{$v->author}} 发布"
                                                                  rel="author">{{ $v->author }}</a></span>
                                            <span class="identity"></span> <span
                                                    class="time"> {{ date('Y-m-d H:m:s', $v->addtime) }} </span></dd>
                                        <dd class="text">
                                            {{ $v->brief }}
                                        </dd>
                                    </dl>
                                    <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                                    href="{{ url('/') }}">本站</a> <a href="{{ url('/') }}">校园信息发布平台</a> </span>
                                        <span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($action))
                    {{--{{dd($action)}}--}}
                    <h2 class="title"><strong>最新活动</strong></h2>
                    <div class="row">
                        @foreach($action as $v)
                            <div class="news-list">
                                <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank"
                                                                                    href="{{ url('action/'.$v->guid) }}"><img
                                                src="{{ $v->banner }}" alt=""> </a></div>
                                <div class="news-info col-xs-7 col-sm-7 col-md-8">
                                    <dl>
                                        <dt><a href="{{ url('action/'.$v->guid) }}" target="_blank">{{ $v->title }}</a>
                                        </dt>
                                        <dd><span class="name"><a href="" title="由 {{$v->author}} 发布"
                                                                  rel="author">{{ $v->author }}</a></span>
                                            <span class="identity"></span> <span
                                                    class="time"> {{ date('Y-m-d H:m:s', $v->addtime) }} </span></dd>
                                        <dd class="text">
                                            {{ $v->brief }}
                                        </dd>
                                    </dl>
                                    <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                                    href="{{ url('/') }}">本站</a> <a href="{{ url('/') }}">校园信息发布平台</a> </span>
                                        <span class="look"> 共 <strong>2126</strong> 人围观，已报名 <strong> {{ $v->people }} </strong> 人 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($notice))
                    {{--{{dd($notice)}}--}}
                    <h2 class="title"><strong>最新通知</strong></h2>
                    <div class="row">
                        @foreach($notice as $v)
                            <div class="news-list">
                                <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank"
                                                                                    href="{{ url('notice/'.$v->guid) }}"><img
                                                src="{{ asset('home/images/logo.jpg') }}" alt=""> </a></div>
                                <div class="news-info col-xs-7 col-sm-7 col-md-8">
                                    <dl>
                                        <dt><a href="{{ url('notice/'.$v->guid) }}" target="_blank">{{ $v->title }}</a>
                                        </dt>
                                        <dd><span class="name"><a href="" title="由 {{$v->author}} 发布"
                                                                  rel="author">{{ $v->author }}</a></span>
                                            <span class="identity"></span> <span
                                                    class="time"> {{ date('Y-m-d H:m:s', $v->addtime) }} </span></dd>
                                        <dd class="text">
                                            {{ $v->brief }}
                                        </dd>
                                    </dl>
                                    <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                                    href="{{ url('/') }}">本站</a> <a href="{{ url('/') }}">校园信息发布平台</a> </span>
                                        <span class="look"><strong>3506</strong> 人围观，来自 <strong> {{ $v->source }} </strong> </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <h2 class="title"><strong>最新二手交易</strong></h2>
                <div class="row">
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank" href="index.html"><img
                                        src="{{ asset('home/images/logo.jpg') }}" alt=""> </a></div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt><a href="index.html" target="_blank"> 校园信息发布平台正式上线！ </a></dt>
                                <dd><span class="name"><a href="index.html" title="由 校园信息发布平台 发布"
                                                          rel="author">校园信息发布平台</a></span> <span
                                            class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">
                                    欢迎来到校园信息发布平台，在这里可以看到校园最新信息的发布，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。
                                </dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                            href="index.html">本站</a> <a href="index.html">校园信息发布平台</a> </span> <span
                                        class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span>
                            </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank" href="index.html"><img
                                        src="{{ asset('home/images/img1.jpg') }}" alt=""> </a></div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt><a href="index.html" target="_blank"> 校园信息发布平台正式上线！ </a></dt>
                                <dd><span class="name"><a href="index.html" title="由 校园信息发布平台 发布"
                                                          rel="author">校园信息发布平台</a></span> <span
                                            class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">
                                    欢迎来到校园信息发布平台，在这里可以看到校园最新信息的发布，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。
                                </dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                            href="index.html">本站</a> <a href="index.html">校园信息发布平台</a> </span> <span
                                        class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span>
                            </div>
                        </div>
                    </div>
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank" href="index.html"><img
                                        src="{{ asset('home/images/img2.jpg') }}" alt=""> </a></div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt><a href="index.html" target="_blank"> 校园信息发布平台正式上线！ </a></dt>
                                <dd><span class="name"><a href="index.html" title="由 校园信息发布平台 发布"
                                                          rel="author">校园信息发布平台</a></span> <span
                                            class="identity"></span> <span class="time"> 2015-10-19 </span></dd>
                                <dd class="text">
                                    欢迎来到校园信息发布平台，在这里可以看到校园最新信息的发布，还有CMS内容管理系统，包括但不限于这些还有CMS内容管理系统，包括但不限于这些。
                                </dd>
                            </dl>
                            <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                            href="index.html">本站</a> <a href="index.html">校园信息发布平台</a> </span> <span
                                        class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection

