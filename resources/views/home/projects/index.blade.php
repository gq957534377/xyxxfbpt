@extends('home.layouts.master')

@section('title', '创新作品')

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/list(pc).css') }}">
@endsection

@section('menu')
    <!---导航栏开始-->
    @include('home.public.nav')
    <!---导航栏结束-->
@endsection

@section('content')
<!-- 广告图 Start-->
    <section class="hang">
        <img src="{{ asset('home/img/demoimg/dd.jpg') }}">
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
                    <a href="{{ route('project.show', $project->project_id) }}">
                        <img src="{{ $project->image }}" alt="">
                    </a>
                    <div>
                        <h3><a href="{{ route('project.show', $project->project_id) }}">{{ $project->title }}</a></h3>
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