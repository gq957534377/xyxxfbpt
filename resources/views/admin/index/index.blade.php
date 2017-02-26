@extends('admin.layouts.master')
@section('content')
@section('title', '校园信息发布平台后台')
        {{-- 弹出表单开始 --}}

        <!--继承组件-->
        <!--替换按钮ID-->
        @section('form-id', 'con-close-modal')
        <!--定义弹出表单ID-->
        @section('form-title', '表单标题')
        <!--定义弹出内容-->
        @section('form-body')

        @endsection
       <!--定义底部按钮-->
        @section('form-footer')
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info">Save changes</button>
            </div>
        @endsection
        {{-- 弹出表单结束 --}}

@section('alertInfo-title', '弹出标题')
@section('alertInfo-body')

@endsection
{{-- AlertInfoEnd --}}
<h1>校园信息发布平台后台管理系统</h1>

@endsection

@section('script')
    <!--alertInfo JS-->
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
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
                //this.$commentForm = $("#commentForm"),
                        this.$signupForm = $("#signupForm");
            };

            //初始化
            FormValidator.prototype.init = function() {
                //插件验证完成执行操作 可以不写
                $.validator.setDefaults({
                    submitHandler: function() { alert("可以提交!"); }
                });

                // validate the comment form when it is submitted
               // this.$commentForm.validate();

                // validate signup form on keyup and submit
                this.$signupForm.validate({
                    rules: {
                        fname: "required", //必填
                        lastname: "required",//必填
                        username: {
                            required: true,//必填
                            minlength: 2//最短 两位
                        },
                        password: {
                            required: true,
                            minlength: 5
                        },
                        confirm_password: {
                            required: true,
                            minlength: 5,
                            equalTo: "#password" //等于谁
                        },
                        email: {
                            required: true,
                            email: true // 验证是否是邮箱
                        },
                        topic: {
                            required: "#newsletter:checked", //验证是否选择
                            minlength: 2
                        },
                        agree: "required"
                    },
                    //提示信息
                    messages: {
                        fname: "请输入您的名字",
                        lastname: "请输入您的姓",
                        username: {
                            required: "请输入一个用户名",
                            minlength: "您的用户名必须包括至少2个字符"
                        },
                        password: {
                            required: "请输入密码",
                            minlength: "您的密码必须至少有5个字符长"
                        },
                        confirm_password: {
                            required: "请输入密码",
                            minlength: "您的密码必须至少有5个字符长",
                            equalTo: "请输入相同的密码"
                        },
                        email: "请输入一个有效的电子邮件地址",
                        agree: "请接受我们的政策.."
                    }
                });

                // propose username by combining first- and lastname
                $("#username").focus(function() {
                    var fname = $("#ftname").val();
                    var lastname = $("#lastname").val();
                    if(fname && lastname && !this.value) {
                        this.value = fname + "." + lastname;
                    }
                });

                //code to hide topic selection, disable for demo
                var newsletter = $("#newsletter");
                // newsletter topics are optional, hide at first
                var inital = newsletter.is(":checked");
                var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
                var topicInputs = topics.find("input").attr("disabled", !inital);
                // show when newsletter is checked
                newsletter.click(function() {
                    topics[this.checked ? "removeClass" : "addClass"]("gray");
                    topicInputs.attr("disabled", !this.checked);
                });

            },
                    //init
                    $.FormValidator = new FormValidator, $.FormValidator.Constructor = FormValidator
        }(window.jQuery),

        //initializing
                function($) {
                    "use strict";
                    $.FormValidator.init()
                }(window.jQuery);
    </script>
@endsection

