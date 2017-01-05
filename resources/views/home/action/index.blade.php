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
    <section class="container">

        <div class="nav-status-bar col-xs-12 pad-clr">
            @if($type == 1)
            <span>路演活动</span>
            <span class="pull-right">路演活动</span>
            @elseif($type == 2)
            <span>创业大赛</span>
            <span class="pull-right">创业大赛</span>
            @endif
            <span class="pull-right">＞</span>
            <span class="pull-right">活动</span>
            <div></div>
        </div>

        <ul class="nav-status-bar-type col-xs-12 pad-clr">
            <li @if($status == 204)class="nav-status-bar-type-active" @endif><a href="/action?type={{$type}}">所有</a></li>
            <li @if($status == 1)class="nav-status-bar-type-active" @endif><a href="/action?type={{$type}}&status=1">报名中</a></li>
            <li @if($status == 5)class="nav-status-bar-type-active" @endif><a href="/action?type={{$type}}&status=5">等待开始</a></li>
            <li @if($status == 2)class="nav-status-bar-type-active" @endif><a href="/action?type={{$type}}&status=2">进行中</a></li>
            <li @if($status == 3)class="nav-status-bar-type-active" @endif><a href="/action?type={{$type}}&status=3">往期回顾</a></li>
        </ul>

    </section>

    <section class="container">
        <div class="row add-margin-bottom">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

                @if($StatusCode == 204)
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span style="color: #999999">暂无数据呦~亲 O(∩_∩)O~</span>
                    </li>
                @else
                    @if($StatusCode == 200)
                        <!--路演列表块开始-->
                        <ul class="row rodeing-list">
                            @foreach($ResultData['data'] as $action)
                                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="rodeing-img col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <a href="{{ route('action.show', $action->guid) }}"><img src="{{ $action->banner }}"  onerror="this.src='{{asset('home/img/zxz.png')}}'"></a>
                                        </div>
                                        <div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                            <h2>
                                                <a href="{{ route('action.show', $action->guid) }}">
                                                    {{ $action->title }}
                                                </a>
                                            </h2>
                                            <div class="rodeing-class">
                                                <ul class="row">
                                                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ date('Y年m月d日 H:m',$action->start_time) }}——{{ date('Y年m月d日 H:m',$action->end_time) }}</li>
                                                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ $action->address }}</li>
                                                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        @if($action->status == 1)
                                                        <span class="road-banner-join">报名中</span>
                                                            @elseif($action->status == 2)
                                                            <span class="road-banner-join">进行中</span>
                                                        @elseif($action->status == 3)
                                                            <span class="road-banner-join">已结束</span>
                                                        @elseif($action->status == 5)
                                                            <span class="road-banner-join">报名已经截止</span>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if($ResultData['totalPage'] > $nowPage)
                        <div data-type="{{$type}}" data-status="{{$status}}" class="loads" id="more_list"></div>
                        @endif
                            <!--路演列表块结束-->
                        @else
                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span style="color: #999999">出错了~{{$ResultData}}O(∩_∩)O~</span>
                        </li>
                        @endif

                @endif

            </div>

            <!----广告位开始----->
            <div class="guanggao col-lg-3 col-md-3 col-sm-12 hidden-xs ">
                <a href="#" class="col-sm-4 col-md-12 pad-clr"><img src="{{ asset('home/img/demoimg/zf3.jpg') }}" alt=""></a>
                <a href="#" class="col-sm-4 col-md-12 pad-clr"><img src="{{ asset('home/img/demoimg/zf2.jpg') }}" alt=""></a>
                <a href="#" class="col-sm-4 col-md-12 pad-clr"><img src="{{ asset('home/img/demoimg/zf1.jpg') }}" alt=""></a>
            </div>
            <!----广告位结束----->
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('JsService/Model/date.js') }} "></script>
    <script>
        function status(status) {
            var result;
            switch (status){
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
            var url="action/create";
            $.ajax({
                url:url,
                type:'get',
                data:{'nowPage':nowPage,'type':type,'status':sta},
                success:function (data) {
                    console.log(data);
                    data['ResultData']['data'].map(function (action) {
                        var html = '';
                        html += '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                        html += '<div class="row">';
                        html += '<div class="rodeing-img col-lg-4 col-md-4 col-sm-4 col-xs-12">';
                        html += '<a href="/action/' + action.guid + '"><img src="' + action.banner + '"  onerror="this.src=\'home/img/zxz.png\'"></a></div>';
                        html += '<div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">';
                        html += '<h2><a href="/action/' + action.guid + '">' + action.title + '</a></h2>';
                        html += '<div class="rodeing-class">';
                        html += '<ul class="row">';
                        html += '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">' + getLocalTime(action.start_time) + '——' + getLocalTime(action.end_time) + '</li>';
                        html += '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">' + action.address + '</li>';
                        html += '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><span class="road-banner-join">' + status(action.status) + '</span></li></ul></div></div></div></li>';

                        $('.rodeing-list').append(html);
                    });
                    if (nowPage<data.ResultData['totalPage']){
                        nowPage++;
                    }else {
                        $('#more_list').remove();
                    }
                }
            });
        });

    </script>
@endsection