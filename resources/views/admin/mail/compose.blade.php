@extends('admin.layouts.master')
@section('content')
@section('title', '写信')

<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">写信</h3>
    </div>

    <div class="row">

        <!-- Left sidebar -->
        <div class="col-md-3">
            <a href="{{url('compose')}}" class="btn btn-purple btn-block">写信</a>

            <div class="p-0 m-t-20">
                <div class="list-group mail-list">
                    <a href="{{url('inbox')}}" class="list-group-item"><i class="fa fa-download m-r-5"></i><b>收件箱(8)</b></a>
                    <a href="#" class="list-group-item"><i class="fa fa-star-o m-r-5"></i>星标邮件</a>
                    <a href="#" class="list-group-item"><i class="fa fa-file-text-o m-r-5"></i>草稿 <b>(20)</b></a>
                    <a href="#" class="list-group-item"><i class="fa fa-paper-plane-o m-r-5"></i>发件箱</a>
                    <a href="#" class="list-group-item"><i class="fa fa-trash-o m-r-5"></i>垃圾箱 <b>(354)</b></a>
                </div>
            </div>

            <h3 class="panel-title m-t-40">标签</h3>
            <div class=" m-t-20 p-0">
                <div class="list-group no-border mail-list">
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-info pull-right"></span>Web App</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-warning pull-right"></span>项目1</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-purple pull-right"></span>项目2</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-pink pull-right"></span>朋友</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-success pull-right"></span>家庭</a>
                </div>
            </div>
        </div>
        <!-- Left sidebar -->

        <!-- Right Sidebar -->
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-toolbar" role="toolbar">
                        <div>
                            <button type="button" class="btn btn-success m-r-5"><i class="fa fa-floppy-o"></i></button>
                            <button type="button" class="btn btn-success m-r-5"><i class="fa fa-trash-o"></i></button>
                            <button class="btn btn-success"> <span>发送</span> <i class="fa fa-send m-l-10"></i> </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default m-t-20">
                <div class="panel-body p-t-10">

                    <form role="form">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="收件人">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="cc">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Bcc">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="主题">
                        </div>
                        <div class="form-group">
                            <textarea class="wysihtml5 form-control" placeholder="正文" style="height: 200px"></textarea>
                        </div>
                    </form>
                </div> <!-- panel -body -->
            </div> <!-- panel -->
        </div> <!-- End Rightsidebar -->

    </div><!-- End row -->

</div> <!-- END Wraper -->

@endsection
@section('script')
@endsection