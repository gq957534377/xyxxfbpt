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
                            <a href="#" class="list-group-item " data-toggle="modal" data-target="#myModal">
                                <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;修改头像</a>
                            <!--修改头像弹出层 start-->
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">更换头像</h4>
                                        </div>
                                        <form method="POST" id="headPicForm" enctype="muitipart/form-data" >
                                            <input type="hidden" mame="_method" value="put">
                                            <div class="modal-body">
                                                <img id="headpic" src="{{asset('home/images/man1.jpg')}}" class="img-circle" style="width: 147px;height: 138.88px;"><br>
                                                <input type="file" name="headpic" />
                                            </div>
                                        </form>
                                        <div class="modal-footer">
                                            <button id="changeHead" type="button" class="btn btn-info">更换</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--修改头像弹出层 end-->
                            <a href="#" class="list-group-item " data-toggle="modal" data-target="#myModal_1">
                                <i class="text-md fa fa-bell" aria-hidden="true" style="margin-left: 40px;"></i>&nbsp;申请成为创业者
                            </a>
                            <!--申请成为创业者 start-->
                            <!-- Modal -->
                            <div class="modal fade" id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">创业者申请</h4>
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
                                                    <input class="sex1" name="sex" value="1" type="radio">男
                                                    <input class="sex0" name="sex" value="0" type="radio">女</div></div>

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
                            <a href="#" class="list-group-item ">
                                <i class="text-md fa fa-flask" aria-hidden="true"></i>&nbsp;发布项目</a>
                        </div>
                    </div>
                </div>
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <div id="userBox" class="panel panel-default padding-md" style="position: relative;z-index: 1;">
                        <div class="panel-body ">
                            <h2><i class="fa fa-cog" aria-hidden="true"></i>编辑个人资料  </h2>
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
                                        <input class="form-control" name="user_hometown" value="" type="text"></div>
                                    <div class="col-sm-4 help-block">如：湖北省武汉市光谷大道</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">生日</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="user_birthday" value="" type="text"></div>
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
                </div>
            </div>
        </div><!--/.container-->
    </section><!--/#contact-page-->

@endsection

@section('script')
@include('home.user.ajax.ajaxRequire')
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
                    case 200:
                        user_nickname.empty().val(msg.ResultData.msg.nickname);
                        user_email.empty().val(msg.ResultData.msg.email);
                        user_realname.empty().val(msg.ResultData.msg.realname);
                        user_hometown.empty().val(msg.ResultData.msg.hometown);
                        user_birthday.empty().val(msg.ResultData.msg.birthday);
                        msg.ResultData.msg.sex == 1?sex1.attr('checked','true'):sex0.attr('checked','true');
                        tel.empty().val(msg.ResultData.msg.tel);
                        headpic.attr('src','uploads/image/'+msg.ResultData.msg.headpic);

                        // 给创业提交信息也附上值
                        nickname.empty().val(msg.ResultData.msg.nickname);
                        realname.empty().val(msg.ResultData.msg.realname);
                        hometown.empty().val(msg.ResultData.msg.hometown);
                        birthday.empty().val(msg.ResultData.msg.birthday);
                        msg.ResultData.msg.sex == 1?sex1.attr('checked','true'):sex0.attr('checked','true');
                        user_phone.empty().val(msg.ResultData.msg.tel);

                        $(".loading").hide();
                        break;
                    case 404:
                        alert(msg.ResultData);
                        $(".loading").hide();
                        break;
                    case 500:
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
            ajaxRequire('/headpic','POST',headPicForm,$("#userBox"),1);
        });

        // 申请成为创业者
        $("#applySubmit").click(function(){
            var formData = new FormData(document.getElementById("entrepreneur"));
            formData.append('guid',guid);
            ajaxRequire('/user','POST',formData,$('#entrepreneur'),1);
        });
    });
</script>
@include('home.user.ajax.ajaxRequire')
@include('home.validator.UpdateValidator')

@endsection