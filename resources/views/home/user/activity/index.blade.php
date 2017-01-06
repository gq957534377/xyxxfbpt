@extends('home.layouts.userCenter')

@section('title','参加的活动')

@section('style')
    <link href="{{ asset('home/css/user_center_my_road.css') }}" rel="stylesheet">
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
                <li class=""><a @if($ResultData['list'] == 1)class="active" @endif href="{{asset('/action_order?list=1&type=1')}}">路演活动</a></li>
                <li class=""><a @if($ResultData['list'] == 2)class="active" @endif href="{{asset('/action_order?list=2&type=2')}}">创业大赛</a></li>
                <li class=""><a @if($ResultData['list'] == 3)class="active" @endif href="{{asset('/action_order?list=3')}}">英雄学院</a></li>
            </ul>
        </div>
        <div class="row mar-clr bb-3">
            <div class="col-sm-3 col-md-3 col-lg-2 pad-cl">
                <p>活动状态：</p>
            </div>
            <ul class="col-sm-9 col-md-9 col-lg-10 road-time mar-clr pad-clr">
                <li class='pad-r2-xs @if($ResultData['status'] == 6) active @endif'><a href="{{asset('/action_order?list='.$ResultData['list'].'&type='.$ResultData['list'])}}">全部</a></li>
                <li class='pad-r2-xs @if($ResultData['status'] == 1) active @endif'><a href="{{asset('/action_order?list='.$ResultData['list'].'&type='.$ResultData['list'].'&status=1')}}">报名中</a></li>
                <li class='pad-r2-xs @if($ResultData['status'] == 5) active @endif'><a href="{{asset('/action_order?list='.$ResultData['list'].'&type='.$ResultData['list'].'&status=5')}}">等待开始</a></li>
                <li class='pad-r2-xs @if($ResultData['status'] == 2) active @endif'><a href="{{asset('/action_order?list='.$ResultData['list'].'&type='.$ResultData['list'].'&status=2')}}">进行中</a></li>
                <li class='pad-r2-xs @if($ResultData['status'] == 3) active @endif'><a href="{{asset('/action_order?list='.$ResultData['list'].'&type='.$ResultData['list'].'&status=3')}}">已结束</a></li>
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
                <div class="row mar-clr bb-3">
                    <div class="road-img col-lg-5 col-md-12 col-sm-12 pad-clr">
                        <a @if($ResultData['list'] == 3) href="{{asset('/school/'.$action->guid)}}" @else href="{{asset('/action/'.$action->guid)}}" @endif><img src="{{ $action->banner }}"  alt=""></a>
                    </div>
                    <div class="road-font col-lg-7 col-md-12 col-sm-12 pad-clr">
                        <h2>
                            @if($ResultData['list'] == 3)
                            <a href="{{asset('/school/'.$action->guid)}}">
                                @else
                            <a href="{{asset('/action/'.$action->guid)}}">
                                @endif
                                {{ $action->title }}
                            </a>
                        </h2>
                        <p class="indent">
                            {{ $action->brief }}
                        </p>
                        <div class="row mar-clr road-class-u">
                            <p class="col-sm-6 col-xs-12 pad-clr">
                                @if($ResultData['list'] == 3)
                                    @if($action->type == 1)
                                        企业管理
                                    @elseif($action->type == 2)
                                        资金管理
                                    @elseif($action->type == 3)
                                        人才管理
                                    @endif
                                @else
                                    @if($action->type == 1)
                                        路演活动
                                    @elseif($action->type == 2)
                                        创业大赛
                                    @endif
                                @endif
                            </p>
                            <p class="col-sm-6 col-xs-12 pad-clr">{{ $action->author }}</p>
                        </div>
                        <div class="road-class-d">
                            <p class="col-xs-12 pad-clr">{{ date('Y年m月d日 H:m', $action->start_time) }}--{{ date('Y年m月d日 H:m', $action->end_time) }}</p>
                            <p class="col-xs-12 pad-clr">{{ $action->address }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
                <div class="panel" id="data">{!! $ResultData['pages'] !!}</div>
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

    //活动类型展示
    function type(type) {
        var res;
        if ("{{$ResultData['list']}}" != 3)
        {
            switch (type){
                case 1:
                    res = '路演活动';
                    break;
                case 2:
                    res = '创业大赛';
                    break;
                default:
                    break;
            }
        }else{
            switch (type){
                case 1:
                    res = '企业管理';
                    break;
                case 2:
                    res = '资金管理';
                    break;
                case 3:
                    res = '人才管理 ';
                    break;
                default:
                    break;
            }
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
            if (status == 6){
                url = $(this).children().prop('href') + '&list=' + list + '&type=' + list;
            }else {
                url = $(this).children().prop('href') + '&list=' + list + '&type=' + list +'&status=' + status;
            }

            $.ajax({
                url: url,
                success: function (data) {
                    $('#list').html('');
                    $('#data').html('');
                    console.log(data);
                    if (data.StatusCode === '200'){
                        var html = '';
                        $.each(data.ResultData.data, function (i,v) {
                            html+='<div class="row mar-clr bb-3"><div class="road-img col-lg-5 col-md-12 col-sm-12 pad-clr">';
                            html+='<a';
                            if(data.ResultData.list === 3){
                                html+= 'href="/school/'+v.guid+'">';
                            }else{
                                html += 'href="/actionl/'+v.guid+'">';
                            }
                            html += '<img src="'+v.banner+'"></a></div>';
                            html+='<div class="road-font col-lg-7 col-md-12 col-sm-12 pad-clr"><h2>';
                            if(data.ResultData.list === 3){
                                html+='<a href="/school/'+v.guid+'">';
                            }else{
                                html+='<a href="/action/'+v.guid+'">';
                            }
                            html += v.title+'</a></h2><p class="indent">'+v.brief+'</p><div class="row mar-clr road-class-u">';
                            html += '<p class="col-sm-6 col-xs-12 pad-clr">';
//                            if (v.type === 1){
//                                html += '路演活动';
//                            }else if(v.type === 2){
//                                html += '创业大赛';
//                            }else if(v.type === 3){
//                                html += '英雄学院';
//                            }
                            html += type(v.type);
                            html += '</p><p class="col-sm-6 col-xs-12 pad-clr">'+v.author+'</p></div>';
                            html += '<div class="road-class-d">';
                            html += '<p class="col-xs-12 pad-clr">'+getLocalTime(v.start_time)+'--'+getLocalTime(v.end_time)+'</p>';
                            html += '<p class="col-xs-12 pad-clr">'+v.address+'</p></div></div></div>';
                        });
                        console.log(html);
                        $('#list').html(html);
                        $('#data').html(data.ResultData.pages);
                        getPage();
                    }else{
                        $('#list').html('好像出错了呦:'+data.ResultData.data+',错误代码：'+data.StatusCode);
                    }
                }
            });
            return false;
        });
    }
    getPage();
</script>
@endsection