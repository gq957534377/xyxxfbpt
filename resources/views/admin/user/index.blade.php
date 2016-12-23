{{--author lw--}}
@extends('admin.layouts.master')
@section('styles')
    <style>
        .loading{z-index:999;position:absolute;display: none;}
        #alert-info{padding-left:10px;}
        table{font-size:14px;}
        .table button{margin-right:15px;}
        .page-title{ padding-bottom: 5px;}
        .list-unstyled > li{
            margin-bottom: 5px;
        }
        .list-unstyled > li:nth-child(1){
            margin-bottom: 25px;
        }
    </style>
@endsection
{{--展示内容开始--}}
@section('content')

    <div class="btn-toolbar" role="toolbar">
        <h2>用户常规管理</h2>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">用户类型
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list"  key="1"  title="普通用户">普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="2"  title="创业者用户">创业者用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="3" title="投资者用户">投资者用户</a>
                </li>
                <li>
                    <a  class="user_role_list"  key="4"  title="英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>


        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">已禁用
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="user_role_list" key="5" title="已禁用普通用户" >普通用户</a>
                </li>
                <li>
                    <a  class="user_role_list" key="6" title="已禁用创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="7" title="已禁用投资者用户" >投资者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="8" title="已禁用英雄会成员">英雄会成员</a>
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

    {{--修改信息弹出框 --}}
    <div id="user-change" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm" id="fabu">
            <div class="modal-content">
                <div id = "" class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="text-danger">x</span></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="submit" data-name="" class="btn btn-primary">修改</button>
                </div>

            </div>
        </div>
    </div>
    {{--查看详情弹出框 --}}
    <div id="user-info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" id="fabu">
            <div class="modal-content">
                <div id = "" class="modal-header">
                    <h3>用户详细信息</h3><button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="text-danger">x</span></button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><strong>头像</strong> :
                                        {{--<img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}">--}}
                                        <div class="ibox-content" style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                                            <div class="row">
                                                <div id="crop-avatar">
                                                    <div class="avatar-view" title="" style="width: 70px;border: none;border-radius: 0px;box-shadow: none;">
                                                        <img id="headpic" class="img-circle" src="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>真实姓名 ：<span id="realname"></span></li>
                                    <li>昵称 ：<span id="nickname"></span></li>
                                    <li>性别 ：<span id="sex"></span></li>
                                    <li>出生日期 ：<span id="birthday"></span></li>
                                    <li>电话 ：<span id="phone"></span></li>
                                    <li>邮箱 ：<span id="email"></span></li>
                                    <li>公司 ： <span id="company"></span></li>
                                    <li>职位 ：<span id="company_position"></span></li>
                                    <li>公司地址 ：<span id="company_address"></span></li>

                                    <li><span></span></li>
                                    <li><span></span></li>
                                    <li><span></span></li>
                                    <li><span></span></li>
                                    <li><span></span></li>
                                    <li><span></span></li>
                                    <li><span></span></li>
                                    <li><span></span></li>
                                    <li><span></span></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li>微信 ： <div class="ibox-content" style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                                            <div class="row">
                                                <div id="crop-avatar">
                                                    <div class="avatar-view" title="" style="width: 70px;border: none;border-radius: 0px;box-shadow: none;">
                                                        <img id="wechat" class="img-rounded" src="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>注册时间 ：<span id="addtime"></span></li>
                                    <li id="role"></li>
                                    <li id="status"></li>
                                    <li>个人简介 ：<span id="introduction"></span></li>
                                </ul>
                            </div>

                        </div>

                </div>
            </div>
        </div>
    </div>


@endsection
{{--展示内容结束--}}

@section('script')
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <script src="{{asset('admin/js/sweet-alert.min.js')}}"></script>
    <script>

        //页面默认加载所有可用用户信息
        $(function () {
            $('#user_title').html('<h3>所有用户</h3>');
            var key = 0;

            var url = '/user_management/show';

            //初始化请求参数
            var queryString = {
                key : key
            };

            //执行ajax请求
            execAjax( url, queryString, 'get');
        });

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
                    $('.user_change').click(function(){
                        var guid = $(this).data('name');
                        var id = $(this).data('id');

                        //获取tr节点
                        var tr = $(this).parent().parent();
                        if(id == 2){
                            var status = '禁用';
                        }else{
                            var status = '启用';
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
                                $.ajax({
                                    url :'/user_management/'+id+'/edit', //参数2 为禁用,1 为启用
                                    type : 'get',
                                    data : {guid : guid},
                                    success : function (msg) {
                                        if(msg.statusCode == 400){
                                            swal(msg.resultData, '执行' + status + '失败', "danger");
                                        }
                                        swal(msg.resultData, '该用户已被成功'+status, "success");
                                        //成功后删除当前行
                                        tr.remove();

                                    }
                                });

                            } else {
                                swal("已取消！", "没有做任何修改！", "error");
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
         *修改用户信息
         *
         *
         *
         * */
        function userChange() {
            $('.user_modify').click(function () {
                var guid = $(this).data('name');
                if(1){
                    $('#user-change').modal('show');
                    //$('.modal-body').html('操作成功！');
                }

            });
        }

        /**
         * 查看用户详情
         *
         *
         * */
        function userInfo() {
            $('.user_info').click(function () {

                var data = $(this).data();
                //alert(realname);
                $('#headpic').attr('src',data.headpic);
                $('#realname').text(data.realname);
                $('#nickname').text(data.nickname);
                switch (data.sex){
                    case 1:
                        var sex = '男';
                        break;
                    case 2:
                        var sex = '女';
                        break;
                    default:
                        var sex = '未填写';
                }
                $('#sex').text(sex);
                $('#birthday').text(data.birthday);
                $('#phone').text(data.phone);
                $('#email').text(data.email);
                $('#company').text(data.company);
                $('#company_position').text(data.company_position ? data.company_position : '');
                $('#company_address').text(data.company_address ? data.company_address : '');
                $('#introduction').text(data.introduction ? data.introduction : '');
                $('#wechat').attr('src',data.wechat);
                $('#addtime').text(data.addtime);
                //角色身份选择
                switch (data.role){
                    case 1 :
                        var str = '身份 ：<span class="text-info text-xs">普通用户&nbsp;</span>';
                        break;
                    case 2 :
                        var str = '身份 ：<span class="text-warning text-xs">创业者&nbsp;</span>';
                        break;
                    case 3 :
                        var str = '身份 ：<span class="text-success text-xs">投资者&nbsp;</span>';
                        break;
                }
                //会员身份选择
                switch(data.memeber){
                    case 2:
                        var member = '<span class="text-danger text-xs">英雄会员&nbsp;</span>';
                        break;
                    default:
                    var member = '';
                }


                $('#role').html(str + member);

                //状态匹配
                switch (data.status){
                    case 1:
                        var status = '当前状态 ：<span class="text-primary text-xs">正常使用中&nbsp;</span>';
                        break;
                    default:
                        var status = '当前状态 ：<span class="text-danger text-xs">禁用中&nbsp;</span>';
                }
                $('#status').html(status);
                $('#').text();
                $('#').text();

                $('#user-info').modal('show');

            });
        }
        
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
                    pages();    //分页事件触发
                    userChange(); //调用修改弹出框
                    initAlert();    //调用确认弹出框
                    userInfo();     //用户详情


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

                if(v.status == 1){
                    str +=  '<a href="javascript:;" data-name="' + v.guid + '" data-id="2" class="user_change"><button class="btn btn-danger btn-xs" id = "sa-warning" style="border-radius:6px">禁用</button></a>';
                }
                if(v.status == 2){
                    str +=  '<a href="javascript:;" data-name="' + v.guid + '" data-id="1" class="user_change"><button class="btn btn-success btn-xs">启用</button></a>';
                }
                if(v.status == 5){
                    str += '<span class="text-danger text-xs">待审核&nbsp;</span>';
                }
                if(v.status == 7){
                    str += '<span class="text-danger text-xs">审核失败&nbsp;</span>';
                }
                str +=  '</td>';
                str +=  '<td>';
                str +=  '<a href="javascript:;" data-name="' + v.guid + '" class="user_modify"><button class="btn btn-info btn-xs">修改</button></a>';
                str +=  '<a href="javascript:;" data-nickname="' + v.nickname + '" data-realname="'+ v.realname +'" data-role ="'+v.role+
                        '" data-brithday="'+v.birthday+'" data-sex ="'+v.sex+'" data-company_position="'+v.company_position+
                        '" data-company_address="'+v.company_address+'" data-tel ="'+v.tel+'" data-email="'+v.email+
                        '" data-headpic="'+v.headpic+'" data-wechat="'+v.wechat+'" data-intoduction="'+v.introduction+
                        '" data-memeber="'+v.memeber+'" data-addtime="'+v.addtime+'" data-status="'+v.status+
                        '" class="user_info"><button class="btn btn-warning btn-xs">详情</button></a>';

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




    </script>

@endsection