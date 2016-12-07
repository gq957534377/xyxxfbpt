@extends('heroHome.layouts.master')

@section('title','用户中心')

@section('style')
    <link href="{{ asset('heroHome/css/user_center_aside.css') }}" rel="stylesheet">
    <link href="{{ asset('heroHome/css/user_center_personal_data.css') }}" rel="stylesheet">
    <link href="{{asset('dateTime/jquery.datetimepicker.css')}}" rel="stylesheet">
    <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('cropper/css/main.css')}}" rel="stylesheet"/>
@endsection

@section('menu')

@endsection

@section('content')
    <!--移动设备menu开始-->
    <div class="container-fluid mobile-aside navbar-fixed-top">
        <span class="dropdown-toggle" data-toggle="dropdown"></span>
        <ul class="list-unstyled dropdown-menu" role="menu">
            <li><a href="#">个人资料</a></li>
            <li><a href="#">我的身份</a></li>
            <li><a href="#">创业大赛报名</a></li>
            <li><a href="#">参加的活动</a></li>
            <li><a href="#">我的投稿</a></li>
            <li><a href="#">我的需求</a></li>
            <li><a href="#">我的收藏</a></li>
            <li><a href="#">账号设置</a></li>
            <li><a href="#">点赞和评论</a></li>
        </ul>
    </div>
    <!--移动设备menu结束-->

    <!--用户中心基本信息开始-->
    <section class="container-fluid">
        <div class="container">
            <div class="row user-center">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                    <aside class="hidden-xs">
                        <ul class="list-unstyled">
                            <li><a href="#">个人资料</a></li>
                            <li><a href="#">我的身份</a></li>
                            <li><a href="#">创业大赛报名</a></li>
                            <li><a href="#">参加的活动</a></li>
                            <li><a href="#">我的投稿</a></li>
                            <li><a href="#">我的需求</a></li>
                            <li><a href="#">我的收藏</a></li>
                            <li><a href="#">账号设置</a></li>
                            <li><a href="#">点赞和评论</a></li>
                        </ul>
                    </aside>
                </div>

                <!--基本信息开始-->
                <div id="userinfo" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 personal-data">
                    <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;display: none;" >
                    <div class="basic-info">
                        <span>基本信息</span>
                        <a href="javascript:void(0);" class="pull-right" id="editBtn">编辑</a>
                        <ul class="list-unstyled">
                            <li>头像<img class="user_avatar img-circle" src="{{ asset('heroHome/img/user_center.jpg') }}"></li>
                            <li>名字<span class="user_name">XXXXXXXXXX</span></li>
                            <li>性别<span class="user_sex">XXXXXXXXXX</span></li>
                            <li>生日<span class="user_birthday">XXXXXXXXXX</span></li>
                            <li>微信<span class="user_webchat">XXXXXXXXXX</span></li>
                            <li>个人信息<span class="user_info">XXXXXXXXXX</span></li>
                        </ul>
                    </div>
                    <div class="company-info">
                        <span>公司信息</span>
                        <a href="#" class="pull-right">编辑</a>
                        <ul class="list-unstyled">
                            <li>在职公司<span>XXXXXXXXXX</span></li>
                            <li>职位<span>XXXXXXXXXX</span></li>
                            <li>所在地<span>XXXXXXXXXX</span></li>
                        </ul>
                    </div>
                </div>
                <!--基本信息结束-->

                <!--基本信息编辑开始 隐藏-->
                <div id="editUserInfo" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 personal-data" style="display: none;">
                    <div class="basic-info">
                        <span>基本信息</span>
                        <a href="#" class="pull-right">保存</a>

                        <div class="mar-b30 col-md-12 col-sm-12" style="padding: 0;margin-top: 30px;">
                            <label for="inputfile" class="col-md-2 control-label line-h hidden-xs hidden-sm" style="padding: 0;font-weight: unset;">头像</label>
                            <div class="col-md-2">
                                @include('heroHome.public.avatar')
                            </div>
                            <div class="col-md-2">
                                <span>点击头像进行更换</span>
                            </div>
                        </div>

                        <form class="form-horizontal personal-data-edit" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                            <div class="form-group mar-b30">
                                <label for="form-title" class="col-md-2 control-label mar-b10">名字</label>
                                <div class="col-md-4">
                                    <input type="text" name="realname" class="form-control" id="form-title" placeholder="">
                                </div>
                            </div>

                            <div class="form-group mar-b30">
                                <label class="col-md-2 control-label mar-b10">性别</label>
                                <div class="col-md-6">
                                    <label class="radio-1">
                                        <input type="radio" name="sex" id="male" class="mar-r5" value="1" checked>男
                                    </label>
                                    <label class="radio-1">
                                        <input type="radio" name="sex" id="female" class="mar-r5" value="2">女
                                    </label>
                                    <label class="radio-1">
                                        <input type="radio" name="sex" id="other-sex" class="mar-r5" value="3">保密
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mar-b15">
                                <span class="col-md-2 control-label mar-b10 dis-in-bl">生日</span>
                                  <div class="col-md-4">
                                      <input type="text" name="birthday" class="form-control pad-clr-xs text-center some_class" id="birthday-year"></div>
                            </div>
                            <div class="form-group mar-b30">
                                <label for="wechat-num" class="col-md-2 control-label mar-b10">微信</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control form-title" id="wechat-num" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mar-b30">
                                <label for="form-introduction" class="col-md-2 control-label mar-b10">个人简介</label>
                                <div class="col-md-8">
                                    <textarea class="form-control text-r ht-8" id="form-introduction" placeholder=""></textarea>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
                <!--基本信息编辑结束-->

            </div>
        </div>
    </section>


    <!--用户中心基本信息结束-->
