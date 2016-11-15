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
                            <input type="text" class="form-control" name="name"placeholder="填写大赛名称">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">活动排序：</label>
                            <input type="text" class="form-control" name="order" placeholder="第几届">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">组织机构名称：</label>
                            <input type="text" name="org" class="form-control"
                                   placeholder="机构名称">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">参与人数：</label>
                            <input type="text" name="peoples" class="form-control"
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
                {{--在这里加上验证之后js验证插件定位不准--}}
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-info" id="add_road">发布</button>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
{{--修改--}}
<div id="con-close-modald" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" id="fabu">
        <div class="modal-content">
            <form id="altersend" action="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">信息编辑</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">大赛名称：</label>
                                <input type="text" class="form-control" name="name" placeholder="填写大赛名称">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">活动排序：</label>
                                <input type="text" class="form-control" name="order" placeholder="第几届">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-2" class="control-label">组织机构名称：</label>
                                <input type="text" id="groupname" name="org" class="form-control" placeholder="机构名称">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-2" class="control-label">参与人数：</label>
                                <input type="text" id="groupname" name="peoples" class="form-control" placeholder="填写人数">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-4" class="control-label">比赛开始时间：</label>
                                <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control" name="start_time" id="start_time">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">比赛结束时间：</label>
                                <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control" name="end_time" id="stop_time">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-6" class="control-label">报名截止时间：</label>
                                <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control" name="deadline" id="deadline">
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
                                <textarea name="content" id="UE2"></textarea>
                            </div>
                        </div>
                    </div>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-info" id="alter_road" data-guid="22">发布</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
{{--提示--}}
<div id="hint_form" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Small modal</h4>
            </div>
            <p></p>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

{{--提示信息按钮--}}
<button id="hint" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm" style="display: none;" >提示信息</button>
{{--提示信息按钮结束--}}
{{--修改表单按钮--}}
<button id="alter" class="btn btn-primary" data-toggle="modal"
        data-target="#con-close-modald">下面的 &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></button>
{{--修改表单按钮结束--}}
{{--发布弹窗按钮--}}
<button id="add_training" class="btn btn-primary" data-toggle="modal"
        data-target="#con-close-modal">添加大赛 &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></button>
{{--发布弹窗按钮结束--}}

<img src="/admin/images/load.gif" class="loading">
{{--列表 初始化为空--}}
            <div class="row">
                <div class="col-sm-6">
                    <p>  </p>
                </div>
            </div>
            <table class="table table-bordered table-striped" id="datatable-editable">
                <thead>
                <tr>
                    <th>大赛名称</th>
                    <th>大赛排序</th>
                    <th>组织机构</th>
                    <th>参与人数</th>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>报名截止</th>
                    <th>修改时间</th>
                    <th>活动内容</th>
                    <th>信息操作</th>
                </tr>
                </thead>
                <tbody class="span">
                <tr class="gradeX">
                    {{--<td>暂无内容</td>--}}
                </tr>
                </tbody>
            </table>
            {{--paging--}}
            <div class="col-sm-12" id="data-page">
                <ul class="pagination pull-right">
                    <li>
                        <a href="#" aria-label="Previous">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li class="disabled"><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
            {{--end-paging--}}
{{--列表结束--}}
@endsection

