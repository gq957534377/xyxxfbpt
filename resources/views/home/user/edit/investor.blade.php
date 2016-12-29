@extends('home.layouts.userCenter')

@section('title', '申请创业者')

@section('style')
    <link href="{{ asset('home/css/user_center_identity-info.css') }}" rel="stylesheet">
    <link href="{{ asset('home/css/change/zyzn_1.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!--我的身份开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 identity-info">
        <img src="{{asset('home/img/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;display: none;" >
        <!--认证投资人开始-->
        <div class="investor">
            <div>
                <span>认证投资人</span>
                <form id="applyInvestorForm" class="form-horizontal form-investor" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="investor_role" value="3">
                    <input type="hidden" name="investor_id" value="{{ empty(session('roleInfo')[3]->id) ? '--' : session('roleInfo')[3]->id }}">
                    <div class="form-group mar-b30">
                        <label for="real-name" class="col-md-2 control-label"><span class="form-star">*</span>真实姓名</label>
                        <div class="col-md-5">
                            <input autofocus  type="text" class="form-control form-title" value="{{ empty(session('roleInfo')[3]->realname) ? '--' : session('roleInfo')[3]->realname }}" disabled>
                        </div>
                    </div>
                    <div class="form-group mar-b30">
                        <label for="investors" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>从业年份</label>
                        <div class="col-md-5">
                            <input autofocus type="text" class="form-control form-title" maxlength="2" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="{{ empty(session('roleInfo')[3]->work_year) ? '--' : session('roleInfo')[3]->work_year }} 年" disabled>
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资规模</label>
                        <div class="col-md-5">
                            <input autofocus name="investor_scale" type="text" class="form-control form-title" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="{{ empty(session('roleInfo')[3]->scale) ? '--' : session('roleInfo')[3]->scale }}" placeholder="投资规模，请填写数字,单位（万">
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>所在公司</label>
                        <div class="col-md-5">
                            <input autofocus type="text" class="form-control form-title" value="{{ empty(session('roleInfo')[3]->company) ? '--' : session('roleInfo')[3]->company }}" disabled >
                        </div>
                    </div>


                    <div class="form-group mar-b30">
                        <label for="invest-step" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>所在地</label>
                        <div class="col-md-5">
                            <input autofocus type="text" class="form-control form-title" value="{{ empty(session('roleInfo')[3]->company_address) ? '--' : session('roleInfo')[3]->company_address }}" disabled >
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="invest-area" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>投资领域</label>
                        <div class="col-md-5">
                            <input class="nation form-control chr-c bg-1" name="investor_field" data-value="" onclick="appendhybar(this,'duoxuan');" type="text" placeholder="请选择投资领域" value="{{ empty(session('roleInfo')[3]->field) ? '--' : session('roleInfo')[3]->field }}">
                        </div>
                    </div>

                    <div class="form-group mar-b30">
                        <label for="inputfile" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>上传名片</label>
                        <div class="col-md-5 upload_box">
                            <img src="{{ empty(session('roleInfo')[3]->card_pic_a) ? '--' : session('roleInfo')[3]->card_pic_a }}" >
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
    <script src="{{ asset('home/js/change/load_hycode.js') }}"></script>
    <script src="{{ asset('home/js/change/hgz_hycode.js') }}"></script>
    <script src="{{ asset('home/js/user/editInvestorValidate.js') }}"></script>
@endsection