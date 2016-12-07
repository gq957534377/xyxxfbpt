@extends('admin.layouts.master')

@section('content')
@section('title', '网站管理')
@section('style')

@endsection
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">轮播图管理</h3>
    </div>
    <div id="carousel">

    </div>
        <div class="col-sm-10">
            <div class="panel">
                <div class="panel-body">
                    <div class="media-main">
                        <a class="pull-left" href="#">
                            @include('admin.webadminstrtion.picturecarousel')
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
</div>

@endsection
@section('script')

        @include("admin.validator.webAdminValidator")
        <script src="{{ asset('/admin/js/carouselorganiz.js') }}"></script>
        <script src="{{asset('/cropper/js/cropper.min.js')}}"></script>
        <script src="{{asset('/cropper/js/carousel.js')}}"></script>
@endsection


