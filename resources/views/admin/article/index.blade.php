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
@section('title', '内容管理')
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
{{--发布文章表单--}}
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" id="fabu">
        <div class="modal-content">
            <form data-name="" role="form" id="yz_fb"  onsubmit="return false">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="title">文章发布</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="field-3">文章类型</label>
                                <div for="field-3">
                                    <select class="form-control" id="type" name="type">
                                        <option value="1">市场</option>
                                        <option value="2">政策发布</option>
                                        <option value="3">用户来搞</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章标题</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="article title...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">缩略图</label>
                                <input type="text" size="50" style="width: 150px;" class="lg"  id="banner" name="banner" disabled="true">
                                <input id="file_upload" name="file_upload" type="file" multiple="true">
                                <img src="" id="article_thumb_img" style="max-width: 350px;max-height: 110px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章来源</label>
                                <input type="text" class="form-control" id="source" name="source" placeholder="article source...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label">文章简述</label>
                                <textarea class="form-control autogrow" id="brief" name="brief" placeholder="Write something about your article" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 control-label">文章详情</label>
                        <div class="col-md-12">
                            <textarea id="UE" name="describe" class="describe"></textarea>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                </div>
                <div class="modal-footer" id="caozuo">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="submit" data-name="" class="article_update btn btn-primary" id="add_article">发布</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
{{--修改文章表单--}}
<div class="modal fade bs-example-modal-lg" id="xg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">修改文章</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-20" data-name="" role="form" id="yz_xg"  onsubmit="return false">
                    <input name="id" type="hidden">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="field-3">文章类型</label>
                                <div for="field-3">
                                    <select class="form-control" id="xg_type" name="type">
                                        <option value="1">市场</option>
                                        <option value="2">政策发布</option>
                                        <option value="3">用户来搞</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9" style="margin-left: 68px;">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章标题</label>
                                <input type="text" class="form-control" id="xg_title" name="title" placeholder="article title...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">缩略图</label>
                                <input type="text" size="50" style="width: 150px;" class="lg" name="banner" id="charge_banner" disabled="true">
                                <input id="file_charge" name="file_upload" type="file" multiple="true">
                                <img src="" id="charge_thumb_img" style="max-width: 350px;max-height: 110px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章来源</label>
                                <input type="text" class="form-control" id="xg_source" name="source" placeholder="article source...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label">文章简述</label>
                                <textarea class="form-control autogrow" id="xg_brief" name="brief" placeholder="Write something about your article" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 control-label">文章详情</label>
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
{{--文章详情--}}
<div id="tabs-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-0">
            <ul class="nav nav-tabs nav-justified">
                <li class="">
                    <a href="#home-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">缩略图</span>
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
                                <label for="field-1" class="control-label">文章标题</label>
                                <input type="text" id="xq_title" class="form-control" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章类型</label>
                                <input type="text" id="xq_type" class="form-control" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">发布人</label>
                                <input type="text" class="form-control" id="xq_author" disabled="true">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">文章状态</label>
                                <input type="text" class="form-control" id="xq_status" placeholder="Doe" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                             <label for="field-3" class="control-label">文章发布时间</label>
                             <input type="text" class="some_class form-control " id="xq_time" placeholder="time..." disabled="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-5" class="control-label">活动来源</label>
                                <input type="text" class="form-control" id="xq_source" placeholder="United States" disabled="true">
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

<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">文章发布</button>
<img src="/admin/images/load.gif" class="loading">

