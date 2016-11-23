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
            this.$investorForm = $("#investorForm");
        };
        // 初始化
        FormValidator.prototype.init = function() {
            // ajax 异步
            $.validator.setDefaults({
                // 提交触发事件
                submitHandler: function() {
                    //将laravel的csrftoken加入请求头，所以页面中应该有meta标签，详细写法在上面的form表单部分
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    //与正常form不同，通过下面这样来获取需要验证的字段
                    var data = new FormData();
                    data.append( "realname"      , $("input[name= 'realname']").val());
                    data.append( "sex"       , $("input[name= 'sex']").val());
                    data.append( "birthday"       , $("input[name= 'birthday']").val());
                    data.append( "hometown"       , $("input[name= 'hometown']").val());
                    data.append( "tel"       , $("input[name= 'tel']").val());
                    data.append( "card_number"       , $("input[name= 'card_number']").val());
//                    data.append( "investor_carda"       , $("input[name= 'investor_carda']").val());
//                    data.append( "investor_cardb"       , $("input[name= 'investor_cardb']").val());
                    data.append( "orgname"       , $("input[name= 'orgname']").val());
                    data.append( "orglocation"       , $("input[name= 'orglocation']").val());
                    data.append( "fundsize"       , $("input[name= 'fundsize']").val());
                    data.append( "field"       , $("input[name= 'field']").val());
                    data.append( "orgdesc"       , $("textarea[name= 'orgdesc']").val());
                    data.append( "workyear"       , $("input[name= 'workyear']").val());
                    data.append( "scale"       , $("input[name= 'scale']").val());
                }
            });
            // 验证规则和提示信息
            this.$investorForm.validate({
                // 验证规则
                rules: {
                    realname: {
                        required: true,
                        minlength : 2
                    },
                    sex: {
                        required: true,
                    },
                    birthday: {
                        required: true,
                    },
                    hometown: {
                        required: true,
                    },
                    tel: {
                        required: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    number: {
                        required: true,
                        minlength: 16,
                        maxlength: 18
                    },
//                    investor_carda: {
//                        required: true,
//                    },
//                    investor_cardb: {
//                        required: true,
//                    },
                    orgname: {
                        required: true,
                    },
                    orglocation: {
                        required: true,
                    },
                    fundsize: {
                        required: true,
                    },
                    field: {
                        required: true,
                    },
                    orgdesc: {
                        required: true,
                    },
                    workyear: {
                        required: true,
                        maxlength:2
                    },
                    scale: {
                        required: true,
                    }

                },
                // 提示信息
                messages: {
                    realname: {
                        required: "请输入真实姓名！",
                        minlength : "最少两位"
                    },
                    sex: {
                        required: "请选择性别",
                    },
                    birthday: {
                        required: "请填写你的出生年月",
                    },
                    hometown: {
                        required: "请填写您的籍贯",
                    },
                    tel: {
                        required: "请输入你的手机号",
                        minlength: "长度为11位",
                        maxlength: "长度为11位",
                    },
                    card_number: {
                        required: "请填写真实的身份证号码",
                        minlength: "长度为16-18位",
                        maxlength: "超出长度"
                    },
//                    investor_carda: {
//                        required: "请上传您身份证正面",
//                    },
//                    investor_cardb: {
//                        required:"请上传您身份证反面",
//                    },
                    orgname: {
                        required: "请输入机构名称",
                    },
                    orglocation: {
                        required: "请输入机构所在地",
                    },
                    fundsize: {
                        required: "请输入资金规模",
                    },
                    field: {
                        required: "请输入行业领域",
                    },
                    orgdesc: {
                        required: "行业描述",
                    },
                    workyear: {
                        required: "请输入您的从业年限",
                        maxlength:"2位以内"
                    },
                    scale: {
                        required: "投资规模"
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