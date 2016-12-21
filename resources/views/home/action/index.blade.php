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
    <section class="container-fluid rodeing-type">
        <ul class="row">
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'>活动类型：</li>
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a class="@if($type == 1) active @endif" href="{{ route('action.index', ['type' => '1']) }}">路演活动</a></li>
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a class="@if($type == 2) active @endif" href="{{ route('action.index', ['type' => '2']) }}">创业大赛</a></li>
        </ul>
    </section>

    <section class="container-fluid">
        <div class="row rodeing-content">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <ul class="row rodeing-time">
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'>活动状态：</li>
                    {{--{{dd($status)}}--}}
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2 @if($status == 204)active @endif'><a href="/action?type={{$type}}">所有</a></li>
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2 @if($status == 1)active @endif'><a href="/action?type={{$type}}&status=1">未开始</a></li>
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2 @if($status == 2)active @endif'><a href="/action?type={{$type}}&status=2">进行中</a></li>
                    <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2 @if($status == 3)active @endif'><a href="/action?type={{$type}}&status=3">往期回顾</a></li>
                </ul>
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
                                            <img src="{{ $action->banner }}"  onerror="this.src='{{asset('home/img/zxz.png')}}'">
                                        </div>
                                        <div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                            <h2>
                                                <a href="{{ route('action.show', $action->guid) }}">
                                                    {{ $action->title }}
                                                </a>
                                            </h2>
                                            <p>{{ $action->brief }}</p>
                                            <div class="rodeing-class">
                                                <ul class="row">
                                                    <li class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                                                        @if($action->type == 1)
                                                            路演活动
                                                        @elseif($action->type == 2)
                                                            创业大赛
                                                        @endif
                                                    </li>
                                                    <li class="col-lg-6 col-md-6 col-sm-6 col-xs-9">{{ $action->author }}</li>
                                                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ date('Y/m/d H:m',$action->start_time) }}——{{ date('Y/m/d H:m',$action->end_time) }}</li>
                                                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ $action->address }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if($ResultData['totalPage'] > $nowPage)
                        <a data-name="{{($nowPage+1)}}" data-type="{{$type}}" id="more_list">点击加载更多</a>
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
            <div class="guanggao col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <a href="#"><img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('home/img/demoimg/test13.jpg') }}" alt=""></a>
            </div>
            <!----广告位结束----->
        </div>
    </section>
@endsection

@section('script')
    <script>
        var type_list = function(type) {
            if (type == 1){
                return "路演活动";
            }else{
                return "创业大赛";
            }
        }
        var nowPage = 2;
        var type = $('#more_list').data('type');
        $('#more_list').click(function () {
//            nowPage = $(this).data('name');
//            type = $(this).data('type');
            var url="action/create";
            $.ajax({
                url:url,
                type:'get',
                data:{'nowPage':nowPage,'type':type},
                success:function (data) {
                    console.log(data);

                    data['ResultData']['data'].map(function (action) {
                        $('.rodeing-list').append('<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'+
                                '<div class="row">'+
                                '<div class="rodeing-img col-lg-4 col-md-4 col-sm-4 col-xs-12">'+
                                '<img src="'+action.banner+'"  onerror="this.src=\'home/img/zxz.png\'">'+
                                '</div>'+
                                '<div class="rodeing-font col-lg-8 col-md-8 col-sm-8 col-xs-12">'+
                                '<h2>'+
                                '<a href="">'+action.title+
                                '</a>'+
                                '</h2>'+
                                '<p>'+action.brief+'</p>'+
                                '<div class="rodeing-class">'+
                                '<ul class="row">'+
                                '<li class="col-lg-6 col-md-6 col-sm-6 col-xs-3">'+type_list(action.type)+
                        '</li>'+
                        '<li class="col-lg-6 col-md-6 col-sm-6 col-xs-9">'+action.author+'</li>'+
                         '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'+action.start_time+'——'+action.end_time+'</li>'+
                        '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'+action.address+'</li></ul></div></div></div></li>'
                                );
                    });
                    if (nowPage<data.ResultData['totalPage']){
                        nowPage+=1;
                    }else {
                        $('#more_list').remove();
                    }
//                    $('#more_list').attr('data-name',(nowPage));
                    console.log("{{$nowPage}}");
                }
            });
        });

    </script>
@endsection