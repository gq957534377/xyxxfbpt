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
                    <div class="panel panel-default padding-md">
                        <div class="panel-body ">
                            <h2>
                                <i class="fa fa-cog" aria-hidden="true"></i>编辑个人资料</h2>
                            <hr>
                            <form class="form-horizontal" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
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
@include('home.ajax.userinfo')

@endsection