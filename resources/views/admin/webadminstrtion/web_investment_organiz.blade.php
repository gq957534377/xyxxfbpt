@extends('admin.layouts.master')

@section('content')
@section('title', '网站管理')
@section('style')

@endsection
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">投资机构管理</h3>
    </div>
    <div id="carousel">


    </div>
    <div class="col-sm-10">
        <div class="panel">
            <div class="panel-body">
                <div class="media-main">
                    <a class="pull-left" href="#">
                        @include('admin.webadminstrtion.investment_organiz')
                    </a>
                </div>
                <div class="info">
                    <h4>添加投资机构</h4>

                </div>
                <div class="clearfix"></div>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- end col -->
</div>
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

@endsection
@section('script')

    @include("admin.validator.webAdminValidator")
    <script src="{{ asset('/admin/js/inves-organiz.js') }}"></script>
    <script src="{{asset('/cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('/cropper/js/cooper.js')}}"></script>
@endsection


