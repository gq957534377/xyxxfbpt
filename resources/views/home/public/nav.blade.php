<div class="hidden-xs header"><!--超小屏幕不显示-->
    <h1 class="logo"><a href="{{url('/')}}/" title="校园信息发布平台"></a></h1>
    @if(!empty(session('user')))
        <div class="top-right">
            <center><a href="{{ url('/user/'.session('user')->guid) }}"><img id="topAvatar" class="img-circle"
                                                                     style="width: 66%"
                                                                     src="{{ session('user')->headpic }}"
                                                                     data-id="{{ session('user')->guid }}"></a></center>
            <a class="hidden-xs" href="{{ url('/user/'.session('user')->guid) }}" style="margin-left: 24%">
                <mark id="nicknameBox">{{ session('user')->username }}</mark>
            </a>
            <span class="hidden-xs">|</span>
            <a class="pad-l12-xs" href="{{ url('/logout') }}">退出</a>
        </div>
    @else
        <div class="top-right" style="margin-left: 13%">

            <a class="hidden-xs" id="modaltrigger" href="{{ url('/login') }}">
                <mark id="nicknameBox">登陆</mark>
            </a>
            <span class="hidden-xs">|</span>
            <a class="pad-l12-xs" href="{{ url('/register') }}">注册</a>
        </div>
    @endif
    <ul class="nav hidden-xs-nav nav-box">
        <li class="active">
            <a href="{{url('/')}}"><span class="glyphicon glyphicon-home"></span>网站首页</a>
        </li>
        <li><a><span style="font-size: 25px;" class="zmdi zmdi-odnoklassniki"></span>校园活动</a>
            <div>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ url('/action?type=1') }}"><span class="glyphicon glyphicon-erase"></span>文娱活动</a>
                    <li><a href="{{ url('/action?type=2') }}"><span class="glyphicon glyphicon-erase"></span>学术活动</a>
                    <li><a href="{{ url('/action?type=3') }}"><span class="glyphicon glyphicon-erase"></span>竞赛活动</a>
                </ul>
            </div>
        </li>
        <li><a href=""><span class="glyphicon glyphicon-inbox"></span>校园文章</a>
            <div>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('article.index', ['type' => '1']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>爱情文章</a>
                    <li><a href="{{ route('article.index', ['type' => '2']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>亲情文章</a>
                    <li><a href="{{ route('article.index', ['type' => '3']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>友情文章</a>
                    <li><a href="{{ route('article.index', ['type' => '4']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>生活随笔</a>
                </ul>
            </div>
        </li>
        <li><a href=""><span class="glyphicon glyphicon-globe"></span>校园通知</a>
            <div>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('notice.index', ['type' => '1']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>俩办通知</a>
                    <li><a href="{{ route('notice.index', ['type' => '2']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>其他通知</a>
                    <li><a href="{{ route('notice.index', ['type' => '3']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>本科教学</a>
                    <li><a href="{{ route('notice.index', ['type' => '4']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>研究生教学</a>
                    <li><a href="{{ route('notice.index', ['type' => '5']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>科技信息</a>
                    <li><a href="{{ route('notice.index', ['type' => '6']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>社科信息</a>
                </ul>
            </div>
        </li>
        <li><a href="{{ route('goods.index') }}"><span class="glyphicon glyphicon-user"></span>校园二手交易</a>

        </li>
        <li><a href=""><span class="glyphicon glyphicon-tags"></span>校园学习</a>
            <div>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('jisuanji.index') }}"><span class="glyphicon glyphicon-erase"></span>计算机等级考试查询</a>
                </ul>
            </div>
        </li>
        <li><a href=""><span class="glyphicon glyphicon-tags"></span>新闻</a>
            <div style="height: 439px">
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'top']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>头条新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'shehui']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>社会新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'guonei']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>国内新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'guoji']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>国际新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'yule']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>娱乐新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'tiyu']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>体育新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'junshi']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>军事新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'keji']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>科技新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'caijing']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>财经新闻</a>
                </ul>
                <ul class="nav hidden-xs-nav">
                    <li><a href="{{ route('news.index' ,['type' => 'shishang']) }}"><span
                                    class="glyphicon glyphicon-erase"></span>时尚新闻</a>
                </ul>
            </div>
        </li>
    </ul>
    <div class="feeds"><a class="feed feed-xlweibo" href="http://blog.guoq.xin/" target="_blank"><i></i>博客</a> <a
                class="feed feed-txweibo" href="http://weibo.com/u/3912137536" target="_blank"><i></i>新浪微博</a> <a class="feed feed-rss"
                                                                                               href="http://www.jianshu.com/u/08986e4feb77"
                                                                                               target="_blank"><i></i>简书</a>
        <a class="feed feed-weixin" data-toggle="popover" data-trigger="hover" data-html="true"
           data-content="<img src='{{ asset('home/images/wx.png') }}' alt=''>" href="javascript:;" target="_blank"><i></i>关注微信</a>
    </div>
    {{--<div class="wall"><a href="readerWall.html" target="_blank">读者墙</a> | <a href="tags.html"--}}
                                                                             {{--target="_blank">标签云</a></div>--}}
