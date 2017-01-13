/**
 * Theme: 登录验证
 * Author:
 * Form Validator
 */
// 文档地址 http://www.runoob.com/jquery/jquery-plugin-validate.html
!(function ($) {
    "use strict";//使用严格标准
    if (sessionStorage.getItem('remember_user') != null && sessionStorage.getItem('remember_pwd') != null) {
        $("input[name= 'tel']").val(sessionStorage.getItem('remember_user'));
        $("input[name= 'password']").val(sessionStorage.getItem('remember_pwd'));
    } else {
        $("input[name= 'tel']").val('');
        $("input[name= 'password']").val('');
        $('.input_checkbox').children('i').toggleClass('fa-check');
    }
    // 获取表单元素
    var FormValidator = function(){
        this.$signOnForm = $("#signOnForm");
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
                data.append( "tel"      , $("input[name= 'tel']").val());
                data.append( "password"       , $("input[name= 'password']").val());
                data.append( "code"       , $("input[name= 'code']").val());
                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "POST",
                    url: '/login',
                    data: {
                        'tel': $("input[name= 'tel']").val(),
                        'password': $("input[name= 'password']").val(),
                        "code": $("input[name= 'code']").val()
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                // promptBoxHandle('警告',data.ResultData);
                                $('#error-info').html('警告,'+data.ResultData).fadeIn(1000);
                                break;
                            case '411':
                                // promptBoxHandle('警告',data.ResultData);
                                $('#error-info').html(data.ResultData).fadeIn(1000);
                                $('#login-code').show();
                                break;
                            case '200':
                                if ($('.input_checkbox').children('i').is('.fa-check')) {
                                    sessionStorage.setItem("remember_user", $("input[name= 'tel']").val());
                                    sessionStorage.setItem("remember_pwd", $("input[name= 'password']").val());
                                } else {
                                    sessionStorage.clear();
                                }
                                self.location = document.referrer;
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
                tel: {
                    required: true,
                    isMobile: true
                },
                password: {
                    required: true,
                    minlength:6
                },
                code: {
                    minlength: 4,
                    maxlength: 4
                }
            },
            // 提示信息
            messages: {
                tel: {
                    required: "请输入手机号！",
                    isMobile: "手机号格式不对"
                },
                password: {
                    required: "请输入密码",
                    minlength: "密码长度不对"
                },
                code: {
                    minlength: '验证码最小长度为四',
                    maxlength: '验证码最大程度为四'
                }
            },
            errorPlacement: function(error, element) {
                // Append error within linked label
                if (error[0].textContent != '') {
                    $('#error-info').html(error[0].textContent).fadeIn(1000);
                }


                //$(element).focus();
            },
            success: function () {
                $('#error-info').hide();
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

// 验证手机号是否存在
// $('input[name="tel"]').on('change', function () {

    // var num = $(this).val().length;
    // if (num == 11) {
    //     $.ajax({
    //         type: "get",
    //         url: '/register/checkphoto',
    //         data: {
    //             'tel': $("input[name= 'tel']").val(),
    //         },
    //         success:function(data){
    //             console.log(data);
    //             switch (data.StatusCode){
    //                 case '200':
    //                     $('#error-info').html(data.ResultData).fadeIn(1000);
    //                     $('input[name="tel"]').focus();
    //                     break;
    //
    //
    //             }
    //         }
    //     });
    // }
// });

$('.input_checkbox').on('click', function () {
    var obj = $(this).children('i');
    obj.toggleClass('fa-check');

});

// 验证码点击更换
var captcha = document.getElementById('captcha');
captcha.onclick = function(){
    updateCaptcha($(this));
};
function updateCaptcha(me) {
    var url = '/code/captcha/';
    url = url + me.data('sesid') + Math.ceil(Math.random()*100);
    me.attr('src', url);
}
