@extends('admin.layouts.master')
@section('style')
<style>
    .loading {
        z-index: 999;
        position: absolute;
        display: none;
    }
    #alert-info {
        padding-left: 10px;
    }

    table {
        font-size: 14px;
    }

    .table button {
        margin-right: 15px;
    }

    #fabu {
        width: 80%;
        height: 80%;
    }

    .btn {
        border-radius: 7px;
        padding: 6px 16px;
    }

</style>
<link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
<link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
@endsection
@section('content')
@section('title', '活动管理')
{{-- 弹出表单开始 --}}
<!--继承组件-->
<!--替换按钮ID-->
@section('form-id', 'myModal')
<!--定义弹出表单ID-->
@section('form-title', '详细信息：')
<!--定义弹出内容-->
@section('form-body')
    <div class="row" id="alert-form"></div>
    <div id="alert-info"></div>
@endsection
<!--定义底部按钮-->
@section('form-footer')
    <button type="button" class="btn btn-info" data-dismiss="modal">关闭</button>
@endsection

<div id="organiz" class="wraper container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-md-4">
                <h3 class="title">活动管理</h3>
            </div>
        </div>


        <br>
        <button class="btn btn-success status1" data-status="1">联系方式及备案管理</button>
        <button class="btn btn-default status1" data-status="2">合作机构管理</button>
        <button class="btn btn-default status1" data-status="3">投资机构管理</button>
        <button class="btn btn-default status1" data-status="4">轮播图管理</button>
    </div>
    <hr>

    <div id="margin_data" style="position: relative;">
        <img src="{{ asset('admin/images/load.gif') }}" class="loading">
        <div id="data"></div>
    </div>


    <div class="col-sm-10 add-picture" hidden>
        <div class="panel">
            <div class="panel-body">
                <div class="media-main">
                    <input type="hidden" name="investor_card_pic">
                    <a class="pull-left" href="#">
                        <div id="crop-avatar3">
                            <div class="avatar-view" title="">
                                <img id="headpic" class="thumb-lg" src="{{ url('/admin/images/jiahao.jpg') }}" alt="Avatar"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="info">
                    <h4>添加图片</h4>
                    <p class="text-muted">Graphics Designer</p>
                </div>
                <div class="clearfix"></div>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- end col -->


    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="custom-width-modalLel">投资机构信息</h4>
                </div>
                <div class="modal-body">
                    <input id="investid" name="investid" type="hidden" value="">
                    <div class="row">
                        <div class="col-sm-8">
                            <label for="inputEmail3" class="col-sm-3 control-label">name</label>
                            <div class="col-sm-9">
                                <input id="investname" type="text" class="form-control" data-method="invesname" name="investname" placeholder="name">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-8">
                            <label for="inputEmail3" class="col-sm-3 control-label">url</label>
                            <div class="col-sm-9">
                                <input id="investurl" type="text" class="form-control" name="investurl" placeholder="url">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="saveinfo" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@include('admin.public.card')
