@extends('home.layouts.master')

@section('title', '校园活动')

@section('menu')
    @parent
@endsection

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <div class="content-block new-content">
                <ul class="min_title">
                    <li class=" btn @if((int)$type == 1)btn-success @else btn-default @endif">
                        <a href="{{ url('/action?type=1') }}">文娱活动</a></li>
                    <li class=" btn @if((int)$type == 2)btn-success @else btn-default @endif">
                        <a href="{{ url('/action?type=2') }}">学术活动</a></li>
                    <li class=" btn @if((int)$type == 3)btn-success @else btn-default @endif">
                        <a href="{{ url('/action?type=3') }}">竞赛活动</a></li>
                </ul>
                <h2 class="title" id="action_type"><strong>@if((int)$type == 1)文娱活动@elseif((int)$type == 2)学术活动@elseif((int)$type == 3)竞赛活动@endif</strong></h2>
                <div class="row">
                    @if(!empty($StatusCode) && $StatusCode == '200')
                    @foreach($ResultData['data'] as $action)
                        <div class="news-list">
                            <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank"
                                                                                href="{{ url('action/'.$action->guid) }}"><img
                                            src="{{ $action->banner }}" alt="{{ $action->title }}"> </a></div>
                            <div class="news-info col-xs-7 col-sm-7 col-md-8">
                                <dl>
                                    <dt>
                                        <a href="{{ url('action/'.$action->guid) }}" target="_blank">
                                            {{ $action->title }}
                                        </a>
                                    </dt>
                                    <dd>
                                        <span class="name">
                                            <a href="{{ $action->group->pointurl }}" target="_blank" title="由 {{ $action->group->name }} 发布" rel="author">{{ $action->group->name }}</a>
                                        </span>
                                        <span class="identity"></span>
                                        <span class="time"> {{ date('Y-m-d H:m', $action->addtime) }} </span> <span
                                                class="identity"></span><a class="btn-success" href="index.html">@if($action->status == 1)
                                                报名中 @elseif($action->status == 2) 进行中 @elseif($action->status == 3)
                                                已结束 @elseif($action->status == 4) 已取消 @elseif($action->status == 5)
                                                报名已经截止 @endif</a>
                                    </dd>
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
                        @else
                        <div>
                            <center><h4>{{$ResultData}}</h4></center>
                        </div>
                        @endif
                </div>
                @if(!empty($StatusCode) && $StatusCode == '200')
                    <div id="pages">{!! $ResultData['pages'] !!}</div>
                @endif
                <div id="url" style="display: none" data-type="{{ $type }}" data-status="{{ $status }}">
                    {{--<div class="quotes" style="margin-top:15px"><span class="disabled">首页</span><span class="disabled">上一页</span><span class="current">1</span><a href="index.html">2</a><a href="index.html">下一页</a><a href="index.html">尾页</a></div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('JsService/Model/date.js') }} "></script>
    <script>
        function pageList() {
            $('.pagination li').click(function (event) {
                event.preventDefault();
                var class_name = $(this).prop('class');
                if (class_name === 'disabled' || class_name === 'active') {
                    return false;
                }

                var list_type = $('#url').data('type');
                var list_status = $('#url').data('status');

                var url = $(this).children().prop('href') + '&type=' + list_type + '&status=' + list_status;

                $.ajax({
                    url: url,
                    type: 'get',
                    success: addList,
                });
            });
        }
        pageList();

        function addList(data) {
            if (data.StatusCode === '200') {
                var html = '<div class="news-list">';
                $.each(data.ResultData.data, function (i, e) {
                    html += '<div class="news-list">';
                    html += '<div class="news-img col-xs-5 col-sm-5 col-md-4">';
                    html += '<a target="_blank" href="' + 'action/' + e.guid + '">';
                    html += '<img src="' + e.banner + '" alt="' + e.title + '"> </a></div>';

                    html += '<div class="news-info col-xs-7 col-sm-7 col-md-8"><dl>';
                    html += '<dt><a href="action/' + e.guid + '" target="_blank">' + e.title + '</a></dt>';
                    html += '<dd><span class="name"><a href="' + e.group.pointurl + '" target="_blank" title="由 ' + e.group.name + '发布" rel="author">' + e.group.name + '</a></span>';
                    html += '<span class="identity"></span><span class="time">' + getLocalTime(e.addtime) + '</span>';
                    html += '<span class="identity"></span><a class="btn-success" href="index.html">' + status(e.status) + '</a></dd>';
                    html += '<dd class="text">' + e.brief + '</dd>';
                    html += '<dd class="text">活动时间: ' + getLocalTime(e.start_time) + ' 到 ' + getLocalTime(e.end_time) + '</dd>';
                    html += '</dl>';

                    html += '<div class="news_bot col-sm-7 col-md-8">';
                    html += '<span class="tags visible-lg visible-md">';
                    html += '<a href="/">本站</a><a href="/">校园信息发布平台</a> </span>';
                    html += '<span class="look"> 共 <strong>2126</strong> 人围观，发现 <strong> 12 </strong> 个不明物体 </span>';
                    html += '</div></div></div>';
                });
                $('.row').html(html);
                $('#pages').html(data.ResultData.pages);
                pageList();
            } else if (data.StatusCode === '204') {
                $('.row').html('<p style="padding:20px;" class="text-center">暂时没有活动信息！</p>');
            } else {
                $('.row').html('<p>' + data.ResultData + '</p>');
            }
        }

        function status(status) {
            var result;
            switch (parseInt(status)) {
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

    </script>
@endsection

