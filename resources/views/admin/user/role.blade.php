@extends('admin.layouts.master')
@section('styles')
    <link href="{{asset('admin/css/userandrole.css')}}" rel="stylesheet">
@endsection
{{--展示内容开始--}}
@section('content')
    <div class="btn-toolbar" role="toolbar">
        <h2>用户审核管理</h2>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">待审核
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a  class="user_role_list" key="0" title="待审核创业者用户" >创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="1" title="待审核投资者用户" >投资者</a>
                </li>
                <li>
                    <a   class="user_role_list" key="2"  title="待审核英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">审核失败
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="user_role_list" key="3" title="审核失败创业者用户">创业者</a>
                </li>
                <li>
                    <a  class="user_role_list" key="4" title="审核失败投资者用户">投资者</a>
                </li>
                <li>
                    <a class="user_role_list" key="5" title="审核失败英雄会成员">英雄会成员</a>
                </li>
            </ul>
        </div>
    </div>

    {{--<img src="{{asset('admin/images/load.gif')}}" class="loading">--}}

    <div class="page-title">
        <h5 id="user_title" class="title text-center"></h5>
    </div>

    {{--表格盒子开始--}}
    <div class="panel" id="data" style="text-align: center"></div>
    {{--表格盒子结束--}}

{{--展示内容结束--}}

{{--弹出页面 开始--}}
<div id="con123" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" id="fabu">
        <div class="modal-content">
            <div id = "" class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="text-danger">x</span></button>
                <h3>创业者详细信息</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">

                            <li><input type="hidden" id="guid" name="guid"  /><input type="hidden" id="role" name="role"  /></li>
                            <li><strong>真实姓名 ：</strong><mark><span id="realname1"></span></mark></li>
                            <li><strong>地址 ：</strong><span id="school_address"></span></li>
                            <li><strong>学校名字 ： </strong><span id="school_name"></span></li>

                            <li><strong>专业 ：</strong><span id="major"></span></li>
                            <li><strong>入学年份 ：</strong><span id="enrollment_year" class="text-muted"></span></li>
                            <li><strong>毕业年份 ：</strong><span id="graduation_year"></span></li>
                            <li><strong>学历 ：</strong><span id="education"></span></li>
                            <li><strong>申请时间 ：</strong><span id="addtime"></span></li>
                            <li id="role"></li>
                            <li id="status"></li>


                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">


                            <li><strong>身份证a：</strong>
                                {{--<img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}">--}}
                                <div class="ibox-content" style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                                    <div class="row">
                                        <div id="crop-avatar">
                                            <div class="avatar-view pic_img" title="">
                                                <img id="pic_a" class="img-thumbnail" src="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><strong>身份证b</strong> :
                                {{--<img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}">--}}
                                <div class="ibox-content" style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                                    <div class="row">
                                        <div id="crop-avatar">
                                            <div class="avatar-view pic_img" title="" >
                                                <img id="pic_b" class="img-thumbnail" src="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <a href="javascript:;" data-name="' + v.guid + '" data-id="7" class="check_pass"><button type="submit" data-name="" class="btn btn-danger" id="check_pass">拒绝</button></a>
                <a href="javascript:;" data-name="' + v.guid + '" data-id="6" class="check_pass"><button type="submit" data-name="" class="btn btn-primary">通过</button></a>
            </div>

        </div>
    </div>

</div>

{{--弹出页面 开始--}}
<div id="con12" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" id="fabu">
        <div class="modal-content">
            <div id = "" class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="text-danger">x</span></button>
                <h3>投资者详细信息</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">

                            <li><input type="hidden" id="guid" name="guid"  /><input type="hidden" id="role" name="role"  /></li>
                            <li><strong>真实姓名 ：</strong><mark><span id="realname2"></span></mark></li>
                            <li><strong>从业年限 ： </strong><span id="work_year"></span></li>
                            <li><strong>投资规模 ：</strong><span id="scale"></span></li>
                            <li><strong>所在行业 ：</strong><span id="field"></span></li>
                            <li><strong>公司 ：</strong><span id="company" class="text-muted"></span></li>
                            <li><strong>地址 ：</strong><span id="company_address"></span></li>
                            <li><strong>申请时间 ：</strong><span id="addtime1"></span></li>
                            <li id="role"></li>
                            <li id="status"></li>


                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">


                            <li><strong>证件：</strong>
                                {{--<img class="user_avatar img-circle" src="{{ asset('home/img/user_center.jpg') }}">--}}
                                <div class="ibox-content" style="display: inline-block;padding-left: 40px;vertical-align: middle;">
                                    <div class="row">
                                        <div id="crop-avatar">
                                            <div class="avatar-view pic_img" title="">
                                                <img id="pic_aa" class="" src=""  />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <a href="javascript:;" data-name="' + v.guid + '" data-id="7" class="check_pass"><button type="submit" data-name="" class="btn btn-danger" id="check_pass">拒绝</button></a>
                <a href="javascript:;" data-name="' + v.guid + '" data-id="6" class="check_pass"><button type="submit" data-name="" class="btn btn-primary">通过</button></a>
            </div>

        </div>
    </div>

</div>
@endsection


@section('script')
    <script src="{{ asset('admin/js/classie.js') }}"></script>
    <script src="{{ asset('admin/js/modaleffects.js') }}"></script>
    <script src="{{ asset('jsService/Model/user/userRole.js') }}"></script>

@endsection