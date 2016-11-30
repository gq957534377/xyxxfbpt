@extends('home.layouts.index')
@section('content')
    <section id="contact-page">
        <div class="container main-container">
            <div class="users-show">
                <!--侧边菜单栏 Start-->
                @include('home.user.side')
                <!--侧边菜单栏 End-->
                <!--申请成为创业者 start-->
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <div id="MemeberBox" class="panel panel-default padding-md" style="position: relative;z-index: 1;">
                        <div class="panel-body ">
                            <div style="height: 60px;">
                                <h2><i class="fa fa-cog" aria-hidden="true"></i>英雄会入会申请</h2>
                                <hr>
                            </div>
                            <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;" >
                            <form id="entrepreneur" class="form-horizontal" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">真实姓名</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="realname" type="text"></div>
                                    <div class="col-sm-4 help-block">如：李小明</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">
                                        身份证号码
                                    </label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="card_number" type="text"></div>
                                    <div class="col-sm-4 help-block">如：363636201611110012</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">籍贯</label>
                                    <div class="col-sm-6">
                                        <div id="demo" class="citys">
                                            <p>
                                                <select  name="province"></select>
                                                <select  name="city"></select>
                                                <select  name="area"></select>
                                            </p>
                                            <input id="place" class="form-control" name="hometown" value="" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 help-block">如：湖北省武汉市光谷大道</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label ">生日</label>
                                    <div class="col-sm-6">
                                        <input class="form-control some_class" name="birthday" value="" type="text"></div>
                                    <div class="col-sm-4 help-block">如：19931127</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">性别</label>
                                    <div class="col-sm-6">
                                        <input class="sex1" name="sex" value="1" type="radio">男
                                        <input class="sex0" name="sex" value="2" type="radio">女</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">手机号</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="tel" type="text"></div>
                                    <div class="col-sm-4 help-block">如：18870913609</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">身份证正面</label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control" name="card_pic_a" type="text"></div>
                                    <div class="col-sm-4 help-block">如：</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">身份证反面</label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control" name="card_pic_b" type="text"></div>
                                    <div class="col-sm-4 help-block">如：</div></div>

                                <div class="modal-footer">
                                    <input class="btn btn-info" id="applySubmit" value="提交申请" type="button">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--申请成为创业者 end-->
            </div>
        </div><!--/.container-->
    </section><!--/#contact-page-->
@endsection
@section('script')
<script>
    $(function(){
        var guid = $("#userinfo").val();
        var realname = $("input[name='realname']");
        var hometown = $("input[name='hometown']");
        var birthday = $("input[name='birthday']");
        var card_number = $('input[name="card_number"]');
        var headpic = $('#headpic');
        var sex = $("input[name='sex']");
        var sex0 = $(".sex0");
        var sex1 = $(".sex1");
        var tel = $("input[name='tel']");
        var width = $("#userBox").width()/2 -40;
        var height = $("#userBox").height()/2 -50;
        // 异步获取数据
        $.ajax({
            type: "get",
            url: '/roleinfo'+'/'+guid,
            beforeSend:function(){
                $(".loading").css({'width':'80px','height':'80px','left':width,'top':height}).show();
            },
            success: function(msg){
                console.log(msg);
                // 将传过json格式转换为json对象
                switch(msg.StatusCode){
                    case '200':
                        headpic.attr('src','uploads/image/'+msg.ResultData.msg.headpic);
                        realname.empty().val(msg.ResultData.msg.realname);
                        card_number.empty().val(msg.ResultData.msg.card_number);
                        hometown.empty().val(msg.ResultData.msg.hometown);
                        birthday.empty().val(msg.ResultData.msg.birthday);
                        msg.ResultData.msg.sex == 1?sex1.attr('checked','true'):sex0.attr('checked','true');
                        tel.empty().val(msg.ResultData.msg.tel);

                        $(".loading").hide();
                        break;
                    case '400':
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

        // 城级联动
        $('#demo').citys({
            required:false,
            nodata:'disabled',
            onChange:function(data){
                var text = data['direct']?'(直辖市)':'';
                $('#place').val(data['province']+text+' '+data['city']+' '+data['area']);
            }
        });
        // 申请成为英雄会会员
        $("#applySubmit").click(function(){
            var formData = new FormData(document.getElementById("entrepreneur"));
            formData.append('guid',guid);
            ajaxRequire('/user/apply/memeber','POST',formData,$('#entrepreneur'),1);
        });
    });
</script>
@include('home.user.ajax.ajaxRequire')
@include('home.public.dateTime')
@endsection
