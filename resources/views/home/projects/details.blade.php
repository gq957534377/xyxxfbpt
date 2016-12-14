@extends('home.layouts.master')

@section('title','创新作品详情')

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/content(pc).css') }}">
@endsection

@section('content')
    <section class="container-fluid hang">
        <div class="row vidio_block">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 top_left">
                {{--<img src="{{ asset('home/img/demoimg/test7.jpg') }}">--}}
                <img src="{{ $project_details->image }}">
            </div>
            <!--项目主要属性开始-->
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 top_right">
                <div class="row top_right_1">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 top_right_1_left">
                        <img src="{{ asset('home/img/demoimg/test8.jpg') }}">
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 top_right_1_right">
                        <h2>{{ $project_details->title }}</h2>
                        <p>精品娱乐内容生产者</p> <!--公司的简短标语-->
                    </div>
                </div>
                <div class="row top_right_2">
                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">北京</span>
                </div>
                <ul class="row top_right_3">
                    <li class="col-lg-6 col-md-6 col-sm-3">￥50-500万</li>
                    <li class="col-lg-6 col-md-6 col-sm-3">尚未获投</li>
                    <li class="col-lg-6 col-md-6 col-sm-3">1%-10%</li>
                    <li class="col-lg-6 col-md-6 col-sm-3">股权融资</li>
                    <li class="col-lg-6 col-md-6 col-sm-3">2016-12-31</li>
                </ul>
                <div class="row top_right_4">
                    <span class="col-lg-4 col-md-4 col-sm-4 col-xs-4">跨境电商</span>
                    <span class="col-lg-4 col-md-4 col-sm-4 col-xs-4">跨境管理系统</span>
                </div>
                <div class="row top_right_5">
                    <span class="col-lg-6 col-md-6 col-sm-6 col-xs-5">点赞（345）</span>
                    <span class="col-lg-6 col-md-6 col-sm-6 col-xs-5">12723人看过</span>
                </div>
            </div>
            <!--项目主要属性结束-->
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
                    <img class="col-lg-3 col-md-3 col-sm-3 col-xs-3" src="{{ $userinfo->headpic }}">
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <div class="row csrxx-1">
                            <span class="col-lg-3 col-md-3 col-sm-3 ">{{ $userinfo->realname }}</span>
                            <span class="col-lg-3 col-md-3 col-sm-3">
                                @if($userinfo->role == 2)
                                    创业者
                                @elseif($userinfo->role == 3)
                                    投资者
                                @endif
                            </span>
                        </div>
                        <div class="row csrxx-2">
                            <span class="col-lg-12 col-md-12 col-sm-12">杭州糖礼记科技信息有限公司 | 创始人</span>
                        </div>
                        <div class="row csrxx-3">
                            <p class="col-lg-12 col-md-12 col-sm-12">
                                牛津大学数学系本科、硕士毕业，帝国理工大学金融系硕士，毕业后就职于美银美林，2010年回国后分别任职于中信证券、中德证券、十年投融资经验，专注于TMT和金融行业
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
                    <img src="{{ $project_details->image }}" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </li>
                <li class="row content-row-left-title">
                    <h4>项目历程</h4>
                </li>
                <li class="row">
                    <ul class="row">
                        <li class="col-lg-2 col-md-2 col-sm-2">
                            2016年2月
                        </li>
                        <li class="col-lg-10 col-md-10 col-sm-10">
                            完成100期家庭课程 报名家庭1000个
                        </li>
                    </ul>
                    <ul class="row">
                        <li class="col-lg-2 col-md-2 col-sm-2">
                            2016年6月
                        </li>
                        <li class="col-lg-10 col-md-10 col-sm-10">
                            完成100期家庭课程 报名家庭1000个
                        </li>
                    </ul>
                    <ul class="row">
                        <li class="col-lg-2 col-md-2 col-sm-2">
                            2016年8月
                        </li>
                        <li class="col-lg-10 col-md-10 col-sm-10">
                            完成100期家庭课程 报名家庭1000个
                        </li>
                    </ul>
                    <ul class="row">
                        <li class="col-lg-2 col-md-2 col-sm-2">
                            2016年10月
                        </li>
                        <li class="col-lg-10 col-md-10 col-sm-10">
                            完成100期家庭课程 报名家庭1000个
                        </li>
                    </ul>
                    <ul class="row">
                        <li class="col-lg-2 col-md-2 col-sm-2">
                            2016年11月
                        </li>
                        <li class="col-lg-10 col-md-10 col-sm-10">
                            完成100期家庭课程 报名家庭1000个
                        </li>
                    </ul>
                </li>
                <li class="row content-row-left-title">
                    <h4>项目需求</h4>
                </li>
                <li class="row">
                    <p class="col-lg-12 col-md-12 col-sm-12">
                        种子轮求融资
                    </p>
                </li>
                <li class="row content-row-left-title">
                    <h4>成员信息</h4>
                </li>
                <!--成员信息开始-->
                <!--循环遍历开始-->
                <li class="row">
                    <div class="rowsd">
                        <img src="{{ $userinfo->headpic }}" class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <ul class="col-lg-9 col-md-9 col-sm-9 cyxx-ul">
                            <li class="row">
                                <span>CEO</span>
                                <span>{{ $userinfo->realname }}</span>
                            </li>
                            <li class="row">
                                <span>户外星球创始人</span>
                            </li>
                            <li class="row">
                                <p>中戏导演系毕业，中央3编导，凤凰卫视独立制片人，睿尔旭文化传播创始人，阿卡农庄联合创始人</p>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--循环遍历结束-->
                <li class="row">
                    <div class="rowsd">
                        <img src="{{ asset('home/img/demoimg/test11.jpg') }}" class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <ul class="col-lg-9 col-md-9 col-sm-9 cyxx-ul">
                            <li class="row">
                                <span>CEO</span>
                                <span>徐征</span>
                            </li>
                            <li class="row">
                                <span>户外星球创始人</span>
                            </li>
                            <li class="row">
                                <p>中戏导演系毕业，中央3编导，凤凰卫视独立制片人，睿尔旭文化传播创始人，阿卡农庄联合创始人</p>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--成员信息结束-->
            </ul>
            <ul class="col-lg-4 col-md-4 col-sm-12">
                <li class="row content_title">
                    <h3>更多信息</h3>
                </li>
                <li class="row gdxx">
                    <div class="kuang">
                        @if(session('user')->role != 3)
                            <div class="gdxx-content"></div>
                        @else
                            <a style="position: absolute;top: 50%;left: 36%;" href="{{ $project_details->file }}">项目详细资料</a>
                        @endif
                    </div>
                </li>
                <!--用户评论开始-->
                <div class="row pl-block">
                    <h2 class="col-lg-8 col-md-8 col-sm-8 col-xs-8">评论</h2>
                    <a href="{{asset('comment')}}" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">更多评论></a>
                    <ul class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <li class="row inputs">
                            <textarea>                    </textarea>
                            <button class="subbtn btn btn-warning">提交</button>
                        </li>
                        <!---循环遍历开始-->
                        <li class="row">
                            <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="user-img-bgs">
                                    <img src="{{ asset('home/img/demoimg/test11.jpg') }}">
                                </div>
                            </div>
                            <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                <div class="row user-say1">
                                    <span>Paloma</span>
                                    <span>2016-11-24 16:26</span>
                                </div>
                                <div class="row user-say2">
                                    <p>这个项目很有意思,我很喜欢,赞一个</p>
                                </div>
                            </div>
                        </li>
                        <li class="row">
                            <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="user-img-bgs">
                                    <img src="{{ asset('home/img/demoimg/test11.jpg') }}">
                                </div>
                            </div>
                            <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                <div class="row user-say1">
                                    <span>Paloma</span>
                                    <span>2016-11-24 16:26</span>
                                </div>
                                <div class="row user-say2">
                                    <p>这个项目很有意思,我很喜欢,赞一个</p>
                                </div>
                            </div>
                        </li>
                        <li class="row">
                            <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="user-img-bgs">
                                    <img src="{{ asset('home/img/demoimg/test11.jpg') }}">
                                </div>
                            </div>
                            <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                <div class="row user-say1">
                                    <span>Paloma</span>
                                    <span>2016-11-24 16:26</span>
                                </div>
                                <div class="row user-say2">
                                    <p>这个项目很有意思,我很喜欢,赞一个</p>
                                </div>
                            </div>
                        </li>
                        <li class="row">
                            <div class="user-img col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="user-img-bgs">
                                    <img src="{{ asset('home/img/demoimg/test11.jpg') }}">
                                </div>
                            </div>
                            <div class="user-say col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                <div class="row user-say1">
                                    <span>Paloma</span>
                                    <span>2016-11-24 16:26</span>
                                </div>
                                <div class="row user-say2">
                                    <p>这个项目很有意思,我很喜欢,赞一个</p>
                                </div>
                            </div>
                        </li>
                        <!---循环遍历结束-->

                    </ul>
                </div>
                <!--用户评论结束-->
            </ul>
        </div>
    </section>
@endsection



