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
                        'action_id': $("input[name= 'action_id']").val()
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                // promptBoxHandle('警告',data.ResultData);
                                alert('警告',data.ResultData);
                                break;
                            case '200':
                                var html = '<li class="row">';
                                html += '<div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">';
                                html += '<div class="user-img-bgs">';
                                html += '<img src="'+ data.ResultData.headpic +'">';
                                html += '</div>';
                                html += '</div>';
                                html += '<div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">';
                                html += '<div class="row user-say1">';
                                html += '<span>'+ data.ResultData.user_name +'</span>';
                                html += '<span>'+ data.ResultData.time +'</span>';
                                html += '</div>';
                                html += '<div class="row user-say2">';
                                html += '<p>'+ data.ResultData.content +'</p>';
                                html += '</div>';
                                html += '</div>';
                                html += '</li>';
                                $('#commentlist').find('li').eq(0).after(html);
                                $('#commentlist').find('li').eq(4).remove();
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
                    minlength: 15
                }
            },
            // 提示信息
            messages: {
                content: {
                    required: "请输入评论内容！",
                    minlength: "评论最少为15字"
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



