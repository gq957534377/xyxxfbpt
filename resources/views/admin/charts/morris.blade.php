@extends('admin.layouts.master')
@section('content')
@section('title', 'morris图')

<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Morris Chart</h3>
    </div>

    <!-- BAR Chart -->
    <div class="row">
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Bar Chart
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#bg-default"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="bg-default" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="morris-bar-example" style="height: 300px;"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div> <!-- col -->

        <!--  Line Chart -->
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Line Chart
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlet4"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet4" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="morris-line-example" style="height: 300px;"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>
    </div> <!-- End row-->


    <div class="row">

        <!-- Area Chart -->
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Area Chart
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlet2"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="morris-area-example" style="height: 300px;"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>

        <!-- Donut Chart -->
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Donut Chart
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlet3"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet3" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="morris-donut-example" style="height: 300px;"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>
    </div> <!-- End row-->



@endsection
@section('script')
        <script src="http://cdn.rooyun.com/js/morris.min.js"></script>
        <script src="http://cdn.rooyun.com/js/raphael.min.js"></script>
        <script src="http://cdn.rooyun.com/js/morris.init.js"></script>
@endsection