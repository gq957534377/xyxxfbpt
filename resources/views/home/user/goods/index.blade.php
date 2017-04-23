@extends('home.layouts.userCenter')

@section('title','我的二手')

@section('style')
    <link href="{{ asset('home/css/user_center_my_road.css') }}" rel="stylesheet">
    <link href="{{asset('admin/css/sweet-alert.min.css')}}" rel="stylesheet">
    <style>
        .pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #ff9600;
            border-color: #ff9600;
        }
        .sweet-alert p {
            font-size: 14px;
            font-weight: 400;
            line-height: 22px;
        }
        button.confirm {
            background-color: #34c73b !important;
            box-shadow: none !important;
        }
        .sweet-alert .sa-icon.sa-success .sa-placeholder {
            border: 4px solid #34c73b;
        }
        .sweet-alert .sa-icon.sa-success .sa-line {
            background-color: #34c73b;
        }
        .sweet-alert .sa-icon.sa-error {
            border-color: #d74548;
        }
        .sweet-alert .sa-icon.sa-error .sa-line {
            background-color: #d74548;
        }
    </style>
@endsection

@section('content')
    <!--我参加的路演列表开始-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10  mar-clr my-road">
        <div>
            <span>我的二手交易</span>
        </div>
        <a href="{{ url('userGoods/create') }}" class="btn-success">发布商品</a>
        <!--活动列表块开始-->
        @if($StatusCode === '204')
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <center><span style="color: #999999">你还未发表任何商品呦~亲 O(∩_∩)O~</span></center>
            </li>
        @elseif($StatusCode == '200')
            <div id="list">
                @foreach($ResultData['data'] as $goods)
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4">
                            <a target="_blank" href="{{ url('goods/'.$goods->guid) }}">
                                <img src="{{ $goods->banner }}" alt="{{ $goods->name }}">
                            </a>
                        </div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt>
                                    <a href="{{ url('goods/'.$goods->guid) }}" target="_blank">
                                        {{ $goods->name }}
                                    </a>
                                    <a href="userGoods/{{ $goods->guid }}">修改</a>
                                    <a data-user="{{ $goods->guid }}" class="del">删除</a>
                                <h3 style="color: red">{{ $goods->price }}元</h3>
                                </dt>
                                <dd>
                                        <span class="name">
                                            <strong>QQ:</strong><span>{{ $goods->qq }}</span>&nbsp&nbsp <strong>电话:</strong><span>{{ $goods->tel }}</span>&nbsp&nbsp <strong>微信:</strong><span>{{ $goods->wechat }}</span>&nbsp&nbsp
                                        </span>
                                </dd>
                                <dt>
                                    <span class="time"> {{ date('Y-m-d H:m', $goods->addtime) }} </span></dt>
                                <dd class="text">{{ $goods->brief }}</dd>
                            </dl>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="panel pull-right" id="data">{!! $ResultData['pages'] !!}</div>
        @else
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span style="color: #999999">出错了呦~亲 /(ㄒoㄒ)/~~ 错误信息：{{$ResultData['data']}}错误码：{{$StatusCode}}</span>
            </li>
    @endif

    <!--活动列表块结束-->
    </div>
    <!--我参加的路演列表结束-->
@endsection

@section('script')
    <script src="{{ asset('admin/js/sweet-alert.min.js') }}"></script>
    <script>
        // 删除操作
        $('.del').click(function () {
            var This = $(this);
            var title = '确定删除';
            var message = '当前操作将永久删除该商品，此操作无法恢复';
            swal({
                title: title,
                text: message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '确定',
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    var url = '/userGoods/' + This.data('user') + '/edit';
                    $.ajax({
                        url: url,
                        success: function (data) {
                            if (data.StatusCode != '200') {
                                swal('删除失败', data.ResultData, "error");
                            } else {
                                swal('删除成功', data.ResultData, "success");
                                This.parents('.news-list').remove();
                            }
                        }
                    });
                } else {
                    swal("已取消！", "没有做任何修改！", "error");
                    return false;
                }
            });
            return false;
        })
    </script>
@endsection

