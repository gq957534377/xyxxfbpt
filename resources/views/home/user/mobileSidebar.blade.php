{{--<div class="container-fluid mobile-aside navbar-fixed-top">--}}
    {{--<span class="dropdown-toggle" data-toggle="dropdown"></span>--}}
    {{--<ul class="list-unstyled dropdown-menu" role="menu">--}}
        {{--<li><a href="{{ route('user.index') }}">个人资料</a></li>--}}
        {{--<li><a href="{{ route('identity.index') }}">我的身份</a></li>--}}
        {{--<li><a href="{{ route('identity.index',['identity' => 'hero']) }}">英雄会报名</a></li>--}}
        {{--<li><a href="">我的项目</a></li>--}}
        {{--<li><a href="{{ route('activity.index') }}">参加的活动</a></li>--}}
        {{--<li><a href="{{ route('send.index') }}">我的投稿</a></li>--}}
        {{--<li><a href="#">点赞和评论</a></li>--}}
        {{--<li><a href="{{ route('user.edit', ['id' => session('user')->guid]) }}">账号设置</a></li>--}}
    {{--</ul>--}}
{{--</div>--}}
<!--移动设备menu开始-->
<div class="container-fluid mobile-aside">
    <div class="container">
        <ul class="list-unstyled col-xs-12">
            <li class="bgc-2"><a href="{{ route('user.index') }}">我的主页</a></li>
            <li><a href="{{ route('identity.index',['identity' => 'hero']) }}">英雄会报名</a></li>
            <li><a href="#">我的项目</a></li>
            <li><a href="{{ route('activity.index') }}">参加的活动</a></li>
            <li><a href="{{ route('send.index') }}">我的投稿</a></li>
            <li><a href="#">点赞和评论</a></li>
            <li><a href="{{ route('user.edit', ['id' => session('user')->guid]) }}">账号设置</a></li>
        </ul>
    </div>
</div>
<!--移动设备menu结束-->