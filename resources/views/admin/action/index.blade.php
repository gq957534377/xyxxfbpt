@extends('admin.layouts.master')
@section('style')
    <style>
        .loading {
            z-index: 999;
            position: absolute;
            display: none;
        }

        #alert-info {
            padding-left: 10px;
        }

        table {
            font-size: 14px;
        }

        .table button {
            margin-right: 15px;
        }

        .btn {
            border-radius: 7px;
            padding: 6px 16px;
        }

    </style>
    <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
@endsection
@section('content')
@section('title', '活动管理')
{{-- 弹出表单开始 --}}
<!--继承组件-->
<!--替换按钮ID-->
@section('form-id', 'myModal')
<!--定义弹出表单ID-->
@section('form-title', '详细信息：')
<!--定义弹出内容-->
@section('form-body')
    <div class="row" id="alert-form"></div>
    <div id="alert-info"></div>
@endsection
<!--定义底部按钮-->
@section('form-footer')
    <button type="button" class="btn btn-info" data-dismiss="modal">关闭</button>
@endsection
{{-- 弹出表单结束 --}}
{{--活动详情--}}
<div id="tabs-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-0">
            <ul class="nav nav-tabs nav-justified">
                <li class="">
                    <a href="#home-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">宣传图</span>
                    </a>
                </li>
                <li class="">
                    <a href="#profile-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">主信息</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#messages-2" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                        <span class="hidden-xs">简述</span>
                    </a>
                </li>
                <li class="">
                    <a href="#settings-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                        <span class="hidden-xs">详情</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="home-2">
                    <div>
                        <img src="/admin/images/banner.png" id="xq_banner" style="max-width: 100%;max-height: 500px;">
                    </div>
                </div>
                <div class="tab-pane" id="profile-2">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="field-1" class="control-label">活动主题</label>
                                <input type="text" id="xq_title" class="form-control" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-1" class="control-label">活动类型</label>
                                <input type="text" id="xq_type" class="form-control" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">负责人</label>
                                <input type="text" class="form-control" id="xq_author" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">所属机构</label>
                                <input type="text" class="form-control" id="xq_group" placeholder="Doe" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">活动状态</label>
                                <input type="text" class="form-control" id="xq_status" placeholder="Doe"
                                       disabled="true">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">活动开始时间</label>
                                    <input type="text" class="some_class form-control " id="xq_start_time"
                                           placeholder="start time..." disabled="true">
                                </div>
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">活动结束时间</label>
                                    <input type="text" class="some_class form-control" id="xq_end_time"
                                           placeholder="end time..." disabled="true">
                                </div>
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">报名截止</label>
                                    <input type="text" class="some_class form-control" id="xq_deadline"
                                           placeholder="end time..." disabled="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-5" class="control-label">活动地址</label>
                                <input type="text" class="form-control" id="xq_address" placeholder="United States"
                                       disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">目前参与人数</label>
                                <input type="text" class="form-control" id="xq_population" placeholder="United States"
                                       disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">限报人数</label>
                                <input type="text" class="form-control" id="xq_limit" placeholder="United States"
                                       disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">活动信息发布时间</label>
                                <input type="text" class="some_class form-control" id="xq_time"
                                       placeholder="United States" disabled="true">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="messages-2">
                    <div class="row">
                        <div class="col-md-12">
                            <p id="xq_brief" disabled="true"></p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="settings-2">
                    <div class="row">
                        <div class="col-md-12">
                            <p id="xq_describe" disabled="true"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<h3 class="title">@if($type == 1)文娱活动管理@elseif($type == 2)学术活动管理@else竞赛活动管理@endif</h3>
{{--<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">发布活动</button>--}}
<a href="/action_add?list={{$type}}">
    <button class="btn btn-primary" id="add">发布活动</button>
</a>
<img src="/admin/images/load.gif" class="loading">
<div class="page-title">
    <button class="btn btn-success status1" data-status="1">报名中</button>
    <button class="btn btn-default status1" data-status="2">活动进行中...</button>
    <button class="btn btn-default status1" data-status="3">往期回顾</button>
    <button class="btn btn-default status1" data-status="4">回收站</button>
    <button class="btn btn-default status1" data-status="5">报名截止，等待开始</button>
</div>
<div class="panel" id="data"></div>
@include('admin.public.banner')
@endsection
@section('script')
    <!--引用ajax模块-->
    <script src="{{asset('JsService/Controller/ajaxController.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/ajaxBeforeModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/action/actionAjaxSuccessModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/ajaxErrorModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/pageList.js') }}" type="text/javascript"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
    {{--提示框--}}
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <script src="{{asset('admin/js/sweet-alert.min.js')}}"></script>
    <script type="text/javascript">
        {{--全局变量的设置--}}

        //全局变量参数的设置
        var token = $('meta[name="csrf-token"]').attr('content');
        var list_type = "{{$type}}";//活动类型：1：路演 2：大赛 3：学习
        var list_status = 1;//活动状态：1：报名中 2：进行中 3：往期回顾 4：回收站 5：报名截止，等待开始
        var college_type = 4;

        function updates() {

        }

        function groups() {
            var result;
            $.ajax({
                url: '/web_admins/create?type=23',
                type: 'get',
                async: false,
                success: function (data) {
                    result = data;
                },
                error: function () {
                    result = '获取机构列表失败'
                }
            });
            return result;
        }

        groupMessage = groups();
        function group(id) {
            var result = '个人';
            $.each(groupMessage, function (i, v) {

                if (v.id == id) {
                    result = v.name;
                }
            });
            return result;
        }

        //活动类型展示
        function type(type) {
            var res;
            switch (type) {
                case 1:
                    res = '文娱活动';
                    break;
                case 2:
                    res = '学术活动';
                    break;
                case 3:
                    res = '竞赛活动';
                    break;
                default:
                    break;
            }

            return res;
        }
        @if($type == 3)
        //活动类型选择
        $('#college').change(function () {
            college_type = $(this).val();
            list(3, list_status);
        });
        @endif
        //活动状态选择
        $('.status1').off('click').on('click', function () {
            $('.status1').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');
            $('#list_title').html($(this).html());
            listType(list_type, $(this).data('status'));
        });

        //列表活动类型设置
        function listType(type, status) {
            list_type = type;
            list_status = status;
            list(type, status);
        }

        //分类查看数据
        $('#xz_type').change(function () {
            list(3, list_status);
        });

        function initAlert() {
            !function ($) {
                "use strict";

                var SweetAlert = function () {
                };

                //examples
                SweetAlert.prototype.init = function () {

                    //禁用弹出确认框
                    $('.status').click(function () {

                        var guid = $(this).data('name');
                        var status = $(this).data('status');
                        var statusMessage;
                        if (status != 1) {
                            statusMessage = "禁用";
                        } else {
                            statusMessage = "启用";
                        }

                        //获取tr节点
                        var tr = $(this).parent().parent();


                        swal({
                            title: "确定要" + statusMessage + "?",
                            text: "当前操作" + statusMessage + "该活动的展示!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: statusMessage,
                            cancelButtonText: "取消",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }, function (isConfirm) {
                            if (isConfirm) {
                                //发送请求
                                var url = '/action/' + guid + '/edit/?status=' + status + '&list=' + list_type;
                                $.ajax({
                                    url: url,
                                    success: function (data) {
                                        if (data.StatusCode != '200') {
                                            swal(data.ResultData, statusMessage + '失败', "danger");
                                        } else {
                                            swal(data.ResultData, '成功' + statusMessage + '该活动', "success");
                                            tr.remove();
                                        }
                                    },
                                });
                            } else {
                                swal("已取消！", "没有做任何修改！", "error");
                            }
                        });
                    });
                },
                        //init
                        $.SweetAlert = new SweetAlert,
                        $.SweetAlert.Constructor = SweetAlert
            }(window.jQuery),

//initializing
                    function ($) {
                        "use strict";
                        $.SweetAlert.init()
                    }(window.jQuery);
        }

        //展示活动信息详情
        function showInfo() {
            $('.info').click(function () {
                var ajax = new ajaxController();
                var url = '/action/' + $(this).data('name') + '?list=' + list_type;
                ajax.ajax({
                    url: url,
                    before: ajaxBeforeNoHiddenModel,
                    success: showInfoList,
                    error: ajaxErrorModel
                });
            });
        }

        //查看报名情况
        function checkAction() {
            $('.bm').click(function () {
                if ($(this).data('num') === 0) {
                    $('#myModal').modal('show');
                    $('#alert-info').html('<p>暂无报名情况</p>');
                } else {
                    var url = '/action_order?id=' + $(this).data('name') + '&list=' + list_type;
                    window.location.href = url;
                }
            });
        }

        // 页面加载时触发事件请求分页数据
        function list(type, status) {
            var ajax = new ajaxController();
            var url = '/action/create?type=' + type + '&status=' + status + '&college_type=' + college_type;
            ajax.ajax({
                url: url,
                before: ajaxBeforeModel,
                success: getInfoList,
                error: ajaxErrorModel,
            });
        }
        list(list_type, list_status);
    </script>
@endsection
