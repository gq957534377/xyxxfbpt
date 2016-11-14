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
        width: 600px;
        height: 200px;
    }
</style>
@section('content')
@section('title', '创业大赛')
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
            <form id="postSend" action="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">发布创业大赛</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">大赛名称：</label>
                            <input type="text" class="form-control" name="name" id="title" placeholder="填写大赛名称">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">活动排序：</label>
                            <input type="text" class="form-control" name="order" id="title" placeholder="第几届">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">组织机构名称：</label>
                            <input type="text" id="groupname" name="org" class="form-control"
                                   placeholder="机构名称">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">参与人数：</label>
                            <input type="text" id="groupname" name="peoples" class="form-control"
                                   placeholder="填写人数">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-4" class="control-label">比赛开始时间：</label>
                            <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                                   name="start_time" id="start_time">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-5" class="control-label">比赛结束时间：</label>
                            <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                                   name="end_time" id="stop_time">
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
                            <label for="field-7" class="control-label">创业大赛详情</label>
                            <textarea name="content" id="UE1"></textarea>
                        </div>
                    </div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-info" id="add_road">发布</button>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->


<button style="float: right" id="add_training" class="btn btn-primary" data-toggle="modal"
        data-target="#con-close-modal">添加大赛 &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></button>


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
         * 添加培训信息
         */

        $('#add_road').click(function () {
            // $('.modal-title').html('技术培训信息详情');
//            var data=[];
//            console.log(typeof data);
//            data['name']=$('input[name=name]').val();
//            data['order']=$('input[name=order]').val();
//            data['org']=$('input[name=org]').val();
//            data['peoples']=$('input[name=peoples]').val();
//            data['start_time']=$('input[name=start_time]').val();
//            data['end_time']=$('input[name=end_time]').val();
//            data['deadline']=$('input[name=deadline]').val();
//            data['content']=ue1.getContent();
            var data = new FormData($("#postSend"));
            data.append('name',$('input[name=name]').val());
            console.log(data);
            $.ajax({
                url:'match',
                type:'post',
                data:data,
                dataType:'json',
                beforeSend:function () {
                    console.log("发送成功");
                },
                success:function (data) {
                    console.log(data);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                error : function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(XMLHttpRequest.status);
                    console.log(XMLHttpRequest.readyState);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
            return false;
        });

        // 修改大赛信息

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
    <script>
        $('#add_training').click(function () {
            var ajax = new ajaxController();
            ajax.ajax({
                url: '/training',
//                before: ajaxBeforeModel(),
                success: function (data) {
//                    $('.loading').hide();
                }
            });
        });
    </script>
@endsection