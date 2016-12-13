@extends('admin.layouts.master')
@section('style')
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
<link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
<link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
    @endsection
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
                        <div class="col-md-12">
                            <div class="form-group mar-b30">
                                <label for="inputfile" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>缩略图</label>
                                <input type="hidden" name="banner">
                                <div class="col-md-5">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div id="crop-avatar" class="col-md-6">
                                                <div class="avatar-view" title="">
                                                    <img src="{{ asset('home/img/upload-card.png') }}" id="article_thumb_img" alt="Logo" style="width: 200px;height: 150px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
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
                        <div class="col-md-12">
                            <div class="form-group mar-b30">
                                <label for="inputfile" class="col-md-2 pad-cr"><span class="form-star">*</span>缩略图</label>
                                <input type="hidden" name="banner">
                                <div class="col-md-10">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div id="crop-avatar2" class="col-md-12">
                                                <div class="avatar-view" title="">
                                                    <img src="{{ asset('home/img/upload-card.png') }}" id="charge_thumb_img" alt="Logo" style="width: 200px;height: 150px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
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

                    <center><button type="submit" class="btn btn-success m-l-10">修改</button></center>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-0 b-0">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="panel-title">请填写否决理由</h3>
                </div>
                <div class="panel-body">
                    <textarea id = "reason" style="width: 100%;"></textarea><br><br>
                    <center><button class="btn btn-success status" id="pass_form">确定</button></center>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--新的详情页--}}
<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;width: 80%;margin-left: 10%">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <center><h2 id="xq_title"></h2></center>
                <br>
                <center><h6 class="modal-title" id="xq_time_author"></h6></center>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <center><img id="xq_banner" src=""></center>
                        </div>
                    </div>
                    <center><div class="modal-header col-md-12">
                        <center><p id="xq_brief"></p></center>
                    </div></center>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p id="xq_describe"></p>
                        </div>
                    </div>
                </div>
                <center><div class="modal-header col-md-12">
                        <center><p id="xq_source"></p></center>
                    </div></center>
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
            </div>
            <div class="col-md-4">
                <select class="form-control" id="xz_type" name="xz_type">
                    <option value="3">所有</option>
                    <option value="1">市场</option>
                    <option value="2">政策</option>
                </select>
            </div>
        </div>
        <div class="btn-group-vertical">
            <div class="btn-group-vertical">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    已发布
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" data-status="1">
                    <li><a href="#" class="status1" data-user="1">管理员文稿</a></li>
                    <li><a href="#" class="status1" data-user="2">用户来稿</a></li>
                </ul>
            </div>
            <div class="btn-group-vertical">
                <button type="button" data-status="2" class="status1 btn btn-default dropdown-toggle" data-toggle="dropdown">
                    待审核...
                </button>
            </div>
            <div class="btn-group-vertical">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    已下架
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" data-status="3">
                    <li><a href="#" class="status1" data-user="1">管理员文稿</a></li>
                    <li><a href="#" class="status1" data-user="2">用户来稿</a></li>
                </ul>
            </div>
        </div>
        <center><h1 id="list_title">管理员文稿</h1></center>
    </div>
    <div class="panel" id="data"></div>
