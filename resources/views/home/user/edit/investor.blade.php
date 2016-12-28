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
                            <input autofocus  type="text" class="form-control form-title" value="{{ $roleInfo->realname }}" disabled>
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="investors" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>从业年份</label>
                        <div class="col-md-5">
                            <input autofocus type="text" class="form-control form-title" maxlength="2" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="{{ $roleInfo->work_year }} 年" disabled>
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资规模</label>
                        <div class="col-md-5">
                            <input autofocus name="investor_scale" type="text" class="form-control form-title" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="{{ $roleInfo->scale }} 万" placeholder="投资规模，请填写数字,单位（万">
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>所在公司</label>
                        <div class="col-md-5">
                            <input autofocus type="text" class="form-control form-title" value="{{ $roleInfo->company }}" disabled >
                        </div>
                    </div>


                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>所在地</label>
                        <div class="col-md-5">
                            <input autofocus type="text" class="form-control form-title" value="{{ $roleInfo->company_address }}" disabled >
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-area" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资领域</label>
                        <div class="col-md-5">
                            <select name="investor_field" class="form-control chr-c bg-1" id="invest-area">
                                <option value="">请选择领域</option>
                                <option value="互联网">互联网</option>
                                <option value="餐饮业">餐饮业</option>
                                <option value="旅游业">旅游业</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="inputfile" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>上传名片</label>
                        <div class="col-md-5 upload_box">
                            <img src="{{ $roleInfo->card_pic_a or asset('home/img/upload_normal.jpg') }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <!--col-sm-offset-2-->
                        <div class="col-xs-4 col-sm-3 col-md-offset-2 col-md-2">
                            <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">保存</button>
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

@endsection