@extends('home.layouts.userCenter')

@section('title','我的文章')

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
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10  mar-clr my-road">
        <div>
            <span>我的文章</span>
        </div>
        <div class="tab-info-top col-xs-12 col-sm-9 col-md-9 col-lg-10 pad-clr">
            <a id="contribute" class="hidden-xs btn @if(empty($status)) btn-success @else btn-default @endif"
               href="/send/create">&nbsp;&nbsp;投稿&nbsp;&nbsp;<span class="triangle-down left-2"></span></a>
            <a class="pad-tab-top-info-xs btn @if($status == 2) btn-success @else btn-default @endif"
               href="/send?status=2">审核中({{ $num['2'] or 0 }})<span class="triangle-down left-2"></span></a>
            <a class="pad-tab-top-info-xs btn @if($status == 1) btn-success @else btn-default @endif"
               href="/send?status=1">已发表({{ $num['1'] or 0 }})<span class="triangle-down left-2"></span></a>
            <a class="pad-tab-top-info-xs btn @if($status == 3) btn-success @else btn-default @endif"
               href="/send?status=3">已退稿({{ $num['3'] or 0 }})<span class="triangle-down left-2"></span></a>
            <a class="pad-tab-top-info-xs btn @if($status == 4) btn-success @else btn-default @endif"
               href="/send?status=4">草稿箱({{ $num['4'] or 0 }})<span class="triangle-down left-2"></span></a>
        </div>
        <!--列表块开始-->
        @if($StatusCode === '204')
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <center><span style="color: #999999">你还未发表任何文章呦~亲 O(∩_∩)O~</span></center>
            </li>
        @elseif($StatusCode == '200')
            <div id="list">
                @foreach($ResultData['data'] as $val)
                    <div class="news-list">
                        <div class="news-img col-xs-5 col-sm-5 col-md-4"><a target="_blank"
                                                                            href="{{ url('article/'.$val->guid) }}"><img
                                        onerror="this.src='{{asset('home/img/zxz.png')}}'" src="{{ $val->banner }}"
                                        alt="{{ $val->title }}">
                            </a></div>
                        <div class="news-info col-xs-7 col-sm-7 col-md-8">
                            <dl>
                                <dt>
                                    <a style="width: 50%" href="{{ url('article/'.$val->guid) }}" target="_blank">
                                        {{ $val->title }}
                                    </a>
                                    @if(in_array($val->status,[1,4]))
                                        <a href="javascript:void (0)"
                                           style="float: right;font-size: 12px;width: 10%" class="del"
                                           data-id="{{ $val->guid }}">删除</a>
                                    @endif
                                    @if(in_array($val->status,[3,4]))
                                        <a href="{{ url("send/{$val->guid}") }}"
                                           style="float: right;font-size: 12px;width: 10%">修改</a>
                                    @endif
                                </dt>
                                <dd>
                                        <span class="name">
                                            <a title="由 {{ $val->author }} 发布" rel="author">{{ $val->author }}</a>
                                        </span>
                                    <span class="identity"></span>
                                    <span class="time"> {{ date('Y-m-d H:m', $val->addtime) }} </span>
                                </dd>
                                <dd class="text">{{ $val->brief }}</dd>
                            </dl>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="panel pull-right" id="data">{!! $ResultData['pages'] !!}</div>
        @else
            <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span style="color: #999999">出错了呦~亲 /(ㄒoㄒ)/~~ 错误信息：{{$ResultData}}错误码：{{$StatusCode}}</span>
            </li>
    @endif
    <!--活动列表块结束-->
    </div>
    <!--我参加的活动列表结束-->
@endsection

@section('script')
    <script src="{{ asset('admin/js/sweet-alert.min.js') }}"></script>
    <script>
        // 删除操作
        $('.del').click(function () {
            var This = $(this);
            var title = '确定删除';
            var message = '当前操作将永久删除该文章，此操作无法恢复';
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
                    var url = '/send/' + This.data('id') + '/edit';
                    $.ajax({
                        url: url,
                        data: {'status': 3},
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

