@extends('home.layouts.master')

@section('style')
    <link href="{{ asset('home/css/articleContent.css') }}" rel="stylesheet">
@endsection

@section('menu')
    @parent
@endsection

@section('content')
        @if(empty($error))
        <section class="container-fluid">
          <div class="row content">

            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 content-left">
              <div class="row article-title">
                <h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ $title or '' }}</h2>
              </div>
              <div class="row article-content">
                <div class="bg-mg col-lg-1 col-md-1 col-sm-1 col-xs-1">
                  <div class="bg-mg-f">
                    <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $headPic or '' }}">
                  </div>
                </div>
                <div class="author-name col-lg-11 col-md-11 col-sm-11 col-xs-11">
                  <p>
                    {{ $author or '匿名' }} {{ date('Y-m-d H:i', $addtime) }}
                  </p>
                </div>
                <div class="fwb col-lg-12 col-md-12 col-sm-12 col-xs-12">{!! $describe or '' !!}</div>
              </div>
              <div class="row article-bottom">
                      <span id="like" data-id="" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
                            <span></span> <span id="likeNum">0</span>
                      </span>
                <span class="col-lg-10 col-md-10 col-sm-10 col-xs-12 fenxiang">
                  <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                </span>
              </div>
            </div>


            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 content-right">
              <div class="guangao row">
                <a href="#"><img onerror="this.src='{{asset('home/img/zxz.png')}}'" class="col-lg-12 col-md-12" src="{{ asset('home/img/test13.jpg') }}"></a>
              </div>
              <div class="row news-list-title">
                <h2>你可能感兴趣的文章</h2>
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
              <!--评论区域开始-->
              <div class="row pl-block">
                <h2 class="col-lg-8 col-md-8 col-sm-8 col-xs-8">评论</h2>
                <a href="{{asset('comment')}}" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">更多评论></a>
                <ul id="commentlist" class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <!---循环遍历开始-->
                  <li class="row inputs">
                      <form id="comment" method = 'post'>
                            <input name="action_id" value="" hidden>
                            <input name="type" value="1" hidden>
                            <textarea name="content" required></textarea>
                            <button type="submit" class="subbtn btn btn-warning" >提交</button>
                      </form>
                  </li>

                </ul>
              </div>
              <!--评论区域开始-->
            </div>
          </div>
        </section>
        @else
            <div class="container">
                <div class="row" >
                    <div class="col-sm-3" style="text-align: center;">
                        <h1>验证码错误</h1>
                    </div>
                </div>
            </div>
    @endif
@endsection

@section('script')
@endsection
