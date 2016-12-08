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
        
        /**
         *  获取不同类型用户的列表点击事件
         *  
         * @return  mixed   用户的列表
         * */
        $('.user_role_list').click(function(){
            //用户列表title
            $('#user_title').html($(this).attr('title'));

            return;
            //获取参数
            var url = $(this).attr('memeber');  //请求url
            var status = $(this).attr('status');
            var role = $(this).attr('role');

            //初始化请求参数
            var queryString = {
                status : '',
                role   : ''
            };

            //执行ajax请求
            doAjax(url,queryString,'get');

        });

        
        /** ajax请求，通过参数返回不同类型用户的列表
         *
         * @param   var url           string    请求url
         * @param   var querystring   json      请求参数，需要提前拼装为json格式
         * @param   var type          string    请求类型（get or post ...）
         *
         * @return  data              json      接口响应的json格式数据
         * */
        function doAjax(url,queryString,type) {
            //如果为非GET请求  携带 csrf _token 做请求验证
            if(type == post || type == put || type == delete){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
            //ajax请求
            $.ajax({
                url:url,
                type:type,
                data:queryString,
                success:function(data){
                    //没有该类型用户数据返回提示
                    if (data.status == 400) return $('#data').html('暂无数据哦');

                    //有数据，遍历数据进行DOM操作
                    $('').html(htmlStr(data));


                }
            })
        }
        
        /**
         *  HtmlStr() 用户列表标签拼装
         * 
         * @param var data      json        ajax请求返回的json格式数组
         *
         * @return var str      string      返回拼装遍历好的html标签
         * */
        function htmlStr(data) {
            //初始化变量
            var str = '';

            //公共表格头
            str +=  '<div class="panel-body">' +
                    '<table class="table table-bordered table-striped">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>item</th>' +
                    '<th>昵称</th>' +
                    '<th>姓名</th>' +
                    '<th>性别</th>' +
                    '<th>生日</th>' +
                    '<th>手机</th>' +
                    '<th>邮箱</th>' +
                    '<th>用户状态</th>' +
                    '<th>操作</th>' +
                    '</tr>' +
                    '</thead>'+
                    '<tbody>';

            //
            return str;
        }
        /**
         *
         *
         *
         *
         * */

    </script>

@endsection