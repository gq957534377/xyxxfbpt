<!-- Aside Start-->
<aside class="left-panel">

    <!-- brand -->
    <div class="logo">
        <a href="index.html" class="logo-expanded">
            <i class="ion-social-buffer"></i>
            <span class="nav-label">Hero Meeting</span>
        </a>
    </div>
    <!-- / brand -->

    <!-- Navbar Start -->
    <nav class="navigation">
        <ul class="list-unstyled">
            <li class="active"><a href="{{url('/')}}"><i class="zmdi zmdi-view-dashboard"></i> <span class="nav-label">控制台</span></a></li>

            <li class="has-submenu">
                <a href="#"><i class="zmdi zmdi-view-list"></i> <span class="nav-label">用户管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a id="aside_normal" href="{{url('user?role=1')}}">普通用户</a></li>
                    <li><a id="aside_entrepreneurs" href="{{url('user?role=2')}}">创业者用户</a></li>
                    <li><a id="aside_investor" href="{{url('user?role=3')}}">投资者用户</a></li>
                    <li><a id="aside_check_entrepreneurs" href="{{url('user_role')}}">创业者待审核用户</a></li>
                    <li><a id="aside_check_investor" href="{{url('user_role')}}">投资者待审核用户</a></li>
                </ul>
            </li>

            <li class="has-submenu">
                <a href="{{url('project_approval')}}"><i class="fa fa-dollar"></i> <span class="nav-label">众筹管理</span><span class="menu-arrow"></span></a>
            </li>

            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-collection-text"></i> <span class="nav-label">路演管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('road/create')}}">发布路演</a></li>
                    <li><a href="{{url('road')}}">路演管理</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-chart"></i> <span class="nav-label">创业大赛</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{asset('/match')}}">发布信息</a></li>
                    <li><a href="#">参赛者管理</a></li>
                    <li><a href="#">修改信息</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">创业技术培训</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('training')}}">列表页</a></li>
                </ul>
            </li>

            {{--项目发布--}}
            <li class="has-submenu"><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">项目发布管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('project/unchecked')}}">待审核项目管理</a></li>
                    <li><a href="{{url('project/pass')}}">已通过项目管理</a></li>
                    <li><a href="{{url('project/nopass')}}">未通过项目管理</a></li>
                </ul>
            </li>
        </ul>
    </nav>

</aside>
<!-- Aside Ends-->

