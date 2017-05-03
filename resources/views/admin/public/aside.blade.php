<!-- Aside Start-->
<aside class="left-panel">

    <!-- brand -->
    <div class="logo">
        <a href="{{ url('/') }}" class="logo-expanded">
            <i class="ion-social-buffer"></i>
            <span class="nav-label">校园信息发布平台</span>
        </a>
    </div>
    <!-- / brand -->

    <!-- Navbar Start -->
    <nav class="navigation">
        <ul class="list-unstyled">
            <li class="has-submenu"><a href=""><i class="fa fa-bullhorn" aria-hidden="true"></i> <span class="nav-label">活动管理</span></a>
                <ul class="list-unstyled">
                    <li><a href="{{asset('action?type=1')}}">文娱活动管理</a></li>
                    <li><a href="{{asset('action?type=2')}}">学术活动管理</a></li>
                    <li><a href="{{asset('action?type=3')}}">竞赛活动管理</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="{{url('/article')}}"><i class="ion-android-book" aria-hidden="true"></i> <span class="nav-label">校园文章管理</span></a>
            </li>
            {{--校园文章管理--}}
            <li class="has-submenu"><a href="{{ url('notice') }}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">校园通知管理</span><span class="menu-arrow"></span></a>
            </li>
            {{--网站管理--}}
            <li class="has-submenu"><a href="{{ url('/web_admins?type=1') }}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">网站管理</span><span class="menu-arrow"></span></a>
            </li>
            {{--<li class="has-submenu">--}}
                {{--<a href="{{ url('/web_admins?type=1') }}"><i class="fa fa-dollar"></i> <span class="nav-label">网站管理</span></a>--}}
            {{--</li>--}}

            <li class="has-submenu"><a href="{{url('/user_management')}}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">用户管理</span><span class="menu-arrow"></span></a>
            </li>


        </ul>
    </nav>

</aside>
<!-- Aside Ends-->

