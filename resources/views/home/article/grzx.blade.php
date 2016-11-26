@extends('home.layouts.index')
@section('style')
    <script type="text/javascript" src="{{url('/qiniu/js/jquery.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/uploadbox.css')}}">
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/plupload.full.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/qiniu.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui2.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main2.js')}}"></script>
@endsection
@section('content')
    <section id="blog" class="container">
        {{--发布--}}
        <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" id="fabu">
                <div class="modal-content">
                    <form data-name="" role="form" id="yz_fb"  onsubmit="return false">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="title">文章发布</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">文章标题</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="article title...">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-5" class="control-label">缩略图</label>
                                        <input type="text" size="50" style="width: 150px;" class="lg"  id="banner" name="banner" disabled="true">
                                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                                        <img src="" id="article_thumb_img" style="max-width: 350px;max-height: 110px;">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">文章来源</label>
                                        <input type="text" class="form-control" id="source" name="source" placeholder="article source...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group no-margin">
                                        <label for="field-7" class="control-label">文章简述</label>
                                        <textarea class="form-control autogrow" id="brief" name="brief" placeholder="Write something about your article" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-12 control-label">文章详情</label>
                                <div class="col-md-12">
                                    <textarea id="UE" name="describe" class="describe"></textarea>
                                </div>
                            </div>

                            <meta name="csrf-token" content="{{ csrf_token() }}">

                        </div>
                        <div class="modal-footer" id="caozuo">
                            <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                            <button type="submit" data-name="2" class="add_article btn btn-primary">提交审核</button>
                            <a target=_blank data-name="5" class="add_article"><button type="submit" data-name="5" class="add_article btn btn-primary">预览</button></a>
                            <button type="submit" data-name="4" class="add_article btn btn-primary">存稿</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal -->
        {{--修改--}}

        <div class="center">
            <h2>文章管理</h2>
        </div>

        <button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">文章发布</button>
        <br>
        <a href="/send?status=1"><button class="btn @if($status == 1) btn-success @else btn-default @endif">已发布</button></a>
        <a href="/send?status=2"><button class="btn @if($status == 2) btn-success @else btn-default @endif">审核中...</button></a>
        <a href="/send?status=3"><button class="btn @if($status == 3) btn-success @else btn-default @endif">已退稿</button></a>
        <a href="/send?status=4"><button class="btn @if($status == 4) btn-success @else btn-default @endif">草稿</button></a>

        <div>
            <table style="width:100%;">
            @if(is_string($article))
            <h1>{{$article}}</h1>
            @else
                    <tr>
                        <td>标题</td>
                        <td>发布时间</td>
                        <td>简述</td>
                        <td>来源</td>
                        <td>操作</td>
                    </tr>
                @foreach($article as $v)
                <tr>
                    <td>{{$v->title}}</td>
                    <td>{{$v->time}}</td>
                    <td>{{$v->brief}}</td>
                    <td>{{$v->source}}</td>
                    <td>
                        @if($status == 1)
                            <a href="/article/{{$v->guid}}?type=3" target=_blank><button class="btn btn-success">查看详情</button></a>
                            @elseif($status == 2)
                            <a href="/send/{{$v->guid}}" target=_blank><button class="btn btn-success" href="/send/create?status=2">预览</button></a>
                            @elseif($status == 3)
                            <a href="/send/{{$v->guid}}" target=_blank><button class="btn btn-success" href="/send/create?status=3">编辑</button></a>
                            <a href="/send/{{$v->guid}}" target=_blank><button class="btn btn-danger" href="/send/create?status=3">删除</button></a>
                            @else
                            <a href="/send/{{$v->guid}}" target=_blank><button class="btn btn-success" href="/send/create?status=4">编辑</button></a>
                            <a href="/send/{{$v->guid}}" target=_blank><button class="btn btn-danger" href="/send/create?status=4">删除</button></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
            </table>
        </div>
    </section><!--/#blog-->
    @include('home.validator.publishValidator')
@endsection

