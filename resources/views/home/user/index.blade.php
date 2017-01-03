@extends('home.layouts.userCenter')

@section('title','用户中心')

@section('style')
    <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
    <link href="{{asset('home/css/user_center_my_home.css')}}" rel="stylesheet"/>

@endsection

@section('content')

    <!--我的主页内容开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 my-home fs-c-4 fs-14">
        <!--基本信息开始-->
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pad-cl my-home-basic">
            <!-- 头像修改 Start -->
            <div class="col-sm-2 col-md-3 col-lg-2 pad-clr">
                <div class="ibox-content">
                    <div class="row">
                        <div id="crop-avatar">
                            <div class="avatar-view" title="">
                                <img class="user_avatar img-circle"
                                     src="{{ session('user')->headpic ? session('user')->headpic : asset('home/img/user_center.jpg') }}" alt="Logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 头像修改 End -->
            <div class="col-sm-10 col-md-9 col-lg-10 pad-clr">
                <p class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad-cr">昵称：<span class="user_nickname">{{ $userInfo->nickname or '--'}}</span><a id="userInfoEdit" href="javascript:void(0);">编辑</a></p>
                <p class="user_tel col-xs-12 col-sm-5 col-md-6 col-lg-4">{{ $userInfo->tel or '--'}}</p>
                <p class="user_email col-xs-12 col-sm-6 col-md-6 col-lg-6 {{$userInfo->emails or 'hidden'}}">{{ $userInfo->email or '--'}}</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pad-cr my-home-entrepreneur-info">
            <div class="b-all-3 bgc-0">
                <p>0</p>
                <p class="mar-cb"><a href="{{ route('commentlike') }}">评论</a></p>
            </div>
            <div class="b-all-3 bgc-0">
                <p>999</p>
                <p class="mar-cb"><a href="">项目</a></p>
            </div>
        </div>
        <!--基本信息结束-->

        <!--修改头像弹出框 Start-->
            @include('home.public.avatar')
        <!--修改头像弹出框 End-->

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <img src="{{asset('home/img/load.gif')}}" class="loading pull-right">
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
                                <input type="text" name="nickname" class="form-control form-title"  placeholder="输入新的昵称">
                            </div>
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-4 wid-2-xs"  id="editSubmit">保存</button>
                                <button type="button" class="btn btn-default userInfoReset" data-dismiss="modal">取消</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-no h-align-1 pad-ct"></div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <!--修改密码 结束-->

        <!--创业者认证 未认证 和 审核中-->
        <div class="col-xs-12 pad-clr b-all-3 bgc-0 my-home-info my-home-min
                    @if(empty($roleInfo[2]))
                        {{ ($userInfo->role == 23 || $userInfo->role == 2) ? 'hidden' : ''}}
                    @else
                         hidden
                    @endif
                ">
            <div class="col-xs-12 col-sm-9 pad-clr">
                <h4 class="col-xs-12 pad-clr my-home-title">创业者认证<span class="label label-warning hidden">审核中</span></h4>
                <p class="col-xs-12 pad-clr">认证成为创业者，XXXXXXXXXXXX</p>
            </div>
            <div class="col-xs-12 col-sm-3 pad-clr my-home-auth">
                <a href="{{ route('identity.index', ['identity' => 'syb']) }}" class="btn fs-15 btn-1 bgc-2 fs-c-1 zxz border-no" role="button">去认证</a>
            </div>
        </div>
        <!--创业者认证 已认证 和 审核中-->

        <!--创业者认证通过 开始-->
        <div class="col-xs-12 col-sm-12 col-md-12 pad-clr b-all-3 bgc-0 my-home-info my-home-min {{ !empty($roleInfo[2]) ? '' : 'hidden'}}">
            @if(!empty($roleInfo[2]))
            <h4 class="col-xs-12 pad-clr my-home-title">创业者认证
                @if($roleInfo[2]->status == 5)
                    <span class="label label-warning">待审核</span>
                @elseif($roleInfo[2]->status == 6)
                    <span class="label label-success">认证成功</span>
                @else
                    <span class="label label-danger">审核失败</span>
                    <a href="{{ route('identity.index', ['identity' => 'syb']) }}" class="pull-right fs-14">重新认证</a>
                @endif
                {{--<a href="{{ route('identity.edit', ['identity' => 'syb','id' => session('user')->guid]) }}" class="pull-right fs-14">编辑</a>--}}
            </h4>
            <div class="col-xs-12 pad-clr my-home-content">
                <p class="col-lg-6 pad-clr">真实姓名：<span>{{ $roleInfo[2]->realname or '--' }}</span></p>
                <p class="col-lg-6 pad-clr">毕业年份：<span>{{ $roleInfo[2]->graduation_year or '--' }} 年</span></p>
                {{--<p class="col-lg-6 pad-clr">身份证号：<span></span></p>--}}
                <p class="col-lg-6 pad-clr">学历层次：<span>{{ $roleInfo[2]->education or '--' }}</span></p>
                <p class="col-lg-6 pad-clr">所在院校：<span>{{ $roleInfo[2]->school_address or '--'}} {{ $roleInfo[2]->school_name or '暂无'}}</span></p>
                <p class="col-lg-6 pad-clr">专业名称：<span>{{ $roleInfo[2]->major or '--'}}</span></p>
                <p class="col-lg-6 pad-clr">入学年份：<span>{{ $roleInfo[2]->enrollment_year or '--'}} 年</span></p>
            </div>
            @else

            @endif

            @if(empty($roleInfo[2]->company) && $userInfo->role == 2)
                <h4 class="col-xs-12 pad-clr my-home-title">我管理的公司
                        {{--<a href="javascript:void(0)" class="pull-right fs-14 hidden fw-0 my-home-info-edit">编辑</a>--}}
                </h4>
                <div class="col-xs-12 pad-clr my-home-content">
                    <div class="com-bot"> <p>入驻英雄会，获取优质创业服务</p>
                        <a href="{{ route('user.create') }}" class="btn fs-15 btn-1 bgc-2 fs-c-1 zxz border-no" role="button">创建公司</a>

                    </div>
                </div>
            @elseif(!empty($roleInfo[2]->company))
                <h4 class="col-xs-10 pad-clr my-home-title">我管理的公司
                    @if($roleInfo[2]->company->status == 5 )
                        <span class="label label-warning"> 待审核 </span>
                    @elseif($roleInfo[2]->company->status == 6 )
                        <span class="label label-success"> 审核通过 </span>
                    @else
                        <span class="label label-danger"> 审核失败 </span>
                    @endif
                </h4>
                <div class="col-xs-12 pad-clr my-home-content">
                    <p class="col-lg-6 pad-clr">公司名称：<span>{{ $roleInfo[2]->company->company or '--'}}</span></p>
                    <p class="col-lg-6 pad-clr">公司网址：<span><a href="{{ $roleInfo[2]->company->url or '--'}}" target="_blank">{{ $roleInfo[2]->company->url or '暂无'}}</a></span></p>
                    <p class="col-lg-6 pad-clr">公司简介：<span>{{ $roleInfo[2]->company->abbreviation or '--'}}</span></p>
                    <p class="col-lg-6 pad-clr">领域：<span>{{ $roleInfo[2]->company->field or '--'}}</span></p>
                    <p class="col-lg-6 pad-clr">所在地：<span>{{ $roleInfo[2]->company->address or '--'}}</span></p>
                    <p class="col-lg-6 pad-clr">创始人姓名：<span>{{ $roleInfo[2]->company->founder_name or '--'}}</span></p>
                </div>
            @endif
        </div>
        <!--创业者认证通过 结束-->

        <!--投资者认证 未认证 和 审核中-->
        <div class="col-xs-12 pad-clr b-all-3 bgc-0 my-home-info my-home-min
                        @if(empty($roleInfo[3]))
                            {{ ( $userInfo->role == 23 || $userInfo->role == 3) ? 'hidden' : ''}}
                        @else
                            hidden
                        @endif
                   ">
            <div class="col-xs-12 col-sm-9 pad-clr">
                <h4 class="col-xs-12 pad-clr my-home-title">投资者认证<span class="label label-success hidden">认证</span></h4>
                <p class="col-xs-12 pad-clr">认证成为投资人，参加路演活动发现更多好项目！</p>
            </div>
            <div class="col-xs-12 col-sm-3 pad-clr my-home-auth">
                <a href="{{ route('identity.index', ['identity' => 'investor']) }}" class="btn fs-15 btn-1 bgc-2 fs-c-1 zxz border-no" role="button">去认证</a>
            </div>
        </div>
        <!--投资者认证 未认证 和 审核中-->

        <!--投资者认证通过 开始-->
        @if(!empty($roleInfo[3]))
        <div class="col-xs-12 col-sm-12 col-md-12 pad-clr b-all-3 bgc-0 my-home-info my-home-min {{ !empty($roleInfo[2]) ? '' : 'hidden'}}">
            <h4 class="col-xs-12 pad-clr my-home-title">投资者认证
                @if($roleInfo[3]->status == 5 )
                    <span class="label label-warning"> 待审核 </span>
                    {{--<a href="{{ route('identity.edit', ['identity' => 'investor','id' => $roleInfo[3]->guid]) }}" class="pull-right fs-14 fw-0 my-home-info-edit">编辑</a>--}}
                @elseif($roleInfo[3]->status == 6 )
                    <span class="label label-success"> 认证成功 </span>
                    {{--<a href="{{ route('identity.edit', ['identity' => 'investor','id' => $roleInfo[3]->guid]) }}" class="pull-right fs-14 fw-0 my-home-info-edit">编辑</a>--}}
                @else
                    <span class="label label-danger"> 审核失败 </span>
                    <a href="{{ route('identity.index', ['identity' => 'investor']) }}" class="pull-right fs-14">重新认证</a>
                @endif
            </h4>

            <div class="col-xs-12 pad-clr my-home-content">
                <p class="col-lg-6 pad-clr">真实姓名：<span>{{ $roleInfo[3]->realname or '--'}}</span></p>
                <p class="col-lg-6 pad-clr">从业年份：<span>{{ $roleInfo[3]->work_year or '--'}}年</span></p>
                <p class="col-lg-6 pad-clr">投资规模：<span>{{ $roleInfo[3]->scale or '--'}} 万</span></p>
                <p class="col-lg-6 pad-clr">所在公司：<span>{{ $roleInfo[3]->company or '--'}}</span></p>
                <p class="col-lg-6 pad-clr">所在地：<span>{{ $roleInfo[3]->company_address or '--'}}</span></p>
                <p class="col-lg-6 pad-clr">投资领域：<span>{{ $roleInfo[3]->field or '--'}}</span></p>
            </div>
        </div>
        @endif
        <!--投资者认证通过 结束-->

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
