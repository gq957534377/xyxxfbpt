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
                        <i id="editProject" style="color: #FF9036;font-size: 16px;cursor: pointer;float: right">查看</i>
                          <i id="delProject" style="color: #FF0000;font-size: 16px;cursor: pointer;float: right">删除</i>git
                        <div id="becouse" style="display: none">{{$temp->remark}}</div>
                        <div id="project_id" style="display: none">{{$temp->guid}}</div>
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
    <script>
        $('#editProject').click(function () {

            swal({
                        title: '未通过原因', // 标题，自定
                        text: $('#becouse').html(),   // 内容，自定
                        type: "warning",    // 类型，分别为error、warning、success，以及info
                        showCancelButton: true, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                        confirmButtonColor: '#34c73b',  // 确认用途的按钮颜色，自定
                        confirmButtonText: "重新编辑",
                        cancelButtonText: "关闭",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = '/project/'+ $("#project_id").html()+'/edit';
                        } else {
                            swal("温馨提醒", "您未对该项目作出更改", "success");
                        }

                    });
        })
    </script>
@endsection