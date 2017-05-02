@extends('home.layouts.userCenter')

@section('title','我的主页')

@section('style')
    <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
    <link href="{{asset('home/css/user_center_my_home.css')}}" rel="stylesheet"/>
    <link href="{{ asset('home/css/user_center_account_setting.css') }}" rel="stylesheet">
    <link href="{{ asset('home/css/common.css') }}" rel="stylesheet">
    <style>
        .user_info:after {
            content: '';
            display: table;
            clear: both;
        }
    </style>

@endsection

@section('content')

    <!--我的主页内容开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 my-home fs-c-4 fs-14 content-wrap">
        <!--基本信息开始-->
        <div style="position: relative;" class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pad-cl my-home-basic">
            <!-- 头像修改 Start -->
            <div class="col-sm-2 col-md-3 col-lg-2 pad-clr"
                 style="left:15px;position:absolute;display: inline-block;width: 20%;">
                <div class="ibox-content">
                    <div class="row">
                        <div id="crop-avatar">
                            <div class="avatar-view" title="">
                                <img class="user_avatar img-circle"
                                     src="{{ session('user')->headpic ? session('user')->headpic : asset('home/images/user_center.jpg') }}"
                                     alt="Logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 头像修改 End -->
            {{--<div class="col-sm-10 col-md-9 col-lg-10 pad-clr user_info" style="display: inline-block;width: 66%;padding-left: 68px;margin-top: 7px;">--}}
            {{--<p class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad-cr">昵称：<span class="user_nickname">{{ $userInfo->username or '--'}}</span><a id="userInfoEdit" href="javascript:void(0);">编辑</a></p>--}}
            {{--<p class="user_tel col-xs-12 col-sm-5 col-md-6 col-lg-4">{{ $userInfo->phone_number or '--'}}</p>--}}
            {{--<p class="user_email col-xs-12 col-sm-6 col-md-6 col-lg-6 {{$userInfo->emails or 'hidden'}}">{{ $userInfo->email or '--'}}</p>--}}
            {{--</div>--}}
            <div class="col-sm-10 col-md-9 col-lg-10 pad-clr user_info"
                 style="margin-left:10%;display: inline-block;width: 66%;padding-left: 68px;margin-top: 7px;">
                <p class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad-cr">昵称：<span
                            class="user_nickname">{{ $userInfo->username or '--'}}</span><a id="userInfoEdit"
                                                                                            href="javascript:void(0);">编辑</a>
                </p>
                <p class="user_tel col-xs-12 col-sm-5 col-md-6 col-lg-4">{{ $userInfo->phone_number or '--'}}</p>
                <p class="user_email col-xs-12 col-sm-6 col-md-6 col-lg-6 {{$userInfo->emails or 'hidden'}}">{{ $userInfo->email or '--'}}</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pad-cr my-home-entrepreneur-info">
            <div class="b-all-3 bgc-0">
                <p>{{ $goods ?? 0 }}</p>
                <p class="mar-cb"><a href="{{ route('userGoods.index') }}">二手</a></p>
            </div>
            <div class="b-all-3 bgc-0">
                <p>{{ $article ?? 0 }}</p>
                <p class="mar-cb"><a href="{{ route('send.index',['status'=>1]) }}" class="toTheProject">文章</a></p>
            </div>

        </div>
        <!--基本信息结束-->

        <!--修改头像弹出框 Start-->
    @include('home.public.avatar')
    <!--修改头像弹出框 End-->

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <img src="{{asset('home/images/load.gif')}}" class="loading pull-right">
                <div class="modal-content">
                    <div class="modal-header bgc-6 fs-c-0">
                        <h4 class="modal-title">修改昵称</h4>
                    </div>
                    <!--第一步 填写-->
                    <div class="modal-body key-step-one">
                        <!-- 错误提示 Start-->
                        <div id="userInfoError" class="col-xs-12 alert alert-danger hidden"></div>
                        <div id="userInfoSuccess" class="col-xs-12 alert alert-success hidden"></div>
                        <!-- 错误提示 End-->
                        <div class="col-xs-12">
                            <label class="col-xs-12 control-label mar-b5">用户昵称</label>
                            <div class="col-xs-12">
                                <input type="text" name="nickname" maxlength="10" class="form-control form-title"
                                       placeholder="输入新的昵称">
                            </div>
                            <div class="col-xs-12 nickname_sub">
                                <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" id="editSubmit">
                                    保存
                                </button>
                                <button type="button" class="btn btn-default userInfoReset" data-dismiss="modal">取消
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-no h-align-1 pad-ct"></div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <!--修改昵称 结束-->

        <!--账号设置开始-->
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 account-setting fs-c-4">
            <div class="col-xs-12 pad-clr">
                <span class="col-sm-12 col-md-2 col-lg-2 dis-in-bl pad-cr mar-emt05">账户信息</span>
            </div>
            <div class="binding col-xs-12 bb-1 pad-clr">
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pad-clr binding-tel">
                    <p class="col-xs-12 col-sm-12 col-md-3 col-lg-2 pad-clr">安全手机</p>
                    <p class="col-xs-4 col-sm-4 col-md-3 col-lg-2 pad-cr {{ !empty($userInfo->phone_number) ? 'binded' : 'unbinded'}}">{{ !empty($userInfo->phone_number) ? '已绑定' : '未绑定'}}</p>
                    <p class="col-xs-6 col-sm-3 col-md-5 col-lg-4 pad-clr">{{ !empty($userInfo->phone_number) ? $userInfo->phone_number : ''}}</p>
                    <p class="col-xs-12 col-sm-12 pad-clr fs-c-5">安全手机将可用于登录和修改密码</p>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 pad-clr">
                    <a href="javascript:void(0);" class="btn btn-0 bgc-0 fs-c-4 b-all-2 wid-3 fs-16 zxz" id="changeTel">更换</a>
                </div>
            </div>
            <div class="binding col-xs-12 bb-1 pad-clr">
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pad-clr binding-email">
                    <p class="col-xs-12 col-sm-12 col-md-3 col-lg-2 pad-clr">安全邮箱</p>
                    <p id="emailBinded"
                       class="col-xs-4 col-sm-4 col-md-3 col-lg-2 pad-cr {{ !empty($userInfo->email) ? 'binded' : 'unbinded'}}">{{ !empty($userInfo->email) ? '已绑定' : '未绑定'}}</p>
                    <p id='email'
                       class="col-xs-6 col-sm-3 col-md-5 col-lg-4 pad-clr">{{ !empty($userInfo->email) ? $userInfo->email : ''}}</p>
                    <p class="col-xs-6 col-sm-3 col-md-5 col-lg-4 pad-clr"></p>
                    <p class="col-xs-12 col-sm-12 pad-clr fs-c-5">安全邮箱将可用于登录和修改密码</p>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 pad-clr">
                    <a href="javascript:void(0);" class="btn btn-0 bgc-0 fs-c-4 b-all-2 wid-3 fs-16 zxz"
                       id="changeEmail">{{ !empty($userInfo->email) ? '更换' : '绑定'}}</a>
                </div>
            </div>
            <div class="binding col-xs-12 bb-1 pad-clr">
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pad-clr binding-key">
                    <p class="col-xs-12 col-sm-12 col-md-3 col-lg-2 pad-clr">账号密码</p>
                    <p class="col-xs-12 col-sm-12 pad-clr fs-c-5">用于保护账号信息和登陆安全</p>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 pad-clr">
                    <a href="javascript:void(0);" class="btn btn-0 bgc-0 fs-c-4 b-all-2 wid-3 fs-16 zxz" id="changeKey">修改</a>
                </div>
            </div>

            <!--模态框 开始-->
            <!--修改手机号 开始-->
            <!-- 模态框（Modal） -->
            <div class="modal fade" id="changeTelModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <img src="{{asset('home/images/load.gif')}}" class="loading pull-right">
                    <div class="modal-content">
                        <div class="modal-header bgc-6 fs-c-0">
                            <h4 class="modal-title">修改手机号</h4>
                        </div>
                        <!--每次只出现其中之一-->
                        <!--第一步 获取验证码 开始-->
                        <div class="modal-body tel-step-one">
                            <p class="fs-c-0 fw-1">为了账号安全，需要验证手机有效性</p>
                            <!--发送提示    &    验证错误提示  开始-->
                            <div id="errorBox" class="alert alert-danger hidden">验证码验证失败！</div>
                            <!--////////////////////-->
                            <p id="sendSmsSuccess" class="fs-c-5 hidden">
                                一条包含有验证码的短信已发送至手机：
                                <span class="fs-c-6">{{ isset($accountInfo->tel) ? $accountInfo->tel : ''}}</span>
                            </p>

                            <!--发送提示    &    验证错误提示  结束-->

                            <div class="form-group mar-cb">
                                <div class="col-sm-9 pad-cl">
                                    <input type="text" class="form-control form-title" id="captcha" placeholder="输入验证码">
                                </div>
                                <label for="captcha" id="resend_captcha_label"
                                       class="col-sm-3 control-label line-h-1 hidden  pad-cl">重新发送<span>54</span>秒</label>
                                <div class="col-sm-3 control-label line-h-1" id="resend_captcha">
                                    <button type="button"
                                            class="btn btn-1 bgc-2 fs-c-1 zxz wid-5 border-no resend_captcha">获取短信验证码
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-no h-align-1">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" id="step_one">下一步
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            {{--<p class="mar-emt1"><a class="fs-c-6" href="#">我为何收不到验证码</a></p>--}}
                        </div>
                        <!--第一步 获取验证码 结束-->

                        <!--第二步 填写新手机号 开始-->
                        <div class="modal-body tel-step-two hidden">
                            <div class="my-progress-bar mar-b15">
                                <div>
                                    <div class="change-color">
                                        <div></div>
                                        <p>输入新号码</p>
                                    </div>
                                    <div>
                                        <div></div>
                                        <p>验证新号码</p>
                                    </div>
                                    <div>
                                        <div></div>
                                        <p>完成</p>
                                    </div>
                                </div>
                            </div>

                            <p class="fs-c-0 fw-1">请输入新的手机号</p>

                            <!-- 错误提示 Start-->
                            <div id='errorBox2' class="alert alert-danger hidden">验证码验证失败！</div>
                            <!-- 错误提示 End-->


                            <div class="form-group">
                                <label class="col-xs-12 col-sm-6 control-label pad-cl pad-cr-xs">
                                    <select class="form-control chr-c bg-1">
                                        <option value="+86">中国大陆(+86)</option>
                                    </select>
                                </label>
                                <label class="col-xs-12 col-sm-6 control-label pad-cl-xs pad-cr-xs">
                                    <input id="newTel" type="text" class="form-control form-title" placeholder="手机号">
                                </label>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="modal-footer border-no h-align-1 hidden">
                            <button type="button" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" id="step_two">下一步
                            </button>
                            <button type="button" class="btn btn-default" id="tel_return">返回</button>
                            <button type="button" class="btn btn-default tel_btn_reset pull-right" data-dismiss="modal">
                                取消
                            </button>
                        </div>
                        <!--第二步 填写新手机号 结束-->

                        <!--第三步 验证新手机号-->
                        <div class="modal-body tel-step-three hidden">
                            <div class="my-progress-bar mar-b15">
                                <div>
                                    <div class="change-color">
                                        <div></div>
                                        <p>输入新号码</p>
                                    </div>
                                    <div class="change-color">
                                        <div></div>
                                        <p>验证新号码</p>
                                    </div>
                                    <div>
                                        <div></div>
                                        <p>完成</p>
                                    </div>
                                </div>
                            </div>
                            {{--<p class="fs-c-0 fw-1"> </p>--}}
                            <div></div>
                            <!--发送提示    &    验证错误提示  开始-->
                            <div id="errorBox3" class="alert alert-danger hidden">验证码验证失败！</div>
                            <!--////////////////////-->
                            <p id="sendSmsSuccessTwo" class="fs-c-5 hidden">
                                含有验证码的短信已发送至手机：
                                <span id="newSmsBox" class="fs-c-6"></span>
                            </p>
                            <!--发送提示    &    验证错误提示  结束-->
                            <div class="form-group mar-cb">
                                <div class="col-sm-9 pad-cl">
                                    <input type="text" class="form-control form-title" id="captcha_two"
                                           placeholder="请输入您收到的短信验证码">
                                </div>
                                <label id="resend_captcha_laravel_two" for="captcha_"
                                       class="col-sm-3 control-label line-h-1 hidden">重新发送<span>54</span>秒</label>
                                <div class="col-sm-3 control-label line-h-1 pad-cr pad-cl-xs" id="resend_captcha_two">
                                    <button type="button"
                                            class="btn btn-1 bgc-2 fs-c-1 zxz wid-5 border-no resend_captcha">获取短信验证码
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <p class="fs-c-0 fw-1">请输入右侧图片验证码</p>
                            <div class="form-group mar-b10">
                                <div class="col-sm-9 pad-cl">
                                    <input class="form-control" type="text" id="auth-code" placeholder="请输入右侧图片中的验证码">
                                </div>
                                <div class="col-sm-3 pad-cr pad-cl-xs">
                                    <img id="captcha-new" data-sesid="code" src="{{url('/code/captcha/code')}}">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="modal-footer border-no h-align-1 hidden">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" id="step_three">
                                下一步
                            </button>
                            <button type="button" class="btn btn-default tel_btn_reset" data-dismiss="modal">取消</button>
                        </div>


                        <!--第四步 修改成功-->
                        <div class="modal-body tel-step-four hidden">
                            <div class="my-progress-bar mar-b15">
                                <div>
                                    <div class="change-color">
                                        <div></div>
                                        <p>输入新号码</p>
                                    </div>
                                    <div class="change-color">
                                        <div></div>
                                        <p>验证新号码</p>
                                    </div>
                                    <div class="change-color">
                                        <div></div>
                                        <p>完成</p>
                                    </div>
                                </div>
                            </div>
                            <p class="fs-c-0 fw-1">您已成功修改安全手机</p>
                        </div>
                        <div class="modal-footer border-no h-align-1 pad-ct hidden">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" data-dismiss="modal"
                                    id="step_four">关闭
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
            <!--修改手机号 结束-->

            <!--修改邮箱 开始-->
            <!-- 模态框（Modal） -->
            <div class="modal fade" id="changeEmailModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <img src="{{asset('home/images/load.gif')}}" class="loading pull-right">
                    <div class="modal-content">
                        <div class="modal-header bgc-6 fs-c-0">
                            <h4 class="modal-title">修改邮箱</h4>
                        </div>
                        <!--每次只出现其中之一-->
                        <!--第一步 填写新邮箱-->
                        <div class="modal-body email-step-one">
                            <p class="fs-c-0 fw-1">{{ isset($accountInfo->email) ? '请输入新的邮箱' : '请输入绑定邮箱' }}</p>
                            <!--Email 错误提示 Start-->
                            <div id="errorEmailBox_one" class="alert alert-danger hidden">验证码验证失败！</div>
                            <!--Email 错误提示 End-->
                            <div class="form-group">
                                <label class="col-xs-12 control-label pad-cl">
                                    <input id="newEmail" type="email" class="form-control form-title" placeholder="邮箱">
                                </label>
                            </div>

                        </div>
                        <div class="modal-footer border-no h-align-1">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" id="email_step_one">
                                下一步
                            </button>
                            <button type="button" class="btn btn-default btn_email_reset" data-dismiss="modal">取消
                            </button>
                        </div>
                        <!--第二步 验证新邮箱-->
                        <div class="modal-body email-step-two hidden">
                            <!--发送提示    &    验证错误提示  开始-->
                            <!--Email 错误提示 Start-->
                            <div id="errorEmailBox_two" class="alert alert-danger hidden">验证码验证失败！</div>
                            <!--Email 错误提示 End-->
                            <!--////////////////////-->
                            <p class="fs-c-0 fw-1">我们向: <span id="toEmail">15110313915@qq.com</span>发送了验证邮件<br>请你输入邮箱中的验证码
                            </p>
                            <!--发送提示    &    验证错误提示  结束-->

                            <div class="form-group mar-cb">
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-title" id="captcha_email"
                                           placeholder="验证码">
                                </div>
                                <label id="resend_email_two" for="captcha_"
                                       class="col-sm-3 control-label line-h-1 hidden">重新发送<span>54</span>秒</label>
                                <div class="col-sm-3 control-label line-h-1">
                                    <button type="submit"
                                            class="btn btn-1 bgc-2 fs-c-1 zxz wid-2 border-no resend_captcha"
                                            id="resend_captcha_email">重新发送
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer border-no h-align-1 hidden">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" id="email_step_two">
                                下一步
                            </button>
                            <button type="button" class="btn btn-default" id="email_return">返回</button>
                            <button type="button" class="btn btn-default btn_email_reset pull-right"
                                    data-dismiss="modal">取消
                            </button>
                            {{--<p class="mar-emt1"><a class="fs-c-6" href="#">我为何收不到验证码</a></p>--}}
                        </div>
                        <!--第三步 修改成功-->
                        <div class="modal-body email-step-three hidden">
                            <p class="fs-c-0 fw-1">您已成功修改安全邮箱</p>
                        </div>
                        <div class="modal-footer border-no h-align-1 pad-ct hidden">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" data-dismiss="modal"
                                    id="email_step_three">关闭
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
            <!--修改邮箱 结束-->

            <!--修改密码 开始-->
            <!-- 模态框（Modal） -->
            <div class="modal fade" id="changeKeyModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <img src="{{asset('home/images/load.gif')}}" class="loading pull-right">
                    <div class="modal-content">
                        <div class="modal-header bgc-6 fs-c-0">
                            <h4 class="modal-title">修改密码</h4>
                        </div>
                        <!--每次只出现其中之一-->
                        <!--Email 错误提示 Start-->
                        <div id="errorPasswordBox_one" class="alert alert-danger hidden"></div>
                        <!--Email 错误提示 End-->
                        <!--第一步 填写-->
                        <div class="modal-body key-step-one">
                            <form class="form-horizontal" role="form" method="POST" action="#" accept-charset="UTF-8"
                                  enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="key_old" class="col-xs-12 control-label mar-b5">输入旧密码</label>
                                    <div class="col-xs-12">
                                        <input type="password" class="form-control form-title" placeholder="旧密码"
                                               id="key_old">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="key_old" class="col-xs-12 control-label mar-b5">输入新密码</label>
                                    <div class="col-xs-12">
                                        <input type="password" class="form-control form-title" placeholder="新密码"
                                               id="key_new">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="key_old" class="col-xs-12 control-label mar-b5">重复新密码</label>
                                    <div class="col-xs-12">
                                        <input type="password" class="form-control form-title" placeholder="新密码"
                                               id="key_new_two">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer border-no h-align-1 pad-ct">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" id="key_step_one">
                                确认修改
                            </button>
                            <button type="button" class="btn btn-default btn_password_reset" data-dismiss="modal">取消
                            </button>
                        </div>
                        <!--第二步 结果提示-->
                        <div class="modal-body key-step-two hidden">
                            <p class="fs-c-0 fw-1">您已成功修改密码</p>
                        </div>
                        <div class="modal-footer border-no h-align-1 pad-ct hidden">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs" data-dismiss="modal"
                                    id="key_step_two">关闭
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
            <!--修改密码 结束-->

            <!--模态框 结束  -->

        </div>
        <!--账号设置结束-->
    </div>
    <!--我的主页内容结束-->
@endsection



@section('script')
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/main.js')}}"></script>
    <script src="{{asset('home/js/ajax/ajaxCommon.js')}}"></script>
    {{--用户中心--}}
    <script src="{{asset('home/js/accountSettings.js')}}"></script>
    <script src="{{ asset('home/js/user/index.js') }}"></script>
@endsection
