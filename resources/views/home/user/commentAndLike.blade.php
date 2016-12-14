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
            @if(!empty($data))
            @foreach($data as $data)
            <div class="my-like-box pad-3 bb-1">
                <p class="col-xs-12">
                    <a href="{{route('action.show', $data->action_id) }}"><span>资讯</span>{{$data->contentTitle}}</a>
                </p>
                <div class="col-xs-12 zxz-comment">
                    {{$data->content}}
                </div>
                <p class="col-xs-12 mar-cb">{{$data->time}}</p>
                <div class="clearfix"></div>
            </div>
            @endforeach
                <div class="page-style pull-right mar-emt15">
                    {!! $pageData['pages'] !!}
                </div>
            @else
                <div class="my-like-box pad-3 bb-1">
                    暂无您的评论数据呦~亲
                    {{$errinfo}}
                    <div class="clearfix"></div>
                </div>
            @endif
            <!--分页-->


        </div>
        <div class="zxz-none col-xs-12 col-sm-9 col-md-9 col-lg-10 fs-15 bgc-1 pad-9">
            <div class="my-like-box pad-3 bb-1">
                <p class="col-xs-12">
                    <a href="#"><span>资讯</span>调研报告：初创公司生存状态面面观调研报告：初创公司生存状态面面观调研报告：初创公司生存状态面面观调研报告：初创公司生存状态面面观调研报告：初创公司生存状态面面观</a>
                </p>
                <p class="col-xs-12 mar-cb">2016-12-04 10:44</p>
                <div class="clearfix"></div>
            </div>
            <!--分页-->
            <div class="pull-right mar-emt15">
                {{--<ul class="list-inline">--}}
                {{--<li class="b-all-1 fs-c-5">上一页</li>--}}
                {{--<li class="b-all-1 fs-c-1 bgc-7">1</li>--}}
                {{--<li class="b-all-1">2</li>--}}
                {{--<li class="b-all-1 border-no">...</li>--}}
                {{--<li class="b-all-1">下一页</li>--}}
                {{--</ul>--}}
            </div>

        </div>
        <!--我的评论 点赞 结束-->
    </section>
@endsection



@section('script')
    <script>
        function aOnClica() {
            $("#js_changStyle a").click(function () {
                changeStyle();
            })
        }
        function changeStyle() {
            $('#js_changStyle a').toggleClass("active");
            aOnClica();
            $('#js_changStyle .active').unbind("click")
            $('.zxz-none').toggleClass("active");
        }
        aOnClica();
    </script>
@endsection
