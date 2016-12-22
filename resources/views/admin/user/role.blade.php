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
        <h2>用户审核管理</h2>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">待审核
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list" key="9" title="待审核创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="10" title="待审核投资者用户" >投资者</a>
                </li>
                <li>
                    <a   class="user_role_list" key="11"  title="待审核英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">审核失败
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="user_role_list" key="12" title="审核失败创业者用户">创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="13" title="审核失败投资者用户">投资者</a>
                </li>
                <li>
                    <a class="user_role_list" key="14" title="审核失败英雄会成员">英雄会成员</a>
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
<div id="con123" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" id="fabu">
        <div class="modal-content">
            <div id = "" class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="text-danger">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">123451313156464646465456465456444</div>
                    <div class="col-sm-4">67890464654654444444444444444444444</div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="submit" data-name="" class="btn btn-danger" id="add_road">拒绝</button>
                <button type="submit" data-name="" class="btn btn-primary" id="add_road">通过</button>
            </div>

        </div>
    </div>

</div>



@section('script')
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <script src="{{asset('admin/js/sweet-alert.min.js')}}"></script>
    <script>
        /**************************************************************************************************/
        /** 弹出确认框
         * Theme: Velonic Admin Template
         * Author: Coderthemes
         * SweetAlert -
         * Usage: $.SweetAlert.methodname
         */

        function initAlert() {
            !function($) {
                "use strict";

                var SweetAlert = function() {};

                //examples
                SweetAlert.prototype.init = function() {

                    //禁用弹出确认框
                    $('.user_modify').click(function(){
                        var guid = $(this).data('name');
                        var id = $(this).data('id');

                        //获取tr节点
                        var tr = $(this).parent().parent();
                        if(id == 2){
                            var status = '通过';
                        }else{
                            var status = '不通过';
                        }

                        swal({
                            title: "确定要"+status+"?",
                            text: "当前操作会"+status+"用户的所有功能!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: status,
                            cancelButtonText: "取消",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }, function(isConfirm){
                            if (isConfirm) {
                                //发送请求
//                                $.ajax({
//                                    url :'/user_management/'+id+'/edit', //参数2 为禁用,1 为启用
//                                    type : 'get',
//                                    data : {guid : guid},
//                                    success : function (msg) {
//                                        if(msg.statusCode == 400){
//                                            swal(msg.resultData, '执行' + status + '失败', "danger");
//                                        }
//                                        swal(msg.resultData, '该用户已被成功'+status, "success");
//                                        //成功后删除当前行
//                                        tr.remove();
//
//                                    }
//                                });
                                swal('chenggong', '该用户已被成功'+status, "success");

                            } else {
                                swal("Cancelled", "Your imaginary file is safe :)", "error");
                            }
                        });
                    });
                },
                        //init
                        $.SweetAlert = new SweetAlert,
                        $.SweetAlert.Constructor = SweetAlert
            }(window.jQuery),

//initializing
                    function($) {
                        "use strict";
                        $.SweetAlert.init()
                    }(window.jQuery);
        }


        /********************************************************************************************/


        /**
         *  审核操作
         *
         *
         */
        function userCheck() {
            $('.user_check').click(function () {
                var guid = $(this).data('name');
                $('#con123').modal('show');
                //$('.modal-content').html(guid);
            });
        }
        /**
         *查看用户详情
         *
         *
         *
         * */
//        function listenChange() {
//            $('.user_modify').click(function () {
//                var guid = $(this).data('name');
//                $('#con123').modal('show');
//                $('.modal-header').html(guid);
//            });
//        }

        //页面默认加载所有可用用户信息
        $(function () {
            $('#user_title').html('<h3>待审核用户</h3>');
            var key = 15;   //默认请求所有待审核用户

            var url = '/user_management/show';

            //初始化请求参数
            var queryString = {
                key : key
            };

            //执行ajax请求
            execAjax( url, queryString, 'get');
        });

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
            var url = '/user_management/show';  //请求url

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
                    //listenChange();

                    userCheck();        //监听审核



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
                    '<th class ="text-center">姓名</th>' +
                    '<th class ="text-center">类型</th>' +
                    '<th class ="text-center">性别</th>' +
                    '<th class ="text-center">生日</th>' +
                    '<th class ="text-center">手机</th>' +
                    '<th class ="text-center">邮箱</th>' +
                    '<th class ="text-center">用户状态</th>' +
                    '<th class ="text-center">操作</th>' +
                    '</tr>' +
                    '</thead>'+
                    '<tbody>';

            //

            $.each(data, function (i, v) {

                str += '<tr class="gradeX">';
                str +=  '<td>' + v.realname + '</td>';
                str +=  '<td>';
                if(v.role == 1){
                    str +=  '<span class="text-info text-xs">普通用户&nbsp;</span>';
                }
                if(v.role == 2){
                    str +=  '<span class="text-warning text-xs">创业者&nbsp;</span>';
                }
                if(v.role == 3){
                    str += '<span class="text-success text-xs">投资者&nbsp;</span>';
                }
                if(v.memeber == 2){
                    str += '<span class="text-danger text-xs">英雄会员&nbsp;</span>';
                }
                str += '</td>';
                if(v.sex == 1){
                    str += '<td>男</td>';
                }else{
                    str +=  '<td>女</td>';
                }

                str += '<td>' + v.birthday + '</td>';
                str +=  '<td>' + v.tel + '</td>';
                str +=  '<td>' + v.email + '</td>';
                str +=  '<td>';

                if(v.status == 5 && v.role == 2){
                    str += '<span class="text-danger text-xs">待审核&nbsp; </span><span class="text-info text-xs">创业者</span>';
                }
                if(v.status == 5 && v.role == 3){
                    str += '<span class="text-danger text-xs">待审核&nbsp;</span><span class="text-success text-xs">投资者</span>';
                }
                if(v.status == 5 && v.role == 4){
                    str += '<span class="text-danger text-xs">待审核&nbsp;</span><span class="text-warning text-xs">英雄会员</span>';
                }

                if(v.status == 7 && v.role == 2){
                    str += '<span class="text-danger text-xs">未通过&nbsp; </span><span class="text-info text-xs">创业者</span>';
                }
                if(v.status == 7 && v.role == 3){
                    str += '<span class="text-danger text-xs">未通过&nbsp;</span><span class="text-success text-xs">投资者</span>';
                }
                if(v.status == 7 && v.role == 4){
                    str += '<span class="text-danger text-xs">未通过&nbsp;</span><span class="text-warning text-xs">英雄会员</span>';
                }
                str +=  '</td>';
                str +=  '<td>';
                if(v.status == 5 || v.status == 7){
                    str +=  '<a href="javascript:;" data-name="' + v.guid + '" class="user_check"><button class="btn btn-success btn-xs">审核</button></a>';
                }


                str +=  '</td></tr>';
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