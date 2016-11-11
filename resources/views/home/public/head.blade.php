<header id="header">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-4">
                    <div class="top-number"><p><i class="fa fa-phone-square"></i>  +0123 456 70 90</p></div>
                </div>
                <div class="col-sm-6 col-xs-8">
                    <div class="social">
                        <ul class="social-share">
                            <li><a href="{{url('/login')}}">登录</a></li>
                            <li><a href="{{url('/register')}}">注册</a></li>
                            <!--<li><a href="#"><i class="fa fa-linkedin"></i></a></li> -->
                            <!--<li><a href="#"><i class="fa fa-dribbble"></i></a></li>-->
                            <!--<li><a href="#"><i class="fa fa-skype"></i></a></li>-->
                        </ul>
                        <div class="search">
                            <form role="form">
                                <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                <i class="fa fa-search"></i>
                            </form>
                        </div>
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
                <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="logo"></a>
            </div>

            <div class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.html">Home</a></li>
                    <li><a href="{{url('crowd_funding')}}">英雄众筹</a></li>
                    <li class="dropdown"><a href="{{url('/roald')}}">路演活动<i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/roald/create')}}">最新路演</a></li>
                            <li><a href="{{url('/roald/id')}}">我的路演</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">创业大赛 <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">大赛介绍</a></li>
                            <li><a href="#">大赛服务</a></li>
                            <li><a href="#">组织结构</a></li>
                            <li><a href="#">报名方式</a></li>
                            <li><a href="#">入围项目</a></li>
                            <li><a href="#">创客故事</a></li>
                        </ul>
                    </li>
                    <li><a href="{{url('/training')}}">创业技术培训</a></li>
                    <li><a href="contact-us.html">Contact</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="contact-us.html">Contact</a></li>
                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->
</header><!--/header-->