@section('script')
    @include('home.user.ajax.ajaxRequire')
    {{--<script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>--}}
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="{{asset('/laravel-ueditor/ueditor.config.js') }}"></script>
    <script src="{{asset('/laravel-ueditor/ueditor.all.min.js')}}"></script>
    <script src="{{url('uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{url('uploadify/uploadify.css')}}">
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        var toolbra = {
            toolbars: [
                [
//                'anchor', //锚点
//                'undo', //撤销
//                'redo', //重做
                    'bold', //加粗
                    'indent', //首行缩进
                    'italic', //斜体
                    'underline', //下划线
//                'strikethrough', //删除线
//                'subscript', //下标
//                'fontborder', //字符边框
//                'superscript', //上标
//                'source', //源代码
                    'blockquote', //引用
//                'pasteplain', //纯文本粘贴模式
//                'selectall', //全选
                    'horizontal', //分隔线
                    'removeformat', //清除格式
//                'time', //时间
//                'date', //日期
                    'unlink', //取消链接
//                'insertrow', //前插入行
//                'insertcol', //前插入列
                    'mergeright', //右合并单元格
                    'mergedown', //下合并单元格
                    'deleterow', //删除行
                    'deletecol', //删除列
                    'inserttitle', //插入标题
                    'mergecells', //合并多个单元格
                    'deletetable', //删除表格
                    'cleardoc', //清空文档
                    'insertparagraphbeforetable', //"表格前插入行"
//                'insertcode', //代码语言
                    'fontfamily', //字体
                    'fontsize', //字号
                    'paragraph', //段落格式
//                'simpleupload', //单图上传
//                'insertimage', //多图上传
                    'edittable', //表格属性
                    'edittd', //单元格属性
                    'link', //超链接
                    'spechars', //特殊字符
//                'searchreplace', //查询替换
//                'gmap', //Google地图
//                'insertvideo', //视频
                    'justifyleft', //居左对齐
                    'justifyright', //居右对齐
                    'justifycenter', //居中对齐
                    'forecolor', //字体颜色
                    'backcolor', //背景色
//                'directionalityltr', //从左向右输入
//                'directionalityrtl', //从右向左输入
//                'rowspacingtop', //段前距
//                'rowspacingbottom', //段后距
//                'pagebreak', //分页
//                'insertframe', //插入Iframe
//                'imagenone', //默认
//                'imageleft', //左浮动
//                'imageright', //右浮动
//                'attachment', //附件
                    'imagecenter', //居中
                    'lineheight', //行间距
//                'customstyle', //自定义标题
//                'autotypeset', //自动排版
//                'webapp', //百度应用
                    'background', //背景
//                'template', //模板
//                'scrawl', //涂鸦
//                'music', //音乐
                    'inserttable', //插入表格
//                'charts', // 图表
                ]
            ],
            initialFrameWidth : '100%',
        };
        var ue = UE.getEditor('UE', toolbra);
//        var ue1 = UE.getEditor('UE1', toolbra);
        //    var ue2 = UE.getEditor('UE2', toolbra);

    </script>
    <script type="text/javascript">
        <?php $timestamp = time();?>
        //发布文章-图片上传
        $(function() {
            $('#file_upload').uploadify({
                'buttonText':'选择图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}",
                },
                'swf'      : '{{url('uploadify/uploadify.swf')}}',
                'uploader' : '{{url('/upload')}}',
                'onUploadSuccess':function (file,data,response) {
                    var data = JSON.parse(data);
                    $('#banner').val(data.res);
                    $('#article_thumb_img').attr('src',data.res);
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            });
            //修改文章-图片上传
            $('#file_charge').uploadify({
                'buttonText':'修改图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}",
                },
                'swf'      : '{{url('uploadify/uploadify.swf')}}',
                'uploader' : '{{url('/upload')}}',
                'onUploadSuccess':function (file,data,response) {
                    var data = JSON.parse(data);
                    $('#charge_banner').val(data.res);
                    $('#charge_thumb_img').attr('src',data.res);
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            });
        });
    </script>
    <script>
        $('.status1').off('click').on('click',function () {
            $('.status1').removeClass('btn-success').addClass('btn-default');
            $(this).addClass('btn-success');
        });

//发布
        $('.add_article').click(function () {
            var data = {
                title:$('input[name=title]').val(),
                banner:$('input[name=banner]').val(),
                source:$('input[name=source]').val(),
                brief:$('textarea[name=brief]').val(),
                describe:$('textarea[name=describe]').val(),
            };
            var status = $(this).data('name');

            console.log(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'/send?status='+status,
                type:'post',
                data: data,
                success:function (data) {
                    if (data.StatusCode == 200){
                        $('#con-close-modal').modal('hide');
                        alert('成功');
                    }
                    else {
                        alert(data.ResultData);
                    }
                }
            });
        });
    </script>
    @include('home.user.ajax.ajaxRequire')
    @include('home.validator.UpdateValidator')
@endsection

