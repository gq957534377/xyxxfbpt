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

@if($StatusCode == 200)
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
                <h5 class="col-md-3" style="padding:0 0 0 30px;text-align: left;word-break: keep-all;">活动时间：{{$ResultData->start_time}} ----> {{$ResultData->end_time}}</h5>
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
    <script src="JsService/Controller/ajaxController.js" type="text/javascript"></script>
    <script src="JsService/Model/ajaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/action/actionOrderAjaxSuccessModel.js" type="text/javascript"></script>
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

        //全局变量参数的设置action_id
        var action_id;
                @if($StatusCode == 200)
        action_id = "{{$ResultData->guid}}";
                @endif


        var token       = $('meta[name="csrf-token"]').attr('content');
        var list_status = 1;//报名状态：1：报名 3：禁用

        {{--@if($type == 3)--}}
        {{--//活动类型选择--}}
        {{--$('#college').change(function () {--}}
            {{--college_type = $(this).val();--}}
            {{--list(3, list_status);--}}
        {{--});--}}
        {{--@endif--}}
        //活动状态选择
        $('.status1').off('click').on('click', function () {
            $('.status1').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');
//            listType(list_type, $(this).data('status'));
        });

        //列表活动类型设置
        function listType(type, status) {
            list_type   = type;
            list_status = status;
            list(type, status);
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

        // 页面加载时触发事件请求分页数据
        function list(action_id, status) {
            var ajax = new ajaxController();
            var url  = '/action_order/create?action_id='+action_id+'&status=' + status;
            ajax.ajax({
                url     : url,
                before  : ajaxBeforeModel,
                success : actionOrder,
                error   : ajaxErrorModel,
            });
        }
        list(action_id, list_status);
    </script>
@endsection
