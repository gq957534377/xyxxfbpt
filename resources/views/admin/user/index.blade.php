@extends('admin.layouts.master')
@section('styles')
    <style>
        .loading{z-index:999;position:absolute;display: none;}
        #alert-info{padding-left:10px;}
        table{font-size:14px;}
        .table button{margin-right:15px;}
        .page-title{ padding-bottom: 5px;}
    </style>
@endsection
{{--展示内容开始--}}
@section('content')

    <div class="btn-toolbar" role="toolbar">

        {{--<div class="btn-group">--}}
            {{--<button type="button" data-name="user_normal" onclick="getInfo(1)" title="普通用户" role="1" status="1" class="user_list btn btn-default">普通用户</button>--}}
        {{--</div>--}}
        {{--<div class="btn-group">--}}
            {{--<button type="button" data-name="user_entrepreneurs" title="创业者用户" onclick="getInfo(2)" role="2" status="1" class="user_list btn btn-default">创业者用户</button>--}}
        {{--</div>--}}
        {{--<div class="btn-group">--}}
            {{--<button type="button" data-name="user_investor" title="投资者用户" role="3" status="1" class="user_list btn btn-default">投资者用户</button>--}}
        {{--</div>--}}
        {{--<div class="btn-group">--}}
            {{--<button type="button" data-name="user_investor" memeber="3" role="memeber" status="1" class=" btn btn-default user_memeber_list" title="英雄会成员">英雄会成员</button>--}}
        {{--</div>--}}

        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">用户类型
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list"  onclick="getInfo(1)" title="普通用户">普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  onclick="getInfo(2)" title="创业者用户">创业者用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  onclick="getInfo(3)" title="投资者用户">投资者用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  onclick="getInfo(4)" title="英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">待审核
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list" title="待审核创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" title="待审核投资者用户" >投资者</a>
                </li>
                <li>
                    <a   class="user_role_list"  title="待审核英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">审核失败
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="user_role_list" title="审核失败创业者用户">创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" title="审核失败投资者用户">投资者</a>
                </li>
                <li>
                    <a class="user_role_list"  title="审核失败英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">已禁用
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="user_role_list" title="已禁用普通用户" >普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list" title="已禁用创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" title="已禁用投资者用户" >投资者</a>
                </li>
                <li>
                    <a  class="user_role_list"  title="已禁用英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">已停用
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list" title="已停用普通用户" >普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list" title="已停用创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" title="已停用投资者用户" >投资者</a>
                </li>
                <li>
                    <a class="user_role_list"  title="已停用英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
    </div>

    {{--<img src="{{asset('admin/images/load.gif')}}" class="loading">--}}

    <div class="page-title">
        <h5 id="user_title" class="title text-center">普通用户</h5>
    </div>

    {{--表格盒子开始--}}
    <div class="panel" id="data" style="text-align: center"></div>
    {{--表格盒子结束--}}

@endsection
{{--展示内容结束--}}

{{--弹出页面 开始--}}
@section('form-id', 'con-modal')
@section('form-title', '提示信息：')
@section('form-body')
    <div class="row" id="alert-form"></div>
    <div id="alert-info"></div>
@endsection
@section('form-footer')
    <button type="button" id="post" class="btn btn-info hidden">提交</button>
    <button type="button" id="cancel" class="btn btn-info hidden" data-dismiss="modal">取消</button>

    <button type="button" class="btn check_pass hidden">通过</button>

    <button type="button" class="btn check_fail btn-warning hidden">不通过</button>

    <button type="button" class="btn change_memeber_false btn-warning hidden">不通过2</button>

    <button type="button" id="close" class="btn btn-info hidden" data-dismiss="modal">Close</button>

@endsection
{{--弹出页面结束--}}

{{--警告信息弹层开始--}}
{{--@section('alertInfo-title', 'xxxxxxx')--}}
{{--@section('alertInfo-body', 'yyyyyyyy')--}}
{{--警告信息弹层结束--}}

@section('script')

    {{--<script>--}}

        {{--function getInfo(n) {--}}
            {{--$('#data').html(n);--}}
        {{--}--}}
    {{--</script>--}}

    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    {{--<script src="{{asset('JsService/Model/user/html.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('JsService/Model/user/function.js')}}" type="text/javascript"></script>--}}



    {{--<script>--}}
        {{--var number = 0;--}}

        {{--//初始化 请求数据 包含分页数据 添加事件--}}
        {{--$(function () {--}}
            {{--$("button[title='普通用户']").click();--}}
        {{--});--}}

    {{--</script>--}}

    <script>
        //定义用户角色表格相关按钮事件  待审核、审核失败
        $('.user_role_list').click(function(){
            $('#user_title').html($(this).attr('title'));

            return;
            var memeber = $(this).attr('memeber'), status = $(this).attr('status'), role = $(this).attr('role');
            $.ajax({
                url:'/user_role/list',
                type:'get',
                data:{
                    status:status,
                    role:role,
                    memeber:memeber
                },
                success:function(data){
                    if (data.data.length==0) return $('#data').html('暂无数据哦');



                }
            })
        });



    </script>

@endsection