@extends('home.layouts.master')

@section('style')
    <style>
        .col-lg-3 {
            width: 73%;
        }

    </style>
@endsection
@section('title', '二手交易详情')

@section('menu')
    @parent
@endsection

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <header class="news_header">
                <h2>{{ $data->name }}</h2>
                <ul>
                    <li>
                        发布于 {{ date('Y-m-d H:m:s', $data->addtime )}}</li>
                    <li>栏目：<a>校园二手交易</a>
                    </li>
                </ul>
            </header>
            <article class="news_content">
                <div style="height: 10px">
                </div>
                <div class="sponsor">
                    <p class=""><span><strong>价格：</strong></span><h3 style="color: red">{{ $data->price }}元</h3></p>

                    <p class=""><span><strong>电话：</strong></span><a target="_blank"
                                                     href="">{{ $data->tel }}</a>
                    </p>
                    <p class=""><span><strong>QQ：</strong></span>{{ $data->qq }}</p>
                    <p class=""><span><strong>微信：</strong></span>{{ $data->wechat }}</p>
                    <p class="">{{ $data->brief}}</p>
                </div>
                <div>
                    <p>{!! $data->content !!}</p>
                </div>
            </article>
            <div class="zambia"><a @if($likeStatus != 1) class="collect" @endif rel=""><span
                            class="glyphicon glyphicon-thumbs-up"></span><span id="zan">@if($likeStatus != 1)赞@else
                            已赞@endif</span>（<span id="zanNum">{{ $likeNum }}</span>）</a></div>

            <div class="tags news_tags">标签： <span data-toggle="tooltip" data-placement="bottom"
                                                  title="关于 本站"><a href="{{ url('/') }}">本站</a></span> <span
                        data-toggle="tooltip" data-placement="bottom"><a
                            href="{{ url('/') }}">信息平台</a></span>
            </div>
            <p>分享到:</p>
            <div class="bdsharebuttonbox col-lg-3 col-md-4 col-sm-4 col-xs-9 pad-clr pad-l30-md pad-l30-sm">
                <a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone"
                                                                    title="分享到QQ空间"></a><a href="#" class="bds_tsina"
                                                                                           data-cmd="tsina"
                                                                                           title="分享到新浪微博"></a><a
                        href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren"
                                                                                       data-cmd="renren"
                                                                                       title="分享到人人网"></a><a href="#"
                                                                                                             class="bds_weixin"
                                                                                                             data-cmd="weixin"
                                                                                                             title="分享到微信"></a>

            </div>
            <div class="content-block comment">
                <h2 class="title"><strong>评论</strong></h2>
                <form id="comment" method="post" class="form-inline">
                    <div class="comment-form">
                        <textarea placeholder="你的评论可以一针见血" name="content"></textarea>
                        <input name="action_id" value="{{ $contentId}}" type="hidden">
                        <input name="type" value="4" type="hidden">
                        <div class="comment-form-footer">
                            @if(!$isLogin)
                                <div class="comment-form-text">请先 <a href="{{ url('/login') }}">登录</a> 或 <a
                                            href="{{ url('/register') }}">注册</a>
                                </div>
                            @endif
                            <div class="comment-form-btn">
                                <button type="submit" class="btn btn-default btn-comment">提交评论</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="comment-content" id="js_comment">
                    @if($comment['StatusCode'] == '200')
                        @foreach($comment['ResultData'] as $datas)
                            <ul>
                                <li><span class="face"><img src="{{ $datas->userImg }}" alt=""></span> <span
                                            class="text"><strong>{{ $datas->nikename }}</strong> ({{ date('Y-m-d H:m:s', $datas->addtime) }}
                                        ) 说：<br/>
                                        {{ $datas->content }}</span></li>
                            </ul>
                        @endforeach
                    @endif
                </div>
                <div id="js_pages" class="pull-right">{!! $pageStyle !!}</div>
            </div>
        </div>
    </div>
    <!--/内容-->
@endsection
@section('script')
    <script src="{{asset('home/js/jquery.validate.min.js')}}"></script>
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <script src="{{ asset('home/js/commentForpage.js') }}"></script>
    <script src="{{ asset('home/js/commentValidate.js') }}"></script>
    <script>
        var token = $('meta[name="csrf-token"]').attr('content');
        @if($isLogin)
        //点赞功能暂时注释
        $('.collect').click(function () {
            var obj = $(this);
            var temp = obj.parent('p').is('.taoxin') ? -1 : 1;
            var num = parseInt($('#likeNum').html())
            $.ajax({
                type: "get",
                url: "/action/{{$data->guid}}/edit",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {type: 3},
                success: function (data) {
                    switch (data.StatusCode) {
                        case '200':
                            $('#zan').html('已赞');
                            $('#zanNum').html(parseInt($('#zanNum').html()) + 1);
                            break;
                        case '400':
                            alert(data.ResultData);
                            break;
                    }
                },
                error: function (XMLHttpRequest) {
                    var number = XMLHttpRequest.status;
                    var msg = "Error: " + number + ",数据异常！";
                    alert(msg);
                }
            })
        })
        @else
            $('#js_enroll').click(function () {
            alert('请登录后操作！');
            login();
        });
        //点赞功能暂时注释
        $('.collect').click(function () {
            alert('请登录后操作！');
            login();
        });
        $('#comment').click(function () {
            alert('请登录后操作！');
            login();
        });
        @endif
        function login() {
            window.location.href = "{{route('login.index')}}";
        }


        //分享按钮
        window._bd_share_config = {
            "common": {
                "bdSnsKey": {},
                "bdText": "",
                "bdMini": "2",
                "bdMiniList": false,
                "bdPic": "",
                "bdStyle": "0",
                "bdSize": "24"
            }, "share": {}
        };
        with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
    </script>
@endsection

