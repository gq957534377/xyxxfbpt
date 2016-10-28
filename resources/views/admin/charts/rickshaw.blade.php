@extends('admin.layouts.master')
@section('content')
@section('title', 'rickshaw图')


<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Ricksaw Charts</h3>
    </div>

    <!-- BAR Chart -->
    <div class="row">
        <div class="col-sm-12">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Line Chart
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
                        <div id="linechart"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div> <!-- col -->
    </div> <!-- End row-->


    <div class="row">
        <!--  Line Chart -->
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Lines & Toggling Chart
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
                        <div id="linetoggle"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>

        <!--  Line Chart -->
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Donut Chart
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlet5"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet5" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="lineplotchart"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>
    </div> <!-- End row-->

    <div class="row">
        <!--  Line Chart -->
        <div class="col-lg-12">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Multi Chart
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlet6"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet6" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="column">
                            <div id="multichart"></div>
                        </div>
                        <div class="column" id="legend"></div>
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
                        Simple area Chart
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
                        <div id="simplearea"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>

        <!-- Donut Chart -->
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Multiple Area
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
                        <div id="multiplearea"></div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>
    </div> <!-- End row-->




</div>




@endsection
@section('script')
    <!-- jQuery Flot Chart-->
    <script src="http://cdn.rooyun.com/js/d3.min.js"></script>
    <script src="http://cdn.rooyun.com/js/d3.layout.min.js"></script>
    <script src="http://cdn.rooyun.com/js/rickshaw.min.js"></script>
    <script src="http://cdn.rooyun.com/js/rickshaw.chart.init.js"></script>
@endsection