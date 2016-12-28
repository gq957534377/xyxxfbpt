@extends('home.layouts.userCenter')

@section('title', '我的身份')

@section('style')
  <link href="{{ asset('home/css/user_center_contribute.css') }}" rel="stylesheet">

  <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
  <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
@endsection

@section('content')
      <!--我的投稿 已发表开始-->
      <!--导航开始-->
      <div class="tab-info-top col-xs-12 col-sm-9 col-md-9 col-lg-10 pad-clr">
        <a id="contribute" class="hidden-xs" href="/send?status=5">&nbsp;&nbsp;投稿&nbsp;&nbsp;<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?status=2">审核中({{ $ResultData['releaseNum'] or 0 }})<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?status=1">已发表({{ $ResultData['trailNum'] or 0 }})<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?status=3">已退稿({{ $ResultData['notNum'] or 0 }})<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?status=4">草稿箱({{ $ResultData['draftNum'] or 0 }})<span class="triangle-down left-2"></span></a>
      </div>
      <!--导航结束-->
      <div id="contributeNav" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 fs-15 bgc-1 pad-2">
            <input hidden id="write" value="{{ $write or false }}">
          <div id="contribute-text">
             <span class="contribute-title">投稿</span>
             <form id="contribute-form" class="form-horizontal form-contribute" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                  <div class="form-group mar-b30">
                      <label for="form-title" class="col-md-2 control-label"><span class="form-star">*</span>标题</label>
                      <div class="col-md-10">
                          <input autofocus type="text" class="form-control form-title" id="form-title" name="title" placeholder="">
                          </div>
                      </div>
                  <div class="form-group mar-b30">
                     <label for="form-introduction" class="col-md-2 control-label"><span class="form-star">*</span>导语</label>
                      <div class="col-md-10">
                          <textarea class="form-control form-introduction" id="form-introduction" name="brief" placeholder=""></textarea>
                         </div>
                  </div>
                 <div class="form-group mar-b30">
                     <label for="form-content" class="col-md-2 control-label"><span class="form-star">*</span>展示图片</label>
                     <div class="col-md-10">
                         <input type="hidden" name="1">
                         <div class="col-md-5">
                             <div class="ibox-content">
                                 <div class="row">
                                     <div id="crop-avatar" class="col-md-6">
                                         <div class="avatar-view" title="">
                                             <img id="contribution-picture" src="{{ asset('home/img/upload-card.png') }}" alt="Logo">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                  <div class="form-group mar-b30">
                      <label for="form-content" class="col-md-2 control-label"><span class="form-star">*</span>内容</label>
                     <div class="col-md-10">
                          <textarea class="" id="form-content" name="describe"></textarea>
                          </div>
                  </div>

                 <div class="form-group mar-b30">
                     <label for="form-source" class="col-md-2 control-label"><span class="form-star">*</span>来源</label>
                     <div class="col-md-4 mar-b30">
                         <input type="text" class="form-control" id="form-source" name="source" placeholder="">
                     </div>
                 </div>
                  <div class="form-group mar-b30">
                      <label for="auth-code" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>验证码</label>
                      <div class="col-md-8 pad-clr">
                          <div class="col-xs-5 col-sm-8 col-md-6">
                             <input class="form-control" type="text" id="auth-code" name="verif_code" placeholder="">
                              </div>
                          <div class="col-xs-6 col-sm-4 col-md-4">
                              <img id="captcha" data-sesid="{{ $sesid }}" src="{{url('/code/captcha/' . $sesid)}}">
                              </div>
                          </div>
                      </div>
                  <div class="form-group">

                      <div class="col-xs-4 col-sm-3 col-md-offset-2 col-md-2">
                          <button data-status="2" type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">提交审核</button>
                      </div>
                      <div class="col-xs-4 col-sm-3 col-md-2">
                          <button data-status="4" type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">保存草稿</button>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-2">
                          <button data-status="0" type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">预览</button>
                      </div>
                  </div>
                     <input hidden type="text" id="status" name="status" value="2">
             </form>
          </div>
          @include('home.public.card')


      </div>

      <!--我的投稿 已发表结束-->

@endsection

@section('script')

    {{--富文本--}}
    <script src="{{asset('/laravel-ueditor/ueditor.config.js') }}"></script>
    <script src="{{asset('/laravel-ueditor/ueditor.all.min.js')}}"></script>
    {{--验证--}}
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>

    {{--图片上传--}}
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/contribution.js')}}"></script>
    <script src="{{asset('home/js/contribution.js')}}"></script>


@endsection
