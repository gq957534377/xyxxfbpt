{{--author 郭庆--}}
@extends('admin.layouts.master')
@section('styles')
    <link href="{{asset('admin/css/userandrole.css')}}" rel="stylesheet">
@endsection
{{--展示内容开始--}}
@section('content')

    <div class="btn-toolbar" role="toolbar">
        <h2>用户管理</h2>
    </div>
    {{--表格盒子开始--}}
    <div class="panel" id="data" style="text-align: center">
        @if($StatusCode == '200')
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">昵称</th>
                        <th class="text-center">手机</th>
                        <th class="text-center">邮箱</th>
                        <th class="text-center">用户状态</th>
                        <th class="text-center">注册时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ResultData['data'] as $user)
                        {{--{{ dd($user) }}--}}
                        <tr class="gradeX">
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>{{ $user->email }}</td>
                            <td>@if($user->status == 1) <span style="color: green">正常</span> @else <span
                                        style="color: red">已禁用</span> @endif
                            </td>
                            <td>{{ date('Y-m-d H:m:s', $user->addtime) }}</td>
                            <td>
                                <a data-nickname="{{ $user->username }}" data-realname="{{ $user->realname }}"
                                   data-tel="{{ $user->phone_number }}" data-email="{{ $user->email }}"
                                   data-headpic="{{ $user->headpic }}" data-addtime="{{ $user->addtime }}"
                                   data-status="{{ $user->status }}" class="user_info btn btn-warning btn-xs">
                                    详情
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                {!! $ResultData['pages'] !!}
            </div>
        @else
            <p>{{ $ResultData }}</p>
        @endif
    </div>
    {{--表格盒子结束--}}

    {{--查看详情弹出框 --}}
    <div id="user-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
         style="display: none;">
        <div class="modal-dialog" id="fabu">
            <div class="modal-content">
                <div id="" class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span
                                class="text-danger">x</span></button>
                    <h3>用户详细信息</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>头像</strong> :
                                    {{--<img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}">--}}
                                    <div class="ibox-content"
                                         style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                                        <div class="row">
                                            <div id="crop-avatar">
                                                <div class="avatar-view pic_head_img" title=""
                                                     style="width: 70px;border: none;border-radius: 0px;box-shadow: none;">
                                                    <img id="headpic" class="img-circle" src=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>真实姓名 ：</strong>
                                    <mark><span id="realname"></span></mark>
                                </li>
                                <li><strong>昵称 ：</strong><span id="nickname"></span></li>
                                <li><strong>电话 ：</strong>
                                    <ins><span id="phone"></span></ins>
                                </li>
                                <li><strong>邮箱 ：</strong><span id="email"></span></li>

                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">

                                <li><strong>注册时间 ：</strong><span id="addtime"></span></li>
                                <li id="role"></li>
                                <li id="status"></li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
{{--展示内容结束--}}

@section('script')
    <script>
        $('.user_info').click(function () {

            var data = $(this).data();
            var time = new Date(data.addtime*1000);
            //alert(realname);
            $('#headpic').attr('src',data.headpic);
            $('#realname').text(data.realname ? data.realname : ' - - ');
            $('#nickname').text(data.nickname);
            $('#phone').text(data.tel);
            $('#email').text(data.email ? data.email : ' - - ');
            $('#addtime').text(time.getFullYear() +'-'+ time.getMonth() + 1 +'-' +time.getDate()+ ' ' +time.getHours()+':'+time.getMinutes() + ':' + time.getSeconds());

            //状态匹配
            switch (data.status){
                case 1:
                    var status = '<strong>当前状态 ：</strong><span class="text-primary text-xs">正常使用中&nbsp;</span>';
                    break;
                default:
                    var status = '<strong>当前状态 ：</strong><span class="text-danger text-xs">禁用中&nbsp;</span>';
            }
            $('#status').html(status);
            $('#introduction').text(data.introduction ? data.introduction : '');
            $('#').text();

            $('#user-info').modal('show');
        });
    </script>
@endsection