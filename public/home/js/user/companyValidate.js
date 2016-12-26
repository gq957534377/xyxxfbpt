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
        this.$companyForm = $("#companyForm");
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
                data.append( "company"        , $("input[name= 'company']").val());
                data.append( "abbreviation"          , $("input[name= 'abbreviation']").val());
                data.append( "address"          , $("input[name= 'address']").val());
                data.append( "founder_name"  , $("input[name= 'founder_name']").val());
                data.append( "url"     , $("input[name= 'url']").val());
                data.append( "field"     , $("select[name= 'field']").val());
                data.append( "organize_card"     , $("input[name= 'organize_card']").val());
                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "POST",
                    url: '/user',
                    beforeSend:function(){
                        $(".loading").css({'width':'80px','height':'80px'}).show();
                    },
                    data: {
                        "guid"      : $("#topAvatar").data('id'),
                        "company"      : $("input[name= 'company']").val(),
                        'abbreviation'  : $("input[name= 'abbreviation']").val(),
                        'address': $("input[name= 'address']").val(),
                        'founder_name': $("input[name= 'founder_name']").val(),
                        'url': $("input[name= 'url']").val(),
                        'field': $("select[name= 'field']").val(),
                        'organize_card': $("input[name= 'organize_card']").val(),
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
        this.$companyForm.validate({
            // 验证规则
            rules: {
                company: {
                    required: true,
                },
                abbreviation: {
                    required: true,
                },
                address: {
                    required: true,
                },
                founder_name: {
                    required: true,
                }
                ,
                url: {
                    required: true,
                },
                field: {
                    required: true,
                },
                organize_card: {
                    required: true,
                }
            },
            // 提示信息
            messages: {
                company: {
                    required: "请输入公司名称",
                },
                abbreviation: {
                    required: "请输入公司简称",
                },
                address: {
                    required: "请选择公司所在地",
                },
                founder_name: {
                    required: "请输入公司创始人姓名",
                }
                ,
                url: {
                    required: "请输入公司网址",
                },
                field: {
                    required: "请选择行业领域",
                },
                organize_card: {
                    required: "请上传组织机构代码证",
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
