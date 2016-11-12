@extends('home.layouts.index')
@section('content')
    <section id="contact-page">
        <div class="container main-container">
            <div class="users-show">
                <div class="col-md-3 box" style="padding: 15px 15px;">
                    <div class="padding-md">
                        <div class="list-group text-center">
                            <a href="#" class="list-group-item active">
                                <i class="text-md fa fa-list-alt" aria-hidden="true"></i>&nbsp;个人信息</a>
                            <a href="#" class="list-group-item ">
                                <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;修改头像</a>
                            <a href="#" class="list-group-item ">
                                <i class="text-md fa fa-bell" aria-hidden="true" style="margin-left: 40px;"></i>&nbsp;申请成为创业者</a>
                            <a href="#" class="list-group-item ">
                                <i class="text-md fa fa-flask" aria-hidden="true"></i>&nbsp;账号绑定</a>
                        </div>
                    </div>
                </div>
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <div id="userBox" class="panel panel-default padding-md" style="position: relative;z-index: 1;">
                        <div class="panel-body ">
                            <h2><i class="fa fa-cog" aria-hidden="true"></i>编辑个人资料  </h2>
                            <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="position: absolute;z-index: 9999;" >
                            <hr>
                            <form id="userform" class="form-horizontal" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                                <input type="hidden" name="_mehtod" value="put">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">昵称</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="nickname" type="text"></div>
                                    <div class="col-sm-4 help-block">创意只要一点点！</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">邮 箱</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="email" value="" type="text"></div>
                                    <div class="col-sm-4 help-block">如：name@website.com</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">真实姓名</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="realname" type="text"></div>
                                    <div class="col-sm-4 help-block">如：李小明</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">籍贯</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="hometown" value="" type="text"></div>
                                    <div class="col-sm-4 help-block">如：湖北省武汉市光谷大道</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">生日</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="birthday" value="" type="text"></div>
                                    <div class="col-sm-4 help-block">如：19931127</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">性别</label>
                                    <div class="col-sm-6">
                                        <input class="" name="sex" value="" type="radio" checked>男
                                        <input class="" name="sex" value="" type="radio">女</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">手机号</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="phone" type="text"></div>
                                    <div class="col-sm-4 help-block">如：18870913609</div></div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <input class="btn btn-info" id="editSubmit" value="应用修改" type="button"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section><!--/#contact-page-->
@endsection

@section('script')
{{--@include('home.ajax.userinfo')--}}
<script>
    $(function(){
        // 用户信息获取
        var nickname = $("input[name='nickname']");
        var email = $("input[name='email']");
        var realname = $("input[name='realname']");
        var hometown = $("input[name='hometown']");
        var birthday = $("input[name='birthday']");
        var sex = $("input[name='sex']");
        var phone = $("input[name='phone']");
        var guid = $("#userinfo").val();
        var url = '/user';
        var width = $("#userBox").width()/2 -40;
        var height = $("#userBox").height()/2 -50;

        $.ajax({
            type: "get",
            url: url+'/'+guid,
            beforeSend:function(){
                $(".loading").css({'width':'80px','height':'80px','left':width,'top':height}).show();
            },
            success: function(msg){
                // 将传过json格式转换为json对象
                switch(msg.StatusCode){
                    case 200:
                        nickname.empty().val(msg.ResultData.msg.nickname);
                        email.empty().val(msg.ResultData.msg.email);
                        realname.empty().val(msg.ResultData.msg.realname);
                        hometown.empty().val(msg.ResultData.msg.hometown);
                        birthday.empty().val(msg.ResultData.msg.birthday);
                        phone.empty().val(msg.ResultData.msg.tel);
                        $(".loading").hide();
                        break;
                    case 404:
                        alert(msg.ResultData);
//                    nickname.val('');
//                    email.val('');
//                    realname.val('');
//                    hometown.val('');
//                    birthday.val('');
//                    phone.val('');
                        break;
                    case 500:
                        alert(msg.ResultData);
//                    nickname.val('');
//                    email.val('');
//                    realname.val('');
//                    hometown.val('');
//                    birthday.val('');
//                    phone.val('');
                        break;
                }


            }
        });

        // 个人中心修改
        $("#editSubmit").click(function(){
            var data = {
                'nickname' : nickname.val(),
                'email' : email.val(),
                'realname' : realname.val(),
                'hometown' : hometown.val(),
                'birthday' : birthday.val(),
                'phone' : phone.val()
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'PUT',
                data:data,
                url:url+'/'+guid,
                beforeSend:function(){
                    $(".loading").css({'width':'80px','height':'80px','left':width,'top':height}).show();
                },
                success:function(msg){
                    console.log(msg);
                },
                error:function(msg){

                }


            });
        });

    });
</script>
@endsection