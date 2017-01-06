@extends('home.layouts.master')

@section('style')
  <link href="{{ asset('home/css/change-passwd.css') }}" rel="stylesheet">
  <link href="{{ asset('home/css/sweet-alert.min.css') }}" rel="stylesheet">

@endsection

@section('menu')
  @parent
@endsection

@section('content')
<div class="container-fluid bgc-8">
  <div class="container">

    <div class="bgc-0 col-md-offset-2 col-xs-12 col-md-8 change-passwd">
          <p class="fs-24 bb-1">重置密码</p>

          <div>
              <div id="error-info" class="alert alert-danger" style="display: none;"></div>
            <form id="changePasswordForm" class="form-horizontal" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">

              <div class="form-group mar-b30">
                <label for="form-title" class="col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">手机号：</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="">
                </div>
              </div>
              <div class="form-group mar-b30">
                <label for="wechat-num" class="col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">新密码：</label>
                <div class="col-sm-6">
                  <input type="password" class="form-control form-title" id="password" name="password" placeholder="">
                </div>
              </div>

              <div class="form-group mar-b30 mar-b15-xs">
                <label for="work-company" class="col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">确认新密码：</label>
                <div class="col-sm-6">
                  <input type="password" class="form-control" name="confirm_password" id="" placeholder="">
                </div>
              </div>
              <div class="form-group mar-b30 mar-b15-xs">
                <label for="work-position" class="col-xs-12 col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">验证码：</label>
                <div class="col-xs-7 col-sm-4">
                  <input type="text" class="form-control form-title" name="piccode" placeholder="">
                </div>
                <div class="col-xs-5 col-md-3 pad-cl">
                  <img id="captcha" data-sesid="" src="{{url('/code/captcha/1')}}">
                </div>
              </div>

              <div class="form-group mar-b30 mar-b15-xs">
                <label for="work-position" class="col-xs-12 col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">验证码：</label>
                <div class="col-xs-7 col-sm-4">
                  <input type="text" class="form-control form-title" name="code" id="work-position" placeholder="">
                </div>
                <div class="col-xs-5 col-md-3 pad-cl">
                  <button class="btn fs-15 bgc-4 fs-c-0 zxz border-no" role="button" id="get_captcha">获取验证码</button>
                </div>
              </div>

              <div class="form-group mar-b30">
                <div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-sm-6">
                  <button type="submit" class="btn fs-18 btn-1 bgc-2 fs-c-1 zxz border-no" id="submit_my_company">提&nbsp;&nbsp;&nbsp;&nbsp;交</button>
                </div>
              </div>
            </form>

          </div>
        </div>
  </div>
</div>

@endsection
@section('script')
    <script src="{{ asset('home/js/sweet-alert.min.js') }}"></script>
    <script src="{{asset('home/js/sweet-alert.init.js')}}"></script>
    <script src="{{asset('home/js/changePasswd.js')}}"></script>
  <script>

  </script>
@endsection
