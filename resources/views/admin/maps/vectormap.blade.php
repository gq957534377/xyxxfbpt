@extends('admin.layouts.master')
<!-- jvectormap -->
<link href="http://cdn.rooyun.com/css/jquery-jvectormap-2.0.2_1.css" rel="stylesheet" />
@section('content')
@section('title', 'vector地图')

<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Vector 地图</h3>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        世界地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets1"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets1" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="world-map-markers" style="height: 500px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        美国地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets2"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="usa" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        意大利地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets3"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets3" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="india" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->



    <div class="row">
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        英国地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets4"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets4" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="uk" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        芝加哥地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets5"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets5" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="chicago" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        澳大利亚地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets6"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets6" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="australia" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        加拿大地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets7"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets7" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="canada" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        德国地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets8"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets8" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="germany" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        亚洲地图
                    </h3>
                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlets9"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="portlets9" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="asia" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End row -->


</div> <!-- END Wraper -->


@endsection
@section('script')

    <!-- jvectormap -->
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-2.0.2.min_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-world-mill-en_1.js"></script>
    <script src="http://cdn.rooyun.com/js/gdp-data_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-us-aea-en_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-uk-mill-en_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-au-mill_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-us-il-chicago-mill-en_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-ca-lcc_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-de-mill_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-in-mill_1.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery-jvectormap-asia-mill_1.js"></script>

    <!--vectormap init-->
    <script src="http://cdn.rooyun.com/js/jvectormap.init_1.js"></script>
@endsection