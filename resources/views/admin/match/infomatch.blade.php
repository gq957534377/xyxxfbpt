@extends('admin.layouts.master')
@section('content')
    @section('title', '功能测试')
        {{-- 弹出表单开始 --}}
        <button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">add</button>
        <!--继承组件-->
        <!--替换按钮ID-->
        @section('form-id', 'con-close-modal')
        <!--定义弹出表单ID-->
        @section('form-title', '发布大赛')
        <!--定义弹出内容-->
        @section('form-body')
                <form id="signupForm" class="form-horizontal p-1" role="form" action="" method="">
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

<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Standard Modal</button>
        {{-- AlertInfo --}}
        <a href="javascript:;" id="error" class="md-trigger btn btn-primary btn-sm" data-modal="modal-1">Show Me</a>
        @section('alertInfo-title', '弹出标题')

            @section('alertInfo-body')
                <p></p>
                <ul>
                    <li></li>
                </ul>
            @endsection
        {{-- AlertInfoEnd --}}
{{-- AlertInfo --}}

{{-- 大赛详细信息 --}}

<div class="page-title">
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
                <tbody class="span">
                    <!-- <tr>
                        <td>对不起还没有比赛信息，点击上面的添加按钮添</td>
                    </tr> -->
                </tbody>
            </table>
            {{--paging--}}
            <div class="col-sm-12">
                <ul class="pagination pull-right">
                    <li>
                        <a href="#" aria-label="Previous">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li class="disabled"><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
            {{--end-paging--}}
            </div>
        </div>
    </div>
        <!-- end: page -->
<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Modal Heading</h4>
            </div>
            <div class="modal-body">
                <h4>Text in a modal</h4>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                <hr>
                <h4>Overflowing text to show scroll behavior</h4>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
<!-- script -->
@section('script')
    <!--alertInfo JS-->
        <script src="http://cdn.rooyun.com/js/classie.js"></script>
        <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
        <!--alertInfo end-->
        <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
        <script src="{{asset('/JsService/Controller/sendAjax.js')}}"></script>
        <script src="{{asset('/JsService/Controller/ajaxController.js')}}"></script>
        {{--获取分页数据半成品--}}
        <script>
            var againRequest;
            $(document).ready(function(){
                againRequest = function(){
                var data = {data:'2'};
                    $.ajax({
                        type:"get",
                        url:'paging',
                        // dataType:'json',
                        data:data,
                        processData:true,
                        beforeSend:function(){
                            console.log("数据正在发送");
                        },
                        success : function(data,textStatus){
                            console.log(textStatus);
                            for (var i=0;i<data.length;i++){
                                $(".span").append(
                                    '<tr class="gradeX">'+
                                    '<td>'+data[i].name+'</td>'+
                                    '<td>'+data[i].order+'</td>'+
                                    '<td>'+data[i].org+'</td>'+
                                    '<td>'+data[i].title+'</td>'+
                                    '<td>'+data[i].content+'</td>'+
                                    '<td>'+data[i].peoples+'</td>'+
                                    '<td>'+data[i].start_time+'</td>'+
                                    '<td>'+data[i].end_time+'</td>'+
                                    '<td>'+data[i].deadline+'</td>'+
                                    '<td class="actions">'+
                                        '<a href="javascript:;" id="left" data-name='+data[i].guid+' class="on-default edit-row"><i class="fa fa-pencil" title="修改"></i></a>'+
                                        '<a href="javascript:;" id="right"  data-name='+data[i].guid+' class="on-default remove-row"><i class="fa fa-trash-o" title="删除"></i></a>'+
                                    '</td>'
                                );
                            }
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown){
                            console.log(XMLHttpRequest.status);
                            console.log(XMLHttpRequest.readyState);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    });
                }
                againRequest();
            });
        </script>
        {{--事件操作--}}
        <script>
            {{--删除事件,成功之后页面重载--}}
            $(document).on('click','#right',function(){
                var data = this.getAttribute ('data-name');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url:'match/'+data,
                    type:'delete',
                    beforeSend:function(){
                        console.log("正在请求中");
                    },
                    success: function(data,textStatus) {
                        console.log(data);
                        console.log(textStatus);
                        // 重新载入页面
                        againRequest();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown){
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            });
            // 数据修改.还有弹窗
            $(document).on('click','#left',function(){
                var data = this.getAttribute ('data-name');

            });
        </script>
        {{--验证提交表单--}}
        <script>
                    !function($) {
                "use strict";
                var FormValidator = function() {
                    this.$signupForm = $("#signupForm");
                };
                FormValidator.prototype.init = function() {
                    $.validator.setDefaults({
                        submitHandler: function() {
                            $.ajaxSetup({
                                headers: {
<<<<<<< HEAD
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
=======
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
>>>>>>> origin/wangtuo
                                }
                            });
                            var data = new FormData();
                            data.append( "name"      , $('input[name=name]').val());
                            data.append( "order"     , $('input[name=order]').val());
                            data.append( "org"       , $('input[name=org]').val());
                            data.append( "title"     , $('input[name=title]').val());
                            data.append( "content"   , $('input[name=content]').val());
                            data.append( "peoples"   , $('input[name=peoples]').val());
                            data.append( "start_time", $('input[name=start_time]').val());
                            data.append( "end_time"  , $('input[name=end_time]').val());
                            data.append( "deadline"  , $('input[name=deadline]').val());
                            // add data for ajax
                            var sendajax = new Sendajax('match','post',data);
                                sendajax.send();
                        }
                    });
                    // validate signup form on keyup and submit
                    this.$signupForm.validate({
                        rules: {
                            name: {
                                required: true
                            },
                            order:{
                                required: true,
                                digits:true
                            },
                            org:{
                                required: true
                            },
                            title:{
                                required: true
                            },
                            content:{
                                required: true
                            },
                            peoples:{
                                required: true,
                                digits:true,
                                min:5
                            },
                            // start_time:{date:true},
                            // end_time:{date:true},
                            // deadline:{date:true}
                        },
                        //提示信息
                        messages: {
                            name: {
                                required: "请输入比赛名称"
                            },
                            order:{
                                required:"注意不能为空",
                                digits:"注意必须要为整数"
                            },
                            org:{
                                required:"注意不能为空"
                            },
                            title:{
                                required:"注意不能为空"
                            },
                            content:{
                                required:"注意不能为空"
                            },
                            peoples:{
                                required:"同志这个不能为空",
                                digits:"同志这个必须是数字",
                                min:"这个活动至少5个人吧"
                            },
                            // start_time:{date:""},
                            // end_time:{date:""},
                            // deadline:{date:""}
                        }
                    });

                },
                        //init
                        $.FormValidator = new FormValidator,
                        $.FormValidator.Constructor = FormValidator
            }(window.jQuery),

                    function($) {
                        "use strict";
                        $.FormValidator.init()
                    }(window.jQuery);
        </script>
@endsection
