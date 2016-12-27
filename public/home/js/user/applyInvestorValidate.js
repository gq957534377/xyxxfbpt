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
                data.append( "investor_work_year"      , $('input[name = "investor_work_year"]').val());
                data.append( "investor_scale"      , $('input[name = "investor_scale"]').val());
                data.append( "investor_company"      , $('input[name = "investor_company"]').val());
                data.append( "investor_company_address"      , $('input[name = "investor_company_address"]').val());
                data.append( "investor_field"       , $("select[name = 'investor_field']").val());
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
                        'work_year': $('input[name = "investor_work_year"]').val(),
                        'scale': $('input[name = "investor_scale"]').val(),
                        'company': $('input[name = "investor_company"]').val(),
                        'company_address': $('input[name = "investor_company_address"]').val(),
                        'field':  $("select[name = 'investor_field']").val(),
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
                investor_work_year: {
                    required: true,
                    digits:true,
                    maxlength : 2,
                },
                investor_scale: {
                    required: true,
                    digits:true
                },
                investor_company: {
                    required: true,
                },
                investor_company_address: {
                    required: true,
                },
                investor_field: {
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
                investor_work_year: {
                    required: "请输入从业年份",
                    digits: '必须输入整数。',
                    maxlength: "请输入两位以内数字"
                },
                investor_scale: {
                    required: "请输入投资规模",
                    digits: '必须输入整数。',
                },
                investor_company: {
                    required: "请输入所在公司名称",
                },
                investor_company_address: {
                    required: "请输入公司所在地",
                },
                investor_field: {
                    required: "请选择创业领域"
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

