@extends('home.layouts.index')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/uploadbox.css')}}">
    <script type="text/javascript" src="{{url('qiniu/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/plupload.full.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/qiniu.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main2.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main3.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main4.js')}}"></script>

@endsection
@section('content')
    <section id="contact-page">
        <div class="container main-container">
            <div class="users-show">
                <!--侧边菜单栏 Start-->
                   @include('home.user.side')
                <!--侧边菜单栏 End-->

                <!--编辑个人资料 Start-->
                <div id="editUserInfo" class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <!--个人信息部分 start-->
                    <div id="userBox" class="panel panel-default padding-md" style="position: relative;z-index: 1;">
                        <div class="panel-body ">
                            <div style="height: 60px;">
                                <h2><i class="fa fa-cog" aria-hidden="true"></i>编辑个人资料</h2>
                                <div class="ibox-content pull-right" style="margin-top: -50px;">
                                    @include('home.user.avatar')
                                </div>
                            </div>

                            <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;" >
                            <hr>
                            <form id="userform" class="form-horizontal" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="put">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">昵称</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="user_nickname" type="text"></div>
                                    <div class="col-sm-4 help-block">创意只要一点点！</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">邮 箱</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="user_email" value="" type="text"></div>
                                    <div class="col-sm-4 help-block">如：name@website.com</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">真实姓名</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="user_realname" type="text"></div>
                                    <div class="col-sm-4 help-block">如：李小明</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">籍贯</label>
                                    <div class="col-sm-6">
                                        <div id="demo" class="citys">
                                            <p>
                                                <select  name="province"></select>
                                                <select  name="city"></select>
                                                <select  name="area"></select>
                                            </p>
                                            <input id="place" class="form-control" name="user_hometown" value="" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 help-block">如：湖北省武汉市光谷大道</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">生日</label>
                                    <div class="col-sm-6">
                                        <input class="form-control some_class" name="user_birthday" value="" type="text"></div>
                                    <div class="col-sm-4 help-block">如：19931127</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">性别</label>
                                    <div class="col-sm-6">
                                        <input class="sex1" name="user_sex" value="1" type="radio">男
                                        <input class="sex0" name="user_sex" value="2" type="radio">女</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">手机号</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="user_phone" type="text"></div>
                                    <div class="col-sm-4 help-block">如：18870913609</div></div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <input class="btn btn-info" id="editSubmit" value="应用修改" type="button"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--个人信息部分 end-->
                </div>
                <!--编辑个人资料 End-->
            </div>
        </div><!--/.container-->
    </section><!--/#contact-page-->
@endsection

@section('script')
<script>
    $(function(){
        // 用户信息获取
        var nickname = $("input[name='nickname']");
        var realname = $("input[name='realname']");
        var hometown = $("input[name='hometown']");
        var birthday = $("input[name='birthday']");
        var card_number = $('input[name="card_number"]');
        var headpic = $('#headpic');
        var sex = $("input[name='sex']");
        var sex0 = $(".sex0");
        var sex1 = $(".sex1");
        var tel = $("input[name='tel']");
        var guid = $("#userinfo").val();
        var url = '/user';
        var width = $("#userBox").width()/2 -40;
        var height = $("#userBox").height()/2 -50;
        var user_nickname = $("input[name='user_nickname']");
        var user_email = $("input[name='user_email']");
        var user_realname = $("input[name='user_realname']");
        var user_hometown = $("input[name='user_hometown']");
        var user_birthday = $("input[name='user_birthday']");
        var user_phone = $("input[name='user_phone']");
        var user_sex = $('input:radio[name="user_sex"]:checked');

        $.ajax({
            type: "get",
            url: url+'/'+guid,
            beforeSend:function(){
                $(".loading").css({'width':'80px','height':'80px','left':width,'top':height}).show();
            },
            success: function(msg){
                // 将传过json格式转换为json对象
                switch(msg.StatusCode){
                    case '200':
                        user_nickname.empty().val(msg.ResultData.msg.nickname);
                        user_email.empty().val(msg.ResultData.msg.email);
                        user_realname.empty().val(msg.ResultData.msg.realname);
                        user_hometown.empty().val(msg.ResultData.msg.hometown);
                        user_birthday.empty().val(msg.ResultData.msg.birthday);
                        msg.ResultData.msg.sex == 1?sex1.attr('checked','true'):sex0.attr('checked','true');
                        $("#head_pic").attr('src',msg.ResultData.msg.headpic);
                        headpic.attr('src',msg.ResultData.msg.headpic);
                        user_phone.empty().val(msg.ResultData.msg.tel);

                        $(".loading").hide();
                        break;
                    case '404':
                        alert(msg.ResultData);
                        $(".loading").hide();
                        break;
                    case '500':
                        alert(msg.ResultData);
                        $(".loading").hide();
                        break;
                }
            }
        });

        // 个人中心修改
        $("#editSubmit").click(function(){
            var data = {
                'nickname' : user_nickname.val(),
                'email' : user_email.val(),
                'realname' : user_realname.val(),
                'hometown' : user_hometown.val(),
                'birthday' : user_birthday.val(),
                'sex':  $('input:radio[name="user_sex"]:checked').val(),
                'tel' : user_phone.val()
            };
            ajaxRequire(url+'/'+guid,'PUT',data,$("#userBox"),2);
        });

        // 异步上传头像
        $("#changeHead").click(function(){
            var headPicForm = new FormData(document.getElementById("headPicForm"));
            headPicForm.append('guid',guid);
            var url = '/headpic';
            ajaxRequire('/headpic','POST',headPicForm,$("#userBox"),3);
        });

        // 申请成为投资者
        $("#applyInvestor").click(function(){
            var formData = new FormData(document.getElementById("investorForm"));
            formData.append('guid',guid);
            ajaxRequire('/apply','POST',formData,$('#investorForm'),1);
        });
        // 城级联动
        $('#demo').citys({
            required:false,
            nodata:'disabled',
            onChange:function(data){
                var text = data['direct']?'(直辖市)':'';
                $('#place').val('当前选中地区：'+data['province']+text+' '+data['city']+' '+data['area']);
            }
        });

        // 申请成为投资者
//        $("#investor").click(function(){
//            $('#userBox').hide();
//            $('#pro_list_table').hide();
//            $('#investorBox').show();
//            $('#entrepreneursBox').hide();
//            $("#editUserInfoBtn").removeClass('active');
//            $("#entrepreneursBtn").removeClass('active');
//            $(this).addClass('active');
//        });
//
//        $("#editUserInfoBtn").click(function(){
//            $('#userBox').show();
//            $('#pro_list_table').hide();
//            $('#investorBox').hide();
//            $('#entrepreneursBox').hide();
//            $("#investor").removeClass('active');
//            $("#entrepreneursBtn").removeClass('active');
//            $(this).addClass('active');
//        });
//
//        $("#entrepreneursBtn").click(function(){
//            $('#userBox').hide();
//            $('#pro_list_table').hide();
//            $('#investorBox').hide();
//            $('#entrepreneursBox').show();
//            $("#editUserInfoBtn").removeClass('active');
//            $("#investor").removeClass('active');
//            $(this).addClass('active');
//        });

    });



</script>
@include('home.user.ajax.ajaxRequire')
@include('home.validator.UpdateValidator')
@include('home.validator.publishValidator')
@include('home.project.all_pro_list')
@include('home.public.dateTime')


@endsection