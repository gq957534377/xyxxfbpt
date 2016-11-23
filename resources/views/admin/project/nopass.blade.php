@extends('admin.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}">
    <style>
        .unchecked_table {text-align: center;}
        .unchecked_table thead td:last-child{width:18%;}
        .unchecked_table thead td:nth-child(4){width:6%;}
        .unchecked_table thead td:nth-child(2){width:20%;}
        .unchecked_table td{max-width:200px;overflow: hidden;}
        .unchecked_table button{font-size: 10px;}
        .loading{z-index:999;position:absolute;display: none;}
        .unchecked_img{width:100%}
    </style>
    <h3>未通过项目</h3>
    <table class = "table table-striped table-bordered unchecked_table" id="unchecked_table">
        <thead></thead><tbody></tbody>
    </table>
    {{--{!! $pages !!}--}}
    <img src="{{asset('/admin/images/load.gif')}}" class="loading">
@endsection

@section('script')
    <script src="{{url('JsService/Model/projectModel.js')}}" type="text/javascript"></script>
    <script src="{{url('JsService/Controller/project/nopassController.js')}}" type="text/javascript"></script>
@endsection