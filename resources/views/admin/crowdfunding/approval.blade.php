@extends('admin.layouts.master')
@section('content')
@section('title', '众筹管理')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">众筹管理</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Default Example</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                            <table id="datatable" class="table table-condensed table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>项目ID</th>
                                    <th>项目名称</th>
                                    <th>已筹资金</th>
                                    <th>目标资金</th>
                                    <th>项目属性</th>
                                    <th>发布日期</th>
                                    <th>管理</th>
                                </tr>
                                </thead>


                                <tbody id="case">
                                <tr>
                                    <td>123123123123</td>
                                    <td>123123123123</td>
                                    <td>123123123123</td>
                                    <td>123123123123</td>
                                    <td>123123123123</td>
                                    <td>123123123123</td>
                                    <td ><div class='btn-group' zxz-id='1'><button zxz-type='publish' class='btn btn-sm btn-primary '> <i class='fa fa-keyboard-o'></i> </button><button zxz-type='revise' class='btn btn-sm btn-success '> <i class='fa fa-wrench'></i> </button><button zxz-type='close' class='btn btn-sm btn-danger '> <i class="fa fa-remove"></i> </button></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Row -->
</div>
    <button id="modals" style="display: none" class="btn btn-primary" data-toggle="modal" data-target="#con-close-modalssss">表单弹窗</button>
    <div id="con-close-modalssss" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">琦立英雄众筹管理系统</h4>
                </div>
                <div class="modal-body" id="plotDiv">
                    {{--<div class='row'>--}}
                        {{--<div class='col-md-6'>--}}
                            {{--<div class='form-group'>--}}
                                {{--<label for='field-1' class='control-label'>项目ID</label>--}}
                                {{--<input type='text' readonly class='form-control' id='field-1' value='111'>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class='col-md-6'>--}}
                            {{--<div class='form-group'>--}}
                                {{--<label for='field-2' class='control-label'>项目名称</label>--}}
                                {{--<input type='text' readonly class='form-control' id='field-2' value=''>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class='row'>--}}
                        {{--<div class='col-md-12'>--}}
                            {{--<div class='form-group'>--}}
                                {{--<label for='field-3' class='control-label'>预筹资金(￥)</label>--}}
                                {{--<input type='number' class='form-control' id='field-3' >--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class='row'>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <label for='field-4' class='control-label'>City</label>
                                <input type='text' class='form-control' id='field-4' placeholder='Boston'>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <label for='field-5' class='control-label'>Country</label>
                                <input type='text' class='form-control' id='field-5' placeholder='United States'>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <label for='field-6' class='control-label'>Zip</label>
                                <input type='text' class='form-control' id='field-6' placeholder='123456'>
                            </div>
                        </div>
                    </div>
                    {{--<div class='row'>--}}
                        {{--<div class='col-md-12'>--}}
                            {{--<div class='form-group no-margin'>--}}
                                {{--<label for='field-7' class='control-label'>项目简介</label>--}}
                                {{--<textarea class='form-control autogrow' id='field-7' placeholder='Write something about yourself' style='overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;' readonly style="resize: none">                                                        </textarea>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeButton"  class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" id="supperButton" class="btn btn-info">发布</button>
                </div>
            </div>
        </div>
    </div>

@include("Tool.Ajax")
<script>
    var objStore = null;
    buttonOnClick();
    function buttonOnClick() {
        $(".btn-group button").click(function () {
            buttonClick($(this));
            objStore = $(this);
        })
    }
//点击按钮执行ajax请求
function buttonClick(obj) {
    var type = obj.attr("zxz-type");
    var id = obj.parent("div").attr("zxz-id");
    ajaxRequest(id,type);//执行ajax请求
}
//ajax请求成功后的方法；
var successFunction = function (data) {
    if(data.StatusCode == "200"){
        var type = data.ResultData.type;
        delete data.ResultData.type;
        var datas = data.ResultData;
        plotForm(type,datas[0]);//绘制弹框
    }else {
        alert(data.ResultData)
    }
}
//ajax失败后的方法
var errFunction = function(err){
    console.log(err)
}
//ajax发送前的方法
var beforeFunction = function () {
    alert("请求中!")
}
//ajax请求方法
function ajaxRequest(id,type) {
    var ajaxFunction = new AjaxWork("/project_approval/"+id+"_"+type,"get");
    ajaxFunction.upload({},successFunction,errFunction,beforeFunction);
}
//绘制相应弹框
function plotForm(type,data){
    switch (type){
        case "publish":publishFrom(type,data);break;
        case "revise":reviseFrom(type,data);break;
        default :closeFrom(data);
    }
}
function publishFrom(types,data) {
    var html = "<div class='row'>" +
                    "<div class='col-md-6'>" +
                        "<div class='form-group'>" +
                            "<label for='field-1' class='control-label'>                                                     项目ID" +
                            "</label>" +
                            "<input type='text' readonly class='form-control' id='field-1' value='"+data.project_id+"'>" +
                        "</div>" +
                    "</div>" +
                    "<div class='col-md-6'>" +
                        "<div class='form-group'>" +
                            "<label for='field-2' class='control-label'>" +
                                "项目名称" +
                            "</label>" +
                            "<input type='text' readonly class='form-control' id='field-2' value='"+data.title+"'>" +
                        "</div>" +
                    "</div>" +
                "</div>" +
                "<div class='row'>" +
                    "<div class='col-md-4'>" +
                        "<label for='field-3' class='control-label'>" +
                            "项目分类" +
                        "</label>" +
                         "<select id='selects' class='form-control'>" +
                            "<option value='0'>" +
                                "热门推荐" +
                            "</option>" +
                            "<option value='1'>" +
                                "最新发布" +
                            "</option>" +
                            "<option value='2'>" +
                                "未来科技" +
                            "</option>" +
                            "<option value='3'>" +
                                "健康出行" +
                            "</option>" +
                            "<option value='4'>" +
                                "生活美学" +
                            "</option>" +
                            "<option value='5'>" +
                                "美食生活" +
                            "</option>" +
                            "<option value='6'>" +
                                "流行文化" +
                            "</option>" +
                            "<option value='7'>" +
                                "爱心公益" +
                            "</option>" +
                        "</select>" +
                    "</div>" +
                "</div>"+
                "<div class='row'>" +
                    "<div class='col-md-12'>" +
                        "<div class='form-group'>" +
                            "<label for='field-4' class='control-label'>" +
                                "预筹资金(￥)" +
                            "</label>" +
                            "<input type='number' class='form-control' id='field-3' >" +
                        "</div>" +
                    "</div>" +
                "</div>" +
                "<div class='row'>" +
                    "<div class='col-md-12'>" +
                        "<div class='form-group no-margin'>" +
                            "<label for='field-5' class='control-label'>" +
                                "项目简介" +
                            "</label>" +
                            "<textarea class='form-control autogrow' id='field-7' placeholder='Write something about yourself' style='overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;' readonly style='resize: none'>"+
                                data.content+
                            "</textarea>" +
                        "</div>" +
                    "</div>" +
                "</div>" +
                "<div id='Type' style='display: none'>"+
                    types+
                "</div>";
    $("#plotDiv").html(html);
    formShow();
}
//显示表单
function formShow() {
    $("#modals").trigger("click");
}
//隐藏表单
function formHide() {
    $("#closeButton").trigger("click")
}

var successPublishi = function (data) {
    if(data.StatusCode == "200"){
        alert("发布成功");
        formHide();
        objStore.remove();
    }else {
        alert(data.ResultData)
    }
}
$("#supperButton").click(function () {
    var type = $("#Type").html();
    switch (type){
        case "publish":startCrowdfunding();
    }
})
function startCrowdfunding() {
    var targetFund = $("#field-3").val();
    var ID = $("#field-1").val();
    var tokens = "{{csrf_token()}}";
    var Typeclass =$("#selects").val();
    var ajaxFunction = new AjaxWork("/project_approval","post");
    ajaxFunction.upload({_token:tokens,project_id:ID,fundraising:targetFund,project_type:Typeclass},successPublishi,errFunction,beforeFunction);
}
</script>

@endsection