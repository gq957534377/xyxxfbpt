@extends('home.layouts.userCenter')

@section('title','点赞和评论')

@section('style')
    <link href="{{asset('home/css/user_center_my_like_list.css')}}" rel="stylesheet">
@endsection

@section('content')
    <section class="container-fluid zxz-styled" onselectstart="return false;" style="-moz-user-select:none;">
        <!--导航开始-->
        <div id="js_changStyle" class="tab-info-top col-xs-12 col-sm-9 col-md-9 col-lg-10 pad-clr fs-15 fw-1">
            <a class="active" href="javascript:void(0);">我的评论
                <span class="triangle-down left-2">
                </span>
            </a>
            <a class="pad-tab-top-info-xs" href="javascript:void(0);">我的点赞
                <span class="triangle-down left-2">
                </span>
            </a>
        </div>
        <!--导航结束-->
        <div class="active zxz-none col-xs-12 col-sm-9 col-md-9 col-lg-10 fs-15 bgc-1 pad-9">
            @if(!empty($commentData))
            @foreach($commentData as $data)
            <div class="my-like-box pad-3 bb-1">
                <p class="col-xs-12">
                    <a href="{{route('action.show', $data->action_id) }}"><span>活动</span>{{$data->contentTitle}}</a>
                </p>
                <div class="col-xs-12 zxz-comment">
                    {{$data->content}}
                </div>
                <p class="col-xs-12 mar-cb">{{$data->time}}</p>
                <div class="clearfix"></div>
            </div>
            @endforeach
                <div class="page-style pull-right mar-emt15">
                    {!! $commentPage['pages'] !!}
                </div>
            @else
                <div class="my-like-box pad-3 bb-1">
                    暂无您的评论数据呦~亲
                    <div class="clearfix"></div>
                </div>
            @endif
            <!--分页-->


        </div>
        <div class="zxz-none col-xs-12 col-sm-9 col-md-9 col-lg-10 fs-15 bgc-1 pad-9">
            @if(!empty($likeData))
                <div id="js_ajaxReplace">
                @foreach($likeData as $data)
                    <div class="my-like-box pad-3 bb-1">
                        <p class="col-xs-12">
                            <a href="{{route('action.show', $data->action_id) }}"><span>活动</span>{{$data->contentTitle}}</a>
                        </p>
                        <p class="col-xs-12 mar-cb">{{$data->time}}</p>
                        <div class="clearfix"></div>
                    </div>
                @endforeach
                </div>
                <div id="likePage" class="page-style pull-right mar-emt15">
                    {!! $likePage['pages'] !!}
                </div>
            @else
                <div class="my-like-box pad-3 bb-1">
                    暂无您的点赞数据呦~亲
                    <div class="clearfix"></div>
                </div>
            @endif

        </div>
        <!--我的评论 点赞 结束-->
    </section>
@endsection



@section('script')
    <script>
        aOnClick();
        pageOnclick();
        function aOnClick()
        {
            $("#js_changStyle a").click(function () {
                changeStyle();
            })
        }
        function changeStyle()
        {
            $('#js_changStyle a').toggleClass("active");
            aOnClick();
            $('#js_changStyle .active').unbind("click")
            $('.zxz-none').toggleClass("active");
        }
        //点赞页码ajax请求
        function ajaxRequest(obj)
        {
            var num = obj.html();
            $.ajax({
                url:"{{route('getLike')}}",
                type:'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{nowPage:num},
                success:function (data) {
                    successFun(data);
                }
            })
        }
        //点赞页码点击事件
        function pageOnclick()
        {
            $("#likePage ul li a").click(function () {
                ajaxRequest($(this));
                return false;
            })
        }
        //ajax成功后的执行方法
        function successFun(data) {
            if (data.StatusCode == "200") {
                plot(data.ResultData);
            }else {
                alert("网络忙！请尝试刷新页面");
            }
        }
        
        function plot(data) {
            var html = "";
            var pageData = data['pageData']['pages'];
            delete data.pageData;
            var likeData = data;
            for (var data in likeData) {
                html += "<div class='my-like-box pad-3 bb-1'>";
                html +=     "<p class='col-xs-12'>";
                html +=         "<a href="+likeData[data]['action_id']+"><span>活动</span>";
                html +=             likeData[data]['contentTitle'];
                html +=         "</a></p>";
                html +=     "<p class='col-xs-12 mar-cb'>";
                html +=         likeData[data]['time'];
                html +=     "</p><div class='clearfix'></div></div>";
            }
            $('#js_ajaxReplace').html(html);
            $('#likePage').html(pageData);
            pageOnclick();
        }
    </script>
@endsection
