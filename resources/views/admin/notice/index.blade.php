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
    </style>
    <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
@endsection
@section('content')
@section('title', '校园通知管理')
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
{{--发布通知表单--}}
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" id="fabu" style="width: 64%;">
        <div class="modal-content">
            <form data-name="" role="form" id="yz_fb" onsubmit="return false">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="title">通知发布</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="field-3">通知类型</label>
                                <div for="field-3">
                                    <select class="form-control" id="type" name="type">
                                        <option value="1">两办通知</option>
                                        <option value="2">其他通知</option>
                                        <option value="3">本科教学</option>
                                        <option value="4">研究生教学</option>
                                        <option value="5">科技信息</option>
                                        <option value="6">社科信息</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="field-1" class="control-label">通知标题</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="notice title...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">通知来源</label>
                                <input type="text" class="form-control" id="source" name="source"
                                       placeholder="notice source...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label">通知简述</label>
                                <textarea class="form-control autogrow" id="brief" name="brief"
                                          placeholder="Write something about your notice"
                                          style="overflow: hidden; word-wrap: break-word; resize: none; height: 104px;">                                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 control-label">通知详情</label>
                        <div class="col-md-12">
                            <textarea id="UE" name="describe" class="describe"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="caozuo">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="submit" data-name="" class="notice_update btn btn-primary" id="add_notice">发布
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
{{--修改通知表单--}}
<div class="modal fade bs-example-modal-lg" id="xg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">修改通知</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-20" data-name="" role="form" id="yz_xg" onsubmit="return false">
                    <input name="id" type="hidden">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="field-3">通知类型</label>
                                <div for="field-3">
                                    <select class="form-control" id="xg_type" name="type">
                                        <option value="1">两办通知</option>
                                        <option value="2">其他通知</option>
                                        <option value="3">本科教学</option>
                                        <option value="4">研究生教学</option>
                                        <option value="4">科技信息</option>
                                        <option value="4">社科信息</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9" style="margin-left: 68px;">
                            <div class="form-group">
                                <label for="field-1" class="control-label">通知标题</label>
                                <input type="text" class="form-control" id="xg_title" name="title"
                                       placeholder="notice title...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">通知来源</label>
                                <input type="text" class="form-control" id="xg_source" name="source"
                                       placeholder="notice source...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label">通知简述</label>
                                <textarea class="form-control autogrow" id="xg_brief" name="brief"
                                          placeholder="Write something about your notice"
                                          style="overflow: hidden; word-wrap: break-word; resize: none; height: 104px;">                                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 control-label">通知详情</label>
                        <div class="col-md-12">
                            <textarea id="UE1" name="describe" class="describe"></textarea>
                        </div>
                    </div>

                    <center>
                        <button type="submit" class="btn btn-success m-l-10">修改</button>
                    </center>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

{{--新的详情页--}}
<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel"
     aria-hidden="true" style="display: none;width: 80%;margin-left: 10%">
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
                    <center>
                        <div class="modal-header col-md-12">
                            <center><p id="xq_brief"></p></center>
                        </div>
                    </center>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p id="xq_describe"></p>
                        </div>
                    </div>
                </div>
                <center>
                    <div class="modal-header col-md-12">
                        <center><p id="xq_source"></p></center>
                    </div>
                </center>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<h3 class="title">通知管理</h3>
<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">发布通知</button>
{{--大菊花转转转--}}
<img src="{{asset('/admin/images/load.gif')}}" class="loading">

{{--总按钮--}}
<div class="wraper container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-md-1">
                <h3 id="list_title" class="title">已发布</h3>
            </div>
            <div class="col-md-1">
                <select class="form-control" id="xz_type" name="xz_type">
                    <option value="null">所有</option>
                    <option value="1">两办通知</option>
                    <option value="2">其他通知</option>
                    <option value="3">本科教学</option>
                    <option value="4">研究生教学</option>
                    <option value="4">科技信息</option>
                    <option value="4">社科信息</option>
                </select>
            </div>
            <div class="col-md-10">

            </div>
        </div>
        <br>
        <div class="btn-group-vertical">
            <div class="btn-group-vertical">
                <button type="button" class="btn btn-success dropdown-toggle list-status" data-status="1">
                    已发布
                </button>
            </div>

            <div class="btn-group-vertical">
                <button type="button" class="btn btn-default dropdown-toggle list-status" data-status="2">
                    已删除
                </button>
            </div>
        </div>
    </div>
    <div class="panel" id="data"></div>
