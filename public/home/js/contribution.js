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

//富文本配置
var toolbra     = {
    zIndex : 1,
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
            // 'simpleupload', //单图上传
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
                                window.open('/send/1?title=' + title + '&brief=' + brief + '&describe=' + describe + '&source=' + source + '&verif_code=' + verif_code + '&src=' + src);
                                break;
                            case '200.1':
                                newWin("/send/" + data.ResultData, 'liulan1');
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


function newWin(url, id) {
    var a = document.createElement('a');
    a.setAttribute('href', url);
    a.setAttribute('target', '_blank');
    a.setAttribute('id', id);
    // 防止反复添加
    if(!document.getElementById(id)) {
        document.body.appendChild(a);
    }
    a.click();
}
