<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
    <aside class="hidden-xs">
        <ul id="js_zxz" class="list-unstyled">
            <li><a class="sidebar-active sidebar-active-1" data-sidebar="user" href="{{ route('user.show', ['id' => session('user')->guid]) }}">我的主页</a></li>
            <li class="hidden"></li>
            {{--<li class="hidden"><a data-sidebar="identity" href="{{ route('identity.index', ['identity' => 'applyHero']) }}">英雄会报名</a></li>--}}
            <li><a class="@if(!(session('user')->role == 23 || session('user')->role == 2))
                              hidden
                         @endif" data-sidebar="myProject" href="/user/myProject">我的项目</a></li>
            <li><a data-sidebar="activity" href="/action_order?list=1&type=1&status=1">参加的活动</a></li>
            <li><a data-sidebar="send" href="{{ route('send.index') }}">我的投稿</a></li>
            <li><a data-sidebar="commentandlike" href="{{ route('commentlike') }}">我的评论</a></li>
            <li><a data-sidebar="account" href="{{ route('user.edit', ['id' => session('user')->guid]) }}">账号设置</a></li>
        </ul>
    </aside>
</div>