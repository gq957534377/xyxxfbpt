@extends('admin.layouts.master')
@section('content')
    <div class="page-title">
        <h3 class="title">发布众筹</h3>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal p-20" role="form" action="/roald/" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group">
                            <label class="col-md-2 control-label">项目ID：</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="title" value="" placeholder="roaldShow title...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-email">筹款金额：</label>
                            <div class="col-md-10">
                                <input type="text" id="example-email" name="speaker" value="" class="form-control" placeholder="Speaker">
                            </div>
                        </div>
                        <center><button type="submit" class="btn btn-success m-l-10">发布</button></center>
                    </form>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
@endsection