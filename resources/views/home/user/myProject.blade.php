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
          @if(is_array($data))
          @foreach($data as $temp)
            <li class="col-sm-6 col-md-6 col-lg-4 mar-emt15">
              <div class="content-block">
                <a href="@if($temp->status==1){{route('project.show',['id' => $temp->guid])}}@else#@endif">
                  <img onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{$temp->banner_img}}">
                </a>
                <div>
                  <a href="@if($temp->status==1){{route('project.show',['id' => $temp->guid])}}@else#@endif" class="ellipse">{{$temp->title}}</a>
                  <p>{{mb_substr($temp->brief_content,0,38,'utf-8')}}...</p>
                  <!---p标签内容不可超过40个中文简体字--->
                  <div>
                    @if($temp->status==0)
                      审核中
                    @elseif($temp->status==1)
                      通过审核
                    @elseif($temp->status==2)
                      未通过审核
                    @endif
                  </div>
                </div>
              </div>
            </li>
            @endforeach
          @else
            <li class="col-sm-12 col-md-12 col-lg-12">
              <div style="text-align: center;color: #777777">{{$data}}</div>
            </li>
          @endif
        </ul>
          @if(!empty($pageView))
              <div style="text-align: center">
                  {!! $pageView['pages'] !!}
              </div>
          @endif
        <div class="text-center">
          <a href="/project/create" id="toggle-popup" class="btn fs-15 border-no mar-emt15 btn-1 bgc-2 fs-c-1 zxz" role="button">新建项目</a>
        </div>
      </div>
      <!--我的项目列表结束-->
@endsection

@section('script')

@endsection