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
        this.$applySybForm = $("#applySybForm");
    };

    // 初始化
    FormValidator.prototype.init = function() {
        // 自定义手机验证规则
        $.validator.addMethod("isMobile", function(value, element) {
            var length = value.length;
            var mobile = /^1[34578]\d{9}$/;
            return this.optional(element) || (length == 11 && mobile.test(value));
        }, "请正确填写您的手机号码");
        $.validator.addMethod("amountLimit", function(value, element) {
            var returnVal = false;
            var amountStart = $("input[name= 'syb_start_school']").val();
            var amountEnd = $("input[name= 'syb_finish_school']").val();
            if(parseFloat(amountEnd)>parseFloat(amountStart)){
                returnVal = true;
            }
            return returnVal;
        },"毕业时间必须大于入学时间");
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
                data.append( "syb_realname"        , $("input[name= 'syb_realname']").val());
                data.append( "syb_card_a"          , $("input[name= 'syb_card_a']").val());
                data.append( "syb_card_b"          , $("input[name= 'syb_card_b']").val());
                data.append( "syb_school_address"  , $("input[name= 'syb_school_address']").val());
                data.append( "syb_school_name"     , $("input[name= 'syb_school_name']").val());
                data.append( "syb_start_school"     , $("input[name= 'syb_start_school']").val());
                data.append( "syb_finish_school"     , $("input[name= 'syb_finish_school']").val());
                data.append( "syb_education"       , $("input[name= 'syb_education']").val());
                data.append( "syb_major"       , $("input[name= 'syb_major']").val());
                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "POST",
                    url: '/identity',
                    beforeSend:function(){
                        $(".loading").css({'width':'80px','height':'80px'}).show();
                    },
                    data: {
                        "guid"      : $("#topAvatar").data('id'),
                        "role"      : $("input[name= 'role']").val(),
                        'realname'  : $("input[name= 'syb_realname']").val(),
                        'card_pic_a': $("input[name= 'syb_card_a']").val(),
                        'card_pic_b': $("input[name= 'syb_card_b']").val(),
                        'school_address': $("select[name= 'syb_school_address']").val(),
                        'school_name': $("select[name= 'syb_school_name']").val(),
                        'start_school': $("input[name= 'syb_start_school']").val(),
                        'finish_school': $("input[name= 'syb_finish_school']").val(),
                        'education': $("select[name= 'syb_education']").val(),
                        'major': $("input[name= 'syb_major']").val(),
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
        this.$applySybForm.validate({
            // 验证规则
            rules: {
                syb_realname: {
                    required: true,
                },
                syb_card_a: {
                    required: true,
                },
                syb_card_b: {
                    required: true,
                },
                syb_school_address: {
                    required: true,
                }
                ,
                syb_school_name: {
                    required: true,
                },
                syb_start_school: {
                    required: true,
                },
                syb_finish_school: {
                    required: true,
                    amountLimit: true
                },
                syb_education: {
                    required: true,
                },
                syb_major: {
                    required: true,
                },

            },
            // 提示信息
            messages: {
                syb_realname: {
                    required: "请填写您的真实姓名！",
                },
                syb_card_a: {
                    required: "请上传身份证证件照正面"
                },
                syb_card_b: {
                    required: "请上传身份证证件照反面"
                },
                syb_school_address: {
                    required: "请选择您所在院校的省份",
                },
                syb_school_name: {
                    required: "请选择您所在院校的名字",
                },
                syb_start_school: {
                    required: "请输入您的入学时间",
                },
                syb_finish_school: {
                    required: "请输入您的毕业时间",
                },
                syb_education: {
                    required: "请输入您的学历",
                },
                syb_major: {
                    required: "请输入您的专业名称",
                },


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

