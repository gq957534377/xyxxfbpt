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

    .list-unstyled li{background: red;}
    .list-unstyled > li{
        margin-bottom: 10px;
    }
    .list-unstyled > li:nth-child(1){
        margin-bottom: 25px;
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
{{--查看报名用户详情谈框--}}
<div id="user-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" id="fabu">
        <div class="modal-content">
            <div id = "" class="modal-header">
                <h3>用户详细信息</h3><button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="text-danger">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li style="line-height: 40px"><strong>头像</strong> :
                                {{--<img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}">--}}
                                <div class="ibox-content" style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                                    <div class="row">
                                        <div id="crop-avatar">
                                            <div class="avatar-view" title="" style="width: 70px;border: none;border-radius: 0px;box-shadow: none;">
                                                <img id="head" class="img-circle" src="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li style="line-height: 40px" style="line-height: 40px"><strong>真实姓名 ：</strong><mark><span id="realname"></span></mark></li>
                            <li style="line-height: 40px"><strong>昵称 ：</strong><span id="nickname"></span></li>
                            <li style="line-height: 40px"><strong>性别 ：</strong><span id="sex"></span></li>
                            <li style="line-height: 40px"><strong>出生日期 ：</strong><span id="birthday"></span></li>
                            <li style="line-height: 40px"><strong>电话 ：</strong><ins><span id="phone"></span></ins></li>
                            <li style="line-height: 40px"><strong>邮箱 ：</strong><span id="email"></span></li>

                            <li style="line-height: 40px"><span></span></li>
                            <li style="line-height: 40px"><span></span></li>
                            <li style="line-height: 40px"><span></span></li>
                            <li style="line-height: 40px"><span></span></li>
                            <li style="line-height: 40px"><span></span></li>
                            <li style="line-height: 40px"><span></span></li>
                            <li style="line-height: 40px"><span></span></li>
                            <li style="line-height: 40px"><span></span></li>
                            <li style="line-height: 40px"><span></span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled1">
                            <li style="line-height: 40px"><strong>注册时间 ：</strong><span id="addtime"></span></li>
                            <li style="line-height: 40px" id="role"></li>
                            <li style="line-height: 40px" id="status"></li>
                            <li style="line-height: 40px"><strong>个人简介 ：</strong><small id="introduction"></small></li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@if($StatusCode == '200')
    <center><h1>报名表</h1><center>

            <div class="row">
                <div class="col-md-1">
                    <h4>活动描述：</h4>
                    </div>
                <br>
                <br>
                <div class="col-md-3" style="padding-left: 30px;text-align: left;">
                    <h5>活动标题：{{$ResultData->title}}</h5>
                </div>
            </div>
            <div class="row">
                <h5 class="col-md-3" style="padding-left: 30px;text-align: left;">发布时间：{{$ResultData->addtime}}</h5>
                </div>
            <div class="row">
                <h5 class="col-md-3" style="padding:0 0 0 30px;text-align: left;word-break: keep-all;">活动时间：{{date('m月d日 H点m分',$ResultData->start_time)}} ----> {{date('m月d日 H点m分',$ResultData->end_time)}}</h5>
            </div>
            <div class="panel" id="data"></div>
            @else
                <center><h1>出现错误了，错误代码{{$StatusCode}}，错误原因：{{$ResultData}}</h1>
                    <center>
                        @endif
@include('admin.public.banner')
@endsection
@section('script')
    <!--引用ajax模块-->
    <script src="{{asset('JsService/Controller/ajaxController.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/ajaxBeforeModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/action/actionOrderAjaxSuccessModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/ajaxErrorModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/pageList.js') }}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/date.js') }}" type="text/javascript"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>

    <script type="text/javascript">
        {{--全局变量的设置--}}

        //全局变量参数的设置action_id
        var action_id;
                @if($StatusCode == '200')
        action_id = "{{$ResultData->guid}}";
                @endif


        var token       = $('meta[name="csrf-token"]').attr('content');
        var list_status = 1;//报名状态：1：报名 3：禁用

        // 页面加载时触发事件请求分页数据
        function list(action_id, status) {
            var ajax = new ajaxController();
            var url  = '/action_order/create?action_id='+action_id;
            ajax.ajax({
                url     : url,
                before  : ajaxBeforeModel,
                success : actionOrder,
                error   : ajaxErrorModel,
            });
        }
        function pageUrl(){
            $('.pagination li').click(function () {
                var class_name = $(this).prop('class');
                if (class_name === 'disabled' || class_name === 'active') {
                    return false;
                }

                var url = $(this).children().prop('href') + '&action_id='+action_id+'&status=' + list_status;

                var ajax = new ajaxController();
                ajax.ajax({
                    url: url,
                    before: ajaxBeforeModel,
                    success: actionOrder,
                    error: ajaxErrorModel
                });
                return false;
            });
        }
        list(action_id, list_status);
    </script>
@endsection
