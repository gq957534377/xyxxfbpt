@extends('admin.layouts.master')
<style>
    .loading{z-index:999;position:absolute;display: none;}
    #alert-info{padding-left:10px;}
    table{font-size:14px;}
    .table button{margin-right:15px;}
    #fabu{
        width: 80%;
        height:80%;
    }
</style>
@section('content')
@section('title', '路演管理')
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
    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
@endsection
{{-- 弹出表单结束 --}}
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" id="fabu">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="road_title">发布路演活动</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">路演主题</label>
                            <input type="text" data-title="" class="form-control" id="title" placeholder="roaldShow title...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">主讲人</label>
                            <input type="text" class="form-control" id="speaker" placeholder="Doe">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3">所属机构</label>
                            <div for="field-3">
                                <select class="form-control" id="group" name="group">
                                    <option value="1">英雄会</option>
                                    <option value="2">兄弟会</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-4" class="control-label">路演开始时间：</label>
                            <input type="datetime-local" class="form-control" id="roadShow_time" placeholder="Boston">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-5" class="control-label">缩略图</label>
                            <input type="hidden" class="form-control" id="banner" placeholder="United States">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <img for="field-6" class="control-label" src="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label">路演简述</label>
                            <textarea class="form-control autogrow" id="brief" placeholder="Write something about yourself" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label">路演详情</label>
                    <div class="col-md-12">
                        <textarea id="UE" class="roadShow_describe"></textarea>
                    </div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </div>
            <div class="modal-footer" id="caozuo">
                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                <button type="button" data-name="" class="road_update btn btn-info" id="add_road">发布路演</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<div id="tabs-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-0">
            <ul class="nav nav-tabs nav-justified">
                <li class="">
                    <a href="#home-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Home</span>
                    </a>
                </li>
                <li class="">
                    <a href="#profile-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Many</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#messages-2" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                        <span class="hidden-xs">Brief</span>
                    </a>
                </li>
                <li class="">
                    <a href="#settings-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                        <span class="hidden-xs">Describe</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="home-2">
                    <div>
                        <img src="{{asset('/admin/images/banner.png')}}" style="width: 100%">
                    </div>
                </div>
                <div class="tab-pane" id="profile-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">路演主题</label>
                                <input type="text" id="roadShow_title" class="form-control" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-2" class="control-label">主讲人</label>
                                <input type="text" class="form-control" id="speaker" placeholder="Doe" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-3" class="control-label">路演开始时间</label>
                                <input type="text" class="form-control" id="roadShow_time" placeholder="Address" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-4" class="control-label">所属机构</label>
                                <input type="text" class="form-control" id="group" placeholder="Boston" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">目前参与人数</label>
                                <input type="text" class="form-control" id="population" placeholder="United States" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">发布时间</label>
                                <input type="text" class="form-control" id="time" placeholder="United States" disabled="true">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="messages-2">
                    <div class="row">
                        <div class="col-md-12">
                            <p id="brief" disabled="true"></p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="settings-2">
                    <div class="row">
                        <div class="col-md-12">
                            <p id="roadShow_describe" disabled="true"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">路演发布</button>
<button class="btn btn-primary" data-toggle="modal" data-target="#tabs-modal">Tabs in Modal</button>


<img src="/admin/images/load.gif" class="loading">

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">路演管理</h3>
    </div>
    <div class="panel" id="data"></div>
</div>
@endsection

@section('script')
    <!--alertInfo JS-->
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--引用ajax模块-->
    <script src="JsService/Controller/ajaxController.js" type="text/javascript"></script>
    <script src="JsService/Model/road/roadAjaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/road/roadAjaxSuccessModel.js" type="text/javascript"></script>
    <script src="JsService/Model/road/roadAjaxErrorModel.js" type="text/javascript"></script>
    <!--引用ajax模块-->
    <!--alertInfo end-->
    <script>
