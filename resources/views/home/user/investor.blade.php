@extends('home.layouts.userCenter')

@section('title', '申请创业者')

@section('style')
    <link href="{{ asset('home/css/user_center_identity-info.css') }}" rel="stylesheet">
    <link href="{{ asset('home/css/change/zyzn_1.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{--{{ dd(session()->all()) }}--}}
    <!--我的身份开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 identity-info">
        <img src="{{asset('home/img/load.gif')}}" class="loading pull-right">
        <!--认证投资人开始-->
        <div class="investor">
            <div>
                <span>认证投资人</span>
                <form id="applyInvestorForm" class="form-horizontal form-investor" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="investor_role" value="3">
                    <div class="form-group mar-b30">
                        <label for="real-name" class="col-md-2 control-label"><span class="form-star">*</span>真实姓名</label>
                        <div class="col-md-5">
                            <input autofocus name="investor_realname" type="text" maxlength="16" class="form-control form-title" placeholder="请输入您的姓名！" >
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="investors" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>从业年份</label>
                        <div class="col-md-5">
                            <input autofocus name="investor_work_year" type="text" class="form-control form-title" maxlength="2" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="工龄，请填写两位以内的数字">
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资规模</label>
                        <div class="col-md-5">
                            <input autofocus name="investor_scale" type="text" class="form-control form-title" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="投资规模，请填写数字,单位（万）">
                        </div>
                        <div class="col-md-2 scaleSuffix">万</div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>所在公司</label>
                        <div class="col-md-5">
                            <input autofocus name="investor_company" type="text" class="form-control form-title" placeholder="请输入所在公司">
                        </div>
                    </div>


                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>所在地</label>
                        <div id="companyAddress" class="col-md-5 " class="citys">
                            <p>
                                <select class="form-control form-title" name="province"></select> <br>
                                <select class="form-control" name="city"></select> <br>
                                <select class="form-control" name="area"></select>
                            </p>
                            <input id="address" class="form-control" name="investor_company_address" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-area" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资领域</label>
                        <div class="col-md-5">
                            {{--<select name="investor_field" class="form-control chr-c bg-1" id="invest-area">--}}
                                {{--<option value="">请选择领域</option>--}}
                                {{--<option value="互联网">互联网</option>--}}
                                {{--<option value="餐饮业">餐饮业</option>--}}
                                {{--<option value="旅游业">旅游业</option>--}}
                            {{--</select>--}}
                            <input class="nation form-control chr-c bg-1" name="investor_field" data-value="" onclick="appendhybar(this,'duoxuan');" type="text" placeholder="请选择投资领域">
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="inputfile" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>上传名片</label>
                        <input type="hidden" name="investor_card_pic">
                        <div class="col-md-5 upload_box">
                            <img  id="investor_card_a" src="{{ asset('home/img/upload_normal.jpg') }}" >
                            {{--公用一个上传input--}}
                            <input type="file" name="card_pic" id="card_upload">
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
    <script src="{{asset('home/js/jquery.citys.js')}}"></script>
    <script src="{{ asset('home/js/user/applyInvestorValidate.js') }}"></script>
    <script src="{{asset('home/js/upload/uploadCommon.js')}}"></script>
    <script src="{{asset('home/js/ajax/ajaxCommon.js')}}"></script>
    <script src="{{asset('home/js/change/load_hycode.js')}}"></script>
    <script src="{{asset('home/js/change/hgz_hycode.js')}}"></script>
    {{--<script src="{{asset('home/js/change/hgz_zncode.js')}}"></script>--}}
    <script>
        //  异步上传身份证照
        var upload = new uploadCommon();
        var ajax = new ajaxCommon();
        $("#investor_card_a").click(function(){

            $("#card_upload").trigger('click');

            upload.upload({
                inputObj    : $("#card_upload"),
                imgObj      : $("#investor_card_a"),
                url         : '/uploadcard',
                type        : 'POST',
                loadingPic  : '/home/img/loading.gif',
                hideinput   : $("input[name = 'investor_card_pic']")
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

        $('input[name = "card_pic"]').change(function(){
            console.log($(this).context.files[0].size);
            var fileSize=$(this).context.files[0].size;
            var maxSize = 2*1024*1024;
            if(fileSize > maxSize){
                alert("请上传大小在2M以下的图片");
                return false;
            }else{
                return true;
            }
        });


        // 获取用户真实姓名
        ajax.ajax({
            url      :   '/user/realname' + '/'+$('#topAvatar').data('id'),
            type     :   'GET',
            beforeSend: ajaxBeforeSend($('.loading')),
            success  :   function(msg){
                ajaxAfterSend($('.loading'));
               switch (msg.StatusCode){
                   case '400':
                       $('input[name="investor_realname"]').attr('disabled', false);
                       break;
                   case '200':
                       if (msg.ResultData.realname.length <= 0) {
                           $('input[name="investor_realname"]').attr('disabled', false);
                       }else {
                           $('input[name="investor_realname"]').val(msg.ResultData.realname).attr('disabled', true);
                       }

                       break;
               }
            },
        });

    </script>
@endsection