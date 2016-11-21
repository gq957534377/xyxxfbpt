@extends('admin.layouts.master')
<style>
    .loading {
        z-index: 999;
        position: absolute;
        display: none;
    }

    .modal-content {
        width: 690px;
    }
    #UE{
        width: 648px;
        height: 200px;
    }
</style>
@section('content')
@section('title', '技术培训管理')
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
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" id="fabu">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">添加技术培训</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">创业技术培训名称：</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="请填写创业技术培训名称">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">组织机构名称：</label>
                            <input type="text" id="groupname" name="groupname" class="form-control"
                                   placeholder="请填写组织机构名称">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-4" class="control-label">培训开始时间：</label>
                            <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                                   name="start_time" id="start_time">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-5" class="control-label">培训结束时间：</label>
                            <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                                   name="stop_time" id="stop_time">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-6" class="control-label">报名截止时间：</label>
                            <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                                   name="deadline" id="deadline">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-6" class="control-label">缩略图：</label>
                            <input type="file" class="form-control" name="banner" id="banner">
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
                            <label for="field-7" class="control-label">创业项目培训详情</label>
                            <textarea class="" placeholder="请详细描述创业项目培训内容" id="UE1"
                                      name="describe">请详细描述创业项目培训内容</textarea>
                        </div>
                    </div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-info" id="add_training">发布技术培训</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->


<button style="float: right" id="training" class="btn btn-primary" data-toggle="modal"
        data-target="#con-close-modal">添加技术培训 &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></button>


<img src="/admin/images/load.gif" class="loading">


<div class="panel" id="data"></div>
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
        /**
         * 添加用户
         */
<<<<<<< HEAD
        $('#add_road').click(function () {

=======
        $('#add_training').click(function () {
>>>>>>> origin/dev
            $('.modal-title').html('技术培训信息详情');
            var data = {
                title: $('#title').val(),
                groupname: $('#groupname').val(),
                start_time: $('#start_time').val(),
                stop_time: $('#stop_time').val(),
                deadline: $('#deadline').val(),
                banner: $('#banner').val(),
                describe: ue1.getContent()
            };

            $.ajax({
                url: '/training',
<<<<<<< HEAD
                type:'post',
                dataType:'json',
                data:data,
                success : function (data) {
                    alert(11);
=======
                type: 'post',
                dataType: 'json',
                data: data,
                beforeSend:function () {
//                    console.log('测试运行ajax');
                },
                success: function (data) {
>>>>>>> 01202d3764bee5f602f579d44236d8a0808b6c06
                    $('.loading').hide();
                    $('#myModal').modal('show');
                    $('.modal-title').html('提示');
                    if (data) {
                        if (data.ServerNo == 200) {
                            $('#fabu').hide();
                            $('#alert-info').html('<p>技术培训发布成功!</p>');
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>' + data.ResultData + '</p>');
                        }
                    } else {
//                        $('#alert-form').hide();
//                        $('#alert-info').html('<p>未知的错误</p>');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }
            });
        });
        /**
         * 修改
         */
        $(document).on('click','editor',function () {
            var data = this.getAttribute('data-name');
            $.ajax({
                url:'/training/' + data + '/edit',
                type:'get',
                proccessData:true,
                beforeSend:function () {
                    console.log('获取数据中');
                },
                success:function () {
                    $('#altersend input[name=title]').val(data[0].title);
                }
            })
        });



        // 页面加载时触发事件请求分页数据
        var ajax = new ajaxController();
        ajax.ajax({
            url: 'training_info_page',
            before: ajaxBeforeModel,
            success: getInfoList,
            error: ajaxErrorModel,
        });
    </script>

    {{--添加培训--}}
@endsection