//        var chartChange = function (btn,div) {
//            $(this).addClass()
//        }
        /**
         * 发布路演
         * @author 郭庆
         */
         $('#add_road').click(function () {
                $('.modal-title').html('路演信息详情');
                var data = {
                    title:$('#title').val(),
                    speaker:$('#speaker').val(),
                    group:$('#group option:selected').val(),
                    roadShow_time:$('#roadShow_time').val(),
                    banner:$('#banner').val(),
                    brief:$('#brief').val(),
                    roadShow_describe:ue.getContent()
                };
                $.ajax({
                    url: '/road',
                    type:'post',
                    dataType:'json',
                    data:data,
                    success : function (data) {
                        $('.loading').hide();
                        $('#myModal').modal('show');
                        $('.modal-title').html('提示');
                        if (data) {
                            if (data.ServerNo == 200) {
                                $('#fabu').hide();
                                $('#alert-info').html('<p>路演发布成功!</p>');
                            } else {
                                $('#alert-form').hide();
                                $('#alert-info').html('<p>' + data.ResultData + '</p>');
                            }
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>未知的错误</p>');
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                    }
                });
            });
        /**
         * 路演信息修改请求后台
         * @author 郭庆
         *
         * */
        function chage() {
            $('.road_update').click(function () {
                var ajax = new ajaxController();
                var data = {
                    title:$('#title').val(),
                    speaker:$('#speaker').val(),
                    group:$('#group option:selected').val(),
                    roadShow_time:$('#roadShow_time').val(),
                    banner:$('#banner').val(),
                    brief:$('#brief').val(),
                    roadShow_describe:ue.getContent()
                };
                console.log(data);
                $.ajax({
                    url     : '/road/' + $(this).data('name'),
                    type:'put',
                    data:data,
                    before  : ajaxBeforeNoHiddenModel,
                    success : check,
                    error   : ajaxErrorModel
                });

                function check(data){
                    console.log(data);
                    $('.loading').hide();
                    $('#myModal').modal('show');
                    $('.modal-title').html('提示');
                    if (data) {
                        if (data.ServerNo == 200) {
                            $('#alert-info').html('<p>路演活动修改成功!</p>');
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>' + data.ResultData + '</p>');
                        }
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>未知的错误</p>');
                    }
                }
            });
        }
         /**
         *修改路演信息展示旧的信息
         * @author 郭庆
         */
        function updateRoad() {
            $('#fabu').show();
            $('.charge-road').click(function () {
                $('.road_title').html('路演信息修改');
                $('#add_road').remove();
                $('#caozuo').append('<button type="button" data-name="" class="road_update" id="xiugai">修改</button>');
                chage();
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/road_one_info?name=' + $(this).data('name'),
                    before  : ajaxBeforeNoHiddenModel,
                    success : showUpdate,
                    error   : ajaxErrorModel
                });
            });
        }


        // 显示路演信息详情
//        function showInfo() {
//            $('.info').click(function () {
//                $('.modal-title').html('路演信息详情');
//                var ajax = new ajaxController();
//                ajax.ajax({
//                    url     : '/road_one_info?name=' + $(this).data('name'),
//                    before  : ajaxBeforeNoHiddenModel,
//                    success : showInfoList,
//                    error   : ajaxErrorModel
//                });
//            });
//        }
        function showInfo() {
            $('.info').click(function () {
                $('.modal-title').html('路演信息详情');
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/road_one_info?name=' + $(this).data('name'),
                    before  : ajaxBeforeNoHiddenModel,
                    success : showInfoList,
                    error   : ajaxErrorModel
                });
            });
        }


        // 修改个人信息状态
        function modifyStatus() {
            $('.status').click(function () {
                var _this = $(this);
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/road_chage_status?status=' + $(this).data('status') + '&name=' + $(this).data('name'),
                    before  : ajaxBeforeNoHiddenModel,
                    success : checkStatus,
                    error   : ajaxErrorModel
                });

                function checkStatus(data){
                    console.log(data);
                    $('.loading').hide();
                    $('#myModal').modal('show');
                    $('.modal-title').html('提示');
                    if (data) {
                        if (data.ServerNo == 200) {
                            var code = data.ResultData;
                            $('#alert-form').hide();
                            _this.data('status', code);
                            if (_this.children().hasClass("btn-danger")) {
                                _this.children().removeClass("btn-danger").addClass("btn-primary").html('启用');
                            } else if (_this.children().hasClass("btn-primary")) {
                                _this.children().removeClass("btn-primary").addClass("btn-danger").html('禁用');
                            }
                            $('#alert-info').html('<p>数据修改成功!</p>');
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>' + data.ResultData + '</p>');
                        }
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>未知的错误</p>');
                    }
                }
            });
        }

        // 页面加载时触发事件请求分页数据
        var ajax = new ajaxController();
        ajax.ajax({
            url     : '/road_info_page',
            before  : ajaxBeforeModel,
            success : getInfoList,
            error   : ajaxErrorModel,
        });
    </script>
@endsection