@extends('home.layouts.master')

@section('title', '校园文章')

@section('menu')
    @parent
@endsection

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <div class="content-block new-content">
                <ul class="min_title">
                    <li class=" btn @if((int)$type == 1)btn-success @else btn-default @endif">
                        <a href="{{ url('/action?type=1') }}">爱情文章</a></li>
                    <li class=" btn @if((int)$type == 2)btn-success @else btn-default @endif">
                        <a href="{{ url('/action?type=2') }}">亲情文章</a></li>
                    <li class=" btn @if((int)$type == 3)btn-success @else btn-default @endif">
                        <a href="{{ url('/action?type=3') }}">友情文章</a></li>
                    <li class=" btn @if((int)$type == 4)btn-success @else btn-default @endif">
                        <a href="{{ url('/action?type=3') }}">生活随笔</a></li>
                </ul>
                <h2 class="title" id="action_type"><strong>@if((int)$type == 1)爱情文章@elseif((int)$type == 2)
                            亲情文章@elseif((int)$type == 3)友情文章@elseif((int)$type == 4)生活状态@endif</strong></h2>
                <div class="row">
                    @if(!empty($StatusCode) && $StatusCode == '200')
                        @foreach($ResultData['data'] as $val)
                            <div class="news-list">
                                <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank"
                                                                                    href="{{ url('article/'.$val->guid) }}"><img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->banner }}" alt="{{ $val->title }}">
                                    </a></div>
                                <div class="news-info col-xs-7 col-sm-7 col-md-8">
                                    <dl>
                                        <dt>
                                            <a href="{{ url('article/'.$val->guid) }}" target="_blank">
                                                {{ $val->title }}
                                            </a>
                                        </dt>
                                        <dd>
                                        <span class="name">
                                            <a title="由 {{ $val->author }} 发布" rel="author">{{ $val->author }}</a>
                                        </span>
                                            <span class="identity"></span>
                                            <span class="time"> {{ date('Y-m-d H:m', $val->addtime) }} </span>
                                        </dd>
                                        <dd class="text">{{ $val->brief }}</dd>
                                    </dl>
                                    <div class="news_bot col-sm-7 col-md-8"><span class="tags visible-lg visible-md"> <a
                                                    href=" {{ url('/') }}">本站</a> <a
                                                    href="{{ url('/') }}">校园信息发布平台</a> </span> <span
                                                class="look"> 共 <strong>2126</strong> 人阅读，发现 <strong> 12 </strong> 个不明物体 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div id="pages">{!! $ResultData['pages'] !!}</div>
                    @else
                        <p>{{$ResultData}}</p>
                    @endif

                </div>

                <div id="url" style="display: none" data-type="{{ $type }}">
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
                    html += '<div class="news-img col-xs-5 col-sm-5 col-md-4">'
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

