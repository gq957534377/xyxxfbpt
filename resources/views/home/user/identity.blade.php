@extends('home.layouts.master')

@section('title', '我的身份')

@section('style')
    <link href="{{ asset('home/css/user_center_identity-info.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!--移动设备menu开始-->
    @include('home.user.mobileSidebar')
    <!--移动设备menu结束-->
    <section class="container-fluid">
        <div class="container test">
            <div class="row user-center">
                @include('home.user.pcSideBar')
                {{--{{ dd(session('user')) }}--}}
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
                </div>
                <!--我的身份结束-->

            </div>
        </div>
    </section>
    <!--用户中心我的身份结束-->
@endsection

@section('script')
<script>
    // tabs 切换
    $('.tabs_btn').click(function(){
        $(this).addClass('active').siblings().removeClass('active');

        if ($(this).data('status') == 1) {
            $("#hide_syb").show();
            $("#hide_investor").hide();
        } else {
            $("#hide_syb").hide();
            $("#hide_investor").show();
        }
    });

    //
    $('#sybSubmit').click(function(){

    });
</script>
@endsection
