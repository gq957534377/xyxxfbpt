@extends('home.layouts.master')

@section('title','创新作品详情')

@section('style')
    <link href="{{ asset('home/css/sweet-alert.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/content.css') }}">
@endsection

@section('content')
    <section class="container-fluid hang">
        <div class="row vidio_block">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 top_left">
                {{--<img src="{{ asset('home/img/demoimg/test7.jpg') }}">--}}
                <img src="{{ $project_details->banner_img }}">
            </div>
            <!--项目主要属性开始-->
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 top_right">
                <div class="row top_right_1">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 top_right_1_left">
                        <img src="{{ $project_details->logo_img }}">
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 top_right_1_right">
                        <h2>{{ $project_details->title }}</h2>
                        <p>{{$project_details->brief_content}}</p> <!--公司的简短标语-->
                    </div>
                </div>
                <div class="row top_right_2">
                    {{--<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">北京</span>--}}
                </div>
                <ul class="row top_right_3">

                    <li class="col-lg-6 col-md-6 col-sm-3">
                        @if($project_details->financing_stage == 1)
                            种子轮
                        @elseif($project_details->financing_stage == 2)
                            天使轮
                        @elseif($project_details->financing_stage == 3)
                            Pre-A轮
                        @elseif($project_details->financing_stage == 4)
                            A轮
                        @elseif($project_details->financing_stage == 5)
                            B轮
                        @elseif($project_details->financing_stage == 6)
                            C轮
                        @elseif($project_details->financing_stage == 7)
                            D轮
                        @elseif($project_details->financing_stage == 8)
                            E轮
                        @elseif($project_details->financing_stage == 9)
                            F轮已上市
                        @elseif($project_details->financing_stage == 10)
                            其他
                        @endif
                    </li>
                    <li class="col-lg-6 col-md-6 col-sm-3">{{date('Y-m-d',$project_details->changetime)}}</li>
                    {{--<li class="col-lg-6 col-md-6 col-sm-3">￥50-500万</li>--}}
                    {{--<li class="col-lg-6 col-md-6 col-sm-3">1%-10%</li>--}}
                    {{--<li class="col-lg-6 col-md-6 col-sm-3">股权融资</li>--}}
                </ul>
                <div class="row top_right_4">
                   <span class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                         @if($project_details->industry == 1)
                           TMT
                       @elseif($project_details->industry == 2)
                           医疗健康
                       @elseif($project_details->industry == 3)
                           文化与创意
                       @elseif($project_details->industry == 4)
                           智能硬件
                       @elseif($project_details->industry == 5)
                           教育
                       @elseif($project_details->industry == 6)
                           电商
                       @elseif($project_details->industry == 7)
                           旅游
                       @elseif($project_details->industry == 8)
                           型农业
                       @elseif($project_details->industry == 9)
                           互联网金融
                       @elseif($project_details->industry == 10)
                           游戏
                       @elseif($project_details->industry == 11)
                           汽车后市场
                       @elseif($project_details->industry == 12)
                           企业级服务
                       @elseif($project_details->industry == 13)
                           数据服务
                       @elseif($project_details->industry == 14)
                           其他
                       @endif
                    </span>
                </div>
                    {{--<div class="row top_right_5">--}}
                    {{--@if($likeStatus == 1)--}}
                    {{--<span id="like"  data-id="{{$project_details->guid}}" class="bang col-lg-6 col-md-6 col-sm-6 col-xs-5">点赞（<span id="likeNum">{{$likeNum}}</span>）</span>--}}
                    {{--@else--}}
                        {{--<span id="like"  data-id="{{$project_details->guid}}" class="col-lg-6 col-md-6 col-sm-6 col-xs-5">点赞（<span id="likeNum">{{$likeNum}}</span>）</span>--}}
                    {{--@endif--}}
                    {{--<span class="col-lg-6 col-md-6 col-sm-6 col-xs-5">12723人看过</span>--}}
                {{--</div>--}}

            <!--项目主要属性结束-->
        </div>
        </div>
    </section>
    <section class="container-fluid hang content">
        <div class="row content-row">
            <div id='content_title' class="col-lg-12  col-md-12 col-sm-12 content_title">
                <h3>项目详情</h3>
            </div>
        </div>
        <div id="content-row" class="row content-row">
            <ul id="content-row-left" class="col-lg-8 col-md-8 col-sm-12">
                <li class="row content-row-left-title">
                    <h4>创始人信息</h4>
                </li>
                <li class="row">
                    <img class="col-lg-3 col-md-3 col-sm-3 col-xs-3" src="{{ $project_details->userInfo->headpic }}">
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <div class="row csrxx-1">
                            <span class="col-lg-12 col-md-12 col-sm-12 ">{{ $project_details->userInfo->realname }}</span>
                            {{--<span class="col-lg-3 col-md-3 col-sm-3">--}}
                                {{--@if($project_details->userInfo->role == 2)--}}
                                    {{--创业者--}}
                                {{--@elseif($project_details->userInfo->role == 3)--}}
                                    {{--投资者--}}
                                {{--@endif--}}
                            {{--</span>--}}
                        </div>
                        <div class="row csrxx-2">
                            <span class="col-lg-12 col-md-12 col-sm-12">
                                {{--杭州糖礼记科技信息有限公司 | @if($project_details->userInfo->role == 2)--}}
                                    创业者
                                {{--@elseif($project_details->userInfo->role == 3)--}}
                                    {{--投资者--}}
                                {{--@endif--}}
                            </span>
                        </div>
                        <div class="row csrxx-3">
                            <p class="col-lg-12 col-md-12 col-sm-12">
                                {{--牛津大学数学系本科、硕士毕业，帝国理工大学金融系硕士，毕业后就职于美银美林，2010年回国后分别任职于中信证券、中德证券、十年投融资经验，专注于TMT和金融行业--}}
                            </p>
                        </div>
                    </div>
                </li>
                <li class="row content-row-left-title">
                    <h4>项目详情</h4>
                </li>
                <li class="row">
                    <p class="col-lg-12 col-md-12 col-sm-12 fwb-p">
                        {{ $project_details->content }}
                    </p>
                    <img src="{{ $project_details->banner_img}}" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </li>
                <li class="row content-row-left-title">
                    <h4>项目历程</h4>
                </li>
                <li class="row">
                    @if(is_array($project_details->project_experience))
                        @foreach($project_details->project_experience as $temp)
                            <ul class="row">
                                <li class="col-lg-2 col-md-2 col-sm-2">
                                    {{$temp[0]}}
                                </li>
                                <li class="col-lg-10 col-md-10 col-sm-10">
                                    {{$temp[1]}}
                                </li>
                            </ul>
                        @endforeach
                    @endif
                </li>
                {{--<li class="row content-row-left-title">--}}
                    {{--<h4>项目需求</h4>--}}
                {{--</li>--}}
                {{--<li class="row">--}}
                    {{--<p class="col-lg-12 col-md-12 col-sm-12">--}}
                        {{--种子轮求融资--}}
                    {{--</p>--}}
                {{--</li>--}}
                <li class="row content-row-left-title">
                    <h4>成员信息</h4>
                </li>
                <!--成员信息开始-->
                <ul class="row">
                <!--循环遍历开始-->
                @if(is_array($project_details->team_member))
                    @foreach($project_details->team_member as $item)
                        <li class="row">
                            <div class="rowsd">
                                <img src="{{ $item[1] }}" class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <ul class="col-lg-9 col-md-9 col-sm-9 cyxx-ul">
                                    <li class="row">
                                        <span>{{ $item[2] }}</span>
                                        <span>{{ $item[0] }}</span>
                                    </li>
                                    {{--<li class="row">--}}
                                    {{--<span>户外星球创始人</span>--}}
                                    {{--</li>--}}
                                    <li class="row">
                                        <p>{{$item[3]}}</p>
                                    </li>
                                </ul>
                            </div>
                        </li>
                @endforeach
            @endif
                </ul>
                <!--循环遍历结束-->
                <div style="background-color: #ffffff;" class="row pl-block">
                    <h2 class="col-lg-8 col-md-8 col-sm-8 col-xs-8">评论</h2>
                    {{--<a href="{{asset('comment')}}" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">更多评论></a>--}}
                    <ul id="commentlist" class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!---循环遍历开始-->
                        <li class="row inputs">
                            <form id="comment" method = 'post'>
                                <input name="action_id" value="{{ $id}}" hidden>
                                <input name="type" value="2" hidden>
                                <textarea name="content" required></textarea>
                                <button type="submit" class="subbtn btn btn-warning" >提交</button>
                            </form>
                        </li>
                        @if($commentData['StatusCode'] == 200)
                            @foreach($commentData['ResultData'] as $datas)
                                <li class="row">
                                    <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <div class="user-img-bgs">
                                            <img src="{{ $datas->userImg }}">
                                        </div>
                                    </div>
                                    <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                        <div class="row user-say1">
                                            <span>{{ $datas->nikename }}</span>
                                            <span>{{ date('Y-m-d H:m:s',$datas->changetime) }}</span>
                                        </div>
                                        <div class="row user-say2">
                                            <p>{{ $datas->content }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                    @endif
                    <!---循环遍历结束-->

                    </ul>
                </div>
                <!--成员信息结束-->
            </ul>
            <ul class="col-lg-4 col-md-4 col-sm-12">
                <li class="row content_title">
                    <h3>更多信息</h3>
                </li>
                <li class="row gdxx">
                    <div class="kuang">

                        @if(session('user'))
                            @if(session('user')->role == 23||session('user')->role == 3||session('user')->guid == $project_details->user_guid)
                                <a class="projectZiliao" href="{{ $project_details->file }}">项目详细资料</a>
                            @else
                                <div class="gdxx-content"> <a href="{{ url('/user').'/'.session('user')->guid }}" style="display: block;height: 100%;width: 100%;"></a></div>
                            @endif
                        @else
                            <div class="gdxx-content">
                                <a href="{{route('login.index')}}" class="ziliaoWu"></a>
                            </div>
                        @endif

                    </div>
                </li>
                <!--用户评论开始-->
            </ul>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{asset('home/js/sweet-alert.min.js')}}"></script>
    <script src="{{asset('home/js/sweet-alert.init.js')}}"></script>
    <script src="{{ asset('home/js/commentValidate.js') }}"></script>
    <script>
        $('#like').click(function () {
            var temp = $(this).is('.bang')?-1:1;
            var str = $(this).is('.bang')?"点赞":"已赞";
            var num = parseInt($('#likeNum').html());
            var nowLikeNum = temp+num;
            var contentId = $(this).data('id');
            $.ajax({
                type:'get',
                url:'/action/'+contentId+'/edit',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{type:2},
                success:function (data) {
                    switch (data.StatusCode){
                        case '200':$('#like').toggleClass('bang').html(str+"（<span id='likeNum'>"+nowLikeNum+"</span>）");break;
                        case '400':alert(data.ResultData);break;
                        case '401':alert(data.ResultData);window.location.href = "{{route('login.index')}}";break;
                    }
                },
                error: function(XMLHttpRequest){
                    var number = XMLHttpRequest.status;
                    var msg = "Error: "+number+",数据异常！";
                    alert(msg);
                }
            })
        })
    </script>
@endsection


