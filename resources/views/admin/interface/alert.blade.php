@extends('admin.layouts.master')
@section('content')
@section('title', '弹窗')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">弹窗</h3>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"> 弹窗示例 </h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th style="width:50%;">弹窗类型</th>
                    <th>示例</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="middle-align">基础弹窗</td>
                    <td>
                        <button class="btn btn-info btn-sm" id="sa-basic">点击测试</button>
                    </td>
                </tr>
                <tr>
                    <td class="middle-align">A title with a text under</td>
                    <td>
                        <button class="btn btn-info btn-sm" id="sa-title">Click me</button>
                    </td>
                </tr>
                <tr>
                    <td class="middle-align">A success message!</td>
                    <td>
                        <button class="btn btn-info btn-sm" id="sa-success">Click me</button>
                    </td>
                </tr>
                <tr>
                    <td class="middle-align">A warning message, with a function attached to the "Confirm"-button...</td>
                    <td>
                        <button class="btn btn-info btn-sm" id="sa-warning">Click me</button>
                    </td>
                </tr>
                <tr>
                    <td class="middle-align">By passing a parameter, you can execute something else for "Cancel".</td>
                    <td>
                        <button class="btn btn-info btn-sm" id="sa-params">Click me</button>
                    </td>
                </tr>
                <tr>
                    <td class="middle-align">A message with custom Image Header</td>
                    <td>
                        <button class="btn btn-info btn-sm" id="sa-image">Click me</button>
                    </td>
                </tr>
                <tr>
                    <td class="middle-align">A message with auto close timer</td>
                    <td>
                        <button class="btn btn-info btn-sm" id="sa-close">Click me</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
@section('script')
    <script src="http://cdn.rooyun.com/js/sweet-alert.min.js"></script>
    <script src="http://cdn.rooyun.com/js/sweet-alert.init.js"></script>
@endsection