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
        <button class="btn btn-default status1" data-status="4">回收站</button>
        <button class="btn btn-default status1" data-status="5">报名截止，等待开始</button>
        <center><h1 id="list_title">报名中</h1></center>
    </div>
    <div class="panel" id="data"></div>
</div>
@include('admin.public.banner')
@endsection
@section('script')

    <script type="text/javascript">

        //活动状态选择
        $('.status1').off('click').on('click', function () {
            $('.status1').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');
            $('#list_title').html($(this).html());
            listType(list_type, $(this).data('status'));
        });

    </script>
@endsection
