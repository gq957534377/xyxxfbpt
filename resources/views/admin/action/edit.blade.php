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
{{--发布活动表单--}}
<h3>发布活动</h3>
<form data-name="" role="form" id="yz_fb" onsubmit="return false">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-3">活动类型</label>
                    <div for="field-3">
                        <select class="form-control" id="action" name="type">
                            <option value="1" @if($list !=3 && $ResultData->type == 1) selected @endif>路演活动</option>
                            <option value="2" @if($list !=3 && $ResultData->type == 2) selected @endif>创业大赛</option>
                            <option value="3" @if($list == 3) selected @endif>英雄学院</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="type" style="display: @if($list == 3)block @endif none">
                <div class="form-group">
                    <label for="field-3">培训类型</label>
                    <div for="field-3">
                        <select id="type1" class="form-control" name="">
                            <option value="1" @if($ResultData->type == 1) selected @endif>企业管理</option>
                            <option value="2" @if($ResultData->type == 2) selected @endif>资金管理</option>
                            <option value="3" @if($ResultData->type == 3) selected @endif>人才管理</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-1" class="control-label">活动主题</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{$ResultData->title}}" placeholder="action title...">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-2" class="control-label">负责人</label>
                    <input type="text" class="form-control" id="author" name="author" value="{{$ResultData->author}}" placeholder="Author">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3">所属机构</label>
                    <div for="field-3">
                        <select class="form-control" id="group" name="group">
                            <option value="1" @if($ResultData->group == 1) selected @endif>英雄会</option>
                            <option value="2" @if($ResultData->group == 2) selected @endif>兄弟会</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-4" class="control-label">活动开始时间：</label>
                    <input type="text" class="some_class form-control" value="{{date('Y/m/d H:m', $ResultData->start_time)}}" id="start_time" name="start_time"/>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-4" class="control-label">活动结束时间：</label>
                    <input type="text" class="some_class form-control" value="{{date('Y/m/d H:m', $ResultData->end_time)}}" id="end_time" name="end_time"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-4" class="control-label">截止报名时间：</label>
                    <input type="text" class="some_class form-control" value="{{date('Y/m/d H:m', $ResultData->deadline)}}" name="deadline" id="deadline"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-4" class="control-label">限报人数：</label>
                    <input type="text" class="form-control" value="{{$ResultData->limit}}" id="limit" name="limit">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mar-b30">
                    <label for="inputfile" class="col-md-2 control-label pad-cr"><span
                                class="form-star">*</span>缩略图</label>
                    <input type="hidden" id="banner" value="{{$ResultData->banner}}" name="banner">
                    <div class="col-md-5">
                        <div class="ibox-content">
                            <div class="row">
                                <div id="crop-avatar" class="col-md-6">
                                    <div class="avatar-view" title="">
                                        <img src="{{$ResultData->banner}}" id="action_thumb_img" alt="Logo" style="width: 200px;height: 150px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="form-group">
                    <label for="field-4" class="control-label">活动地址：</label>
                    <input type="text" class="form-control" id="address" value="{{$ResultData->address}}" name="address">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group no-margin">
                    <label for="field-7" class="control-label">活动简述</label>
                    <textarea class="form-control autogrow" id="brief" name="brief" placeholder="Write something about action" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{$ResultData->brief}}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="col-md-12 control-label">活动详情</label>
            <div class="col-md-12">
                <textarea id="UE" name="describe" class="describe">{{$ResultData->describe}}</textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer" id="caozuo">
        <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
        <button type="submit" class="road_update btn btn-primary" id="add_road">修改</button>
    </div>
</form>

