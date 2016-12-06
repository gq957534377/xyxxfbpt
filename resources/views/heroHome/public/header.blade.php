<header class="container-fluid navbar-fixed-top">
    <div class="container">
        <div class="row change-row-margin">
            <div class="top-left">
                <a href="{{ url('/') }}"><img class="img-responsive" src="{{ asset('heroHome/img/logo.jpg') }}"></a>
            </div>
            @if(!empty(session('user')))
                <div class="top-right">
                    <ul class="navbar-right">
                        <li id="fat-menu" class="dropdown">
                            <a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img id="topAvatar" class="img-circle" src="{{ session('user')->headpic }}" alt="头像" title="{{ session('user')->nickname }}" data-id="{{ session('user')->guid }}">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/user') }}"><i class="fa fa-briefcase"></i> 个人中心</a></li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/logout') }}"><i class="fa fa-sign-in"></i> 退出登录</a></li>
                            </ul>
                        </li>
                    </ul>
                    <a href="#">消息</a>
                    <a href="#">英雄社区</a>

                </div>
            @else
                <div class="top-right">
                    <a href="{{ url('/login') }}"><img class="img-circle" src="{{ asset('heroHome/img/icon_empty.png') }}"></a>
                    <a href="{{ url('/login') }}">未登录</a>
                    <a href="#">英雄社区</a>
                </div>
            @endif
        </div>
    </div>
</header>
