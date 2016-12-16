@extends('home.layouts.master')

@section('title', '活动详情')

@section('style')
    <link href="{{ asset('home/css/roading-details.css') }}" rel="stylesheet">
@endsection

@section('menu')
    @parent
@endsection

@section('content')
    <!--活动详情banner 开始-->
    <section class="container road-banner bgc-1 mar-emt1 pad-7 pad-7-xs">
        <h4 class="mar-ct mar-b15">{{ $data->title }}</h4>
        <p class="mar-b15"><span>时间：</span>{{ $data->start_time }}——{{ $data->end_time }}</p>
        <p class="mar-b15"><span>地点：</span>{{ $data->address }}</p>
        <p class="mar-emt60 mar-b15">已报名{{ $data->people }}人</p>

        <!--两个按钮按照情况只显示一个-->
        @if($data->status == 1)
            @if(!$isHas)
        <button id="js_enroll" type="button" class="btn btn-primary bgc-2 b-n btn-1">我要报名</button>
            @else
                <button style="background: #3E8CE6;" type="button" class="btn btn-primary bgc-2 b-n btn-1">已报名</button>
            @endif
        @elseif($data->status == 5)
            <button type="button" class="btn btn-info b-n disabled">报名截止</button>
        @elseif($data->status == 2)
            <button type="button" class="btn btn-info b-n disabled">活动已开始</button>
        @endif
    </section>
    <!--活动详情banner 结束-->
    <!--活动说明 & 评论 开始-->
    <section class="container">
        <span class="content-bar dis-in-bl mar-5 fs-18">活动说明</span>
        <div class="row bgc-0">
            <!--活动说明 开始-->
            <div class="col-md-9 col-lg-9 pad-clr mar-b15">
                <div class="br-1 pad-8 mar-r20 b-n-sm b-n-xs mar-cr-sm mar-cr-xs road-explain">
                    <p class="col-sm-6"><span>主办方：</span>{{ $data->author }}</p>
                    <p class="col-sm-6"><span>项目合作：</span>好园区  梦想接力</p>
                    <p class="col-sm-6"><span>合作伙伴：</span>微链</p>
                    <p class="col-sm-6"><span>场地合作：</span>初橙</p>
                    <p class="col-sm-6"><span>协作：</span>苏河汇、创客加速</p>
                    <div class="col-xs-12">
                        <img class="img-responsive" src="{{ asset('home/img/demoimg/u1591.png') }}">
                    </div>
                    <p class="col-xs-12">
                        <br>每月一期！<br>
                        仍然是8个优选创业项目！<br>
                        仍然是精选种子轮和天使轮项目<br>
                        仍然邀请20+投资机构<br><br>
                        第16期活动，将是结合项目路演和种子轮投资观点对话的盛会！
                    </p>

                    <p class="col-xs-12">
                        <br><br>
                        下图是14、15期活动场景
                    </p>
                    <div class="col-xs-12">
                        <img class="img-responsive" src="{{ asset($data->banner) }}">
                    </div>
                    <p class="col-xs-12">
                        <br>活动流程
                    </p>
                    <p class="col-sm-6">13:30-14:00  演讲</p>
                    <p class="col-sm-6">14:00-15:00  路演上半场（含休息时间）</p>
                    <p class="col-sm-6">15:00-15:30  沪杭种子轮投资对话1</p>
                    <p class="col-sm-6">15:30-16:30  路演下半场（含休息时间）</p>
                    <p class="col-sm-6">16:30-17:00  沪杭种子轮投资对话2</p>
                    <p class="col-xs-12">
                        <br>沪杭种子轮投资对话会
                    </p>
                    <p class="col-xs-12 indent">
                        在杭州有很多早期阶段投资的投资机构和投资人，而上海相对来说更后端的投资机构比较多。邀请关注种子轮投资的杭州投资人们来做专业的交流！这是实质性的对话，致力于对种子轮投资的专业认识的提升和交流“沪杭种子轮投资对话会”将和项目路演穿插进行，并结合路演的项目案例来展开！
                    </p>
                    <p class="col-xs-12">
                        <br>话题包括
                    </p>
                    <p class="col-xs-12 indent mar-b30">
                        本地创业者的状态，众筹投资，有潜力的新投资方向，种子轮投资应该如何定位（月中将逐渐披露一些参与嘉宾）。
                    </p>
                    <p class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
            <span class="collect">
              收藏
            </span>
                    </p>
                    <p class="col-lg-1 col-md-1 col-sm-1 col-xs-3 pad-cr pad-clr-md pad-cl-sm line-h-36">分享到</p>
                    <div class="bdsharebuttonbox col-lg-3 col-md-4 col-sm-4 col-xs-9 pad-clr pad-l30-md pad-l30-sm">
                        <a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                        <script>
                            window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};
                            with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
                        </script>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--活动说明 结束-->
            <!--活动评论 开始-->
            <div class="col-md-3 col-lg-3 road-comment road-banner pl-block">
                <h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">评论</h2>
                <ul id="commentlist" class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!---循环遍历开始-->
                    <li class="row inputs">
                        <form id="comment" method = 'post'>
                            <input name="action_id" value="{{ $contentId}}" hidden>
                            <input name="type" value="3" hidden>
                            <textarea name="content" required>
                            </textarea>
                            <button type="submit" class="subbtn btn btn-warning" >提交</button>
                        </form>
                    </li>
                    @if($comment['StatusCode'] == 200)
                        @foreach($comment['ResultData'] as $datas)
                            <li class="row">
                                <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div class="user-img-bgs">
                                        <img src="{{ $datas->userImg }}">
                                    </div>
                                </div>
                                <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="row user-say1">
                                        <span>{{ $datas->nikename }}</span>
                                        <span>{{ $datas->time }}</span>
                                    </div>
                                    <div class="row user-say2">
                                        <p>{{ $datas->content }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        <div class="row">
                            <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="user-img-bgs">

                                </div>
                            </div>
                            <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                <div class="row user-say1">
                                </div>
                                <div class="row user-say2">
                                    <p><a href="#">更多</a></p>
                                </div>
                            </div>
                        </div>
                    @else
                        <li class="row">
                            <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">

                            </div>
                            <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">

                                <div class="row user-say2">
                                    <p>暂无评论</p>
                                </div>
                            </div>
                        </li>
                @endif
                    <!---循环遍历结束-->

                </ul>
                <div class="clearfix"></div>
            </div>
            <!--活动评论 结束-->
        </div>
    </section>
    <!--活动说明 & 评论 结束-->
@endsection
@section('script')
    <script src="{{ asset('home/js/commentValidate.js') }}"></script>
    <script>
        @if($isLogin)
        $('#js_enroll').click(function(){
            var obj = $(this);
            $.ajax({
                type:'post',
                url:"{{route('action.store')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{user_id:"{{session('user')->guid}}",action_id:"{{$data->guid}}"},
                success:function (data) {
                    switch (data.StatusCode){
                        case '200':obj.html("已报名").css({background:"#3E8CE6"}).unbind("click");break;
                        case '400':alert(data.ResultData);break;
                    }
                }
            })
        });
        $('.collect').click(function () {
            var obj = $(this);
            $.ajax({
                type:"get",
                url:"/article/{{$data->guid}}/edit",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (data) {
                    switch (data.StatusCode){
                        case '200':obj.html("已收藏").unbind("click").parent('p').addClass('taoxin');break;
                        case '400':alert(data.ResultData);break;
                    }
                }
            })
        })
        @else
            $('#js_enroll').click(function(){
                login();
        });
            $('.collect').click(function () {
                    login()
            });
        @endif
        function login() {
            window.location.href = "{{route('login.index')}}"
        }
    </script>
@endsection
