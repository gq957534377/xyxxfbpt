@extends('home.layouts.userCenter')

@section('title','修改文稿')

@section('style')
    <link href="{{ asset('home/css/user_center_my_road.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('imageInput/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('imageInput/css/ssi-uploader.min.css') }}"/>
    <style>
        .pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #ff9600;
            border-color: #ff9600;
        }

        div#image {
            width: 60%;
            margin-left: 21%;
        }

        .loading {
            z-index: 999;
            position: absolute;
            display: none;
        }

        .container {
            width: 100%;
        }

        .error {
            color: red;
        }
    </style>
@endsection

@section('content')
    @include('home.public.error')
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10  mar-clr my-road row">
        <input type="hidden" id="domain" value="{{ QINIU_URL }}">
        <input type="hidden" id="uptoken_url" value="{{url('getQiniuToken')}}">
        <form action="{{ url("send/{$data->guid}") }}" id="add-form" class="add2-form" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="modal-header">
                <h4 class="modal-title">投稿</h4>
            </div>
            <input type="hidden" value="2">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">标题：</label>
                            <input type="text" class="form-control" name="title" placeholder="请输入文章标题" value="{{ $data->title }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>文章类型：</label>
                        <select class="form-control" id="action" name="type" value="{{ $data->type }}">
                            <option value="1">爱情文章</option>
                            <option value="2">亲情文章</option>
                            <option value="3">友情文章</option>
                            <option value="4">生活随笔</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="field-1" class="control-label">简述：</label>
                        <textarea type="text" class="form-control" name="brief"
                                  placeholder="请输入文章简述">{{ $data->brief }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label">详情：</label>
                    <div class="col-md-12">
                        <textarea id="UE" name="describe">{{ $data->describe }}</textarea>
                    </div>
                </div>
                <img src="{{ $data->banner }}" style="width: 100%;height: 100%" id="img">
                <div class="row">
                    <div class="col-md-12" id="up_img">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="path" name="banner" value="{{ $data->banner }}">
                        <input type="file" multiple id="ssi-upload"/>
                        <div>仅支持PNG\JPEG\JPG\GIF图片呦O(∩_∩)O~（单张图片小于2M）</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">来源：</label>
                            <input type="text" class="form-control" name="source" value="{{ $data->source }}" placeholder="请输入来源">
                        </div>
                    </div>
                </div>
            </div>
            <input id="status" name="status" type="hidden">
            <div class="modal-footer">
                <button type="submit" class="btn-tj btn btn-info">提交审核</button>
                <button type="submit" class="btn-cg btn btn-info">保存草稿</button>
                <button type="submit" class="btn-yl btn btn-info">预览</button>
            </div>
        </form>
    </div>
    <!--我参加的活动列表结束-->
@endsection
@section('script')
    <script src="{{ asset('imageInput/js/ssi-uploader.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.validate.min.js') }}"></script>
    {{--<script src="{{asset('JsService/Model/ajaxBeforeModel.js')}}" type="text/javascript"></script>--}}
    {{--富文本--}}
    <script src="{{asset('/laravel-ueditor/ueditor.config.js') }}"></script>
    <script src="{{asset('/laravel-ueditor/ueditor.all.min.js')}}"></script>
    <script>
        $('.btn-tj').click(function () {
            $('#status').val(2);
        });
        $('.btn-cg').click(function () {
            $('#status').val(4);
        });
        $('.btn-yl').click(function () {
            $('#status').val('yl');
        });
        $(function () {
            getToken();
        });

        var getToken = function () {
            $.ajax({
                url: $('#uptoken_url').val(),
                type: 'get',
                async: false,
                success: function (data) {
                    $('#tokens').val(data.uptoken);
//                    alert(data.uptoken);
                    $('#ssi-upload').ssi_uploader({
                        url: 'http://upload.qiniu.com/',
                        data: {'token': data.uptoken},
                        maxFileSize: 2,
                        maxNumberOfFiles: 1,
                        allowed: ['jpg', 'gif', 'png'],
                        onEachUpload: function (fileInfo, xhr) {
                            if (!xhr.key) {
                                uplodeImg = false;
                            }
                            var domian = $('#domain').val();
                            $('#path').val(domian + xhr.key);
                        }
                    });
                }
            });
        };

        //富文本配置
        var toolbra = {
            toolbars: [
                [
                    'bold', //加粗
                    'indent', //首行缩进
                    'italic', //斜体
                    'underline', //下划线
                    'blockquote', //引用
                    'pasteplain', //纯文本粘贴模式
                    'horizontal', //分隔线
                    'removeformat', //清除格式
                    'mergeright', //右合并单元格
                    'mergedown', //下合并单元格
                    'deleterow', //删除行
                    'deletecol', //删除列
                    'inserttitle', //插入标题
                    'mergecells', //合并多个单元格
                    'deletetable', //删除表格
                    'cleardoc', //清空文档
                    'insertparagraphbeforetable', //"表格前插入行"
                    'fontfamily', //字体
                    'fontsize', //字号
                    'paragraph', //段落格式
                    'insertimage', //多图上传
                    'edittable', //表格属性
                    'edittd', //单元格属性
                    'link', //超链接
                    'spechars', //特殊字符
                    'insertvideo', //视频
                    'justifyleft', //居左对齐
                    'justifyright', //居右对齐
                    'justifycenter', //居中对齐
                    'forecolor', //字体颜色
                    'backcolor', //背景色
                    'pagebreak', //分页
                    'attachment', //附件
                    'imagecenter', //居中
                    'lineheight', //行间距
                    'autotypeset', //自动排版
                    'background', //背景
                    'music', //音乐
                    'inserttable', //插入表格
                ]
            ],
            initialFrameWidth: '100%',
            initialFrameHeight: '220',
        };
        var ue = UE.getEditor('UE', toolbra);

        // 上传表单验证
        $("#add-form").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 80
                },
                brief: {
                    required: true,
                    maxlength: 150
                },
                describe: {
                    required: true,
                },
                source: {
                    required: true,
                    maxlength: 80
                },
                banner: {
                    required: true,
                },
            },
            //错误信息提示
            messages: {
                title: {
                    required: '请输入文章标题',
                    maxlength: '标题最80个字符'
                },
                brief: {
                    required: '请输入文章简述',
                    maxlength: '文章简述最多150个字符'
                },
                describe: {
                    required: '请输入文章详情',
                },
                source: {
                    required: '请输入文章来源',
                    maxlength: '文章来源最多80个字符'
                },
                banner: {
                    required: '请上传缩略图',
                },
            },
        });

    </script>

@endsection
