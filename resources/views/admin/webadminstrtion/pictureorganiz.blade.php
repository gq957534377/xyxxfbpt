@extends('admin.layouts.master')

@section('content')
@section('title', '网站管理')
@section('style')

@endsection
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">网站管理</h3>
    </div>
    <div class="row">










    </div> <!-- End row -->
    <div class="row">
        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-body">
                    <div class="media-main">
                        <a class="pull-left" href="#">
                            <img class="thumb-lg img-circle bx-s" src="picture/avatar-2.jpg" alt="">
                        </a>
                        <div class="pull-right btn-group-sm">
                            <a href="#" class="btn btn-success tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#" class="btn btn-danger tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Delete">
                                <i class="fa fa-close"></i>
                            </a>
                        </div>
                        <div class="info">
                            <h4>Jonathan Smith</h4>
                            <p class="text-muted">Graphics Designer</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- end col -->

        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-body">
                    <div class="media-main">
                        <a class="pull-left" href="#">
                            @include('admin.webadminstrtion.picture')
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

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">文字管理</h3></div>
                <div class="panel-body">
                    <div class=" form p-20">

                        <form class="cmxform form-horizontal tasi-form" id="textfrom" method="get" action="#">
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">客服电话：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="tel" type="text" name="tel" required="" aria-required="true" value="{{ $info['tel'] or ''}}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">客服邮箱：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="cemail" type="email" name="email" required="" aria-required="true" value="{{ $info['email'] or ''}}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">工作时间：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="time" type="text" name="time" required="" aria-required="true" value="{{ $info['time'] or ''}}" >
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="curl" class="control-label col-lg-2">备案内容：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="record" type="text" name="record" value="{{ $info['record'] or '' }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-success" type="submit">Save</button>
                                    <button class="btn btn-default" type="button">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- .form -->
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->




</div>

@include("Tool.Ajax")

@include("admin.validator.webAdminValidator")

@endsection


