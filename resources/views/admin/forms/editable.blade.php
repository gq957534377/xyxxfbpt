@extends('admin.layouts.master')
<link type="text/css" href="http://cdn.rooyun.com/css/bootstrap-editable.css" rel="stylesheet">
@section('content')
@section('title', 'X-编辑')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">X-Editable</h3>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Inline Editor</h3>
                </div>
                <div class="panel-body">
                    <form action="#" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Simple Text Field</label>
                            <div class="col-sm-9">
                                <a href="#" id="inline-username" data-type="text" data-pk="1" data-title="Enter username">superuser</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Empty text field, required</label>
                            <div class="col-sm-9">
                                <a href="#" id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Select, local array, custom display</label>
                            <div class="col-sm-9">
                                <a href="#" id="inline-sex" data-type="select" data-pk="1" data-value="" data-title="Select sex"></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Select, error while loading</label>
                            <div class="col-sm-9">
                                <a href="#" id="inline-status" data-type="select" data-pk="1" data-value="0" data-source="/status" data-title="Select status">Active</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Combodate</label>
                            <div class="col-sm-9">
                                <a href="#" id="inline-dob" data-type="combodate" data-value="1984-05-15" data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" data-template="D / MMM / YYYY" data-pk="1"  data-title="Select Date of birth"></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Textarea, buttons below. Submit by <i>ctrl+enter</i></label>
                            <div class="col-sm-9">
                                <a href="#" id="inline-comments" data-type="textarea" data-pk="1" data-placeholder="Your comments here..." data-title="Enter comments">awesome user!</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Popover Editor</h3>
                </div>
                <div class="panel-body">
                    <form action="#" class="form-horizontal editor-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Simple Text Field</label>
                            <div class="col-sm-9">
                                <a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username">superuser</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Empty text field, required</label>
                            <div class="col-sm-9">
                                <a href="#" id="firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Select, local array, custom display</label>
                            <div class="col-sm-9">
                                <a href="#" id="sex" data-type="select" data-pk="1" data-value="" data-title="Select sex"></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Select, error while loading</label>
                            <div class="col-sm-9">
                                <a href="#" id="status" data-type="select" data-pk="1" data-value="0" data-source="/status" data-title="Select status">Active</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Combodate</label>
                            <div class="col-sm-9">
                                <a href="#" id="dob" data-type="combodate" data-value="1984-05-15" data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" data-template="D / MMM / YYYY" data-pk="1"  data-title="Select Date of birth"></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Textarea, buttons below. Submit by <i>ctrl+enter</i></label>
                            <div class="col-sm-9">
                                <a href="#" id="comments" data-type="textarea" data-pk="1" data-placeholder="Your comments here..." data-title="Enter comments">awesome user!</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> <!-- end row -->


</div>
@endsection
@section('script')
    <script type="text/javascript" src="http://cdn.rooyun.com/js/moment.min.js"></script>
    <script type="text/javascript" src="http://cdn.rooyun.com/js/bootstrap-editable.js"></script>
    <script type="text/javascript" src="http://cdn.rooyun.com/js/demo-xeditable.js"></script>
@endsection