<div class="hidden-xs header"><!--超小屏幕不显示-->
    <h1 class="logo"><a href="{{url('/')}}/" title="校园信息发布平台"></a></h1>
    @if(!empty(session('user')))
        <div class="top-right">
            <a href=""><img id="topAvatar" class="img-circle" style="width: 106%"
                            src="{{asset('home/images/ea5acc07864b.jpg')}}" data-id=""></a>
            <a class="hidden-xs" href="" style="margin-left: 24%">
                <mark id="nicknameBox">庆欧巴~</mark>
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
    <ul class="nav hidden-xs-nav">
        <li class="active"><a href="{{url('/')}}"><span class="glyphicon glyphicon-home"></span>网站首页</a></li>
        <li><a href="{{ url('/action?type=1') }}"><span class="glyphicon glyphicon-erase"></span>校园活动</a></li>
        <li><a href="index.html"><span class="glyphicon glyphicon-inbox"></span>校园文章</a></li>
        <li><a href="index.html"><span class="glyphicon glyphicon-globe"></span>校园通知</a></li>
        <li><a href="about.html"><span class="glyphicon glyphicon-user"></span>校园二手交易</a></li>
        <li><a href="friendly.html"><span class="glyphicon glyphicon-tags"></span>校园学习</a></li>
        <li><a href="friendly.html"><span class="glyphicon glyphicon-tags"></span>社会新闻</a></li>
    </ul>
    <div class="feeds"><a class="feed feed-xlweibo" href="index.html" target="_blank"><i></i>新浪微博</a> <a
                class="feed feed-txweibo" href="index.html" target="_blank"><i></i>腾讯微博</a> <a class="feed feed-rss"
                                                                                               href="index.html"
                                                                                               target="_blank"><i></i>订阅本站</a>
        <a class="feed feed-weixin" data-toggle="popover" data-trigger="hover" title="微信扫一扫" data-html="true"
           data-content="<img src='images/weixin.jpg' alt=''>" href="javascript:;" target="_blank"><i></i>关注微信</a>
    </div>
    <div class="wall"><a href="readerWall.html" target="_blank">读者墙</a> | <a href="tags.html"
                                                                             target="_blank">标签云</a></div>
</div>
<!--/超小屏幕不显示-->
<div class="visible-xs header-xs"><!--超小屏幕可见-->


    <div class="navbar-header header-xs-logo">
        @if(!empty(session('user')))
            <div style="float: left">
                <div class="top-left">
                    <a href=""><img id="topAvatar" class="img-circle" style="width: 11%;margin-bottom: -12%;"
                                    src="{{ session('user')->headpic }}" data-id=""></a>
                    <br>
                    <a class="" href="" style="margin-left: 0%">
                        <font size="2" color="#f0f8ff">{{ session('user')->username }}</font>
                    </a>
                </div>
                <div style="float: right;margin-right: 49%;margin-top: -22%;">
                    <a class="pad-l12-xs" href="{{ url('/logout') }}"><font size="2" color="#f0f8ff">退出</font></a>
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
            <span class="glyphicon glyphicon-menu-hamburger"></span>
        </button>
    </div>
    <div id="header-xs-menu" class="navbar-collapse collapse">
        <ul class="nav navbar-nav header-xs-nav">
            <li class="active"><a href="{{url('/')}}"><span class="glyphicon glyphicon-home"></span>网站首页</a></li>
            <li><a href="{{ url('action?type=1') }}"><span class="glyphicon glyphicon-erase"></span>校园活动</a></li>
            <li><a href="index.html"><span class="glyphicon glyphicon-inbox"></span>校园文章</a></li>
            <li><a href="index.html"><span class="glyphicon glyphicon-globe"></span>校园通知</a></li>
            <li><a href="about.html"><span class="glyphicon glyphicon-user"></span>校园二手交易</a></li>
            <li><a href="friendly.html"><span class="glyphicon glyphicon-tags"></span>校园学习</a></li>
            <li><a href="friendly.html"><span class="glyphicon glyphicon-tags"></span>社会新闻</a></li>
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
