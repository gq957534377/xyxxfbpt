<!-- 更改绑定邮箱 Start -->
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
            this.$changeEmail = $("#changeEmail");
        };
        FormValidator.prototype.init = function() {
            $.validator.setDefaults({
                submitHandler: function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var data = new FormData();
                    data.append( "email"    , $("input[name='email']").val());
                    data.append( "newEmail" , $("input[name='newEmail']").val());
                    data.append( "password" , $("input[name='password']").val());
                    // add data for ajax
                    $.ajax({
                        url:'/user/change/email/'+ $("#userinfo").val(),
                        type:'put',
                        data:{
                            email   :$("input[name='email']").val(),
                            newEmail:$("input[name='newEmail']").val(),
                            password:$("input[name='password']").val(),
                        },
                        beforeSend:function(){
                            $('.loading').show();
                        },
                        success:function(data){
                            $('.loading').hide();
                            $("input[name='email']").val('');
                            $("input[name='newEmail']").val('');
                            $("input[name='password']").val('');

                            switch (data.StatusCode){
                                case '400':
                                    promptBoxHandle('警告',data.ResultData);
                                    break;
                                case '200':
                                    $('.close').click();
                                    promptBoxHandle('提示',data.ResultData);
                                    $("input[name='email']").val(data.Email);
                                    break;
                            }

                        },
                        error:function(data){

                        }
                    })
                }
            });
            // validate signup form on keyup and submit
            this.$changeEmail.validate({
                // 验证规则
                rules: {
                    email: {
                        required: true,
                        email : true
                    },
                    newEmail: {
                        required: true,
                        email : true
                    },
                    password: {
                        required: true
                    }
                },
                // 提示信息
                messages: {
                    email: {
                        required: '请填写您的原始邮箱',
                        email: '原始邮箱格式不正确'
                    },
                    newEmail: {
                        required: '请填写您的新邮箱',
                        email: '新邮箱格式不正确'
                    },
                    password: {
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
<!-- 更改绑定邮箱 End -->
