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
            this.$userform = $("#userform");
        };
        // 初始化
        FormValidator.prototype.init = function() {
            this.$userform.validate({
                // 验证规则
                rules: {
                    nickname: {
                        required: true,
                        minlength : 2
                    },
                    email: {
                        required: true,
                        email:true
                    },
                    realname: {
                        required: true,
                        minlength: 2
                    },
                    hometown: {
                        required: true,
                        minlength:2
                    },
                    birthday: {
                        required:true,
                        minlength:4
                    },
                    sex: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        minlength: 11
                    }
                },
                // 提示信息
                messages: {
                    nickname: {
                        required: "请输入昵称！",
                        minlength: "最少两个汉字或字母哦！"
                    },
                    email: {
                        required: "请输入邮箱！",
                        email:"输入正确的格式"
                    },
                    realname: {
                        required: "请填写你的真实姓名！",
                        minlength: "最少两个汉字哦"
                    },
                    hometown: {
                        required: "请输入你的籍贯",
                        minlength:"最少两个汉字哦"
                    },
                    birthday: {
                        required:"请输入你的出生年月",
                        minlength:"最少4个字符"
                    },
                    sex: {
                        required: "请输入你的性别",
                    },
                    phone: {
                        required: "请输入您的手机号",
                        minlength: "最少11位哦"
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