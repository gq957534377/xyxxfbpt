@extends('home.layouts.master')

@section('style')
    <link href="{{ asset('home/css/index.css') }}" rel="stylesheet">

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
                        @if( is_array($rollingPic) )
                            <?php $f = true; ?>
                        @foreach($rollingPic as $key => $val)

                            @if($f)
                                            <?php $f = false; ?>
                                <li data-target="#carousel-example-generic" data-slide-to="{{$key}}" class="active"></li>
                            @else
                                <li data-target="#carousel-example-generic" data-slide-to="{{$key}}"></li>
                            @endif

                        @endforeach
                        @else
                           {{ $rollingPic }}
                        @endif
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @if( is_array($rollingPic) )
                            <?php $f = true; ?>
                        @foreach($rollingPic as $key => $val)

                                    @if($f)
                                            <?php $f = false; ?>
                                        <div class="item active">
                                            <img  onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->url }}" alt="...">
                                            <div class="carousel-caption">
                                            </div>
                                        </div>
                                    @else
                                        <div class="item">
                                            <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->url }}" alt="...">
                                            <div class="carousel-caption">
                                            </div>
                                        </div>
                                    @endif

                        @endforeach
                        @else
                            <li>{{ $rollingPic }}</li>
                        @endif
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
                    <li><a href="{{ route('action.index', ['type' => '2']) }}">参加创业大赛</a></li>
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
                        <h2 class="jx-tit">创新项目</h2>
                    </div>
                    <div class="col-sm-5 col-xs-9 jxxm" style="padding-right:0;">
                        <li><a class="ckgd" href="{{route('project.index')}}">查看更多</a></li>
                        <li><a class="wysjx" href="/user/myProject">我要发布项目！</a></li>
                    </div>
                </div>
                <ul class="row">
                    @if(is_array($projects))
                        @foreach ($projects as $project)
                            <li class="col-sm-4">
                                <a class="new_a" href="{{ route('project.show', $project->guid) }}">
                                    <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $project->banner_img }}">
                                    <div class="companyName">{{ $project->title }}</div>
                                    <div class="classLabel">
                                <span>
                                    @if($project->industry == 0)
                                        TMT
                                    @elseif($project->industry == 1)
                                        医疗健康
                                    @elseif($project->industry == 2)
                                        文化与创意
                                    @elseif($project->industry == 3)
                                        智能硬件
                                    @elseif($project->industry == 4)
                                        教育
                                    @elseif($project->industry == 5)
                                        电商
                                    @elseif($project->industry == 6)
                                        旅游
                                    @elseif($project->industry == 7)
                                        型农业
                                    @elseif($project->industry == 8)
                                        互联网金融
                                    @elseif($project->industry == 9)
                                        游戏
                                    @elseif($project->industry == 10)
                                        汽车后市场
                                    @elseif($project->industry == 11)
                                        企业级服务
                                    @elseif($project->industry == 12)
                                        数据服务
                                    @elseif($project->industry == 13)
                                        其他
                                    @endif
                                </span>
                                        <span>
                                             @if($project->financing_stage == 0)
                                                种子轮
                                            @elseif($project->financing_stage == 1)
                                                天使轮
                                            @elseif($project->financing_stage == 2)
                                                Pre-A轮
                                            @elseif($project->financing_stage == 3)
                                                A轮
                                            @elseif($project->financing_stage == 4)
                                                B轮
                                            @elseif($project->financing_stage == 5)
                                                C轮
                                            @elseif($project->financing_stage == 6)
                                                D轮
                                            @elseif($project->financing_stage == 7)
                                                E轮
                                            @elseif($project->financing_stage == 8)
                                                F轮已上市
                                            @elseif($project->financing_stage == 9)
                                                其他
                                            @endif
                                        </span>
                                    </div>
                                    <p class="new_p">
                                        {{ mb_substr($project->content,0,30).'...'}}
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
            {{--<div class="row">--}}
                {{--<h2>英雄榜</h2>--}}
            {{--</div>--}}
            <ul>
                {{--<li class="row">--}}
                    {{--<a href="#">--}}
                        {{--<div class="section2_img col-sm-3">--}}
                            {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">--}}
                            {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" class="hidden-767" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">--}}
                        {{--</div>--}}
                        {{--<div class="section2_center col-sm-6">--}}
                            {{--<div class="section2_center_title">--}}
                                {{--<h3>小余老师说</h3>--}}
                                {{--<span>致力于让全国人更懂教育的互联网+教育公司</span>--}}
                            {{--</div>--}}
                            {{--<ul>--}}
                                {{--<li>--}}
                                    {{--<div>1天</div>--}}
                                    {{--<div class="section2_hover">成功天数</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<div>￥650万</div>--}}
                                    {{--<div class="section2_hover">成功融资</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<div>傅盛</div>--}}
                                    {{--<div class="section2_hover">领投人</div>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="hidden-767 section2_evaluate col-sm-3">--}}
                            {{--<p>--}}
                                {{--<span></span>--}}
                                {{--<span>跟投人评价：</span>--}}
                                {{--作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="row">--}}
                    {{--<a href="#">--}}
                        {{--<div class="section2_img col-sm-3">--}}
                            {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">--}}
                            {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" class="hidden-767" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">--}}
                        {{--</div>--}}
                        {{--<div class="section2_center col-sm-6">--}}
                            {{--<div class="section2_center_title">--}}
                                {{--<h3>小余老师说</h3>--}}
                                {{--<span>致力于让全国人更懂教育的互联网+教育公司</span>--}}
                            {{--</div>--}}
                            {{--<ul>--}}
                                {{--<li>--}}
                                    {{--<div>1天</div>--}}
                                    {{--<div class="section2_hover">成功天数</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<div>￥650万</div>--}}
                                    {{--<div class="section2_hover">成功融资</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<div>傅盛</div>--}}
                                    {{--<div class="section2_hover">领投人</div>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="hidden-767 section2_evaluate col-sm-3">--}}
                            {{--<p>--}}
                                {{--<span></span>--}}
                                {{--<span>跟投人评价：</span>--}}
                                {{--作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="row">--}}
                    {{--<a href="#">--}}
                        {{--<div class="section2_img col-sm-3">--}}
                            {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">--}}
                            {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" class="hidden-767" src="{{ asset('home/img/demoimg/xiaoyu.jpg') }}">--}}
                        {{--</div>--}}
                        {{--<div class="section2_center col-sm-6">--}}
                            {{--<div class="section2_center_title">--}}
                                {{--<h3>小余老师说</h3>--}}
                                {{--<span>致力于让全国人更懂教育的互联网+教育公司</span>--}}
                            {{--</div>--}}
                            {{--<ul>--}}
                                {{--<li>--}}
                                    {{--<div>1天</div>--}}
                                    {{--<div class="section2_hover">成功天数</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<div>￥650万</div>--}}
                                    {{--<div class="section2_hover">成功融资</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<div>傅盛</div>--}}
                                    {{--<div class="section2_hover">领投人</div>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="hidden-767 section2_evaluate col-sm-3">--}}
                            {{--<p>--}}
                                {{--<span></span>--}}
                                {{--<span>跟投人评价：</span>--}}
                                {{--作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                {{--</li>--}}
            </ul>
        </section>
        <!-- 英雄榜 End -->

        <!-- 路演活动 Start -->
        <section id="section3" class="font-size">
            <div class="section_title">
                <h2>路演活动</h2>
                <a href="{{ route('action.index', ['type' => '1']) }}">查看全部</a>
            </div>
            <div class="section_titles">
                <h2>路演活动</h2>
                <a href="{{ route('action.index', ['type' => '1']) }}">查看全部</a>
            </div>
            <ul class="row">
                @if(is_array($roadShows))
                @foreach($roadShows as $roadShow)
                    <li class="col-sm-4">
                        <a href="{{ url('action').'/'.$roadShow->guid }}">
                            <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $roadShow->banner }}"/>
                        </a>
                        <div class="ly">
                            <h3><a href="{{ url('action').'/'.$roadShow->guid }}">{{ mb_substr($roadShow->title,0,20)."..." }}</a></h3>
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
                    <span>{{ mb_substr($roadShow->address,0,4)."..." }}</span>
    				<span>{{ date('Y-m-d',$roadShow->start_time) }}</span>
    			</span>
                    </li>
                @endforeach
                @else
                    {{ $roadShows }}
                @endif
            </ul>
        </section>
        <!-- 路演活动 End -->

        <!-- 创业大赛 Start -->
        <section id="section3s" class="font-size">
            <div class="section_title">
                <h2>创业大赛</h2>
                <a href="{{ route('action.index', ['type' => '2']) }}">查看全部</a>
            </div>
            <div class="section_titles">
                <h2>创业大赛</h2>
                <a href="{{ route('action.index', ['type' => '2']) }}">查看全部</a>
            </div>
            <ul class="row">
                @if(is_array($sybs))
                @foreach($sybs as $syb)
                    <li class="col-sm-4">
                        <a href="{{ route('action.show', $syb->guid) }}">
                            <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $syb->banner }}"/>
                        </a>
                        <div class="ly">
                            <h3><a href="{{ route('action.show', $syb->guid) }}">{{ mb_substr($syb->title, 0,20).'...' }}</a></h3>
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
    				<span>{{ mb_substr($syb->address,0,4)."..." }}</span>
    				<span>{{ date('Y-m-d',$syb->start_time) }}</span>
    			</span>
                    </li>
                @endforeach
                @else
                  {{ $sybs }}
                @endif
            </ul>
        </section>
        <!-- 创业大赛 End -->

        <!-- 英雄学院 Start -->
        <section id="section4" class="font-size">
            <div class="section_title">
                <h2>英雄学院</h2>
                <a href="{{ route('school.index', ['type' => '1']) }}">查看全部</a>
            </div>
            <div class="section_titles">
                <h2>英雄学院</h2>
                <a href="#">查看全部</a>
            </div>
            <ul class="row">
                @if(is_array($schools))
                @foreach($schools as $school)
                    <li class="col-sm-6">
                        <a href="{{ route('school.show', $school->guid) }}">
                            <span>第1期</span>
                            <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $school->banner }}"/>
                            <div>
                                <h3>{{ mb_substr($school->title, 0,20).'...'}}</h3>
                        <span>
                            @if($school->status == 1)
                                报名中
                            @elseif($school->status == 2)
                                进行中
                            @elseif($school->status == 3)
                                已结束
                            @elseif($school->status == 4)
                                已取消
                            @elseif($school->status == 5)
                                报名截止
                            @endif
                        </span>
                            </div>
                            <p>{{ $school->brief }}</p>
                        </a>
                    </li>
                @endforeach
                @else
                    {{ $schools }}
                @endif
            </ul>
        </section>
        <!-- 英雄学院 End -->
    </div>
    <!-- 活动 End -->

    <!-- 英雄众筹 Start-->
    <div class=" container-fluid" style="background-color: #F6F6F6;">
        {{--<section id="section5" class="font-size">--}}
            {{--<div class="section_titles section_title">--}}
                {{--<h2>英雄众筹</h2>--}}
            {{--</div>--}}
            {{--<div id="section5_content">--}}
                {{--<!-- <h2>众筹</h2> -->--}}
                {{--<ul id="section5_content_middle">--}}
                    {{--<li class="active">最新上架</li>--}}
                    {{--<li>即将结束</li>--}}
                    {{--<a id="zcckgd_a" href="#">查看全部></a>--}}
                {{--</ul>--}}
                {{--<div id="section5_content_bottom">--}}
                    {{--<ul class="row">--}}
                        {{--<li class="col-sm-3">--}}
                            {{--<a href="#">--}}
                                {{--<div class="img_block">--}}
                                    {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/test.jpg') }}">--}}
                                    {{--<div>--}}
                                        {{--<p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="js_loding">--}}
                                    {{--<h4>NOBADAY单板滑雪板</h4>--}}
                                    {{--<div class="js_loding_father">--}}
                                        {{--<div class="js_loding_son"></div>--}}
                                    {{--</div>--}}
                                    {{--<span>目标</span>--}}
                                    {{--<span>￥53000</span>--}}
                                    {{--<span class="zcy">￥7949</span>--}}
                                    {{--<span class="zcy">超值档位</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="col-sm-3">--}}
                            {{--<a href="#">--}}
                                {{--<div class="img_block">--}}
                                    {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/test.jpg') }}">--}}
                                    {{--<div>--}}
                                        {{--<p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="js_loding">--}}
                                    {{--<h4>NOBADAY单板滑雪板</h4>--}}
                                    {{--<div class="js_loding_father">--}}
                                        {{--<div class="js_loding_son"></div>--}}
                                    {{--</div>--}}
                                    {{--<span>目标</span>--}}
                                    {{--<span>￥53000</span>--}}
                                    {{--<span class="zcy">￥7949</span>--}}
                                    {{--<span class="zcy">超值档位</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="col-sm-3">--}}
                            {{--<a href="#">--}}
                                {{--<div class="img_block">--}}
                                    {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/test.jpg') }}">--}}
                                    {{--<div>--}}
                                        {{--<p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="js_loding">--}}
                                    {{--<h4>NOBADAY单板滑雪板</h4>--}}
                                    {{--<div class="js_loding_father">--}}
                                        {{--<div class="js_loding_son"></div>--}}
                                    {{--</div>--}}
                                    {{--<span>目标</span>--}}
                                    {{--<span>￥53000</span>--}}
                                    {{--<span class="zcy">￥7949</span>--}}
                                    {{--<span class="zcy">超值档位</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="col-sm-3">--}}
                            {{--<a href="#">--}}
                                {{--<div class="img_block">--}}
                                    {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/test.jpg') }}">--}}
                                    {{--<div>--}}
                                        {{--<p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="js_loding">--}}
                                    {{--<h4>NOBADAY单板滑雪板</h4>--}}
                                    {{--<div class="js_loding_father">--}}
                                        {{--<div class="js_loding_son"></div>--}}
                                    {{--</div>--}}
                                    {{--<span>目标</span>--}}
                                    {{--<span>￥53000</span>--}}
                                    {{--<span class="zcy">￥7949</span>--}}
                                    {{--<span class="zcy">超值档位</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<ul class="active row">--}}
                        {{--<li class="col-sm-3">--}}
                            {{--<a href="#">--}}
                                {{--<div class="img_block">--}}
                                    {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/5837b19bN7c6a2b50.jpg') }}">--}}
                                    {{--<div>--}}
                                        {{--<p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="js_loding">--}}
                                    {{--<h4>NOBADAY单板滑雪板</h4>--}}
                                    {{--<div class="js_loding_father">--}}
                                        {{--<div class="js_loding_son"></div>--}}
                                    {{--</div>--}}
                                    {{--<span>目标</span>--}}
                                    {{--<span>￥53000</span>--}}
                                    {{--<span class="zcy">￥7949</span>--}}
                                    {{--<span class="zcy">超值档位</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="col-sm-3">--}}
                            {{--<a href="#">--}}
                                {{--<div class="img_block">--}}
                                    {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/5837b19bN7c6a2b50.jpg') }}">--}}
                                    {{--<div>--}}
                                        {{--<p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="js_loding">--}}
                                    {{--<h4>NOBADAY单板滑雪板</h4>--}}
                                    {{--<div class="js_loding_father">--}}
                                        {{--<div class="js_loding_son"></div>--}}
                                    {{--</div>--}}
                                    {{--<span>目标</span>--}}
                                    {{--<span>￥53000</span>--}}
                                    {{--<span class="zcy">￥7949</span>--}}
                                    {{--<span class="zcy">超值档位</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="col-sm-3">--}}
                            {{--<a href="#">--}}
                                {{--<div class="img_block">--}}
                                    {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/5837b19bN7c6a2b50.jpg') }}">--}}
                                    {{--<div>--}}
                                        {{--<p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="js_loding">--}}
                                    {{--<h4>NOBADAY单板滑雪板</h4>--}}
                                    {{--<div class="js_loding_father">--}}
                                        {{--<div class="js_loding_son"></div>--}}
                                    {{--</div>--}}
                                    {{--<span>目标</span>--}}
                                    {{--<span>￥53000</span>--}}
                                    {{--<span class="zcy">￥7949</span>--}}
                                    {{--<span class="zcy">超值档位</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="col-sm-3">--}}
                            {{--<a href="#">--}}
                                {{--<div class="img_block">--}}
                                    {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/5837b19bN7c6a2b50.jpg') }}">--}}
                                    {{--<div>--}}
                                        {{--<p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="js_loding">--}}
                                    {{--<h4>NOBADAY单板滑雪板</h4>--}}
                                    {{--<div class="js_loding_father">--}}
                                        {{--<div class="js_loding_son"></div>--}}
                                    {{--</div>--}}
                                    {{--<span>目标</span>--}}
                                    {{--<span>￥53000</span>--}}
                                    {{--<span class="zcy">￥7949</span>--}}
                                    {{--<span class="zcy">超值档位</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</section>--}}
    </div>
    <!-- 英雄众筹 End-->

    <!-- 英雄社区 Start-->
    <div class=" container-fluid">
        <section id="section6" class="font-size">
            {{--<ul class="section6_top">--}}
                {{--<li>--}}
                    {{--<h2>英雄社区</h2>--}}
                {{--</li>--}}
            {{--</ul>--}}
            {{--<div id="section6_bottom">--}}
                {{--<ul id="section6_left" class="row">--}}
                    {{--<li class="col-sm-6">--}}
                        {{--<div class="bg-mg">--}}
                            {{--<div class="bg-mg-f">--}}
                                {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/Roadshow.jpg') }}"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>--}}
                            {{--<p>Posted on 2016/11/11 10:44:05</p>--}}
                            {{--<p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="col-sm-6">--}}
                        {{--<div class="bg-mg">--}}
                            {{--<div class="bg-mg-f">--}}
                                {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/Roadshow.jpg') }}"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>--}}
                            {{--<p>Posted on 2016/11/11 10:44:05</p>--}}
                            {{--<p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="col-sm-6">--}}
                        {{--<div class="bg-mg">--}}
                            {{--<div class="bg-mg-f">--}}
                                {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/Roadshow.jpg') }}"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>--}}
                            {{--<p>Posted on 2016/11/11 10:44:05</p>--}}
                            {{--<p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="col-sm-6">--}}
                        {{--<div class="bg-mg">--}}
                            {{--<div class="bg-mg-f">--}}
                                {{--<img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/demoimg/Roadshow.jpg') }}"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>--}}
                            {{--<p>Posted on 2016/11/11 10:44:05</p>--}}
                            {{--<p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            <ul class="section6_top">
                <li>
                    <h2>市场资讯</h2>
                </li>
            </ul>
            <div id="yxzx" class="row">
                <ul class='col-sm-5 section6_right'>
                    @for($i = 0; $i < round(count($articles)/2); $i++)
                        <li>
                            <h3><a href="{{ route('article.show', $articles[$i]->guid) }}">{{ mb_substr($articles[$i]->title, 0,20).'...' }}</a></h3>
                            <p>发布时间 {{ $articles[$i]->addtime }}</p>
                        </li>
                    @endfor
                </ul>
                <ul class='col-sm-5 section6_right'>
                    @for($i = round(count($articles)/2); $i < count($articles); $i++)
                        <li>
                            <h3><a href="{{ route('article.show', $articles[$i]->guid) }}">{{ mb_substr($articles[$i]->title, 0,20).'...' }}</a></h3>
                            <p>发布时间 {{ $articles[$i]->addtime }}</p>
                        </li>
                    @endfor
                </ul>
            </div>
        </section>
        <!----英雄社区与市场咨询结束----->
        <!----英雄会友情机构开始----->
        <section id="section7" class="font-size">
            <h2>英雄会合作机构</h2>
            <ul class="row">
                @if(is_array($picArr))
                @foreach($picArr as $val)
                        @if($val->type == 3)
                            <li class="col-sm-2"><a href="{{ $val->pointurl }}"><img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->url }}"></a></li>
                        @endif
                @endforeach
                @else
                  {{ $picArr }}
                @endif
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
                @if(is_array($picArr))
                @foreach($picArr as $val)
                        @if($val->type == 5)
                            <li class="col-sm-2">
                                <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->url }}"/>
                                <a href="{{ $val->pointurl }}">
                                    <div>
                                        <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ asset('home/img/cross.png') }}"/>
                                    </div>
                                </a>
                            </li>
                        @endif
                @endforeach
                @else
                  {{ $picArr }}
                @endif

            </ul>
        </section>
    </div>
    <!-- 英雄会顶级投资机构联盟 End-->

@endsection
@section('script')
<script>
    alert($.cookie('Remember_user'));
</script>
@endsection

