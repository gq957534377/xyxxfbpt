@extends('admin.layouts.master')
@section('content')
@section('title', '功能测试')
        {{-- 弹出表单开始 --}}
        <button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">表单弹窗</button>
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


{{-- AlertInfo --}}
<a href="javascript:;" class="md-trigger btn btn-primary btn-sm" data-modal="modal-1">Show Me</a>
@section('alertInfo-title', '弹出标题')
@section('alertInfo-body')
    <p>This is a modal window. You can do the following things with it:</p>
    <ul>
        <li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
        <li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>
        <li><strong>Close:</strong> click on the button below to close the modal.</li>
    </ul>
    @endsection
{{-- AlertInfoEnd --}}

<!-- 表单验证 -->
<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Form validations</h3></div>
            <div class="panel-body">
                <div class=" form">
                    <form class="cmxform form-horizontal tasi-form" id="signupForm" method="get" action="#" novalidate="novalidate">
                        <div class="form-group ">
                            <label for="fname" class="control-label col-lg-2">Fname *</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="fname" name="fname" type="text">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="lastname" class="control-label col-lg-2">Lastname  *</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="lastname" name="lastname" type="text">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="username" class="control-label col-lg-2">Username *</label>
                            <div class="col-lg-10">
                                <input class="form-control " id="username" name="username" type="text">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="password" class="control-label col-lg-2">Password *</label>
                            <div class="col-lg-10">
                                <input class="form-control " id="password" name="password" type="password">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="confirm_password" class="control-label col-lg-2">Confirm Password *</label>
                            <div class="col-lg-10">
                                <input class="form-control " id="confirm_password" name="confirm_password" type="password">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="email" class="control-label col-lg-2">Email *</label>
                            <div class="col-lg-10">
                                <input class="form-control " id="email" name="email" type="email">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="agree" class="control-label col-lg-2 col-sm-3">Agree to Our Policy *</label>
                            <div class="col-lg-10 col-sm-9">
                                <input type="checkbox" style="width: 16px" class="checkbox form-control" id="agree" name="agree">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="newsletter" class="control-label col-lg-2 col-sm-3">Receive the Newsletter</label>
                            <div class="col-lg-10 col-sm-9">
                                <input type="checkbox" style="width: 16px" class="checkbox form-control" id="newsletter" name="newsletter">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- .form -->

            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->

</div>
<!-- 表单验证结束-->


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

