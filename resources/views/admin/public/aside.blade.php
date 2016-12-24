<!-- Aside Start-->
<aside class="left-panel">

    <!-- brand -->
    <div class="logo">
        <a href="{{ url('/') }}" class="logo-expanded">
            <i class="ion-social-buffer"></i>
            <span class="nav-label">英雄会后台管理系统</span>
        </a>
    </div>
    <!-- / brand -->

    <!-- Navbar Start -->
    <nav class="navigation">
        <ul class="list-unstyled">
            {{--<li class="active"><a href="{{url('/')}}"><i class="zmdi zmdi-view-dashboard"></i> <span class="nav-label">控制台</span></a></li>--}}

            <li>
                <a href="{{url('user')}}"><i class="zmdi zmdi-view-list"></i> <span class="nav-label">用户管理</span></a>
            </li>

            {{--<li class="has-submenu">--}}
                {{--<a href="{{url('project_approval')}}"><i class="fa fa-dollar"></i> <span class="nav-label">众筹管理</span></a>--}}
            {{--</li>--}}

            <li class="has-submenu"><a href=""><i class="fa fa-bullhorn" aria-hidden="true"></i> <span class="nav-label">活动管理</span></a>
                <ul class="list-unstyled">
                    <li><a href="{{asset('action?type=1')}}">路演活动管理</a></li>
                    <li><a href="{{asset('action?type=2')}}">创业大赛管理</a></li>
                    <li><a href="{{asset('action?type=3')}}">英雄学院管理</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="{{asset('/article')}}"><i class="ion-android-book" aria-hidden="true"></i> <span class="nav-label">内容管理</span></a>
            </li>
            {{--项目发布--}}
            <li class="has-submenu"><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">项目发布管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('project/unchecked')}}">待审核项目管理</a></li>
                    <li><a href="{{url('project/pass')}}">已通过项目管理</a></li>
                    <li><a href="{{url('project/nopass')}}">未通过项目管理</a></li>
                </ul>
            </li>
            {{--网站管理--}}
            <li class="has-submenu">
                <a href="{{ url('/web_admins?type=1') }}"><i class="fa fa-dollar"></i> <span class="nav-label">网站管理</span></a>
            </li>

            <li class="has-submenu"><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">用户管理beta</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('/user_management')}}">用户常规管理</a></li>
                    <li><a href="{{url('/role_management')}}">用户审核管理</a></li>
                </ul>
            </li>


        </ul>
    </nav>

</aside>
<!-- Aside Ends-->

