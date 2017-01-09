@extends('home.layouts.master')

@section('title', '创新作品')

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/list.css') }}">
@endsection

@section('content')
<!-- 广告图 Start-->
    <section class="hang">
        <img src="{{ asset('home/img/demoimg/dd.jpg') }}">
    </section>
<!-- 广告图 End-->

<!--搜索行开始-->
<section class="hang container-fluid">
    <form>
        <ul class="row selected">
            <li class="col-lg-2 col-md-2 col-sm-2 col-xs-5">融资阶段：</li>
            <li class="col-lg-2 col-md-2 col-sm-2 col-xs-6 form-group">
                <div class="btn-group">
                    <button id="typeId" data-id="@if(empty($type)){!! 0 !!}@else{{$type}}@endif" type="button" class="btn">
                        @if(empty($type))
                            默认
                        @else
                            @if($type == 1)
                                种子轮
                            @elseif($type == 2)
                                天使轮
                            @elseif($type == 3)
                                Pre-A轮
                            @elseif($type == 4)
                                A轮
                            @elseif($type == 5)
                                B轮
                            @elseif($type == 6)
                                C轮
                            @elseif($type == 7)
                                D轮
                            @elseif($type == 8)
                                E轮
                            @elseif($type == 9)
                                F轮已上市
                            @elseif($type == 10)
                                其他
                            @endif
                        @endif
                    </button>
                    <button  type="button"  class="btn dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{route('project.index', ['type' =>1])}}">种子轮</a></li>
                        <li><a href="{{route('project.index', ['type' =>2])}}">天使轮</a></li>
                        <li><a href="{{route('project.index', ['type' =>3])}}">Pre-A轮</a></li>
                        <li><a href="{{route('project.index', ['type' =>4])}}">A轮</a></li>
                        <li><a href="{{route('project.index', ['type' =>5])}}">B轮</a></li>
                        <li><a href="{{route('project.index', ['type' =>6])}}">C轮</a></li>
                        <li><a href="{{route('project.index', ['type' =>7])}}">D轮</a></li>
                        <li><a href="{{route('project.index', ['type' =>8])}}">E轮</a></li>
                        <li><a href="{{route('project.index', ['type' =>9])}}">F轮已上市</a></li>
                        <li><a href="{{route('project.index', ['type' =>10])}}">其他</a></li>
                        <li><a href="{{route('project.index')}}">默认</a></li>
                    </ul>
                </div>
            </li>
            {{--<li class="col-lg-2 col-md-2 col-sm-2 col-xs-6"><input placeholder='结果中搜索项目名称' name="selects" type="text"></li>--}}
            {{--<li class="col-lg-1 col-md-1 col-sm-1 col-xs-3"><button type="button">搜索</button></li>--}}
        </ul>
    </form>
</section>
<!--搜索行结束-->

<!--主体内容行开始-->
<section class="hang container-fluid">
    <ul class="row content">
        @if(!empty($projects))
            {{-- */$i=0;/* --}}
            @foreach($projects as $project)
                {{-- */$i++;/* --}}
                <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6 animated @if($i<=4)fadeInLeft @else fadeInRight @endif ">
                    <div class="content-block">
                        <a href="{{ route('project.show', $project->guid) }}" title="{{$project->title}}">
                            <img src="{{ $project->banner_img }}" alt="">
                        </a>
                        <div>
                            <h3><a href="{{ route('project.show', $project->guid) }}" title="{{$project->title}}">
                                    @if(mb_strlen($project->title)>10)
                                        {{mb_substr($project->title,0,10).'...'}}
                                    @else
                                        {{$project->title}}
                                    @endif
                                </a>
                            </h3>
                            <p>{{ mb_substr($project->brief_content,0,20).'...' }}</p>
                            <!--p标签内容不可超过40个中文简体字-->
                            <div>
                                {{--<span>21</span>--}}
                                {{--<span>12723</span>--}}
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        @else
            <div style="color: #CCCCCC;">暂无数据呦，亲 O(∩_∩)O~</div>
        @endif
    </ul>
    @if(count($projects)>=8)
        <div class="loads"></div>
    @endif
</section>
<!--主体内容行结束-->
@endsection
@section('script')
    <script>
        var nowPage = 2;//当前页数
        $('.loads').click(function () {
            nowPage++;
            var typeId = $('#typeId').attr('data-id');
            $.ajax({
                url:'{{route('projectList')}}',
                type:'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    nowPage:nowPage,
                    typeId:typeId
                },
                success:function (data) {


                    if(data.StatusCode == "400" || data.ResultData.length<4) {
                        $('.loads').remove();
                    }
                    createDom(data.ResultData)
                }
            })
        })
        function createDom(data) {

            if(typeof data == "string") return;

            var html='';
            if(nowPage%2==0){
                var n = -1;
                var s = 3;
            }else {
                var n = 1;
                var s = 0;
            }
            for(var i=0;i<data.length;i++) {
                var  fanNum = s+n*i
                html += "<li class='col-lg-3 col-md-3 col-sm-6 col-xs-6 lis"+fanNum+" animated bounceInUp'>";
                html +=     "<div class='content-block'>";
                html +=         "<a href='/project/"+data[i].guid+"' title='"+data[i].title+"'>";
                html +=             "<img src='"+data[i].banner_img+"'>"
                html +=         "</a>"
                html +=         "<div>"
                html +=         "<h3><a href='/project/"+data[i].guid+"' title='"+data[i].title+"'>"
                html +=             data[i].title.substr(0,10);
                html +=         "</a></h3>"
                html +=         "<p>"+data[i].brief_content.substr(0,20)+"</p>";
                html +=         "<div></div></div></div></li>";
            }
            $('.content').append(html);
        }
    </script>
@endsection