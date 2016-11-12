﻿@extends('admin.layouts.master')
@section('styles')
    <style>
        .modal-content {
            width: 690px;
        }
    </style>
@endsection


@section('content')
    {{-- 添加培训弹出表单开始 --}}
    <button style="float: right;" class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">添加创业培训项目<i
                class="fa fa-plus"></i></button>
    <!--继承组件-->
    <!--替换按钮ID-->
@section('form-id', 'con-close-modal')
<!--定义弹出表单ID-->
@section('form-title', '添加创业项目培训')
<!--定义弹出内容-->
@section('form-body')
    <form method="post" action="{{url('training')}}">
        {{csrf_field()}}

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-1" class="control-label">创业技术培训名称：</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="请填写创业技术培训名称">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-2" class="control-label">组织机构名称：</label>
                    <input type="text" id="groupname" name="groupname" class="form-control" placeholder="请填写组织机构名称">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-4" class="control-label">培训开始时间：</label>
                    <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                           name="start_time" id="start_time">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-5" class="control-label">培训结束时间：</label>
                    <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                           name="stop_time" id="stop_time">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-6" class="control-label">报名截止时间：</label>
                    <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                           name="deadline" id="deadline">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-6" class="control-label">缩略图：</label>
                    <input type="file" class="form-control" name="banner" id="banner">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group no-margin">
                    <label for="field-7" class="control-label">创业项目培训详情</label>
                    <textarea class="" placeholder="请详细描述创业项目培训内容" id="UE" name="describe">请详细描述创业项目培训内容</textarea>
                </div>
            </div>
        </div>
        @endsection
    <!--定义底部按钮-->
        @section('form-footer')
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-info">发布</button>
            </div>
    </form>
@endsection
{{-- 添加培训弹出表单结束 --}}




@section('title', '用户列表')
{{-- 弹出表单开始 --}}
<!--继承组件-->
<!--替换按钮ID-->
@section('form-id', 'con-close-modal')
<!--定义弹出表单ID-->
@section('form-title', '详细信息：')
<!--定义弹出内容-->
@section('form-body')
    <div class="row" id="alert-form"></div>
    <div id="alert-info"></div>
@endsection
<!--定义底部按钮-->
@section('form-footer')
    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
    <button type="submit" class="btn btn-info">保存修改</button>
@endsection
{{-- 弹出表单结束 --}}




<img src="{{asset('/admin/images/load.gif')}}" class="loading">

<div class="wraper container-fluid">
    <div id="data"></div>
</div>
@endsection





@section('script')
    <!--alertInfo JS-->
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--引用ajax模块-->
    <script src="JsService/Controller/ajaxController.js" type="text/javascript"></script>
    <script src="JsService/Model/training/TrainingAjaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/training/TrainingAjaxSuccessModel.js" type="text/javascript"></script>
    <script src="JsService/Model/training/TrainingAjaxErrorModel.js" type="text/javascript"></script>
    <!--引用ajax模块-->
    <!--alertInfo end-->
    <script>
        // 显示个人信息详情
        function showInfo() {
            $('.info').click(function () {
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/training_show_one?name=' + $(this).data('name'),
                    before  : ajaxBeforeNoHiddenModel,
                    success : showOneInfo,
                    error   : ajaxErrorModel
                });
            });
        }

        // 页面加载时触发事件请求分页数据
        var ajax = new ajaxController();
        ajax.ajax({
            url     : '/training',
            before  : ajaxBeforeModel,
            success : getInfoList,
            error   : ajaxErrorModel,
        });
    </script>
@endsection