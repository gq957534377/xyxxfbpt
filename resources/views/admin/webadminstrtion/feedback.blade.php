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
        <h2>用户意见管理</h2>

    </div>

    {{--<img src="{{asset('admin/images/load.gif')}}" class="loading">--}}

    <div class="page-title">
        <h5 id="user_title" class="title text-center"></h5>
    </div>

    {{--表格盒子开始--}}
    <div class="panel" id="data" style="text-align: center">

    </div>
    {{--表格盒子结束--}}

@endsection
{{--展示内容结束--}}

{{--弹出页面 开始--}}
<div id="feedback" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">意见详情</h4>
            </div>
            <div class="modal-body">
                <h4>邮箱</h4>
                <p id="feedback-email"></p>
                <hr>
                <h4>意见内容</h4>
                <p id="feedback-descri"></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button id="delete-feedback" data-ip="11" type="button" class="btn btn-danger">删除</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@section('script')
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <script src="{{asset('admin/js/sweet-alert.init.js')}}"></script>
    <script>
        /**************************************************************************************************/



        //页面默认加载所有可用用户信息
        $(function () {
            $('#user_title').html('<h3>所有意见</h3>');

            var url = '/feedback/1';
            //初始化请求参数
            var queryString = {};
            //执行ajax请求
            execAjax( url, queryString, 'get');
        });




        /** ajax请求，返回用户意见数据
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
                    if (msg.StatusCode == '400') return $('#data').html('暂无数据');
                    //有数据，遍历数据进行DOM操作
                    $('#data').html(htmlStr(msg.ResultData));
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
            console.log(data);
//            //公共表格头

            str +=  '<div class="panel-body">';
            str += '<div class="dt-buttons btn-group">' +
                '<a id="check-all" class="btn btn-default buttons-copy buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons">' +
                '<span>全选</span>' +
                '</a>' +
                '<a id="delete-all" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons">' +
                '<span>删除</span></a></div>';
            str += '<table class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th class ="text-center" style="width: 5%;">#</th>' +
                '<th class ="text-center" style="width: 15%;">IP</th>' +
                '<th class ="text-center" style="width: 20%;">邮箱</th>' +
                '<th class ="text-center">建议</th>' +
                '<th class ="text-center" style="width: 15%;">操作</th>' +
                '</tr>' +
                '</thead>'+
                '<tbody>';


            $.each(data[0], function (i, v) {
                obj = JSON.parse(data[1][i]);
                str += '<tr class="gradeX">';
                str +=  '<td><input class="checkbox-list" name="Fruit" type="checkbox" data-ip="'+ data[0][i] +'" /></td>';
                str +=  '<td>' + obj.ip + '</td>';
                str +=  '<td class="feedb-email">' + obj.fb_email + '</td>';
                str +=  '<td hidden class="feedb-descri">'+ obj.description +'</td>';
                str +=  '<td>' + obj.description.slice(0, 53) + '</td>';
                str +=  '<td>';
                str +=  '<button class="btn btn-info btn-xs" data-ip="'+ data[0][i] +'" style="border-radius:7px;" data-toggle="modal" data-target="#feedback">详情</button>';
                str +=  '<button id="'+ data[0][i] +'" data-ip="'+ data[0][i] +'" style="border-radius:7px;" class="btn btn-danger btn-xs">删除</button>';
                str +=  '</td></tr>';
            });


            str += '</tbody>' +
                '</table>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-sm-8"></div>' +
                '<div class="col-sm-4" id="page"></div>' +
                '</div>';

            str += data[2];
            return str;
        }
        /**
         * 修改全选，取消全选状态
         * @author 王通
         */
        $('#data').on('click', '#check-all', function () {
            if ($(this).children('span').html() == '全选') {
                $(this).children('span').html('取消全选');
                $('.checkbox-list').prop('checked', true);
            } else {
                $(this).children('span').html('全选');
                $('.checkbox-list').prop('checked', false);
            }
        });

        /**
         * 修改复选框状态
         * @author 王通
         */
        $('#data').on('click', '.checkbox-list', function () {
            var num = $('.checkbox-list').size();
            var check = '';
            var f = false;
            for (var i = 0; i < num; i++) {
                check = $('#data').find('.checkbox-list:eq('+ i +')').prop('checked');
                if (!check) {
                    f = true;
                }
            }
            if (f) {
                $('#check-all').children('span').html('全选');
            } else {
                $('#check-all').children('span').html('取消全选');

            }
        });

        /**
         * 删除所有的列表
         * @author 王通
         */
        $('#data').on('click', '#delete-all', function () {
            var num = $('.checkbox-list').size();
            var check = '';
            var arr = [];
            var j = 0;

            for (var i = 0; i < num; i++) {
                check = $('#data').find('.checkbox-list:eq('+ i +')').prop('checked');
                if (check) {
                    arr[j] = $('#data').find('.checkbox-list:eq('+ i +')').data('ip');
                    j++;
                }
            }
            if (arr != []) {
                operation('/feedback/delete', {'iparr' : arr}, 'delete', null);
            }

            console.log(arr);

        });

        /**
         * 详情
         *@author 王通
         */
        $('#data').on('click', '.btn-info', function () {
            var email = $(this).parent().siblings('.feedb-email').html();
            var descri = $(this).parent().siblings('.feedb-descri').html();
            var ip = $(this).data('ip');
            $('#delete-feedback').attr('data-ip', ip);
            $('#feedback-email').html(email);
            $('#feedback-descri').html(descri);
        });

        /**
         * 分页点击事件
         *
         */
        $('#data').on('click', '.pagination > li', function () {

            var class_name = $(this).prop('class');
            if(class_name == 'disabled' || class_name == 'active') {
                return false;
            }
            var url = $(this).children().prop('href');

            //初始化请求参数
            var queryString = {};

            execAjax(url, queryString, 'get');
            return false;
        });

        /**
         * 删除指定意见
         */
        $('#data').on('click', '.btn-danger', function () {
            var me = $(this);
            deleteFeedback(me);
        });

        $('.btn-danger').on('click', function () {
            var me = $(this);
            deleteFeedback(me);
            $('#feedback').modal('hide');
        });

        function deleteFeedback(me) {
            var id = me.data('ip');
            swal({
                title: "确认删除？",
                text: "请问是否删除该条意见，该操作不可逆！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "删除！",
                cancelButtonText: "取消！",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm){
                if (isConfirm) {
                    operation('/feedback/' + id, {'iparr' : [id]}, 'delete', me);
                } else {
                    swal("已取消", "", "error");
                }
            });
        }
        /**
         * @param url
         * @param queryString
         * @param type
         */

        function operation( url, queryString, type, obj) {
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
                    if (msg.StatusCode == '200') {
                        swal("删除成功!", "", "success");
                        $.each(queryString.iparr, function (key, val) {
                            var obj = $('input[data-ip="'+val+'"]');
                            delOk(obj, 2);
                        })

                    } else {
                        console.log(msg);
                        swal("失败", msg.ResultData, "error");
                    }
                }
            })
        }

        /**
         * 删除记录 回掉，删除几个记录
         * @param obj
         * @author 王通
         */
        function delOk(obj, k) {
            if (k <= 0) {
                obj.remove();
            } else {
                obj = obj.parent();
                k--;
                delOk(obj, k);
            }

        }
    </script>

@endsection