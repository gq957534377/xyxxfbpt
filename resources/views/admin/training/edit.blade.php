@extends('admin.layouts.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="training" class="form-horizontal p-20" role="form" action="/add_training" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">创业技术培训名称：</label>
                            <div class="col-md-10">
                                <input type="text" value="{{$msg->title}}" class="form-control" name="title" id="title"
                                       placeholder="请填写创业技术培训名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-email">组织机构名称：</label>
                            <div class="col-md-10">
                                <input type="text" id="groupname" value="{{$msg->groupname}}" name="groupname"
                                       class="form-control"
                                       placeholder="请填写组织机构名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">培训开始时间：</label>
                            <div class="col-md-10">
                                <input type="datetime-local" value="{{data('Y-m-d\TH:i:s', $msg->start_time)}}"
                                       class="form-control"
                                       name="start_time" id="start_time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">培训结束时间：</label>
                            <div class="col-md-10">
                                <input type="datetime-local" value="{{data('Y-m-d\TH:i:s', $msg->stop_time)}}"
                                       class="form-control" name="stop_time" id="stop_time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">报名截止时间：</label>
                            <div class="col-md-10">
                                <input type="datetime-local" value="{{data('Y-m-d\TH:i:s', $msg->deadline)}}"
                                       class="form-control" name="deadline" id="deadline">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">缩略图：</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" value="{{$msg->banner}}" name="banner"
                                       id="banner">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">培训详情</label>
                            <div class="col-md-10">
                                <textarea id="UE" name="describe">{{$msg->roadShow_describe}}</textarea>
                            </div>
                        </div>
                        <center>
                            <button type="submit" class="btn btn-success m-l-10">发布</button>
                        </center>
                    </form>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->







@endsection