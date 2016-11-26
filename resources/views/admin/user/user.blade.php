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
            <button type="button" data-name="user_normal"  class="add_event btn btn-default">普通用户</button>
        </div>
        <div class="btn-group">
            <button type="button" data-name="user_entrepreneurs" class="add_event btn btn-default">创业者用户</button>
        </div>
        <div class="btn-group">
            <button type="button" data-name="user_investor" class="add_event btn btn-default">投资者用户</button>
        </div>
        <div class="btn-group">
            <button type="button" data-name="user_investor" role="4" status="1" class="add_event btn btn-default user_list">英雄会成员</button>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">待审核
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a data-name="check_entrepreneurs" class="add_event" href="javascript:void(0)">创业者</a>
                </li>
                <li>
                    <a data-name="check_investor" class="add_event" href="javascript:void(0)">投资者</a>
                </li>
                <li>
                    <a data-name="check_investor" status="1" role="4" class="user_role_list" href="javascript:void(0)">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">审核失败
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a data-name="check_entrepreneurs_fail" class="add_event" href="javascript:void(0)">创业者</a>
                </li>
                <li>
                    <a data-name="check_investor_fail" class="add_event" href="javascript:void(0)">投资者</a>
                </li>
                <li>
                    <a data-name="check_investor_fail" role="4" status="3" class="user_role_list" href="javascript:void(0)">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">已禁用
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a data-name="user_normal_disabled" class="add_event" href="javascript:void(0)">普通用户</a>
                </li>
                <li>
                    <a data-name="user_entrepreneurs_disabled" class="add_event" href="javascript:void(0)">创业者</a>
                </li>
                <li>
                    <a data-name="user_investor_disabled" class="add_event" href="javascript:void(0)">投资者</a>
                </li>
                <li>
                    <a data-name="user_investor_disabled" class="add_event" href="javascript:void(0)">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">已停用
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a data-name="user_normal_deleted" class="add_event" href="javascript:void(0)">普通用户</a>
                </li>
                <li>
                    <a data-name="user_entrepreneurs_deleted" class="add_event" href="javascript:void(0)">创业者</a>
                </li>
                <li>
                    <a data-name="user_investor_deleted" class="add_event" href="javascript:void(0)">投资者</a>
                </li>
                <li>
                    <a data-name="user_investor_deleted" status="3" role="4" class="add_event" href="javascript:void(0)">英雄会成员</a>
                </li>
            </ul>
        </div>
    </div>

    {{--<img src="{{asset('admin/images/load.gif')}}" class="loading">--}}

    <div class="page-title">
        <h5 id="user_title" class="title text-center">普通用户</h5>
    </div>

    {{--表格盒子开始--}}
    <div class="panel" id="data"></div>
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

    <button type="button" id="close" class="btn btn-info hidden" data-dismiss="modal">Close</button>

@endsection
{{--弹出页面结束--}}

{{--警告信息弹层开始--}}
{{--@section('alertInfo-title', 'xxxxxxx')--}}
{{--@section('alertInfo-body', 'yyyyyyyy')--}}
{{--警告信息弹层结束--}}

@section('script')

    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>

    {{--<script src="{{asset('JsService/Model/user/user_normal.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('JsService/Model/user/user_check_investor.js')}}" type="text/javascript"></script>--}}

    <script src="{{asset('JsService/Model/user/html.js')}}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/user/function.js')}}" type="text/javascript"></script>



    <script>
//      全局变量声明开始
//        user全局变量，标识当前在哪个页面，不同标识加载不同的页面，请求不同的数据 0~12
        var user = 0;
//        number全局变量，标识动作，不同标识，执行不同的动作 0~6
        var number = 0;
//        guid全局变量，标识当前数据身份
        var guid = null;
//        item全局变量，标识当前数据item
        var item = null;
//        data全局变量，标识不同情况下ajax请求参数
        var data = null;
//        url全局变量，标识不同情况下ajax请求url
        var url = null;
//        type全局变量，标识不同情况下ajax请求type
        var type = null;
//        success全局变量，标识不同情况下ajax请求success
        var handle = null;
//        nowPage全局变量，标识不同情况下ajax请求success
        var nowpage = 1;
//        当前页面数据条数
        var pagenum = 0;
//        当前页面总页面数
        var totalpage = 1;
//      全局变量声明结束
        var modify_guid = null;

        //初始化 请求数据 包含分页数据 添加事件
        $(function () {
//            $('.btn-group').eq(user).children('button').addClass('btn-success');
            $('.add_event').eq(user).addClass('btn-success');
            url = '/user/create';
            data = {
                role : user + 1,
                status : 1
            };
            type = 'GET';
            //加载事件列表
            handle = {
                one : initial,
                two : getPage,
                three : changeSomeStatus,
                four : checkInfo,
                five : modifyData
            };
            load(url, data, type, function (data) {
                checkResponse(data, handle, listUserShow);
            });
        });

    </script>

    <script>
            $('.user_role_list').click(function(){
                var status = $(this).attr('status'), role = $(this).attr('role');
                $('.check_pass').show();
                $('.check_fail').show();
                $.ajax({
                    url:'/user_role/list',
                    type:'get',
                    data:{
                        status:status,
                        role:role
                    },
                    success:function(data){
                        var html=listRoleShow2(data);
                        $('#data').html(html);
                        checkInfo();
                        $('.check_pass').off('click').click(function(){
                            var guid = $(this).data('name');
                            var This = $(this);
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url:'user_role/'+guid,
                                type:'put',
                                data:{
                                    status:2
                                },
                                success:function(data){
                                    $('#alert-form').hide();
                                    $('#alert-info').show().html('<p>数据修改成功!</p>');
                                    $('.check_pass').hide();
                                    $('.check_fail').hide();
                                    $('a[data-name='+guid+']').parents('tr').remove();
                                }
                            })
                        });
                    }
                })
            })
    </script>

@endsection