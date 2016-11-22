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
                    <div id="lookStatus" style="float: right;">
                        <button zxz-status="1"  class="btn btn-success">查看发布项目</button>
                        <button zxz-status="0" class="btn">查看下架项目</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                            <table id="datatable" class="table table-condensed table-striped table-bordered">

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
                    <button type="button" id="supperButton" class="btn btn-danger">确认</button>
                </div>
            </div>
        </div>
    </div>
@include("Tool.Ajax")
<script>
    var dataStore = null;
    var objStore = null;
    var nowPage = 1;//当前页码；
    var lookStatus = 1;//查看的状态
    forPage("crowd_forpage?nowPage=1");
    /* 异步获取分页内容及样式 */
    function forPage(url) {
        var forpageAjax = new AjaxWork(url,"get");
        forpageAjax.upload({status:lookStatus},function (data) {
            if(data.StatusCode == "200"){

                if(data.ResultData.data.length!=0){
                    $("#pageCenter").html(data.ResultData.page.pages);
                    nowPage = data.ResultData.page.nowPage;
                    createHtml(data.ResultData.data);
                }else{
                    $("#pageCenter").html("");
                    createHtml(data.ResultData.data);
                }
                pageAddClick();
                buttonOnClick();
            }else {
                alert(data.ResultData)
            }
        })
    }
    // 创建DOM元素
    function createHtml(data) {
        if(data.length==0){
            $("#datatable").html("<thead ><tr><th>亲，暂无数据哦O(∩_∩)O~</th></tr></thead>")
        }else{
            var html ="";
            html+="<thead>";
            html+="<tr>"
            html+="<th>项目ID</th>"
            html+="<th>项目名称</th>"
            html+="<th>已筹资金</th>"
            html+="<th>目标资金</th>"
            html+="<th>项目属性</th>"
            html+="<th>到期日期</th>"
            html+="<th>管理</th>"
            html+="</tr>"
            html+="</thead>"
            html+="<tbody id='case'>"
            html+="</tbody>"
            $("#datatable").html(html);
            var htmls ="";
            for(var key in data){
                htmls+="<tr>"
                htmls+="<td>"+data[key].project_id+"</td>";
                htmls+="<td>"+data[key].title+"</td>";
                htmls+="<td>"+data[key].fundraising_now+"</td>";
                htmls+="<td>"+data[key].fundraising+"</td>";
                htmls+="<td>"+data[key].project_type+"</td>";
                htmls+="<td>"+data[key].endtime+"</td>";
                htmls+="<td>"+data[key].btn+"</td>";
                htmls+="</tr>"
            }
            $("#case").html(htmls);
        }
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
            plotForm(type,datas);//绘制弹框
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
        case "selectPub":selectPub("selectPub",data);break;
        case "see":seeFrom(data);break;
        default :closeFrom(type,data);
    }
}
//制造重新发布模态框内容
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
                            "开始日期" +
                        "</label>" +
                        "<input type='text'  class='form-control some_class' id='field-3s' >" +
                    "</div>" +
                    "<div class='col-md-4'>" +
                        "<label for='field-3' class='control-label'>" +
                            "结束日期" +
                        "</label>" +
                        "<input type='text' class='form-control some_class' id='field-5s' >" +
                    "</div>" +
                "</div>"+
                "<div class='row'>" +
                    "<div class='col-md-4'>" +
                        "<div class='form-group'>" +
                            "<label for='field-4' class='control-label'>" +
                                "预筹资金(￥)" +
                            "</label>" +
                            "<input type='text' class='form-control' id='field-4' >" +
                        "</div>" +
                    "</div>" +
                    "<div class='col-md-4'>" +
                        "<div class='form-group'>" +
                            "<label for='field-4' class='control-label'>" +
                                "众筹简介" +
                            "</label>" +
                            "<input type='text' class='form-control' id='field-6' value="+data.simple_info+" >" +
                        "</div>" +
                    "</div>" +
                    "<div class='col-md-4'>" +
                        "<div class='form-group'>" +
                            "<label for='field-4' class='control-label'>" +
                                "奖励信息" +
                            "</label>" +
                            "<input type='text' class='form-control' id='field-7' value="+data.donors_info+" >" +
                        "</div>" +
                    "</div>" +
                "</div>" +
                "<div class='row'>" +
                    "<div class='col-md-12'>" +
                        "<div class='form-group no-margin'>" +
                            "<label for='field-5' class='control-label'>" +
                                "项目简介" +
                            "</label>" +
                            "<textarea class='form-control autogrow' id='field-8' style='overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;'  style='resize: none'>"+
                                data.info+
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
    dateTime();
}
    //开启验证
    function startVerification() {
        $("#field-3,#field-4,#addDay,#addHour,#field-5").keyup(function () {
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
        if(data[0]){
            var html = "";
            html += "<table  class='table table-condensed table-striped table-bordered'>"
            html+="<thead>";
            html+="<tr>"
            html+="<th>ID</th>"
            html+="<th>投资者ID</th>"
            html+="<th>投资金额</th>"
            html+="<th>投资日期</th>"
            html+="</tr>"
            html+="</thead>"
            html+="<tbody id='caseData'>"
            html+="</tbody>"
            html += "</table>"
            html += "<div id='Type' style='display: none'>"
            html += type
            html += "</div>";
            $("#plotDiv").html(html);
            var htmls = "";
            console.log(data);
            for(var key in data){
                htmls+="<tr>"
                htmls+="<td>"+data[key].id+"</td>";
                htmls+="<td>"+data[key].user_id+"</td>";
                htmls+="<td>"+data[key].money+"</td>";
                htmls+="<td>"+data[key].addtime+"</td>";
                htmls+="</tr>";
            }
            $("#caseData").html(htmls);
            formShow();
        }else{
            var temp = "";
            temp += "<h1>";
            temp += "亲，暂无数据哦！O(∩_∩)O~";
            temp += "</h1>";
            temp += "<div id='Type' style='display: none'>";
            temp += type;
            temp += "</div>";
            $("#plotDiv").html(temp);
            formShow();
        }
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
//模态框确认按钮点击事件
$("#supperButton").click(function () {
    var type = $("#Type").html();
    if(type == "close"){
        var projectId = $("#ProjectId").html()
    }
    switch (type){
        case "publish":startCrowdfunding();break;
        case "revise" :formHide();break;
        case "selectPub":newPub();break;
        case "see":formHide();break;
        default:closeCrowdfunding(projectId);
    }
})
    //重新上架
function startCrowdfunding() {
    var project_id = $("#field-1").val();
    var project_type = $("#selects").val();
    var days = $("#field-3s").val();
    var enddays = $("#field-5s").val();
    var donors_info = $("#field-7").val();
    var info = $("#field-8").val();
    var simple_info = $("#field-6").val();
    var fundraising = $("#field-4").val();
    var tokens = "{{csrf_token()}}";
    if(fundraising&&project_id&&project_type&&days&&enddays&&donors_info&&info&&simple_info){
        var ajaxFunction = new AjaxWork("/project_approval/updata","PATCH");
        ajaxFunction.upload({_token:tokens,project_id:project_id,fundraising:fundraising,project_type:project_type,enddays:enddays,days:days,simple_info:simple_info,donors_info:donors_info,info:info,simple_info:simple_info,_method:"put"},successPublishi,errFunction,beforeFunction);
    }else{
        alert("以上内容不可为空！")
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
                html+= "<option value='hehe'>===请切换内容===</option>"
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
            if(Id == "hehe"){
                $("#creatPub").html("");
            }else {
                createPub(Id);
            }
        })
    }
    //创建发布模板
    function createPub(Id) {
        var data = dataStore;
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
                "项目介绍" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-2' value='"+data[Id]['content']+"'>" +
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
                "开始日期" +
                "</label>" +
                "<input type='text' class='form-control some_class' id='field-3s' >" +
                "</div>" +
                "<div class='col-md-4'>" +
                "<label for='field-3' class='control-label'>" +
                "结束日期" +
                "</label>" +
                "<input type='text' class='form-control some_class' id='field-4s' >" +
                "</div>" +
                "</div>"+
                "<div class='row'>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "预筹资金(￥)" +
                "</label>" +
                "<input type='text' class='form-control' id='field-5' >" +
                "</div>" +
                "</div>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "众筹简介" +
                "</label>" +
                "<input type='text' class='form-control' id='field-6' >" +
                "</div>" +
                "</div>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "奖励信息" +
                "</label>" +
                "<input type='text' class='form-control' id='field-7' >" +
                "</div>" +
                "</div>" +
                "</div>"+
                "<div class='row'>" +
                "<div class='col-md-12'>" +
                "<div class='form-group no-margin'>" +
                "<label for='field-5' class='control-label'>" +
                "众筹详情" +
                "</label>" +
                "<textarea class='form-control autogrow' id='field-8' style='overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;'  style='resize: none'>"+
                "</textarea>" +
                "</div>" +
                "</div>" +
                "</div>"+"<input type='hidden' value='"+data[Id]['guid']+"'id='guid'>"
        $("#creatPub").html(html);
        startVerification();
        dateTime();
    }
    //发布新众筹
    function newPub() {
        var project_id = $("#field-1").val();
        var guid = $("#guid").val();
        var selectIndex = document.getElementById("selectPubs").selectedIndex;
        var title = document.getElementById("selectPubs").options[selectIndex].text
        var project_type = $("#selects").val();
        var startdays = $("#field-3s").val();
        var enddays = $("#field-4s").val();
        var donors_info = $("#field-7").val();
        var info = $("#field-8").val();
        var simple_info = $("#field-6").val();
        var fundraising = $("#field-5").val();
        var tokens = "{{csrf_token()}}";
        if(fundraising&&project_id&&guid&&title&&project_type&&startdays&&enddays&&donors_info&&info&&simple_info){
            var ajaxFunction = new AjaxWork("/project_approval/publish","PATCH");
            ajaxFunction.upload({_token:tokens,project_id:project_id,fundraising:fundraising,project_type:project_type,enddays:enddays,days:startdays,simple_info:simple_info,guid:guid,donors_info:donors_info,info:info,simple_info:simple_info,_method:"put",title:title},successPublishi,errFunction,beforeFunction);
        }else{
            alert("以上内容不可为空！")
        }
    }
    //查看众筹信息
    function seeFrom(data) {
        var html = "<div class='row'>" +
                "<div class='col-md-6'>" +
                "<div class='form-group'>" +
                "<label for='field-1' class='control-label'>                                                     项目ID" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-1' value='"+data['project_id']+"'>" +
                "</div>" +
                "</div>" +
                "<div class='col-md-6'>" +
                "<div class='form-group'>" +
                "<label for='field-2' class='control-label'>" +
                "项目标题" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-2' value='"+data['title']+"'>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class='row'>" +
                "<div class='col-md-4'>" +
                "<label for='field-3' class='control-label'>" +
                "项目分类" +
                "</label>" +
                "<select disabled id='selects' class='form-control'>" +
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
                "截止日期" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-3' value='"+data["endtime"]+"' >" +
                "</div>" +
                "<div class='col-md-4'>" +
                "<label for='field-3' class='control-label'>" +
                "开始日期" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-4' value='"+data["starttime"]+"'>" +
                "</div>" +
                "</div>"+
                "<div class='row'>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "预筹资金(￥)" +
                "</label>" +
                "<input type='text' class='form-control' readonly id='field-5' value='"+data["fundraising"]+"' >" +
                "</div>" +
                "</div>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "众筹简介" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-6' value='"+data["simple_info"]+"' >" +
                "</div>" +
                "</div>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "奖励信息" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-7'value='"+data["donors_info"]+"' >" +
                "</div>" +
                "</div>" +
                "</div>"+
                "<div class='row'>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "已筹资金(￥)" +
                "</label>" +
                "<input type='text' readonly class='form-control' value='"+data["fundraising_now"]+"' >" +
                "</div>" +
                "</div>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "参与人数(人)" +
                "</label>" +
                "<input type='text' readonly class='form-control' value='"+data["Number_of_participants"]+"' >" +
                "</div>" +
                "</div>" +
                "<div class='col-md-4'>" +
                "<div class='form-group'>" +
                "<label for='field-4' class='control-label'>" +
                "创建日期" +
                "</label>" +
                "<input type='text' readonly class='form-control' id='field-7'value='"+data["addtime"]+"' >" +
                "</div>" +
                "</div>" +
                "</div>"+
                "<div class='row'>" +
                "<div class='col-md-12'>" +
                "<div class='form-group no-margin'>" +
                "<label for='field-5' class='control-label'>" +
                "众筹详情" +
                "</label>" +
                "<textarea class='form-control autogrow' id='field-8' style='overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;' readonly style='resize: none'>"+
                        data["info"]+
                "</textarea>" +
                "</div>" +
                "</div>" +
                "</div>"+"<input type='hidden' value='see'id='guid'>"
        $("#plotDiv").html(html);
        $("#selects").val(data["project_type"])
        formShow();
    }
    $("#lookStatus button").click(function () {
        lookStatus = $(this).attr("zxz-status");
        $("#lookStatus button").removeClass("btn-success");
        $(this).addClass("btn-success");
        forPage("crowd_forpage?nowPage="+nowPage);
    })
    //时间插件
    function dateTime() {
        $.datetimepicker.setLocale('en');
        $('#datetimepicker_format').datetimepicker({value:'2015/04/15 05:03', format: $("#datetimepicker_format_value").val()});
        console.log($('#datetimepicker_format').datetimepicker('getValue'));

        $("#datetimepicker_format_change").on("click", function(e){
            $("#datetimepicker_format").data('xdsoft_datetimepicker').setOptions({format: $("#datetimepicker_format_value").val()});
        });
        $("#datetimepicker_format_locale").on("change", function(e){
            $.datetimepicker.setLocale($(e.currentTarget).val());
        });

        $('#datetimepicker').datetimepicker({
            dayOfWeekStart : 1,
            lang:'en',
            disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
            startDate:	'1986/01/05'
        });
        $('#datetimepicker').datetimepicker({value:'2015/04/15 05:03',step:10});

        $('.some_class').datetimepicker();

        $('#default_datetimepicker').datetimepicker({
            formatTime:'H:i',
            formatDate:'d.m.Y',
            //defaultDate:'8.12.1986', // it's my birthday
            defaultDate:'+03.01.1970', // it's my birthday
            defaultTime:'10:00',
            timepickerScrollbar:false
        });

        $('#datetimepicker10').datetimepicker({
            step:5,
            inline:true
        });
        $('#datetimepicker_mask').datetimepicker({
            mask:'9999/19/39 29:59'
        });

        $('#datetimepicker1').datetimepicker({
            datepicker:false,
            format:'H:i',
            step:5
        });
        $('#datetimepicker2').datetimepicker({
            yearOffset:222,
            lang:'ch',
            timepicker:false,
            format:'d/m/Y',
            formatDate:'Y/m/d',
            minDate:'-1970/01/02', // yesterday is minimum date
            maxDate:'+1970/01/02' // and tommorow is maximum date calendar
        });
        $('#datetimepicker3').datetimepicker({
            inline:true
        });
        $('#datetimepicker4').datetimepicker();
        $('#open').click(function(){
            $('#datetimepicker4').datetimepicker('show');
        });
        $('#close').click(function(){
            $('#datetimepicker4').datetimepicker('hide');
        });
        $('#reset').click(function(){
            $('#datetimepicker4').datetimepicker('reset');
        });
        $('#datetimepicker5').datetimepicker({
            datepicker:false,
            allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00'],
            step:5
        });
        $('#datetimepicker6').datetimepicker();
        $('#destroy').click(function(){
            if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
                $('#datetimepicker6').datetimepicker('destroy');
                this.value = 'create';
            }else{
                $('#datetimepicker6').datetimepicker();
                this.value = 'destroy';
            }
        });
        var logic = function( currentDateTime ){
            if (currentDateTime && currentDateTime.getDay() == 6){
                this.setOptions({
                    minTime:'11:00'
                });
            }else
                this.setOptions({
                    minTime:'8:00'
                });
        };
        $('#datetimepicker7').datetimepicker({
            onChangeDateTime:logic,
            onShow:logic
        });
        $('#datetimepicker8').datetimepicker({
            onGenerate:function( ct ){
                $(this).find('.xdsoft_date')
                        .toggleClass('xdsoft_disabled');
            },
            minDate:'-1970/01/2',
            maxDate:'+1970/01/2',
            timepicker:false
        });
        $('#datetimepicker9').datetimepicker({
            onGenerate:function( ct ){
                $(this).find('.xdsoft_date.xdsoft_weekend')
                        .addClass('xdsoft_disabled');
            },
            weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
            timepicker:false
        });
        var dateToDisable = new Date();
        dateToDisable.setDate(dateToDisable.getDate() + 2);
        $('#datetimepicker11').datetimepicker({
            beforeShowDay: function(date) {
                if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
                    return [false, ""]
                }

                return [true, ""];
            }
        });
        $('#datetimepicker12').datetimepicker({
            beforeShowDay: function(date) {
                if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
                    return [true, "custom-date-style"];
                }

                return [true, ""];
            }
        });
        $('#datetimepicker_dark').datetimepicker({theme:'dark'})
    }
</script>

@endsection
