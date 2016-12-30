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
                data.append( "company"        , $("input[name= 'company']").val());
                data.append( "abbreviation"          , $("input[name= 'abbreviation']").val());
                data.append( "address"          , $("input[name= 'address']").val());
                data.append( "founder_name"  , $("input[name= 'founder_name']").val());
                data.append( "url"     , $("input[name= 'url']").val());
                data.append( "field"     , $("input[name= 'field']").val());
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
                        'field': $("input[name= 'field']").val(),
                        'organize_card': $("input[name= 'organize_card']").val(),
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
                                        confirmButtonColor: '#DD6B55',  // 确认用途的按钮颜色，自定
                                    },
                                    function (isConfirm) {
                                        swal('提示', data.ResultData, "success");
                                        $(".userInfoReset").click();
                                    });
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
                    chinese: true,
                },
                abbreviation: {
                    required: true,
                    chinese: true,
                },
                address: {
                    required: true,
                },
                founder_name: {
                    required: true,
                    chinese: true,
                }
                ,
                url: {
                    required: true,
                    url:true
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
                    url: "请输入正确的URL地址"
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

