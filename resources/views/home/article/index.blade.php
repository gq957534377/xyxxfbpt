@extends('home.layouts.master')

@section('style')
  <link rel="stylesheet" href="{{ asset('home/css/list.css') }}">
  <link href="{{ asset('home/css/zhengce.css') }}" rel="stylesheet">
@endsection

@section('menu')
  @parent
@endsection

@section('content')
  <section class="bannerimg hang">
    <img src="{{ asset('home/img/demoimg/dd.jpg') }}">
  </section>
    <!--内容开始--->
    <section class="container-fluid">
      <input id="article-type" type="text" hidden value="{{ $type or 1 }}">
      <div class="row content">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 content-left">
          @if(empty($type) || $type == 1)
              <h2>市场咨讯</h2>
          @else
              <h2>创业政策</h2>
          @endif
          <ul class="article-list">
            @if(!empty($StatusCode) && $StatusCode == '200')
              @foreach($ResultData['data'] as $val)
                <li class="row">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 list-img">
                    <a href="/article/{{ $val->guid }}"><img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->banner }}"></a>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 list-font">
                    <h3><a href="/article/{{ $val->guid }}">{{ $val->title }}</a></h3>
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
          </ul>
          @if(!empty($StatusCode) && $StatusCode == '200' && $ResultData['totalPage'] != 1)
              <div class="loads"></div>
          @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 content-right">
          <div class="guangao row">
            {{--*/$i=rand(1,3);/*--}}
            <a href="#"><img onerror="this.src='{{asset('home/img/zxz.png')}}'" class="col-lg-12 col-md-12" src="{{ asset('home/img/demoimg/zf'.$i.'.jpg') }}"></a>
          </div>
          <div class="row news-list-title">
            <h2>您可能感兴趣的内容</h2>
          </div>
          <ul class="row news-list">

            @if(!empty($StatusCode) && $StatusCode == '200' && $ResultData['RandomList']['StatusCode'] == '200')
                @foreach($ResultData['RandomList']['ResultData'] as $key => $val)
                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <h3><a href="/article/{{ $val->guid }}">{{ $val->title }}</a></h3>
                  <div class="news-list-time">
                    <span>{{ date('Y-m-d', $val->addtime) }}</span>
                  </div>
                </li>
                @endforeach
            @endif

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
<script src="{{ asset('/home/js/articleScroll.js') }}"></script>
@endsection
