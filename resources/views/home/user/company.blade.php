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

            <form id="companyForm" class="form-horizontal my-company-edit" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">

                <div class="form-group mar-b30">
                    <label for="form-title" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">*</span>公司名字</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="company" placeholder="请输入公司名称">
                    </div>
                </div>
                <div class="form-group mar-b30">
                    <label for="wechat-num" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">&nbsp;</span>公司简称</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control form-title" name="abbreviation" placeholder="">
                    </div>
                </div>

                <div class="form-group mar-b15">
                    <span class="col-md-3 col-lg-2 control-label mar-b10 dis-in-bl"><span class="form-star">&nbsp;</span>所在地</span>
                    <div class="col-md-8">
                        <div id="companyAddress" class="col-md-9 pad-cl" class="citys">
                            <p>
                                <select class="form-control form-title" name="province"></select> <br>
                                <select class="form-control" name="city"></select> <br>
                                <select class="form-control" name="area"></select>
                            </p>
                            <input id="address" class="form-control" name="address" type="text" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group mar-b30 mar-b15-xs">
                    <label for="work-company" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">&nbsp;</span>创始人姓名</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="founder_name" placeholder="">
                    </div>
                </div>
                <div class="form-group mar-b30 mar-b15-xs">
                    <label for="work-position" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">&nbsp;</span>公司网址</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control form-title" name="url" placeholder="">
                    </div>
                </div>

                <div class="form-group mar-b30 line-h-3">
                    <label for="invest-area" class="col-sm-12 col-md-3 col-lg-2 control-label pad-cr mar-xs--b"><span class="form-star">*</span>领域</label>
                    <div class="col-sm-8 col-md-6">
                        <select class="form-control chr-c bg-1" name="field">
                            <option value="">请选择领域</option>
                            <option value="1">互联网</option>
                            <option value="2">餐饮业</option>
                            <option value="3">服务业</option>
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
                        <button href="javascript:void(0)" class="btn fs-15 btn-1 bgc-2 fs-c-1 zxz border-no" type="submit" >提交</button>
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
    <script src="{{asset('home/js/user/companyValidate.js')}}"></script>
    <script>
        //  异步上传身份证照
        var upload = new uploadCommon();
        var originalPic = $("#organize_card_img").attr('src');

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

        // 城市联动
        $('#companyAddress').citys({
            required: false,
            nodata: 'disabled',
            onChange: function (data) {
                var text = data['direct'] ? '(直辖市)' : '';
                $('#address').val(data['province'] + text + ' ' + data['city'] + ' ' + data['area']);
            }
        });
    </script>
@endsection