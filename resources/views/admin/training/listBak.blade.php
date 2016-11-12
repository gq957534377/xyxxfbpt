@extends('admin.layouts.master')
@section('styles')
    <style>
        .modal-content {
            width: 690px;
        }
    </style>
@endsection
@section('content')
    {{-- 弹出表单开始 --}}
    <button style="float: right;" class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">添加创业培训项目<i
                class="fa fa-plus"></i></button>
    <!--继承组件-->
    <!--替换按钮ID-->
@section('form-id', 'con-close-modal')
<!--定义弹出表单ID-->
@section('form-title', '添加创业项目培训')
<!--定义弹出内容-->
@section('form-body')
    <form method="post" action="{{url('training')}}">
        {{csrf_field()}}

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-1" class="control-label">创业技术培训名称：</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="请填写创业技术培训名称">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-2" class="control-label">组织机构名称：</label>
                    <input type="text" id="groupname" name="groupname" class="form-control" placeholder="请填写组织机构名称">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-4" class="control-label">培训开始时间：</label>
                    <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                           name="start_time" id="start_time">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-5" class="control-label">培训结束时间：</label>
                    <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                           name="stop_time" id="stop_time">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-6" class="control-label">报名截止时间：</label>
                    <input type="datetime-local" value="2016-11-11T00:00:00" class="form-control"
                           name="deadline" id="deadline">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-6" class="control-label">缩略图：</label>
                    <input type="file" class="form-control" name="banner" id="banner">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group no-margin">
                    <label for="field-7" class="control-label">创业项目培训详情</label>
                    <textarea class="" placeholder="请详细描述创业项目培训内容" id="UE" name="describe">请详细描述创业项目培训内容</textarea>
                </div>
            </div>
        </div>
    @endsection
    <!--定义底部按钮-->
        @section('form-footer')
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-info">发布</button>
            </div>
    </form>
@endsection
{{-- 弹出表单结束 --}}


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">创业项目培训列表</h3>

            </div>
            {{--table开始--}}
            <table class="table table-bordered table-striped" id="datatable-editable">
                <thead>
                <tr>
                    <th>创业项目培训主题</th>
                    <th>组织</th>
                    <th>培训开始时间</th>
                    <th>培训结束时间</th>
                    <th>报名截止时间</th>
                    <th>参与人数</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($msg as $v)
                    <tr class="gradeU">
                        <td>{{$v->title}}</td>
                        <td>{{$v->groupname}}</td>
                        <td>{{date('Y-m-d H:i:s', $v->start_time)}}</td>
                        <td>{{date('Y-m-d H:i:s', $v->stop_time)}}</td>
                        <td>{{date('Y-m-d H:i:s', $v->deadline)}}</td>
                        <td>{{$v->population}}</td>
                        <td>{{$v->status}}</td>
                        <td class="actions">
                            <a href="/training/{{$v->training_guid}}/edit" class="on-default edit-row"><i
                                        class="fa fa-pencil"></i></a>
                            <a href="/roald/{{$v->training_guid}}" class="on-default remove-row"><i
                                        class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--table结束--}}
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
@endsection
@section('script')
    <script>
        $(function () {
            $(".fa-pencil").click(function () {
                ajaxData(data);
            })
        })

        function ajaxData(data) {
            var url = "/training/"+{{$v->training_guid}}+"/edit";
            $.ajax({
                url:url,
                async:true,
                type:"get",
                beforeSend:function () {
                    //菊花图
                },
                success:function (data) {
                    //调用弹出层方法，传值
                    //菊花图隐藏
                },
                error:function (XMLHttpRequest, errmsg) {
                    //菊花图隐藏
                    //调用弹出层，提示失败请求
                }
            })
        }
    </script>
@endsection





