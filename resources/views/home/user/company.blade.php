@extends('home.layouts.userCenter')

@section('title', '申请创业者')

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/user_center_my_company.css') }}">
@endsection

@section('content')
    <!--我管理的公司开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 my-company">
        <div class="basic-info">
            <span>我管理的公司</span>

            <form class="form-horizontal my-company-edit" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">

                <div class="form-group mar-b30">
                    <label for="form-title" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">*</span>公司名字</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="form-title" placeholder="">
                    </div>
                </div>
                <div class="form-group mar-b30">
                    <label for="wechat-num" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">&nbsp;</span>公司简称</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control form-title" id="wechat-num" placeholder="">
                    </div>
                </div>

                <div class="form-group mar-b15">
                    <span class="col-md-3 col-lg-2 control-label mar-b10 dis-in-bl"><span class="form-star">&nbsp;</span>所在地</span>
                    <div class="col-md-6 pad-cl">
                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <select class="form-control chr-c bg-2" id="work-province">
                                <option value="">北京市</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <label for="work-province" class="col-xs-1 col-sm-1 col-md-1 control-label pad-clr h-align line-h-1">省</label>
                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <select class="form-control chr-c bg-2" id="work-city">
                                <option value="">北京市</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <label for="work-city" class="col-xs-1 col-sm-1 col-md-1 control-label pad-cl line-h-1">市</label>
                    </div>
                </div>
                <div class="form-group mar-b30 mar-b15-xs">
                    <div class="col-xs-9 col-sm-10 col-md-offset-3  col-lg-offset-2 col-md-6">
                        <input type="text" class="form-control form-title" id="work-road" placeholder="">
                    </div>
                    <label for="work-road" class="col-xs-3 col-sm-1 col-md-2 col-lg-2 control-label pad-clr line-h-1">街道</label>
                </div>

                <div class="form-group mar-b30 mar-b15-xs">
                    <label for="work-company" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">&nbsp;</span>创始人姓名</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="work-company" placeholder="">
                    </div>
                </div>
                <div class="form-group mar-b30 mar-b15-xs">
                    <label for="work-position" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">&nbsp;</span>公司网址</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control form-title" id="work-position" placeholder="">
                    </div>
                </div>

                <div class="form-group mar-b30 line-h-3">
                    <label for="invest-area" class="col-sm-12 col-md-3 col-lg-2 control-label pad-cr mar-xs--b"><span class="form-star">*</span>领域</label>
                    <div class="col-sm-8 col-md-6">
                        <select class="form-control chr-c bg-1" id="invest-area">
                            <option value="">请选择领域</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mar-b30">
                    <label for="upload-certificate" class="col-md-3 col-lg-3 control-label pad-cr mar-xs--b"><span class="form-star">*</span>组织机构代码证</label>
                    <input type="hidden" name="organize_card">
                    <div class="organize_card_box col-md-6 move-front">
                        <img  id="organize_card_img" src="{{ asset('home/img/upload_normal.jpg') }}" >
                        {{--公用一个上传input--}}
                        <input type="file" name="card_pic" id="card_upload" style="display: none;">
                        {{--公用一个上传input--}}
                    </div>
                </div>

                <div class="form-group mar-b30">
                    <div class="col-md-offset-3 col-lg-offset-2 col-md-6">
                        <a href="javascript:void(0)" class="btn fs-15 btn-1 bgc-2 fs-c-1 zxz border-no" role="button" id="submit_my_company">提交</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--我管理的公司结束-->
@endsection

@section('script')
    <script src="{{asset('home/js/jquery.citys.js')}}"></script>
    <script src="{{asset('home/js/upload/uploadCommon.js')}}"></script>
    <script>
        //  异步上传身份证照
        var upload = new uploadCommon();
        var originalPic = $(this).attr('src');

        $("#organize_card_img").click(function(){

            $("#card_upload").trigger('click');

            upload.upload({
                inputObj    : $("#card_upload"),
                imgObj      : $("#organize_card_img"),
                url         : '/uploadcard',
                type        : 'POST',
                loadingPic  : '/home/img/loading.gif',
                originalPic : originalPic,
                hideinput   : $("input[name = 'organize_card']")
            });
        });
    </script>
@endsection