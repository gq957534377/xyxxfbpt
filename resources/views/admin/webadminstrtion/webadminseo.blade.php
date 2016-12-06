@extends('admin.layouts.master')

@section('content')
@section('title', '网站管理')
@section('style')

@endsection
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">SEO优化管理</h3>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class=" form p-20">

                        <form class="cmxform form-horizontal tasi-form" id="seofrom" method="post" action="#">

                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">TITLE：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="title" type="text" name="title" required="" aria-required="true" value="{{ $info['title'] or ''}}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">KEYWORDS：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="keywords" type="text" name="keywords" aria-required="true" value="{{ $info['keywords'] or ''}}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">DESCRIPTION：</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="description" type="text" name="description" aria-required="true" value="{{ $info['description'] or ''}}" >
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
@include("admin.validator.webAdminSeoValidator")


@endsection
