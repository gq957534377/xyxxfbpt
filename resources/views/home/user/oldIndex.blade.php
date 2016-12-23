@extends('home.layouts.userCenter')

@section('title','用户中心')

@section('style')
    <link href="{{ asset('home/css/user_center_personal_data.css') }}" rel="stylesheet">
    <link href="{{asset('dateTime/jquery.datetimepicker.css')}}" rel="stylesheet">
    <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
    {{--<link href="{{asset('cropper/css/main.css')}}" rel="stylesheet"/>--}}
    <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
@endsection

@section('content')
    <!--用户中心基本信息开始-->
    <!--基本信息开始-->
    <div id="userinfo" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 personal-data">
        <img src="{{asset('home/img/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;display: none;" >
        <div class="basic-info">
            <span>基本信息</span>
            <a href="javascript:void(0);" class="pull-right" id="editBtn">编辑</a>
            <ul class="list-unstyled">
                <li>头像
                    {{--<img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}">--}}
                    <div class="ibox-content" style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                        <div class="row">
                            <div id="crop-avatar">
                                <div class="avatar-view" title="" style="width: 70px;border: none;border-radius: 0px;box-shadow: none;">
                                    <img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}" alt="Logo" style="margin-left: 0px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>昵称<span class="user_nickname">XXXXXXXXXX</span></li>
                <li>名字<span class="user_name">XXXXXXXXXX</span></li>
                <li>性别<span class="user_sex">XXXXXXXXXX</span></li>
                <li>生日<span class="user_birthday">XXXXXXXXXX</span></li>
                {{--<li>微信<span class="user_webchat">XXXXXXXXXX</span></li>--}}
                <li>个人信息<span class="user_info">XXXXXXXXXX</span></li>
            </ul>
        </div>
        <div class="company-info">
            <span>公司信息</span>
            <a href="#" id="editCompanyBtn" class="pull-right">编辑</a>
            <ul class="list-unstyled">
                <li>在职公司<span class="user_company">XXXXXXXXXX</span></li>
                <li>职位<span class="user_company_position">XXXXXXXXXX</span></li>
                <li>所在地<span class="user_company_address">XXXXXXXXXX</span></li>
            </ul>
        </div>
    </div>
    <!--修改头像弹出框 Start-->
    @include('home.public.avatar')
    <!--修改头像弹出框 End-->

    <!--基本信息结束-->

    <!--基本信息编辑开始 隐藏-->
    <div id="editUserInfo" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 personal-data" style="display: none;">
        <img src="{{asset('home/img/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;display: none;" >
        <div class="basic-info">
            <span>基本信息</span>
            <a href="#" class="pull-right" id="editRevoke" style="padding-left: 5px;">取消</a>
            <a href="#" class="pull-right" id="editSubmit">保存</a>

            <form class="form-horizontal personal-data-edit" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">

                <div class="form-group mar-b30">
                    <label for="form-title" class="col-md-2 control-label mar-b10">昵称</label>
                    <div class="col-md-4">
                        <input type="text" name="nickname" class="form-control" id="form-title" placeholder="">
                    </div>
                </div>

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
                            <input type="radio" name="sex" id="male" class="mar-r5" value="1" data-sex="1">男
                        </label>
                        <label class="radio-1">
                            <input type="radio" name="sex" id="female" class="mar-r5" value="2" data-sex="2">女
                        </label>
                        <label class="radio-1">
                            <input type="radio" name="sex" id="other-sex" class="mar-r5" value="3" data-sex="3">保密
                        </label>
                    </div>
                </div>

                <div class="form-group mar-b15">
                    <span class="col-md-2 control-label mar-b10 dis-in-bl">生日</span>
                      <div class="col-md-4">
                          <input type="text" name="birthday" class="form-control pad-clr-xs date-time" id="birthday-year"></div>
                </div>
                {{--<div class="form-group mar-b30">--}}
                    {{--<label for="wechat-num" class="col-md-2 control-label mar-b10">微信</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input type="text" name="wechat" class="form-control form-title" id="wechat-num" placeholder="微信号">--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="form-group mar-b30">
                    <label for="form-introduction" class="col-md-2 control-label mar-b10">个人简介</label>
                    <div class="col-md-4">
                        <textarea name="introduction" class="form-control text-r ht-8" id="form-introduction" placeholder="" style="overflow: hidden;word-wrap: break-word; resize:horizontal;"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--基本信息编辑隐藏 结束-->
    <!--公司信息编辑隐藏 开始-->
    <div id="editCompanyInfo" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 personal-data" style="display: none;">
        <div class="basic-info">
            <span>公司信息</span>
            <a href="#" class="pull-right" id="editCompanyRevoke" style="padding-left: 5px;">取消</a>
            <a href="#" id="editCompanySubmit" class="pull-right">保存</a>
            <form class="form-horizontal personal-data-edit" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                <div class="form-group mar-b30 mar-b15-xs">
                    <label for="work-company" class="col-md-2 control-label mar-b10">在职公司</label>
                    <div class="col-md-6">
                        <input name="company" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group mar-b30 mar-b15-xs">
                    <label for="work-position" class="col-md-2 control-label mar-b10">职位</label>
                    <div class="col-md-6">
                        <input name="company_position" type="text" class="form-control form-title">
                    </div>
                </div>
                <div class="form-group mar-b30 mar-b15-xs">
                    <span class="col-md-2 control-label mar-b10 dis-in-bl">所在城市</span>
                    <div class="col-md-8">
                        <div id="companyAddress" class="col-md-9 pad-cl" class="citys">
                            <p>
                                <select class="form-control form-title" name="province"></select> <br>
                                <select class="form-control" name="city"></select> <br>
                                <select class="form-control" name="area"></select>
                            </p>
                            <input id="place" class="form-control" name="company_address" value="" type="text" readonly>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--公司信息编辑隐藏 结束-->
    <!--用户中心基本信息结束-->
@endsection



@section('script')
    <script src="{{asset('home/js/jquery.citys.js')}}"></script>
    <script src="{{asset('dateTime/build/jquery.datetimepicker.full.js')}}"></script>
    <script src="{{asset('home/js/dateTime.js')}}"></script>
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/main.js')}}"></script>
    <script src="{{asset('home/js/ajax/ajaxCommon.js')}}"></script>
    {{--用户中心--}}
    <script src="{{ asset('home/js/user/index.js') }}"></script>

@endsection