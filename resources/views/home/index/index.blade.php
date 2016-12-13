@extends('home.layouts.master')

@section('style')
    <link href="{{ asset('home/css/index(pc).css') }}" rel="stylesheet">
@endsection

@section('menu')
    @parent
@endsection

@section('content')
    <div class=" container-fluid" >
        <div class="row">
            <nav id="NavigationBar" class="font-size">
                <div id="carousel-example-generic" class="carousel slide animated rotateInUpLeft" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach($cooper as $key => $val)
                            @if($key == 0)
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            @else
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            @endif
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">


                        @foreach($cooper as $key => $val)
                            @if($key == 0)
                                <div class="item active">
                                    <img src="{{ $val->url }}" alt="...">
                                    <div class="carousel-caption">
                                    </div>
                                </div>
                            @else
                                <div class="item">
                                    <img src="{{ $val->url }}" alt="...">
                                    <div class="carousel-caption">
                                    </div>
                                </div>
                            @endif
                        @endforeach


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
                <ul>
                    <li><a href="#">项目投资</a></li>
                    <li><a href="#">找投资人</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- 精选项目 Start -->
    <div class=" container-fluid" style="background-color: #F7F7F7;">
        <div id="section1">
            <div class="container" style="max-width: 1200px;width:100%;">
                <div style="max-width: 1200px;width:100%; margin:0 auto;" class=" row">
                    <div class="col-sm-7 col-xs-3" style="padding-left:0;">
                        <h2 class="jx-tit">精选项目</h2>
                    </div>
                    <div class="col-sm-5 col-xs-9 jxxm" style="padding-right:0;">
                        <li><a class="ckgd" href="#">查看更多</a></li>
                        <li><a class="wysjx" href="#">我要上精选！</a></li>
                    </div>
                </div>
                <ul class="row">
                    @if(isset($projects))
                        @foreach ($projects as $project)
                            <li class="col-sm-4">
                                <a class="new_a" href="{{ route('project.show', $project->project_id) }}">
                                    <img src="{{ $project->image }}">
                                    <div class="companyName">{{ $project->title }}</div>
                                    <div class="classLabel">
                                <span>
                                    @if($project->project_type == 1)
                                        热门推荐
                                    @elseif($project->project_type == 2)
                                        新品上架
                                    @elseif($project->project_type == 3)
                                        未来科技
                                    @elseif($project->project_type == 4)
                                        健康出行
                                    @elseif($project->project_type == 5)
                                        生活美学
                                    @elseif($project->project_type == 6)
                                        美食生活
                                    @elseif($project->project_type == 7)
                                        流行文化
                                    @elseif($project->project_type == 8)
                                        爱心公益
                                    @endif
                                </span>
                                        <span>{{ $project->habitude }}</span>
                                    </div>
                                    <p class="new_p">
                                        {{ $project->content }}
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    @else
                        暂无数据
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- 精选项目 End -->

    <!-- 活动 Start -->
    <div class=" container-fluid">

        <!-- 英雄榜 Start -->
        <section id="section2" class="font-size">
            <div class="row">
                <h2>英雄榜</h2>
            </div>
            <ul>
                <li class="row">
                    <a href="#">
                        <div class="section2_img col-sm-3">
                            <img src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">
                            <img class="hidden-767" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">
                        </div>
                        <div class="section2_center col-sm-6">
                            <div class="section2_center_title">
                                <h3>小余老师说</h3>
                                <span>致力于让全国人更懂教育的互联网+教育公司</span>
                            </div>
                            <ul>
                                <li>
                                    <div>1天</div>
                                    <div class="section2_hover">成功天数</div>
                                </li>
                                <li>
                                    <div>￥650万</div>
                                    <div class="section2_hover">成功融资</div>
                                </li>
                                <li>
                                    <div>傅盛</div>
                                    <div class="section2_hover">领投人</div>
                                </li>
                            </ul>
                        </div>
                        <div class="hidden-767 section2_evaluate col-sm-3">
                            <p>
                                <span></span>
                                <span>跟投人评价：</span>
                                作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。
                            </p>
                        </div>
                    </a>
                </li>
                <li class="row">
                    <a href="#">
                        <div class="section2_img col-sm-3">
                            <img src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">
                            <img class="hidden-767" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">
                        </div>
                        <div class="section2_center col-sm-6">
                            <div class="section2_center_title">
                                <h3>小余老师说</h3>
                                <span>致力于让全国人更懂教育的互联网+教育公司</span>
                            </div>
                            <ul>
                                <li>
                                    <div>1天</div>
                                    <div class="section2_hover">成功天数</div>
                                </li>
                                <li>
                                    <div>￥650万</div>
                                    <div class="section2_hover">成功融资</div>
                                </li>
                                <li>
                                    <div>傅盛</div>
                                    <div class="section2_hover">领投人</div>
                                </li>
                            </ul>
                        </div>
                        <div class="hidden-767 section2_evaluate col-sm-3">
                            <p>
                                <span></span>
                                <span>跟投人评价：</span>
                                作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。
                            </p>
                        </div>
                    </a>
                </li>
                <li class="row">
                    <a href="#">
                        <div class="section2_img col-sm-3">
                            <img src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">
                            <img class="hidden-767" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">
                        </div>
                        <div class="section2_center col-sm-6">
                            <div class="section2_center_title">
                                <h3>小余老师说</h3>
                                <span>致力于让全国人更懂教育的互联网+教育公司</span>
                            </div>
                            <ul>
                                <li>
                                    <div>1天</div>
                                    <div class="section2_hover">成功天数</div>
                                </li>
                                <li>
                                    <div>￥650万</div>
                                    <div class="section2_hover">成功融资</div>
                                </li>
                                <li>
                                    <div>傅盛</div>
                                    <div class="section2_hover">领投人</div>
                                </li>
                            </ul>
                        </div>
                        <div class="hidden-767 section2_evaluate col-sm-3">
                            <p>
                                <span></span>
                                <span>跟投人评价：</span>
                                作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
        </section>
        <!-- 英雄榜 End -->

        <!-- 路演活动 Start -->
        <section id="section3" class="font-size">
            <div class="section_title">
                <h2>路演活动</h2>
                <a href="#">查看全部</a>
            </div>
            <div class="section_titles">
                <h2>路演活动</h2>
                <a href="#">查看全部</a>
            </div>
            <ul class="row">
                @foreach($roadShows as $roadShow)
                    <li class="col-sm-4">
                        <a href="#">
                            <img src="{{ $roadShow->banner }}"/>
                        </a>
                        <div class="ly">
                            <h3><a href="#">{{ $roadShow->title }}</a></h3>
                    <span>
                        @if($roadShow->status == 1)
                            报名中
                        @elseif($roadShow->status == 2)
                            进行中
                        @elseif($roadShow->status == 3)
                            已结束
                        @elseif($roadShow->status == 4)
                            已取消
                        @elseif($roadShow->status == 5)
                            报名截止
                        @endif
                    </span>
                        </div>
                <span>
    				<span>{{ $roadShow->address }}</span>
    				<span>{{ $roadShow->start_time }}</span>
    			</span>
                    </li>
                @endforeach
            </ul>
        </section>
        <!-- 路演活动 End -->

        <!-- 创业大赛 Start -->
        <section id="section3s" class="font-size">
            <div class="section_title">
                <h2>创业大赛</h2>
                <a href="#">查看全部</a>
            </div>
            <div class="section_titles">
                <h2>创业大赛</h2>
                <a href="#">查看全部</a>
            </div>
            <ul class="row">
                @foreach($sybs as $syb)
                    <li class="col-sm-4">
                        <a href="#">
                            <img src="{{ $syb->banner }}"/>
                        </a>
                        <div class="ly">
                            <h3><a href="#">{{ $syb->title }}</a></h3>
                    <span>
                        @if($syb->status == 1)
                            报名中
                        @elseif($syb->status == 2)
                            进行中
                        @elseif($syb->status == 3)
                            已结束
                        @elseif($syb->status == 4)
                            已取消
                        @elseif($syb->status == 5)
                            报名截止
                        @endif
                    </span>
                        </div>
                <span>
    				<span>{{ $syb->address }}</span>
    				<span>{{ $syb->start_time }}</span>
    			</span>
                    </li>
                @endforeach
            </ul>
        </section>
        <!-- 创业大赛 End -->

        <!-- 英雄学院 Start -->
        <section id="section4" class="font-size">
            <div class="section_title">
                <h2>英雄学院</h2>
                <a href="#">查看全部</a>
            </div>
            <div class="section_titles">
                <h2>英雄学院</h2>
                <a href="#">查看全部</a>
            </div>
            <ul class="row">
                @foreach($trains as $train)
                    <li class="col-sm-6">
                        <a href="#">
                            <span>第1期</span>
                            <img src="{{ $train->banner }}"/>
                            <div>
                                <h3>{{ $train->title }}</h3>
                        <span>
                            @if($train->status == 1)
                                报名中
                            @elseif($train->status == 2)
                                进行中
                            @elseif($train->status == 3)
                                已结束
                            @elseif($train->status == 4)
                                已取消
                            @elseif($train->status == 5)
                                报名截止
                            @endif
                        </span>
                            </div>
                            <p>{{ $train->brief }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
        <!-- 英雄学院 End -->
    </div>
    <!-- 活动 End -->

    <!-- 英雄众筹 Start-->
    <div class=" container-fluid" style="background-color: #F6F6F6;">
        <section id="section5" class="font-size">
            <div class="section_titles section_title">
                <h2>英雄众筹</h2>
            </div>
            <div id="section5_content">
                <!-- <h2>众筹</h2> -->
                <ul id="section5_content_middle">
                    <li class="active">最新上架</li>
                    <li>即将结束</li>
                    <a id="zcckgd_a" href="#">查看全部></a>
                </ul>
                <div id="section5_content_bottom">
                    <ul class="row">
                        <li class="col-sm-3">
                            <a href="#">
                                <div class="img_block">
                                    <img src="{{ asset('home/img/demoimg/test.jpg') }}">
                                    <div>
                                        <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                    </div>
                                </div>
                                <div class="js_loding">
                                    <h4>NOBADAY单板滑雪板</h4>
                                    <div class="js_loding_father">
                                        <div class="js_loding_son"></div>
                                    </div>
                                    <span>目标</span>
                                    <span>￥53000</span>
                                    <span class="zcy">￥7949</span>
                                    <span class="zcy">超值档位</span>
                                </div>
                            </a>
                        </li>
                        <li class="col-sm-3">
                            <a href="#">
                                <div class="img_block">
                                    <img src="{{ asset('home/img/demoimg/test.jpg') }}">
                                    <div>
                                        <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                    </div>
                                </div>
                                <div class="js_loding">
                                    <h4>NOBADAY单板滑雪板</h4>
                                    <div class="js_loding_father">
                                        <div class="js_loding_son"></div>
                                    </div>
                                    <span>目标</span>
                                    <span>￥53000</span>
                                    <span class="zcy">￥7949</span>
                                    <span class="zcy">超值档位</span>
                                </div>
                            </a>
                        </li>
                        <li class="col-sm-3">
                            <a href="#">
                                <div class="img_block">
                                    <img src="{{ asset('home/img/demoimg/test.jpg') }}">
                                    <div>
                                        <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                    </div>
                                </div>
                                <div class="js_loding">
                                    <h4>NOBADAY单板滑雪板</h4>
                                    <div class="js_loding_father">
                                        <div class="js_loding_son"></div>
                                    </div>
                                    <span>目标</span>
                                    <span>￥53000</span>
                                    <span class="zcy">￥7949</span>
                                    <span class="zcy">超值档位</span>
                                </div>
                            </a>
                        </li>
                        <li class="col-sm-3">
                            <a href="#">
                                <div class="img_block">
                                    <img src="{{ asset('home/img/demoimg/test.jpg') }}">
                                    <div>
                                        <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                    </div>
                                </div>
                                <div class="js_loding">
                                    <h4>NOBADAY单板滑雪板</h4>
                                    <div class="js_loding_father">
                                        <div class="js_loding_son"></div>
                                    </div>
                                    <span>目标</span>
                                    <span>￥53000</span>
                                    <span class="zcy">￥7949</span>
                                    <span class="zcy">超值档位</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <ul class="active row">
                        <li class="col-sm-3">
                            <a href="#">
                                <div class="img_block">
                                    <img src="{{ asset('home/img/demoimg/5837b19bN7c6a2b50.jpg') }}">
                                    <div>
                                        <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                    </div>
                                </div>
                                <div class="js_loding">
                                    <h4>NOBADAY单板滑雪板</h4>
                                    <div class="js_loding_father">
                                        <div class="js_loding_son"></div>
                                    </div>
                                    <span>目标</span>
                                    <span>￥53000</span>
                                    <span class="zcy">￥7949</span>
                                    <span class="zcy">超值档位</span>
                                </div>
                            </a>
                        </li>
                        <li class="col-sm-3">
                            <a href="#">
                                <div class="img_block">
                                    <img src="{{ asset('home/img/demoimg/5837b19bN7c6a2b50.jpg') }}">
                                    <div>
                                        <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                    </div>
                                </div>
                                <div class="js_loding">
                                    <h4>NOBADAY单板滑雪板</h4>
                                    <div class="js_loding_father">
                                        <div class="js_loding_son"></div>
                                    </div>
                                    <span>目标</span>
                                    <span>￥53000</span>
                                    <span class="zcy">￥7949</span>
                                    <span class="zcy">超值档位</span>
                                </div>
                            </a>
                        </li>
                        <li class="col-sm-3">
                            <a href="#">
                                <div class="img_block">
                                    <img src="{{ asset('home/img/demoimg/5837b19bN7c6a2b50.jpg') }}">
                                    <div>
                                        <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                    </div>
                                </div>
                                <div class="js_loding">
                                    <h4>NOBADAY单板滑雪板</h4>
                                    <div class="js_loding_father">
                                        <div class="js_loding_son"></div>
                                    </div>
                                    <span>目标</span>
                                    <span>￥53000</span>
                                    <span class="zcy">￥7949</span>
                                    <span class="zcy">超值档位</span>
                                </div>
                            </a>
                        </li>
                        <li class="col-sm-3">
                            <a href="#">
                                <div class="img_block">
                                    <img src="{{ asset('home/img/demoimg/5837b19bN7c6a2b50.jpg') }}">
                                    <div>
                                        <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                    </div>
                                </div>
                                <div class="js_loding">
                                    <h4>NOBADAY单板滑雪板</h4>
                                    <div class="js_loding_father">
                                        <div class="js_loding_son"></div>
                                    </div>
                                    <span>目标</span>
                                    <span>￥53000</span>
                                    <span class="zcy">￥7949</span>
                                    <span class="zcy">超值档位</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <!-- 英雄众筹 End-->

    <!-- 英雄社区 Start-->
    <div class=" container-fluid">
        <section id="section6" class="font-size">
            <ul class="section6_top">
                <li>
                    <h2>英雄社区</h2>
                </li>
            </ul>
            <div id="section6_bottom">
                <ul id="section6_left" class="row">
                    <li class="col-sm-6">
                        <div class="bg-mg">
                            <div class="bg-mg-f">
                                <img src="{{ asset('home/img/demoimg/Roadshow.jpg') }}"/>
                            </div>
                        </div>
                        <div>
                            <h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>
                            <p>Posted on 2016/11/11 10:44:05</p>
                            <p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>
                        </div>
                    </li>
                    <li class="col-sm-6">
                        <div class="bg-mg">
                            <div class="bg-mg-f">
                                <img src="{{ asset('home/img/demoimg/Roadshow.jpg') }}"/>
                            </div>
                        </div>
                        <div>
                            <h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>
                            <p>Posted on 2016/11/11 10:44:05</p>
                            <p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>
                        </div>
                    </li>
                    <li class="col-sm-6">
                        <div class="bg-mg">
                            <div class="bg-mg-f">
                                <img src="{{ asset('home/img/demoimg/Roadshow.jpg') }}"/>
                            </div>
                        </div>
                        <div>
                            <h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>
                            <p>Posted on 2016/11/11 10:44:05</p>
                            <p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>
                        </div>
                    </li>
                    <li class="col-sm-6">
                        <div class="bg-mg">
                            <div class="bg-mg-f">
                                <img src="{{ asset('home/img/demoimg/Roadshow.jpg') }}"/>
                            </div>
                        </div>
                        <div>
                            <h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>
                            <p>Posted on 2016/11/11 10:44:05</p>
                            <p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>
                        </div>
                    </li>
                </ul>
            </div>
            <ul class="section6_top">
                <li>
                    <h2>市场资讯</h2>
                </li>
            </ul>
            <div id="yxzx" class="row">
                <ul class='col-sm-5 section6_right'>
                    <li>
                        <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                        <p>Posteed on 2016/07/03</p>
                    </li>
                    <li>
                        <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                        <p>Posteed on 2016/07/03</p>
                    </li>
                    <li>
                        <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                        <p>Posteed on 2016/07/03</p>
                    </li>
                    <li>
                        <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                        <p>Posteed on 2016/07/03</p>
                    </li>
                </ul>
                <ul class='col-sm-5 section6_right'>
                    <li>
                        <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                        <p>Posteed on 2016/07/03</p>
                    </li>
                    <li>
                        <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                        <p>Posteed on 2016/07/03</p>
                    </li>
                    <li>
                        <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                        <p>Posteed on 2016/07/03</p>
                    </li>
                    <li>
                        <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                        <p>Posteed on 2016/07/03</p>
                    </li>
                </ul>
            </div>
        </section>
        <!----英雄社区与市场咨询结束----->
        <!----英雄会友情机构开始----->
        <section id="section7" class="font-size">
            <h2>英雄会合作机构</h2>
            <ul class="row">
                <li class="col-sm-2"><a href="#"><img src="{{ asset('home/img/demoimg/test2.jpg') }}"></a></li>
                <li class="col-sm-2"><a href="#"><img src="{{ asset('home/img/demoimg/test2.jpg') }}"></a></li>
                <li class="col-sm-2"><a href="#"><img src="{{ asset('home/img/demoimg/test2.jpg') }}"></a></li>
                <li class="col-sm-2"><a href="#"><img src="{{ asset('home/img/demoimg/test2.jpg') }}"></a></li>
                <li class="col-sm-2"><a href="#"><img src="{{ asset('home/img/demoimg/test2.jpg') }}"></a></li>
            </ul>
        </section>
        <!----英雄会友情机构结束----->
    </div>
    <!-- 英雄社区 End-->

    <!-- 英雄会顶级投资机构联盟 Start-->
    <div class=" container-fluid" style="padding: 0px">
    </div>
    <div class=" container-fluid" style="background: #F2F3F7;">
        <section id="section9" class="font-size">
            <h2>英雄会顶级投资机构联盟</h2>
            <ul class="row">
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
                <li class="col-sm-2">
                    <img src="{{ asset('home/img/demoimg/test4.jpg') }}"/>
                    <a href="#">
                        <div>
                            <img src="{{ asset('home/img/cross.png') }}"/>
                        </div>
                    </a>
                </li>
            </ul>
        </section>
    </div>
    <!-- 英雄会顶级投资机构联盟 End-->
@endsection

