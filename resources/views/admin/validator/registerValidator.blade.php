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
            this.$signUpForm = $("#signUpForm");
        };
        // 初始化
        FormValidator.prototype.init = function() {
            this.$signUpForm.validate({
                // 验证规则
                rules: {
                    email: {
                        required: true,
                        email : true
                    },
                    username:{
                        required: true,
                        minlength: 2,
                        maxlength: 10
                    },
                    password: {
                        required: true,
                        minlength:6
                    },
                    confirm_password: {
                        required: true,
                        minlength: 6
                    }
                },
                // 提示信息
                messages: {
                    email: {
                        required: "请输入邮箱！",
                        email: "Email 格式不对！"
                    },
                    username:{
                        required: "请输入昵称！",
                        minlength: "输入长度最小是 2 的字符串（汉字算一个字符）。",
                        maxlength: "输入长度最多是 10 的字符串（汉字算一个字符）。"
                    },
                    password: {
                        required: "请输入密码",
                        minlength: "密码长度不能小于 6 个字母"
                    },
                    confirm_password: {
                        required: '请输入确认密码',
                        minlength: "密码长度不能小于 6 个字母"
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

    $("input[name = 'confirm_password']").blur(function(){
        var pass = $("input[name = 'password']").val();
        var confirm_password = $(this).val();
        var error = $("#confirm_password-error");
        if(pass != confirm_password) {
            alert('两次密码不一致！');
        }
    });

</script>
<!-- 验证机制 End -->