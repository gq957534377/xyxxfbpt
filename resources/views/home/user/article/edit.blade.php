@extends('home.layouts.userCenter')

@section('title','我的二手')

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
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10  mar-clr my-road row">
        @include('home.public.error')
        <input type="hidden" id="domain" value="{{ QINIU_URL }}">
        <input type="hidden" id="uptoken_url" value="{{url('getQiniuToken')}}">
        <form action="{{ url('userGoods/'.$data->guid) }}" id="add-form" class="add2-form" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            {{--<input type="hidden" name="_method" value="PUT">--}}
            <div class="modal-header">
                <h4 class="modal-title">修改商品</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="field-1" class="control-label">商品名：</label>
                            <input type="text" class="form-control" name="name" value="{{ $data->name }}"
                                   placeholder="请输入商品名">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">价格：</label>
                            <input type="text" class="form-control" name="price" value="{{ $data->price }}"
                                   placeholder="请输入价格">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">商品简述：</label>
                            <textarea type="text" class="form-control" name="brief"
                                      placeholder="请输入商品简述">{{ $data->brief }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label">商品详情：</label>
                    <div class="col-md-12">
                        <textarea id="UE" name="content">{{ $data->content }}</textarea>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">QQ：</label>
                            <input type="text" value="{{ $data->qq }}" class="form-control" name="qq"
                                   placeholder="请输入QQ号">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">电话：</label>
                            <input type="text" class="form-control" value="{{ $data->tel }}" name="tel"
                                   placeholder="请输入电话">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">微信：</label>
                            <input type="text" class="form-control" name="wechat" value="{{ $data->wechat }}"
                                   placeholder="请输入微信">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">修改</button>
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
        $(function () {
            getToken();
        });

        // 获取七牛token
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
                            $('#img').attr('src', domian + xhr.key)
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
                name: {
                    required: true,
                    maxlength: 64
                },
                price: {
                    required: true,
                    number: true,
                },
                content: {
                    required: true,
                },
                brief: {
                    required: true,
                    maxlength: 120
                },
                qq: {
                    required: true,
                    digits: true
                },
                tel: {
                    required: true,
                    digits: true
                },
                wechat: {
                    required: true,
                },
            },
            //错误信息提示
            messages: {
                name: {
                    required: '请输入商品名',
                    maxlength: '商品名最多64个字符'
                },
                price: {
                    required: '请输入商品价格',
                    number: '请输入数字',
                },
                content: {
                    required: '请输入商品详情',
                },
                brief: {
                    required: '请输入商品简述',
                    maxlength: '商品简述最多120个字符'
                },
                qq: {
                    required: '请输入QQ号',
                    digits: '请输入正确格式QQ号'
                },
                tel: {
                    required: '请输入手机号',
                    digits: '请输入正确的手机号格式'
                },
                wechat: {
                    required: '请输入微信账号',
                },
            },
        });

    </script>

@endsection
