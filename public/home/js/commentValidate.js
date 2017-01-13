/**
 * Created by wangt on 2016/12/12.
 */

// 文档地址 http://www.runoob.com/jquery/jquery-plugin-validate.html
!(function ($) {
    "use strict";//使用严格标准
    // 获取表单元素
    var FormValidator = function(){
        this.$signOnForm = $("#comment");
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
                data.append( "content", $("textarea[name= 'content']").val());
                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "POST",
                    url: '/article/setcomment',
                    data: {
                        'content': $("textarea[name= 'content']").val(),
                        'action_id': $("input[name= 'action_id']").val(),
                        'type': $("input[name= 'type']").val()
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                swal({
                                        title: '消息提示', // 标题，自定
                                        text: data.ResultData,   // 内容，自定
                                        type: "info",    // 类型，分别为error、warning、success，以及info
                                        showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                                        confirmButtonColor: '#DD6B55',  // 确认用途的按钮颜色，自定
                                    },
                                    function (isConfirm) {
                                        swal('消息提示', data.ResultData, "info");
                                        $("textarea[name= 'content']").val("");
                                    });
                                break;
                            case '401':
                                swal({
                                        title: '消息提示', // 标题，自定
                                        text: data.ResultData,   // 内容，自定
                                        type: "info",    // 类型，分别为error、warning、success，以及info
                                        showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                                        confirmButtonColor: '#DD6B55',  // 确认用途的按钮颜色，自定
                                    },
                                    function (isConfirm) {
                                        swal('消息提示', data.ResultData, "info");
                                        window.location.href = '/login';
                                    });
                                break;
                            case '200':
                                $("textarea[name= 'content']").val('');
                                ajaxForPage(1, $("input[name= 'action_id']").val());
                                break;
                        }
                    }
                });
            }
        });
        // 验证规则和提示信息
        this.$signOnForm.validate({
            // 验证规则
            rules: {
                content: {
                    required: true,
                    minlength: 15,
                    maxlength: 80,
                }
            },
            // 提示信息
            messages: {
                content: {
                    required: "请输入评论内容！",
                    minlength: "评论最少为15字",
                    maxlength: "评论最多为80字",
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



