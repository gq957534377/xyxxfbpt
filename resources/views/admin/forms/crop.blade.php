@extends('admin.layouts.master')
<link rel="stylesheet" href="http://cdn.rooyun.com/css/cropper.css" />
@section('content')
@section('title', '功能测试')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Image Cropper</h3>
    </div>

    <div class="row">
        <div class="col-lg-8">

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Heading</h3></div>
                <div class="panel-body">
                    <div>
                        <img class="cropper" src="http://cdn.rooyun.com/picture/img_1.jpg" alt="Picture">
                    </div>

                    <hr>

                    <ul class="list-unstyled list-inline showcase-btn">
                        <li><button id="reset" type="button" class="btn btn-warning m-t-10">Reset</button></li>
                        <li><button id="reset2" type="button" class="btn  btn-warning m-t-10">Reset (deep)</button></li>
                        <li><button id="clear" type="button" class="btn btn-primary m-t-10">Release</button></li>
                        <li><button id="destroy" type="button" class="btn btn-danger m-t-10">Destroy</button></li>
                        <li><button id="enable" type="button" class="btn btn-success m-t-10">Enable</button></li>
                        <li><button id="disable" type="button" class="btn btn-warning m-t-10">Disable</button></li>
                        <li><button id="zoomIn" type="button" class="btn btn-info m-t-10">Zoom In</button></li>
                        <li><button id="zoomOut" type="button" class="btn btn-info m-t-10">Zoom Out</button></li>
                        <li><button id="rotateLeft" type="button" class="btn btn-info m-t-10">Rotate Left</button></li>
                        <li><button id="rotateRight" type="button" class="btn btn-info m-t-10">Rotate Right</button></li>
                        <li><button id="setData" type="button" class="btn btn-primary m-t-10">Set Data</button></li>
                    </ul>

                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Preview</h3></div>
                <div class="panel-body">
                    <div class="preview preview-md"></div>
                    <div class="preview preview-sm"></div>
                    <div class="preview preview-xs"></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Current Values</h3></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6 m-t-10">
                            <div class="input-group">
                                <span class="input-group-addon">X</span>
                                <input class="form-control" id="dataX" type="text" placeholder="x">
                            </div>
                        </div>
                        <div class="col-lg-6 m-t-10">
                            <div class="input-group">
                                <span class="input-group-addon">Y</span>
                                <input class="form-control" id="dataY" type="text" placeholder="y">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 m-t-10">
                            <div class="input-group">
                                <span class="input-group-addon">W</span>
                                <input class="form-control" id="dataWidth" type="text" placeholder="width">
                            </div>
                        </div>
                        <div class="col-lg-6 m-t-10">
                            <div class="input-group">
                                <span class="input-group-addon">H</span>
                                <input class="form-control" id="dataHeight" type="text" placeholder="height">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 m-t-10">
                            <div class="input-group">
                                <span class="input-group-addon">Rotate</span>
                                <input class="form-control" id="dataRotate" type="text" placeholder="rotate">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Actions</h3></div>
                <div class="panel-body">

                    <div class="input-group m-t-10">
                                    <span class="input-group-btn">
                                    <button class="btn btn-info" id="getData" type="button">Get Data</button>
                                    </span>
                        <input class="form-control" id="showData" type="text">
                    </div>


                    <div class="input-group m-t-15">
                                    <span class="input-group-btn">
                                    <button class="btn btn-info" id="getImageData" type="button">Get Image Data</button>
                                    </span>
                        <input class="form-control" id="showImageData" type="text">
                    </div>

                    <div class="input-group m-t-15">
                                    <span class="input-group-btn">
                                    <button class="btn btn-primary" id="replace" type="button">Replace</button>
                                    </span>
                        <input class="form-control" id="replaceWith" type="text" value="img/img_2.jpg">
                    </div>

                    <div class="input-group m-t-15">
                                    <span class="input-group-btn">
                                    <button class="btn btn-primary" id="setAspectRatio" type="button">Set Aspect Ratio</button>
                                    </span>
                        <input class="form-control" id="aspectRatio" name="aspectRatio" type="text" value="auto">
                    </div>

                    <div class="row">
                        <div class="col-lg-6 m-t-15"><button class="btn btn-primary btn-block" id="getDataURL" type="button">Get Data URL</button></div>
                        <div class="col-lg-6 m-t-15"><button class="btn btn-primary btn-block" id="getDataURL2" type="button">Get Data URL (JPG)</button></div>
                    </div>

                    <textarea class="form-control" id="dataURL" rows="3"></textarea>

                    <div id="showDataURL" class="m-t-15"></div>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection
@section('script')
    <script src="http://cdn.rooyun.com/js/cropper.min.js"></script>
    <script src="http://cdn.rooyun.com/js/cropper-conf.js"></script>
@endsection