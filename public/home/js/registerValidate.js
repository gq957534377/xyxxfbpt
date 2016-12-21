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
        // 自定义手机验证规则
        $.validator.addMethod("isMobile", function(value, element) {
            var length = value.length;
            var mobile = /^1[34578]\d{9}$/;
            return this.optional(element) || (length == 11 && mobile.test(value));
        }, "手机号码不对");

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
                data.append( "tel"     , $("input[name= 'tel']").val());
                data.append( "password"       , $("input[name= 'password']").val());
                data.append( "confirm_password"     ,$("input[name= 'confirm_password']").val());
                data.append( "code"     , $("input[name= 'code']").val());
                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "POST",
                    url: '/register',
                    data: {
                        'tel': $("input[name= 'tel']").val(),
                        'password': $("input[name= 'password']").val(),
                        'confirm_password': $("input[name= 'confirm_password']").val(),
                        'code': $("input[name= 'code']").val(),
                        'stage': $("input[name= 'stage']").val(),
                        'captcha': $("input[name= 'captcha']").val(),
                        'sms': $("input[name= 'sms']").val(),
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                alert('警告' + data.ResultData);
                                break;
                            case '200':

                                if (data.ResultData == '1') {
                                    var str = '<div class="input_block_0">';
                                    str += '<input name="stage" type="text" hidden value="2">';
                                    str += '<span>我们将向您的手机<span class="phoneNum">';
                                    str += data.Tel;
                                    str+='</span>发送一条验证短息';
                                    str += '</span>';
                                    str += '</div>';
                                    str += '<div class="message_block">';
                                    str += '<div>';
                                    str += '<input name="sms" type="text" placeholder="请输入短信验证码">';
                                    str += '</div>';
                                    str += '<button type="button" id="sendCode" class="btn btn-defult">发送验证码</button>';
                                    str += '</div>';
                                    str += '<div class="btn_block">';
                                    str += '<button type="submit" class="btn btn-warning btn-block btn-lg">下一步</button>';
                                    str += '</div>';
                                } else if (data.ResultData == '2') {
                                    var str = '<div class="input_block_0">';
                                    str += '<input name="stage" type="text" hidden value="3">';
                                    str += '<span>';
                                    str += '请设置您的账号<span class="phoneNum">';
                                    str += data.Tel;
                                    str +='</span>的登陆密码';
                                    str += '</span>';
                                    str += '</div>';
                                    str += '<ul class="input_block_1">';
                                    str += '<li class="pwd">';
                                    str += '<input name="password" id="password" type="password" placeholder="请输入密码" />';
                                    str += '</li>';
                                    str += '<li class="pwd">';
                                    str += '<input name="confirm_password" type="password"  placeholder="请确认密码" />';
                                    str += '</li>';
                                    str += '</ul>';
                                    str += '<div class="input_block_2">';
                                    str += '<span>';
                                    str += '密码长度8-16位，其中数字，字母和符号至少包含两种';
                                    str += '</span>';
                                    str += '</div>';
                                    str += '<div class="btn_block">';
                                    str += '<button type="submit" class="btn btn-warning btn-block btn-lg">下一步</button>';
                                    str += '</div>';
                                } else {
                                    alert('提示\n' + data.ResultData);
                                    setTimeout('delayer()', 3000);
                                }

                                jQuery(document).ready(function(){
                                    $('#signUpForm').html(str);
                                    //setTimeout('delayer()', 3000);
                                    //这里实现延迟3秒跳转
                                });
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
                password: {
                    required: true,
                    minlength:6
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                tel: {
                    required: true,
                    minlength:11,
                    maxlength: 11,
                    isMobile: true

                }
            },
            // 提示信息
            messages: {
                password: {
                    required: "请输入密码",
                    minlength: "密码长度小于6"
                },
                confirm_password: {
                    required: "请输入确认密码",
                    minlength: "密码长度小于6",
                    equalTo: "输入密码不一致"
                },
                tel: {
                    required: "请输入手机号",
                    minlength: "密码长度小于11位",
                    maxlength: "密码长度大于11位",
                    isMobile: "手机号码不对"
                },
                code: {
                    required: "输入短信验证码"
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
        alert('警告','请输入手机号');
        exit();
    } else {
        if(isPhoneNo($.trim(phone))== false) {
            alert('警告' + '手机号不正确');

            exit();
        }
    }
}

// 异步发送短信
$("#signUpForm").on('click','#sendCode',function(){

    var phone =$(".phoneNum").html();
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
                    // promptBoxHandle('警告',data.ResultData);
                    alert('警告,'+ data.ResultData);
                    setTime($("#sendCode"));
                    break;

                case '200':
                    alert('提示' + data.ResultData);
                    setTime($("#sendCode"));
                    break;
            }
        }
    });

});
// 短信验证发送后计时器
var countdown=60;
function setTime(obj) {
    if (countdown == 0) {
        obj.removeAttr('disabled');
        obj.html('获取验证码');
        countdown = 60;
        return;
    } else {
        obj.attr('disabled','true');
        obj.html('等待('+ countdown + 's)');
        countdown --;
    }
    setTimeout(function() {
        setTime(obj)
    },1000);
}

// 跳转路径
function delayer(){
    window.location = "/login";
}

// 验证码点击更换
var captcha = document.getElementById('captcha');
captcha.onclick = function(){
        var url = '/code/captcha/';
        url = url + $(this).data('sesid') + Math.ceil(Math.random()*100);
        this.src = url;
    }


