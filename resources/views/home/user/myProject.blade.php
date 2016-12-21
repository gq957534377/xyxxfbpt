@extends('home.layouts.userCenter')

@section('title','我的项目')

@section('style')
  <link href="{{ asset('home/css/user_center_my_project.css') }}" rel="stylesheet">
@endsection
@section('content')
      <!--我的项目列表开始-->
      <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 my-project">
        <div>
          <span>我的项目</span>
        </div>
        <ul class="row pad-3">
          <li class="col-sm-6 col-md-6 col-lg-4 mar-emt15">
            <div class="content-block">
              <a href="#">
                <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{asset('home/img/demoimg/test6.jpg') }}/" alt="">
              </a>
              <div>
                <a href="#">金蟾云</a>
                <p>金蟾云管理系统，一款基于SAAS的真正简跨境出口电商销售管理系统。。。</p>
                <!---p标签内容不可超过40个中文简体字--->
                <div>
                  <span>21</span>
                  <span class="pull-right">12723</span>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <div class="text-center">
          <a href="/project/create" id="toggle-popup" class="btn fs-15 border-no mar-emt15 btn-1 bgc-2 fs-c-1 zxz" role="button">新建项目</a>
        </div>
      </div>
      <!--我的项目列表结束-->
@endsection

@section('script')

@endsection