@endsection
@section('script')

    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/webOrganiz.js')}}"></script>
    <script src="{{asset('admin/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin/js/web-admin-validator.js')}}"></script>
    <script type="text/javascript">

        //活动状态选择
        $('.status1').off('click').on('click', function () {
            $('.status1').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');
            listType($(this).data('status'));
            var status = $(this).data('status');
            switch (status)
            {
                case 1:
                    $('.avatar-scale').val('1');
                    break;
                case 2:
                    $('.avatar-scale').val(224/153);
                    $('.organiz-type').val(status);
                    break;
                case 3:
                    $('.avatar-scale').val(224/153);
                    $('.organiz-type').val(status);
                    break;
                case 4:
                    $('.avatar-scale').val(192/60);
                    $('.organiz-type').val(status);
                    break;

            }
        });

        $(function () {
            listType(1);
        });
        var width  = $('#data').width() / 2;
        var height = $('#data').height() / 2 + 80;

        function ajaxBeforeModel() {
            $('.loading').show().css({
                'left': width,
                'top': height
            });
        }
        /**
         * 加载指定类型的数据
         * @author 王通
         **/
        function listType(type) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "get",
                url: '/web_admins/create',
                data: {
                    'type': type,
                },
                before  : ajaxBeforeModel(),
                success:function(data){
                    console.log(data);
                    if (data.StatusCode == '200') {

                        switch (type)
                        {
                            case 1:
                                console.log(data);
                                contentHtml(data.ResultData);
                                $('.add-picture').hide();
                                break;
                            case 2:
                                console.log(data);
                                institutionHtml(data.ResultData);
                                $('.text-coutent').show();
                                $('.add-picture').show();
                                break;
                            case 3:
                                console.log(data);
                                institutionHtml(data.ResultData);
                                $('.text-coutent').show();
                                $('.add-picture').show();
                                break;
                            case 4:
                                carouselHtml(data.ResultData);
                                $('.add-picture').show();
                                $('.text-coutent').hide();
                                break;

                        }

                    } else {
                        console.log(data);
                        alert(data.ResultData);
                    }
                    $('.loading').hide();
                }
            });

        }
        /**
         * 拼接html字符串
         * @param data
         */
        function institutionHtml(data) {
            html = '';
            $.each(data, function (key, value) {
                html += '<div class="col-sm-6">';
                html += '<div class="panel">';
                html += '<div class="panel-body">';
                html += '<div class="media-main">';
                html += '<a id="img'+ value.id +'" class="pull-left" href="'+ value.pointurl +'">';
                html += '<img  class="thumb-lg bx-s" src="'+ value.url +'" alt="" style="width: 146%;">';
                html += '</a>';
                html += '<div class="pull-right btn-group-sm">';
                html += '<a data-id="'+ value.id +'" href="" class="btn btn-success tooltips" data-placement="Top" data-toggle="modal" data-target="#custom-width-modal" data-original-title="Edit">';
                html += '<i class="fa fa-pencil"></i>';
                html += '</a>';
                html += '<a id="'+ value.id +'"  class="btn btn-danger tooltips" data-placement="Top" data-toggle="tooltip" data-original-title="Delete">';
                html += '<i class="fa fa-close"></i>';
                html += '</a>';
                html += '</div>';
                html += '<div class="info text-center">';
                html += '<h4 id="name'+ value.id +'">'+ value.name +'</h4>';

                html += '</div>';

                html += '</div>';
                html += '<div class="clearfix"></div>';
                html += '</div> <!-- panel-body -->';
                html += '</div> <!-- panel -->';
                html += '</div> <!-- end col -->';
            });
            $('#data').html(html);
            $('#headpic').attr('src', '/admin/images/jiahao.jpg');

        }

        function carouselHtml (data) {

            html = '';
            $.each(data, function (key, value) {

                html += '<div class="row">';
                html += '<div class="col-sm-10">';
                html += '<div class="panel">';
                html += '<div class="panel-body">';
                html += '<div class="media-main">';
                html += '<a class="pull-left" href="#">';
                html += '<img class="thumb-lg bx-s" src="'+ value.url +'" alt="" style="width: 250%;">';
                html += '</a>';
                html += '<div class="pull-right btn-group-sm">';
//                html += '<a href="" class="btn btn-success tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit">';
//                html += '<i class="fa fa-pencil"></i>';
//                html += '</a>';
                html += '<a id="'+ value.id +'"  class="btn btn-danger tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Delete">';
                html += '<i class="fa fa-close"></i>';
                html += '</a>';
                html += '</div>';

                html += '</div>';
                html += '<div class="clearfix"></div>';
                html += '</div> <!-- panel-body -->';
                html += '</div> <!-- panel -->';
                html += '</div> <!-- end col -->';
                html += '</div> <!-- end row -->';
            });
            $('#data').html(html);
            $('#headpic').attr('src', '/admin/images/jiahao.jpg');


        }
        /**
         * 拼接html字符串
         * @param data
         */
        function contentHtml(data) {
            console.log(data);
            html = '';
            html += '<div class="row">';
            html += '<div class="col-sm-12">';
            html += '<div class="panel panel-default">';
            html += '<div class="panel-heading"><h3 class="panel-title">文字管理</h3></div>';
            html += '<div class="panel-body">';
            html += '<div class=" form p-20">';
            html += '<form class="cmxform form-horizontal tasi-form" id="textfrom">';
            html += '<div class="form-group ">';
            html += '<label for="cemail" class="control-label col-lg-2">客服电话：</label>';
            html += '<div class="col-lg-10">';
            html += '<input class="form-control " id="tel" type="text" name="tel" required="" aria-required="true" value="' + data.tel  + '">';
            html += '</div>';
            html += '</div>';
            html += ' <div class="form-group ">';
            html += '<label for="cemail" class="control-label col-lg-2">客服邮箱：</label>';
            html += '<div class="col-lg-10">';
            html += '<input class="form-control " id="cemail" type="email" name="email" required="" aria-required="true" value="' + data.email + '">';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group ">';
            html += '<label for="cemail" class="control-label col-lg-2">工作时间：</label>';
            html += '<div class="col-lg-10">';
            html += '<input class="form-control " id="time" type="text" name="time" required="" aria-required="true" value="' + data.time + '" >';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group ">';
            html += '<label for="curl" class="control-label col-lg-2">备案内容：</label>';
            html += '<div class="col-lg-10">';
            html += '<input class="form-control " id="record" type="text" name="record" value="' + data.record + '">';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<div class="col-lg-offset-2 col-lg-10">';
            html += '<button id="text-content-submit" class="btn btn-success" type="button">Save</button>';
            html += '</div>';
            html += '</div>';
            html += '</form>';
            html += '</div> ';
            html += '</div> ';
            html += '</div> ';
            html += '</div> ';
            html += '</div> ';

            $('#data').html(html);
        }

        // 提交文本内容
        $('#data').on('click', '#text-content-submit', function(){
            // 异步更新
            $.ajax({
                type: "POST",
                url: '/web_admins',
                data: {
                    'email' : $('#cemail').val(),
                    'tel' : $('#tel').val(),
                    'time' : $('#time').val(),
                    'record' : $('#record').val(),
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                },
                before  : ajaxBeforeModel(),
                success:function(data){
                    if (data.StatusCode == '200') {
                        listType(1);
                        alert('更新成功');
                    } else {
                        alert('失败：' + data.ResultData)
                    }
                    $('.loading').hide();
                }
            });
        });
        function addHtml() {
            var html = '';
            html += '<div class="col-sm-10">';
            html += '<div class="panel">';
            html += '<div class="panel-body">';
            html += '<div class="media-main">';
            html += '<a class="pull-left" href="#">';


            html += '</a>';
            html += '</div>';
            html += '<div class="info">';
            html += '<h4>添加合作机构</h4>';
            html += '<p class="text-muted">Graphics Designer</p>';
            html += '</div>';
            html += '<div class="clearfix"></div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

        }

        // 删除
        $('#data').on('click', '.btn-danger' ,function () {
            if (!confirm('是否确认删除？')) {
                return ;
            }
            var me = $(this);
            // 异步删除
            $.ajax({
                type: "POST",
                url: '/web_admins/'+ me.attr('id'),
                data: {
                    '_method': 'DELETE',
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                },
                before  : ajaxBeforeModel(),
                success:function(data){
                    if (data.StatusCode == 200) {
                        me.parent().parent().remove();
                    } else {
                        alert(data.ResultData);
                    }
                    $('.loading').hide();
                }
            });
        });

        // 编辑信息
        $('#data').on('click', '.btn-success', function () {
            //alert($(this).data('id'));
            var me = $(this);
            var id = me.data('id');
            $('#investid').val(id);
            $('#investname').val($('#name' + id).html());
            $('#investurl').val($('#img' + id).attr('href'));
        });

        // 提交修改信息
        $('#saveinfo').on('click', function () {
            var id = $('#investid').val();
            var name = $('#investname').val();
            var url = $('#investurl').val()

            // 异步修改
            $.ajax({
                type: "POST",
                url: '/picture/'+ id,
                data: {
                    '_method': 'PUT',
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'name' : name,
                    'url' : url
                },
                before  : ajaxBeforeModel(),
                success:function(data){
                    alert(data.ResultData);
                    updateHtml();
                    $('.loading').hide();
                }
            });
        });
        // 更新HTML界面
        function updateHtml() {
            var status = $('.page-title .btn-success').data('status');
            if (status == null || status == undefined) {
                listType(1);
            } else {
                listType(status);
            }
        }

    </script>

@endsection
