@extends('admin.layouts.master')
@section('content')
@section('title', '收件箱')


<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">收件箱</h3>
    </div>


    <div class="row">

        <!-- Left sidebar -->
        <div class="col-sm-3">
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

        <!-- Right sidebar -->
        <div class="col-sm-9">
            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success"><i class="fa fa-fw fa-level-up fa-rotate-270"></i></button>
                            <button type="button" class="btn btn-success"><i class="fa fa-exclamation-circle"></i></button>
                            <button type="button" class="btn btn-success"><i class="fa fa-trash-o"></i></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-folder"></i>
                                <b class="caret"></b>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#fakelink">动作</a></li>
                                <li><a href="#fakelink">另外动作</a></li>
                                <li><a href="#fakelink">其他的东西</a></li>
                                <li class="divider"></li>
                                <li><a href="#fakelink">分离链接</a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-tag"></i>
                                <b class="caret"></b>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#fakelink">动作</a></li>
                                <li><a href="#fakelink">另外动作</a></li>
                                <li><a href="#fakelink">其他的东西</a></li>
                                <li class="divider"></li>
                                <li><a href="#fakelink">分离链接</a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                更多
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#fakelink">下拉链接</a></li>
                                <li><a href="#fakelink">下拉链接</a></li>
                            </ul>
                        </div>

                    </div> <!-- btn-toolbar -->
                </div> <!-- end col -->
            </div> <!-- end row -->


            <!-- Message -->
            <div class="panel panel-default m-t-20">
                <div class="panel-heading">
                    <h3 class="panel-title">Hi Bro, How are you?</h3>
                </div>
                <div class="panel-body">
                    <div class="media m-b-30 ">
                        <a href="#" class="pull-left">
                            <img alt="" src="http://cdn.rooyun.com/picture/avatar-2.jpg" class="media-object thumb-sm">
                        </a>
                        <div class="media-body">
                            <span class="media-meta pull-right">07:23 AM</span>

                            <h4 class="text-primary m-0">Jonathan Smith</h4>
                            <small class="text-muted">From: jonathan@Velonic.com</small>
                        </div>
                    </div> <!-- media -->

                    <p><b>Hi Bro...</b></p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>
                    <p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.</p>
                    <p>Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar,</p>

                    <hr/>

                    <h4> <i class="fa fa-paperclip m-r-10 m-b-10"></i> 附件： <span>(2)</span> </h4>

                    <a href="#" class="thumb-sm"> <img src="http://cdn.rooyun.com/picture/sm-img-1.jpg" alt="attachment" class="br-radius m-r-10"> </a>
                    <a href="#" class="thumb-sm"> <img src="http://cdn.rooyun.com/picture/sm-img-2.jpg" alt="attachment" class="br-radius"> </a>

                </div> <!-- panel-body -->
            </div> <!-- End panel -->
            <!-- End message -->

            <!-- Replay -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <a href="#" class="pull-left">
                            <img alt="" src="http://cdn.rooyun.com/picture/avatar-3.jpg" class="media-object thumb-sm">
                        </a>
                        <div class="media-body">
                            <textarea class="wysihtml5 form-control" rows="10" placeholder="回复......"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Replay -->

        </div> <!-- Col-->

    </div><!-- End row -->

</div> <!-- END Wraper -->


@endsection
@section('script')

@endsection