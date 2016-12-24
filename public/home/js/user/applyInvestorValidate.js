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
        // 身份证号码验证
        // $.validator.addMethod("isIdCardNo", function(value, element) {
        //     return this.optional(element) || idCardNoUtil.checkIdCardNo(value);
        // }, "请正确输入您的身份证号码");
        // 验证图片的大小
        $.validator.addMethod("checkPicSize", function(value,element) {
            var fileSize=element.files[0].size;
            var maxSize = 5*1024*1024;
            if(fileSize > maxSize){
                return false;
            }else{
                return true;
            }
        }, "请上传大小在5M以下的图片");
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
                data.append( "investor_realname"      , $("input[name= 'investor_realname']").val());
                data.append( "investor_subject"      , $("#investor_subject").val());
                data.append( "investor_tel"      , $("input[name= 'investor_tel']").val());
                // data.append( "investor_card"       , $("input[name= 'investor_card']").val());
                data.append( "investor_field"       , $("#investor_field").val());
                data.append( "investor_realname"       , $("#investor_stage").val());
                data.append( "investor_card_pic"       , $("input[name= 'investor_card_pic']").val());
                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "POST",
                    url: '/identity',
                    data: {
                        "guid": $("#topAvatar").data('id'),
                        "role": $("input[name= 'investor_role']").val(),
                        'realname': $("input[name= 'investor_realname']").val(),
                        'subject': $("#investor_subject").val(),
                        'tel': $("input[name= 'investor_tel']").val(),
                        // 'card_number': $("input[name= 'investor_card']").val(),
                        'field': $("#investor_field").val(),
                        'stage': $("#investor_stage").val(),
                        'card_pic_a': $("input[name= 'investor_card_pic']").val()
                    },
                    beforeSend:function(){
                        $(".loading").css({'width':'80px','height':'80px'}).show();
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                // promptBoxHandle('警告',data.ResultData);
                                $(".loading").hide();
                                alert('警告,'+data.ResultData);
                                break;
                            case '200':
                                loadAjax();
                                $(".loading").hide();
                                alert('提示,'+data.ResultData);
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
                investor_realname: {
                    required: true,
                },
                investor_subject: {
                    required: true,
                }
                ,
                investor_tel: {
                    required: true,
                    isMobile: true
                },
                // investor_card: {
                //     required: true,
                //     isIdCardNo: true
                // },
                investor_field: {
                    required: true,
                },
                investor_stage: {
                    required: true,
                },
                investor_card_pic: {
                    required: true
                }
            },
            // 提示信息
            messages: {
                investor_realname: {
                    required: "请填写您的真实姓名！",
                },
                investor_subject: {
                    required: "请选择创业主体！",
                },
                investor_tel: {
                    required: "请输入手机号！",
                    isMobile: "手机号格式不对"
                },
                // investor_card: {
                //     required: "请输入身份证号！",
                //     isIdCardNo: "请正确输入您的身份证号码"
                // },
                investor_field: {
                    required: "请选择创业领域"
                },
                investor_stage: {
                    required: "请选择创业阶段",
                },
                investor_card_pic: {
                    required: "请上传身份证件照"
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

