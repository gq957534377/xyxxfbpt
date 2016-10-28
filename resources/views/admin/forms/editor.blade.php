@extends('admin.layouts.master')
<link rel="stylesheet" type="text/css" href="http://cdn.rooyun.com/css/bootstrap-wysihtml5.css" />
<link href="http://cdn.rooyun.com/css/summernote.css" rel="stylesheet" />
@section('content')
@section('title', '所见即所得编辑器')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Editors</h3>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Summernote Editor</h3></div>
                <div class="panel-body">
                    <div class="summernote">Hello Summernote</div>
                </div>
            </div>
        </div>

    </div> <!-- End row -->


    <div class="row">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Wysihtml5 Editor</h3></div>
                <div class="panel-body">
                    <textarea class="wysihtml5 form-control" rows="9"></textarea>
                </div>
            </div>
        </div>

    </div> <!-- End row -->


</div>
@endsection
@section('script')
    <script type="text/javascript" src="http://cdn.rooyun.com/js/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="http://cdn.rooyun.com/js/bootstrap-wysihtml5.js"></script>
    <script src="http://cdn.rooyun.com/js/summernote.min.js"></script>


    <script>

        jQuery(document).ready(function(){
            $('.wysihtml5').wysihtml5();

            $('.summernote').summernote({
                height: 200,                 // set editor height

                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor

                focus: true                 // set focus to editable area after initializing summernote
            });

        });
    </script>
@endsection