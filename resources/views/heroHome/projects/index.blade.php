@extends('heroHome.layouts.master')

@section('title', '创新作品')

@section('style')
    <link rel="stylesheet" href="{{ asset('heroHome/css/list(pc).css') }}">
@endsection

@section('menu')
    <!---导航栏开始-->
    <nav class="container-fluid naves">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ url('/') }}">奇力首页</a></li>
                <li><a href="{{ url('/project') }}">创新作品</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">项目投资<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">项目投资</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
                <li><a href="#">英雄学院</a></li>
                <li><a href="#">市场咨询</a></li>
                <li><a href="#">创业政策</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">项目投资<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">路演活动</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!---导航栏结束-->
@endsection

@section('content')
<!-- 广告图 Start-->
    <section class="hang">
        <img src="{{ asset('heroHome/img/demoimg/dd.jpg') }}">
    </section>
<!-- 广告图 End-->

<!--搜索行开始-->
<section class="hang container-fluid">
    <form>
        <ul class="row selected">
            <li class="col-lg-1 col-md-1 col-sm-1 col-xs-6">默认排序</li>
            <li class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                <select name="" id="">
                    <option value="">最近三天</option>
                    <option value="">最近一周</option>
                    <option value="">最近一月</option>
                    <option value="">全部</option>
                </select>
            </li>
            <li class="col-lg-2 col-md-2 col-sm-2 col-xs-6"><input placeholder='结果中搜索项目名称' name="selects" type="text"></li>
            <li class="col-lg-1 col-md-1 col-sm-1 col-xs-3"><button type="button">搜索</button></li>
        </ul>
    </form>
</section>
<!--搜索行结束-->

<!--主体内容行开始-->
<section class="hang container-fluid">
    <ul class="row content">
        @foreach($projects as $project)
            <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="content-block">
                    <a href="#">
                        <img src="{{ $project->image }}" alt="">
                    </a>
                    <div>
                        <h3><a href="#">{{ $project->title }}</a></h3>
                        <p>{{ $project->content }}</p>
                        <!--p标签内容不可超过40个中文简体字-->
                        <div>
                            <span>21</span>
                            <span>12723</span>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</section>
<!--主体内容行结束-->
@endsection