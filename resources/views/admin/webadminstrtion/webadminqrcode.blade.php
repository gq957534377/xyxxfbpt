@extends('admin.layouts.master')

@section('content')
@section('title', '网站管理')
@section('style')

@endsection
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">二维码介绍管理</h3>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">二维码介绍</h3></div>
                <div class="panel-body">
                    <div class=" form p-20">

                        <form class="cmxform form-horizontal tasi-form" id="textfrom" method="get" action="#">
                            {{--<div class="form-group ">--}}
                                {{--<label for="cname" class="control-label col-lg-2">顶部宣传语：</label>--}}
                                {{--<div class="col-lg-10">--}}
                                    {{--<input class=" form-control" id="top-propaganda" name="toppropaganda" type="text" required="" aria-required="true">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">标题：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="title" type="text" name="title" required="" aria-required="true" value="{{ $info['title'] or ''}}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">简介1：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="synopsis1" type="text" name="synopsis1" aria-required="true" value="{{ $info['synopsis1'] or ''}}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">简介2：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="synopsis2" type="text" name="synopsis2"  aria-required="true" value="{{ $info['synopsis2'] or ''}}" >
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
@include("admin.validator.webAdminQRcodeValidator")


@endsection
@section('script')
    <script>

    </script>

@endsection
