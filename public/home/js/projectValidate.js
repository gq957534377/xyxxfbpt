/**
 * Created by Administrator on 2016/12/21.
 */
/**
 * Theme: 登录验证
 * Author:
 * Form Validator
 */
// 文档地址 http://www.runoob.com/jquery/jquery-plugin-validate.html
!(function ($) {
    "use strict";//使用严格标准
    // 获取表单元素
    var FormValidator = function(){
        this.$signOnForm = $("#projectForm");
    };

    // 初始化
    FormValidator.prototype.init = function() {
        // 自定义手机验证规则
        $.validator.addMethod("isMobile", function(value, element) {
            var length = value.length;
            var mobile = /^1[34578]\d{9}$/;
            return this.optional(element) || (length == 11 && mobile.test(value));
        }, "请正确填写您的手机号码");

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
                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "POST",
                    url: '/project',
                    data: {
                        'title': $("input[name= 'title']").val(),
                        'brief_content': $("textarea[name= 'brief_content']").val(),
                        'industry': $("select[name= 'industry']").val(),
                        'financing_stage':$("select[name= 'financing_stage']").val(),
                        'content':$("textarea[name= 'content']").val(),
                        'project_experience':$("input[name= 'project_experience']").val(),
                        'logo_img':$("input[name= 'logo_img']").val(),
                        'banner_img':$("input[name= 'banner_img']").val(),
                        'team_member':$("input[name= 'team_member']").val(),
                        "privacy":$("input[name= 'privacy']").val()
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                // promptBoxHandle('警告',data.ResultData);
                                alert('警告,'+data.ResultData);
                                break;
                            case '200':
                                window.location = '/user/myProject';
                                break;
                        }
                    }
                });
            }
        });
        // 验证规则和提示信息
        this.$signOnForm.validate({
            // 验证规则
            rules: {
                title: {
                    required: true,
                    maxlength:64
                },
                brief_content: {
                    required: true,
                    rangelength:[20,60]
                },
                industry:{
                    required: true,
                    digits:true
                },
                financing_stage:{
                    required: true,
                    digits:true
                },
                content:{
                    required: true,
                    rangelength:[120,800]
                },
                logo_img:{
                    required: true
                },
                banner_img:{
                    required: true
                },
                team_member:{
                    required: true
                },
                privacy:{
                    required: true,
                    digits:true
                }
            },
            // 提示信息
            messages: {
                title: {
                    required: "此处不可为空！",
                    maxlength:"最多只可输入64个字符！"
                },
                brief_content: {
                    required: "此处不可为空！",
                    rangelength:"应输入20~60个字符！"
                },
                industry:{
                    required: "请选一个行业！",
                    digits:'别费力气了，我早考虑到了'
                },
                financing_stage:{
                    required: "请选一个融资阶段！",
                    digits:'别费力气了，我早考虑到了'
                },
                content:{
                    required: "此处不可为空！",
                    rangelength:"应输入120~800个字符！"
                },
                logo_img:{
                    required: "请为您的项目添加一个logo！"
                },
                banner_img:{
                    required: "请添加您的项目添加一个Banner图！"
                },
                team_member:{
                    required: "请点下方添加按钮添加一位核心成员"
                },
                privacy:{
                    required: '请选填一个隐私内容',
                    digits:'别费力气了，我早考虑到了'
                }
            }
        });
    };
    $.FormValidator = new FormValidator;
    $.FormValidator.Constructor = FormValidator;
})(window.jQuery),
    function($){
        "use strict";
        $.FormValidator.init();
    }(window.jQuery);

