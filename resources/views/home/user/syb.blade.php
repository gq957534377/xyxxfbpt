@extends('home.layouts.userCenter')

@section('title', '申请创业者')

@section('style')
    <link href="{{ asset('home/css/user_center_my_entrepreneur.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!--认证创业者开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 my-education">
        <img src="{{asset('home/img/load.gif')}}" class="loading pull-right" >
        <div class="basic-info">
            <span>认证创业者</span>

            <form id="applySybForm" class="form-horizontal my-education-edit" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                <input type="hidden" name="role" value="2">
                <input type="hidden" name="nowDate" value="{{ date('Y') }}">
                <div class="form-group mar-b30">
                    <label for="form-title" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">*</span>真实姓名</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="syb_realname" placeholder="">
                    </div>
                </div>

                <div class="form-group mar-b15 line-h-3">
                    <span class="col-md-3 col-lg-2 control-label mar-b10 dis-in-bl mar-xs--b"><span class="form-star">*</span>上传身份证</span>
                    <div class="col-md-9 col-lg-10 fs-15">
                        <div class="row mar-clr upload-specification">
                            <p class="col-xs-12 pad-cl">上传规范<br></p>
                            <p class="col-xs-12 pad-cl mar-cb">1.请确保身份证处于有效期内</p>
                            <p class="col-xs-12 pad-cl">2.横向拍摄，确保身份证照片完整、清晰</p>
                            <div class="col-xs-12 col-sm-offset-2 col-sm-10 upload_card_box">
                                <img src="{{ asset('home/img/demoimg/zhengmian.jpg') }}">
                                <img src="{{ asset('home/img/demoimg/fanmian.jpg') }}">
                            </div>
                            <p class="col-xs-12 pad-clr"><br>第一步：上传正面<br></p>
                            <input type="hidden" name="syb_card_a">
                            <div class="col-xs-12 col-sm-8 pad-clr upload-active bgc-6">
                                <img id="syb_card_a" src="{{ asset('home/img/upload_normal.jpg') }}">
                            </div>

                            <p class="col-xs-12 pad-clr"><br>第二步：上传背面<br></p>
                            <input type="hidden" name="syb_card_b">
                            <div class="col-xs-12 col-sm-8 pad-clr upload-active bgc-6">
                                <img  id="syb_card_b" src="{{ asset('home/img/upload_normal.jpg') }}" >
                                {{--公用一个上传input--}}
                                <input type="file" name="card_pic" id="card_upload">
                                {{--公用一个上传input--}}

                            </div>

                        </div>
                    </div>
                </div>
                <p class="fs-16 fs-c-5"><br>请完善其他信息<br><br></p>

                <div class="form-group mar-b30 line-h-3">
                    <label for="institutions_address" class="col-sm-12 col-md-3 col-lg-2 control-label pad-cr mar-xs--b"><span class="form-star">*</span>所在院校</label>
                    <div class="col-sm-8 col-md-6 mar-b10">
                        {{--<select class="form-control chr-c bg-1" name="syb_school_address">--}}
                            {{--<option value="">请选择院校所在省</option>--}}
                            {{--<option value="湖北省">湖北省</option>--}}
                            {{--<option value="江西省">江西省</option>--}}
                        {{--</select>--}}
                        <input type="text" class="form-control form-title" name="syb_school_address" placeholder="请选择院校所在省">
                    </div>
                    <label for="institutions_name" class="hidden"></label>
                    <div class="col-md-offset-3 col-lg-offset-2 col-sm-8 col-md-6">
                        {{--<select class="form-control chr-c bg-1" name="syb_school_name">--}}
                            {{--<option value="">请选择所在院校</option>--}}
                            {{--<option value="武汉大学">武汉大学</option>--}}
                            {{--<option value="江西财经大学">江西财经大学</option>--}}
                        {{--</select>--}}
                        <input type="text" class="form-control form-title" name="syb_school_name" placeholder="请选择所在院校">
                    </div>
                </div>

                <div class="form-group mar-b30 mar-b15-xs">
                    <label for="work-position" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">*</span>专业名称</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control form-title" name="syb_major" placeholder="请输入专业名称">
                    </div>
                </div>

                <div class="form-group mar-b30">
                    <label for="wechat-num" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">*</span>入学时间</label>
                    <div class="col-md-6">
                        <input type="text" name="syb_start_school" class="form-control form-title" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="例如：2016">
                    </div>
                </div>

                <div class="form-group mar-b30 mar-b15-xs">
                    <label for="work-company" class="col-md-3 col-lg-2 control-label mar-b10"><span class="form-star">*</span>毕业时间</label>
                    <div class="col-md-6">
                        <input type="text" name="syb_finish_school" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="例如：2016">
                    </div>
                </div>

                <div class="form-group mar-b30 line-h-3">
                    <label for="institutions_education" class="col-sm-12 col-md-3 col-lg-2 control-label pad-cr mar-xs--b"><span class="form-star">*</span>学历</label>
                    <div class="col-sm-8 col-md-6 mar-b10">
                        <select class="form-control chr-c bg-1" name="syb_education">
                            <option value="">请选择学历</option>
                            <option value="高中">高中</option>
                            <option value="大专">大专</option>
                            <option value="本科">本科</option>
                            <option value="硕士">硕士</option>
                            <option value="博士">博士</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mar-b30">
                    <div class="col-md-offset-3 col-lg-offset-2 col-md-6">
                        <button href="javascript:void(0)" class="btn fs-15 btn-1 bgc-2 fs-c-1 zxz border-no" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!--认证创业者结束-->
@endsection

@section('script')
    <script src="{{ asset('home/js/user/applySybValidate.js') }}"></script>
    <script src="{{asset('home/js/upload/uploadCommon.js')}}"></script>
    <script>
        //  异步上传身份证照
        var upload = new uploadCommon();

        $("#syb_card_a").click(function(){

            $("#card_upload").trigger('click');

            upload.upload({
                inputObj    : $("#card_upload"),
                imgObj      : $("#syb_card_a"),
                url         : '/uploadcard',
                type        : 'POST',
                loadingPic  : '/home/img/loading.gif',
                hideinput   : $("input[name = 'syb_card_a']")
            });
        });

        $("#syb_card_b").click(function(){

            $("#card_upload").trigger('click');

            upload.upload({
                inputObj    : $("#card_upload"),
                imgObj      : $("#syb_card_b"),
                url         : '/uploadcard',
                type        : 'POST',
                loadingPic  : '/home/img/loading.gif',
                hideinput   : $("input[name = 'syb_card_b']")
            });
        });

    </script>
@endsection