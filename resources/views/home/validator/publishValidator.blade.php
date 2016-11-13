<!-- 验证机制 Start -->
<script type="text/javascript" src="{{url('/qiniu/js/jquery.js')}}"></script>
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
            this.projectForm = $("#projectForm");
        };
        // 初始化
        FormValidator.prototype.init = function() {
            this.projectForm.validate({
                // 验证规则
                rules: {
                    title: {
                        required: true
                    },
                    content: {
                        required: true
                    },
                    image: {
                        required: true
                    },
                    file: {
                        required: true
                    }
                },
                // 提示信息
                messages: {
                    title: {
                        required: '必须要填写标题哦'
                    },
                    content: {
                        required: '必须要填写项目简介哦'
                    },
                    image: {
                        required: '必须要上传一张图片哦'
                    },
                    file: {
                        required: '必须要上传一份项目文件哦'
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