</div>
@include('admin.public.banner')
@endsection
@section('script')
    <!--引用ajax模块-->
    <script src="{{asset('JsService/Controller/ajaxController.js')}}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/ajaxBeforeModel.js')}}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/notice/noticeAjaxSuccessModel.js')}}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/ajaxErrorModel.js')}}" type="text/javascript"></script>
    <!--alertInfo end-->
    <script src="{{asset('/admin/js/jquery.validate.min.js')}}"></script>
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <script src="{{asset('admin/js/sweet-alert.min.js')}}"></script>
    {{--富文本--}}
    <script src="{{asset('/laravel-ueditor/ueditor.config.js') }}"></script>
    <script src="{{asset('/laravel-ueditor/ueditor.all.min.js')}}"></script>
    {{--图片剪切--}}
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/sitelogo.js')}}"></script>
    <script type="text/javascript">
        //富文本配置
        var toolbra = {
            toolbars: [
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
            initialFrameWidth: '100%',
            initialFrameHeight: '220',
        };
        var ue = UE.getEditor('UE', toolbra);
        var ue1 = UE.getEditor('UE1', toolbra);

        //全局变量参数的设置
        var token = $('meta[name="csrf-token"]').attr('content');
        var list_type = null;//通知类型
        var list_status = 1;//通知状态：1：已发布 2：已删除

        //验证规则
        var rules = {
            type: {
                required: true,
            },
            title: {
                required: true,
                maxlength: 50
            },
            source: {
                required: true,
                maxlength: 50
            },
            brief: {
                required: true,
                rangelength: [40, 100]
            },
            describe: {
                required: true,
                minlength: 50
            },
        };
        //提示信息
        var messages = {
            type: {
                required: '请输入通知类型'
            },
            title: {
                required: '请输入通知标题'
            },
            brief: {
                required: '请输入通知简述'
            },
            source: {
                required: '请输入通知来源'
            },
            describe: {
                required: '请输入通知详情'
            },
        };

        //列表通知类型设置
        function listType(type, status) {
            list_type = type;
            list_status = status;
            list(type, status);
        }
        //分类查看数据
        $('#xz_type').change(function () {
            listType($('#xz_type').val(), list_status);
        });

        //状态选择
        $('.list-status').off('click').on('click', function () {
                $('.list-status').removeClass('btn-success').addClass('btn-default');
                $(this).addClass('btn-success');
                $('#list_title').html($(this).html());
                list_status = $(this).data('status');
            listType(list_type, list_status);
        });

        //确认谈框
        function initAlert() {
            var passId;
            var passDom;
            $('.pass').click(function () {
                passDom = $(this).parent().parent().parent();
                passId = $(this).data('name');
            });
            !function ($) {
                "use strict";

                var SweetAlert = function () {
                };

                //examples
                SweetAlert.prototype.init = function () {

                    //禁用弹出确认框
                    $('.status').off('click').click(function () {

                        var guid = $(this).data('name');
                        var status = $(this).data('status');
                        var reason = $('#reason').val();
                        var statusMessage = $(this).html();

                        //获取tr节点
                        var tr;
                        if (statusMessage == "通过" || statusMessage == "否决") {
                            tr = $(this).parent().parent().parent();
                            if (statusMessage == "否决") {
                                guid = $(this).data('name');
                                status = 3;
                                tr = null;
                            }
                        } else {
                            tr = $(this).parent().parent();
                        }

                        swal({
                            title: "确定要" + statusMessage + "?",
                            text: "当前操作将" + statusMessage + "该通知的展示!",
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
                                var url = '/notice/' + guid + '/edit/?status=' + status;
                                $.ajax({
                                    url: url,
                                    success: function (data) {
                                        if (data.StatusCode != 200) {
                                            swal(data.ResultData, statusMessage + '通知失败', "danger");
                                        } else {
                                            swal(data.ResultData, '成功' + statusMessage + '通知', "success");
                                            $('#panel-modal').modal('hide');
//                                            passDom.remove();
                                            tr.remove();
                                        }
                                    }
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

        {{--修改--}}
            !function ($) {
            "use strict";
            var FormValidator = function () {
                this.$signupForm = $("#yz_xg");
            };

            //初始化
            FormValidator.prototype.init = function () {
                //插件验证完成执行操作 可以不写
                $.validator.setDefaults({
                    submitHandler: function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                        });
                        var data = new FormData();
                        var resul = {
                            type: $('#yz_xg').find('select[name=type]').val(),
                            title: $('#yz_xg').find('input[name=title]').val(),
                            banner: $('#yz_xg').find('input[name=banner]').val(),
                            source: $('#yz_xg').find('input[name=source]').val(),
                            brief: $('#yz_xg').find('textarea[name=brief]').val(),
                            describe: ue1.getContent(),
                        };
                        data.append("type", resul.type);
                        data.append("title", resul.title);
                        data.append("brief", resul.brief);
                        data.append("describe", resul.describe);
                        data.append("banner", resul.banner);
                        data.append("source", resul.source);

                            var url = '/notice/' + $('input[name=id]').val();
                            $.ajax({
                                url: url,
                                type: 'put',
                                data: resul,
                                before: ajaxBeforeNoHiddenModel,
                                success: check,
                                error: ajaxErrorModel
                            });
                        function check(data) {
                            $('.loading').hide();
                            if (data) {
                                if (data.StatusCode === '200') {
                                    swal({
                                            title: data.ResultData, // 标题，自定
                                            text: '请到对应通知类型管理列表查看',   // 内容，自定
                                            type: "success",    // 类型，分别为error、warning、success，以及info
                                            showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                                            confirmButtonColor: '#DD6B55',  // 确认用途的按钮颜色，自定
                                        },
                                        function (isConfirm) {
                                            $('.bs-example-modal-lg').modal('hide');
                                            swal(data.ResultData, '请到对应通知类型管理列表查看', "success");
                                            listType(resul.type, list_status);
                                        });
                                } else {
                                    swal(data.ResultData, '错误代码：' + data.StatusCode, "error");
                                }
                            } else {
                                swal('出错了', '错误代码：未知', "error");
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
            function ($) {
                "use strict";
                $.FormValidator.init()
            }(window.jQuery);

        //发布
        !function ($) {
            "use strict";
            var FormValidator = function () {
                this.$signupForm = $("#yz_fb");
            };

            //初始化
            FormValidator.prototype.init = function () {
                //插件验证完成执行操作 可以不写
                $.validator.setDefaults({
                    submitHandler: function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                        });
                        var data = new FormData();
                        var resul = {
                            type: $('select[name=type]').val(),
                            title: $('input[name=title]').val(),
                            banner: $('input[name=banner]').val(),
                            source: $('input[name=source]').val(),
                            brief: $('textarea[name=brief]').val(),
                            describe: $('textarea[name=describe]').val(),
                        };
                        data.append("type", resul.type);
                        data.append("title", resul.title);
                        data.append("brief", resul.brief);
                        data.append("describe", resul.describe);
                        data.append("banner", resul.banner);
                        data.append("source", resul.source);

                            if (!resul.describe) {
                                swal('请填写完毕', '详情描述不能为空', "error");
                            } else {
                                $.ajax({
                                    url: '/notice',
                                    type: 'post',
                                    data: resul,
                                    before: ajaxBeforeNoHiddenModel,
                                    success: check,
                                    error: ajaxErrorModel
                                });
                            }
                        function check(data) {
                            $('.loading').hide();
                            if (data) {
                                if (data.StatusCode === '200') {
                                    swal({
                                            title: data.ResultData, // 标题，自定
                                            text: '请到对应通知类型管理列表查看',   // 内容，自定
                                            type: "success",    // 类型，分别为error、warning、success，以及info
                                            showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                                            confirmButtonColor: '#DD6B55',  // 确认用途的按钮颜色，自定
                                        },
                                        function (isConfirm) {
                                            $('#con-close-modal').modal('hide');
                                            swal(data.ResultData, '请到对应通知类型管理列表查看', "success");
                                            $('#yz_fb').find('input[name=title]').val('');
                                            $('#yz_fb').find('input[name=source]').val('');
                                            $('#yz_fb').find('input[name=banner]').val('');
                                            $('#notice_thumb_img').attr('src', 'home/img/upload-card.png');
                                            $('#yz_fb').find('textarea[name=brief]').val('');
                                            ue.setContent('');
                                            listType(resul.type, list_status);
                                        });
                                } else {
                                    swal(data.ResultData, '错误代码：' + data.StatusCode, "error");
                                }
                            } else {
                                swal('出错了', '错误代码：未知', "error");
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
            function ($) {
                "use strict";
                $.FormValidator.init()
            }(window.jQuery);

        //修改通知信息展示旧的信息
        function updates() {
            $('.charge-road').click(function () {
                $('.loading').hide();
                var ajax = new ajaxController();
                var url = '/notice/' + $(this).data('name');
                ajax.ajax({
                    url: url,
                    before: ajaxBeforeNoHiddenModel,
                    success: date,
                    error: ajaxErrorModel
                });
            });
        }

        //展示通知信息详情
        function showInfo() {
            $('.info').click(function () {
                var ajax = new ajaxController();
                ajax.ajax({
                    url: '/notice/' + $(this).data('name'),
                    before: ajaxBeforeNoHiddenModel,
                    success: showInfoList,
                    error: ajaxErrorModel
                });
            });
        }

        function checkAction() {
        }

        // 页面加载时触发事件请求分页数据
        function list(type, status, user) {
            var ajax = new ajaxController();
            var url = '/notice/create?type=' + type + '&status=' + status;
            ajax.ajax({
                url: url,
                before: ajaxBeforeModel,
                success: getInfoList,
                error: ajaxErrorModel
            });
        }
        listType(list_type, list_status);
    </script>
@endsection
