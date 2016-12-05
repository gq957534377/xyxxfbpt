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
            this.$textfrom = $("#textfrom");
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
                    data.append( "tel"      , $("input[name= 'tel']").val());
                    data.append( "email"     , $("input[name= 'email']").val());
                    data.append( "time"       , $("input[name= 'time']").val());
                    data.append( "record"     ,$("input[name= 'record']").val());

                    //开始正常的ajax
                    // 异步登录
                    $.ajax({
                        type: "POST",
                        url: '/webadmins',
                        data: {
                            'email': $("input[name= 'email']").val(),
                            'time': $("input[name= 'time']").val(),
                            'tel': $("input[name= 'tel']").val(),
                            'record': $("input[name= 'record']").val(),

                        },
                        success:function(data){
                            switch (data.StatusCode){
                                case '400':
                                    alert('警告' + data.ResultData);
                                    break;
                                case '200':
                                    alert('chenggong');
                                    break;
                            }
                        }
                    });
                }
            });


            this.$textfrom.validate({
                // 验证规则
                rules: {
                    email: {
                        required: true,
                        email : true
                    },
//                    toppropaganda:{
//                        required: true,
//                        minlength: 2,
//                        maxlength: 20
//                    },
                    tel: {
                        required: true,
                        minlength:6,
                        maxlength:13
                    },
                    time: {
                        required: true
                    },
                    record: {
                        required: true
                    }
                },
                // 提示信息
                messages: {
                    email: {
                        required: "请输入邮箱！",
                        email: "Email 格式不对！"
                    },
                    time:{
                        required: "工作时间是必填选项！"
                    },
                    tel: {
                        required: "请输入客服电话",
                        minlength: "电话长度必须大于6小于13",
                        maxlength: "电话长度必须大于6小于13",
                    },
                    record: {
                        required: '备案内容不能为空'
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