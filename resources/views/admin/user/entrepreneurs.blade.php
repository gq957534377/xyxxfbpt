@extends('admin.layouts.master')

{{--展示内容开始--}}
@section('content')
    <img src="{{asset('admin/images/load.gif')}}" class="loading">
    <div class="page-title">
        <h3 class="title">待审核用户</h3>
    </div>
    {{--表格盒子开始--}}
    <div class="panel"></div>
    {{--表格盒子结束--}}
@endsection
{{--展示内容结束--}}

{{--弹出页面 开始--}}
@section('form-id', 'xxxxxxx')
@section('form-title', 'yyyyyyy')
@section('form-body')

@endsection
@section('form-footer')

@endsection
{{--弹出页面结束--}}

{{--警告信息弹层开始--}}
@section('alertInfo-title', 'xxxxxxxxxx')
@section('alertInfo-body', 'yyyyyyyy')
{{--警告信息弹层结束--}}

@section('script')

@endsection