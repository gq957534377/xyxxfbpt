@extends('admin.layouts.master')
<link href="http://cdn.rooyun.com/css/ion.rangeslider.css" rel="stylesheet" type="text/css"/>
<link href="http://cdn.rooyun.com/css/ion.rangeslider.skinflat.css" rel="stylesheet" type="text/css"/>
@section('content')
@section('title', '范围滑块')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Range Slider</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Ion Range Slider</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="range_01" class="col-sm-2 control-label">Default<span class="text-muted clearfix font-normal small">Start without params</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="range_01">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_02" class="col-sm-2 control-label"><b>Min-Max</b><span class="text-muted clearfix font-normal small">Set min value, max value and start point</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="range_02">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_03" class="col-sm-2 control-label"><b>Prefix</b><span class="text-muted clearfix font-normal small">showing grid and adding prefix "$"</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="range_03">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_04" class="col-sm-2 control-label"><b>Range</b><span class="text-muted clearfix font-normal small">Set up range with negative values</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="range_04">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_05" class="col-sm-2 control-label"><b>Step</b><span class="text-muted clearfix font-normal small">Using step 250</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="range_05">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_06" class="col-sm-2 control-label"><b>Custom Values</b><span class="text-muted clearfix font-normal small">Using any strings as values</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="range_06">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_07" class="col-sm-2 control-label"><b>Prettify Numbers</b><span class="text-muted clearfix font-normal small">Prettify enabled. Much better!</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="range_07">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_08" class="col-sm-2 control-label"><b>Disabled</b><span class="text-muted clearfix font-normal small">Lock slider by using disable option</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="range_08">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- Row -->


</div>
@endsection
@section('script')
    <script src="http://cdn.rooyun.com/js/ion.rangeslider.min.js"></script>
    <script src="http://cdn.rooyun.com/js/ui-sliders.js"></script>
@endsection