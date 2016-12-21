@extends('home.layouts.userCenter')

@section('title', '我的身份')

@section('style')
  <link href="{{ asset('home/css/user_center_contribute.css') }}" rel="stylesheet">

  <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
  <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
@endsection

@section('content')
      <!--我的投稿 已发表开始-->
      <!--导航开始-->
      <div class="tab-info-top col-xs-12 col-sm-9 col-md-9 col-lg-10 pad-clr">
        <a id="contribute" class="hidden-xs" href="/send?status=5">&nbsp;&nbsp;投稿&nbsp;&nbsp;<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?status=2">审核中({{ $ResultData['releaseNum'] or 0 }})<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?status=1">已发表({{ $ResultData['trailNum'] or 0 }})<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?status=3">已退稿({{ $ResultData['notNum'] or 0 }})<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?status=4">草稿箱({{ $ResultData['draftNum'] or 0 }})<span class="triangle-down left-2"></span></a>
      </div>
      <!--导航结束-->
      <div id="contributeNav" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 fs-15 bgc-1 pad-2">
            <input hidden id="write" value="{{ $write or false }}">
          <div id="contribute-text">
             <span class="contribute-title">投稿</span>
             <form id="contribute-form" class="form-horizontal form-contribute" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                  <div class="form-group mar-b30">
                      <label for="form-title" class="col-md-2 control-label"><span class="form-star">*</span>标题</label>
                      <div class="col-md-10">
                          <input autofocus type="text" class="form-control form-title" id="form-title" name="title" placeholder="">
                          </div>
                      </div>
                  <div class="form-group mar-b30">
                     <label for="form-introduction" class="col-md-2 control-label"><span class="form-star">*</span>导语</label>
                      <div class="col-md-10">
                          <textarea class="form-control form-introduction" id="form-introduction" name="brief" placeholder=""></textarea>
                         </div>
                  </div>
                 <div class="form-group mar-b30">
                     <label for="form-content" class="col-md-2 control-label"><span class="form-star">*</span>展示图片</label>
                     <div class="col-md-10">
                         <input type="hidden" name="1">
                         <div class="col-md-5">
                             <div class="ibox-content">
                                 <div class="row">
                                     <div id="crop-avatar" class="col-md-6">
                                         <div class="avatar-view" title="">
                                             <img id="contribution-picture" src="{{ asset('home/img/upload-card.png') }}" alt="Logo">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                  <div class="form-group mar-b30">
                      <label for="form-content" class="col-md-2 control-label"><span class="form-star">*</span>内容</label>
                     <div class="col-md-10">
                          <textarea class="" id="form-content" name="describe"></textarea>
                          </div>
                  </div>

                 <div class="form-group mar-b30">
                     <label for="form-source" class="col-md-2 control-label"><span class="form-star">*</span>来源</label>
                     <div class="col-md-4 mar-b30">
                         <input type="text" class="form-control" id="form-source" name="source" placeholder="">
                     </div>
                 </div>
                  <div class="form-group mar-b30">
                      <label for="auth-code" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>验证码</label>
                      <div class="col-md-8 pad-clr">
                          <div class="col-xs-5 col-sm-8 col-md-6">
                             <input class="form-control" type="text" id="auth-code" name="verif_code" placeholder="">
                              </div>
                          <div class="col-xs-6 col-sm-4 col-md-4">
                              <img id="captcha" data-sesid="{{ $sesid }}" src="{{url('/code/captcha/' . $sesid)}}">
                              </div>
                          </div>
                      </div>
                  <div class="form-group">

                      <div class="col-xs-4 col-sm-3 col-md-offset-2 col-md-2">
                          <button data-status="2" type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">提交审核</button>
                      </div>
                      <div class="col-xs-4 col-sm-3 col-md-2">
                          <button data-status="4" type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">保存草稿</button>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-2">
                          <button data-status="0" type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">预览</button>
                      </div>
                  </div>
                     <input hidden type="text" id="status" name="status" value="2">
             </form>
          </div>
          @include('home.public.card')


      </div>

      <!--我的投稿 已发表结束-->

@endsection

