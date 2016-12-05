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
                <div class="panel-heading"><h3 class="panel-title">logo管理</h3></div>
                <div class="panel-body">
                    <div class=" form p-20">

                        <div style="height: 60px;">
                            <h2>更换logo</h2>
                            <div class="ibox-content pull-right" style="margin-top: -50px;">
                                @include('admin.webadminstrtion.logobomb')
                            </div>
                        </div>

                        <form class="cmxform form-horizontal tasi-form" id="commentForm" method="get" action="#" novalidate="novalidate">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2">Name (required)</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="cname" name="name" type="text" required="" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">E-Mail (required)</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="cemail" type="email" name="email" required="" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="curl" class="control-label col-lg-2">URL (optional)</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="curl" type="url" name="url">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="ccomment" class="control-label col-lg-2">Your Comment (required)</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control " id="ccomment" name="comment" required="" aria-required="true"></textarea>
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

@include('admin.public.script')

@endsection
