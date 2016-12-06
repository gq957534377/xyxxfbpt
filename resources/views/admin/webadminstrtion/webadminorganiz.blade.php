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
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">logo管理</h3></div>
                <div class="panel-body">
                    <div class=" form p-20">

                        <div style="height: 60px;">
                            <h2>更换logo</h2>
                            <div class="ibox-content pull-right" style="margin-top: -50px;">
                                @include('admin.webadminstrtion.logobomb')
                            </div>
                        </div>

                    </div> <!-- .form -->
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->

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
