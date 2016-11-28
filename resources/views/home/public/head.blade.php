<header id="header">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-4">
                    <div class="top-number"><p><i class="fa fa-phone-square"></i>  +0123 456 70 90</p></div>
                </div>
                <div class="col-sm-6 col-xs-8" style="margin: 0;padding: 0;">
                            @if(!empty(session('user')))
                                <!-- Right navbar -->
                                    <ul class="nav navbar-nav navbar-right top-right-menu" style="margin: 0;padding: 0;">
                                        <!-- user login dropdown start-->
                                        <li class="dropdown text-center" style="margin: 0;padding: 0;">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                                <img id="head_pic" src="{{session('user')->headpic}}" class="img-circle profile-img thumb-sm">
                                                <span class="username">{{session('user')->email}} </span> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;margin: 0;padding: 0;">
                                                <li><a href="{{url('/user')}}"><i class="fa fa-briefcase"></i>个人中心 <input type="hidden" id="userinfo" value="{{session('user')->guid}}"/></a></li>
                                                <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out"></i>登出</a></li>
                                            </ul>
                                        </li>
                                        <!-- user login dropdown end -->
                                    </ul>
                                    <!-- End right navbar -->
                            @else
                                    <ul id="userBox" class="social-share pull-right">
                                        <li><a href="{{url('/login')}}" id="login">登录</a><input type="hidden" name="guid"></li>
                                        <li><a href="{{url('/register')}}" id="register">注册</a></li>
                                    </ul>

                            @endif
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </div><!--/.top-bar-->

    <nav class="navbar navbar-inverse" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img src="{{asset('home/images/logo.png')}}" alt="logo"></a>
            </div>

            <div class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li><a href="{{url('crowd_funding')}}">英雄众筹</a></li>
                    <li class="dropdown"><a href="{{url('/action?type=1')}}">路演活动<i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/action?type=1')}}">最新路演</a></li>
                            <li><a href="{{url('/road/id')}}">我的路演</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="{{url('/action?type=2')}}">创业大赛<i class="fa fa-angle-down"></i></a>
                    </li>
                    <li><a href="{{url('/action?type=3')}}">创业技术培训</a></li>
                    <li><a href="{{url('/project')}}">创业项目</a></li>
                    <li><a href="{{url('/article?type=1')}}">市场</a></li>
                    <li><a href="{{url('/article?type=2')}}">政策</a></li>
                    <li><a href="{{url('/article?type=3')}}">用户投稿</a></li>
                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->
</header><!--/header-->