@extends('admin.layouts.master')
@section('content')
    {{--这一步展示哪些信息？--}}
    {{--基本信息，--}}
    {{--每个创业者的项目列表，--}}
    {{--基本操作--}}
        <div class="page-title">
            <h3 class="title">创业者用户</h3>
        </div>
        <div class="panel">
            <div class="panel-body">
                <table class="table table-bordered table-striped" id="datatable-editable">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>昵称</th>
                        <th>性别</th>
                        <th>电话</th>
                        <th>邮箱</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr class="my_class">
                            <td>{{$v->realname}}</td>
                            <td>{{$v->nickname}}</td>
                            <td>{{$v->sex}}</td>
                            <td>{{$v->tel}}</td>
                            <td>{{$v->email}}</td>
                            <td class="actions">
                                <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            添加分页
        </div>
@endsection
@section('script')
    {{--<script src="http://cdn.rooyun.com/js/magnific-popup.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/jquery.datatables.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/datatables.bootstrap.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/datatables.editable.init.js"></script>--}}
@endsection