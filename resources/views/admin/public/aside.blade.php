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

            <li>
                <a href="{{url('user')}}"><i class="zmdi zmdi-view-list"></i> <span class="nav-label">用户管理</span></a>
            </li>

            <li class="has-submenu">
                <a href="{{url('project_approval')}}"><i class="fa fa-dollar"></i> <span class="nav-label">众筹管理</span><span class="menu-arrow"></span></a>
            </li>

            <li class="has-submenu"><a href="{{asset('/action')}}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">活动管理</span><span class="menu-arrow"></span></a>
            </li>

            <li class="has-submenu"><a href="{{asset('/article')}}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">内容管理</span><span class="menu-arrow"></span></a>
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

            <li class="has-submenu"><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">网站管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/web_admins') }}">联系方式及备案管理</a></li>
                    {{--<li><a href="{{ url('/web_qrcode_organiz') }}">二维码管理</a></li>--}}
                    <li><a href="{{url('/web_admins_seo')}}">SEO优化</a></li>
                    <li><a href="{{url('/web_Cooper_organiz')}}">合作机构管理</a></li>
                    <li><a href="{{url('/web_invest_organiz')}}">投资机构管理</a></li>
                    <li><a href="{{url('/picture/carousel')}}">轮播图管理</a></li>

                </ul>
            </li>

        </ul>
    </nav>

</aside>
<!-- Aside Ends-->

