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
                    nikename: {
                        required: true,
                        minlength: 2,
                    },
                    password: {
                        required: true,
                        minlength:6
                    },
                    confirm_password: {
                        required: true,
                        minlength: 6
                    },
                    phone: {
                        required: true,
                        minlength:11,
                        maxlength: 11
                    },
                    code: {
                        required: true
                    }
                },
                // 提示信息
                messages: {
                    email: {
                        required: "请输入邮箱！",
                        email: "Email 格式不对！"
                    },
                    nikename: {
                        required: "请输入昵称",
                        minlength: "昵称长度不能小于2个字符",
                    },
                    password: {
                        required: "请输入密码",
                        minlength: "密码长度不能小于 6 个字母"
                    },
                    confirm_password: {
                        required: "请输入确认密码",
                        minlength: "密码长度不能小于 6 个字母"
                    },
                    phone: {
                        required: "请输入手机号",
                        minlength: "密码长度不能小于 11 位",
                        maxlength: "密码长度不能大于 11 位"
                    },
                    code: {
                        required: "请输入短信验证码"
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

    // 异步登录
    $('#register').click(function(){
        var email = $("input[name= 'email']").val();
        var nickname = $("input[name= 'nickname']").val();
        var password = $("input[name= 'password']").val();
        var confirm_password = $("input[name= 'confirm_password']").val();
        var phone = $("input[name= 'phone']").val();
        var code = $("input[name= 'code']").val();
        var _token = $("input[name= '_token']").val();
        if(password != confirm_password){
            alert('两次密码输入的不一致！');
        }
        var data = {
            'email': email,
            'nickname': nickname,
            'password': password,
            'confirm_password': confirm_password,
            'phone': phone,
            'code': code,
            '_token' : _token
        };
        var url = '/register';
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success:function(data){
              obj=eval("("+data+")");
                alert(obj.msg);
            }
        });
    });

    // 手机号验证规则
    function isPhoneNo(phone) {
        var pattern = /^1[34578]\d{9}$/;
        return pattern.test(phone);
    }

    //验证函数
    function formValidate(phone) {
        // 返回信息
        var str = '';

        // 判断手机号
        if($.trim(phone).length == 0){
            alert('请输入手机号');
            phone.focus();
        } else {
            if(isPhoneNo($.trim(phone))== false) {
                alert('手机号不正确');
                phone.fcous();
            }
        }
    }

    // 异步发送短信
    $("#sendCode").click(function(){
        var phone =$("input[name='phone']").val();
        var _token = $("input[name= '_token']").val();
        // 校验手机号
        formValidate(phone);
        // 传输
        var url = '/sms';
        var data = {
            'phone':phone ,
            '_token': _token
        };
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success:function(data){
                obj=eval("("+data+")");
                alert(obj.msg);
            }
        });

    });

</script>
<!-- 验证机制 End -->