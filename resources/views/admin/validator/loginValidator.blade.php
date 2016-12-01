<!-- 验证机制 Start -->
<script src="{{asset('admin/js/jquery.validate.min.js')}}"></script>
<script>
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
            this.$signOnForm = $("#signOnForm");
        };
        // 初始化
        FormValidator.prototype.init = function() {
            this.$signOnForm.validate({
                // 验证规则
                rules: {
                    email: {
                        required: true,
                        email : true
                    },
                    password: {
                        required: true,
                        minlength:6
                    },
                    captcha: {
                        required: true,
                        minlength: 4,
                        maxlength: 4
                    }
                },
                // 提示信息
                messages: {
                    email: {
                        required: "请输入邮箱！",
                        email: "Email 格式不对！"
                    },
                    password: {
                        required: "请输入密码",
                        minlength: "密码长度不能小于 6 个字母"
                    },
                    captcha: {
                        required: "请输入验证码",
                        minlength: "请填写4位验证码",
                        maxlength: "请填写4位验证码"
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
</script>
<!-- 验证机制 End -->