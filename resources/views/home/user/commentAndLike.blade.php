@extends('home.layouts.userCenter')

@section('title','我的评论')

@section('style')
    <link href="{{asset('home/css/user_center_my_like_list.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!--导航结束-->
    <div class="active zxz-none col-xs-12 col-sm-9 col-md-9 col-lg-10 fs-15 bgc-1 pad-9">
        <div>
            <span><h3>我的评论</h3></span>
        </div>
        @if(!empty($commentData))

            @foreach($commentData as $data)

                <div class="my-like-box pad-3 bb-1">
                    <p class="col-xs-12">
                        @if($data->type == 1)
                            <a href="{{route('article.show', $data->action_id) }}">
                                <span>文章</span>
                                @if(!empty($data->contentTitle))
                                    {{$data->contentTitle}}
                                @endif
                            </a>
                        @elseif($data->type == 2)
                            <a href="{{route('project.show', $data->action_id) }}">
                                <span>项目</span>
                                @if(!empty($data->contentTitle))
                                    {{$data->contentTitle}}
                                @endif
                            </a>
                        @elseif($data->type == 3)
                            <a href="{{route('action.show', $data->action_id) }}">
                                <span>活动</span>
                                @if(!empty($data->contentTitle))
                                    {{$data->contentTitle}}
                                @endif
                            </a>
                        @elseif($data->type == 4)
                            <a href="{{route('school.show', $data->action_id) }}">
                                <span>活动</span>
                                @if(!empty($data->contentTitle))
                                    {{$data->contentTitle}}
                                @endif
                            </a>
                        @endif
                    </p>
                    <div class="col-xs-12 zxz-comment">
                        {{$data->content}}
                    </div>
                    <p class="col-xs-12 mar-cb">{{date('Y-m-d H:m:s',$data->changetime)}}</p>
                    <div class="clearfix"></div>
                </div>
            @endforeach
            <div class="page-style pull-right mar-emt15">
                {!! $commentPage['pages'] !!}
            </div>
        @else
            <div class="my-like-box pad-3 bb-1">
                暂无您的评论数据呦~亲
                <div class="clearfix"></div>
            </div>
    @endif
    <!--分页-->
    </div>
@endsection

