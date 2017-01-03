@extends('home.layouts.master')

@section('title', '创新作品')

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/roading.css') }}">
@endsection
@section('content')
    <section class="bannerimg hang">
        <img src="{{ asset('home/img/demoimg/dd.jpg') }}">
    </section>
    <!---类型选择层开始---->
    <section class="container mar-b10">

        <div class="nav-status-bar col-xs-12 pad-clr">
            @if($type == 1)
                <span>企业管理</span>
                <span class="pull-right">企业管理</span>
            @elseif($type == 2)
                <span>资金管理</span>
                <span class="pull-right">资金管理</span>
            @elseif($type == 3)
                <span>人才管理</span>
                <span class="pull-right">人才管理</span>
            @endif
            <span class="pull-right">＞</span>
            <span class="pull-right">英雄学院</span>
            <div></div>
        </div>

        <ul class="nav-status-bar-type col-xs-12 pad-clr">
            <li @if($status == 204)class="nav-status-bar-type-active" @endif><a href="school?type=1">企业管理</a></li>
            <li @if($status == 1)class="nav-status-bar-type-active" @endif><a href="school?type=2">资金管理</a></li>
            <li @if($status == 5)class="nav-status-bar-type-active" @endif><a href="school?type=3">人才管理</a></li>
        </ul>

    </section>
    <!---类型选择层结束---->
    <!---内容层开始---->
    <section class="container-fluid">
        <ul class="row content school_list">
            @if($StatusCode == 204)
                <div style=" height:160px;width: 100%;text-align: center;font-size: 20px;line-height: 160px;color: #ddd8d5">
                    哎呦喂，亲，暂无数据哦O(∩_∩)O~
                </div>
            @elseif($StatusCode == 200)
                @foreach($ResultData['data'] as $data)
                    <li class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="content-block">
                            <a href="school/{{$data->guid}}"><img src="{{$data->banner}} " onerror="this.src='{{asset('home/img/zxz.png')}}'"></a>
                            <h2><a href="school/{{$data->guid}}">{{$data->title}}</a></h2>
                            <p>
                                {{$data->brief}}
                            </p>
                            <div>
                                <span>{{date('Y年m月d日 H:m', $data->addtime)}}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <span style="color: #999999">出错了~{{$ResultData}}O(∩_∩)O~</span>
                </li>
            @endif
        </ul>
        @if($ResultData['totalPage'] > $nowPage)
            <div data-type="{{$type}}" class="loads" id="more_list"></div>
        @endif
    </section>
    <!---类型内容层结束---->
@endsection
@section('script')
    <script src="{{ asset('JsService/Model/date.js') }} "></script>
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
            var url="school/create";
            $.ajax({
                url:url,
                type:'get',
                data:{'nowPage':nowPage,'type':type},
                success:function (data) {
                    console.log(data);

                    data['ResultData']['data'].map(function (action) {
                        $('.school_list').append('<li class="col-lg-3 col-md-3 col-sm-4 col-xs-12"><div class="content-block">' +
                                '<a href="/school/'+action.guid+'">'+
                                '<img src="'+action.banner+'"  onerror="this.src=\'home/img/zxz.png\'"></a>'+
                                '<h2>'+
                                '<a href="/school/'+action.guid+'">'+action.title+
                                '</a></h2>'+
                                '<p>'+action.brief+'</p><div>'+
                                '<span>'+getLocalTime(action.addtime)+'</span></div></div></li>'
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
