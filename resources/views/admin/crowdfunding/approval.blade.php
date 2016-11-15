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
                    <button id="publishBtn" class="btn  btn-info">发布众筹</button>
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
                                    <th>到期日期</th>
                                    <th>管理</th>
                                </tr>
                                </thead>
                                <tbody id="case">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Row -->
</div>
<center id="imgLoad" style="display: none"><img src="/admin/images/load.gif" style="position: absolute;top:300px;"></center>
<center id="pageCenter">

</center>
    <button id="modals" style="display: none" class="btn btn-primary" data-toggle="modal" data-target="#con-close-modalssss">表单弹窗</button>
    <div id="con-close-modalssss" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">琦立英雄众筹管理系统</h4>
                </div>
                <div class="modal-body" id="plotDiv">
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
    var dataStore = null;
    var objStore = null;
    var nowPage = 1;//当前页码；
    forPage("crowd_forpage?nowPage=1");
    /* 异步获取分页内容及样式 */
    function forPage(url) {
        var forpageAjax = new AjaxWork(url,"get");
        forpageAjax.upload({},function (data) {
            if(data.StatusCode == "200"){
                $("#pageCenter").html(data.ResultData.page.pages);
                nowPage = data.ResultData.page.nowPage;
                createHtml(data.ResultData.data);
                pageAddClick();
                buttonOnClick();
            }else {
                alert(data.ResultData)
            }
        })
    }
    // 创建DOM元素
    function createHtml(data) {
        var html ="";
        for(var i =0;i<data.length;i++){
            html+="<tr>"
            html+="<td>"+data[i]['project_id']+"</td>";
            html+="<td>"+data[i]['title']+"</td>";
            html+="<td>"+data[i]['fundraising_now']+"</td>";
            html+="<td>"+data[i]['fundraising']+"</td>";
            html+="<td>"+data[i]['project_type']+"</td>";
            html+="<td>"+data[i]['endtime']+"</td>";
            html+="<td>"+data[i]['btn']+"</td>";
            html+="</tr>"
        }
        $("#case").html(html);
    }
    // 初始化分页按钮，绑定点击事件
    function pageAddClick() {
        $(".pagination li a").click(function () {
            var pageUrl = $(this).attr("href");
            forPage(pageUrl);
            return false;
        })
    }
    // 初始化工具按钮，绑定点击事件
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
    if(type == "close"){
        plotForm(type,id);
    }else{
        ajaxRequest(id,type);//执行ajax请求
    }
}
//ajax请求成功后的方法；
var successFunction = function (data) {
    if(data.StatusCode == "200"){
        $("#imgLoad").css({"display":"none"});
        var type = data.ResultData.type;
        delete data.ResultData.type;
        if(type == "close"){
            objStore.parent("div").html("<button zxz-type='publish' class='btn btn-sm btn-primary '><i class='fa fa-keyboard-o'></i> </button><button zxz-type='revise' class='btn btn-sm btn-success '> <i class='fa fa-wrench'></i> </button>");
            buttonOnClick();
            forPage("crowd_forpage?nowPage="+nowPage);
            formHide();
            alert("下架成功！");
        }else{
            var datas = data.ResultData;
            plotForm(type,datas[0]);//绘制弹框
        }
    }else {
        alert(data.ResultData)
    }
}
//ajax失败后的方法
var errFunction = function(err){
    $("#imgLoad").css({"display":"none"});
    alert("请求失败！")
}
//ajax发送前的方法
var beforeFunction = function () {
    $("#imgLoad").css({"display":"block"});
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
        case "selectPub":selectPub("publish",data);break;
        default :closeFrom(type,data);
    }
}
//制造发布模态框内容
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
                    "<div class='col-md-4'>" +
                        "<label for='field-3' class='control-label'>" +
                            "预筹天数(天)" +
                        "</label>" +
                        "<input type='number' class='form-control' id='field-3' >" +
                    "</div>" +
                "</div>"+
                "<div class='row'>" +
                    "<div class='col-md-12'>" +
                        "<div class='form-group'>" +
                            "<label for='field-4' class='control-label'>" +
                                "预筹资金(￥)" +
                            "</label>" +
                            "<input type='number' class='form-control' id='field-4' >" +
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
    startVerification();
    formShow();
}
//开启验证
function startVerification() {
    $("#field-3,#field-4,#addDay,#addHour").keyup(function () {
        var temp = parseInt($(this).val());
        if(isNaN(temp)) {
            $(this).val("");
            alert("请输入数字！")
        }else{
            $(this).val(temp)
        }
    })
}
function reviseFrom(type,data)
{
    var html ="<div class='row'>" +
            "<div class='col-md-6'>" +
            "<div class='form-group'>" +
            "<label for='field-1' class='control-label'>                                                     项目ID" +
            "</label>" +
            "<input type='text' readonly  class='form-control' id='field-1' value='"+data.project_id+"'>" +
            "</div>" +
            "</div>" +
            "<div class='col-md-6'>" +
            "<div class='form-group'>" +
            "<label for='field-2' class='control-label'>" +
            "项目名称" +
            "</label>" +
            "<input type='text' readonly  class='form-control' id='field-2' value='"+data.title+"'>" +
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
            "<div class='col-md-4'>" +
            "<label for='field-3' class='control-label'>" +
            "预筹剩余天数(天)" +
            "</label>" +
            "<input type='text' class='form-control' id='field-3' readonly value='"+data.endtime+"' >" +
            "</div>" +
            "<div class='col-sm-2'>" +
            "<label for='field-3' class='control-label'>" +
            "追加日期(天)" +
            "</label>" +
            "<input type='text' class='form-control' id='addDay' value='' >" +
            "</div>" +
            "<div class='col-sm-2'>" +
            "<label for='field-3' class='control-label'>" +
            "追加小时(时)" +
            "</label>" +
            "<input type='text' class='form-control' id='addHour' value='' >" +
            "</div>" +
            "</div>"+
            "<div class='row'>" +
            "<div class='col-md-12'>" +
            "<div class='form-group'>" +
            "<label for='field-4' class='control-label'>" +
            "预筹资金(￥)" +
            "</label>" +
            "<input type='number' class='form-control' id='field-4' value='"+data.fundraising+"'>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class='row'>" +
            "<div class='col-md-12'>" +
            "<div class='form-group no-margin'>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div id='Type' style='display: none'>"+
            type+
            "</div>";
            $("#plotDiv").html(html);
            $("#selects").val(data.project_type);
            startVerification();
            formShow();
}

