<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
    <aside class="hidden-xs">
        <ul class="list-unstyled">
            <li><a zxz-data="user" href="{{ route('user.index') }}">个人资料</a></li>
            <li><a zxz-data="identity" href="{{ route('identity.index') }}">我的身份</a></li>
            <li><a href="{{ route('identity.index',['identity' => 'hero']) }}">奇立英雄会报名</a></li>
            <li><a href="">我的项目</a></li>
            <li><a href="">创业大赛报名</a></li>
            <li><a href="{{ route('activity.index') }}">参加的活动</a></li>
            <li><a href="/send">我的投稿</a></li>
            <li><a href="/commentandlike">点赞和评论</a></li>
            <li><a href="#">账号设置</a></li>
        </ul>
    </aside>
</div>