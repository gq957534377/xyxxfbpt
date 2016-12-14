@extends('home.layouts.master')

@section('title', '创新作品')

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/comment.css') }}">
@endsection
@section('content')
    <section class="bannerimg hang">
        <img src="{{ asset('home/img/demoimg/dd.jpg') }}">
    </section>
    <!---类型选择层开始---->
    <section class="container-fluid comment-section">
        <div class="row content">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 content-left">
                <div class="content-title">
                    <h2>[项目]微知养老护理人员服务培训公司[项目]微知养老护理人员服务培训公司[项目]微知养老护理人员服务培训公司</h2>
                    <a href="#">【返回原文】</a>
                </div>
                <div class="comment-block">
                    <div class="comment-top">
                        <div class="user-top row">
                            <div class="user-img-bgs">
                                <div class="user-img">
                                    @if(session("user"))
                                        <img src="{{session("user")->headpic}}">
                                    @else
                                        <img src="{{asset('home/img/icon_empty.png')}}">
                                    @endif
                                </div>
                            </div>
                            <div class="user-name">
                                @if(session('user'))
                                    <span>{{session('user')->nickname}}</span>
                                @else
                                    <span>无名氏</span>
                                @endif
                                <span>[创业者]</span>
                            </div>
                            <div class="comment-num">
                                已有<span>663</span>条评论，共<span>18337</span>人参与
                            </div>
                        </div>
                        <div class="user-input">
                            <textarea>
                            </textarea>
                        </div>
                        <div class="user-bottom">
                            <button class="btn btn-warning">发表评论</button>
                        </div>
                        <div class="line"></div>
                        <div class="comment-top-bottom">
                            <h3>最新评论</h3>
                            <button class="btn btn-default"><i class="fa fa-refresh"></i>刷新</button>
                        </div>
                    </div>
                    <ul class="comment-list">
                        <li class="row">
                            <div class="user-img-bgs">
                                <div class="user-img">
                                        <img src="{{asset('home/img/icon_empty.png')}}">
                                </div>
                            </div>
                            <div class="user-say-block">
                                <div class="user-info">
                                    <div class="user-name">
                                        <span>小文vvvvv</span>
                                        <span>[创业者]</span>
                                    </div>
                                    <div class="say-time">
                                        <span>2016-12-31</span>|
                                        <a href="#">举报</a>
                                    </div>
                                </div>
                                <p class="user-say">
                                    这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！
                                </p>
                            </div>
                        </li>
                        <li class="row">
                            <div class="user-img-bgs">
                                <div class="user-img">
                                    <img src="{{asset('home/img/icon_empty.png')}}">
                                </div>
                            </div>
                            <div class="user-say-block">
                                <div class="user-info">
                                    <div class="user-name">
                                        <span>小文vvvvv</span>
                                        <span>[创业者]</span>
                                    </div>
                                    <div class="say-time">
                                        <span>2016-12-31</span>|
                                        <a href="#">举报</a>
                                    </div>
                                </div>
                                <p class="user-say">
                                    这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！
                                </p>
                            </div>
                        </li>
                        <li class="row">
                            <div class="user-img-bgs">
                                <div class="user-img">
                                    <img src="{{asset('home/img/icon_empty.png')}}">
                                </div>
                            </div>
                            <div class="user-say-block">
                                <div class="user-info">
                                    <div class="user-name">
                                        <span>小文vvvvv</span>
                                        <span>[创业者]</span>
                                    </div>
                                    <div class="say-time">
                                        <span>2016-12-31</span>|
                                        <a href="#">举报</a>
                                    </div>
                                </div>
                                <p class="user-say">
                                    这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！
                                </p>
                            </div>
                        </li>
                        <li class="row">
                            <div class="user-img-bgs">
                                <div class="user-img">
                                    <img src="{{asset('home/img/icon_empty.png')}}">
                                </div>
                            </div>
                            <div class="user-say-block">
                                <div class="user-info">
                                    <div class="user-name">
                                        <span>小文vvvvv</span>
                                        <span>[创业者]</span>
                                    </div>
                                    <div class="say-time">
                                        <span>2016-12-31</span>|
                                        <a href="#">举报</a>
                                    </div>
                                </div>
                                <p class="user-say">
                                    这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！
                                </p>
                            </div>
                        </li>
                        <li class="row">
                            <div class="user-img-bgs">
                                <div class="user-img">
                                    <img src="{{asset('home/img/icon_empty.png')}}">
                                </div>
                            </div>
                            <div class="user-say-block">
                                <div class="user-info">
                                    <div class="user-name">
                                        <span>小文vvvvv</span>
                                        <span>[创业者]</span>
                                    </div>
                                    <div class="say-time">
                                        <span>2016-12-31</span>|
                                        <a href="#">举报</a>
                                    </div>
                                </div>
                                <p class="user-say">
                                    这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！这篇文章很有意思，我很喜欢这个创意！
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 content-right">
                <div class="guangao row">
                    <a href="#"><img class="col-lg-12 col-md-12" src="{{ asset('home/img/test13.jpg') }}"></a>
                </div>
                <div class="row news-list-title">
                    <h2>7×24h 快讯</h2>
                </div>
                <ul class="row news-list">
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
                        <div class="news-list-time">
                            <span>两分钟前</span>
                        </div>
                    </li>
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
                        <div class="news-list-time">
                            <span>两分钟前</span>
                        </div>
                    </li>
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
                        <div class="news-list-time">
                            <span>两分钟前</span>
                        </div>
                    </li>
                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3><a href="#">前微软WP主管乔北峰长假回归 新岗位或将得罪不少用户</a></h3>
                        <div class="news-list-time">
                            <span>两分钟前</span>
                        </div>
                    </li>
                </ul>
                <!-- <div class="btn-ll">
                  浏览更多
                </div> -->
            </div>
        </div>
    </section>
    <!---类型内容层结束---->
@endsection