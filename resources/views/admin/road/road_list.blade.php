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
{{--发布路演表单--}}
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
                            <input type="text" class="form-control" id="title" placeholder="roadShow title...">
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
                            <input type="datetime-local" class="form-control" id="roadShow_time">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-5" class="control-label">缩略图</label>
                            <img id="clickObj" src="/admin/images/upload.png" style="cursor: pointer;margin-left: 20px;">
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
                <button type="submit" data-name="" class="road_update btn btn-info" id="add_road">发布路演</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
{{--修改路演表单--}}
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">修改路演</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-20" data-name="" role="form" id="yz_xg"  onsubmit="return false">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label class="col-md-2 control-label">路演主题：</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" placeholder="roaldShow title...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="example-email">主讲人：</label>
                        <div class="col-md-10">
                            <input type="text" id="example-email" name="speaker" class="form-control" placeholder="Speaker">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">所属机构：</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="group">
                                <option value="1">英雄会</option>
                                <option value="2">兄弟会</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">路演开始时间：</label>
                        <div class="col-md-10">
                            <input type="datetime-local" class="form-control" name="roadShow_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">缩略图</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control" name="banner">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">路演简述</label>
                        <div class="col-md-10">
                            <textarea class="col-md-12" name="brief"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">路演详情</label>
                        <div class="col-md-10">
                            <textarea id="UE1" name="roadShow_describe"></textarea>
                        </div>
                    </div>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <center><button type="submit" class="btn btn-success m-l-10">修改</button></center>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div style="display: none;">
    <form enctype="multipart/form-data" id="postForm">
        <input type="file" id="rongqi">
    </form>
</div>
<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">路演发布</button>

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
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
    <!--引用ajax模块-->
    <!--alertInfo end-->
    <script>
        $("#clickObj").click(function () {
            $("#rongqi").trigger("click");
        })
        $("#rongqi").change(function () {
            var formData = new FormData($( "#postForm" )[0]);
            $.ajax({
                url: '/' ,
                type: 'post',
                data: formData,
                async: false,
                cache: false,
                processData: false,
                success: function (returndata) {
                    alert(returndata);
                },
                error: function (returndata) {
                }
            });
        })
        {{--修改--}}
        !function($) {
            "use strict";
            var FormValidator = function() {
                //this.$commentForm = $("#commentForm"),
                this.$signupForm = $("#yz_xg");
            };

            //初始化
            FormValidator.prototype.init = function() {
                //插件验证完成执行操作 可以不写
                $.validator.setDefaults({
                    submitHandler: function() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        var data = new FormData();
                        var resul={
                            title:$('input[name=title]').val(),
                            speaker:$('input[name=speaker]').val(),
                            group:$('select[name=group]').val(),
                            roadShow_time:$('input[name=roadShow_time]').val(),
                            brief:$('textarea[name=brief]').val(),
                            roadShow_describe:$('textarea[name=roadShow_describe]').val(),
                        };
                        data.append( "title"      , resul.title);
                        data.append( "speaker"     , resul.speaker);
                        data.append( "group"       ,resul.group);
                        data.append( "roadShow_time"     , resul.roadShow_time);
//                        data.append( "banner"   ,$('#banner').val());
                        data.append( "brief"   , resul.brief);
                        data.append( "describe", resul.roadShow_describe);
                        $('#alert-info').html();
                        console.log(resul);
                        $.ajax({
                            url     : '/road/' + $('input[name=id]').val(),
                            type:'put',
                            data:resul,
                            before  : ajaxBeforeNoHiddenModel,
                            success : check,
                            error   : ajaxErrorModel
                        });
                        function check(data){
                            $('.loading').hide();
                            $('#myModal').modal('show');
                            $('.modal-title').html('提示');
                            if (data) {
                                if (data.ServerNo == 200) {
                                    $('.bs-example-modal-lg').hide();
                                    $('#myModal').show();
                                    $('#alert-info').html('<p>路演活动修改成功!</p>');
                                    list();
                                    $('.modal-backdrop').remove();
                                } else {
                                    $('#alert-form').hide();
                                    $('#alert-info').html('<p>' + data.ResultData + '</p>');
                                    $('#alert-info').html();
                                }
                            } else {
                                $('#alert-form').hide();
                                $('#alert-info').html('<p>未知的错误</p>');
                                $('#alert-info').html();
                            }
                        }
                    }
                });
                // validate signup form on keyup and submit
                this.$signupForm.validate({
                    rules: {
                        title: {
                            required: true
                        },
                        speaker:{
                            required: true,
                        },
                        group:{
                            required: true
                        },
                        roadShow_time:{
                            required: true
                        },
                        brief:{
                            required: true
                        },
                        describe:{
                            required: true,
                        },
                        // start_time:{date:true},
                        // end_time:{date:true},
                        // deadline:{date:true}
                    },
                    //提示信息
                    messages: {
                        title: {
                            required: '请输入路演主题'
                        },
                        speaker:{
                            required: '请输入主讲人'
                        },
                        group:{
                            required: '组织机构必选'
                        },
                        roadShow_time:{
                            required:'请输入路演时间'
                        },
                        brief:{
                            required: '请输入路演简述'
                        },
                        describe:{
                            required: '请输入路演详情'
                        },
                        // start_time:{date:""},
                        // end_time:{date:""},
                        // deadline:{date:""}
                    }
                });

            },
                    //init
                    $.FormValidator = new FormValidator,
                    $.FormValidator.Constructor = FormValidator
        }(window.jQuery),
                function($) {
                    "use strict";
                    $.FormValidator.init()
                }(window.jQuery);

        /**
         * 发布路演
         * @author 郭庆
         */
         $('#add_road').click(function () {
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
                                $('#con-close-modal').hide();
                                $('#myModal').show();
                                $('#alert-info').html('<p>路演发布成功!</p>');
                                list();
                                $('.modal-backdrop').remove();
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
         *修改路演信息展示旧的信息
         * @author 郭庆
         */
        function updateRoad() {
            $('.charge-road').click(function () {
                $('.loading').hide();
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/road/' + $(this).data('name'),
                    before  : ajaxBeforeNoHiddenModel,
                    success : date,
                    error   : ajaxErrorModel
                });
            });
        }

        //展示路演信息详情
        function showInfo() {
            $('.info').click(function () {
                $('#alert-info').html('');
                $('.modal-title').html('路演信息详情');
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/road/' + $(this).data('name'),
                    before  : ajaxBeforeNoHiddenModel,
                    success : showInfoList,
                    error   : ajaxErrorModel
                });
            });
        }


        // 修改路演信息状态
        function modifyStatus() {
            $('.status').click(function () {
                var _this = $(this);
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/road/create?status=' + $(this).data('status') + '&name=' + $(this).data('name'),
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
        function list() {
            var ajax = new ajaxController();
            ajax.ajax({
                url     : '/road_info_page',
                before  : ajaxBeforeModel,
                success : getInfoList,
                error   : ajaxErrorModel,
            });
        }
        list();
    </script>
@endsection
