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

    #fabu {
        width: 80%;
        height: 80%;
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
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" id="fabu">
        <div class="modal-content">
            <form data-name="" role="form" id="yz_fb" onsubmit="return false">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="road_title">发布活动</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-3">活动类型</label>
                                <div for="field-3">
                                    <select class="form-control" id="action" name="action">
                                        <option value="1">活动</option>
                                        <option value="2">比赛</option>
                                        <option value="3">学习</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">活动主题</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="action title...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label">负责人</label>
                                <input type="text" class="form-control" id="author" name="author" placeholder="Author">
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
                                <label for="field-4" class="control-label">活动开始时间：</label>
                                <input type="text" class="some_class form-control" id="start_time" name="start_time"/>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-4" class="control-label">活动结束时间：</label>
                                <input type="text" class="some_class form-control" id="end_time" name="end_time"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-4" class="control-label">截止报名时间：</label>
                                <input type="text" class="some_class form-control" name="deadline" id="deadline"/>
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
                        <div class="col-md-12">
                            <div class="form-group mar-b30">
                                <label for="inputfile" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>缩略图</label>
                                <input type="hidden" id="banner" name="banner">
                                <div class="col-md-5">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div id="crop-avatar" class="col-md-6">
                                                <div class="avatar-view" title="">
                                                    <img src="{{ asset('home/img/upload-card.png') }}" id="action_thumb_img" alt="Logo" style="width: 200px;height: 150px;">
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
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label">活动简述</label>
                                <textarea class="form-control autogrow" id="brief" name="brief"
                                          placeholder="Write something about action"
                                          style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 control-label">活动详情</label>
                        <div class="col-md-12">
                            <textarea id="UE" name="describe" class="describe"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="caozuo">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="submit" data-name="" class="road_update btn btn-primary" id="add_road">发布活动</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--修改活动表单--}}
<div class="modal fade bs-example-modal-lg" id="xg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">修改活动</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-20" data-changed=false role="form" id="yz_xg" onsubmit="return false">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-3">活动类型</label>
                                <div for="field-3">
                                    <select class="form-control" id="xg_action" name="action" disabled="true">
                                        <option value="1">活动</option>
                                        <option value="2">比赛</option>
                                        <option value="3">学习</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="xg_id" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">活动主题</label>
                                <input type="text" class="form-control" id="xg_title" name="title"
                                       placeholder="action title...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label">负责人</label>
                                <input type="text" class="form-control" id="xg_author" name="author"
                                       placeholder="Author">
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
                                <label for="field-4" class="control-label">活动开始时间：</label>
                                <input type="text" class="some_class form-control" id="xg_start_time" name="start_time">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-4" class="control-label">活动结束时间：</label>
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
                        <div class="col-md-12">
                            <div class="form-group mar-b30">
                                <label for="inputfile" class="col-md-2 pad-cr"><span class="form-star">*</span>缩略图</label>
                                <input type="hidden" name="banner" id="charge_banner">
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
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="field-4" class="control-label">活动地址：</label>
                                <input type="text" class="form-control" id="xg_address" name="address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label">活动简述</label>
                                <textarea class="form-control autogrow" id="xg_brief" name="brief"
                                          placeholder="Write something about action"
                                          style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 control-label">活动详情</label>
                        <div class="col-md-12">
                            <textarea id="UE1" name="describe" class="describe"></textarea>
                        </div>
                    </div>
                    <center>
                        <button type="submit" id="sub_xg" class="btn btn-success m-l-10">修改</button>
                    </center>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
{{--活动详情--}}
<div id="tabs-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="field-1" class="control-label">活动主题</label>
                                <input type="text" id="xq_title" class="form-control" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-1" class="control-label">活动类型</label>
                                <input type="text" id="xq_type" class="form-control" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">负责人</label>
                                <input type="text" class="form-control" id="xq_author" disabled="true">
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
                                <input type="text" class="form-control" id="xq_status" placeholder="Doe"
                                       disabled="true">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">活动开始时间</label>
                                    <input type="text" class="some_class form-control " id="xq_start_time"
                                           placeholder="start time..." disabled="true">
                                </div>
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">活动结束时间</label>
                                    <input type="text" class="some_class form-control" id="xq_end_time"
                                           placeholder="end time..." disabled="true">
                                </div>
                                <div class="col-md-4">
                                    <label for="field-3" class="control-label">报名截止</label>
                                    <input type="text" class="some_class form-control" id="xq_deadline"
                                           placeholder="end time..." disabled="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-5" class="control-label">活动地址</label>
                                <input type="text" class="form-control" id="xq_address" placeholder="United States"
                                       disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">目前参与人数</label>
                                <input type="text" class="form-control" id="xq_population" placeholder="United States"
                                       disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">限报人数</label>
                                <input type="text" class="form-control" id="xq_limit" placeholder="United States"
                                       disabled="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">活动信息发布时间</label>
                                <input type="text" class="some_class form-control" id="xq_time"
                                       placeholder="United States" disabled="true">
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
</div>
{{--报名表--}}
<div id="baoming" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">报名表</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>用户id</th>
                        <th>报名时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="list_baoming">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<h3 class="title">活动管理</h3>
