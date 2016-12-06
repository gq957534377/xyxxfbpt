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
                    data.append( "title"      , $("input[name= 'title']").val());
                    data.append( "synopsis1"     , $("input[name= 'synopsis1']").val());
                    data.append( "synopsis2"       , $("input[name= 'synopsis2']").val());

                    //开始正常的ajax
                    // 异步登录
                    $.ajax({
                        type: "POST",
                        url: '/web_qrcode_organiz',
                        data: {
                            'title': $("input[name= 'email']").val(),
                            'synopsis1': $("input[name= 'time']").val(),
                            'synopsis2': $("input[name= 'tel']").val()

                        },
                        success:function(data){
                            switch (data.StatusCode){
                                case '400':
                                    alert('警告' + data.ResultData);
                                    break;
                                case '200':
                                    alert('更新成功');
                                    break;
                            }
                        }
                    });
                }
            });


            this.$textfrom.validate({
                // 验证规则
                rules: {
                    title: {
                        required: true
                    }
                },
                // 提示信息
                messages: {
                    title: {
                        required: "请输入标题！"
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