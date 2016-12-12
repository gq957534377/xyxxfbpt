@extends('home.layouts.master')

@section('style')
    <link href="{{ asset('home/css/articleContent.css') }}" rel="stylesheet">
@endsection

@section('menu')
    @parent
@endsection

@section('content')
        <section class="container-fluid">
          <div class="row content">
              @if(!empty($StatusCode) && $StatusCode == '200')
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 content-left">
              <div class="row article-title">
                <h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{{ $ResultData->title }}</h2>
              </div>
              <div class="row article-content">
                <div class="bg-mg col-lg-1 col-md-1 col-sm-1 col-xs-1">
                  <div class="bg-mg-f">
                    <img src="{{ $ResultData->headPic }}">
                  </div>
                </div>
                <div class="author-name col-lg-11 col-md-11 col-sm-11 col-xs-11">
                  <p>
                    {{ $ResultData->author or '匿名' }} {{ $ResultData->time }}
                  </p>
                </div>
                <div class="fwb col-lg-12 col-md-12 col-sm-12 col-xs-12">{!! $ResultData->describe !!}</div>
              </div>
              <div class="row article-bottom">
                <span id="like" data-id="{{ $ResultData->guid }}" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
                    点赞
                </span>
                <span class="col-lg-10 col-md-10 col-sm-10 col-xs-12 fenxiang">
                  <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                </span>
              </div>
            </div>
            @endif
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 content-right">
              <div class="guangao row">
                <a href="#"><img class="col-lg-12 col-md-12" src="{{ asset('home/img/test13.jpg') }}"></a>
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
                <h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">评论</h2>
                <ul class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <!---循环遍历开始-->
                  <li class="row inputs">
                    <textarea>
                    </textarea>
                    <button class="subbtn btn btn-warning" >提交</button>
                  </li>
                  <li class="row">
                    <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                      <div class="user-img-bgs">
                        <img src="{{ asset('home/img/test11.jpg') }}">
                      </div>
                    </div>
                    <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                      <div class="row user-say1">
                        <span>Paloma</span>
                        <span>2016-11-24 16:26</span>
                      </div>
                      <div class="row user-say2">
                        <p>这个项目很有意思,我很喜欢,赞一个</p>
                      </div>
                    </div>
                  </li>
                  <!---循环遍历结束-->
                  <li class="row">
                    <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                      <div class="user-img-bgs">
                        <img src="{{ asset('home/img/test11.jpg') }}">
                      </div>
                    </div>
                    <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                      <div class="row user-say1">
                        <span>Paloma</span>
                        <span>2016-11-24 16:26</span>
                      </div>
                      <div class="row user-say2">
                        <p>这个项目很有意思,我很喜欢,赞一个</p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <!--评论区域开始-->
            </div>
          </div>
        </section>
@endsection

@section('script')
    <script>
        $('#like').on('click', function () {
            var me = $(this);
            var id = me.data('id');

             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
             $.ajax({
                 type : 'get',
                 url: '/article/' + id + '/edit',
                 processData: false, // 告诉jQuery不要去处理发送的数据
                 contentType: false, // 告诉jQuery不要去设置Content-Type请求头
                 async: true,
                 success: function(msg){

                     switch (msg.StatusCode){
                         case '400':
                             alert(msg.ResultData);
                             break;
                         case "200":
                             me.html('点赞  ' + msg.ResultData[0]);
                             me.toggleClass('taoxin');
                             break;
                         default:

                             alert('请先登录');
                             location.href = "http://www.hero.app/login";
                             break;
                     }
                 },
                 error: function(XMLHttpRequest){
                     var number = XMLHttpRequest.status;
                     var msg = "Error: "+number+",数据异常！";
                     alert(msg);
                 }

             });
        });
    </script>
    <script src="{{ asset('home/js/article.js') }}"></script>
@endsection
