@extends('admin.layouts.master')
@section('content')
@section('title', '功能测试')
        {{-- 弹出表单开始 --}}
        <button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">add</button>
        <!--继承组件-->
        <!--替换按钮ID-->
        @section('form-id', 'con-close-modal')
        <!--定义弹出表单ID-->
        @section('form-title', '表单标题')
        <!--定义弹出内容-->
        @section('form-body')
                <form id="formpatk" class="form-horizontal p-1" role="form" action="" method="">
                          <div class="form-group">
                              <label class="col-md-2 control-label">大赛名称：</label>
                              <div class="col-md-10">
                                  <input type="text" class="form-control" name="name" placeholder="roaldShow title...">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-2 control-label">活动排序：</label>
                              <div class="col-md-10">
                                  <input type="text" class="form-control" name="order" placeholder="第几届">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-2 control-label" for="example-email">组织机构：</label>
                              <div class="col-sm-10">
                                  <input type="text" id="example-email" name="org" class="form-control" placeholder="Speaker">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-2 control-label" for="example-email">活动描述：</label>
                              <div class="col-sm-10">
                                  <input type="text" id="example-email" name="title" class="form-control" placeholder="Speaker">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-2 control-label" for="example-email">活动内容：</label>
                              <div class="col-sm-10">
                                  <input type="text" id="example-email" name="content" class="form-control" placeholder="Speaker">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-2 control-label" for="example-email">参与人数：</label>
                              <div class="col-sm-10">
                                  <input type="text" id="example-email" name="peoples" class="form-control" placeholder="Speaker">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-2 control-label">开始时间：</label>
                              <div class="col-md-10">
                                  <input type="datetime-local" class="form-control" name="start_time">
                              </div>
                              <label class="col-md-2 control-label">结束时间：</label>
                              <div class="col-md-10">
                                  <input type="datetime-local" class="form-control" name="end_time">
                              </div>
                              <label class="col-md-2 control-label">截止报名：</label>
                              <div class="col-md-10">
                                  <input type="datetime-local" class="form-control" name="deadline">
                              </div>
                          </div>
                          <!-- <div class="form-group">
                              <label class="col-md-2 control-label">缩略图：</label>
                              <div class="col-md-10">
                                  <input type="file" class="form-control" name="banner">
                              </div>
                          </div> -->
                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                              <button id="submit" type="submit" class="btn btn-info">提交</button>
                          </div>
                      </form>
        @endsection
       <!--定义底部按钮-->
        @section('form-footer')

        @endsection
        {{-- 弹出表单结束 --}}

        {{-- AlertInfo --}}
        <a href="javascript:;" class="md-trigger btn btn-primary btn-sm" data-modal="modal-1">Show Me</a>
        @section('alertInfo-title', '弹出标题')
        @section('alertInfo-body')
            <p>This is a modal window. You can do the following things with it:</p>
            <ul>
                <li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
                <li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>
                <li><strong>Close:</strong> click on the button below to close the modal.</li>
            </ul>
            @endsection
        {{-- AlertInfoEnd --}}
{{-- AlertInfo --}}

{{-- 大赛详细信息 --}}

<div class="page-title">
      </div>
      <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="m-b-30">
                        <input id="tokens"  type="hidden" value="{{csrf_token()}}">
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped" id="datatable-editable">
                <thead>
                    <tr>
                        <th>大赛名称</th>
                        <th>大赛期数</th>
                        <th>组织机构</th>
                        <th>活动描述</th>
                        <th>活动内容</th>
                        <th>参与人数</th>
                        <th>开始时间</th>
                        <th>结束时间</th>
                        <th>报名截止</th>
                        <th>信息修改</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="gradeX">
                        <td>大赛名称</td>
                        <td>大赛期数</td>
                        <td>组织机构</td>
                        <td>活动描述</td>
                        <td>活动内容</td>
                        <td>参与人数</td>
                        <td>开始时间</td>
                        <td>结束时间</td>
                        <td>报名截止</td>
                        <td class="actions">
                            <a href="{{asset('/match/4ec9331aa72411e6a073080027bac1bb/edit')}}" id="left" class="on-default edit-row"><i class="fa fa-pencil" id='0' title="修改"></i></a>
                            <a href="#" id="right" class="on-default remove-row"><i class="fa fa-trash-o" id='' title="删除"></i></a>
                        </td>
                    </tr>


                    <!-- <tr>
                        <td>对不起还没有比赛信息，点击上面的添加按钮添</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <!-- end: page -->


@endsection
<!-- script -->
@section('script')
    <!--alertInfo JS-->
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
    <!-- 表单验证 -->
    <script>
        $(function() {
            $('#submit').click(function() {
                //获取数据已经弃用，改用form-data
                var data = {
                    name      : $('input[name="name"]').val(),
                    order     : $('input[name="order"]').val(),
                    org       : $('input[name="org"]').val(),
                    title     : $('input[name="title"]').val(),
                    content   : $('input[name="content"]').val(),
                    peoples   : $('input[name="peoples"]').val(),
                    start_time: $('input[name="start_time"]').val(),
                    end_time  : $('input[name="end_time"]').val(),
                    deadline  : $('input[name="deadline"]').val(),
                };
                // ajax参
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:"post",
                    url:'/match',
                    dataType:'json',
                    data:data,
                    success : function(data){
                        console.log(data);
                   },
                    error : function(XMLHttpRequest, textStatus, errorThrown){
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
                   }
                });
                return false;
            });
        });
        // 头验证
    </script>
@endsection
