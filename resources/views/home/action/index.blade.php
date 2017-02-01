@extends('home.layouts.master')

{{--@section('style')--}}
{{--<link href="{{{ asset('home/css/index.css') }}" rel="stylesheet">--}}

{{--@endsection--}}
@section('title', '校园活动')

@section('menu')
    @parent
@endsection

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">

            <div class="content-block new-content">
                <h2 class="title"><strong>最新社会新闻</strong></h2>
                {{--{{dd($ResultData)}}--}}
                <div class="row">
                    @foreach($ResultData['data'] as $action)
                        {{--{{dd($action)}}--}}
                        <div class="news-list">
                            <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank"
                                                                                href="{{ url('action/'.$action->guid) }}"><img
                                            src="{{ $action->banner }}" alt="{{ $action->title }}"> </a></div>
                            <div class="news-info col-xs-7 col-sm-7 col-md-8">
                                <dl>
                                    <dt><a href="{{ url('action/'.$action->guid) }}"
                                           target="_blank"> {{ $action->title }} </a></dt>
                                    <dd><span class="name"><a href="{{ url('action/'.$action->guid) }}"
                                                              title="由 {{ $action->group }} 发布"
                                                              rel="author">{{ $action->group }}</a></span> <span
                                                class="identity"></span> <span
                                                class="time"> {{ date('Y-m-d H:m', $action->addtime) }} </span> <span
                                                class="identity"></span><a class="btn-success" href="index.html">报名中</a></dd>
                                    <dd class="text">{{ $action->brief }}</dd>
                                    <dd class="text">活动时间： {{ date('Y-m-d H:m', $action->start_time) }}
                                        到 {{ date('Y-m-d H:m', $action->end_time) }}</dd>
                                </dl>
                                <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                                href=" {{ url('/') }}">本站</a> <a
                                                href="{{ url('/') }}">校园信息发布平台</a> </span> <span
                                            class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {!! $ResultData['pages'] !!}
                {{--<div class="quotes" style="margin-top:15px"><span class="disabled">首页</span><span class="disabled">上一页</span><span class="current">1</span><a href="index.html">2</a><a href="index.html">下一页</a><a href="index.html">尾页</a></div>--}}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('JsService/Model/date.js') }} "></script>
    <script>
        function status(status) {
            var result;
            switch (status) {
                case 1:
                    result = '报名中';
                    break;
                case 2:
                    result = '进行中';
                    break;
                case 3:
                    result = '已结束';
                    break;
                case 4:
                    result = '已取消';
                    break;
                case 5:
                    result = '报名已经截止';
                    break;
            }
            return result;
        }
        var nowPage = 2;
        var type = $('#more_list').data('type');
        var sta = $('#more_list').data('status');

        $('#more_list').click(function () {
            var url = "action/create";
            $.ajax({
                url: url,
                type: 'get',
                data: {'nowPage': nowPage, 'type': type, 'status': sta},
                beforeSend: function () {
                    $('.loads').addClass('loads_change');
                },
                success: function (data) {
                    data['ResultData']['data'].map(function (action) {
                        var html = '';
                        html += '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                        html += '<div class="row">';
                        html += '<div class="rodeing-img col-lg-4 col-md-4 col-sm-4 col-xs-12">';
                        html += '<a target="_blank" href="/action/' + action.guid + '"><img src="' + action.banner + '"  onerror="this.src=\'home/img/zxz.png\'"></a></div>';
                        html += '<div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">';
                        html += '<h2><a target="_blank" href="/action/' + action.guid + '">' + action.title + '</a></h2>';
                        html += '<div class="rodeing-class">';
                        html += '<ul class="row">';
                        html += '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">' + getLocalTime(action.start_time) + '——' + getLocalTime(action.end_time) + '</li>';
                        html += '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">' + action.address + '</li>';
                        html += '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><span class="road-banner-join">' + status(parseInt(action.status)) + '</span></li></ul></div></div></div></li>';
                        $('.rodeing-list').append(html);
                    });
                    $('.loads').removeClass('loads_change');
                    if (nowPage < data.ResultData['totalPage']) {
                        nowPage++;
                    } else {
                        $('#more_list').remove();
                    }
                }
            });
        });
    </script>
@endsection

