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
                <div class="col-md-3 box" style="padding: 15px 15px;">
                    @include('home.user.side')
                </div>

                <!--活动管理 Start-->
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <!--个人信息部分 start-->
                    <div id="userBox" class="panel panel-default padding-md" style="position: relative;z-index: 1;">
                        <div class="panel-body ">
                            <div style="height: 60px;">
                                <h2><i class="fa fa-cog" aria-hidden="true"></i>编辑个人资料</h2>
                                <div class="ibox-content pull-right" style="margin-top: -50px;">
                                    <div class="row">
                                        <div id="crop-avatar">
                                            <div class="avatar-view col-md-3" title="Change Logo Picture">
                                                <img id="userinfo_headpic" class="img-circle" style="width: 100%;" src="{{asset('home/images/load.gif')}}" alt="Logo">
                                            </div>
                                        </div>
                                    </div>
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
                    <!--个人信息部分 end-->

                    <!--项目列表部分 start-->
                    <table class="table table-striped" id='pro_list_table' style="display: none">
                        <caption>项目列表</caption>
                        <thead>
                        <tr>
                            <th>项目标题</th>
                            <th>项目状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!--项目列表部分 end-->
                </div>
                <!--活动管理 End-->
            </div>
        </div><!--/.container-->
    </section><!--/#contact-page-->
@endsection