//
function closeFrom(type,data) {
    var html ="<h1>确认要下架该项目么？</h1><div id='Type' style='display: none'>"+
            type+
            "</div><div id='ProjectId' style='display: none'>"+
            data+
            "</div>";
    $("#supperButton").html("确认").removeClass("btn-info").addClass("btn-danger");
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

//发布成功后的回调方法
var successPublishi = function (data) {
    $("#imgLoad").css({"display":"none"});
    if(data.StatusCode == "200"){
        alert("发布成功!");
        formHide();
        forPage("crowd_forpage?nowPage="+nowPage);
        objStore.remove();
    }else {
        alert(data.ResultData)
    }
}
//修改成功后的回调方法
var successRevise = function (data) {
    $("#imgLoad").css({"display":"none"});
    if(data.StatusCode == "200"){
        alert("修改成功!");
        formHide();
        forPage("crowd_forpage?nowPage="+nowPage);
    }else {
        alert(data.ResultData)
    }
}
//确认按钮点击事件
$("#supperButton").click(function () {
    var type = $("#Type").html();
    if(type == "close"){
        var projectId = $("#ProjectId").html()
    }
    switch (type){
        case "publish":startCrowdfunding();break;
        case "revise" :revise();break;
        case "selectPub":newPub();break;
        default:closeCrowdfunding(projectId);
    }
})
    //重新上架
function startCrowdfunding() {
    var targetFund = $("#field-4").val();
    var days = $("#field-3").val();
    var ID = $("#field-1").val();
    var tokens = "{{csrf_token()}}";
    var Typeclass =$("#selects").val();
    var ajaxFunction = new AjaxWork("/project_approval","post");
    if(targetFund&&days&&ID&&Typeclass){
        ajaxFunction.upload({_token:tokens,project_id:ID,fundraising:targetFund,project_type:Typeclass,days:days},successPublishi,errFunction,beforeFunction);
    }else{
        alert("以上内容不得为空！");
    }
}

//修改内容方法
function revise() {
    var targetFund = $("#field-4").val();
    var days = $("#addDay").val();
    var hour =  $("#addHour").val();
    var ID = $("#field-1").val();
    var tokens = "{{csrf_token()}}";
    var Typeclass =$("#selects").val();
    var ajaxFunction = new AjaxWork("/crowdfunding_revise","post");
    if(targetFund&&days&&hour&&ID&&Typeclass){
        ajaxFunction.upload({_token:tokens,project_id:ID,fundraising:targetFund,project_type:Typeclass,days:days,hour:hour},successRevise,errFunction,beforeFunction);
    }else{
        alert("以上内容不得为空！");
    }
}
function closeCrowdfunding(id) {
    ajaxRequest(id,"close");
}
    /**
     * 11.14新增修改内容
     *
     */
    //发布众筹按钮点击事件
    $("#publishBtn").click(function () {
    var ajaxFunction = new AjaxWork("/select_publish","get");
    ajaxFunction.upload({},function (data) {
        if(data.StatusCode == "200"){
            $("#imgLoad").css({"display":"none"});
            plotForm("selectPub",data.ResultData);
        }else {
            alert(data.ResultData)
        }

    },errFunction,beforeFunction)
})
    //生成发布表单
    function selectPub(type,data) {
        dataStore = data;
        var html = "<div class='row'>"
            html += "<div class='col-md-4'>"
            html += "<div class='form-group'>"
            html += "<label for='field-4' class='control-label'>可选发布内容</label>"
            html += "<select id='selectPubs' class='form-control'>"
        for(var i =0 ;i<=data.length;i++){
            var num = i-1;
            if(i == 0){
                html+= "<option>===请切换内容===</option>"
            }else {
                html+="<option value='"+num+"'>"+data[i-1]["title"]+"</option>";
            }
        }
        html += "</select>"
        html += "</div>"
        html += "</div>"
        html += "</div>";
        html +="<div id='Type' style='display: none'>"+type+"</div>"
        html+="<div id='creatPub'></div>";
        $("#plotDiv").html(html);
        stratSelect();
        formShow();
    }
    //发布表单下拉框改变事件
    function stratSelect() {
        $("#selectPubs").change(function () {
            var Id = $(this).val();
            createPub(Id);
        })
    }
    //创建发布模板
    function createPub(Id) {
        var data = dataStore;
        console.log(data);
        console.log(Id);
        var html = "<div class='row'>" +
                "<div class='col-md-6'>" +
                "<div class='form-group'>" +
                "<label for='field-1' class='control-label'>                                                     项目ID" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-1' value='"+data[Id]['project_id']+"'>" +
                "</div>" +
                "</div>" +
                "<div class='col-md-6'>" +
                "<div class='form-group'>" +
                "<label for='field-2' class='control-label'>" +
                "项目名称" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-2' value='"+data[Id]['title']+"'>" +
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
                "<div class='col-md-4'>" +
                "<label for='field-3' class='control-label'>" +
                "预筹天数(天)" +
                "</label>" +
                "<input type='number' class='form-control' id='field-3' >" +
                "</div>" +
                "</div>"+
                "<div class='row'>" +
                "<div class='col-md-12'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "预筹资金(￥)" +
                "</label>" +
                "<input type='number' class='form-control' id='field-4' >" +
                "</div>" +
                "</div>" +
                "</div>"
        $("#creatPub").html(html);
        startVerification();
    }
    function newPub() {
        startCrowdfunding();
    }
</script>

@endsection
