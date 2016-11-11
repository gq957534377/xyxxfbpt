@extends('admin.layouts.master')
<style>
    .loading{z-index:999;position:absolute;display: none;}
    #alert-error-msg{padding-left:10px;}
</style>
@section('content')
@section('title', '路演列表')
{{-- 弹出表单开始 --}}
<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">发布路演</button>
<!--继承组件-->
<!--替换按钮ID-->
@section('form-id', 'con-close-modal')
<!--定义弹出表单ID-->
@section('form-title', '发布路演')
<!--定义弹出内容-->
@section('form-body')
    <form>
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

@endsection
<!--定义底部按钮-->
@section('form-footer')
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
        <button type="button" onclick="add()" class="btn btn-info">发布</button>
    </div>
    </form>
@endsection
{{-- 弹出表单结束 --}}
<img src="{{asset('/admin/images/load.gif')}}" class="loading">
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">路演活动管理</h3>
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
        function add() {
            var data = {
                title:$('#title').val(),
                speaker:$('#speaker').val(),
                group:$('#group option:selected').val(),
                roadShow_time:$('#roadShow_time').val(),
                banner:$('#banner').val(),
                brief:$('#brief').val(),
                roadShow_describe:$('.roadShow_describe').val()
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/road',
                type: 'post',
                dataType:'json',
                data:data,
                success: function (data) {
                    $('.loading').hide();
                    $('#alert-ok-msg').show();

                    $('#con-close-modal').modal('show');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
//                    var number = XMLHttpRequest.status;
//                    var info = "系统错误：错误号为" + number + ",数据异常!";
//                    $('#con-close-modal').modal('show');
//                    $('.loading').hide();
//                    $('#alert-ok-msg').hide();
//                    $('#alert-error-msg').html('<p>' + info + '</p>');
                },
            });
        }

        // 显示路演信息详情
        function showInfo() {
            $('.info').click(function () {
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
                    $('.loading').hide();
                    $('#con-close-modal').modal('show');
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
                            $('#alert-info').html('<p>状态修改成功!</p>');
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