</div>
<!--/超小屏幕不显示-->
<div class="visible-xs header-xs"><!--超小屏幕可见-->


    <div class="navbar-header header-xs-logo">
        @if(!empty(session('user')))
            <div style="float: left;margin-left: 26px;">
                <div class="top-left">
                    <a href="{{ url('/user/'.session('user')->guid) }}"><img id="topAvatar" class="img-circle"
                                                                             style="width: 15%;margin-bottom: -12%;"
                                                                             src="{{ session('user')->headpic }}"
                                                                             data-id="{{ session('user')->guid }}"></a>
                    <br>
                    <a class="{{ url('/user/'.session('user')->guid) }}" href="" style="margin-left: 0%">
                        <font size="2" color="#f0f8ff"
                              style="font-size: 10px;margin-left: -5px;">{{ session('user')->username }}</font>
                    </a>
                </div>
                <div style="float: right;margin-right: 49%;margin-top: -22%;">
                    {{--<a class="pad-l12-xs" href="{{ url('/logout') }}"><font size="2" color="#f0f8ff">退出</font></a>--}}
                </div>
            </div>
        @else
            <div class="top-right" style="margin-left: 2%;margin-bottom: -9%;">

                <a class="pad-l12-xs" href="{{ url('/login') }}">
                    <font size="2" color="#f0f8ff">登陆</font>
                </a>
                |
                <a class="pad-l12-xs" href="{{ url('/register') }}"><font size="2" color="#f0f8ff">注册</font></a>
            </div>
        @endif
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-xs-menu"
                aria-expanded="false" aria-controls="navbar">
            <span class="glyphicon glyphicon-menu-hamburger" style="margin-top: 14px;"></span>
        </button>
    </div>
    <div id="header-xs-menu" class="navbar-collapse collapse">
        <ul class="nav navbar-nav header-xs-nav nav-box">
            <li class="active"><a href="{{url('/')}}"><span class="glyphicon glyphicon-home"></span>网站首页</a></li>
            <li><a href="{{ url('action?type=1') }}"><span class="glyphicon glyphicon-erase"></span>校园活动</a></li>
            <li><a href="{{ route('article.index', ['type' => '1']) }}"><span class="glyphicon glyphicon-inbox"></span>校园文章</a>
            </li>
            <li><a href="{{ route('notice.index', ['type' => '1']) }}"><span class="glyphicon glyphicon-globe"></span>校园通知</a>
            </li>
            <li><a href="{{ route('goods.index') }}"><span class="glyphicon glyphicon-user"></span>校园二手交易</a></li>
            <li><a href="{{ route('study.index') }}"><span class="glyphicon glyphicon-tags"></span>校园学习</a></li>
            <li><a href="{{ route('news.index' ,['type' => 'top']) }}"><span class="glyphicon glyphicon-tags"></span>社会新闻</a>
            </li>
        </ul>
        <form class="navbar-form" action="search.php" method="post" style="padding:0 25px;">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="请输入关键字">
                <span class="input-group-btn">
            <button class="btn btn-default btn-search" type="submit">搜索</button>
            </span></div>
        </form>
    </div>
</div>
