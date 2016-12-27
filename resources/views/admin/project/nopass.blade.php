@extends('admin.layouts.master')

@section('style')
    <style>
        .unchecked_table {text-align: center;}
        .unchecked_table thead td:last-child{width:18%;}
        .unchecked_table thead td:nth-child(4){width:6%;}
        .unchecked_table thead td:nth-child(2){width:20%;}
        .unchecked_table td{max-width:200px;overflow: hidden;}
        .unchecked_table button{font-size: 10px;}
        .loading{z-index:999;position:absolute;display: none;}
        .unchecked_img{width:100%}
    </style>
@endsection

@section('content')
    <h3>可回收项目</h3>
    <table class = "table table-striped table-bordered unchecked_table" id="unchecked_table">
        <thead></thead><tbody></tbody>
    </table>

    <div id="margin_load" style="position: relative">
        <img src="{{ asset('admin/images/load.gif') }}" class="loading">
    </div>
    <!--通过操作提示框 start -->
    <div class="modal fade" id="verify_yes">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <div class="modal-body">
                    <p>您确认让它上线？</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="verify_yes_btn">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--通过操作提示框 end -->
@endsection

@section('script')
    <script src="{{ asset('JsService/Controller/project/nopassController.js') }}" type="text/javascript"></script>
@endsection