@extends('home.layouts.index')
@section('content')
    <section id="contact-page">
        <div class="container main-container">
            <div class="users-show">
                <!--侧边菜单栏 Start-->
            @include('home.user.side')
            <!--侧边菜单栏 End-->
                <!--账号绑定 Start-->
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <div id="changeBox" class="panel panel-default padding-md" style="position: relative;z-index: 1;">
                        <div class="panel-body ">
                            <div style="height: 60px;">
                                <h2><i class="fa fa-cog" aria-hidden="true"></i>账号改绑</h2>
                            </div>
                            <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;" >
                            <hr>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">邮箱</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="email" type="text"  readonly></div>
                                <div class="col-sm-4 help-block">
                                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#changeEmailModal">更改</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">手机号</label>
                                <div class="col-sm-6">
                                    <input class="form-control some_class" name="tel" type="text" readonly></div>
                                <div class="col-sm-4 help-block">
                                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#changeTelModal">更改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--账号绑定 End-->
            </div>
        </div><!--/.container-->
    </section><!--/#contact-page-->

    <!-- 修改邮箱模态框 Start -->
    <div class="modal fade" id="changeEmailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('/user/change/email/'.session('user')->guid) }}" method="post" id="changeEmail">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">更改邮箱</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="originalEmail" class="control-label">原始邮箱</label>
                            <div class="">
                                <input class="form-control" name="email" type="email" placeholder="输入原始邮箱地址">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">新邮箱</label>
                            <div class="">
                                <input class="form-control" name="newEmail" type="text" placeholder="输入新的邮箱地址">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="control-label">账户密码</label>
                            <div class="">
                                <input class="form-control" name="password" type="password" placeholder="输入账号密码">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="changeEmailBtn" type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- 修改邮箱模态框 End -->
    <!-- 修改手机号模态框 Start -->
    <div class="modal fade" id="changeTelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post" id="changeTel">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">更改手机</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="originalEmail" class="control-label">原始手机号</label>
                            <div class="">
                                <input class="form-control" name="tel" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">新手机号</label>
                            <div class="">
                                <input class="form-control" name="newTel" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="control-label">账户密码</label>
                            <div class="">
                                <input class="form-control" name="password" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- 修改手机号模态框 End -->

@endsection
@section('script')
<script>
    $(function(){
        var guid = $("#userinfo").val();
        var email = $("input[name='email']");
        var tel = $("input[name='tel']");
        var width = $("#changeBox").width()/2 -40;
        var height = $("#changeBox").height()/2 -50;

        $.ajax({
            type: "get",
            url: '/user/'+guid,
            beforeSend:function(){
                $(".loading").css({'width':'80px','height':'80px','left':width,'top':height}).show();
            },
            success: function(msg){
                // 将传过json格式转换为json对象
                switch(msg.StatusCode){
                    case '200':
                        email.empty().val(msg.ResultData.msg.email);
                        tel.empty().val(msg.ResultData.msg.tel);

                        $(".loading").hide();
                        break;
                    case '400':
                        promptBoxHandle('警告',msg.ResultData);
                        $(".loading").hide();
                        break;
                    case '500':
                        promptBoxHandle('警告',msg.ResultData);
                        $(".loading").hide();
                        break;
                }
            }
        });

        // 修改邮箱

    });
</script>
    @include('home.validator.changeEmailValidator')
    @include('home.validator.changePhoneValidator')
@endsection