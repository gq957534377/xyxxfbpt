@extends('home.layouts.master')

@section('title', '创新作品')

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/school.css') }}">
@endsection
@section('content')
    <section class="bannerimg hang">
        <img src="{{ asset('home/img/demoimg/dd.jpg') }}">
    </section>
    <!---类型选择层开始---->
    <section class="container-fluid rodeing-type">
        <ul class="row">
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a class="@if($type == 1) active @endif"
                                                               href="school?type=1">企业管理</a></li>
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a class="@if($type == 2) active @endif"
                                                               href="school?type=2">资金管理</a></li>
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a class="@if($type == 3) active @endif"
                                                               href="school?type=3">人才管理</a></li>
        </ul>
    </section>
    <!---类型选择层结束---->
    <!---内容层开始---->
    <section class="container-fluid">
        <ul class="row content">
            @if($StatusCode == 204)
                <div style=" height:160px;width: 100%;text-align: center;font-size: 20px;line-height: 160px;color: #ddd8d5">
                    哎呦喂，亲，暂无数据哦O(∩_∩)O~
                </div>
            @elseif($StatusCode == 200)
                @foreach($ResultData['data'] as $data)
                    <li class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="content-block">
                            <img src="{{$data->banner}} " onerror="this.src='{{asset('home/img/zxz.png')}}'">
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
                @if($ResultData['totalPage'] > $nowPage)
                    <a data-name="{{($nowPage+1)}}" data-type="{{$type}}" id="more_list">点击加载更多</a>
                @endif
            @else
                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <span style="color: #999999">出错了~{{$ResultData}}O(∩_∩)O~</span>
                </li>
            @endif
        </ul>
    </section>
    <!---类型内容层结束---->
@endsection
@section('script')
    <script src="{{ asset('JsService/Model/date.js') }} "></script>
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
                                '<a href="/action/'+action.guid+'">'+action.title+
                                '</a>'+
                                '</h2>'+
                                '<p>'+action.brief+'</p>'+
                                '<div class="rodeing-class">'+
                                '<ul class="row">'+
                                '<li class="col-lg-6 col-md-6 col-sm-6 col-xs-3">'+type_list(action.type)+
                                '</li>'+
                                '<li class="col-lg-6 col-md-6 col-sm-6 col-xs-9">'+action.author+'</li>'+
                                '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'+getLocalTime(action.start_time)+'——'+getLocalTime(action.end_time)+'</li>'+
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