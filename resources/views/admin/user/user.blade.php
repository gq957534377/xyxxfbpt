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
            <button id="normal" data-name="normal" type="button" class="btn btn-default btn-default addevent">普通用户</button>
        </div>
        <div class="btn-group">
            <button id="entrepreneurs" data-name="entrepreneurs" type="button" class="btn btn-default addevent">创业者</button>
        </div>
        <div class="btn-group">
            <button id="investor" data-name="investor" type="button" class="btn btn-default addevent">投资者</button>
        </div>
        <div class="btn-group">
            <button type="button" id="checking" class="btn btn-default dropdown-toggle" data-toggle="dropdown">待审核
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a id="check_entrepreneurs" data-name="check_entrepreneurs" class="addevent" href="javascript:void(0)">创业者</a>
                </li>
                <li>
                    <a id="check_investor" data-name="check_investor" class="addevent" href="javascript:void(0)">投资者</a>
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
    <button type="button" id="close" class="btn btn-info hidden" data-dismiss="modal">Close</button>
    <button type="button" id="post" class="btn btn-info hidden" data-dismiss="modal">提交</button>
    <button type="button" id="cancel" class="btn btn-info hidden" data-dismiss="modal">取消</button>
@endsection
{{--弹出页面结束--}}

{{--警告信息弹层开始--}}
{{--@section('alertInfo-title', 'xxxxxxx')--}}
{{--@section('alertInfo-body', 'yyyyyyyy')--}}
{{--警告信息弹层结束--}}

@section('script')

    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>

    {{--<script src="{{asset('JsService/Model/user/AjaxController.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('JsService/Model/user/userAjaxBefore.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('JsService/Model/user/userAjaxSuccess.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('JsService/Model/user/userAjaxError.js')}}" type="text/javascript"></script>--}}
    <script src="{{asset('JsService/Model/user/user_normal.js')}}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/user/user_check_investor.js')}}" type="text/javascript"></script>


    <script>
        //全局标识
        var user_role = 1;

        //初始化 请求数据 分页包含在数据中 添加事件
        $(function () {
            $('#normal').addClass('btn-success');
            var user_init = {
                role : user_role
            };
            load('/user/create', user_init, 'GET', showNormal);

            $('.addevent').off('click').on('click', function () {
                //重设按钮颜色
                $('.btn-success').removeClass('btn-success').addClass('btn-default');
                $(this).addClass('btn-success');
                //设置请求参数，更改标题
                var data = null;
                var tmp = $(this).data('name');
                if(tmp == 'normal') {
                    user_role = '1';
                    $('#user_title').text('普通用户');
                }
                if(tmp == 'entrepreneurs') {
                    user_role = '2';
                    $('#user_title').text('创业者用户');
                }
                if(tmp == 'investor') {
                    user_role = '3';
                    $('#user_title').text('投资者用户');
                }
                if(tmp == 'check_entrepreneurs') {
                    user_role = '4';
                    $('#user_title').text('待审核创业者用户');
                    $('#checking').addClass('btn-success');
                }
                if(tmp == 'check_investor') {
                    user_role = '5';
                    $('#user_title').text('待审核投资者用户');
                    $('#checking').addClass('btn-success');
                }
                data = {
                    role : user_role
                };
                if(data.role == '1' || data.role == '2' || data.role == '3')
                    load('/user/create', data, 'GET', showNormal);
                if(data.role == '4' || data.role == '5')
                    load('/user_role/create', data, 'GET', showCheckInvestor);

            });
        });

        function load(url, data, type, success) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url     : url,
                data    : data,
                type    : type,
                async: true,
                success : success
            });
        }

        function getPage() {
            $('.pagination li a').removeAttr('href');
            $('.pagination li').off('click').click(function () {

                var class_name = $(this).prop('class');
                if(class_name == 'disabled' || class_name == 'active') {
                    return false;
                }
                var nowPage = $(this).children('a').text();

                var data = {
                    role : user_role,
                    nowPage : nowPage
                };

                if(user_role == '1' || user_role == '2' || user_role == '3')
                    load('user/create', data, 'GET', showNormal);
                if(user_role == '4' || user_role == '5')
                    load('user_role/create', data, 'GET', showCheckInvestor);
            });
        }

        function updateData() {
            $('.modify').off("click").click(function (event) {
                event.stopPropagation();
                var data = {
                    role : '1',
                    name : $(this).data('name')
                };
                $.ajax({
                    url     : '/users_one_data',
                    type    : 'get',
                    data    : data,
                    success : function showInfoList(data){
                        $('.loading').hide();
                        $('#con-modal').modal('show');
                        $('#cancel').removeClass("hidden");
                        $('#post').removeClass("hidden");
                        $('#close').addClass("hidden");
                        if (data) {
                            if (data.StatusCode == 200) {
                                $('#alert-info').hide();
                                $('#alert-form').show().html(infoHtml(data.ResultData));
                            } else {
                                $('#alert-form').hide();
                                $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
                            }
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>未知的错误</p>');
                        }
                    }
                });
            });
            submitData();
        }

        function changeAllStatus(){
            $('.unlock, .lock, .pass, .fail, .delete').off('click').on('click', function () {
                window.user_guid = $(this).data('name');
                window.item = $(this).parent().siblings("td").first().text();
                $pointer1 = (user_role == '1' || user_role == '2' || user_role == '3');
                $pointer2 = (user_role == '4' || user_role == '5');
                var data = null;
                var status = null;
                var url =null;
                if($(this).hasClass('delete')){
                    if($pointer1) {
                        status = '3';
                        url = '/user/' + $(this).data('name');
                    }
                    if($pointer2) {
                        status = '4';
                        url = '/user_role/' + $(this).data('name');
                    }
                }
                if($(this).hasClass('unlock')){
                    status = '1';
                    url = '/user/' + $(this).data('name');
                }
                if($(this).hasClass('lock')){
                    status = '2';
                    url = '/user/' + $(this).data('name');
                }
                if($(this).hasClass('fail')){
                    status = '3';
                    url = '/user_role/' + $(this).data('name');
                }
                if($(this).hasClass('pass')){
                    status = '2';
                    url = '/user_role/' + $(this).data('name');
                }

                data = {
                    status : status,
                    role : user_role
                };

                load(url, data, 'put', checkStatus);
            })
        }

