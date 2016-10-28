<!-- Aside Start-->
<aside class="left-panel">

    <!-- brand -->
    <div class="logo">
        <a href="index.html" class="logo-expanded">
            <i class="ion-social-buffer"></i>
            <span class="nav-label">JIANGU</span>
        </a>
    </div>
    <!-- / brand -->

    <!-- Navbar Start -->
    <nav class="navigation">
        <ul class="list-unstyled">
            <li class="active"><a href="{{url('index')}}"><i class="zmdi zmdi-view-dashboard"></i> <span class="nav-label">首页</span></a></li>
            <li class="has-submenu">
                <a href="#"><i class="zmdi zmdi-format-underlined"></i> <span class="nav-label">用户界面</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('typography')}}">版式</a></li>
                    <li><a href="{{url('buttons')}}">按钮</a></li>
                    <li><a href="{{url('icons')}}">图标</a></li>
                    <li><a href="{{url('panels')}}">面板</a></li>
                    <li><a href="{{url('tabs')}}">选项卡</a></li>
                    <li><a href="{{url('modals')}}">弹窗</a></li>
                    <li><a href="{{url('elements')}}">按钮元素</a></li>
                    <li><a href="{{url('progressBars')}}">进度条</a></li>
                    <li><a href="{{url('notifications')}}">提示弹窗</a></li>
                    <li><a href="{{url('alert')}}">弹窗</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-album"></i> <span class="nav-label">组件</span><span class="badge bg-warning">New</span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('grid')}}">网格</a></li>
                    <li><a href="{{url('portlets')}}">门户组件</a></li>
                    <li><a href="{{url('widgets')}}">窗口小部件</a></li>
                    <li><a href="{{url('nestable')}}">可折叠列表</a></li>
                    <li><a href="{{url('calendar')}}">日历</a></li>
                    <li><a href="{{url('rangSlider')}}">范围滑块</a></li>
                </ul>
            </li>
            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-collection-text"></i> <span class="nav-label">表单</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('formElements')}}">常用表单</a></li>
                    <li><a href="{{url('validation')}}">表单验证</a></li>
                    <li><a href="{{url('advanced')}}">表单组件</a></li>
                    <li><a href="{{url('wizard')}}">向导表单</a></li>
                    <li><a href="{{url('editor')}}">所见即所得编辑器</a></li>
                    <li><a href="{{url('code')}}">代码编辑器</a></li>
                    <li><a href="{{url('upload')}}">文件上传</a></li>
                    <li><a href="{{url('crop')}}">图片裁切</a></li>
                    <li><a href="{{url('editable')}}">X-编辑</a></li>
                </ul>
            </li>
            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-format-list-bulleted"></i> <span class="nav-label">表格</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('basic')}}">基础表格</a></li>
                    <li><a href="{{url('tabledit')}}">可编辑表格</a></li>
                    <li><a href="{{url('responsive')}}">响应式表格</a></li>
                </ul>
            </li>
            <!--<li class="has-submenu"><a href="#"><i class="zmdi zmdi-chart"></i> <span class="nav-label">Charts</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('morris')}}">Morris图</a></li>
                        <li><a href="{{url('chartjs')}}">Chartjs图</a></li>
                    <li><a href="{{url('flot')}}">柱状图</a></li>
                    <li><a href="{{url('rickshaw')}}">波浪图</a></li>
                    <li><a href="{{url('peity')}}">Peity图</a></li>
                    <li><a href="{{url('c3')}}">C3图</a></li>
                    <li><a href="{{url('other')}}">其它图</a></li>
                </ul>
            </li>-->

            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-email"></i> <span class="nav-label">邮箱</span><span class="badge bg-success">7</span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('inbox')}}">收件箱</a></li>
                    <li><a href="{{url('compose')}}">写信</a></li>
                    <li><a href="{{url('read')}}">查看邮件</a></li>
                    <li><a href="{{url('templates')}}">邮件模板</a></li>
                </ul>
            </li>

            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-map"></i> <span class="nav-label">地图</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('googlemap')}}"> Google地图</a></li>
                    <li><a href="{{url('vectormap')}}"> Vector地图</a></li>
                </ul>
            </li>
            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-collection-item"></i> <span class="nav-label">页面</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('profile')}}">人物简介</a></li>
                    <li><a href="{{url('timeline')}}">时间轴</a></li>
                    <li><a href="{{url('invoice')}}">清单</a></li>
                    <li><a href="{{url('contact')}}">内容列表</a></li>
                    <li><a href="{{url('login')}}">登陆</a></li>
                    <li><a href="{{url('register')}}">注册</a></li>
                    <li><a href="{{url('recoverpw')}}">重置密码</a></li>
                    <li><a href="{{url('lock')}}">锁屏</a></li>
                    <li><a href="{{url('blank')}}">空白页</a></li>
                    <li><a href="{{url('404')}}">404错误</a></li>
                    <li><a href="{{url('404_alt')}}">页面404错误</a></li>
                    <li><a href="{{url('500')}}">500错误</a></li>
                </ul>
            </li>
        </ul>
    </nav>

</aside>
<!-- Aside Ends-->