@endsection



@section('script')
    <script src="{{asset('home/js/jquery.citys.js')}}"></script>
    <script src="{{asset('dateTime/build/jquery.datetimepicker.full.js')}}"></script>
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/main.js')}}"></script>

<script>
    $(document).ready(function (){

        var guid = $('#topAvatar').attr('data-id');
        // 个人资料
        var user_avatar = $(".user_avatar");
        var user_name = $(".user_name");
        var user_sex = $(".user_sex");
        var user_birthday = $(".user_birthday");
        var user_webchat = $(".user_webchat");
        var user_info = $(".user_info");
        // 隐藏个人信息表单
        var hide_avatar = $('#head-pic');
        var hide_realname = $('input[name = "realname"]');
        var hide_sex = $('input[name = "sex"]');
        var hide_birthday = $('input[name = "birthday"]');

        // 异步获取用户数据
        $.ajax({
            type: "GET",
            url: '/user/'+guid,
            beforeSend:function(){
                $(".loading").css({'width':'80px','height':'80px'}).show();
            },
            success: function(msg){
                // 将传过json格式转换为json对象
                switch(msg.StatusCode){
                    case '200':
                        console.log(msg.ResultData);
                        user_avatar.attr('src',msg.ResultData.msg.headpic);
                        user_name.html(msg.ResultData.msg.realname);

                        if (msg.ResultData.msg.sex == 1) {
                            msg.ResultData.msg.sex = '男';
                        } else if(msg.ResultData.msg.sex == 2) {
                            msg.ResultData.msg.sex = '女';
                        } else{
                            msg.ResultData.msg.sex = '保密';
                        }

                        user_sex.html(msg.ResultData.msg.sex);
                        user_birthday.html(msg.ResultData.msg.birthday);
                        user_webchat.html('无');
                        user_info.html('无');

                        hide_avatar.attr('src',msg.ResultData.msg.headpic);
                        hide_realname.empty().val(msg.ResultData.msg.realname);
                        hide_sex.empty().val(msg.ResultData.msg.sex);
                        hide_birthday.empty().val(msg.ResultData.msg.birthday);

                        $(".loading").hide();
                        break;
                    case '400':
                        alert(msg.ResultData);
                        $(".loading").hide();
                        break;
                    case '500':
                        alert(msg.ResultData);
                        $(".loading").hide();
                        break;
                }
            }
        });

        // 编辑页，点击编辑，将Dom元素替换


        $('#editBtn').click(function(){
            $('#userinfo').hide();
            $('#editUserInfo').show();

        });

    });
</script>
@endsection
