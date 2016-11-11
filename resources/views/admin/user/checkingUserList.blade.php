@extends('admin.layouts.master')
@section('content')
    {{--//通过data_role_info数据表的status=1获取待审核用户--}}
    {{--//审核通过，data_role_info和数据表 data_user_info中的 role设置为2--}}
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
                    {{--<tr class="gradeX">--}}
                    {{--<td>Trident</td>--}}
                    {{--<td>Trident</td>--}}
                    {{--<td>Trident</td>--}}
                    {{--<td>Internet--}}
                    {{--Explorer 4.0--}}
                    {{--</td>--}}
                    {{--<td>Win 95+</td>--}}
                    {{--<td class="actions">--}}
                    {{--<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>--}}
                    {{--<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>--}}
                    {{--<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>--}}
                    {{--<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    </tbody>
                </table>
            </div>
            <!-- end: page -->

            {{--<!--分页开始-->--}}
            {{--<div class="row">--}}
            {{--<div class="col-sm-1"></div>--}}
            {{--<div class="col-sm-5">--}}
            {{--<div class="dataTables_info" id="datatable-responsive_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>--}}
            {{--</div>--}}
            {{--<div class="col-sm-6">--}}
            {{--<div class="dataTables_paginate paging_simple_numbers" id="datatable-responsive_paginate">--}}
            {{--<ul class="pagination">--}}
            {{--<li class="paginate_button previous disabled" aria-controls="datatable-responsive" tabindex="0" id="datatable-responsive_previous"><a href="#">Previous</a></li><li class="paginate_button active" aria-controls="datatable-responsive" tabindex="0">--}}
            {{--<a href="#">1</a>--}}
            {{--</li>--}}
            {{--<li class="paginate_button " aria-controls="datatable-responsive" tabindex="0">--}}
            {{--<a href="#">2</a></li>--}}
            {{--<li class="paginate_button " aria-controls="datatable-responsive" tabindex="0">--}}
            {{--<a href="#">3</a>--}}
            {{--</li>--}}
            {{--<li class="paginate_button " aria-controls="datatable-responsive" tabindex="0">--}}
            {{--<a href="#">4</a></li>--}}
            {{--<li class="paginate_button " aria-controls="datatable-responsive" tabindex="0">--}}
            {{--<a href="#">5</a></li>--}}
            {{--<li class="paginate_button " aria-controls="datatable-responsive" tabindex="0">--}}
            {{--<a href="#">6</a></li>--}}
            {{--<li class="paginate_button next" aria-controls="datatable-responsive" tabindex="0" id="datatable-responsive_next">--}}
            {{--<a href="#">Next</a>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!--分页结束-->--}}
        </div> <!-- end Panel -->
@endsection
@section('script')
    {{--<script src="http://cdn.rooyun.com/js/magnific-popup.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/jquery.datatables.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/datatables.bootstrap.js"></script>--}}
    {{--<script src="http://cdn.rooyun.com/js/datatables.editable.init.js"></script>--}}
@endsection