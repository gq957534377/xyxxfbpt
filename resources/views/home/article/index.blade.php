@extends('home.layouts.master')

@section('style')
  <link rel="stylesheet" href="{{ asset('home/css/list(pc).css') }}">
  <link href="{{ asset('home/css/zhengce.css') }}" rel="stylesheet">
@endsection

@section('menu')
  @parent
@endsection

@section('content')
    <!--内容开始--->
    <section class="container-fluid">
      <div class="row content">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 content-left">
          <h2>最新文章</h2>
          <ul class="article-list">
            @if(!empty($StatusCode) && $StatusCode == '200')
              @foreach($ResultData as $val)
                <li class="row">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 list-img">
                    <img src="{{ $val->banner }}">
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 list-font">
                    <h3><a href="/market/{{ $val->guid }}">{{ $val->title }}</a></h3>
                    <p>{{ $val->brief }}</p>
                    <div class="row list-font-bottom">
                      <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">2016-12-31 15:04</span>
                      <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                      <div class="bg-mg">
                        <div class="bg-mg-f">
                          <img src="{{ $val->headPic }}">
                        </div>
                      </div>
                      <div class="bg-mg-name">{{ $val->author or '匿名' }}</div>
                    </span>
                    </div>
                  </div>
                </li>
              @endforeach
            @else
            @endif
          </ul>

        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 content-right">
          <div class="guangao row">
            <a href="#"><img class="col-lg-12 col-md-12" src="{{ asset('home/img/test13.jpg') }}"></a>
          </div>
          <div class="row news-list-title">
            <h2>7×24h 快讯</h2>
          </div>
          <ul class="row news-list">
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
              <div class="news-list-time">
                <span>两分钟前</span>
              </div>
            </li>
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
              <div class="news-list-time">
                <span>两分钟前</span>
              </div>
            </li>
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
              <div class="news-list-time">
                <span>两分钟前</span>
              </div>
            </li>
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
              <div class="news-list-time">
                <span>两分钟前</span>
              </div>
            </li>
          </ul>
          <!-- <div class="btn-ll">
            浏览更多
          </div> -->
        </div>
      </div>
    </section>
      <!--内容结束--->
@endsection