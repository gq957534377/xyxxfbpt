@extends('admin.layouts.admin')
@section('content')
@section('styles')
    <link href="{{asset('admin/css/datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/animate.min.css')}}" rel="stylesheet">
@endsection
@section('title', '英雄会')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="training" class="form-horizontal p-20" role="form" action="/add_training" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-md-2 control-label">创业技术培训名称：</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" id="title" placeholder="请填写创业技术培训名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="example-email">组织机构名称：</label>
                        <div class="col-md-10">
                            <input type="text" id="groupname" name="groupname" class="form-control"
                                   placeholder="请填写组织机构名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">培训开始时间：</label>
                        <div class="col-md-10">
                            <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                                   name="start_time" id="start_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">培训结束时间：</label>
                        <div class="col-md-10">
                            <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control" name="stop_time" id="stop_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">报名截止时间：</label>
                        <div class="col-md-10">
                            <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control" name="deadline" id="deadline">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">缩略图：</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control" name="banner" id="banner">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">培训详情</label>
                        <div class="col-md-10">
                            <textarea id="UE" name="describe"></textarea>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="btn btn-success m-l-10">发布</button>
                    </center>
                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div> <!-- End row -->
@endsection
@section('script')
    {{--时间选择器js--}}
    <script src="{{asset('admin/js/form-advanced-demo.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/js/cropper.min.js')}}"></script>
    {{--验证信息为空引入js--}}
    <script src="{{asset('admin/js/jquery.validate.min.js')}}"></script>
    {{--验证信息开始--}}
    <script>
        !function ($) {
            "use strict";

            var FormValidator = function () {
                this.$training = $("#training");
            };

            //初始化
            FormValidator.prototype.init = function () {

                // validate the comment form when it is submitted
                // this.$commentForm.validate();

                // validate signup form on keyup and submit
                this.$training.validate({
                    rules: {
                        title: {
                            required: true,
                        },
                        groupname: {
                            required: true,
                        },
                        describe: {
                            required: true,
                            minlength: 200,
                        },
                        banner: {
                            required: true,
                        },
                        start_time: {
                            required: true,
                            date:true,
                        },
                        stop_time: {
                            required: true,
                            date:true,
                        },
                        deadline: {
                            required: true,
                            date:true,
                        }
                    },
                    //提示信息
                    messages: {
                        title: {
                            required: "请输入一个名称",
                        },
                        groupname: {
                            required: "请输入组织或机构名称",
                        },
                        describe: {
                            required: "请输入培训详情(至少200字以上)",
                            minlength: "抱歉，您的字数不够，请尽量详细描述培训详情",
                        },
                        start_time: {
                            required: "请输入培训开始时间",
                        },
                        stop_time: {
                            required: "请输入培训结束时间",
                        },
                        deadline: {
                            required: "请输入培训报名截止时间",
                        },
                        banner: "请至少上传一张图片"
                    }
                });
            },
                    //init
                    $.FormValidator = new FormValidator, $.FormValidator.Constructor = FormValidator
        }(window.jQuery),


//initializing
                function ($) {
                    "use strict";
                    $.FormValidator.init()
                }(window.jQuery);
    </script>
@endsection