<div class="nav-fixd">
    <nav class="container-fluid naves">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ route('index') }}">奇力首页</a></li>
                <li><a href="{{ route('project.index') }}">创新作品</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">项目投资<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">项目投资</a></li>
                        <li><a href="#">众筹项目</a></li>
                    </ul>
                </li>
                <li><a href="#">英雄学院</a></li>
                <li><a href="#">市场咨询</a></li>
                <li><a href="#">创业政策</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">路演活动<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('action.index', ['type' => '1']) }}">路演活动</a></li>
                        <li><a href="{{ route('action.index', ['type' => '2']) }}">创业大赛</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>