@extends('home.layouts.master')

@section('style')
    <style>
        .col-lg-3 {
            width: 73%;
        }

    </style>
@endsection
@section('title', '活动详情')

@section('menu')
    @parent
@endsection

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">
            @if($data['StatusCode'] == '200')
                <header class="news_header">
                    <h2>{{ $data['ResultData']->title }}</h2>
                    <ul>
                        <li>
                            <a href="{{ $data['ResultData']->group->pointurl }}">{{ $data['ResultData']->group->name }}</a>
                            发布于 {{ $data['ResultData']->addtime }}</li>
                        <li>栏目：<a href="{{ url('action?type='.$data['ResultData']->type) }}" title="" target="_blank">校园活动</a>
                        </li>
                        <li>负责人：<strong>{{ $data['ResultData']->author }}</strong></li>
                        <li>共 <strong>2345</strong> 人围观</li>
                        <li><strong>123</strong> 个不明物体</li>
                    </ul>
                </header>
                <article class="news_content">
                    <div class="row">
                        <div class="col-md-8">
                            <li><strong>
                                    <h7>活动时间:</h7>
                                </strong> {{ date('Y年m月d日 H点', $data['ResultData']->start_time) }}
                                <strong>到</strong> {{ date('Y年m月d日 H点', $data['ResultData']->end_time) }}</li>
                            <li><strong>
                                    <h7>报名截止时间:</h7>
                                </strong> {{ date('Y年m月d日 H点', $data['ResultData']->deadline) }}</li>
                            <li><strong>
                                    <h7>活动地点:</h7>
                                </strong> {{ $data['ResultData']->address }}</li>
                            <li><strong>
                                    <h7>报名情况:</h7>
                                </strong> 已报名<strong id="people">{{ $data['ResultData']->people }}</strong>人
                                限额(<strong>{{ $data['ResultData']->limit }}</strong>)人
                            </li>
                        </div>
                        <div class="col-md-4">
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
                            @elseif($data['ResultData']->status == 3)
                                <button type="button" class="btn road-banner-join disabled">活动已结束</button>
                            @elseif($data['ResultData']->status == 4)
                                <button type="button" class="btn road-banner-join disabled">活动已取消</button>
                            @endif
                        </div>
                    </div>

                    <div style="height: 10px">
                    </div>
                    <div>
                        <p>{!! $data['ResultData']->describe !!}</p>
                    </div>
                </article>
                <div class="zambia"><a class="collect" name="zambia" rel=""><span
                                class="glyphicon glyphicon-thumbs-up"></span><span id="zan">赞</span>（<span id="zanNum">0</span>）</a></div>

                <div class="tags news_tags">标签： <span data-toggle="tooltip" data-placement="bottom"
                                                      title="查看关于 本站 的文章"><a href="{{ url('/') }}">本站</a></span> <span
                            data-toggle="tooltip" data-placement="bottom"><a
                                href="{{ url('/') }}">信息平台</a></span>
                </div>
            @endif
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
                        <input name="type" value="3" type="hidden">
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
                    @if($data['StatusCode'] == '200' && $comment['StatusCode'] == '200')
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
            <div class="content-block related-content visible-lg visible-md">
                <h2 class="title"><strong>相关推荐</strong></h2>
                <ul>
                    @if($rand['StatusCode'] == '200')
                        @foreach($rand['ResultData'] as $rand)
                            <li><a target="_blank" href="/action/{{ $rand->guid }}"><img src="{{ $rand->banner }}"
                                                                                         alt="{{ $rand->title }}">
                                    <h3><a href="/action/{{ $rand->guid }}">{{ $rand->title }}</a></h3>
                                </a></li>
                        @endforeach
                    @endif
                </ul>
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
        @if($isLogin && $data['StatusCode'] == '200')
        $('#js_enroll').click(function () {
            var obj = $(this);
            $.ajax({
                type: 'post',
                url: "/action_order",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {user_id: "{{$isLogin}}", action_id: "{{$data['ResultData']->guid}}", list: "{{$list}}"},
                success: function (data) {
                    if (data.StatusCode === "200") {
                        alert('报名成功！');
                        $('#people').html('{{ $data['ResultData']->people +1 }}');
                        obj.html("已报名").unbind("click");
                    } else {
                        swal(data.ResultData, '错误代码：' + data.StatusCode, "error");
                    }
                }
            })
        });
        //点赞功能暂时注释
        $('.collect').click(function () {
            var obj = $(this);
            var temp = obj.parent('p').is('.taoxin') ? -1 : 1;
            var num = parseInt($('#likeNum').html())
            $.ajax({
                type: "get",
                url: "/action/{{$data['ResultData']->guid}}/edit",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {type: 3},
                success: function (data) {
                    switch (data.StatusCode) {
                        case '200':
                            $('#zan').html('已赞');
                            $('#zanNum').html(parseInt($('#zanNum').html())+1);
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