<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">发布活动</button>
<img src="/admin/images/load.gif" class="loading">

<div class="wraper container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-md-1">
            <h4>活动类型选择:</h4>
            </div>
            <div class="col-md-3">
                <select class="form-control" id="xz_type" name="xz_type">
                    <option value="null">所有</option>
                    <option value="1">路演活动</option>
                    <option value="2">比赛</option>
                    <option value="3">学习</option>
                </select>
            </div>
            <div class="col-md-8">

            </div>
        </div>

        <br>
        <button class="btn btn-success status1" data-status="1">报名中</button>
        <button class="btn btn-default status1" data-status="2">活动进行中...</button>
        <button class="btn btn-default status1" data-status="3">往期回顾</button>
        <button class="btn btn-default status1" data-status="4">回收站</button>
        <button class="btn btn-default status1" data-status="5">报名截止，等待开始</button>
        {{--<center><h1 id="list_title">报名中</h1></center>--}}
    </div>
    <div class="panel" id="data"></div>
</div>
@include('admin.public.banner')
@endsection
@section('script')
    <!--引用ajax模块-->
    <script src="JsService/Controller/ajaxController.js" type="text/javascript"></script>
    <script src="JsService/Model/ajaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/action/actionAjaxSuccessModel.js" type="text/javascript"></script>
    <script src="JsService/Model/ajaxErrorModel.js" type="text/javascript"></script>
    <script src="JsService/Model/pageList.js" type="text/javascript"></script>
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
        var list_type   = null;//活动类型：1：路演 2：大赛 3：学习
        var list_status = 1;//活动状态：1：报名中 2：进行中 3：往期回顾 4：回收站 5：报名截止，等待开始

        //验证规则
        var rules       = {
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
        var messages    = {
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

        //活动状态选择
        $('.status1').off('click').on('click', function () {
            $('.status1').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');
            $('#list_title').html($(this).html());
            listType(list_type, $(this).data('status'));
        });

        //列表活动类型设置
        function listType(type, status) {
            list_type   = type;
            list_status = status;
            list(type, status);
        }

        //分类查看数据
        $('#xz_type').change(function () {
            listType($('#xz_type').val(), list_status);
        });

        {{--修改活动--}}
        !function ($) {
            "use strict";
            var FormValidator = function () {
                this.$signupForm = $("#yz_xg");
            };

            //初始化
            FormValidator.prototype.init = function () {
                //插件验证完成执行操作 可以不写
//                $('#sub_xg').click(function () {
//                    if ($('#yz_xg').data('changed')){
//                        alert(111);
//                    }else{
//                        alert(222);
//                    }
//                });

                $.validator.setDefaults({
                    submitHandler: function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN' : token
                            }
                        });

                        var data  = new FormData();
                        var id = $('#xg_id').val();
                        var resul = {
                            type       : $('#yz_xg').find('select[name=action]').val(),
                            title      : $('#yz_xg').find('input[name=title]').val(),
                            author     : $('#yz_xg').find('input[name=author]').val(),
                            group      : $('#yz_xg').find('select[name=group]').val(),
                            banner     : $('#yz_xg').find('input[name=banner]').val(),
                            end_time   : $('#yz_xg').find('input[name=end_time]').val(),
                            deadline   : $('#yz_xg').find('input[name=deadline]').val(),
                            address    : $('#yz_xg').find('input[name=address]').val(),
                            limit      : $('#yz_xg').find('input[name=limit]').val(),
                            start_time : $('#yz_xg').find('input[name=start_time]').val(),
                            brief      : $('#yz_xg').find('textarea[name=brief]').val(),
                            describe   : ue1.getContent()
                        };

                        data.append("title", resul.title);
                        data.append("author", resul.author);
                        data.append("group", resul.group);
                        data.append("start_time", resul.start_time);
                        data.append("brief", resul.brief);
                        data.append("describe", resul.describe);
                        data.append("banner", resul.banner);
                        data.append("end_time", resul.end_time);
                        data.append("address", resul.address);
                        data.append("limit", resul.limit);

                        $.ajax({
                            url     : '/action/' + id,
                            type    : 'put',
                            data    : resul,
                            before  : ajaxBeforeNoHiddenModel,
                            success : check,
                            error   : ajaxErrorModel
                        });

                        function check(data) {
                            $('.loading').hide();
                            $('#myModal').modal('show');
                            $('#alert-form').html('');
                            $('.modal-title').html('提示');
                            if (data) {
                                if (data.StatusCode == 200) {
                                    $('.bs-example-modal-lg').modal('hide');
                                    $('#alert-info').html('<p>活动修改成功!</p>');
                                    list(resul.type, 1);
                                } else {
                                    $('#alert-info').html('<p>' + data.ResultData + '  错误代码：'+data.StatusCode + '</p>');
                                }
                            } else {
                                $('#alert-info').html('<p>未知的错误</p>');
                            }
                        }
                    }
                });
                this.$signupForm.validate({
                    rules    : rules,
                    messages : messages
                });
            },
                    //init
            $.FormValidator              = new FormValidator,
            $.FormValidator.Constructor  = FormValidator
        }(window.jQuery),
        function ($) {
            "use strict";
            $.FormValidator.init()
        }(window.jQuery);
        //发布
        !function ($) {
            "use strict";
            var FormValidator    = function () {
                this.$signupForm = $("#yz_fb");
            };

            //初始化
            FormValidator.prototype.init = function () {
                //插件验证完成执行操作 可以不写
                $.validator.setDefaults({
                    submitHandler : function () {
                        $.ajaxSetup({
                            headers : {
                                'X-CSRF-TOKEN' : token
                            }
                        });
                        var data  = new FormData();
                        var resul = {
                            type       : $('select[name=action]').val(),
                            title      : $('input[name=title]').val(),
                            author     : $('input[name=author]').val(),
                            group      : $('select[name=group]').val(),
                            banner     : $('input[name=banner]').val(),
                            end_time   : $('input[name=end_time]').val(),
                            deadline   : $('input[name=deadline]').val(),
                            address    : $('input[name=address]').val(),
                            limit      : $('input[name=limit]').val(),
                            start_time : $('input[name=start_time]').val(),
                            brief      : $('textarea[name=brief]').val(),
                            describe   : $('textarea[name=describe]').val(),
                        };

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

                        $.ajax({
                            url: '/action',
                            type: 'post',
                            data: resul,
                            before: ajaxBeforeNoHiddenModel,
                            success: check,
                            error: ajaxErrorModel
                        });

                        function check(data) {
                            $('.loading').hide();
                            $('#myModal').modal('show');
                            $('#alert-form').html('');
                            $('.modal-title').html('提示');
                            if (data) {
                                if (data.StatusCode == 200) {
                                    $('#con-close-modal').modal('hide');
                                    $('#alert-info').html('<p>活动发布成功!</p>');
                                    $('#yz_fb').find('input[name    = title]').val('');
                                    $('#yz_fb').find('input[name    = end_time]').val('');
                                    $('#yz_fb').find('input[name    = deadline]').val('');
                                    $('#yz_fb').find('input[name    = address]').val('');
                                    $('#yz_fb').find('input[name    = limit]').val('');
                                    $('#yz_fb').find('input[name    = author]').val('');
                                    $('#yz_fb').find('input[name    = banner]').val('');
                                    $('#yz_fb').find('select[name   = group]').val('');
                                    $('#yz_fb').find('input[name    = start_time]').val('');
                                    $('#yz_fb').find('textarea[name = brief]').val('');
                                    $('#action_thumb_img').attr('src', 'home/img/upload-card.png');
                                    ue.setContent('');
                                    list(resul.type, 1);
                                } else {
                                    $('#alert-info').html('<p>' + data.ResultData + '  错误代码：'+data.StatusCode + '</p>');
                                }
                            } else {
                                $('#alert-info').html('<p>未知的错误</p>');
                            }
                        }

                    }
                });
                this.$signupForm.validate({
                    rules    : rules,
                    messages : messages
                });

            },
            $.FormValidator             = new FormValidator;
            $.FormValidator.Constructor = FormValidator;
        }(window.jQuery),
        function ($) {
            "use strict";
            $.FormValidator.init()
        }(window.jQuery);

        //修改活动信息展示旧的信息
        function updates() {
            $('.charge-road').click(function () {
                $('.loading').hide();
                var ajax = new ajaxController();
                var url  = '/action/' + $(this).data('name')
                ajax.ajax({
                    url     : url,
                    before  : ajaxBeforeNoHiddenModel,
                    success : date,
                    error   : ajaxErrorModel
                });
            });
            $("#yz_xg :input").change(function(){
                $("#yz_xg").attr("data-changed",true);
            });
            $('#xg_brief').change(function(){
                $("#yz_xg").attr("data-changed",true);
            });
            $('#charge_banner').change(function(){
                $("#yz_xg").attr("data-changed",true);
            });
        }

        //展示活动信息详情
        function showInfo() {
            $('.info').click(function () {
                var ajax = new ajaxController();
                var url  = '/action/' + $(this).data('name');
                ajax.ajax({
                    url     : url,
                    before  : ajaxBeforeNoHiddenModel,
                    success : showInfoList,
                    error   : ajaxErrorModel
                });
            });
        }

        // 修改活动信息状态
        function modifyStatus() {
            $('.status').click(function () {
                var _this = $(this);
                var ajax  = new ajaxController();
                var url   = '/action/' + $(this).data('name') + '/edit/?status=' + $(this).data('status');
                ajax.ajax({
                    url     : url,
                    before  : ajaxBeforeNoHiddenModel,
                    success : checkStatus,
                    error   : ajaxErrorModel
                });

                function checkStatus(data) {
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
                            list(list_type, list_status);
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>' + data.ResultData + '  错误代码：'+data.StatusCode + '</p>');
                        }
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>未知的错误</p>');
                    }
                }
            });
        }

        //修改报名信息状态
        function actionStatus() {
            $('.action_status').click(function () {
                var _this  = $(this);
                var ajax   = new ajaxController();
                var status = _this.data('status');
                alert(status);
                if (status.data) {
                    status = status.data;
                }
                var url = '/action/' + _this.data('name') + '/edit/?status=' + status;
                ajax.ajax({
                    url     : url,
                    before  : ajaxBeforeNoHiddenModel,
                    success : action_status,
                    error   : ajaxErrorModel
                });
                function action_status(data) {
                    $('.loading').hide();
                    $('#myModal').modal('show');
                    $('.modal-title').html('提示');
                    if (data) {
                        if (data.StatusCode == 200) {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>状态修改成功!</p>');
                            if (status == 1) {
                                _this.html('<a href="javascript:;" data-name="3" data-status="3" class="action_status"><button class="btn-danger">禁用</button></a>');
                            }else {
                                _this.html('<a href="javascript:;" data-name="1" data-status="1" class="action_status"><button class="btn-primary">启用</button></a>');
                            }
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>' + data.ResultData + '  错误代码：'+data.StatusCode + '</p>');
                        }
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>未知的错误</p>');
                    }
                }
            });
        }

        //查看报名情况
        function checkAction() {
            $('.bm').click(function () {
                if ($(this).data('num') == 0){
                    $('#myModal').modal('show');
                    $('#alert-info').html('<p>暂无报名情况</p>');
                }else{
                    $('#baoming').modal('show');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });
                    var ajax = new ajaxController();
                    var url  = '/action/' + $(this).data('name');
                    ajax.ajax({
                        url     : url,
                        type    : 'delete',
                        before  : ajaxBeforeNoHiddenModel,
                        success : actionOrder,
                        error   : ajaxErrorModel
                    });
                }
            });
        }

        // 页面加载时触发事件请求分页数据
        function list(type, status) {
            var ajax = new ajaxController();
            var url  = '/action/create?type=' + type + '&status=' + status;
            ajax.ajax({
                url     : url,
                before  : ajaxBeforeModel,
                success : getInfoList,
                error   : ajaxErrorModel,
            });
        }
        list(list_type, list_status);
    </script>
@endsection
