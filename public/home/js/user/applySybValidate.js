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
            if(parseFloat(amountEnd) > parseFloat(amountStart)){
                returnVal = true;
            }
            return returnVal;
        },"毕业时间必须大于入学时间");

        $.validator.addMethod("nowDate", function(value, element) {
            var returnVal = false;
            var amountStart = $("input[name= 'syb_start_school']").val();
            var amountEnd = $("input[name= 'nowDate']").val();

            if(parseFloat(amountEnd) >= parseFloat(amountStart)){

                returnVal = true;
            }
            return returnVal;
        },"你入学年份输入错误");

        $.validator.addMethod("checkPicSize", function(value,element) {
            var fileSize=element.files[0].size;
            var maxSize = 2*1024*1024;
            if(fileSize > maxSize){
                return false;
            }else{
                return true;
            }
        }, "请上传大小在2M以下的图片");

        $.validator.addMethod("chinese", function(value, element) {
            var chinese = /^[\u4e00-\u9fa5]+$/;
            return this.optional(element) || (chinese.test(value));
        }, "只能输入中文");

        // 字符验证
        $.validator.addMethod("stringCheck", function(value, element) {
            return this.optional(element) || /^[u0391-uFFE5w]+$/.test(value);
        }, "只能包括中文字、英文字母、数字和下划线");

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
                        'school_address': $("input[name= 'syb_school_address']").val(),
                        'school_name': $("input[name= 'syb_school_name']").val(),
                        'enrollment_year': $("input[name= 'syb_start_school']").val(),
                        'graduation_year': $("input[name= 'syb_finish_school']").val(),
                        'education': $("select[name= 'syb_education']").val(),
                        'major': $("input[name= 'syb_major']").val(),
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                // promptBoxHandle('警告',data.ResultData);
                                $(".loading").hide();
                                swal('警告', data.ResultData, "warning");
                                break;
                            case '200':
                                $(".loading").hide();
                                swal({
                                        title: '提示', // 标题，自定
                                        text: '申请成功，等待审核，3个工作日之内...',   // 内容，自定
                                        type: "success",    // 类型，分别为error、warning、success，以及info
                                        showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                                        confirmButtonColor: '#34c73b',  // 确认用途的按钮颜色，自定
                                    },
                                    function (isConfirm) {
                                        swal('提示', data.ResultData, "success");
                                        $(".userInfoReset").click();
                                        window.location.href = '/user/'+ $("#topAvatar").data('id');
                                    });

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
                    chinese: true,
                    minlength: 2,
                    maxlength: 16
                },
                syb_card_a: {
                    required: true,
                    checkPicSize: true,
                },
                syb_card_b: {
                    required: true,
                    checkPicSize: true,
                },
                syb_school_address: {
                    required: true,
                    chinese: true,
                }
                ,
                syb_school_name: {
                    required: true,
                    chinese: true,
                },
                syb_start_school: {
                    required: true,
                    nowDate : true,
                    digits : true,
                },
                syb_finish_school: {
                    required: true,
                    amountLimit: true,
                    digits: true,
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
                    minlength : "最少两位",
                    maxlength : "最长16位"
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
                    digits: '必须输入两位以内的整数。',
                },
                syb_finish_school: {
                    required: "请输入您的毕业时间",
                    digits: '必须输入两位以内的整数。',
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

