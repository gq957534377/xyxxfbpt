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

<img src="/admin/images/load.gif" class="loading">

<div class="wraper container-fluid">
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
    <div id="data"></div>
</div>
@endsection
@section('script')

    <script type="text/javascript">

        //活动状态选择
        $('.status1').off('click').on('click', function () {
            $('.status1').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');

            listType1($(this).data('status'));
        });

        $(function () {
            listType1(1);
        });
        var width  = $(window).width() / 2;
        var height = $(window).height() / 2 - 70;

        function ajaxBeforeModel() {
            $('#data').html('');
            $('.loading').show().css({
                'left': width,
                'top': height
            });
        }
        function listType1(type) {

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
                                break;
                            case 2:
                                console.log(data);
                                carouselHtml(data.ResultData);
                                break;
                            case 3:
                                console.log(data);
                                carouselHtml(data.ResultData);
                                break;
                            case 4:
                                console.log(data);
                                carouselHtml(data.ResultData);
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
        function carouselHtml(data) {
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
            html += '<form class="cmxform form-horizontal tasi-form" id="textfrom" method="get" action="#">';
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
            html += '<button class="btn btn-success" type="submit">Save</button>';
            html += '</div>';
            html += '</div>';
            html += '</form>';
            html += '</div> ';
            html += '</div> ';
            html += '</div> ';
            html += '</div> ';
            html += '</div> ';

            $('#data').html(html);
            $('#headpic').attr('src', '/admin/images/jiahao.jpg');

        }

    </script>
@endsection
