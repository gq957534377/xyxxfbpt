<!-- 更改绑定手机 Start -->
<script src="{{asset('admin/js/jquery.validate.min.js')}}"></script>
<script>
    /**
     * Theme: Velonic Admin Template
     * Author: Coderthemes
     * Form Validator
     */
    // 文档地址 http://www.runoob.com/jquery/jquery-plugin-validate.html
    !function($) {
        "use strict";
        var FormValidator = function() {
            this.$changeTel = $("#changeTel");
        };

        FormValidator.prototype.init = function() {
//            $.validator.addMethod('isMobile', function(value, element){
//                var length = value.length;
//                var telRule = /^1[0-9]{10}$/;
//
//                return this.optional(element) || (length == 11 && telRule.test(value));
//            }, "请正确填写您的手机号码");

            $.validator.addMethod("isMobile", function(value, element) {
                var length = value.length;
                var mobile = /^1[34578]\d{9}$/;
                return this.optional(element) || (length == 11 && mobile.test(value));
            }, "请正确填写您的手机号码");

            $.validator.setDefaults({
                submitHandler: function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var data = new FormData();
                    data.append( "tel"    , $("input[name='tel']").val());
                    data.append( "newTel" , $("input[name='newTel']").val());
                    data.append( "telPassword" , $("input[name='telPassword']").val());
                    // add data for ajax
                    $.ajax({
                        url:'/user/change/phone/'+ $("#userinfo").val(),
                        type:'put',
                        data:{
                            tel     :$("input[name='tel']").val(),
                            newTel  :$("input[name='newTel']").val(),
                            password:$("input[name='telPassword']").val(),
                        },
                        beforeSend:function(){
                            $('.loading').show();
                        },
                        success:function(data){
                            $('.loading').hide();
                            $("input[name='newTel']").val('');
                            $("input[name='telPassword']").val('');

                            switch (data.StatusCode){
                                case '400':
                                    $('.close').click();
                                    promptBoxHandle('警告',data.ResultData);
                                    break;
                                case '200':
                                    $('.close').click();
                                    promptBoxHandle('提示',data.ResultData);
                                    $("input[name='tel']").val(data.Tel);
                                    break;
                            }

                        },
                        error:function(data){

                        }
                    })
                }
            });
            // validate signup form on keyup and submit
            this.$changeTel.validate({
                // 验证规则
                rules: {
                    tel: {
                        required: true,
                        minlength  : 11,
                    },
                    newTel: {
                        required: true,
                        minlength  : 11,
                        isMobile : true
                    },
                    telPassword: {
                        required: true
                    }
                },
                // 提示信息
                messages: {
                    tel: {
                        required: '请填写您的原始手机号1',
                        minlength  : '确认手机不能小于11个字符',
                    },
                    newTel: {
                        required: '请填写您的新手机号',
                        minlength  : '确认手机不能小于11个字符',
                        isMobile : "请正确填写您的手机号码"
                    },
                    telPassword: {
                        required: '请输入你的账号密码'
                    }
                }
            });

        },
                //init
                $.FormValidator = new FormValidator,
                $.FormValidator.Constructor = FormValidator
    }(window.jQuery),

            function($) {
                "use strict";
                $.FormValidator.init()
            }(window.jQuery);


</script>
<!-- 更改绑定手机 End -->
