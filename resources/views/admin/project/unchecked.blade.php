@extends('admin.layouts.master')

@section('content')
<meta name="csrf-token" content="{{csrf_token()}}">
<style>
    .unchecked_table {text-align: center;}
    .unchecked_table thead td:last-child{width:18%;}
    .unchecked_table thead td:nth-child(4){width:6%;}
    .unchecked_table button{font-size: 10px;}
</style>
<h3>待审核项目</h3>
    <table class = "table table-striped table-bordered unchecked_table" id="unchecked_table">
        <thead>
            {{--<tr>--}}
                {{--<td>项目标题</td>--}}
                {{--<td>图片地址</td>--}}
                {{--<td>项目文件</td>--}}
                {{--<td>状态</td>--}}
                {{--<td>操作</td>--}}
            {{--</tr>--}}
        </thead>
        <tbody>
        {{--<tr>--}}
            {{--<td>1</td>--}}
            {{--<td>1</td>--}}
            {{--<td>1</td>--}}
            {{--<td>待审核</td>--}}
            {{--<td>--}}
                {{--<button type="button" class="btn btn-success m-b-5">YES</button>--}}
                {{--<button type="button" class="btn btn-primary m-b-5">NO</button>--}}
            {{--</td>--}}
        {{--</tr>--}}
        </tbody>
    </table>
@endsection

@section('script')
    <script src="{{url('JsService/Controller/ajaxController.js')}}" type="text/javascript"></script>
    <script src="{{url('JsService/Model/road/roadAjaxBeforeModel.js')}}" type="text/javascript"></script>
    <script src="{{url('JsService/Model/road/roadAjaxSuccessModel.js')}}" type="text/javascript"></script>
    <script src="{{url('JsService/Model/road/roadAjaxErrorModel.js')}}" type="text/javascript"></script>
<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
//        请求待审核数据
        $.ajax({
            url:'status1',
            type:'put',
            data:{
                status:'1'
            },
            beforeSend:function(){
                ajaxBeforeNoHiddenModel();
            },
            success:function(data){
                creatTable(data);
            },
            error:function(){
                alert('2');
            }
        })


        var creatTable = function(data){
            for(i in data.data){
                var tr = $('<tr></tr>');
                var title_td = $('<td>1</td>');
                title_td.html(data.data[i].title);
                var image_td = $('<td>1</td>');
                image_td.html(data.data[i].image);
                var file_td = $('<td>1</td>');
                file_td.html(data.data[i].file);
                var status_td = $('<td>待审核</td>');
                var btn_td = $('<td></td>');

                var btn_yes = $("<button class='btn btn-success m-b-5 btn_yes'>YES</button>");
                var btn_no = $("<button class='btn btn-primary m-b-5 btn_no'>NO</button>");
//                btn_no.addClass('btn btn-success m-b-5');
                btn_yes.attr({'id':data.data[i].project_id});
                btn_no.attr({'id':data.data[i].project_id});
                btn_td.append(btn_yes).append(btn_no);
                tr.append(title_td).append(image_td).append(file_td).append(status_td).append(btn_td);
                var thead_tr = $('<tr><td>项目标题</td><td>图片地址</td><td>项目文件</td><td>状态</td><td>操作</td></tr>');
                $("#unchecked_table tbody").append(tr);
            }
            $("#unchecked_table thead").append(thead_tr);
        }
    })
</script>
@endsection