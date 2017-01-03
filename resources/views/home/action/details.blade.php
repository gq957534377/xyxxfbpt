@extends('home.layouts.master')

@section('title', '活动详情')

@section('style')
    <link href="{{ asset('home/css/roading-details.css') }}" rel="stylesheet">
    <!-- sweet alerts -->
    <link href="http://cdn.rooyun.com/css/sweet-alert.min.css" rel="stylesheet">
    <style>
        .sweet-alert p {
            font-size: 14px;
            font-weight: 400;
            line-height: 22px;
        }
        button.confirm {
            background-color: #34c73b !important;
            box-shadow: none !important;
        }
        .sweet-alert .sa-icon.sa-success .sa-placeholder {
            border: 4px solid #34c73b;
        }
        .sweet-alert .sa-icon.sa-success .sa-line {
            background-color: #34c73b;
        }
        .sweet-alert .sa-icon.sa-error {
            border-color: #d74548;
        }
        .sweet-alert .sa-icon.sa-error .sa-line {
            background-color: #d74548;
        }
    </style>
@endsection

@section('menu')
    @parent
@endsection

@section('content')
    <!--活动详情banner 开始-->
    <section class="container road-banner mar-emt1">
        @if($data['StatusCode'] == '200')
            <h1 class="mar-ct">{{ $data['ResultData']->title }}</h1>
            <p class=""><span>活动时间：</span>{{ date('Y年m月d日 H点',$data['ResultData']->start_time) }}——{{ date('Y年m月d日 H点',$data['ResultData']->end_time) }}</p>
            <p class=""><span>报名截止时间：</span>{{ date('Y年m月d日 H点',$data['ResultData']->start_time) }}</p>
            <p class=""><span>活动地点：</span>{{ $data['ResultData']->address }}</p>
            <p id="baomingNum" class="mar-b15">已报名{{ $data['ResultData']->people }}人 &nbsp;限额({{ $data['ResultData']->people }})人</p>

            <!--两个按钮按照情况只显示一个-->
            @if($data['ResultData']->status == 1)
                @if(!$isHas)
                    <button id="js_enroll" type="button" class="btn road-banner-join">我要报名</button>
                @else
                    <button type="button" class="btn road-banner-join">已报名</button>
                @endif
            @elseif($data['ResultData']->status == 5)
                <button type="button" class="btn road-banner-join disabled">报名截止</button>
            @elseif($data['ResultData']->status == 2)
                <button type="button" class="btn road-banner-join disabled">活动已开始</button>
            @endif
        @else
            <h4 class="mar-ct mar-b15">{{ $data['ResultData'] }}</h4>
        @endif
    </section>
    <!--活动详情banner 结束-->
    <!--活动说明 & 评论 开始-->
    <section class="container">
        <span class="content-bar dis-in-bl mar-5 fs-18">活动说明</span>
        <div class="row bgc-0">
            <!--活动说明 开始-->
            <div class="col-md-9 col-lg-9 pad-clr mar-b15">
                <div class="br-1 pad-8 b-n-sm b-n-xs mar-cr-sm mar-cr-xs road-explain">
                    @if($data['StatusCode'] == '200')
                        <div class="sponsor">
                        @if(is_object($data['ResultData']->group))
                            <p class=""><span>主办机构：</span><a target="_blank" href="http://{{$data['ResultData']->group->pointurl}}">{{ $data['ResultData']->group->name }}</a></p>
                            @else
                            <p class=""><span>主办机构：</span>{{ $data['ResultData']->group }}</p>
                            @endif
                        <p class=""><span>负责人：</span>{{ $data['ResultData']->author }}</p>
                        <p class=""><span>活动简述：</span>{{ $data['ResultData']->brief }}</p>
                        </div>
                        <div class="col-md-12">
                            {!! $data['ResultData']->describe !!}
                        </div>
                        <p class="col-lg-8 col-md-7 col-sm-7 col-xs-12 @if($likeStatus == 1) taoxin @endif">
                        {{--<span class="collect">--}}
                          {{--<span id="likeFont"></span><span id="likeNum">{{$likeNum}}</span>--}}
                        {{--</span>--}}
                        </p>
                        <p class="col-lg-1 col-md-1 col-sm-1 col-xs-3 pad-cr pad-clr-md pad-cl-sm line-h-36">分享到</p>
                        <div class="bdsharebuttonbox col-lg-3 col-md-4 col-sm-4 col-xs-9 pad-clr pad-l30-md pad-l30-sm">
                            <a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>

                        </div>
                        <div class="clearfix"></div>
                    @endif
                </div>
            </div>
            <!--活动说明 结束-->

            <div class="col-lg-3 col-md-3 content-right">
                <div class="guangao row">
                    <a href="#"><img onerror="this.src='{{asset('home/img/zxz.png')}}'" class="col-lg-12 col-md-12" src="{{ asset('home/img/test13.jpg') }}"></a>
                </div>
                <div class="row news-list-title">
                    <h2>7×24h 快讯</h2>
                </div>
                <ul class="row news-list">
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
                        <div class="news-list-time">
                            <span>两分钟前</span>
                        </div>
                    </li>
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
                        <div class="news-list-time">
                            <span>两分钟前</span>
                        </div>
                    </li>
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
                        <div class="news-list-time">
                            <span>两分钟前</span>
                        </div>
                    </li>
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
                        <div class="news-list-time">
                            <span>两分钟前</span>
                        </div>
                    </li>
                </ul>
                <!-- <div class="btn-ll">
                  浏览更多
                </div> -->
            </div>

            <!--活动评论 开始-->
            <div class="col-md-9 col-lg-9 road-comment road-banner pl-block">
                <h2 class="col-lg-8 col-md-8 col-sm-8 col-xs-8">评论</h2>
                <a href="{{asset('comment')}}" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">更多评论></a>
                <ul id="commentlist" class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!---循环遍历开始-->
                    <li class="row inputs">
                        <form id="comment" method = 'post'>
                            <input name="action_id" value="{{ $contentId}}" hidden>
                            <input name="type" value="3" hidden>
                            <textarea name="content" required></textarea>
                            <button type="submit" class="subbtn btn btn-warning" >提交</button>
                        </form>
                    </li>
                    @if($comment['StatusCode'] == '200')
                        @foreach($comment['ResultData'] as $datas)
                            <li class="row">
                                <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div class="user-img-bgs">
                                        <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $datas->userImg }}">
                                    </div>
                                </div>
                                <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="row user-say1">
                                        <span>{{ $datas->nikename }}</span>
                                        <span>{{ date('Y-m-d H:m:s',$datas->changetime) }}</span>
                                    </div>
                                    <div class="row user-say2">
                                        <p>{{ $datas->content }}</p>
                                    </div>
                                </div>
                            </li>
                    @endforeach
                @endif
                <!---循环遍历结束-->
                </ul>
                <div class="clearfix"></div>
            </div>
            <!--活动评论 结束-->
        </div>
    </section>
    <!--活动说明 & 评论 结束-->
