/**
 * Created by wangt on 2016/12/7.
 */
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
        this.$seofrom = $("#seofrom");
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
                data.append( "keywords"     , $("input[name= 'keywords']").val());
                data.append( "description"       , $("input[name= 'description']").val());
                //开始正常的ajax
                // 异步登录

                $.ajax({
                    type: "POST",
                    url: '/web_admins_seo',
                    data: {
                        'title': $("input[name= 'title']").val(),
                        'keywords': $("input[name= 'keywords']").val(),
                        'description': $("input[name= 'description']").val()

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


        this.$seofrom.validate({
            // 验证规则
            rules: {
                title: {
                    required: true
                }
            },
            // 提示信息
            messages: {
                email: {
                    required: "标题不能为空！"
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

