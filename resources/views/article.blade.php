@extends('home.layouts.master')

@section('style')
  <link rel="stylesheet" href="{{ asset('home/css/list.css') }}">
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
            @if(!empty($data))
              @foreach($data as $val)

                <li class="row">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 list-img">
                    <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->banner }}">
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 list-font">
                    <h3><a href="/test/show/?guid={{ $val->guid }}">{{ $val->title }}</a></h3>
                    <p>{{ $val->brief }}</p>
                    <div class="row list-font-bottom">
                      <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">{{ date('Y-m-d H:i', $val->addtime) }}</span>
                      <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                      <div class="bg-mg">
                        <div class="bg-mg-f">
                          <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->headPic }}">
                        </div>
                      </div>
                      <div class="bg-mg-name">{{ $val->author or '匿名' }}</div>
                    </span>
                    </div>
                  </div>
                </li>

              @endforeach
            @else
              <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span style="color: #999999;text-align:center;">暂无数据呦~亲 O(∩_∩)O~</span>
              </li>
            @endif
            <li>
              <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-2">
                  <a href="#"><button class="btn btn-warning btn-sm">点击加载更多</button></a>
                </div>

              </div>
            </li>
          </ul>

        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 content-right">
          <div class="guangao row">
            <a href="#"><img onerror="this.src='{{asset('home/img/zxz.png')}}'" class="col-lg-12 col-md-12" src="{{ asset('home/img/test13.jpg') }}"></a>
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
@section('script')
{{--<script src="{{ asset('/home/js/articleScroll.js') }}"></script>--}}

  <script>
          str += '<li class="row">';
          str += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 list-img">';
          str +='<img onerror="this.src='+ +'" src="'+ +'">';
          str +='</div>';
          str +='<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 list-font">';
          str +='<h3><a href="/article/'+v.guid+'">'+ v.title +'</a></h3>';
          str +='<p>'+v.brief+'</p>';
          str +='<div class="row list-font-bottom">';
          str +='<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">'+v.addtime+'</span>';
          str +='<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
          str +='<div class="bg-mg">';
          str +='<div class="bg-mg-f">';
          str +='<img  src="'+v.headPic+'">';
          str +='</div>';
          str +='</div>';
          str +='<div class="bg-mg-name">'+v.author+'</div>';
          str +='</span>';
          str +='</div>';
          str +='</div>';
          str +='</li>';
  </script>
@endsection