@endsection
@section('script')
    {{--提示框--}}
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <script src="{{asset('admin/js/sweet-alert.min.js')}}"></script>
    <script src="{{ asset('home/js/commentValidate.js') }}"></script>
    <script>
        var token  = $('meta[name="csrf-token"]').attr('content');
        @if($isLogin && $data['StatusCode'] == '200')
        $('#js_enroll').click(function(){
            var obj = $(this);
            $.ajax({
                type:'post',
                url:"/action_order",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data:{user_id:"{{$isLogin}}",action_id:"{{$data['ResultData']->guid}}",list:"{{$list}}"},
                success:function (data) {
                    if (data.StatusCode === "200"){
                        swal(data.ResultData, '可以到个人中心“我参加的活动”查看', "success");
                        $('#baomingNum').html('已报名'+({{$data['ResultData']->people}}+1)+'人');
                        obj.html("已报名").unbind("click");
                    }else{
                        swal(data.ResultData, '错误代码：'+data.StatusCode, "error");
                    }
                }
            })
        });
        {{--$('.collect').click(function () {--}}
            {{--var obj = $(this);--}}
            {{--var temp = obj.parent('p').is('.taoxin')?-1:1;--}}
            {{--var num = parseInt($('#likeNum').html())--}}
            {{--$.ajax({--}}
                {{--type:"get",--}}
                {{--url:"/action/{{$data['ResultData']->guid}}/edit",--}}
                {{--headers: {--}}
                    {{--'X-CSRF-TOKEN': token--}}
                {{--},--}}
                {{--data:{type:3},--}}
                {{--success:function (data) {--}}
                    {{--switch (data.StatusCode){--}}
                        {{--case '200':obj.parent('p').toggleClass('taoxin');$('#likeNum').html(num+temp);break;--}}
                        {{--case '400':swal('警告', data.ResultData, "waring");break;--}}
                    {{--}--}}
                {{--},--}}
                {{--error: function(XMLHttpRequest){--}}
                    {{--var number = XMLHttpRequest.status;--}}
                    {{--var msg = "Error: "+number+",数据异常！";--}}
                    {{--swal('点赞失败', msg, "error");--}}
                {{--}--}}
            {{--})--}}
        {{--})--}}
        @else
            $('#js_enroll').click(function(){
            swal({
                        title: '请登录后操作', // 标题，自定
                        text: '请登陆后再报名参加',   // 内容，自定
                        type: "warning",    // 类型，分别为error、warning、success，以及info
                        showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                        confirmButtonColor: '#DD6B55',  // 确认用途的按钮颜色，自定
                    },
                    function (isConfirm) {
                        swal('请登录后操作', '请登陆后再进行报名参加', "waring");
                        login();
                    });
        });
//        $('.collect').click(function () {
//            swal({
//                    title: '请登录后操作', // 标题，自定
//                            text: '请登陆后再进行点赞操作',   // 内容，自定
//                            type: "warning",    // 类型，分别为error、warning、success，以及info
//                            showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
//                            confirmButtonColor: '#DD6B55',  // 确认用途的按钮颜色，自定
//                },
//                function (isConfirm) {
//                    swal('请登录后操作', '请登陆后再进行点赞操作', "warning");
//                    login();
//                });
//        });
        $('#comment').click(function () {
            swal({
                        title: '请登录后操作', // 标题，自定
                        text: '请登陆后再进行评论',   // 内容，自定
                        type: "warning",    // 类型，分别为error、warning、success，以及info
                        showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                        confirmButtonColor: '#DD6B55',  // 确认用途的按钮颜色，自定
                    },
                    function (isConfirm) {
                        swal('请登录后操作', '请登陆后再进行评论', "warning");
                        login();
                    });
        });
        @endif
        function login() {
            window.location.href = "{{route('login.index')}}"
        }

        //分享按钮
        window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};
        with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
    </script>
@endsection
