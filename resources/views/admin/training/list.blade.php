@extends('admin.layouts.master')
<style>
    .loading{z-index:999;position:absolute;display: none;}
    #alert-info{padding-left:10px;}
    table{font-size:14px;}
    .table button{margin-right:15px;}
</style>
@section('content')
@section('title', '用户列表')
{{-- 弹出表单开始 --}}
<!--继承组件-->
<!--替换按钮ID-->
@section('form-id', 'con-close-modal')
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

<img src="/images/load.gif" class="loading">

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">培训列表</h3>
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
    <script src="JsService/Model/training/trainingAjaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/training/trainingAjaxSuccessModel.js" type="text/javascript"></script>
    <script src="JsService/Model/training/trainingAjaxErrorModel.js" type="text/javascript"></script>
    <!--引用ajax模块-->
    <!--alertInfo end-->
    <script>
        // 显示个人信息详情
        function showInfo() {
            $('.fa-pencil').click(function () {
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/user_one_info?name=' + $(this).data('name'),
                    before  : ajaxBeforeNoHiddenModel,
                    success : showOneInfo,
                    error   : ajaxErrorModel
                });
            });
        }

        // 修改个人信息状态
//        function modifyStatus() {
//            $('.status').click(function () {
//                var _this = $(this);
//
//                var ajax = new ajaxController();
//                ajax.ajax({
//                    url     : '/userinfo_up_status?status=' + $(this).data('status') + '&name=' + $(this).data('name'),
//                    before  : ajaxBeforeNoHiddenModel,
//                    success : checkStatus,
//                    error   : ajaxErrorModel
//                });
//
//                function checkStatus(data){
//                    $('.loading').hide();
//                    $('#con-close-modal').modal('show');
//                    if (data) {
//                        if (data.ServerNo == 200) {
//                            var code = data.ResultData;
//                            $('#alert-form').hide();
//                            _this.data('status', code);
//                            if (_this.children().hasClass("btn-danger")) {
//                                _this.children().removeClass("btn-danger").addClass("btn-primary").html('启用');
//                            } else if (_this.children().hasClass("btn-primary")) {
//                                _this.children().removeClass("btn-primary").addClass("btn-danger").html('禁用');
//                            }
//                            $('#alert-info').show().html('<p>数据修改成功!</p>');
//                        } else {
//                            $('#alert-form').hide();
//                            $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
//                        }
//                    } else {
//                        $('#alert-form').hide();
//                        $('#alert-info').show().html('<p>未知的错误</p>');
//                    }
//                }
//            });
//        }

        // 页面加载时触发事件请求分页数据
        var ajax = new ajaxController();
        ajax.ajax({
            url     : '/user_info_page',
            before  : ajaxBeforeModel,
            success : getInfoList,
            error   : ajaxErrorModel,
        });
    </script>
@endsection