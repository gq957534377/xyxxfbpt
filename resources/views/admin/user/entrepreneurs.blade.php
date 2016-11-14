@extends('admin.layouts.master')
@section('styles')
    <style>
        .loading{z-index:999;position:absolute;display: none;}
        #alert-info{padding-left:10px;}
        table{font-size:14px;}
        .table button{margin-right:15px;}
    </style>
@endsection
{{--展示内容开始--}}
@section('content')
    <img src="{{asset('admin/images/load.gif')}}" class="loading">
    <div class="page-title">
        <h3 class="title">创业者用户</h3>
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
    <button type="button" class="btn btn-primary">提交</button>
    <button type="button" class="btn btn-info" data-dismiss="modal">放弃</button>
@endsection
{{--弹出页面结束--}}

{{--警告信息弹层开始--}}
@section('alertInfo-title', 'xxxxxxxxxx')
@section('alertInfo-body', 'yyyyyyyy')
{{--警告信息弹层结束--}}

@section('script')
    <!--alertInfo JS-->
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--引用ajax模块-->
    <script src="{{asset('JsService/Model/user/AjaxController.js')}}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/user/userAjaxBefore.js')}}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/user/userAjaxSuccess.js')}}" type="text/javascript"></script>
    <script src="{{asset('JsService/Model/user/userAjaxError.js')}}" type="text/javascript"></script>
    <!--引用ajax模块-->
    <!--alertInfo end-->

    <script>

        // 页面加载时触发事件请求分页数据
        var ajax = new AjaxController('role=2');
        ajax.ajax({
            url     : '/users_data',
            data    : 'role=1',
            before  : ajaxBeforeModel,
            success : getInfoList,
            error   : ajaxErrorModel
        });

        function getPage() {
            $('.pagination li').click(function () {
                var class_name = $(this).prop('class');
                if(class_name == 'disabled' || class_name == 'active') {
                    return false;
                }
                var url = $(this).children().prop('href');
                var ajax = new AjaxController('role=2');
                ajax.ajax({
                    url : url,
                    before : ajaxBeforeModel,
                    success: getInfoList,
                    error: ajaxErrorModel
                });
                return false;
            });
        }

        function deleteData() {
            $('.delete').click(function () {
                var _this = $(this);
                var data = {id:$(this).data('name'), role:'2'};
                var ajax = new AjaxController();
                $.ajax({
                    url     : '/users_data',
                    type    : 'delete',
                    data    : data,
                    before  : ajaxBeforeNoHiddenModel,
                    success : checkStatus,
                    error   : ajaxErrorModel
                });

                // 重新加载
                ajax.ajax({
                    url     : '/users_data?role=2',
                    before  : ajaxBeforeModel,
                    success : getInfoList,
                    error   : ajaxErrorModel
                });

                function checkStatus(data){
                    $('.loading').hide();
                    $('#con-modal').modal('show');
                    if (data) {
                        if (data.StatusCode == 200) {
                            var code = data.ResultData;
                            $('#alert-form').hide();
                            _this.data('status', code);
                            $('#alert-info').html('<p>数据删除成功!</p>');
                            $('.btn-primary').hide();
                            $('.btn-info').html('<p>Close</p>');
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>' + data.ResultData + '</p>');
                            $('.btn-primary').hide();
                            $('.btn-info').html('<p>Close</p>');
                        }
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>未知的错误</p>');
                        $('.btn-primary').hide();
                        $('.btn-info').html('<p>Close</p>');
                    }
                }
            });
        }

        function updateData() {
            $('.modify').click(function () {
                var _this = $(this);

                var ajax = new AjaxController('role=2');
                ajax.ajax({
                    url     : '/users_one_data'+ '?name=' + $(this).data('name'),
                    type    : 'get',
                    before  : ajaxBeforeNoHiddenModel,
                    success : showInfoList,
                    error   : ajaxErrorModel
                });

                function checkStatus(data){
                    $('.loading').hide();
                    $('#con-modal').modal('show');
                    if (data) {
                        if (data.ServerNo == 200) {
                            var code = data.ResultData;
                            $('#alert-form').hide();
                            _this.data('status', code);
                            $('#alert-info').html('<p>数据修改成功!</p>');
                            $('.btn-primary').hide();
                            $('.btn-info').html('<p>Close</p>');
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>' + data.ResultData + '</p>');
                            $('.btn-primary').hide();
                            $('.btn-info').html('<p>Close</p>');
                        }
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>未知的错误</p>');
                        $('.btn-primary').hide();
                        $('.btn-info').html('<p>Close</p>');
                    }
                }
            });
        }

        function listHtml(data){
            var html = '';
            html += '<div class="panel-body">' +
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
                    '<th>操作</th>' +
                    '</tr>' +
                    '</thead>';
            html += '<tbody>';
            $.each(data.ResultData.data, function (i, e) {
                html += '<tr class="gradeX">';
                html += '<td>' + (i + 1) + '</td>';
                html += '<td>' + e.nickname + '</td>';
                html += '<td>' + e.realname + '</td>';
                html += '<td>' + e.sex + '</td>';
                html += '<td>' + e.birthday + '</td>';
                html += '<td>' + e.tel + '</td>';
                html += '<td>' + e.email + '</td>';
                html += '<td>';
                html += '<a href="javascript:;" data-name="' + e.guid + '" class="modify"><button class="btn btn-info btn-xs">修改</button></a>';
                html += ' ';
                html += '<a href="javascript:;" data-name="' + e.guid + '" class="delete"><button class="btn btn-danger btn-xs">删除</button></a>';
                html += '</td>';
            });
            html += '</tbody>' +
                    '</table>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-sm-8"></div>' +
                    '<div class="col-sm-4" id="page"></div>' +
                    '</div>';
            return html;
        }

        // 修改时弹出
        function infoHtml(data) {
            var html = '';
            html += '<div class="row">';
            html += '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="field-2" class="control-label">真实姓名：</label>';
            html += '<input type="text" class="form-control" value="' + (data.realname || '') + '" id="name" placeholder="无">' +
                    '</div>' +
                    '</div>';
            html += '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="field-2" class="control-label">昵称：</label>';
            html += '<input type="text" class="form-control" value="' + (data.nickname || '') + '" id="name" placeholder="无">' +
                    '</div>' +
                    '</div>';
            html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">性别：</label>';
            html += '<input type="text" class="form-control" value="' + (data.sex || '') + '" id="english_name" placeholder="无"></div></div></div>';

            html += '<div class="row">' +
                    '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">生日：</label>';
            html += '<input type="text" class="form-control" value="' + data.birthday + '" id="card_type" placeholder="无"></div></div>';
            html += '<div class="col-md-4"><div class="form-group no-margin"><label for="field-7" class="control-label">手机：</label>';
            html += '<input type="text" class="form-control" value="' + (data.tel || '') + '" id="tel" placeholder="无"></div></div>';
            html += '<div class="col-md-4"><div class="form-group no-margin"><label for="field-7" class="control-label">邮箱：</label>';
            html += '<input type="text" class="form-control" value="' + (data.email || '') + '" id="tel" placeholder="无"></div></div></div>';
            return html;
        }

    </script>

@endsection