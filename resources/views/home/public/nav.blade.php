<nav class="container-fluid navbar navbar-default nav-fixd naves" role="navigation">
    <div class="container pad-clr">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#qili-navbar-collapse">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse pad-clr nav-opening" id="qili-navbar-collapse">
            <ul class="nav-content pad-cl">
                <li data-status="index" class=""><a href="{{ route('index') }}">奇力首页</a></li>
                <li class="hidden-xs"><div></div></li>
                <li data-status="project" class=""><a href="{{ route('project.index') }}">创新作品</a></li>
                <li class="hidden-xs"></li>
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">项目投资<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu qili-dropdown" role="menu">--}}
                        {{--<li class=""><a href="{{ route('action.index', ['type' => '1']) }}">企业管理</a></li>--}}
                        {{--<li class=""><a href="{{ route('action.index', ['type' => '2']) }}">资金管理</a></li>--}}
                        {{--<li class=""><a href="{{ route('action.index', ['type' => '2']) }}">人才管理</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="hidden-xs"></li>--}}
                <li data-status="school" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">英雄学院<span class="caret"></span></a>
                    <ul class="dropdown-menu qili-dropdown" role="menu">
                        <li class=""><a href="{{ route('school.index', ['type' => '1']) }}">企业管理</a></li>
                        <li class=""><a href="{{ route('school.index', ['type' => '2']) }}">资金管理</a></li>
                        <li class=""><a href="{{ route('school.index', ['type' => '3']) }}">人才管理</a></li>
                    </ul>
                </li>
                <li class="hidden-xs"></li>
                {{--<li class="nav-status"><a href="/article?type=1">市场资讯</a></li>--}}
                <li data-status="article1" class=""><a href="{{ route('article.index', ['type' => '1']) }}">市场资讯</a></li>
                <li class="hidden-xs"></li>
                {{--<li class="nav-status"><a href="/article?type=2">创业政策</a></li>--}}
                <li data-status="article2" class=""><a href="{{ route('article.index', ['type' => '2']) }}">创业政策</a></li>
                <li class="hidden-xs"></li>
                <li data-status="action" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">路演活动<span class="caret"></span></a>
                    <ul class="dropdown-menu qili-dropdown" role="menu">
                        <li class="nav-child-status"><a href="{{ route('action.index', ['type' => '1']) }}">路演活动</a></li>
                        <li class="nav-child-status"><a href="{{ route('action.index', ['type' => '2']) }}">创业大赛</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>