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
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">用户类型
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list"  key="0"  title="普通用户">普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="1"  title="创业者用户">创业者用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="2" title="投资者用户">投资者用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="3"  title="英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">待审核
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list" key="4" title="待审核创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="5" title="待审核投资者用户" >投资者</a>
                </li>
                <li>
                    <a   class="user_role_list" key="6"  title="待审核英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">审核失败
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="user_role_list" key="7" title="审核失败创业者用户">创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="8" title="审核失败投资者用户">投资者</a>
                </li>
                <li>
                    <a class="user_role_list" key="9" title="审核失败英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">已禁用
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="user_role_list" key="10" title="已禁用普通用户" >普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list" key="11" title="已禁用创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="12" title="已禁用投资者用户" >投资者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="13" title="已禁用英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
    </div>

    {{--<img src="{{asset('admin/images/load.gif')}}" class="loading">--}}

    <div class="page-title">
        <h5 id="user_title" class="title text-center"></h5>
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
            var title = $(this).attr('title');
            var key = $(this).attr('key');

            $('#user_title').html('<h3>' + title + '</h3>');

            //获取参数
            var url = '/test/show';  //请求url

            //初始化请求参数
            var queryString = {
                key : key
            };

            //执行ajax请求
            execAjax( url, queryString, 'get');
        });

        /**
         * 点击分页列表获取点击页用户信息
         *
         */
        function pages() {
            $('.pagination li').click(function () {
                var class_name = $(this).prop('class');
                if(class_name == 'disabled' || class_name == 'active') {
                    return false;
                }
                var url = $(this).children().prop('href');

                //初始化请求参数
                var queryString = {};

                //执行ajax请求
                execAjax( url, queryString, 'get');
                return false;

            });
        }


        
        /** ajax请求，通过参数返回不同类型用户的列表
         *
         * @param   var url           string    请求url
         * @param   var querystring   json      请求参数，需要提前拼装为json格式
         * @param   var type          string    请求类型（get or post ...）
         *
         * @return  msg              json      接口响应的json格式数据 msg.ResultData[1] 用户列表，msg.ResultData[0] 分页信息。
         * */
        function execAjax( url, queryString, type) {
            //如果为非GET请求  携带 csrf _token 做请求验证
            if(type == 'post' || type == 'put' || type == 'delete'){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
            //ajax请求
            $.ajax({
                url : url,
                type : type,
                data : queryString,
                success : function(msg){
                    //没有该类型用户数据返回提示
                    if (msg.StatusCode == 400) return $('#data').html('暂无数据');
                    //alert(msg.ResultData);
                    //有数据，遍历数据进行DOM操作
                    $('#data').html(htmlStr(msg.ResultData[1]));
                    $('#page').html(msg.ResultData[0]);
                    pages();


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
        function htmlStr( data) {
            //初始化变量
            var str = '';

            //公共表格头
            str +=  '<div class="panel-body">' +
                    '<table class="table table-bordered table-striped">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>item</th>' +
                    '<th>姓名</th>' +
                    '<th>类型</th>' +
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

            $.each(data, function (i, v) {

                str += '<tr class="gradeX">';
                str +=  '<td>' + i + '</td>';
                str +=  '<td>' + v.realname + '</td>';

                if(v.role == 1){
                    str +=  '<td>普通用户</td>';
                }
                if(v.role == 2){
                    str +=  '<td>创业者</td>';
                }
                if(v.role == 3){
                    str += '<td>投资者</td>';
                }
                if(v.role == 4){
                    str += '<td>英雄会员</td>';
                }

                if(v.sex == 0){
                    str += '<td>男</td>';
                }else{
                    str +=  '<td>女</td>';
                }

                str += '<td>' + v.birthday + '</td>';
                str +=  '<td>' + v.tel + '</td>';
                str +=  '<td>' + v.email + '</td>';
                str +=  '<td>' + '&nbsp;' + '</td>';
                str +=  '<td><a href="javascript:;" data-name="' + v.guid + '" class="user_modify"><button class="btn btn-info btn-xs">修改</button></a></td></tr>';
            });
            str += '</tbody>' +
                    '</table>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-sm-8"></div>' +
                    '<div class="col-sm-4" id="page"></div>' +
                    '</div>';
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