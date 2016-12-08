@extends('admin.layouts.master')
@section('content')
@section('title', '内容清单')
<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">内容列表</h3>
    </div>

    <div class="row">

        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="input-group">
                        <input type="text" id="example-input1-group2" name="example-input1-group2" class="form-control" placeholder="搜索">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                                    </span>
                    </div>
                </div>
            </div>
        </div>

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
                            <p class="text-muted">图形设计师</p>
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
                            <img class="thumb-lg img-circle bx-s" src="picture/avatar-3.jpg" alt="">
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
                            <p class="text-muted">图形设计师</p>
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
                            <img class="thumb-lg img-circle bx-s" src="picture/avatar-8.jpg" alt="">
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
                            <p class="text-muted">图形设计师</p>
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
                            <img class="thumb-lg img-circle bx-s" src="picture/avatar-9.jpg" alt="">
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
                            <p class="text-muted">图形设计师</p>
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


    </div> <!-- End row -->

    <div class="row">
        <div class="col-sm-12">
            <ul class="pagination pull-right">
                <li>
                    <a href="#" aria-label="Previous">
                        <i class="fa fa-angle-left"></i>
                    </a>
                </li>
                <li><a href="#">1</a></li>
                <li class="active"><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li class="disabled"><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>


</div> <!-- END Wraper -->

@endsection
@section('script')
@endsection