@section('script')

    {{--富文本--}}
    <script src="{{asset('/laravel-ueditor/ueditor.config.js') }}"></script>
    <script src="{{asset('/laravel-ueditor/ueditor.all.min.js')}}"></script>

    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>


    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/sitelogo.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            // 异步写入
            var guid = $("#write").val();
            if (guid) {

                $.ajax({
                    type: 'get',
                    url: '/send/get_article_info',
                    data: {
                        'guid': guid,
                    },
                    success:function(data){
                        console.log(data);
                        switch (data.StatusCode){
                            case '400':
                                alert('警告' + data.ResultData);
                                break;
                            case '200':
                                    $("input[name= 'title']").val(data.ResultData.title);
                                    $("textarea[name= 'brief']").val(data.ResultData.brief);
                                    $("input[name= 'source']").val(data.ResultData.source);
                                    $("#contribution-picture").attr('src', data.ResultData.banner);
                                    ue.setContent(data.ResultData.describe);
                                break;
                        }
                    },
                    error:function (data) {
                        alert(data);
                    }
                });
            }

        })
        $('button[type="submit"]').on('click', function () {
            $('#status').val($(this).data('status'));
        });
        // 验证码点击更换
        var captcha = document.getElementById('captcha');
        captcha.onclick = function(){
            var url = '/code/captcha/';
            url = url + $(this).data('sesid') + Math.ceil(Math.random()*100);
            this.src = url;
        };
        {{--全局变量的设置--}}

        //富文本配置
        var toolbra     = {
            toolbars : [
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
                    'simpleupload', //单图上传
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
            initialFrameWidth : '100%',
            initialFrameHeight : '50%',
        };
        var ue          = UE.getEditor('form-content', toolbra);


        //全局变量参数的设置

        //验证规则
        var rules       = {
            title: {
                required: true,
                maxlength: 50
            },
            brief: {
                required: true
            },
            describe: {
                required: true
            },
            source: {
                required: true,
                maxlength: 80
            },
            verif_code: {
                required: true,
                maxlength: 10
            },

        };
        //提示信息
        var messages    = {

            title: {
                required: '请输入标题',
                maxlength: '标题最多50个字符'
            },
            brief: {
                required: '请输入简介',
            },
            describe: {
                required: '请输入投稿正文'
            },
            source: {
                required: '来源不能为空',
                maxlength: '来源最大长度为80个字符',
            },
            verif_code: {
                required: '验证码能为空',
                maxlength: '验证码最大长度为10'
            },
        };
        !(function ($) {
            "use strict";//使用严格标准
            // 获取表单元素
            var FormValidator = function(){
                this.$signUpForm = $("#contribute-form");
            };
            // 初始化
            FormValidator.prototype.init = function() {
                // ajax 异步
                $.validator.setDefaults({
                    // 提交触发事件

                    submitHandler: function() {
                        $.ajaxSetup({
                            //将laravel的csrftoken加入请求头，所以页面中应该有meta标签，详细写法在上面的form表单部分
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        //与正常form不同，通过下面这样来获取需要验证的字段
                        var data = new FormData();

                        data.append( "title"     , $("input[name= 'title']").val());
                        data.append( "brief"       , $("textarea[name= 'brief']").val());
                        data.append( "describe"     ,$("textarea[name= 'describe']").val());
                        data.append( "source"     , $("input[name= 'source']").val());
                        data.append( "verif_code"     , $("input[name= 'verif_code']").val());
                        //开始正常的ajax
                        var status = $('#status').val();
                        var url = '/send';
                        var type = 'post';
                        if (status == 0) {
                            type = 'get';
                            url = '/send/1';
                        }
                        // 异步写入
                        $.ajax({
                            type: type,
                            url: url,
                            data: {
                                'title': $("input[name= 'title']").val(),
                                'write': $("#write").val(),
                                'brief': $("textarea[name= 'brief']").val(),
                                'describe': $("textarea[name= 'describe']").val(),
                                'source': $("input[name= 'source']").val(),
                                'verif_code': $("input[name= 'verif_code']").val(),
                                'banner': $("#contribution-picture").attr('src'),
                                'status': status,
                            },
                            success:function(data){
                                switch (data.StatusCode){
                                    case '400':
                                        alert('警告' + data.ResultData);
                                        break;
                                    case '200':
                                        alert('插入成功');
                                        break;
                                }
                            }
                        });
                    }
                });
                // 验证数据规则和提示
                this.$signUpForm.validate({
                    // 验证规则
                    rules: rules,
                    // 提示信息
                    messages: messages
                });
            };
            $.FormValidator = new FormValidator;
            $.FormValidator.Constructor = FormValidator;
        })(window.jQuery),
            function($){
                "use strict";
                $.FormValidator.init();
            }(window.jQuery);
    </script>
@endsection