<div class="wraper container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-md-4">
                <div class="col-md-6"><h3 class="title">文章管理</h3></div>
                <div class="col-md-6">
                    <button data-name="2" class="btn-default user">用户文章</button>
                    <button data-name="1" class="btn-success user">管理员文章</button>
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="xz_type" name="xz_type">
                    <option value="1">市场</option>
                    <option value="2">政策</option>
                    <option value="3">用户来稿</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn-primary" id="chakan">查看</button>
            </div>
        </div>


        <br>
        <button class="btn-success status1" data-name="1">已发布</button>
        <button class="btn-default status1" data-name="2">待审核...</button>
        <button class="btn-default status1" data-name="3">已下架</button>
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
    <script src="JsService/Model/article/articleAjaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/article/articleAjaxSuccessModel.js" type="text/javascript"></script>
    <script src="JsService/Model/article/articleAjaxErrorModel.js" type="text/javascript"></script>
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
        //发布文章-图片上传
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
                    $('#article_thumb_img').attr('src',data.res);
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            });
            //修改文章-图片上传
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
        var list_type = null;
        var list_status = 1;
        var list_user = 1;
        //列表文章类型设置
        function listType(type,status,user) {
            list_type = type;
            list_status = status;
            list_user = user;
            list(type,status,user);
        }
        //分类查看数据
        $('#chakan').click(function(){
            if (list_user == 1){
                listType($('#xz_type').val(),list_status,list_user);
            }
        });

        //用户选择
        $('.user').off('click').on('click',function () {
            list_type = null;
            $('.user').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');
            list_user = $(this).data('name');
            listType(list_type,list_status,list_user);
        });

        //状态选择
        $('.status1').off('click').on('click',function () {
            if (list_user == 2){list_type = null;}
            $('.status1').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');
            list_status = $(this).data('name');
            listType(list_type,list_status,list_user);
        });
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
                            type:$('#yz_xg').find('select[name=type]').val(),
                            title:$('#yz_xg').find('input[name=title]').val(),
                            banner:$('#yz_xg').find('input[name=banner]').val(),
                            source:$('#yz_xg').find('input[name=source]').val(),
                            brief:$('#yz_xg').find('textarea[name=brief]').val(),
                            describe:ue1.getContent(),
                        };
                        console.log(resul);
                        data.append( "type"      , resul.type);
                        data.append( "title"      , resul.title);
                        data.append( "brief"   , resul.brief);
                        data.append( "describe", resul.describe);
                        data.append( "banner", resul.banner);
                        data.append( "source", resul.source);
                        $.ajax({
                            url     : '/article/' + $('input[name=id]').val(),
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
                                if (data.StatusCode == 200) {
                                    $('.bs-example-modal-lg').modal('hide');
                                    $('#alert-info').html('<p>文章修改成功!</p>');
                                    list(resul.type,1);
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
                        type: {
                            required: true,
                        },
                        title: {
                            required: true,
                        },
                        source: {
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
                        type: {
                            required: '请输入文章类型'
                        },
                        title: {
                            required: '请输入文章标题'
                        },
                        brief:{
                            required: '请输入文章简述'
                        },
                        source:{
                            required: '请输入文章来源'
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
                            type:$('select[name=type]').val(),
                            title:$('input[name=title]').val(),
                            banner:$('input[name=banner]').val(),
                            source:$('input[name=source]').val(),
                            brief:$('textarea[name=brief]').val(),
                            describe:$('textarea[name=describe]').val(),
                        };
                        console.log(resul);
                        data.append( "type"      , resul.type);
                        data.append( "title"      , resul.title);
                        data.append( "brief"   , resul.brief);
                        data.append( "describe", resul.describe);
                        data.append( "banner", resul.banner);
                        data.append( "source", resul.source);
                        $('#alert-info').html();
                        $.ajax({
                            url     : '/article',
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
                                if (data.StatusCode == 200) {
                                    $('#con-close-modal').modal('hide');
                                    $('#alert-info').html('<p>文章发布成功!</p>');
                                    $('#yz_fb').find('input[name=title]').val('');
                                    $('#yz_fb').find('input[name=source]').val('');
                                    $('#yz_fb').find('input[name=banner]').val('');
                                    $('#article_thumb_img').attr('src','');
                                    $('#yz_fb').find('textarea[name=brief]').val('');
                                    ue.setContent('');
                                    list(resul.type,1);
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
                        type: {
                            required: true,
                        },
                        title: {
                            required: true,
                            maxlength:50
                        },
                        source: {
                            required: true,
                            maxlength:50
                        },
                        brief:{
                            required: true,
                            rangelength:[40,100]
                        },
                        describe:{
                            required: true,
                            minlength:50
                        },
                        banner:{
                            required: true,
                        }
                    },
                    //提示信息
                    messages: {
                        type: {
                            required: '请选择文章类型',
                        },
                        title: {
                            required: '请输入文章标题',
                            maxlength:'标题最多50个字符'
                        },
                        brief:{
                            required: '请输入文章简述',
                            rangelength:'请输入40-100个字符作为简述'
                        },
                        source:{
                            required: '请输入文章来源',
                            maxlength:'来源最多50个字符'
                        },
                        describe:{
                            required: '请输入文章详情',
                            minlength:'详情长度最少50个字符'
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

        //修改文章信息展示旧的信息
        function updateArticle() {
            $('.charge-road').click(function () {
                $('.loading').hide();
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/article/' + $(this).data('name') +'?user=' + list_user,
                    before  : ajaxBeforeNoHiddenModel,
                    success : date,
                    error   : ajaxErrorModel
                });
            });
        }

        //展示文章信息详情
        function showInfo() {
            $('.info').click(function () {
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/article/' + $(this).data('name') + '?user=' + list_user,
                    before  : ajaxBeforeNoHiddenModel,
                    success : showInfoList,
                    error   : ajaxErrorModel
                });
            });
        }

        // 修改文章信息状态
        function modifyStatus() {
            $('.status').click(function () {
                var _this = $(this);
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/article/'+ $(this).data('name') + '/edit/?status=' + $(this).data('status')+'&user='+list_user,
                    before  : ajaxBeforeNoHiddenModel,
                    success : checkStatus,
                    error   : ajaxErrorModel
                });

                function checkStatus(data){
                    $('.loading').hide();
                    $('#myModal').modal('show');
                    $('.modal-title').html('提示');
                    if (data) {
                        if (data.StatusCode == 200) {
                            var code = data.ResultData;
                            $('#alert-form').hide();
                            _this.data('status', code);
                            if (_this.children().hasClass("btn-danger")) {
                                _this.children().removeClass("btn-danger").addClass("btn-primary").html('启用');
                            } else if (_this.children().hasClass("btn-primary")) {
                                _this.children().removeClass("btn-primary").addClass("btn-danger").html('禁用');
                            }
                            $('#alert-info').html('<p>状态修改成功!</p>');
                            list(list_type,list_status);
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>状态修改失败！</p>');
                        }
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>未知的错误</p>');
                    }
                }
            });
        }

        // 页面加载时触发事件请求分页数据
        function list(type,status,user) {
            var ajax = new ajaxController();
            ajax.ajax({
                url     : '/article/create?type='+type+'&status='+status+'&user='+user,
                before  : ajaxBeforeModel,
                success : getInfoList,
                error   : ajaxErrorModel,
            });
        }
        list(list_type,list_status,list_user);
    </script>
@endsection
