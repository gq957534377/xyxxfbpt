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
     .uploadify{display:inline-block;}
    .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
    table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
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
            <form data-name="" role="form" id="yz_fb"  onsubmit="return false">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="road_title">发布路演活动</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">路演主题</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="roadShow title...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-2" class="control-label">主讲人</label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="Doe">
                        </div>
                    </div>
                    <div class="col-md-3">
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
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-4" class="control-label">路演开始时间：</label>
                            {{--<input type="datetime-local" class="form-control" id="start_time" name="start_time">--}}
                            <input type="text" class="some_class form-control" value="" id="start_time" name="start_time"/>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-4" class="control-label">路演结束时间：</label>
                            {{--<input type="datetime-local" class="form-control" id="end_time" name="end_time">--}}
                            <input type="text" class="some_class form-control" value="" id="end_time" name="end_time"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-4" class="control-label">截止报名时间：</label>
                            {{--<input type="datetime-local" class="form-control" id="deadline" name="deadline">--}}
                            <input type="text" class="some_class form-control" value="" id="deadline"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-4" class="control-label">限报人数：</label>
                            <input type="text" class="form-control" id="limit" name="limit">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-5" class="control-label">缩略图</label>
                            <input type="text" size="50" style="width: 150px;" class="lg"  id="banner" name="banner" disabled="true">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                            <img src="" id="road_thumb_img" style="max-width: 350px;max-height: 110px;">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="field-4" class="control-label">路演地址：</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label">路演简述</label>
                            <textarea class="form-control autogrow" id="brief" name="brief" placeholder="Write something about yourself" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label">路演详情</label>
                    <div class="col-md-12">
                        <textarea id="UE" name="describe" class="describe"></textarea>
                    </div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">

            </div>
            <div class="modal-footer" id="caozuo">
                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                <button type="submit" data-name="" class="road_update btn btn-primary" id="add_road">发布路演</button>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
{{--修改路演表单--}}
<div class="modal fade bs-example-modal-lg" id="xg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">修改路演</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-20" data-name="" role="form" id="yz_xg"  onsubmit="return false">
                    <input type="hidden" name="id">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">路演主题</label>
                            <input type="text" class="form-control" id="xg_title" name="title" placeholder="roadShow title...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-2" class="control-label">主讲人</label>
                            <input type="text" class="form-control" id="xg_author" name="author" placeholder="Doe">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-3">所属机构</label>
                            <div for="field-3">
                                <select class="form-control" id="xg_group" name="group">
                                    <option value="1">英雄会</option>
                                    <option value="2">兄弟会</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-4" class="control-label">路演开始时间：</label>
                            <input type="text" class="some_class form-control" id="xg_start_time" name="start_time">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-4" class="control-label">路演结束时间：</label>
                            <input type="text" class="some_class form-control" id="xg_end_time" name="end_time">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-4" class="control-label">截止报名时间：</label>
                            <input type="text" class="some_class form-control" id="xg_deadline" name="deadline">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-4" class="control-label">限报人数：</label>
                            <input type="text" class="form-control" id="xg_limit" name="limit">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="field-5" class="control-label">缩略图</label>
                            <input type="text" size="50" style="width: 150px;" class="lg" name="banner" id="charge_banner" disabled="true">
                            <input id="file_charge" name="file_upload" type="file" multiple="true">
                            <img src="" id="charge_thumb_img" style="max-width: 350px;max-height: 110px;">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="field-4" class="control-label">路演地址：</label>
                            <input type="text" class="form-control" id="xg_address" name="address">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label">路演简述</label>
                            <textarea class="form-control autogrow" id="xg_brief" name="brief" placeholder="Write something about yourself" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label">路演详情</label>
                    <div class="col-md-12">
                        <textarea id="UE1" name="describe" class="describe"></textarea>
                    </div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <center><button type="submit" class="btn btn-success m-l-10">修改</button></center>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{--路演详情--}}
<div id="tabs-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">路演主题</label>
                                <input type="text" id="xq_title" class="form-control" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">主讲人</label>
                                <input type="text" class="form-control" id="xq_author" placeholder="Doe" disabled="true">
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
                                <input type="text" class="form-control" id="xq_status" placeholder="Doe" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">路演开始时间</label>
                                    <input type="text" class="some_class form-control " id="xq_start_time" placeholder="start time..." disabled="true">
                                </div>
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">路演结束时间</label>
                                    <input type="text" class="some_class form-control" id="xq_end_time" placeholder="end time..." disabled="true">
                                </div>
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">报名截止</label>
                                    <input type="text" class="some_class form-control" id="xq_deadline" placeholder="end time..." disabled="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-5" class="control-label">路演地址</label>
                                <input type="text" class="form-control" id="xq_adress" placeholder="United States" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">目前参与人数</label>
                                <input type="text" class="form-control" id="xq_population" placeholder="United States" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">限报人数</label>
                                <input type="text" class="form-control" id="xq_limit" placeholder="United States" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">路演信息发布时间</label>
                                <input type="text" class="some_class form-control" id="xq_time" placeholder="United States" disabled="true">
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
</div><!-- /.modal -->
<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">路演发布</button>

