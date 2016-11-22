<div class="list-group text-center">
    <a href="#" class="list-group-item active">
        <i class="text-md fa fa-list-alt" aria-hidden="true"></i>&nbsp;个人信息</a>
    <a href="#" class="list-group-item " data-toggle="modal" data-target="#myModal">
        <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;修改头像</a>

    <!--活动管理 start-->
    <a  href="activity" class="list-group-item ">
        <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;活动管理</a>
    <!--活动管理 end-->

    @if(session('user')->role == 1)
    <a href="#" class="list-group-item " data-toggle="modal" data-target="#myModal_1">
        <i class="text-md fa fa-bell" aria-hidden="true" style="margin-left: 40px;"></i>&nbsp;申请成为创业者
    </a>
    <a href="#" class="list-group-item" id="investor">
        <i class="text-md fa fa-user" aria-hidden="true" style="margin-left: 40px;"></i>&nbsp;申请成为投资者</a>

    @elseif(session('user')->role == 2)
    <!--项目发布 start-->
    <a id = 'publish_trigger' href="#" class="list-group-item " data-toggle="modal">
        <i class="text-md fa fa-bell" aria-hidden="true"></i>项目发布
    </a>
    <a id = 'publish_trigger2' href="#" style="display: none;" class="list-group-item " data-toggle="modal" data-target="#_projectPunlish">
        <i class="text-md fa fa-bell" aria-hidden="true"></i>项目发布
    </a>
    <!--项目发布 end-->

    <!--已发布项目管理 start-->
    <a id='all_pro_list' href="#" class="list-group-item " data-toggle="modal">
        <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;项目管理</a>
    <!--已发布项目管理 end-->
    @elseif(session('user')->role ==3)
        <!--已发布项目管理 start-->
            <a href="#" class="list-group-item ">
                <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;投资项目管理</a>
            <!--已发布项目管理 end-->
    @endif

</div>