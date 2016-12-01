<div class="col-md-3 box" style="padding: 15px 15px;">
    <div class="list-group text-center">
        <a href="{{url('/user')}}" id="editUserInfoBtn" class="list-group-item active" style="z-index: 0;">
            <i class="text-md fa fa-list-alt" aria-hidden="true"></i>&nbsp;个人信息</a>

        <a href="{{url('/user/apply/change')}}" class="list-group-item ">
            <i class="text-md fa fa-edit" aria-hidden="true"></i>&nbsp;账号改绑</a>

        <!--活动管理 start-->
        <a  href="{{url('/activity')}}" class="list-group-item ">
            <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;活动管理</a>
        <!--活动管理 end-->

        @if(session('user')->role == 1)
            <a href="{{url('/user/apply/syb')}}" class="list-group-item " id="entrepreneursBtn">
                <i class="text-md fa fa-bell" aria-hidden="true" style="margin-left: 40px;"></i>&nbsp;申请成为创业者
            </a>
            <a href="{{url('user/apply/investor')}}" class="list-group-item" id="investor">
                <i class="text-md fa fa-user" aria-hidden="true" style="margin-left: 40px;"></i>&nbsp;申请成为投资者</a>
            <a href="{{url('user/apply/memeber')}}" class="list-group-item" id="investor">
                <i class="text-md fa fa-group" aria-hidden="true" style="margin-left: 70px;"></i>&nbsp;申请成为英雄会会员</a>
        @elseif(session('user')->role == 2)
        <!--我的项目 start-->
            <a href="{{url('project_user/myproject')}}" class="list-group-item " data-toggle="modal">
                <i class="text-md fa fa-bell" aria-hidden="true"></i>我的项目
            </a>
            <!--我的项目 end-->

        @elseif(session('user')->role ==3)
        <!--已发布项目管理 start-->
            <a href="#" class="list-group-item ">
                <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;投资项目管理</a>
            <!--已发布项目管理 end-->
        @endif
        <a href="/send" class="list-group-item ">
            <i class="text-md fa fa-folder-open" aria-hidden="true" style="margin-left: 30px;"></i>&nbsp;我的文稿管理</a>
    </div>
</div>
