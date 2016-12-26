@extends('home.layouts.userCenter')

@section('title', '申请创业者')

@section('style')
    <link href="{{ asset('home/css/user_center_identity-info.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!--我的身份开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 identity-info">
        <!--认证投资人开始-->
        <div class="investor">
            <div>
                <span>认证投资人</span>
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
                            <select name="investor_subject" class="form-control chr-c bg-1">
                                <option value="个人">个人</option>
                                <option value="公司">公司</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-area" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资领域</label>
                        <div class="col-md-5">
                            <select name="investor_field" class="form-control chr-c bg-1" id="invest-area">
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
                            <select class="form-control chr-c bg-1" name="investor_stage">
                                <option value="">请选择阶段</option>
                                <option value="1">投资初期</option>
                                <option value="2">投资中期</option>
                                <option value="3">投资后期</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="inputfile" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>上传名片</label>
                        <input type="hidden" name="investor_card_pic">
                        <div class="col-md-5 upload_box">
                            <img  id="investor_card_a" src="{{ asset('home/img/upload_normal.jpg') }}" >
                            {{--公用一个上传input--}}
                            <input type="file" name="card_pic" id="card_upload" style="display: none;">
                            {{--公用一个上传input--}}
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
        <!--认证投资人结束-->

    </div>
    <!--我的身份结束-->
@endsection

@section('script')
    <script src="{{ asset('home/js/user/applyInvestorValidate.js') }}"></script>
    <script src="{{asset('home/js/upload/uploadCommon.js')}}"></script>
    <script>
        //  异步上传身份证照
        var upload = new uploadCommon();
        var originalPic = $(this).attr('src');

        $("#investor_card_a").click(function(){

            $("#card_upload").trigger('click');

            upload.upload({
                inputObj    : $("#card_upload"),
                imgObj      : $("#investor_card_a"),
                url         : '/uploadcard',
                type        : 'POST',
                loadingPic  : '/home/img/loading.gif',
                originalPic : originalPic,
                hideinput   : $("input[name = 'investor_card_pic']")
            });
        });
    </script>
@endsection