@include('admin.public.banner')
@endsection
@section('script')
    <!--引用ajax模块-->
    <script src="{{asset('JsService/Controller/ajaxController.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/ajaxBeforeModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/action/actionAjaxSuccessModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/ajaxErrorModel.js') }}" type="text/javascript"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
    {{--富文本--}}
    <script src="{{asset('/laravel-ueditor/ueditor.config.js') }}"></script>
    <script src="{{asset('/laravel-ueditor/ueditor.all.min.js')}}"></script>
    {{--图片剪切--}}
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/sitelogo.js')}}"></script>
    {{--时间插件--}}
    <script src="{{asset('/dateTime/build/jquery.datetimepicker.full.js')}}"></script>
    <script src="{{asset('/admin/js/public/dateTime.js')}}"></script>//时间插件配置
    <script type="text/javascript">
        {{--全局变量的设置--}}
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
            initialFrameWidth: '100%',
        };
        var ue = UE.getEditor('UE', toolbra);

        //全局变量参数的设置
        var token = $('meta[name="csrf-token"]').attr('content');

        //验证规则
        var rules = {
            type: {
                required: true
            },
            title: {
                required: true,
                maxlength: 50
            },
            end_time: {
                required: true
            },
            deadline: {
                required: true
            },
            address: {
                required: true,
                maxlength: 30
            },
            limit: {
                digits: true,
                required: true
            },
            author: {
                required: true,
                maxlength: 5
            },
            group: {
                required: true
            },
            start_time: {
                required: true
            },
            brief: {
                required: true,
                rangelength: [40, 100]
            },
            describe: {
                required: true,
                minlength: 50
            },
            banner: {
                required: true
            }
        };
        //提示信息
        var messages = {
            type: {
                required: '请选择活动类型'
            },
            title: {
                required: '请输入活动主题',
                maxlength: '标题最多50个字符'
            },
            author: {
                required: '请输入负责人',
                maxlength: '负责人最多5个字符'

            },
            group: {
                required: '组织机构必选'
            },
            start_time: {
                required: '请输入活动开始时间'
            },
            brief: {
                required: '请输入活动简述',
                rangelength: '请输入40-100个字符作为简述'
            },
            end_time: {
                required: '请输入活动结束时间'
            },
            deadline: {
                required: '请输入报名截止日期'
            },
            address: {
                required: '请输入活动地址',
                maxlength: '地址最多30个字符'
            },
            limit: {
                digits: '人数限制必须为整数',
                required: '请输入报名限制人数'
            },
            describe: {
                required: '请输入活动详情',
                minlength: '详情长度最少50个字符'
            },
            banner: {
                required: '缩略图不能为空'
            }
        };


        //分类查看数据
        $('#action').change(function () {
            if ($(this).val() == 3){
                $('#type').css('display','block');
                $(this).attr('name','');
                $('#type1').attr('name','type')
            }else {
                $('#type').css('display','none');
                $(this).attr('name','type');
                $('#type1').attr('name','')
            }
        });

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
                            author: $('input[name=author]').val(),
                            group: $('select[name=group]').val(),
                            banner: $('input[name=banner]').val(),
                            end_time: $('input[name=end_time]').val(),
                            deadline: $('input[name=deadline]').val(),
                            address: $('input[name=address]').val(),
                            limit: $('input[name=limit]').val(),
                            start_time: $('input[name=start_time]').val(),
                            brief: $('textarea[name=brief]').val(),
                            describe: $('textarea[name=describe]').val(),
                        };
                        var url = '/action/{{$ResultData->guid}}?list={{$list}}';

                        data.append("type", resul.type);
                        data.append("title", resul.title);
                        data.append("author", resul.author);
                        data.append("group", resul.group);
                        data.append("start_time", resul.start_time);
                        data.append("brief", resul.brief);
                        data.append("describe", resul.describe);
                        data.append("banner", resul.banner);
                        data.append("end_time", resul.end_time);
                        data.append("start_time", resul.start_time);
                        data.append("address", resul.address);
                        data.append("limit", resul.limit);
                        if (!resul.banner) {
                            alert("缩略图不能为空");
                        }else{
                            if (!resul.describe) {
                                alert("详情描述不能为空")
                            }else{
                                $.ajax({
                                    url: url,
                                    type: 'put',
                                    data: resul,
                                    before: ajaxBeforeNoHiddenModel,
                                    success: check,
                                    error: ajaxErrorModel
                                });
                            }
                        }
                        function check(data) {
                            $('.loading').hide();

                            $('#alert-form').html('');
                            $('.modal-title').html('提示');
                            if (data) {
                                if (data.StatusCode == 200) {
                                    alert('修改成功！');
//                                    $('#alert-info').html('<p>活动发布成功!</p>');
                                    window.history.back(-1);
                                } else {
                                    $('#myModal').modal('show');
                                    $('#alert-info').html('<p>' + data.ResultData + '  错误代码：' + data.StatusCode + '</p>');
                                }
                            } else {
                                $('#myModal').modal('show');
                                $('#alert-info').html('<p>未知的错误</p>');
                            }
                        }

                    }
                });
                this.$signupForm.validate({
                    rules: rules,
                    messages: messages
                });

            },
                    $.FormValidator = new FormValidator;
            $.FormValidator.Constructor = FormValidator;
        }(window.jQuery),
                function ($) {
                    "use strict";
                    $.FormValidator.init()
                }(window.jQuery);

    </script>
@endsection
