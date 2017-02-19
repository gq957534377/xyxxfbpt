/**
 * Created by wangt on 2017/1/10.
 */
// 更改进度条长度
var number = $('#resk').val();
updateResk(number)
function updateResk(number)
{
    $('.progress-bar-warning').width(number + '%');
    $('.safe-lv').html(number);
}

$(function () {

    var guid = $("#topAvatar").data('id');
    var ajax =new ajaxCommon();
//        测量 滚动条宽度的函数 开始
    function measure() { // thx walsh
        this.$body = $(document.body);
        var scrollDiv = document.createElement('div');
        scrollDiv.className = 'modal-scrollbar-measure';
        this.$body.append(scrollDiv);
        var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
        this.$body[0].removeChild(scrollDiv);
        return scrollbarWidth
    }
//        测量 滚动条宽度的函数 结束
    var width = Number(measure());
//        更换安全手机 开始
    $('#changeTel').on('click', function () {
//            处理模态框显示时的问题 开始
        var body = $('body');
        body.scrollTop(5);//控制滚动条下移1px
        var b = body.scrollTop();//取得滚动条位置
        if (b > 0 && measure() > 0) {
            body.scrollTop(0);//滚动条返回顶部
            $('header').css('padding-right', width + 15 + 'px');
            $('nav').css('padding-right', width + 15 + 'px');
            $('#changeTelModal').modal('show').on('hidden.bs.modal', function () {
                $('header').css('padding-right', '15px');
                $('nav').css('padding-right', '15px');
                body.css('padding-right', 0);
            });
        } else {
            $('#changeTelModal').modal('show');
        }
//            处理模态框显示时的问题 结束
    });
    $('#step_one').on('click', function () {
        // 发送成功后，验证输入框不为空执行下一步
        if ($.trim($("#captcha").val()) == '') {
            $('#errorBox').html('请输入短信验证码').removeClass('hidden');
            return false;
        }

        // 输入验证码后，异步发送到后台匹配验证码
        var data = {
            'captcha' : $.trim($("#captcha").val()),
            'step'    : '1'
        };
        ajax.ajax({
            url     :   '/user/change/phone/' + guid,
            type    :   'PUT',
            data    :   data,
            beforeSend: ajaxBeforeSend($('.loading')),
            success :   stepOne,
        });

        function stepOne (msg) {
            if (msg.StatusCode == '200') {
                $('#sendSmsSuccess').addClass('hidden');
                $('.tel-step-one').addClass('hidden');
                $('.tel-step-one + div').addClass('hidden');
                $('.tel-step-two').removeClass('hidden');
                $('.tel-step-two + div').removeClass('hidden');
            } else {
                $('#errorBox').html(msg.ResultData).removeClass('hidden');
            }
            ajaxAfterSend($('.loading'));
        }
    });
    $('#step_two').on('click', function () {
        // 发送成功后，验证输入框不为空执行下一步
        if ($.trim($("#newTel").val()) == '') {
            $('#errorBox2').html('请输入新手机号').removeClass('hidden');
            return false;
        } else {
            var pattern = /^1[34578]\d{9}$/;
            if (pattern.test($.trim($("#newTel").val())) == false) {
                $('#errorBox2').html('请输入正确的手机号').removeClass('hidden');
            }
        };

        // 输入验证码后，异步发送到后台匹配验证码
        var data = {
            'tel' : $.trim($("#newTel").val()),
            'step'    : '2'
        };

        ajax.ajax({
            url      :   '/user/change/phone/' + guid,
            type     :   'PUT',
            data     :   data,
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   stepTwo,

        });

        function stepTwo (msg)
        {
            if (msg.StatusCode == '200') {
                $("#newSmsBox").text(msg.ResultData);
                $('.tel-step-two').addClass('hidden');
                $('.tel-step-two + div').addClass('hidden');
                $('.tel-step-three').removeClass('hidden');
                $('.tel-step-three + div').removeClass('hidden');
            } else {
                $('#errorBox2').html(msg.ResultData).removeClass('hidden');
            }
            ajaxAfterSend($('.loading'));
        }
    });
    // 手机绑定返回按钮
    $('#tel_return').click(function(){
        $("#captcha").val('');
        $("#errorBox").addClass('hidden');
        $("#newTel").val('');
        $('.tel-step-two').addClass('hidden');
        $('.tel-step-two + div').addClass('hidden');
        $('.tel-step-one').removeClass('hidden');
        $('.tel-step-one + div').removeClass('hidden');
    });
    $('#step_three').on('click', function () {
        // 发送成功后，验证输入框不为空执行下一步
        if ($.trim($("#captcha_two").val()) == '') {
            $('#errorBox3').html('请输入短信验证码').removeClass('hidden');
            return false;
        };

        // 输入验证码后，异步发送到后台匹配验证码
        var data = {
            'captcha' : $.trim($("#captcha_two").val()),
            'step'    : '1',
            'tel'     : $("#newSmsBox").text()
        };

        ajax.ajax({
            url      :   '/user/change/phone/' + guid,
            type     :   'PUT',
            data     :   data,
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   StepThree,

        });

        function StepThree (msg)
        {
            if (msg.StatusCode == '200') {
                $('.tel-step-three').addClass('hidden');
                $('.tel-step-three + div').addClass('hidden');
                $('.tel-step-four').removeClass('hidden');
                $('.tel-step-four + div').removeClass('hidden');
                swal({
                        title: '消息提示', // 标题，自定
                        text: '手机绑定成功，准备重新登录...',   // 内容，自定
                        type: "success",    // 类型，分别为error、warning、success，以及info
                        showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                        confirmButtonColor: '#34c73b',  // 确认用途的按钮颜色，自定
                    },
                    function (isConfirm) {
                        swal('消息提示', msg.ResultData, "success");
                        $(".userInfoReset").click();
                        window.location.href = '/logout';
                    });
            } else {
                $('#errorBox3').html(msg.ResultData).removeClass('hidden');
            }
            ajaxAfterSend($('.loading'));
        }
    });
    $('#step_four').on('click', function () {
        $('.tel-step-four').addClass('hidden');
        $('.tel-step-four + div').addClass('hidden');
        $('.tel-step-one').removeClass('hidden');
        $('.tel-step-one + div').removeClass('hidden');
    });

    // 点击取消，回到初始第一步
    $(".tel_btn_reset").click(function(){
        $("#captcha").val('');
        $("#captcha_two").val('');
        $("#newTel").val('');
        $('.tel-step-one').removeClass('hidden');
        $('.tel-step-one + div').removeClass('hidden');
        $('.tel-step-two').addClass('hidden');
        $('.tel-step-two + div').addClass('hidden');
        $('.tel-step-three').addClass('hidden');
        $('.tel-step-three + div').addClass('hidden');
        $('.tel-step-four').addClass('hidden');
        $('.tel-step-four + div').addClass('hidden');
        $('#errorBox').addClass('hidden');
        $('#errorBox2').addClass('hidden');
        $('#errorBox3').addClass('hidden');

    });

//        更换安全手机 结束

//        更换安全邮箱 开始
    $('#changeEmail').on('click', function () {
//            处理模态框显示时的问题 开始
        var body = $('body');
        body.scrollTop(5);//控制滚动条下移1px
        var b = body.scrollTop();//取得滚动条位置
        if (b > 0 && measure() > 0) {
            body.scrollTop(0);//滚动条返回顶部
            $('header').css('padding-right', width + 15 + 'px');
            $('nav').css('padding-right', width + 15 + 'px');
            $('#changeEmailModal').modal('show').on('hidden.bs.modal', function () {
                $('header').css('padding-right', '15px');
                $('nav').css('padding-right', '15px');
                body.css('padding-right', 0);
            });
        } else {
            $('#changeEmailModal').modal('show');
        }
//            处理模态框显示时的问题 结束
    });
    $('#email_step_one').on('click', function () {
        var newEmail = $('#newEmail').val();
        // 判断输入框是否为空
        if ($.trim(newEmail) == '') {
            $("#errorEmailBox_one").html('请输入您的邮箱').removeClass('hidden');
            return false;
        }

        // 验证邮箱是否正确
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if (!reg.test(newEmail)) {
            $("#errorEmailBox_one").html('请输入正确的邮箱').removeClass('hidden');
            return false;
        }

        // 异步将新邮箱、用户ID
        var data = {
            'guid'     : guid,
            'newEmail' : newEmail,
        };

        ajax.ajax({
            url      :   '/user/sendemail',
            type     :   'POST',
            data     :   data,
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   emailOne,

        });

        function emailOne (msg) {
            if (msg.StatusCode == '200') {
                $('#toEmail').html(newEmail);

                $('.email-step-one').addClass('hidden');
                $('.email-step-one + div').addClass('hidden');
                $('.email-step-two').removeClass('hidden');
                $('.email-step-two + div').removeClass('hidden');
            } else {
                $("#errorEmailBox_one").html(msg.ResultData).removeClass('hidden');
            }

            ajaxAfterSend($('.loading'));
        }
    });
    $('#email_step_two').on('click', function () {
        var captcha_email = $("#captcha_email").val();
        if ($.trim(captcha_email) == '') {
            $("#errorEmailBox_two").html('请输入验证码').removeClass('hidden');
            return false;
        }
        var data = {
            'guid' : guid,
            'captcha_email' : captcha_email,
        };
        ajax.ajax({
            url      :   '/user/change/email',
            type     :   'POST',
            data     :   data,
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   emailTwo,

        });

        function emailTwo (msg) {
            if (msg.StatusCode == '200') {
                $("#email").html(msg.ResultData);
                $('.email-step-two').addClass('hidden');
                $('.email-step-two + div').addClass('hidden');
                $('.email-step-three').removeClass('hidden');
                $('.email-step-three + div').removeClass('hidden');
                swal({
                        title: '提示', // 标题，自定
                        text: '邮箱邦定成功',   // 内容，自定
                        type: "success",    // 类型，分别为error、warning、success，以及info
                        showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                        confirmButtonColor: '#34c73b',  // 确认用途的按钮颜色，自定
                    },
                    function (isConfirm) {
                        swal('消息提示', msg.ResultData, "success");
                        $("#emailBinded").removeClass('unbinded').addClass('binded');
                        $("#emailBinded").html('已绑定');
                        $("#changeEmail").html('更换');
                        $(".userInfoReset").click();
                    });
            } else {
                $("#errorEmailBox_two").html(msg.ResultData).removeClass('hidden');

            }
            ajaxAfterSend($('.loading'));
        }
    });
    $('#email_step_three').on('click', function () {
        $('.email-step-two').addClass('hidden');
        $('.email-step-two + div').addClass('hidden');
        $('.email-step-one').addClass('hidden');
        $('.email-step-one + div').addClass('hidden');
    });

    // 邮箱更换绑定返回按钮
    $('#email_return').click(function () {
        $('#newEmail').val('');
        $('#captcha_email').val('');
        $('#errorEmailBox_one').addClass('hidden');
        $('#errorEmailBox_two').addClass('hidden');
        $('.email-step-one').removeClass('hidden');
        $('.email-step-one + div').removeClass('hidden');
        $('.email-step-two').addClass('hidden');
        $('.email-step-two + div').addClass('hidden');
        $('.email-step-three').addClass('hidden');
        $('.email-step-three + div').addClass('hidden');
    });
    // Email更换绑定取消按钮
    $('.btn_email_reset').click(function () {
        $('#newEmail').val('');
        $('#captcha_email').val('');
        $('#errorEmailBox_one').addClass('hidden');
        $('#errorEmailBox_two').addClass('hidden');
        $('.email-step-one').removeClass('hidden');
        $('.email-step-one + div').removeClass('hidden');
        $('.email-step-two').addClass('hidden');
        $('.email-step-two + div').addClass('hidden');
        $('.email-step-three').addClass('hidden');
        $('.email-step-three + div').addClass('hidden');
    });
//        更换安全邮箱 结束

//        更换密码 开始
    $('#changeKey').on('click', function () {
//            处理模态框显示时的问题 开始
        var body = $('body');
        body.scrollTop(5);//控制滚动条下移1px
        var b = body.scrollTop();//取得滚动条位置
        if (b > 0 && measure() > 0) {
            body.scrollTop(0);//滚动条返回顶部
            $('header').css('padding-right', width + 15 + 'px');
            $('nav').css('padding-right', width + 15 + 'px');
            $('#changeKeyModal').modal('show').on('hidden.bs.modal', function () {
                $('header').css('padding-right', '15px');
                $('nav').css('padding-right', '15px');
                body.css('padding-right', 0);
            });
        } else {
            $('#changeKeyModal').modal('show');
        }
//            处理模态框显示时的问题 结束
    });
    $('#key_step_one').on('click', function () {
        var key_old = $('#key_old').val();
        var key_new = $('#key_new').val();
        var key_new_two = $('#key_new_two').val();

        if ($.trim(key_old) == '') {
            $("#errorPasswordBox_one").html('请输入原始密码').removeClass('hidden');
            return false;
        }

        if($.trim(key_new) =='') {
            $("#errorPasswordBox_one").html('请输入新密码').removeClass('hidden');
            return false;
        }

        if($.trim(key_new).length < 6 ) {
            $("#errorPasswordBox_one").html('密码长度最少6位').removeClass('hidden');
            return false;
        }

        if($.trim(key_new_two) =='') {
            $("#errorPasswordBox_one").html('请再次输入新密码').removeClass('hidden');
            return false;
        }

        if($.trim(key_new) != $.trim(key_new_two) ) {
            $("#errorPasswordBox_one").html('请确认新密码').removeClass('hidden');
            return false;
        }

        ajax.ajax({
            url      :   '/user/change/password',
            type     :   'POST',
            data     :   {
                'guid' : guid,
                'password' : key_old,
                'new_password' : key_new,
            },
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   passwordOne,

        });

        function passwordOne (msg) {
            if (msg.StatusCode == '200') {
                $("#errorPasswordBox_one").html('').addClass('hidden');
                $('.key-step-one').addClass('hidden');
                $('.key-step-one + div').addClass('hidden');
                $('.key-step-two').removeClass('hidden');
                $('.key-step-two + div').removeClass('hidden');
                swal({
                        title: '提示', // 标题，自定
                        text: '密码修改成功，准备重新登录...',   // 内容，自定
                        type: "success",    // 类型，分别为error、warning、success，以及info
                        showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                        confirmButtonColor: '#34c73b',  // 确认用途的按钮颜色，自定
                    },
                    function (isConfirm) {
                        swal('提示', msg.ResultData, "success");
                        $(".userInfoReset").click();
                        window.location.href = '/logout';
                    });
            } else {
                $("#errorPasswordBox_one").html(msg.ResultData).removeClass('hidden');
            }
            ajaxAfterSend($('.loading'));
        }

    });
    $('#key_step_two').on('click', function () {
        $('.key-step-two').addClass('hidden');
        $('.key-step-two + div').addClass('hidden');
        $('.key-step-one').removeClass('hidden');
        $('.key-step-one + div').removeClass('hidden');
    });

    $(".btn_password_reset").click(function () {
        $('#key_old').val('');
        $('#key_new').val('');
        $('#key_new_two').val('');
    });
//        更换密码 结束



    // 手机改绑，点击更换事件
    $("#resend_captcha").click(function() {
        // 异步发送短信
        ajax.ajax({
            url      :   '/user/sendsms/'+guid,
            type     :   'GET',
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   resendCaptcha,
        });

        function resendCaptcha(msg)
        {
            if (msg.StatusCode == '200') {
                // 成功后显示
                $('#sendSmsSuccess').removeClass('hidden');
                // 成功后60秒内禁止再次发送
                axxountSettingDown = 60;
                setTime($("#resend_captcha"), $("#resend_captcha_label"));

            } else {
                swal('消息提示', msg.ResultData, "warning");
            }

            $("#errorBox").addClass('hidden');
            ajaxAfterSend($('.loading'));
        }
    });

    $("#resend_captcha_two").click(function() {
        ajax.ajax({
            url      :   '/user/sendsms/'+ guid ,
            type     :   'GET',
            data     :   {
                'phone' :  $('#newSmsBox').text(),
                'code'  :  $('#auth-code').val()
            },
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   resendCaptchaTwo,
        });

        function resendCaptchaTwo(msg)
        {
            if (msg.StatusCode == '200') {
                // 成功后显示
                $('#sendSmsSuccessTwo').removeClass('hidden');
                // 成功后60秒内禁止再次发送
                axxountSettingDown = 60;
                setTime1($("#resend_captcha_two"), $("#resend_captcha_laravel_two"));

            } else {
                swal('消息提示', msg.ResultData, "warning");
            }
            $("#errorBox2").addClass('hidden');
            ajaxAfterSend($('.loading'));
        }

    });

    // 再次发送Email
    $("#resend_captcha_email").click(function(){
        var newEmail = $('#newEmail').val();
        // 异步将新邮箱、用户ID
        var data = {
            'guid'     : guid,
            'newEmail' : newEmail,
        };

        ajax.ajax({
            url      :   '/user/sendemail',
            type     :   'POST',
            data: data,
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   resendEmail,
        });

        function resendEmail(msg)
        {
            if (msg.StatusCode == '200') {
                setTime($("#resend_captcha_email"), $('#resend_email_two'));
            } else {
                $("#errorEmailBox_two").html(msg.ResultData).removeClass('hidden');
                setTime($("#resend_captcha_email"), $('#resend_email_two'));
            }
            ajaxAfterSend($('.loading'));
        }
    });
    // 短信验证发送后计时器
    var axxountSettingDown = 60;
    function setTime(obj, objLabel) {
        if (axxountSettingDown == 0) {
            obj.show();
            objLabel.addClass('hidden');
            axxountSettingDown = 60;
            return;
        } else {
            obj.hide();
            objLabel.removeClass('hidden');
            objLabel.text('重新发送'+ axxountSettingDown + '秒');
            axxountSettingDown --;
        }
        setTimeout(function() {
            setTime(obj, objLabel);
        },1000);

    }

    // 短信验证发送后计时器
    var axxountSettingDown1 = 60;
    function setTime1(obj, objLabel) {
        if (axxountSettingDown1 == 0) {
            obj.show();
            objLabel.addClass('hidden');
            axxountSettingDown1 = 60;
            return;
        } else {
            obj.hide();
            objLabel.removeClass('hidden');
            objLabel.text('重新发送'+ axxountSettingDown1 + '秒');
            axxountSettingDown1 --;
        }
        setTimeout(function() {
            setTime(obj, objLabel);
        },1000);

    }


    updateCaptcha($('#captcha-new'));
    // 验证码点击更换
    var captcha = document.getElementById('captcha-new');
    captcha.onclick = function(){
        updateCaptcha($(this));
    };
    function updateCaptcha(me) {
        var url = '/code/captcha/';
        url = url + me.data('sesid') + Math.ceil(Math.random()*100);
        me.attr('src', url);
    }

});