</div>
@include('admin.public.banner')
@endsection
@section('script')
    <!--引用ajax模块-->
    <script src="JsService/Controller/ajaxController.js" type="text/javascript"></script>
    <script src="JsService/Model/article/articleAjaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/article/articleAjaxSuccessModel.js" type="text/javascript"></script>
    <script src="JsService/Model/article/articleAjaxErrorModel.js" type="text/javascript"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
    {{--富文本--}}
    <script src="{{asset('/laravel-ueditor/ueditor.config.js') }}"></script>
    <script src="{{asset('/laravel-ueditor/ueditor.all.min.js')}}"></script>
    {{--图片剪切--}}
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/sitelogo.js')}}"></script>
    <script type="text/javascript">
        //富文本配置
        var toolbra     = {
            toolbars : [
                [
                    'bold', //加粗
                    'indent', //首行缩进
                    'italic', //斜体
                    'underline', //下划线
                    'blockquote', //引用
                    'pasteplain', //纯文本粘贴模式
                    'horizontal', //分隔线
                    'removeformat', //清除格式
                    'mergeright', //右合并单元格
                    'mergedown', //下合并单元格
                    'deleterow', //删除行
                    'deletecol', //删除列
                    'inserttitle', //插入标题
                    'mergecells', //合并多个单元格
                    'deletetable', //删除表格
                    'cleardoc', //清空文档
                    'insertparagraphbeforetable', //"表格前插入行"
                    'fontfamily', //字体
                    'fontsize', //字号
                    'paragraph', //段落格式
                    'simpleupload', //单图上传
                    'insertimage', //多图上传
                    'edittable', //表格属性
                    'edittd', //单元格属性
                    'link', //超链接
                    'spechars', //特殊字符
                    'insertvideo', //视频
                    'justifyleft', //居左对齐
                    'justifyright', //居右对齐
                    'justifycenter', //居中对齐
                    'forecolor', //字体颜色
                    'backcolor', //背景色
                    'pagebreak', //分页
                    'attachment', //附件
                    'imagecenter', //居中
                    'lineheight', //行间距
                    'autotypeset', //自动排版
                    'background', //背景
                    'music', //音乐
                    'inserttable', //插入表格
                ]
            ],
            initialFrameWidth : '100%',
        };
        var ue          = UE.getEditor('UE', toolbra);
        var ue1         = UE.getEditor('UE1', toolbra);

        //全局变量参数的设置
        var token       = $('meta[name="csrf-token"]').attr('content');
        var list_type   = null;//活动类型：1：市场资讯 2：政策 3：所有
        var list_status = 1;//文章状态：1：已发布 2：待审核 3：已下架
        var list_user = 1;//用户类型：1：管理员  2：普通用户

        //验证规则
        var rules       = {
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
        };
        //提示信息
        var messages    = {
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
        };

        //列表文章类型设置
        function listType(type,status,user) {
            list_type = type;
            list_status = status;
            list_user = user;
            list(type,status,user);
        }
        //分类查看数据
        $('#xz_type').change(function(){
            listType($('#xz_type').val(),list_status,list_user);
        });

        //状态+用户选择
        $('.status1').off('click').on('click',function () {
            if ($(this).data('status') == 2){
                $('.dropdown-toggle').removeClass('btn-success').addClass('btn-default');
                $(this).addClass('btn-success');
                list_status = 2;
                list_user = 2;
                $('#list_title').html($(this).html());
            }else{
                $('.dropdown-toggle').removeClass('btn-success').addClass('btn-default');
                $(this).parent().parent().siblings('button').addClass('btn-success');
                list_status = $(this).parent().parent().data('status');
                list_user = $(this).data('user');
                $('#list_title').html($(this).parent().html());
            }
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
                                'X-CSRF-TOKEN': token
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
                        var url = '/article/' + $('input[name=id]').val() + '?user='+list_user;
                        $.ajax({
                            url     : url,
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
                                    listType(resul.type,list_status,list_user);
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
                    rules: rules,
                    //提示信息
                    messages: messages
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
                                'X-CSRF-TOKEN': token
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
                                    $('#article_thumb_img').attr('src','home/img/upload-card.png');
                                    $('#yz_fb').find('textarea[name=brief]').val('');
                                    ue.setContent('');
                                    list(resul.type,list_status,list_user);
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
                    rules: rules,
                    //提示信息
                    messages: messages
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
                var url = '/article/' + $(this).data('name') +'?user=' + list_user;
                ajax.ajax({
                    url     : url,
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
            $('.status').off('click').click(function () {
                var _this = $(this);
                var ajax = new ajaxController();

                var url = '/article/'+ $(this).data('name') + '/edit/?status=' + $(this).data('status')+'&user='+list_user;
                if($(this).data('status') == 3 && list_user == 2){
                    url = '/article/'+ $(this).data('name') + '/edit/?status=' + $(this).data('status')+'&user='+list_user+'&reason='+$('#reason').val();
                }
                ajax.ajax({
                    url     : url,
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
                            $('#panel-modal').modal('hide');
                            $('#alert-info').html('<p>状态修改成功!</p>');
                            listType(list_type,list_status,list_user);
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

            $('#pass').click(function () {
                $('#pass_form').attr('data-name',$(this).data('name'));
                $('#pass_form').attr('data-status',$(this).data('status'));
            });


        }

        // 页面加载时触发事件请求分页数据
        function list(type,status,user) {
            var ajax = new ajaxController();
            ajax.ajax({
                url     : '/article/create?type='+type+'&status='+status+'&user='+user,
                before  : ajaxBeforeModel,
                success : getInfoList,
                error   : ajaxErrorModel
            });
        }
        listType(list_type,list_status,list_user);
    </script>
@endsection
