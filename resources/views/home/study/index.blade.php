@extends('home.layouts.master')

@section('title', '校园学习')

@section('menu')
    @parent
@endsection

@section('content')
    <div class="content-wrap"><!--内容-->
        <div class="content">
            <div class="content-block new-content">
                <ul class="min_title">
                    <li class=" btn btn-default"><a href="{{ url('/jisuanji') }}">计算机等级考试查询</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

