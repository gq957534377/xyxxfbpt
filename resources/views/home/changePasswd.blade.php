@extends('home.layouts.master')

@section('style')
  <link href="{{ asset('home/css/change-passwd.css') }}" rel="stylesheet">

@endsection

@section('menu')
  @parent
@endsection

@section('content')
<div class="container-fluid bgc-8">
  <div class="container">

    <div class="bgc-0 col-md-offset-2 col-xs-12 col-md-8 change-passwd">
          <p class="fs-24 bb-1">重置密码</p>

          <div>
              <div id="error-info" class="alert alert-danger" style="display: none;"></div>
            <form id="changePasswordForm" class="form-horizontal" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">

              <div class="form-group mar-b30">
                <label for="form-title" class="col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">手机号：</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="">
                </div>
              </div>
              <div class="form-group mar-b30">
                <label for="wechat-num" class="col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">新密码：</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control form-title" id="password" name="password" placeholder="">
                </div>
              </div>

              <div class="form-group mar-b30 mar-b15-xs">
                <label for="work-company" class="col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">确认新密码：</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="confirm_password" id="" placeholder="">
                </div>
              </div>
              <div class="form-group mar-b30 mar-b15-xs">
                <label for="work-position" class="col-xs-12 col-lg-offset-1 col-sm-3 col-lg-2 control-label mar-b10 pad-cr">验证码：</label>
                <div class="col-xs-7 col-sm-4">
                  <input type="text" class="form-control form-title" name="code" id="work-position" placeholder="">
                </div>
                <div class="col-xs-5 col-md-3 pad-cl">
                  <a href="javascript:void(0)" class="btn fs-15 bgc-4 fs-c-0 zxz border-no" role="button" id="get_captcha">获取验证码</a>
                </div>
              </div>

              <div class="form-group mar-b30">
                <div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-sm-6">
                  <button type="submit" class="btn fs-18 btn-1 bgc-2 fs-c-1 zxz border-no" id="submit_my_company">提&nbsp;&nbsp;&nbsp;&nbsp;交</button>
                </div>
              </div>
            </form>

          </div>
        </div>
  </div>
</div>

@endsection
@section('script')
    <script src="{{asset('admin/js/sweet-alert.init.js')}}"></script>
  <script>
      // 手机号验证规则
      function isPhoneNo(phone) {
          var pattern = /^1[34578]\d{9}$/;
          return pattern.test(phone);
      }

      //验证函数
      function formValidate(phone) {
          // 返回信息
          var str = '';
          // 判断手机号
          if($.trim(phone).length == 0){
              $('#error-info').html('警告' + '请输入手机号').fadeIn(1000);
              $('#error-info').fadeOut(2000);
              exit();
          } else {
              if(isPhoneNo($.trim(phone))== false) {
                  $('#error-info').html('警告' + '手机号不正确').fadeIn(1000);
                  $('#error-info').fadeOut(2000);
                  exit();
              }
          }
      }

      $('#get_captcha').on('click', function () {
          var phone =$("#phone").val();
          // 校验手机号
          formValidate(phone);
          // 传输
          var url = '/changepwd/code/'+phone;
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
                          setTime($("#get_captcha"));
                          break;

                      case '200':
                          swal('验证码已发送成功，请注意查收！');
                          setTime($("#get_captcha"));
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

      !(function ($) {
          "use strict";//使用严格标准
          // 获取表单元素
          var FormValidator = function(){
              this.$signUpForm = $("#changePasswordForm");
          };
          // 初始化
          FormValidator.prototype.init = function() {
              // 自定义手机验证规则
              $.validator.addMethod("isMobile", function(value, element) {
                  var length = value.length;
                  var mobile = /^1[34578]\d{9}$/;
                  return this.optional(element) || (length == 11 && mobile.test(value));
              }, "手机号码不对");

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
                      data.append( "phone"     , $("input[name= 'phone']").val());
                      data.append( "password"       , $("input[name= 'password']").val());
                      data.append( "confirm_password"     ,$("input[name= 'confirm_password']").val());
                      data.append( "code"     , $("input[name= 'code']").val());
                      //开始正常的ajax
                      // 异步登录
                      $.ajax({
                          type: "PUT",
                          url: '/login/' + $("input[name= 'phone']").val(),
                          data: {
                              'tel': $("input[name= 'phone']").val(),
                              'password': $("input[name= 'password']").val(),
                              'confirm_password': $("input[name= 'confirm_password']").val(),
                              'code': $("input[name= 'code']").val()
                          },
                          success:function(data){
                              switch (data.StatusCode){
                                  case '400':

                                      $('#error-info').html('警告' + data.ResultData).fadeIn(1000);
                                      $('#error-info').fadeOut(2000);
                                      break;
                                  case '200':
                                      swal({
                                          title: "修改成功！",
                                          text: "请前往登录界面!",
                                          type: "success",
                                          confirmButtonColor: "#6bd431",
                                          confirmButtonText: "确定"
                                      }, function(){
                                          location.href = "/login";
                                      });
                                      break;
                              }
                          }
                      });
                  }
              });
              // 验证数据规则和提示
              this.$signUpForm.validate({
                  // 验证规则
                  rules: {
                      password: {
                          required: true,
                          minlength:6
                      },
                      confirm_password: {
                          required: true,
                          minlength: 6,
                          equalTo: "#password"
                      },
                      phone: {
                          required: true,
                          minlength:11,
                          maxlength: 11,
                          isMobile: true

                      },
                      code: {
                          required: true,

                      }
                  },
                  // 提示信息
                  messages: {
                      password: {
                          required: "请输入密码",
                          minlength: "密码长度小于6"
                      },
                      confirm_password: {
                          required: "请输入确认密码",
                          minlength: "密码长度小于6",
                          equalTo: "输入密码不一致"
                      },
                      phone: {
                          required: "请输入手机号",
                          minlength: "密码长度小于11位",
                          maxlength: "密码长度大于11位",
                          isMobile: "手机号码不对"
                      },
                      code: {
                          required: "输入短信验证码"
                      }
                  }
//                  },
//                  errorPlacement: function(error, element) {
//                      // Append error within linked label
//                      $('#error-info').html(error[0].textContent).fadeIn(1000);
//                      $('#error-info').fadeOut(2000);
//                  }
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
@endsection
