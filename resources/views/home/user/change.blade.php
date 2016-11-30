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
                    <div id="investorBox" class="panel panel-default padding-md" >
                        <div class="panel-body ">
                            <div style="height: 60px;">
                                <h2><i class="fa fa-cog" aria-hidden="true"></i>账号改绑</h2>
                            </div>
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
            <form action="" method="post" id="changeEmail">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">更改邮箱</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="originalEmail" class="control-label">原始邮箱</label>
                            <div class="">
                                <input class="form-control" name="originalEmail" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">新邮箱</label>
                            <div class="">
                                <input class="form-control" name="email" type="text">
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
    <!-- 修改邮箱模态框 End -->
    <!-- 修改手机号模态框 Start -->
    <div class="modal fade" id="changeTelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post" id="changeTel">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">更改手机</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="originalEmail" class="control-label">原始手机号</label>
                            <div class="">
                                <input class="form-control" name="originalEmail" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">新手机号</label>
                            <div class="">
                                <input class="form-control" name="email" type="text">
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

@endsection