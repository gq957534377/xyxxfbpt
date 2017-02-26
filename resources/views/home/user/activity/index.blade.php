@extends('home.layouts.userCenter')

@section('title','参加的活动')

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
            <span>我参加的活动</span>
        </div>
        <div class="row mar-clr bb-2 pad-b15px-xs">
            <div class="col-sm-3 col-md-3 col-lg-2 pad-cl">
                <p>活动类型：</p>
            </div>
            <ul class="col-sm-9 col-md-9 col-lg-10 road-type mar-clr mar-cb pad-clr">
                <li class="">
                    <a @if($ResultData['type'] == 1)class="active" @endif href="{{asset('/action_order?type=1')}}">文娱活动</a>
                </li>
                <li class="">
                    <a @if($ResultData['type'] == 2)class="active" @endif href="{{asset('/action_order?type=2')}}">学术活动</a>
                </li>
                <li class="">
                    <a @if($ResultData['type'] == 3)class="active" @endif href="{{asset('/action_order?type=3')}}">竞赛活动</a>
                </li>
            </ul>
        </div>
        <div class="row mar-clr bb-3">
            <div class="col-sm-3 col-md-3 col-lg-2 pad-cl">
                <p>活动状态：</p>
            </div>
            <ul class="col-sm-9 col-md-9 col-lg-10 road-time mar-clr pad-clr">
                <li class='pad-r2-xs @if($ResultData['status'] == 6) active @endif'>
                    <a href="{{asset('/action_order?type='.$ResultData['list'])}}">全部</a>
                </li>
                <li class='pad-r2-xs @if($ResultData['status'] == 1) active @endif'>
                    <a href="{{asset('/action_order?type='.$ResultData['list'].'&status=1')}}">报名中</a>
                </li>
                <li class='pad-r2-xs @if($ResultData['status'] == 5) active @endif'>
                    <a href="{{asset('/action_order?type='.$ResultData['list'].'&status=5')}}">等待开始</a>
                </li>
                <li class='pad-r2-xs @if($ResultData['status'] == 2) active @endif'>
                    <a href="{{asset('/action_order?type='.$ResultData['list'].'&status=2')}}">进行中</a>
                </li>
                <li class='pad-r2-xs @if($ResultData['status'] == 3) active @endif'>
                    <a href="{{asset('/action_order?type='.$ResultData['list'].'&status=3')}}">已结束</a>
                </li>
            </ul>
        </div>

        <!--活动列表块开始-->
        @if($StatusCode === '204')
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span style="color: #999999">你还未参加任何活动呦~亲 O(∩_∩)O~</span>
            </li>
        @elseif($StatusCode === '200')
            <div id="list">
                @foreach($ResultData['data'] as $action)
                    <div class="row mar-clr bb-3 mar-b15 pad-b15">
                        <div class="road-img col-lg-5 col-md-12 col-sm-12 pad-clr">
                            <a target="_blank" href="{{asset('/action/'.$action->guid)}}"><img src="{{ $action->banner }}" alt=""></a>
                        </div>
                        <div class="road-font col-lg-7 col-md-12 col-sm-12 pad-clr">
                            <h2>
                                <a target="_blank" href="{{asset('/action/'.$action->guid)}}">
                                    {{ $action->title }}
                                </a>
                            </h2>
                            <div class="row mar-clr road-class-u mar-b5">
                                <p class="col-sm-6 col-xs-12 pad-clr">
                                    @if($action->type == 1)
                                        文娱活动
                                    @elseif($action->type == 2)
                                        学术活动
                                    @elseif($action->type == 3)
                                        竞赛活动
                                    @endif
                                </p>
                                <p class="col-sm-6 col-xs-12 pad-clr">{{ $action->author }}</p>
                            </div>
                            <div class="road-class-d mar-b5">
                                <p class="col-xs-12 pad-clr">{{ date('Y年m月d日 H:m', $action->start_time) }}
                                    --{{ date('Y年m月d日 H:m', $action->end_time) }}</p>
                                <p class="col-xs-12 pad-clr mar-emt05">{{ $action->address }}</p>
                                <div class="clearfix"></div>
                            </div>
                            <button type="button" class="btn active-join-status disabled">@if($action->status == 1)
                                    报名中@elseif($action->status == 2)进行中@elseif($action->status == 3)
                                    已结束@elseif($action->status == 4)该活动已取消@elseif($action->status == 5)
                                    报名截止@endif</button>
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

@section('script')
    <script src="{{asset('JsService/Model/date.js')}}"></script>
    <script>
        var status = "{{$ResultData['status']}}";
        var list = "{{$ResultData['list']}}";
        //活动状态展示
        function statu(status) {
            var res;
            switch (status) {
                case 1:
                    res = "报名中";
                    break;
                case 2:
                    res = "活动进行中";
                    break;
                case 3:
                    res = "该活动已结束";
                    break;
                case 4:
                    res = "该活动已取消";
                    break;
                case 5:
                    res = "报名截止";
                    break;
            }
            return res;
        }

        function getPage() {
            $('.pagination li').click(function () {
                var class_name = $(this).prop('class');
                if (class_name == 'disabled' || class_name == 'active') {
                    return false;
                }

                var url;
                if (status == 6) {
                    url = $(this).children().prop('href') + '&list=' + list + '&type=' + list;
                } else {
                    url = $(this).children().prop('href') + '&list=' + list + '&type=' + list + '&status=' + status;
                }

                $.ajax({
                    url: url,
                    success: function (data) {
                        $('#list').html('');
                        $('#data').html('');
                        console.log(data);
                        if (data.StatusCode === '200') {
                            var html = '';
                            $.each(data.ResultData.data, function (i, v) {
                                html += '<div class="row mar-clr bb-3"><div class="road-img col-lg-5 col-md-12 col-sm-12 pad-clr">';
                                html += '<a target="_blank"';
                                html += 'href="/action/' + v.guid + '">';
                                html += '<img src="' + v.banner + '"></a></div>';
                                html += '<div class="road-font col-lg-7 col-md-12 col-sm-12 pad-clr"><h2>';
                                html += '<a target="_blank" href="/action/' + v.guid + '">';
                                html += v.title;
                                html += '</a></h2><div class="row mar-clr road-class-u">';
                                html += '<p class="col-sm-6 col-xs-12 pad-clr">';
                                html += type(v.type);
                                html += '</p><p class="col-sm-6 col-xs-12 pad-clr">' + v.author + '</p></div>';
                                html += '<div class="road-class-d">';
                                html += '<p class="col-xs-12 pad-clr">' + getLocalTime(v.start_time) + '--' + getLocalTime(v.end_time) + '</p>';
                                html += '<p class="col-xs-12 pad-clr">' + v.address + '</p></div>';
                                html += '<button type="button" class="btn active-join-status disabled">' + statu(parseInt(v.status)) + '</button>';
                                html += '</div></div>';
                            });
                            console.log(html);
                            $('#list').html(html);
                            $('#data').html(data.ResultData.pages);
                            getPage();
                        } else {
                            $('#list').html('好像出错了呦:' + data.ResultData.data + ',错误代码：' + data.StatusCode);
                        }
                    }
                });
                return false;
            });
        }
        getPage();
    </script>
@endsection