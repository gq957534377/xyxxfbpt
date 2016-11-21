@extends('home.layouts.index')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/uploadbox.css')}}">
    <script type="text/javascript" src="{{url('qiniu/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/plupload.full.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/qiniu.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui2.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main2.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main3.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main4.js')}}"></script>
@endsection
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
                            <a href="#" class="list-group-item" id="investor">
                                <i class="text-md fa fa-user" aria-hidden="true" style="margin-left: 40px;"></i>&nbsp;申请成为投资者</a>
                            <!--项目发布 start-->
                            <a id = 'publish_trigger' href="#" class="list-group-item " data-toggle="modal">
                                <i class="text-md fa fa-bell" aria-hidden="true"></i>项目发布
                            </a>
                            <a id = 'publish_trigger2' href="#" style="display: none;" class="list-group-item " data-toggle="modal" data-target="#_projectPunlish">
                                <i class="text-md fa fa-bell" aria-hidden="true"></i>项目发布
                            </a>
                            <!--项目发布弹出层 start-->
                            <div class="modal fade" id="_projectPunlish" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">项目发布</h4>
                                        </div>
                                        <!--引入项目发布表单元素-->
                                        <form id = "projectForm" class="form-horizontal" style="padding-bottom: 20px;">
                                            <div class = "col-sm-10 col-sm-offset-1">
                                                <input name='title' type="text" class="form-control _input" placeholder="请输入项目标题">
                                                <input name='habitude' type="text" class="form-control _input" placeholder="请输入项目性质">
                                                <input name='less_funding' type="text" class="form-control _input" placeholder="请输入起步资金">
                                                <input name='cycle' type="text" class="form-control _input" placeholder="请输入项目周期">
                                                <textarea name='content' class="form-control _input" rows="4" placeholder="请输入项目简介（50字以内）"></textarea>
                                                <select name = 'project_type' style="float: left;">
                                                    <option>请选择项目分类</option>
                                                    <option value = '1'>新品上架</option>
                                                    <option value = '2'>健康生活</option>
                                                    <option value = '3'>热门推荐</option>
                                                    <option value = '4'>新品上架</option>
                                                    <option value = '5'>健康生活</option>
                                                    <option value = '6'>健康生活</option>
                                                    <option value = '7'>健康生活</option>
                                                    <option value = '8'>健康生活</option>
                                                </select>
                                            </div>
                                            <div class = "col-sm-6">
                                                <div id="img_container" style="margin-top: 30px;">
                                                    <button class="btn btn-info btn-sm" type="button" id="img_pick">选择图片</button>
                                                    <button class="btn btn-info btn-sm" type="button" id="file_pick">选择资料</button>
                                                </div>
                                            </div>
                                            <!--隐藏表单区-->
                                            <input  type ='hidden' name = "image"/>
                                            <input  type ='hidden' name = "file"/>
                                            <input type="hidden" id="domain" value="http://ogd29n56i.bkt.clouddn.com/">
                                            <input type="hidden" id="uptoken_url" value="{{url('project/getuptoken/edit')}}">

                                            <div class = "col-sm-10 col-sm-offset-1">
                                                <table class="table table-striped table-hover"   style="margin-top:40px;display:none">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-4">文件名</th>
                                                        <th class="col-md-2">大小</th>
                                                        <th class="col-md-6">详情</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="fsUploadProgress">
                                                    </tbody>
                                                    <tbody id="fsUploadProgress2">
                                                    </tbody>
                                                </table>
                                            </div>
                                                <button class="btn btn-info" type="submit" style="margin-left: 70%;margin-top: 40px;">提交</button>
                                        </form>
                                        <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;" >


                                    </div>
                                </div>
                            </div>
                            <!--项目发布弹出层 end-->
                            <!--项目发布 end-->

                            <!--已发布项目管理 start-->
                            <a id='all_pro_list' href="#" class="list-group-item " data-toggle="modal">
                                <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;项目管理</a>
                            <!--已发布项目管理 end-->

                            <!--项目编辑弹出层 start-->
                            <div class="modal fade" id="pro_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">项目发布</h4>
                                        </div>
                                        <!--引入项目编辑表单元素-->
                                        <form id = "pro_edit_form" class="form-horizontal" style="padding-bottom: 20px;">
                                            <div class = "col-sm-10 col-sm-offset-1">
                                                <input id='edit_title' name='title' type="text" class="form-control _input" placeholder="请输入项目标题">
                                                <input id='edit_habitude' name='habitude' type="text" class="form-control _input" placeholder="请输入项目性质">
                                                <input id='edit_less_funding' name='less_funding' type="text" class="form-control _input" placeholder="请输入起步资金">
                                                <input id ='edit_cycle' name='cycle' type="text" class="form-control _input" placeholder="请输入项目周期">
                                                <textarea id='edit_content' name='content' class="form-control _input" rows="4" placeholder="请输入项目简介（50字以内）"></textarea>
                                                <select id ='edit_project_type' name = 'project_type' style="float: left;">
                                                    <option>请选择项目分类</option>
                                                    <option value = '1'>新品上架</option>
                                                    <option value = '2'>健康生活</option>
                                                    <option value = '3'>热门推荐</option>
                                                    <option value = '4'>新品上架</option>
                                                    <option value = '5'>健康生活</option>
                                                    <option value = '6'>健康生活</option>
                                                    <option value = '7'>健康生活</option>
                                                    <option value = '8'>健康生活</option>
                                                </select>
                                            </div>
                                            <div class = "col-sm-6">
                                                <div id="edit_container" style="margin-top: 30px;">
                                                    <button class="btn btn-info btn-sm" type="button" id="edit_img_pick">选择图片</button>
                                                    <button class="btn btn-info btn-sm" type="button" id="edit_file_pick">选择资料</button>
                                                </div>
                                            </div>
                                            <!--隐藏表单区-->
                                            <input  id='edit_image' type ='hidden' name = "image"/>
                                            <input  id='edit_file' type ='hidden' name = "file"/>
                                            <input type="hidden" id="domain" value="http://ogd29n56i.bkt.clouddn.com/">
                                            <input type="hidden" id="uptoken_url" value="{{url('project/getuptoken/edit')}}">

                                            <div class = "col-sm-10 col-sm-offset-1">
                                                <table id='edit_table' class="table table-striped table-hover"   style="margin-top:40px;display:none">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-4">文件名</th>
                                                        <th class="col-md-2">大小</th>
                                                        <th class="col-md-6">详情</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="fsUploadProgress_edit_image">
                                                    </tbody>
                                                    <tbody id="fsUploadProgress_edit_file">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button class="btn btn-info" type="submit" style="margin-left: 70%;margin-top: 40px;">提交</button>
                                        </form>
                                        <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;" >


                                    </div>
                                </div>
                            </div>
                            <!--项目编辑弹出层 end-->
                        </div>
                    </div>
                </div>

                <!--编辑个人资料 Start-->
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
                <!--编辑个人资料 End-->

                <!--申请成为投资人 Start-->
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <div id="investorBox" class="panel panel-default padding-md" style="display: none;position: relative;z-index: 1;">
                        <div class="panel-body ">
                            <div style="height: 60px;">
                                <h2><i class="fa fa-cog" aria-hidden="true"></i>申请成为投资者</h2>
                            </div>
                            <hr>
                            <form id="investorForm"  class="form-horizontal" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">真实姓名</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="investor_name" type="text" placeholder="请输入真实姓名"></div>
                                    <div class="col-sm-4 help-block">请填写真实信息哦！</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">性别</label>
                                    <div class="col-sm-6">
                                        <label class="radio-inline">
                                            <input class="sex1" name="investor_sex" value="1" type="radio">男
                                        </label>
                                        <label class="radio-inline">
                                        <input class="sex0" name="investor_sex" value="2" type="radio">女
                                        </label></div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">出生年月</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="investor_birthday" type="text" placeholder="请输入出生年月"></div>
                                    <div class="col-sm-4 help-block">如:19931127！</div></div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">籍贯</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="investor_hometown" type="text" placeholder="请输入籍贯"></div>
                                    <div class="col-sm-4 help-block">如:湖北省武汉市！</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">手机号</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="investor_tel" type="text" maxlength="11" placeholder="请输入手机号"></div>
                                    <div class="col-sm-4 help-block">如:18866669999！</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">身份证号码</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="investor_number" type="text" maxlength="18" placeholder="请输入真实的身份证证件号"></div>
                                    <div class="col-sm-4 help-block">如:888888888888888888888！</div></div>

                                {{--<div class="form-group">--}}
                                    {{--<label for="" class="col-sm-2 control-label">证件照</label>--}}
                                            {{--<div class = "col-sm-6">--}}
                                                {{--<div id="card_box" style="margin-top: 30px;">--}}
                                                    {{--<button class="btn btn-info btn-sm" type="button" id="card_a">身份证正面</button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<!--隐藏表单区-->--}}
                                            {{--<input  type ='hidden' name = "investor_carda"/>--}}
                                            {{--<input type="hidden" id="cardmain" value="http://ogd29n56i.bkt.clouddn.com/">--}}
                                            {{--<input type="hidden" id="card_url" value="{{url('project/getuptoken/edit')}}">--}}

                                            {{--<div class = "col-sm-10 col-sm-offset-1">--}}
                                                {{--<table class="table table-striped table-hover"   style="margin-top:40px;display:none">--}}
                                                    {{--<thead>--}}
                                                    {{--<tr>--}}
                                                        {{--<th class="col-md-4">文件名</th>--}}
                                                        {{--<th class="col-md-2">大小</th>--}}
                                                        {{--<th class="col-md-6">详情</th>--}}
                                                    {{--</tr>--}}
                                                    {{--</thead>--}}
                                                    {{--<tbody id="card_body">--}}
                                                    {{--</tbody>--}}
                                                {{--</table>--}}
                                            {{--</div>--}}
                                    {{--</div>--}}

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">机构名称</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="orgname" type="text" placeholder="请输入机构名称"></div>
                                    <div class="col-sm-4 help-block">如:坚固控股有限集团</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">机构所在地</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="orglocation" type="text" placeholder="请输入机构所在地"></div>
                                    <div class="col-sm-4 help-block">如:湖北武汉市</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">资金规模</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="fundsize" type="text" placeholder="请输入机构资金规模"></div>
                                    <div class="col-sm-4 help-block"></div>如:1000000美元</div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">投资领域</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="field" type="text" placeholder="请输入投资领域"></div>
                                    <div class="col-sm-4 help-block">如:互联网行业</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">行业描述</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="orgdesc" maxlength="500" placeholder="请对贵机构所在的行业中的地位描述，总字数不超过800个。"></textarea></div>
                                    <div class="col-sm-4 help-block">如:互联网</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">从业年限</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="workyear" type="text" maxlength="2" placeholder="请输入从业年限"></div>
                                    <div class="col-sm-4 help-block"></div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">投资规模</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="scale" type="text" placeholder="规模以万为单位"></div>
                                    <div class="col-sm-4 help-block"></div></div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <button class="btn btn-info" id="applyInvestor" >提交申请</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--申请成为投资人 End-->

                <!--更换头像弹出层 Start-->
                <div class="modal fade modal-md" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form class="avatar-form" action="{{url('/headpic')}}" enctype="multipart/form-data" method="post">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                                    <h4 class="modal-title" id="avatar-modal-label">Change Logo Picture</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="avatar-body">
                                        <div class="avatar-upload">
                                            <input class="avatar-src" name="avatar_src" type="hidden">
                                            <input class="avatar-data" name="avatar_data" type="hidden">
                                            <label for="avatarInput">图片上传</label>
                                            <input class="avatar-input" id="avatarInput" name="avatar_file" type="file"></div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="avatar-wrapper"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="avatar-preview preview-lg"></div>
                                                <div class="avatar-preview preview-md"></div>
                                                <div class="avatar-preview preview-sm"></div>
                                            </div>
                                        </div>
                                        <div class="row avatar-btns">
                                            <div class="col-md-9">
                                                <div class="btn-group">
                                                    <button class="btn" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees"><i class="fa fa-undo"></i> 向左旋转</button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees"><i class="fa fa-repeat"></i> 向右旋转</button>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button id="changeHead" class="btn btn-success btn-block avatar-save" type="submit"><i class="fa fa-save"></i> 保存修改</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                <!--更换头像弹出层 End-->

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
                        $("#head_pic").attr('src','uploads/image/'+msg.ResultData.msg.headpic);
                        $("#userinfo_headpic").attr('src','uploads/image/'+msg.ResultData.msg.headpic);
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
            ajaxRequire('/headpic','POST',headPicForm,$("#userBox"),3);
        });

        // 申请成为创业者
        $("#applySubmit").click(function(){
            var formData = new FormData(document.getElementById("entrepreneur"));
            formData.append('guid',guid);
            ajaxRequire('/user','POST',formData,$('#entrepreneur'),1);
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
        $("#investor").click(function(){
            $('#userBox').hide();
            $('#pro_list_table').hide();
            $('#investorBox').show();

        });
    });
</script>
@include('home.user.ajax.ajaxRequire')
@include('home.validator.UpdateValidator')
@include('home.validator.investorValidator')
@include('home.validator.publishValidator')

@include('home.project.all_pro_list')

@endsection