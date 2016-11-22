@extends('home.layouts.index')
@section('style')

@endsection
@section('content')
    <section id="contact-page">
        <div class="container main-container">
            <div class="users-show">
                <!--侧边菜单栏 Start-->
                <div class="col-md-3 box" style="padding: 15px 15px;">
                    @include('home.user.side')
                </div>

                <!--活动管理 Start-->
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <table class="table">
                        <caption>我参与的活动</caption>
                        <thead>
                        <tr>
                            <th>活动名称</th>
                            <th>活动类型</th>
                            <th>活动地址</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $v)
                            <tr>
                                <td>{{$v->title}}</td>
                                @if($v->type==1)
                                    <td>路演活动</td>
                                @elseif($v->type==2)
                                    <td>创业大赛</td>
                                @elseif($v->type==3)
                                    <td>技术培训</td>
                                @endif
                                <td>{{$v->address}}</td>
                                <td>{{$v->start_time}}</td>
                                <td>{{$v->end_time}}</td>
                                <td><button type="button" class="btn btn-info activity_cancle" activityId="{{$v->guid}}">取消报名</button></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                <!--活动管理 End-->
                </div>
        </div><!--/.container-->
    </section><!--/#contact-page-->
@endsection
@section('script')
    <script>
        $(function(){
            $('.activity_cancle').click(function(){
                $.ajax({
                    url:'',
                    type:'',
                    data:'',
                    success:function(){
                        alert('a');
                    }
                })
            })
        })
    </script>
    @endsection