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
                    data.append( "password"       , $("input[name= 'password']").val());
                    data.append( "homeCaptcha"       , $("input[name= 'homeCaptcha']").val());
                    data.append( "tel"       , $("input[name= 'tel']").val());
                    //开始正常的ajax
                    // 异步登录
                    $.ajax({
                        type: "POST",
                        url: '/login',
                        data: {
                            'email': $("input[name= 'email']").val(),
                            'password': $("input[name= 'password']").val(),
                            'captcha': $("input[name= 'captcha']").val(),
                            'tel': $("input[name= 'tel']").val(),
                        },
                        success:function(data){
                            switch (data.StatusCode){
                                case '400':
                                    // promptBoxHandle('警告',data.ResultData);
<<<<<<< HEAD
                                    alert('警告',data.ResultData);
=======
                                    alert('警告' + data.ResultData);
>>>>>>> 706b881ac01c8251762e13e1e0a6b581a9308496
                                    break;
                                case '200':
                                    window.location = '/';
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

    // 验证码点击更换
    var captcha = document.getElementById('captcha');
    captcha.onclick = function(){
        $url = "{{url('/code/captcha')}}";
        $url = $url + "/" + Math.random();
        this.src = $url;
    }

</script>
<!-- 验证机制 End -->