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
        {{--        {{ dd($ResultData) }}--}}
        @if($StatusCode == '200')

            @foreach($ResultData['data'] as $data)

                <div class="my-like-box pad-3 bb-1">
                    @if($data->type == 1)
                        @if(empty($data->title) || $data->title->status != 1)
                            <p>校园活动:</p>&nbsp&nbsp&nbsp<a style="color: red">
                                该活动已删除</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{date('Y-m-d H:m:s',$data->addtime)}}
                        @else
                            <h5>校园活动:</h5>&nbsp&nbsp&nbsp<a href="{{route('action.show', $data->action_id) }}">
                                {{ $data->title->title }}</a><p>
                                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{date('Y-m-d H:m:s',$data->addtime)}}</p>
                        @endif

                    @elseif($data->type == 2)
                        @if(empty($data->title) || $data->title->status != 1)
                            <p>校园文章:</p>&nbsp&nbsp&nbsp<a style="color: red">
                                该文章已删除</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{date('Y-m-d H:m:s',$data->addtime)}}
                        @else
                            <h5>校园文章:</h5>&nbsp&nbsp&nbsp<a href="{{route('article.show', $data->action_id) }}">
                                {{ $data->title->title }}</a><p>
                                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{date('Y-m-d H:m:s',$data->addtime)}}</p>
                        @endif
                    @elseif($data->type == 3)
                        @if(empty($data->title) || $data->title->status != 1)
                            <p>通知:</p>&nbsp&nbsp&nbsp<a style="color: red">
                                该通知已删除</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{date('Y-m-d H:m:s',$data->addtime)}}
                        @else
                            <h5>通知:</h5>&nbsp&nbsp&nbsp<a href="{{route('notice.show', $data->action_id) }}">
                                {{ $data->title->title }}</a><p>
                                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{date('Y-m-d H:m:s',$data->addtime)}}</p>
                        @endif

                    @elseif($data->type == 3)
                        @if(empty($data->title) || $data->title->status != 1)
                            <p>二手交易:</p>&nbsp&nbsp&nbsp<a style="color: red">
                                该商品已删除</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{date('Y-m-d H:m:s',$data->addtime)}}
                        @else
                            <h5>二手交易:</h5>&nbsp&nbsp&nbsp<a href="{{route('goods.show', $data->action_id) }}">
                                {{ $data->title->title }}</a><p>
                                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{date('Y-m-d H:m:s',$data->addtime)}}</p>
                        @endif

                    @endif
                    <div class="col-xs-12 zxz-comment">
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{$data->content}}
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endforeach
            <div class="page-style pull-right mar-emt15">
                {!! $ResultData['pages'] !!}
            </div>
        @elseif($StatusCode == '204')
            <div class="my-like-box pad-3 bb-1">
                暂无您的评论数据呦~亲
                <div class="clearfix"></div>
            </div>
        @else
            <div class="my-like-box pad-3 bb-1">
                {!! $ResultData !!}
                <div class="clearfix"></div>
            </div>
    @endif
    <!--分页-->
    </div>
@endsection

