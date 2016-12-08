@extends('admin.layouts.master')
@section('content')
@section('title', '清单')
<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">清单</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">
                    <h4>Invoice</h4>
                </div> -->
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-right"><img src="http://cdn.rooyun.com/picture/logo_dark.png" alt="Velonic"></h4>

                        </div>
                        <div class="pull-right">
                            <h4>Invoice # <br>
                                <strong>2016-05-23654789</strong>
                            </h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="pull-left m-t-30">
                                <address>
                                    <strong>Twitter, Inc.</strong><br>
                                    795 Folsom大街600号 <br>
                                    旧金山，加州94 1 07应急 <br>
                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                </address>
                            </div>
                            <div class="pull-right m-t-30">
                                <p><strong>订单日期: </strong> March 15, 2016</p>
                                <p class="m-t-10"><strong>订单状态: </strong> <span class="label label-warning">Pending</span></p>
                                <p class="m-t-10"><strong>订单 ID: </strong> #123456</p>
                            </div>
                        </div>
                    </div>
                    <div class="m-h-50"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table m-t-30">
                                    <thead>
                                    <tr><th>#</th>
                                        <th>项目</th>
                                        <th>描述</th>
                                        <th>数量</th>
                                        <th>单价</th>
                                        <th>总价</th>
                                    </tr></thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>LCD</td>
                                        <td>Lorem ipsum dolor sit amet.</td>
                                        <td>1</td>
                                        <td>$380</td>
                                        <td>$380</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Mobile</td>
                                        <td>Lorem ipsum dolor sit amet.</td>
                                        <td>5</td>
                                        <td>$50</td>
                                        <td>$250</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>LED</td>
                                        <td>Lorem ipsum dolor sit amet.</td>
                                        <td>2</td>
                                        <td>$500</td>
                                        <td>$1000</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>LCD</td>
                                        <td>Lorem ipsum dolor sit amet.</td>
                                        <td>3</td>
                                        <td>$300</td>
                                        <td>$900</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Mobile</td>
                                        <td>Lorem ipsum dolor sit amet.</td>
                                        <td>5</td>
                                        <td>$80</td>
                                        <td>$400</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="border-radius: 0px;">
                        <div class="col-md-3 col-md-offset-9">
                            <p class="text-right"><b>总价:</b> 2930.00</p>
                            <p class="text-right">Discout: 12.9%</p>
                            <p class="text-right">VAT: 12.9%</p>
                            <hr>
                            <h3 class="text-right">USD 2930.00</h3>
                        </div>
                    </div>
                    <hr>
                    <div class="hidden-print">
                        <div class="pull-right">
                            <a href="javascript:window.print()" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                            <a href="#" class="btn btn-primary">Submit</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Page Content Ends -->
<!-- ================== -->



@endsection
@section('script')
@endsection
