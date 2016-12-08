<div class=" container-fluid" style="margin-top: 79.6px;">
    <div class="row">
        <nav id="NavigationBar" class="font-size">
            <!-- Menu Start -->
            <ul>
                <li><a href="{{ url('/') }}">奇力首页</a></li>
                <li><a href="{{ url('/project') }}">创新作品</a></li>
                <li><a href="#">项目投资</a></li>
                <li><a href="#">英雄学院</a></li>
                <li><a href="#">市场咨询</a></li>
                <li><a href="#">创业政策</a></li>
                <li><a href="#">路演活动</a></li>
            </ul>
            <!-- Menu End -->
            <!-- 轮播图 Start -->
            <div id="carousel-example-generic" class="carousel slide animated rotateInUpLeft" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="{{ asset('home/img/demoimg/index_nav_img.jpg') }}" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('home/img/demoimg/banner.png') }}" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('home/img/demoimg/index_nav_img.jpg') }}" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('home/img/demoimg/banner.png') }}" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- 轮播图 End -->
            <!-- 底部 Menu Start -->
            <ul>
                <li><a href="#">项目投资</a></li>
                <li><a href="#">找投资人</a></li>
            </ul>
            <!-- 底部 Menu End -->
        </nav>
    </div>
</div>