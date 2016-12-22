@extends('admin.layouts.master')
@section('style')

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
                <h3 class="title">网站管理</h3>
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
        {{--<img src="{{ asset('admin/images/load.gif') }}" class="loading">--}}
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
                                <img id="headpic" class="thumb-lg" src="{{ asset('/admin/images/jiahao.jpg') }}" alt="Avatar"/>
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
    <script type="text/javascript" src="{{asset('admin/js/web-admin.js')}}"></script>
@endsection