@section('script')
    <!--alertInfo JS-->
    <!--alertInfo JS-->
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
    <!--引用ajax模块-->
    <script src="JsService/Controller/ajaxController.js" type="text/javascript"></script>
    <script src="JsService/Model/match/matchAjaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/match/matchAjaxSuccessModel.js" type="text/javascript"></script>
    <script src="JsService/Model/match/matchAjaxErrorModel.js" type="text/javascript"></script>
    <!--引用ajax模块-->
    <!--alertInfo end-->
    <script>
        /**
         * 项目发布验证
         */
        !function($) {
            "use strict";
            var FormValidator = function() {
                this.$signupForm = $("#postSend");
            };
            FormValidator.prototype.init = function() {
                $.validator.setDefaults({
                    submitHandler: function() {

                        var data = new FormData($("#postSend"));
                        data.append('name',$('#postSend input[name=name]').val());
                        data.append('order',$('#postSend input[name=order]').val());
                        data.append('org',$('#postSend input[name=org]').val());
                        data.append('peoples',$('#postSend input[name=peoples]').val());
                        data.append('start_time',$('#postSend input[name=start_time]').val());
                        data.append('end_time',$('#postSend input[name=end_time]').val());
                        data.append('deadline',$('#postSend input[name=deadline]').val());
                        data.append('content',ue1.getContent());

                        $.ajax({
                            url:'/match',
                            type:'post',
                            data:data,
                            dataType:'json',
                            // 直接使用FormData发送表单设置选项
//                             contentType: false,
                             processData: false,
                            beforeSend:function () {
                                $('#postSend button').eq(0).click();
                                console.log("正在发送请求");
                                // 发送请求时添加弹窗
                            },
                            success:function (data) {
                                // console.log(data);
                                if(data.status==200){
                                    $("#hint").click();
                                    $("#hint_form h4").html(data.msg);
                                    $("#hint_form p").html("恭喜项目发布成功");
                                }else if(data.status==400){
                                    $("#hint").click();
                                    $("#hint_form h4").html(data.msg);
                                    $("#hint_form p").html("抱歉项目发布成功");
                                }else{
                                    $("#hint").click();
                                    $("#hint_form h4").html("未知错误");
                                    $("#hint_form p").html("抱歉出现位置错，请刷新页面再次进行添加");
                                }
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown){
                                console.log(XMLHttpRequest.status);
                                console.log(XMLHttpRequest.readyState);
                                console.log(textStatus);
                                console.log(errorThrown);
                            }
                        });
                    }
                });
                // validate signup form on keyup and submit
                this.$signupForm.validate({
                    rules: {
                        name: {
                            required: true
                        },
                        order:{
                            required: true,
                            digits:true
                        },
                        org:{
                            required: true
                        },
                        content:{
                            required: true
                        },
                        peoples:{
                            required: true,
                            digits:true,
                            min:5
                        }
                    },
                    //提示信息
                    messages: {
                        name: {
                            required: "请输入比赛名称"
                        },
                        order:{
                            required:"注意不能为空",
                            digits:"注意必须要为整数"
                        },
                        org:{
                            required:"注意不能为空"
                        },
                        content:{
                            required:"注意不能为空"
                        },
                        peoples:{
                            required:"同志这个不能为空",
                            digits:"同志这个必须是数字",
                            min:"这个活动至少5个人吧"
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
        // 数据请求，和遍历
        function quest(num){
            num = num||1;
            $.ajax({
                url:'/match/'+num,
                type:'get',
                dataType:"json",
                beforeSend:function () {
                    console.log("数据请求中...");
                },
                success:function (data) {
                    console.log("数据获取成功");
                    for (var i=0;i<data.length;i++){
                        $(".span").append(
                            '<tr class="gradeX">'+
                            '<td>'+data[i].name+'</td>'+
                            '<td>'+data[i].order+'</td>'+
                            '<td>'+data[i].org+'</td>'+
                            '<td>'+data[i].peoples+'</td>'+
                            '<td>'+data[i].start_time+'</td>'+
                            '<td>'+data[i].end_time+'</td>'+
                            '<td>'+data[i].deadline+'</td>'+
                            '<td>'+data[i].up_time+'</td>'+
                            '<td>'+data[i].content+'</td>'+
                            '<td class="actions">'+
                            '<a href="javascript:;" id="left" data-name='+data[i].guid+' class="on-default edit-row"><i class="fa fa-pencil" title="修改"></i></a>'+
                            '<a href="javascript:;" id="right"  data-name='+data[i].guid+' class="on-default remove-row"><i class="fa fa-trash-o" title="删除"></i></a>'+
                            '</td>'
                        );
                    }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown){
                    console.log("很遗憾数据没有请求成功");
                    // console.log(XMLHttpRequest.status);
                    // console.log(XMLHttpRequest.readyState);
                    // console.log(textStatus);
                    // console.log(errorThrown);
                }
            });
        }
        // 请求数据成功
        quest();
        // 获取修改数据
        $(document).on('click','#left',function(){
            var data = this.getAttribute ('data-name');
            $.ajax({
                url:'match/'+data+'/edit',
                type:'get',
                processData:true,
                beforeSend:function(){
                    console.log("正在获取数据");
                },
                success:function(data){
                    console.log(data);
                    console.log(data[0].name);
                    $('#alter').click();
                     // $("#altersend input[name=name]").val(data.name);
                    $('#altersend input[name=name]').attr('placeholder',data[0].name);
                    $('#altersend input[name=order]').attr('placeholder',data[0].order);
                    $('#altersend input[name=org]').attr('placeholder',data[0].org);
                    $('#altersend input[name=peoples]').attr('placeholder',data[0].peoples);
                    $('#altersend input[name=start_time]').val(data[0].start_time);
                    $('#altersend input[name=end_time]').val(data[0].end_time);
                    ue2.setContent(data[0].content);
                    $("#alter_road").attr("data-guid",data[0].guid);
                },
                error:function () {
                    console.log("获取数据失败");
                }
            });
        });
        // 提交编辑
        $("#alter_road").click(function(){
            var data = new FormData($("#altersend"));
//            var result = {
//
//            };
            data.append('name',$('#altersend input[name=name]').val());
            data.append('order',$('#altersend input[name=order]').val());
            data.append('org',$('#altersend input[name=org]').val());
            data.append('peoples',$('#altersend input[name=peoples]').val());
            data.append('start_time',$('#altersend input[name=start_time]').val());
            data.append('end_time',$('#altersend input[name=end_time]').val());
            data.append('deadline',$('#altersend input[name=deadline]').val());
            data.append('content',ue2.getContent());
            var guid = $("#alter_road").attr("data-guid");
            $.ajax({
                url:'/match/'+guid,
                type:'put',
                data:data,
                dataType:'json',
                // 直接使用FormData发送表单设置选项
                contentType: false,
                processData: false,
                beforeSend:function () {
//                                    $('#postSend button').eq(0).click();
                    console.log("正在发送请求");
                    // 发送请求时添加弹窗
                },
                success:function (data) {
                    console.log(data);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error : function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(XMLHttpRequest.status);
                    console.log(XMLHttpRequest.readyState);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            })
            return false;
        });
        // 删除数据
        $(document).on('click','#right',function(){
            var data = this.getAttribute ('data-name');
            alert(data);

        });
        // 换页面
    </script>
    {{--添加培训--}}
@endsection