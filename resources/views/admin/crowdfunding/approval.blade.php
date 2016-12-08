@extends('admin.layouts.master')
@section('content')
@section('title', '众筹管理')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">众筹管理</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button id="publishBtn" class="btn  btn-info">发布众筹</button>
                    <div id="lookStatus" style="float: right;">
                        <button zxz-status="1"  class="btn btn-success">查看发布项目</button>
                        <button zxz-status="0" class="btn">查看下架项目</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                            <table id="datatable" class="table table-condensed table-striped table-bordered">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Row -->
</div>
<center id="imgLoad" style="display: none"><img src="/admin/images/load.gif" style="position: absolute;top:300px;"></center>
<center id="pageCenter">

</center>
    <button id="modals" style="display: none" class="btn btn-primary" data-toggle="modal" data-target="#con-close-modalssss">表单弹窗</button>
    <div id="con-close-modalssss" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">琦立英雄众筹管理系统</h4>
                </div>
                <div class="modal-body" id="plotDiv">
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeButton"  class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" id="supperButton" class="btn btn-danger">确认</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    @include("admin.Tool.Ajax")
    <script src="{{ asset('/admin/js/crowd-funding.js') }}"></script>
@endsection