//        // 修改时弹出
//        function infoHtml(data) {
//            var html = '';
//            html += '<div class="row">';
//            html += '<div class="col-md-4">' +
//                    '<div class="form-group">' +
//                    '<label for="field-2" class="control-label">真实姓名：</label>';
//            html += '<input type="text" class="form-control" value="' + (data.realname || '') + '" id="realname" placeholder="无">' +
//                    '</div>' +
//                    '</div>';
//            html += '<div class="col-md-4">' +
//                    '<div class="form-group">' +
//                    '<label for="field-2" class="control-label">昵称：</label>';
//            html += '<input type="text" class="form-control" value="' + (data.nickname || '') + '" id="nickname" placeholder="无">' +
//                    '</div>' +
//                    '</div>';
//            html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">性别：</label>';
//            html += '<input type="text" class="form-control" value="' + (data.sex || '') + '" id="sex" placeholder="无"></div></div></div>';
//
//            html += '<div class="row">' +
//                    '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">生日：</label>';
//            html += '<input type="text" class="form-control" value="' + data.birthday + '" id="birthday" placeholder="无"></div></div>';
//            html += '<div class="col-md-4"><div class="form-group no-margin"><label for="field-7" class="control-label">手机：</label>';
//            html += '<input type="text" class="form-control" value="' + (data.tel || '') + '" id="tel" placeholder="无"></div></div>';
//            html += '<div class="col-md-4"><div class="form-group no-margin"><label for="field-7" class="control-label">邮箱：</label>';
//            html += '<span class="form-control hidden" id="guid">' + data.guid + '</span>';
//            html += '<input type="text" class="form-control" value="' + (data.email || '') + '" id="email" placeholder="无"></div></div></div>';
//            return html;
//        }
//
//        function submitData() {
//            $('#post').off("click").click(function (event) {
//                event.stopPropagation();
//                var data = {
//                    realname : $('#realname').val(),
//                    nickname : $('#nickname').val(),
//                    sex       : $('#sex').val(),
//                    birthday : $('#birthday').val(),
//                    tel       : $('#tel').val(),
//                    email     : $('#email').val(),
//                    role      : '1',
//                    id        : $('#guid').text()
//                };
//
//                $.ajax({
//                    url : '/users_data',
//                    type : 'put',
//                    data : data,
//                    success: function checkStatus(data){
//                        $('.loading').hide();
//                        $('#con-modal').modal('show');
//                        $('#cancel').addClass("hidden");
//                        $('#post').addClass("hidden");
//                        $('#close').removeClass("hidden");
//                        if (data) {
//                            if (data.StatusCode == 200) {
//                                $('#alert-form').hide();
//                                $('#alert-info').show().html('<p>数据修改成功!</p>');
//                            } else {
//                                $('#alert-form').hide();
//                                $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
//                            }
//                        } else {
//                            $('#alert-form').hide();
//                            $('#alert-info').show().html('<p>未知的错误</p>');
//                        }
//                    }
//                });
////                return false;
//            });
//        }

        function checkStatus(data){
            $('.loading').hide();
            $('#con-modal').modal('show');
            $('#close').removeClass("hidden");
            if (data) {
                if (data.StatusCode == 200) {
                    $('#alert-form').hide();
                    $('#alert-info').show().html('<p>数据修改成功!</p>');
                    changeContent();
                } else {
                    $('#alert-form').hide();
                    $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
                }
            } else {
                $('#alert-form').hide();
                $('#alert-info').show().html('<p>未知的错误</p>');
            }
        }

        //成功时动态修改内容
        function changeContent(){
            var data = {
                name : window.user_guid,
                role : user_role
            };
            if(user_role == '1' || user_role == '2' || user_role == '3'){
                load('/user/create', data, 'GET', function (data) {
                    var e = data.ResultData;
                    var html = '';
                    var status = null;
                    var p1, p2, p3 = '';
                    if(e.status == 1){
                        status = '<p class="text-success">激活</p>';
                        p1 = 'disabled';
                    }
                    if(e.status == 2){
                        status = '<p class="text-warning">禁用</p>';
                        p2 = 'disabled';
                    }
                    if(e.status == 3){
                        status = '<p class="text-danger">删除</p>';
                        p3 = 'disabled';
                    }
                    html += '<td>' + item + '</td>';
                    html += '<td>' + e.nickname + '</td>';
                    html += '<td>' + e.realname + '</td>';
                    html += '<td>' + e.sex + '</td>';
                    html += '<td>' + e.birthday + '</td>';
                    html += '<td>' + e.tel + '</td>';
                    html += '<td>' + e.email + '</td>';
                    html += '<td>' + status + '</td>';
                    html += '<td>';
                    html += '<a href="javascript:;" data-name="' + e.guid + '" class="modify"><button class="btn btn-info btn-xs">修改</button></a>';
                    html += '<a href="javascript:;" data-name="' + e.guid + '" class="unlock"><button class="btn btn-success ' + p1 + '  btn-xs">激活</button></a>';
                    html += '<a href="javascript:;" data-name="' + e.guid + '" class="lock"><button class="btn btn-warning ' + p2 + ' btn-xs">禁用</button></a>';
                    html += '<a href="javascript:;" data-name="' + e.guid + '" class="delete"><button class="btn btn-danger ' + p3 + '  btn-xs">删除</button></a>';
                    html += '</td>';
                    $(".gradeX").eq(item - 1).html(html);

                    //DOM树替换后再次分配事件
                    changeAllStatus();
                });
            }

            if(user_role == '4' || user_role == '5'){
                load('/user_role/create', data, 'GET', function (data) {
                    var e = data.ResultData;
                    var html = '';
                    var status = null;
                    var p1, p2, p3, p4= '';
                    if(e.status == 1){
                        status = '<p class="text-success">待审核</p>';
                        p1 = 'disabled';
                    }
                    if(e.status == 2){
                        status = '<p class="text-warning">审核成功</p>';
                        p2 = 'disabled';
                    }
                    if(e.status == 3){
                        status = '<p class="text-danger">审核失败</p>';
                        p3 = 'disabled';
                    }
                    if(e.status == 4){
                        status = '<p class="text-danger">删除</p>';
                        p4 = 'disabled';
                    }

                    html += '<td>' + item + '</td>';
                    html += '<td>' + e.realname + '</td>';
                    html += '<td>' + e.sex + '</td>';
                    html += '<td>' + e.tel + '</td>';
                    html += '<td>' + e.card_number + '</td>';
                    html += '<td>' + status + '</td>';
                    html += '<td>';
                    html += '<a href="javascript:;" class="info check" data-name="' + e.guid + '"><button class="btn btn-info btn-xs">审核</button></a>';
                    html += '<a href="javascript:;" class="info pass" data-name="' + e.guid + '"><button class="btn btn-success ' + p2 + ' btn-xs">通过</button></a>';
                    html += '<a href="javascript:;" class="info fail" data-name="' + e.guid + '"><button class="btn btn-warning ' + p3 + ' btn-xs">不通过</button></a>';
                    html += '<a href="javascript:;" class="info delete" data-name="' + e.guid + '"><button class="btn btn-danger ' + p4 + ' btn-xs">删除</button></a>';
                    html += '</td>';

                    $(".gradeX").eq(item - 1).html(html);

                    //DOM树替换后再次分配事件
                    changeAllStatus();
                });
            }
        }



    </script>

@endsection