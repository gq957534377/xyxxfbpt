
<header class="container-fluid navbar-fixed-top">
    <div class="container">
        <div class="row change-row-margin">
            <div class="top-left">
                <a href="#"><img class="img-responsive" src="{{asset('heroHome/img/logo.jpg')}}"></a>
            </div>
            <div class="top-right">
                <a href="#"><img class="img-circle" src="{{ empty(session('user')->headpic) ? asset('heroHome/img/icon_empty.png') :  session('user')->headpic}}"></a>
                <a href="#">{{ empty(session('user')->nickname) ? '未设置' :  session('user')->nickname}}</a>
                <a href="#">英雄社区</a>
            </div>
        </div>
    </div>
</header>