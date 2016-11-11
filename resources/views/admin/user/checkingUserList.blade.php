@extends('admin.layouts.master')
@section('content')
    {{--展示：--}}
    {{--基本信息，--}}
    {{--审核，--}}
    {{--基本操作--}}

    {{--审核内容弹层--}}
    {{--A：身份证号码一致性，人像一致性--}}
    {{--B: 对项目的审核--}}
        <div class="page-title">
            <h3 class="title">待审核用户</h3>
        </div>
        <div class="panel">
            <div class="panel-body">
                <table class="table table-bordered table-striped" id="datatable-editable">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>电话</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr class="my_class">
                            <td>{{$v->realname}}</td>
                            <td>{{$v->sex}}</td>
                            <td>{{$v->tel}}</td>
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
            弹出页面审核<br>
            添加分页
        </div>
@endsection
@section('script')
    {{--<script src="http://cdn.rooyun.com/js/magnific-popup.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/jquery.datatables.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/datatables.bootstrap.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/datatables.editable.init.js"></script>--}}
@endsection