<img src="/admin/images/load.gif" class="loading">

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">路演管理</h3>
        <br>
        <button class="btn-primary" onclick="listType(1)">报名中</button>
        <button class="btn-danger" onclick="listType(2)">活动进行中...</button>
        <button class="btn-primary" onclick="listType(3)">往期回顾</button>
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
    <script src="{{url('uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{url('uploadify/uploadify.css')}}">
    <script type="text/javascript">
        <?php $timestamp = time();?>
        $(function() {
            $('#file_upload').uploadify({
                'buttonText':'选择图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}",
                },
                'swf'      : '{{url('uploadify/uploadify.swf')}}',
                'uploader' : '{{url('/upload')}}',
                'onUploadSuccess':function (file,data,response) {
                    var data = JSON.parse(data);
                    $('#banner').val(data.res);
                    $('#road_thumb_img').attr('src',data.res);
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            });
            $('#file_charge').uploadify({
                'buttonText':'修改图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}",
                },
                'swf'      : '{{url('uploadify/uploadify.swf')}}',
                'uploader' : '{{url('/upload')}}',
                'onUploadSuccess':function (file,data,response) {
                    var data = JSON.parse(data);
                    $('#charge_banner').val(data.res);
                    $('#charge_thumb_img').attr('src',data.res);
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            });
        });

    </script>
    <script>
        var list_type = 1;
        function listType(type) {
            list_type = type;
            list(type);
        }
        {{--修改--}}
        !function($) {
            "use strict";
            var FormValidator = function() {
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
                            title:$('#yz_xg').find('input[name=title]').val(),
                            author:$('#yz_xg').find('input[name=author]').val(),
                            group:$('#yz_xg').find('select[name=group]').val(),
                            banner:$('#yz_xg').find('input[name=banner]').val(),
                            end_time:$('#yz_xg').find('input[name=end_time]').val(),
                            deadline:$('#yz_xg').find('input[name=deadline]').val(),
                            address:$('#yz_xg').find('input[name=address]').val(),
                            limit:$('#yz_xg').find('input[name=limit]').val(),
                            start_time:$('#yz_xg').find('input[name=start_time]').val(),
                            brief:$('#yz_xg').find('textarea[name=brief]').val(),
                            describe:ue1.getContent(),
                        };
                        console.log(resul);
                        data.append( "title"      , resul.title);
                        data.append( "author"     , resul.author);
                        data.append( "group"       ,resul.group);
                        data.append( "start_time"     , resul.start_time);
                        data.append( "brief"   , resul.brief);
                        data.append( "describe", resul.describe);
                        data.append( "banner", resul.banner);
                        data.append( "end_time", resul.end_time);
                        data.append( "start_time", resul.start_time);
                        data.append( "address", resul.address);
                        data.append( "limit", resul.limit);
                        $.ajax({
                            url     : '/road/' + $('input[name=id]').val(),
                            type:'put',
                            data:resul,
                            before  : ajaxBeforeNoHiddenModel,
                            success : check,
                            error   : ajaxErrorModel
                        });
                        function check(data){
                            console.log(data);
                            $('.loading').hide();
                            $('#myModal').modal('show');
                            $('#alert-form').html('');
                            $('.modal-title').html('提示');
                            if (data) {
                                if (data.ServerNo == 200) {
                                    $('.bs-example-modal-lg').modal('hide');
                                    $('#alert-info').html('<p>路演活动修改成功!</p>');
                                    list(list_type);
                                } else {
                                    $('#alert-info').html('<p>' + data.ResultData + '</p>');
                                }
                            } else {
                                $('#alert-info').html('<p>未知的错误</p>');
                            }
                        }
                    }
                });
                this.$signupForm.validate({
                    rules: {
                        title: {
                            required: true,
                        },
                        end_time: {
                            required: true
                        },
                        deadline: {
                            required: true
                        },
                        address: {
                            required: true
                        },
                        limit: {
                            required: true
                        },
                        author:{
                            required: true,
                        },
                        group:{
                            required: true
                        },
                        start_time:{
                            required: true
                        },
                        brief:{
                            required: true
                        },
                        describe:{
                            required: true,
                        },
                        banner:{
                            required: true,
                        }
                    },
                    //提示信息
                    messages: {
                        title: {
                            required: '请输入路演主题'
                        },
                        author:{
                            required: '请输入主讲人'
                        },
                        group:{
                            required: '组织机构必选'
                        },
                        start_time:{
                            required:'请输入路演时间'
                        },
                        brief:{
                            required: '请输入路演简述'
                        },
                        end_time:{
                            required: '请输入路演结束时间'
                        },
                        deadline:{
                            required: '请输入报名截止日期'
                        },
                        address:{
                            required: '请输入路演地址'
                        },
                        limit:{
                            required: '请输入报名限制人数'
                        },
                        describe:{
                            required: '请输入路演详情'
                        },
                        banner:{
                            required: '缩略图不能为空'
                        }
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
        //发布
        !function($) {
            "use strict";
            var FormValidator = function() {
                this.$signupForm = $("#yz_fb");
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
                            author:$('input[name=author]').val(),
                            group:$('select[name=group]').val(),
                            banner:$('input[name=banner]').val(),
                            end_time:$('input[name=end_time]').val(),
                            deadline:$('input[name=deadline]').val(),
                            address:$('input[name=address]').val(),
                            limit:$('input[name=limit]').val(),
                            start_time:$('input[name=start_time]').val(),
                            brief:$('textarea[name=brief]').val(),
                            describe:$('textarea[name=describe]').val(),
                        };
                        console.log(resul);
                        data.append( "title"      , resul.title);
                        data.append( "author"     , resul.author);
                        data.append( "group"       ,resul.group);
                        data.append( "start_time"     , resul.start_time);
                        data.append( "brief"   , resul.brief);
                        data.append( "describe", resul.describe);
                        data.append( "banner", resul.banner);
                        data.append( "end_time", resul.end_time);
                        data.append( "start_time", resul.start_time);
                        data.append( "address", resul.address);
                        data.append( "limit", resul.limit);
                        $('#alert-info').html();
                        console.log(resul);
                        $.ajax({
                            url     : '/road',
                            type:'post',
                            data:resul,
                            before  : ajaxBeforeNoHiddenModel,
                            success : check,
                            error   : ajaxErrorModel
                        });
                        function check(data){
                            $('.loading').hide();
                            $('#myModal').modal('show');
                            $('#alert-form').html('');
                            $('.modal-title').html('提示');
                            console.log(data);
                            if (data) {
                                if (data.ServerNo == 200) {
                                    $('#con-close-modal').modal('hide');
                                    $('#alert-info').html('<p>路演发布成功!</p>');
                                    list(list_type);

                                } else {
                                    $('#alert-info').html('<p>' + data.ResultData + '</p>');
                                }
                            } else {
                                $('#alert-info').html('<p>未知的错误</p>');
                            }
                        }
                        $('#yz_fb').find('input[name=title]').val('');
                        $('#yz_fb').find('input[name=end_time]').val('');
                        $('#yz_fb').find('input[name=deadline]').val('');
                        $('#yz_fb').find('input[name=address]').val('');
                        $('#yz_fb').find('input[name=limit]').val('');
                        $('#yz_fb').find('input[name=author]').val('');
                        $('#yz_fb').find('input[name=banner]').val('');
                        $('#road_thumb_img').attr('src','');
                        $('#yz_fb').find('select[name=group]').val('');
                        $('#yz_fb').find('input[name=start_time]').val('');
                        $('#yz_fb').find('textarea[name=brief]').val('');
                        ue.setContent('');
                    }
                });
                this.$signupForm.validate({
                    rules: {
                        title: {
                            required: true,
                        },
                        end_time: {
                            required: true
                        },
                        deadline: {
                            required: true
                        },
                        address: {
                            required: true
                        },
                        limit: {
                            required: true
                        },
                        author:{
                            required: true,
                        },
                        group:{
                            required: true
                        },
                        start_time:{
                            required: true
                        },
                        brief:{
                            required: true
                        },
                        describe:{
                            required: true,
                        },
                        banner:{
                            required: true,
                        }
                    },
                    //提示信息
                    messages: {
                        title: {
                            required: '请输入路演主题'
                        },
                        author:{
                            required: '请输入主讲人'
                        },
                        group:{
                            required: '组织机构必选'
                        },
                        start_time:{
                            required:'请输入路演时间'
                        },
                        brief:{
                            required: '请输入路演简述'
                        },
                        end_time:{
                            required: '请输入路演结束时间'
                        },
                        deadline:{
                            required: '请输入报名截止日期'
                        },
                        address:{
                            required: '请输入路演地址'
                        },
                        limit:{
                            required: '请输入报名限制人数'
                        },
                        describe:{
                            required: '请输入路演详情'
                        },
                        banner:{
                            required: '缩略图不能为空'
                        }
                    }
                });

            },
                    $.FormValidator = new FormValidator,
                    $.FormValidator.Constructor = FormValidator
        }(window.jQuery),
                function($) {
                    "use strict";
                    $.FormValidator.init()
                }(window.jQuery);

         //修改路演信息展示旧的信息
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
                            list(list_type);
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
        function list(type) {
            var ajax = new ajaxController();
            ajax.ajax({
                url     : '/road_info_page?type='+type,
                before  : ajaxBeforeModel,
                success : getInfoList,
                error   : ajaxErrorModel,
            });
        }
        list(list_type);
    </script>
@endsection
