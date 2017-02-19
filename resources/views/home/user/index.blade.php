@extends('home.layouts.userCenter')

@section('title','我的主页')

@section('style')
    <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
    <link href="{{asset('home/css/user_center_my_home.css')}}" rel="stylesheet"/>

@endsection

@section('content')

    <!--我的主页内容开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 my-home fs-c-4 fs-14 content-wrap">
        <!--基本信息开始-->
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pad-cl my-home-basic">
            <!-- 头像修改 Start -->
            <div class="col-sm-2 col-md-3 col-lg-2 pad-clr">
                <div class="ibox-content">
                    <div class="row">
                        <div id="crop-avatar">
                            <div class="avatar-view" title="">
                                <img class="user_avatar img-circle"
                                     src="{{ session('user')->headpic ? session('user')->headpic : asset('home/images/user_center.jpg') }}" alt="Logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 头像修改 End -->
            <div class="col-sm-10 col-md-9 col-lg-10 pad-clr">
                <p class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad-cr">昵称：<span class="user_nickname">{{ $userInfo->username or '--'}}</span><a id="userInfoEdit" href="javascript:void(0);">编辑</a></p>
                <p class="user_tel col-xs-12 col-sm-5 col-md-6 col-lg-4">{{ $userInfo->phone_number or '--'}}</p>
                <p class="user_email col-xs-12 col-sm-6 col-md-6 col-lg-6 {{$userInfo->emails or 'hidden'}}">{{ $userInfo->email or '--'}}</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pad-cr my-home-entrepreneur-info">
            <div class="b-all-3 bgc-0">
                <p>{{ isset($comments) ? $comments : 0 }}</p>
                <p class="mar-cb"><a href="{{ route('commentlike') }}">评论</a></p>
            </div>
            <div class="b-all-3 bgc-0">
                <p>{{ isset($countProjects) ? $countProjects : 0 }}</p>
                <p class="mar-cb"><a href="javascript:void(0);" class="toTheProject">项目</a></p>
            </div>
        </div>
        <!--基本信息结束-->

        <!--修改头像弹出框 Start-->
            @include('home.public.avatar')
        <!--修改头像弹出框 End-->

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <img src="{{asset('home/images/load.gif')}}" class="loading pull-right">
                <div class="modal-content">
                    <div class="modal-header bgc-6 fs-c-0">
                        <h4 class="modal-title">修改昵称</h4>
                    </div>
                    <!--第一步 填写-->
                    <div class="modal-body key-step-one">
                        <!-- 错误提示 Start-->
                        <div id="userInfoError" class="col-xs-12 alert alert-danger hidden"></div>
                        <div id="userInfoSuccess" class="col-xs-12 alert alert-success hidden"></div>
                        <!-- 错误提示 End-->
                        <div class="col-xs-12">
                            <label class="col-xs-12 control-label mar-b5">用户昵称</label>
                            <div class="col-xs-12">
                                <input type="text" name="nickname" maxlength="10" class="form-control form-title"  placeholder="输入新的昵称">
                            </div>
                            <div class="col-xs-12 nickname_sub">
                                <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs"  id="editSubmit">保存</button>
                                <button type="button" class="btn btn-default userInfoReset" data-dismiss="modal">取消</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-no h-align-1 pad-ct"></div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <!--修改昵称 结束-->
    </div>
    <!--我的主页内容结束-->
@endsection



@section('script')
    <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
    <script src="{{asset('cropper/js/main.js')}}"></script>
    <script src="{{asset('home/js/ajax/ajaxCommon.js')}}"></script>
    {{--用户中心--}}
    <script src="{{ asset('home/js/user/index.js') }}"></script>
@endsection
