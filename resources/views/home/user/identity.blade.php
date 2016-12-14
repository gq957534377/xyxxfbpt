@extends('home.layouts.userCenter')

@section('title', '我的身份')

@section('style')
    <link href="{{ asset('home/css/user_center_identity-info.css') }}" rel="stylesheet">
    <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
@endsection

@section('content')
    <!--我的身份开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 identity-info">
        <div class="tab-info-top">
            <a href="#" class="tabs_btn active" data-status="1">我是创业者<span class="triangle-down"></span></a>
            <a href="#" class="tabs_btn" data-status="0">我是投资人<span class="triangle-down"></span></a>
        </div>

        <!--申请成为创业者开始-->
        <div class="pad-4 bgc-1" id="hide_syb">
            <div class="center-block wid-1-xs wid-1-sm wid-1 pad-eml6 pad-cl-xs pad-emt6-xs auth-entre">
                <p class="mar-b5 fw-1 fs-15">申请成为创业者</p>
                <p class="mar-cb text-left fs-12">成为创业者后才可以创建项目，并开始报名参加大赛，同时获得投资人的关注！</p>
                <a href="#" class="btn btn-default btn-1 fs-15 mar-1 bgc-2 fs-c-1 border-no auth-entre-btn" role="button" id="sybSubmit">立即申请</a>
            </div>
        </div>
        <!--申请成为创业者结束-->

        <!--申请成为创业者开始-->
        <div class="pad-4 bgc-1" id="hide_investor" style="display: none;">
            <div class="center-block wid-1-xs wid-1-sm wid-1 pad-eml6 pad-cl-xs pad-emt6-xs auth-entre">
                <p class="mar-b5 fw-1 fs-15">申请成为投资人</p>
                <p class="mar-cb text-left fs-12">成为投资人后才可以创建项目，并开始报名参加大赛，同时获得投资人的关注！</p>
                <a href="#" class="btn btn-1 fs-15 mar-1 bgc-2 fs-c-1 border-no auth-entre-btn" role="button" id="investorSubmit">立即申请</a>
            </div>
        </div>

        <!--申请成为创业者结束-->

        <!--申请成为创业者表单开始-->
        <div class="investor" id="sybBox" style="display: none;">
            <div>
                <span>认证创业者</span>
                <img src="{{asset('home/img/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;display: none;" >
                <form id="applySybForm" class="form-horizontal form-investor" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="role" value="2">
                    <div class="form-group mar-b30">
                        <label for="real-name" class="col-md-2 control-label"><span class="form-star">*</span>真实姓名</label>
                        <div class="col-md-5">
                            <input autofocus name="syb_realname" type="text" class="form-control form-title" id="real-name" placeholder="请输入您的姓名！">
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="investors" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>创业主体</label>
                        <div class="col-md-5">
                            <select id="syb_subject" name="syb_subject" class="form-control chr-c bg-1">
                                <option value="1">个人</option>
                                <option value="2">公司</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="mobile-tel" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>手机号码</label>
                        <div class="col-md-5">
                            <input name="syb_tel" type="text" class="form-control" placeholder="请输入您的手机号！">
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="identity-num" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>身份证号</label>
                        <div class="col-md-5">
                            <input name="syb_card" type="text" class="form-control" placeholder="请输入您的身份证号！">
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="invest-area" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>创业领域</label>
                        <div class="col-md-5">
                            <select id="syb_field" name="syb_field" class="form-control chr-c bg-1">
                                <option value="">请选择领域</option>
                                <option value="1">互联网</option>
                                <option value="2">餐饮业</option>
                                <option value="3">旅游业</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>创业阶段</label>
                        <div class="col-md-5">
                            <select id="syb_stage" name="syb_stage" class="form-control chr-c bg-1">
                                <option value="">请选择阶段</option>
                                <option value="1">准备创业</option>
                                <option value="2">创业初期</option>
                                <option value="3">创业晋升期</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="inputfile" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>上传身份证（正面）</label>
                        <input type="hidden" name="syb_card_pic">
                        <div class="col-md-5">
                            <div class="ibox-content">
                                <div class="row">
                                    <div id="crop-avatar" class="col-md-6">
                                        <div class="avatar-view" title="">
                                            <img src="{{ asset('home/img/upload-card.png') }}" alt="Logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--col-sm-offset-2-->
                        <div class="col-xs-4 col-sm-3 col-md-offset-2 col-md-2">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">提交认证</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--申请成为创业者表单结束-->

        <!--申请成为投资者表单开始-->
        <div class="investor" id="investorBox" style="display: none;">
            <div>
                <span>认证投资者</span>
                <img src="{{asset('home/img/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;display: none;" >
                <form id="applyInvestorForm" class="form-horizontal form-investor" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="investor_role" value="3">
                    <div class="form-group mar-b30">
                        <label for="real-name" class="col-md-2 control-label"><span class="form-star">*</span>真实姓名</label>
                        <div class="col-md-5">
                            <input autofocus name="investor_realname" type="text" class="form-control form-title" placeholder="请输入您的姓名！">
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="investors" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资主体</label>
                        <div class="col-md-5">
                            <select id="investor_subject" class="form-control chr-c bg-1">
                                <option value="1">个人</option>
                                <option value="2">公司</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="mobile-tel" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>手机号码</label>
                        <div class="col-md-5">
                            <input name="investor_tel" type="text" class="form-control" placeholder="请输入您的手机号！">
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="identity-num" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>身份证号</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="investor_card" placeholder="请输入您的身份证号！">
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="invest-area" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资领域</label>
                        <div class="col-md-5">
                            <select id="investor_field" name="investor_field" class="form-control chr-c bg-1" >
                                <option value="">请选择领域</option>
                                <option value="1">互联网</option>
                                <option value="2">餐饮业</option>
                                <option value="3">旅游业</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资阶段</label>
                        <div class="col-md-5">
                            <select id="investor_stage" name="investor_stage" class="form-control chr-c bg-1" >
                                <option value="">请选择阶段</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="inputfile" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>上传名片</label>
                        <div class="col-md-5">
                            <input type="hidden" name="investor_card_pic">
                            <div class="col-md-5">
                                <div class="ibox-content">
                                    <div class="row">
                                        <div id="crop-avatar2" class="col-md-6">
                                            <div class="avatar-view" title="">
                                                <img src="{{ asset('home/img/upload-card.png') }}" alt="Logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--col-sm-offset-2-->
                        <div class="col-xs-4 col-sm-3 col-md-offset-2 col-md-2">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz" id="btn-1">提交认证</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--申请成为投资者表单结束-->

        @include('home.public.card')
    </div>
    <!--我的身份结束-->
@endsection

@section('script')
    <script src="{{ asset('home/js/user/applySybValidate.js') }}"></script>
    <script src="{{ asset('home/js/user/applyInvestorValidate.js') }}"></script>
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/sitelogo.js')}}"></script>
<script>
    // tabs 切换
    $('.tabs_btn').click(function(){
        $(this).addClass('active').siblings().removeClass('active');

        if ($(this).data('status') == 1) {
            $("#hide_investor").hide();
            $("#investorBox").hide();
            $("#sybBox").hide();
            $("#hide_syb").show();
        } else {
            $("#hide_syb").hide();
            $("#sybBox").hide();
            $("#investorBox").hide();
            $("#hide_investor").show();
        }
    });
    // 点击申请切换到，申请提交表单页
    $('#sybSubmit').click(function(){
        $("#hide_syb").hide();
        $("#sybBox").show();
    });
    $('#investorSubmit').click(function(){
        $("#hide_syb").hide();
        $("#hide_investor").hide();
        $("#investorBox").show();
    });
    // 异步提交申请

</script>
@endsection
