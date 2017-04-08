{{--author 郭庆--}}
@extends('admin.layouts.master')
@section('styles')
    <link href="{{asset('admin/css/userandrole.css')}}" rel="stylesheet">
@endsection
{{--展示内容开始--}}
@section('content')

    <div class="btn-toolbar" role="toolbar">
        <h2>用户常规管理</h2>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">用户类型
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list"  key="1"  title="普通用户">普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="2"  title="创业者用户">创业者用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="3" title="投资者用户">投资者用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="4"  title="英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>


        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">已禁用
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="user_role_list" key="5" title="已禁用普通用户" >普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list" key="6" title="已禁用创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="7" title="已禁用投资者用户" >投资者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="8" title="已禁用英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
    </div>

    {{--<img src="{{asset('admin/images/load.gif')}}" class="loading">--}}

    <div class="page-title">
        <h5 id="user_title" class="title text-center"></h5>
    </div>

    {{--表格盒子开始--}}
    <div class="panel" id="data" style="text-align: center"></div>
    {{--表格盒子结束--}}

    {{--修改信息弹出框 --}}
    {{--<div id="user-change" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">--}}
        {{--<div class="modal-dialog modal-sm" id="fabu">--}}
            {{--<div class="modal-content">--}}
                {{--<div id = "" class="modal-header">--}}
                    {{--<button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="text-danger">x</span></button>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}

                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="submit" data-name="" class="btn btn-primary">修改</button>--}}
                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--查看详情弹出框 --}}
    <div id="user-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" id="fabu">
            <div class="modal-content">
                <div id = "" class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="text-danger">x</span></button>
                    <h3>用户详细信息</h3>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><strong>头像</strong> :
                                        {{--<img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}">--}}
                                        <div class="ibox-content" style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                                            <div class="row">
                                                <div id="crop-avatar">
                                                    <div class="avatar-view pic_head_img" title="" style="width: 70px;border: none;border-radius: 0px;box-shadow: none;">
                                                        <img id="headpic" class="img-circle" src="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li><strong>真实姓名 ：</strong><mark><span id="realname"></span></mark></li>
                                    <li><strong>昵称 ：</strong><span id="nickname"></span></li>
                                    <li><strong>电话 ：</strong><ins><span id="phone"></span></ins></li>
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
    <script src="{{ asset('admin/js/classie.js') }}"></script>
    <script src="{{ asset('admin/js/modaleffects.js') }}"></script>
    <script src="{{ asset('JsService/Model/user/userInfo.js') }}"></script>
@endsection