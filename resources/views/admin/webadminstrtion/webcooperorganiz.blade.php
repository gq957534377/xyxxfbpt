@extends('admin.layouts.master')

@section('content')
@section('title', '网站管理')
@section('style')

@endsection
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">合作机构管理</h3>
    </div>
    <div id="carousel">
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
                    <hr/>
                    <ul class="social-links list-inline p-b-10">
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a>
                        </li>
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Message"><i class="fa fa-envelope-o"></i></a>
                        </li>
                    </ul>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- end col -->
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
                    <hr/>
                    <ul class="social-links list-inline p-b-10">
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a>
                        </li>
                        <li>
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Message"><i class="fa fa-envelope-o"></i></a>
                        </li>
                    </ul>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- end col -->
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
    <script src="{{ asset('/admin/js/cooperorganiz.js') }}"></script>
    <script src="{{asset('/cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('/cropper/js/carousel.js')}}"></script>
@endsection


