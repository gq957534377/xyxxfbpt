@extends('home.layouts.index')
@section('style')
    <script type="text/javascript" src="{{url('/qiniu/js/jquery.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/uploadbox.css')}}">
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/plupload.full.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/qiniu.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui2.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main2.js')}}"></script>
@endsection
@section('content')
    <section id="blog" class="container">
        <div class="center">
            <h2>{{$data->title}}</h2>
            <p class="lead">{{$data->brief}}</p>
        </div>

        <div class="blog">
            <div class="row">
                <div class="col-md-8">
                    <div class="blog-item">
                        <img class="img-responsive img-blog" src="/{{$data->banner}}" width="100%" alt="" />
                            <div class="row">  
                                <div class="col-xs-12 col-sm-2 text-center">
                                    <div class="entry-meta">
                                        <span id="publish_date">07  NOV</span>
                                        <span><i class="fa fa-user"></i> <a href="#"> John Doe</a></span>
                                        <span><i class="fa fa-comment"></i> <a href="blog-item.html#comments">2 Comments</a></span>
                                        <span><i class="fa fa-heart"></i><a href="#">56 Likes</a></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-10 blog-content">
                                    <h2>{{$data->author}}</h2>
                                    {!!$data->describe!!}
                                </div>
                            </div>
                        </div><!--/.blog-item-->

                        
                    @if(is_string($likeNum))
                        <p>{{$likeNum}}</p>
                    @else
                            <button class="btn-danger" id="support" onclick="like(1)">支持{{$likeNum[0]}}</button>
                            <button class="btn-custom" id="no_support" onclick="like(2)">不支持{{$likeNum[1]}}</button>
                        @endif
                        <h1 id="comments_title">Comments</h1>
                    <div id = 'comment_list'>

                    </div>


                        <div id="contact-page clearfix">
                            <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>评论 *</label>
                                            <textarea name="message" id="message" required class="form-control" rows="8"></textarea>
                                        </div>                        
                                        <div class="form-group">
                                            <button type="submit" id="comment" class="btn btn-primary btn-lg" required="required">提交</button>
                                        </div>
                                    </div>
                                </div>
                            </form>     
                        </div><!--/#contact-page-->
                    </div><!--/.col-md-8-->

                <aside class="col-md-4">
                    <div class="widget search">
                        <form role="form">
                                <input type="text" class="form-control search_box" autocomplete="off" placeholder="Search Here">
                        </form>
                    </div><!--/.search-->
    				
    				<div class="widget categories">
                        <h3>活动摘要</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>已报名人数：{{$data->people}}</div>
                                <div>活动名额：{{$data->limit}}</div>
                                <div>报名截止日期：{{$data->deadline}}</div>
                                <div>活动开始日期：{{$data->start_time}}</div>
                                <div>活动截止日期：{{$data->end_time}}</div>
                                @if($isHas)
                                    <div><button class="btn btn-success">已参加</button></div>
                                @else
                                    <div><button id="baoming" class="btn btn-success">我要报名</button></div>
                                @endif
                            </div>
                        </div>                     
                    </div><!--/.recent comments-->

                </aside>

            </div><!--/.row-->

         </div><!--/.blog-->

    </section><!--/#blog-->
    @include('home.validator.publishValidator')
@endsection

@section('script')
    @include('home.user.ajax.ajaxRequire')
    <script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script>
    <script>
        //报名按钮
        $('#baoming').click(function () {
                    @if($isLogin)
            var data = {
                        user_id:'{{$isLogin}}',
                        action_id:'{{$data->guid}}',
                    };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/action',
                type:'post',
                data:data,
                success : function (data) {
                    console.log(data);
                    if(data.StatusCode == 200){
                        alert('报名成功！');
                        $('#baoming').html('已参加');
                        $('#baoming').attr('class','btn-default');
                    }else{
                        alert(data.ResultData);
                    }
                },
            });
            @else
                alert('您还未登录，请登录');
            @endif
        });
        //评论按钮
        $('#comment').click(function () {
                    @if($isLogin)
            var data = {
                        user_id:'{{$isLogin}}',
                        action_id:'{{$data->guid}}',
                        content:$('#message').val()
                    };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(data);
            $.ajax({
                url: '/action/create',
                data:data,
                success : function (data) {
                    console.log(data);
                    if(data.StatusCode == 200){
                        alert('评论成功！');
                        list();
                        $('#message').val('');
                    }else{
                        alert(data.ResultData);
                    }
                },
            });
            @else
                alert('您还未登录，请登录');
            @endif
        });

        //评论列表
        function list(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/action/{{$data->guid}}',
                type: 'put',
                success : function (data) {
                    console.log(data);
                    if(data.StatusCode == 200){
                        $('#comment_list').html('');
                        data.ResultData.map(function (item) {
                            $('#comment_list').append('<div class="media comment_section">' +
                                    '<div class="pull-left post_comments">' +
                                    '<a href="#"><img src='+item.headpic+' class="img-circle"/></a>' +
                                    '</div>' +
                                    '<div class="media-body post_reply_comments">' +
                                    '<h3>'+item.user_name+'</h3>' +
                                    '<h4>'+item.time+'</h4>' +
                                    '<p>'+item.content+'</p>' +
                                    '<a href="#">Reply</a>');
                        });
                        $('#comments_title').html(data.ResultData.length+'Comments');
                    }else{
                        $('#comment_list').html('<p>'+data.ResultData+'</p>');
                    }
                }
            });
        }
        list();
        //点赞按钮
        function like(support) {
            @if($isLogin)
            $.ajax({
                url: '/action/{{$data->guid}}/edit',
                data:{support:support},
                success : function (data) {
                    console.log(data);
                    if(data.StatusCode == 200){
                        $('#support').html('支持'+data.ResultData[0]);
                        $('#no_support').html('不支持'+data.ResultData[1]);
                        alert('点赞成功');
                    }else{
                        alert(data.ResultData);
                    }
                },
            });
            @else
            alert('还未登陆，请登录');
            @endif
        }
    </script>
    @include('home.user.ajax.ajaxRequire')
    @include('home.validator.UpdateValidator')
@endsection