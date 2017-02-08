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
                    <div>
                        <div>
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
                                </strong> 已报名<strong>{{ $data['ResultData']->people }}</strong>人
                                限额(<strong>{{ $data['ResultData']->limit }}</strong>)人
                            </li>
                        </div>

                    </div>

                    <div style="height: 10px">
                    </div>
                    <p>{!! $data['ResultData']->describe !!}</p>
                </article>
                <div class="zambia"><a href="javascript:;" name="zambia" rel=""><span
                                class="glyphicon glyphicon-thumbs-up"></span> 赞（0）</a></div>

                <div class="tags news_tags">标签： <span data-toggle="tooltip" data-placement="bottom"
                                                      title="查看关于 本站 的文章"><a href="index.html">本站</a></span> <span
                            data-toggle="tooltip" data-placement="bottom" title="查看关于 异清轩 的文章"><a
                                href="index.html">异清轩</a></span>
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
                <form action="comment.php" method="post" class="form-inline" id="comment-form">
                    <div class="comment-form">
                        <textarea placeholder="你的评论可以一针见血" name="commentContent"></textarea>
                        <div class="comment-form-footer">
                            <div class="comment-form-text">请先 <a href="javascript:;">登录</a> 或 <a
                                        href="javascript:;">注册</a>，也可匿名评论
                            </div>
                            <div class="comment-form-btn">
                                <button type="submit" class="btn btn-default btn-comment">提交评论</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="comment-content">
                    <ul>
                        <li><span class="face"><img src="images/icon.png" alt=""></span> <span
                                    class="text"><strong>异清轩站长</strong> (2015-10-18) 说：<br/>
              欢迎来到异清轩技术博客，在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等在这里可以看到网站前端和后端的技术等 ...</span></li>
                    </ul>
                </div>
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
    <script>
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

