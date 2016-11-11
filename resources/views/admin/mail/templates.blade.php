@extends('admin.layouts.master')
@section('content')
@section('title', '邮件模板')

<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">邮件模板</h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>基本邮件格式：</h4>
                            <a href="{{url('emailaction')}}" target="_blank">
                                <img src="http://cdn.rooyun.com/picture/2.png" class="img-responsive" alt="">
                            </a>
                        </div>
                        <div class="col-md-4">
                            <h4>弹出框格式：</h4>
                            <a href="{{url('emailalert')}}" target="_blank">
                                <img src="http://cdn.rooyun.com/picture/2.png" class="img-responsive" alt="">
                            </a>
                        </div>
                        <div class="col-md-4">
                            <h4>清单格式：</h4>
                            <a href="{{url('emailbilling')}}" target="_blank">
                                <img src="http://cdn.rooyun.com/picture/3.png" class="img-responsive" alt="">
                            </a>
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