@extends('admin.layouts.master')
@section('content')



    <div class="page-title">
        <h3 class="title">路演发布</h3>
    </div>






    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal p-20" role="form" action="/road" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">路演主题：</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="title" placeholder="roaldShow title...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-email">主讲人：</label>
                            <div class="col-md-10">
                                <input type="text" id="example-email" name="speaker" class="form-control" placeholder="Speaker">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属机构：</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="group">
                                    <option value="1">英雄会</option>
                                    <option value="2">兄弟会</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">路演开始时间：</label>
                            <div class="col-md-10">
                                <input type="datetime-local" class="form-control" name="roaldShow_time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">缩略图</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" name="banner">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">路演简述</label>
                            <div class="col-md-10">
                                <textarea class="col-md-12" name="brief"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">路演详情</label>
                            <div class="col-md-10">
                                <textarea id="UE" name="roadShow_describe"></textarea>
                            </div>
                        </div>
                        <center><button type="submit" class="btn btn-success m-l-10">发布</button></center>
                    </form>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->







@endsection