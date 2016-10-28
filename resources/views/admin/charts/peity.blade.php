@extends('admin.layouts.master')
@section('content')
@section('title', 'rickshaw图')


<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Peity Charts</h3>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Pie Charts</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Graph</th>
                            <th>Code</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>
                                <span data-plugin="peity-pie" data-colors="#3960d1,#ebeff2" data-width="30" data-height="30">1/5</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-pie" data-colors="#3960d1,#ebeff2" data-width="30" data-height="30"&gt;1/5&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-plugin="peity-pie" data-colors="#34c73b,#ebeff2" data-width="30" data-height="30">226/360</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-pie" data-colors="#34c73b,#ebeff2" data-width="30" data-height="30"&gt;226/360&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pie" data-plugin="peity-pie" data-colors="#3fb7ee,#ebeff2" data-width="30" data-height="30">0.52/1.561</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-pie" data-colors="#3fb7ee,#ebeff2" data-width="30" data-height="30"&gt;0.52/1.561&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pie" data-plugin="peity-pie" data-colors="#f7c836,#ebeff2" data-width="30" data-height="30">1,4</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-pie" data-colors="#f7c836,#ebeff2" data-width="30" data-height="30"&gt;1,4&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pie" data-plugin="peity-pie" data-colors="#d74548,#ebeff2" data-width="30" data-height="30">226,134</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-pie" data-colors="#d74548,#ebeff2" data-width="30" data-height="30"&gt;226,134&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pie" data-plugin="peity-pie" data-colors="#7d4bc5,#ebeff2" data-width="30" data-height="30">0.52,1.041</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-pie" data-colors="#7d4bc5,#ebeff2" data-width="30" data-height="30"&gt;0.52,1.041&lt;/span&gt;</code>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>  <!-- end panel-body -->
            </div>

        </div>
        <!-- end col -->

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Donut Charts</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Graph</th>
                            <th>Code</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <span class="donut" data-plugin="peity-donut" data-colors="#34c73b,#ebeff2" data-width="30" data-height="30">1/5</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-donut" data-colors="#34c73b,#ebeff2" data-width="30" data-height="30"&gt;1/5&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="donut" data-plugin="peity-donut" data-colors="#7d4bc5,#ebeff2" data-width="30" data-height="30">226/360</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-donut" data-colors="#7d4bc5,#ebeff2" data-width="30" data-height="30"&gt;226/360&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="donut" data-plugin="peity-donut" data-colors="#fc5d93,#ebeff2" data-width="30" data-height="30">0.52/1.561</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-donut" data-colors="#fc5d93,#ebeff2" data-width="30" data-height="30"&gt;0.52/1.561&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="donut" data-plugin="peity-donut" data-colors="#3fb7ee,#ebeff2" data-width="30" data-height="30">1,4</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-donut" data-colors="#3fb7ee,#ebeff2" data-width="30" data-height="30"&gt;1/4&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="donut" data-plugin="peity-donut" data-colors="#2f353f,#ebeff2" data-width="30" data-height="30">226,134</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-donut" data-colors="#2f353f,#ebeff2" data-width="30" data-height="30"&gt;226,134&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="donut" data-plugin="peity-donut" data-colors="#3960d1,#ebeff2" data-width="30" data-height="30">1,2,3,2,2</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-donut" data-colors="#3960d1,#ebeff2" data-width="30" data-height="30"&gt;1,2,3,2,2&lt;/span&gt;</code>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Line and Bars Charts</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Graph</th>
                            <th>Code</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>
                                <span data-plugin="peity-line" data-fill="#3960d1" data-stroke="#169c81" data-width="120" data-height="40">5,3,9,6,5,9,7,3,5,2</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-line" data-fill="#3960d1" data-stroke="#169c81" data-width="100" data-height="40"&gt;5,3,9,6,5,9,7,3,5,2&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-plugin="peity-line" data-fill="#34c73b" data-stroke="#169c81" data-width="120" data-height="40">5,3,2,-1,-3,-2,2,3,5,2</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-line" data-fill="#34c73b" data-stroke="#169c81" data-width="100" data-height="100"&gt;5,3,2,-1,-3,-2,2,3,5,2&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-plugin="peity-line" data-fill="#3fb7ee" data-stroke="#169c81" data-width="120" data-height="40">0,-3,-6,-4,-5,-4,-7,-3,-5,-2</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-line" data-fill="#3fb7ee" data-stroke="#169c81" data-width="100" data-height="100"&gt;0,-3,-6,-4,-5,-4,-7,-3,-5,-2&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-plugin="peity-bar" data-colors="#f7c836,#ebeff2" data-width="100" data-height="30">5,3,9,6,5,9,7,3,5,2</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-bar" data-colors="#f7c836,#ebeff2" data-width="100" data-height="30"&gt;5,3,9,6,5,9,7,3,5,2&lt;/span&gt;</code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-plugin="peity-bar" data-colors="#7d4bc5,#ebeff2" data-width="100" data-height="30">5,3,2,-1,-3,-2,2,3,5,2</span>
                            </td>
                            <td>
                                <code>&lt;span data-plugin="peity-bar" data-colors="#7d4bc5,#ebeff2" data-width="100" data-height="30"&gt;5,3,2,-1,-3,-2,2,3,5,2&lt;/span&gt;</code>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end col -->




        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Data-attributes charts</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Graph</th>
                            <th>Code</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>
                                <span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#4c5667", "#ebeff2"], "innerRadius": 24, "radius": 30 }'>6/7</span>
                            </td>
                            <td>
                                <code>
                                    &lt;span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#4c5667", "#ebeff2"],  "innerRadius": 24, "radius": 30 }'"&gt;6/7&lt;/span&gt;
                                </code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#5fbeaa", "#ebeff2"],  "innerRadius": 18, "radius": 28 }'>4/7</span>
                            </td>
                            <td>
                                <code>
                                    &lt;span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#5fbeaa", "#ebeff2"],  "innerRadius": 18, "radius": 28 }'"&gt;4/7&lt;/span&gt;
                                </code>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#5d9cec", "#ebeff2"],   "innerRadius": 20, "radius": 24 }'>5/7</span>
                            </td>
                            <td>
                                <code>
                                    &lt;span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#5d9cec", "#ebeff2"],  "innerRadius": 20, "radius": 24 }'"&gt;5/7&lt;/span&gt;
                                </code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#fb6d9d", "#ebeff2"], "innerRadius": 18, "radius": 20 }'>6/7</span>
                            </td>
                            <td>
                                <code>
                                    &lt;span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#fb6d9d", "#ebeff2"],  "innerRadius": 18, "radius": 20 }'"&gt;6/7&lt;/span&gt;
                                </code>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#7266ba", "#ebeff2"], "innerRadius": 18, "radius": 20 }'>5/7</span>
                            </td>
                            <td>
                                <code>
                                    &lt;span data-plugin="peity-donut-alt" data-peity='{ "fill": ["#7266ba", "#ebeff2"],  "innerRadius": 18, "radius": 20 }'"&gt;5/7&lt;/span&gt;
                                </code>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>  <!-- end panel-body -->
            </div>

        </div>
        <!-- end col -->

    </div>

    <!-- end row -->


</div>
<!-- Page Content Ends -->
<!-- ================== -->




@endsection
@section('script')
    <!-- jQuery peity Chart-->
    <script src="http://cdn.rooyun.com/js/jquery.peity.min.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery.peity.init.js"></script>
@endsection