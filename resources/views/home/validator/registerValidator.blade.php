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
                    data.append( "email"      , $("input[name= 'email']").val());
                    data.append( "nickname"     , $("input[name= 'nickname']").val());
                    data.append( "password"       , $("input[name= 'password']").val());
                    data.append( "confirm_password"     ,$("input[name= 'confirm_password']").val());
                    data.append( "phone"     , $("input[name= 'phone']").val());
                    data.append( "code"     , $("input[name= 'code']").val());
                    //开始正常的ajax
                    // 异步登录
                        $.ajax({
                            type: "POST",
                            url: '/register',
                            data: {
                                'email': $("input[name= 'email']").val(),
                                'nickname': $("input[name= 'nickname']").val(),
                                'password': $("input[name= 'password']").val(),
                                'confirm_password': $("input[name= 'confirm_password']").val(),
                                'phone': $("input[name= 'phone']").val(),
                                'code': $("input[name= 'code']").val(),
                            },
                            success:function(data){
                                switch (data.StatusCode){
                                    case '400':
                                        alert(data.ResultData);
                                        break;
                                    case '200':
                                        alert(data.ResultData);
                                        window.location = '/login';
                                        break;
                                }
                            }
                        });
                }
            });
            // 验证数据规则和提示
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
                        minlength: 6,
                        equalTo: "#password"
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
                    nickname: {
                        required: "请输入昵称",
                        minlength: "昵称长度不能小于2个字符",
                    },
                    password: {
                        required: "请输入密码",
                        minlength: "密码长度不能小于 6 个字母"
                    },
                    confirm_password: {
                        required: "请输入确认密码",
                        minlength: "密码长度不能小于 6 个字母",
                        equalTo: "两次输入密码不一致"
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
        } else {
            if(isPhoneNo($.trim(phone))== false) {
                alert('手机号不正确');
            }
        }
    }

    // 异步发送短信
    $("#sendCode").click(function(){
        var phone =$("input[name='phone']").val();
        // 校验手机号
        formValidate(phone);
        // 传输
        var url = '/register/'+phone;
        $.ajax({
            type: "GET",
            url: url,
            success:function(data){
                switch (data.StatusCode){
                    case '400':
                        alert(data.ResultData);
                        break;
                    case '200':
                        alert(data.ResultData);
                        break;
                }
            }
        });

    });

</script>
<!-- 验证机制 End -->