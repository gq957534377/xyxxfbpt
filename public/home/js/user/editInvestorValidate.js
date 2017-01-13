/**
 * Theme: Velonic Admin Template
 * Author: Coderthemes
 * Form Validator
 */
// 文档地址 http://www.runoob.com/jquery/jquery-plugin-validate.html
!(function ($) {
    "use strict";//使用严格标准
    // 获取表单元素
    var FormValidator = function(){
        this.$applyInvestorForm = $("#applyInvestorForm");
    };

    // 初始化
    FormValidator.prototype.init = function() {
        // 自定义手机验证规则
        $.validator.addMethod("isMobile", function(value, element) {
            var length = value.length;
            var mobile = /^1[34578]\d{9}$/;
            return this.optional(element) || (length == 11 && mobile.test(value));
        }, "请正确填写您的手机号码");

        $.validator.addMethod("checkPicSize", function(value,element) {
            var fileSize=element.files[0].size;
            var maxSize = 2*1024*1024;
            if(fileSize > maxSize){
                return false;
            }else{
                return true;
            }
        }, "请上传大小在2M以下的图片");

        $.validator.addMethod("chinese", function(value, element) {
            var chinese = /^[\u4e00-\u9fa5]+$/;
            return this.optional(element) || (chinese.test(value));
        }, "只能输入中文");

        // 字符验证
        $.validator.addMethod("stringCheck", function(value, element) {
            return this.optional(element) || /^[u0391-uFFE5w]+$/.test(value);
        }, "只能包括中文字、英文字母、数字和下划线");

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
                data.append( "investor_role"      , $('input[name = "investor_role"]').val());
                data.append( "investor_scale"      , $('input[name = "investor_scale"]').val());
                data.append( "investor_field"       , $("input[name = 'investor_field']").val());
                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "PUT",
                    url: '/identity/'+ $('input[name = "investor_id"]').val(),
                    data: {
                        'role' : $('input[name = "investor_role"]').val(),
                        'scale': $('input[name = "investor_scale"]').val(),
                        'field': $("input[name = 'investor_field']").val(),
                    },
                    beforeSend:function(){
                        $(".loading").css({'width':'80px','height':'80px'}).show();
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                // promptBoxHandle('警告',data.ResultData);
                                $(".loading").hide();
                                alert('消息提示,'+data.ResultData);
                                break;
                            case '200':
                                $(".loading").hide();
                                alert('消息提示,'+data.ResultData);
                                window.location.href = '/user/'+ $("#topAvatar").data('id');
                                break;
                        }
                    }
                });
            }
        });
        // 验证规则和提示信息
        this.$applyInvestorForm.validate({
            // 验证规则
            rules: {
                investor_scale: {
                    required: true,
                    digits:true
                },
                investor_field: {
                    required: true,
                }
            },
            // 提示信息
            messages: {
                investor_scale: {
                    required: "请输入投资规模",
                    digits: '必须输入整数。',
                },
                investor_field: {
                    required: "请选择创业领域"
                },
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

