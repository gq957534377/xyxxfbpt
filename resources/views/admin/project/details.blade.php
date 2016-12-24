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
                <img src="{{ $data->banner_img }}">
            </div>
            <!--项目主要属性开始-->
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 top_right">
                <div class="row top_right_1">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 top_right_1_left">
                        <img src="{{ $data->logo_img }}">
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 top_right_1_right">
                        <h2>{{ $data->title }}</h2>
                        <p>{{ $data->brief_content }}</p> <!--公司的简短标语-->
                    </div>
                </div>
                <div class="row top_right_2">
                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">北京</span>
                </div>
                <ul class="row top_right_3">
                    {{--<li class="col-lg-6 col-md-6 col-sm-3">￥50-500万</li>--}}
                    <li class="col-lg-6 col-md-6 col-sm-3">
                        @if($data->financing_stage == 0)
                            种子轮
                        @elseif($data->financing_stage == 1)
                            天使轮
                        @elseif($data->financing_stage == 2)
                            Pre-A轮
                        @elseif($data->financing_stage == 3)
                            A轮
                        @elseif($data->financing_stage == 4)
                            B轮
                        @elseif($data->financing_stage == 5)
                            C轮
                        @elseif($data->financing_stage == 6)
                            D轮
                        @elseif($data->financing_stage == 7)
                            E轮
                        @elseif($data->financing_stage == 8)
                            F轮已上市
                        @elseif($data->financing_stage == 9)
                            其他
                        @endif
                    </li>
                    {{--<li class="col-lg-6 col-md-6 col-sm-3">1%-10%</li>--}}
                    {{--<li class="col-lg-6 col-md-6 col-sm-3">股权融资</li>--}}
                    <li class="col-lg-6 col-md-6 col-sm-3">{{date('Y-m-d',$data->changetime)}}</li>
                </ul>
                <div class="row top_right_4">
                    <span class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                         @if($data->industry == 0)
                            TMT
                        @elseif($data->industry == 1)
                            医疗健康
                        @elseif($data->industry == 2)
                            文化与创意
                        @elseif($data->industry == 3)
                            智能硬件
                        @elseif($data->industry == 4)
                            教育
                        @elseif($data->industry == 5)
                            电商
                        @elseif($data->industry == 6)
                            旅游
                        @elseif($data->industry == 7)
                            型农业
                        @elseif($data->industry == 8)
                            互联网金融
                        @elseif($data->industry == 9)
                            游戏
                        @elseif($data->industry == 10)
                            汽车后市场
                        @elseif($data->industry == 11)
                            企业级服务
                        @elseif($data->industry == 12)
                            数据服务
                        @elseif($data->industry == 13)
                            其他
                        @endif
                    </span>
                    {{--<span class="col-lg-4 col-md-4 col-sm-4 col-xs-4">跨境管理系统</span>--}}
                </div>
                <div class="row top_right_5">

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
                    <img class="col-lg-3 col-md-3 col-sm-3 col-xs-3" src="{{ $data->userInfo->headpic }}">
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <div class="row csrxx-1">
                            <span class="col-lg-3 col-md-3 col-sm-3 ">{{ $data->userInfo->realname }}</span>
                            <span class="col-lg-3 col-md-3 col-sm-3">
                                @if($data->userInfo->role == 2)
                                    创业者
                                @elseif($data->userInfo->role == 3)
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
                        {{ $data->content }}
                    </p>
                    <img src="{{ $data->banner_img }}" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </li>
                <li class="row content-row-left-title">
                    <h4>项目历程</h4>
                </li>
                <li class="row">
                    @if(is_array($data->project_experience))
                    @foreach($data->project_experience as $temp)
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
                <!--循环遍历开始-->
                @if(is_array($data->team_member))
                    @foreach($data->team_member as $item)
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
                <!--循环遍历结束-->
                <!--成员信息结束-->
            </ul>
            <ul class="col-lg-4 col-md-4 col-sm-12">
                <li class="row content_title">
                    <h3>更多信息</h3>
                </li>
                <li class="row gdxx">
                    <div class="kuang">
                            <a style="position: absolute;top: 50%;left: 36%;" href="{{ $data->file }}">项目详细资料</a>
                    </div>
                </li>
                <!--用户评论开始-->
                <!--用户评论结束-->
            </ul>
        </div>
    </section>
    <div style="width:100%;text-align: center;position: fixed;bottom: 60px;z-index: 1;">
        <button class="btn btn-success btn-lg">通过</button>
        <button class="btn btn-danger btn-lg">不通过</button>
    </div>
@endsection


