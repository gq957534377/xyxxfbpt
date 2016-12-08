@extends('admin.layouts.master')
<link href="http://cdn.rooyun.com/css/dropzone.css" rel="stylesheet" type="text/css" />
@section('content')
@section('title', '文件上传')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">文件上传</h3>
    </div>

    <div class="row">
        <div class="col-md-12 portlets">
            <!-- Your awesome content goes here -->
            <div class="m-b-30">
                <form action="#" class="dropzone" id="dropzone">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="http://cdn.rooyun.com/js/dropzone.min.js"></script>
@endsection