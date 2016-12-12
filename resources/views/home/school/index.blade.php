@extends('home.layouts.master')

@section('title', '创新作品')

@section('style')
  <link rel="stylesheet" href="{{ asset('home/css/school.css') }}">
@endsection
@section('content')
        <section class="bannerimg hang">
          <img src="{{ asset('home/img/demoimg/dd.jpg') }}">
        </section>
        <!---类型选择层开始---->
        <section class="container-fluid rodeing-type">
          <ul class="row">
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a class="active" href="#">企业管理</a></li>
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a  href="#">资金管理</a></li>
            <li class='col-lg-1 col-md-1 col-sm-1 col-xs-2'><a href="#">人才管理</a></li>
          </ul>
        </section>
        <!---类型选择层结束---->
        <!---内容层开始---->
        <section class="container-fluid">
          <ul class="row content">
            @if(isset($schooldata))
            @foreach($schooldata as $data)
            <li class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
              <div class="content-block">
                <img src="{{$data->banner}}">
                <h2><a href="{{ route('action.show', $data->guid) }}">{{$data->title}}</a></h2>
                <p>
                  {{$data->brief}}
                </p>
                <div>
                  <span>{{$data->time}}</span>
                </div>
              </div>
            </li>
            @endforeach
              @else
              <div style=" height:160px;width: 100%;text-align: center;font-size: 20px;line-height: 160px;color: #ddd8d5">哎呦喂，亲，暂无数据哦O(∩_∩)O~</div>
            @endif
          </ul>
        </section>
        <!---类型内容层结束---->
@endsection