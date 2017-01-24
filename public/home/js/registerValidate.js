
//jquery.validate表单验证
$(document).ready(function(){
    //登陆表单验证
    $("#loginForm").validate({
        rules:{
            username:{
                required:true,//必填
                minlength:3, //最少6个字符
                maxlength:10,//最多20个字符
            },
            password:{
                required:true,
                minlength:3,
                maxlength:32,
            },
        },
        //错误信息提示
        messages:{
            username:{
                required:"必须填写用户名",
                minlength:"用户名至少为3个字符",
                maxlength:"用户名至多为10个字符",
                remote: "用户名已存在",
            },
            password:{
                required:"必须填写密码",
                minlength:"密码至少为3个字符",
                maxlength:"密码至多为32个字符",
            },
        },

    });
    //注册表单验证
    $("#registerForm").validate({
        rules:{
            username:{
                required:true,//必填
                minlength:3, //最少3个字符
                maxlength:10,//最多10个字符
                remote:{
                    url:"http://kouss.com/demo/Sharelink/remote.json",//用户名重复检查，别跨域调用
                    type:"post",
                },
            },
            password:{
                required:true,
                minlength:6,
                maxlength:32,
            },

            confirm_password:{
                required:true,
                minlength:6,
                equalTo:'.password'
            },
            phone_number:{
                required:true,
                phone_number:true,//自定义的规则
                digits:true,//整数
            },
            code:{
                required:true,
                operateor:checkCode,
            }
        },
        //错误信息提示
        messages:{
            username:{
                required:"必须填写用户名",
                minlength:"用户名至少为3个字符",
                maxlength:"用户名至多为10个字符",
                remote: "用户名已存在",
            },
            password:{
                required:"必须填写密码",
                minlength:"密码至少为6个字符",
                maxlength:"密码至多为32个字符",
            },
            email:{
                required:"请输入邮箱地址",
                email: "请输入正确的email地址"
            },
            confirm_password:{
                required: "请再次输入密码",
                minlength: "确认密码不能少于6个字符",
                equalTo: "两次输入密码不一致",//与另一个元素相同
            },
            phone_number:{
                required:"请输入手机号码",
                phone_number:"请输入正确的手机号",
                digits:"请输入正确的手机号码",
            },

        },
    });
    //添加自定义验证规则
    jQuery.validator.addMethod("phone_number", function(value, element) {
        var length = value.length;
        var phone_number = /^1[34578]\d{9}$/;
        return this.optional(element) || (length == 11 && phone_number.test(value));
    }, "手机号码格式错误");
});


// 验证码点击更换
var captcha = document.getElementById('captcha');
captcha.onclick = function(){
    updateCaptcha($(this));
};
function updateCaptcha(me) {
    var url = '/code/captcha/';
    url = url + me.data('sesid') + Math.ceil(Math.random()*100);
    me.attr('src', url);
}

// 异步发送短信
$("#registerForm").on('click','#sendCode',function(){

    var phone =$("#number").val();
    // 传输
    var url = '/register/'+phone;
    $.ajax({
        type: "GET",
        url: url,
        success:function(data){
            console.log(data);
            switch (data.StatusCode){
                case '400':
                    // promptBoxHandle('警告',data.ResultData);
                    $('#error-info').html(data.ResultData).fadeIn(1000);
                    $('#error-info').fadeOut(2000);
                    setTime($("#sendCode"));
                    break;

                case '200':
                    $('#error-info').html(data.ResultData).fadeIn(1000);
                    $('#error-info').fadeOut(2000);
                    setTime($("#sendCode"));
                    break;
            }
        }
    });

});
// 短信验证发送后计时器
var countdown=60;
function setTime(obj) {
    if (countdown == 0) {
        obj.removeAttr('disabled');
        obj.html('获取验证码');
        countdown = 60;
        return;
    } else {
        obj.attr('disabled','true');
        obj.html('等待('+ countdown + 's)');
        countdown --;
    }
    setTimeout(function() {
        setTime(obj)
    },1000);
}