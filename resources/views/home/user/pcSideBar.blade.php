<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
    <aside class="hidden-xs">
        <ul id="js_zxz" class="list-unstyled">
            <li><a zxz-data="user" href="{{ route('user.show', ['id' => session('user')->guid]) }}">我的主页</a></li>
            <li><a zxz-data="identity" href="{{ route('identity.index', ['identity' => 'hero']) }}">英雄会报名</a></li>
            <li><a zxz-data="myProject" href="/user/myProject">我的项目</a></li>
            <li><a zxz-data="activity" href="{{ route('activity.index') }}">参加的活动</a></li>
            <li><a zxz-data="send" href="{{ route('send.index') }}">我的投稿</a></li>
            <li><a zxz-data="commentandlike" href="{{ route('commentlike') }}">点赞和评论</a></li>
            <li><a zxz-data="account" href="{{ route('user.edit', ['id' => session('user')->guid]) }}">账号设置</a></li>
        </ul>
    </aside>
</div>