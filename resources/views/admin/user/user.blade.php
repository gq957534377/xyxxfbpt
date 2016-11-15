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
            <button id="normal" type="button" class="btn btn-default btn-success">普通用户</button>
        </div>
        <div class="btn-group">
            <button id="entrepreneurs" type="button" class="btn btn-default">创业者</button>
        </div>
        <div class="btn-group">
            <button id="investor" type="button" class="btn btn-default">投资者</button>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">待审核
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a id="check_entrepreneurs" href="#">创业者</a>
                </li>
                <li>
                    <a id="check_investor" href="#">投资者</a>
                </li>
            </ul>
        </div>
    </div>

    {{--<img src="{{asset('admin/images/load.gif')}}" class="loading">--}}

    <div class="page-title">
        <h5 id="title_one" class="title text-center hidden">普通用户</h5>
        <h5 id="title_two" class="title text-center hidden">创业者用户</h5>
        <h5 id="title_three" class="title text-center hidden">投资者用户</h5>
        <h5 id="title_four" class="title text-center hidden">创业者待审核用户</h5>
        <h5 id="title_five" class="title text-center hidden">投资者待审核用户</h5>
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


    <script>

        //页面加载时触发事件
        //请求数据 与 分页
        $(function () {
            load();
            function load() {
                var data = {
                    role : '1'
                };
                var role = data.role;
                $.ajax({
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            },
                    url     : '/user_ajax_get_data',
                    data    : data,
                    type    : 'get',
                    async: true,
                    success : function turn(data){
                        if(role == '1')
                            showNormal(data);
                    }
                });
            }
        });











//
//        function getPage() {
//            $('.pagination li').off("click").click(function (event) {
//                event.stopPropagation();
//                var class_name = $(this).prop('class');
//                if(class_name == 'disabled' || class_name == 'active') {
//                    return false;
//                }
//                var url = $(this).children().prop('href');
//                var ajax = new AjaxController('role=1');
//                ajax.ajax({
//                    url : url,
//                    before : ajaxBeforeModel,
//                    success: getInfoList,
//                    error: ajaxErrorModel
//                });
//                return false;
//            });
//        }
//
//        function deleteData() {
//            $('.delete').off("click").click(function (event) {
//                event.stopPropagation();
//                var data = {id:$(this).data('name'), role:'1'};
//                var ajax = new AjaxController();
//                $.ajax({
//                    url     : '/users_data',
//                    type    : 'delete',
//                    data    : data,
//                    success : function checkStatus(data){
//                        $('.loading').hide();
//                        $('#con-modal').modal('show');
//                        $('#close').removeClass("hidden");
//                        if (data) {
//                            if (data.StatusCode == 200) {
//                                $('#alert-form').hide();
//                                $('#alert-info').show().html('<p>数据删除成功!</p>');
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
//                reload();
//            });
//        }
//
//        function updateData() {
//            $('.modify').off("click").click(function (event) {
//                event.stopPropagation();
//                var data = {
//                    role : '1',
//                    name : $(this).data('name')
//                };
//                $.ajax({
//                    url     : '/users_one_data',
//                    type    : 'get',
//                    data    : data,
//                    success : function showInfoList(data){
//                        $('.loading').hide();
//                        $('#con-modal').modal('show');
//                        $('#cancel').removeClass("hidden");
//                        $('#post').removeClass("hidden");
//                        $('#close').addClass("hidden");
//                        if (data) {
//                            if (data.StatusCode == 200) {
//                                $('#alert-info').hide();
//                                $('#alert-form').show().html(infoHtml(data.ResultData));
//                            } else {
//                                $('#alert-form').hide();
//                                $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
//                            }
//                        } else {
//                            $('#alert-form').hide();
//                            $('#alert-info').html('<p>未知的错误</p>');
//                        }
//                    }
//                });
//            });
//            submitData();
//        }
//

//
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
//                        reload();
//                    }
//                });
////                return false;
//            });
//        }
//
//        function reload() {
//                // 重新加载
//                var ajax = new AjaxController();
//                ajax.ajax({
//                    url     : '/users_data?role=1',
//                    before  : ajaxBeforeModel,
//                    success : getInfoList,
//                    error   : ajaxErrorModel
//            });
//
//        }


    </script>

@endsection