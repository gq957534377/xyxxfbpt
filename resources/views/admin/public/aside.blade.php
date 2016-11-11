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
            <li class="active"><a href="{{url('index')}}"><i class="zmdi zmdi-view-dashboard"></i> <span class="nav-label">控制台</span></a></li>

            <li class="has-submenu">
                <a href="#"><i class="zmdi zmdi-view-list"></i> <span class="nav-label">用户管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('users')}}">普通用户<span class="badge badge-info pull-right">50</span></a></li>
                    <li><a href="{{url('users')}}">待审核用户<span class="badge badge-danger pull-right">50</span></a></li>
                    <li><a href="{{url('users')}}">创业者用户<span class="badge badge-info pull-right">50</span></a></li>
                    <li><a href="#">数据备份还原</a></li>
                    <li><a href="#">Excel导入/导出</a></li>
                </ul>
            </li>

            <li class="has-submenu">
                <a href="#"><i class="fa fa-dollar"></i> <span class="nav-label">众筹模块</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('crowd_funding')}}" target="">首页</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-collection-text"></i> <span class="nav-label">路演管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('roald/create')}}">发布路演</a></li>
                    <li><a href="{{url('roald')}}">路演管理</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-chart"></i> <span class="nav-label">创业大赛</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="http://admin.hero.com/match">发布信息</a></li>
                    <li><a href="#">参赛者管理</a></li>
                    <li><a href="#">修改信息</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">创业技术培训</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('training')}}">列表页</a></li>
                </ul>
            </li>
        </ul>
    </nav>

</aside>
<!-- Aside Ends-->