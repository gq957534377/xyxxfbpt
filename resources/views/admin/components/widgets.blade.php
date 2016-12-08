@extends('admin.layouts.master')
@section('content')
@section('title', '窗口小部件')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Widgets</h3>
    </div>

    <!--Widget-1 -->
    <div class="row text-center">
        <div class="col-sm-6 col-md-3">
            <div class="panel">
                <div class="panel-body">
                    <div class="h2 text-purple m-t-10">15852</div>
                    <p class="text-muted m-b-10">Sales</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="panel bg-primary">
                <div class="panel-body">
                    <div class="h2 text-white m-t-10">956</div>
                    <p class="text-white m-b-10">New Orders</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="panel">
                <div class="panel-body">
                    <div class="h2 text-success m-t-10">5210</div>
                    <p class="text-muted m-b-10">New Users</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="panel bg-purple">
                <div class="panel-body">
                    <div class="h2 text-white m-t-10">20544</div>
                    <p class="text-white m-b-10">Visits</p>
                </div>
            </div>
        </div>

    </div> <!-- end row -->


    <!--Widget-2 -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="tile-stats white-bg">
                <div class="status">
                    <h3 class="m-t-0"><span class="counter">25</span>% more</h3>
                    <p>Monthly visitor statistics</p>
                </div>
                <div class="chart-inline">
                    <span class="inlinesparkline"></span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="tile-stats white-bg">
                <div class="status">
                    <h3 class="m-t-0 counter">49</h3>
                    <p>Avg. Sales per day</p>
                </div>
                <span class="dynamicbar-big"></span>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="tile-stats white-bg">
                <div class="status">
                    <h3 class="m-t-0 counter">0.9</h3>
                    <p>Stock Market</p>
                </div>
                <span id="compositeline"></span>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="tile-stats white-bg">
                <div class="col-sm-8">
                    <div class="status">
                        <h3 class="m-t-15"><span class="counter">91.5</span>%</h3>
                        <p>US Dollar Share</p>
                    </div>
                </div>
                <div class="col-sm-4 m-t-20">
                    <span class="sparkpie-big"></span>
                </div>
            </div>
        </div>
    </div> <!-- End row -->

    <!--Widget-2 -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-2 white-bg">
                <i class="zmdi zmdi-money text-success"></i>
                <h2 class="m-0 counter">50125</h2>
                <div class="text-muted">Total Revenue</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-2 white-bg">
                <i class="zmdi zmdi-shopping-cart-plus text-primary"></i>
                <h2 class="m-0 counter">145</h2>
                <div class="text-muted">Today's Sales</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-2 white-bg">
                <i class="zmdi zmdi-equalizer text-success"></i>
                <h2 class="m-0"><span class="counter">0.20</span>%</h2>
                <div class="text-muted">Conversion</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-2 white-bg">
                <i class="zmdi zmdi-eye text-primary"></i>
                <h2 class="m-0"><span class="counter">75845</span></h2>
                <div class="text-muted">Today's Visits</div>
            </div>
        </div>
    </div> <!-- End row -->


    <!--Widget-3 -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-1 bg-pink">
                <i class="fa fa-comments-o"></i>
                <h2 class="m-0 counter text-white">50</h2>
                <div class="text-white">Comments</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-1 bg-warning">
                <i class="fa fa-usd"></i>
                <h2 class="m-0 counter text-white">12056</h2>
                <div class="text-white">Sales</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-1 bg-info">
                <i class="fa fa-shopping-cart"></i>
                <h2 class="m-0 counter text-white">1268</h2>
                <div class="text-white">New Orders</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget-panel widget-style-1 bg-success">
                <i class="fa fa-user"></i>
                <h2 class="m-0 counter text-white">145</h2>
                <div class="text-white">New Users</div>
            </div>
        </div>
    </div> <!-- End row -->


    <!--Widget-4 -->
    <div class="row">
        <div class="col-md-3">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon bg-info"><i class="fa fa-usd"></i></span>
                <div class="mini-stat-info text-right">
                    <span class="counter">15852</span>
                    Total Sales
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon bg-warning"><i class="fa fa-shopping-cart"></i></span>
                <div class="mini-stat-info text-right">
                    <span class="counter">956</span>
                    New Orders
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon bg-pink"><i class="fa fa-user"></i></span>
                <div class="mini-stat-info text-right">
                    <span class="counter">5210</span>
                    New Users
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon bg-success"><i class="fa fa-eye"></i></span>
                <div class="mini-stat-info text-right">
                    <span class="counter">20544</span>
                    Unique Visitors
                </div>
            </div>
        </div>
    </div> <!-- End row-->


    <!-- WEATHER -->
    <div class="row">

        <div class="col-lg-6">

            <!-- BEGIN WEATHER WIDGET 1 -->
            <div class="panel bg-success">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <canvas id="partly-cloudy-day" width="115" height="115"></canvas>
                                </div>
                                <div class="col-xs-6">
                                    <h2 class="m-t-0 text-white"><b>32°</b></h2>
                                    <p class="text-white">Partly cloudy</p>
                                    <p class="text-white">15km/h - 37%</p>
                                </div>
                            </div><!-- End row -->
                        </div>
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <h4 class="text-white m-t-0">SAT</h4>
                                    <canvas id="cloudy" width="35" height="35"></canvas>
                                    <h4 class="text-white">30<i class="wi-degrees"></i></h4>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <h4 class="text-white m-t-0">SUN</h4>
                                    <canvas id="wind" width="35" height="35"></canvas>
                                    <h4 class="text-white">28<i class="wi-degrees"></i></h4>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <h4 class="text-white m-t-0">MON</h4>
                                    <canvas id="clear-day" width="35" height="35"></canvas>
                                    <h4 class="text-white">33<i class="wi-degrees"></i></h4>
                                </div>
                            </div><!-- end row -->
                        </div>
                    </div><!-- end row -->
                </div><!-- panel-body -->
            </div><!-- panel-->
            <!-- END Weather WIDGET 1 -->

        </div><!-- End col-md-6 -->

        <div class="col-lg-6">

            <!-- WEATHER WIDGET 2 -->
            <div class="panel bg-primary">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-7">
                            <div class="">
                                <div class="row">
                                    <div class="col-xs-6 text-center">
                                        <canvas id="snow" width="115" height="115"></canvas>
                                    </div>
                                    <div class="col-xs-6">
                                        <h2 class="m-t-0 text-white"><b> 23°</b></h2>
                                        <p class="text-white">Partly cloudy</p>
                                        <p class="text-white">15km/h - 37%</p>
                                    </div>
                                </div><!-- end row -->
                            </div><!-- weather-widget -->
                        </div>
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <h4 class="text-white m-t-0">SAT</h4>
                                    <canvas id="sleet" width="35" height="35"></canvas>
                                    <h4 class="text-white">30<i class="wi-degrees"></i></h4>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <h4 class="text-white m-t-0">SUN</h4>
                                    <canvas id="fog" width="35" height="35"></canvas>
                                    <h4 class="text-white">28<i class="wi-degrees"></i></h4>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <h4 class="text-white m-t-0">MON</h4>
                                    <canvas id="partly-cloudy-night" width="35" height="35"></canvas>
                                    <h4 class="text-white">33<i class="wi-degrees"></i></h4>
                                </div>
                            </div><!-- End row -->
                        </div> <!-- col-->
                    </div><!-- End row -->
                </div><!-- panel-body -->
            </div><!-- panel -->
            <!-- END WEATHER WIDGET 2 -->

        </div><!-- /.col-md-6 -->
    </div> <!-- End row -->



    <!-- Slider/ Carousel -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default text-center">
                <div class="panel-body p-0">
                    <div class="Velonic-carousel">
                        <div id="Velonic-slider" class="owl-carousel">
                            <div class="item">
                                <h4><a href="#">Hey! Welcome to Velonic</a></h4>
                                <p class="small">02 April, 2016</p>
                                <p class="m-t-30"><em>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</em></p>
                                <button class="btn btn-warning btn-sm m-t-40">Read more</button>
                            </div><!-- /.item -->

                            <div class="item">
                                <h4><a href="#">Hey! Welcome to Velonic</a></h4>
                                <p class="small">02 April, 2016</p>
                                <p class="m-t-30"><em>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</em></p>
                                <button class="btn btn-warning btn-sm m-t-40">Read more</button>
                            </div><!-- /.item -->

                            <div class="item">
                                <h4><a href="#">Hey! Welcome to Velonic</a></h4>
                                <p class="small">02 April, 2016</p>
                                <p class="m-t-30"><em>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</em></p>
                                <button class="btn btn-warning btn-sm m-t-40">Read more</button>
                            </div><!-- /.item -->

                        </div><!-- /#tiles-slide-1 -->
                    </div><!-- /.panel-body -->
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default text-center text-white slider-bg">
                <div class="slider-overlay br-radius"></div>
                <div class="panel-body p-0">
                    <div class="Velonic-carousel">
                        <div id="Velonic-slider-2" class="owl-carousel">
                            <div class="item">
                                <h4 class="text-white"><b>Hey! Welcome to Velonic</b></h4>
                                <p class="small">02 April, 2016</p>
                                <p class="m-t-30"><em>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</em></p>
                                <button class="btn btn-warning btn-sm m-t-40">Read more</button>
                            </div><!-- /.item -->

                            <div class="item">
                                <h4 class="text-white"><b>Hey! Welcome to Velonic</b></h4>
                                <p class="small">02 April, 2016</p>
                                <p class="m-t-30"><em>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</em></p>
                                <button class="btn btn-warning btn-sm m-t-40">Read more</button>
                            </div><!-- /.item -->

                            <div class="item">
                                <h4 class="text-white"><b>Hey! Welcome to Velonic</b></h4>
                                <p class="small">02 April, 2016</p>
                                <p class="m-t-30"><em>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</em></p>
                                <button class="btn btn-warning btn-sm m-t-40">Read more</button>
                            </div><!-- /.item -->
                        </div><!-- /#tiles-slide-2 -->
                    </div>
                </div> <!-- panel-body -->
            </div><!-- Panel -->
        </div> <!-- col-->

    </div>  <!-- End row -->


</div>
@endsection
@section('script')
@endsection