@extends('home.layouts.index')
@section('style')
    <script type="text/javascript" src="{{url('/qiniu/js/jquery.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/uploadbox.css')}}">
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/plupload.full.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/qiniu.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui2.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main2.js')}}"></script>
@endsection
@section('content')
    <section id="blog" class="container">
        <div class="center">
            @if(is_string($msg)) <h2>{{$msg}}</h2>
        @else
            <h2>@if($msg[0]->type==1)路演@elseif($msg[0]->type==2)大赛@else学习@endif</h2>
        @endif
        </div>

        <div class="blog">
            <div class="row">
                 <div class="col-md-8">
                     @if(is_string($msg))
                         <h1>{{$msg}}</h1>
                     @else
                     @foreach($msg as $v)
                    <div class="blog-item">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2 text-center">
                                <div class="entry-meta">
                                    <span id="publish_date">{{$v->start_time}}</span>
                                    <span><i class="fa fa-user"></i> <a href="#">{{$v->author}}</a></span>
                                    <span><i class="fa fa-comment"></i> <a href="blog-item.html#comments">@if($v->group==1)英雄会@else 兄弟会@endif</a></span>
                                    <span><i class="fa fa-heart"></i><a href="#">{{$v->people}} Likes</a></span>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-10 blog-content">
                                <a href="#"><img class="img-responsive img-blog" src="{{asset($v->banner)}}" width="100%" alt="" /></a>
                                <h2><a href="/action/{{$v->guid}}">{{$v->title}}</a></h2>
                                <h3>{{$v->brief}}</h3>
                                <a class="btn btn-primary readmore" href="/action/{{$v->guid}}">Read More <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div><!--/.blog-item-->
                     @endforeach
                    @endif
                </div><!--/.col-md-8-->

                <aside class="col-md-4">
                    <div class="widget search">
                        <form role="form">
                                <input type="text" class="form-control search_box" autocomplete="off" placeholder="Search Here">
                        </form>
                    </div><!--/.search-->
    				

    				<div class="widget archieve">
                        <h3>Archieve</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="blog_archieve">
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> December 2013 <span class="pull-right">(97)</span></a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> November 2013 <span class="pull-right">(32)</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> October 2013 <span class="pull-right">(19)</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> September 2013 <span class="pull-right">(08)</a></li>
                                </ul>
                            </div>
                        </div>                     
                    </div><!--/.archieve-->
    			</aside>
            </div><!--/.row-->
        </div>
    </section><!--/#blog-->
    @include('home.validator.publishValidator')
@endsection

@section('script')
    @include('home.user.ajax.ajaxRequire')
    <script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script>
    @include('home.user.ajax.ajaxRequire')
    @include('home.validator.UpdateValidator')
@endsection

