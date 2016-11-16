@extends('home.layouts.index')
@section('content')
    <section id="blog" class="container">
        <div class="blog">
            <div class="row">
                 <div class="col-md-8">
                    <div class="blog-item">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2 text-center">
                                <div class="entry-meta">
                                    <span id="publish_date">07  NOV</span>
                                    <span><i class="fa fa-user"></i> <a href="#">John Doe</a></span>
                                    <span><i class="fa fa-comment"></i> <a href="blog-item.html#comments">2 Comments</a></span>
                                    <span><i class="fa fa-heart"></i><a href="#">56 Likes</a></span>
                                </div>
                            </div>
                                
                            <div class="col-xs-12 col-sm-10 blog-content">
                                <a href="#"><img class="img-responsive img-blog" src="{{$data["pojectInfo"][0]->image}}" width="100%" alt="" /></a>
                                <h2>{{$data["pojectInfo"][0]->title}}</h2>
                                <h3>{{$data["pojectInfo"][0]->content}}</h3>
                                <a class="btn btn-primary readmore" href="blog-item.html">支持(￥)</a>
                            </div>
                            <div class="col-xs-12 col-sm-10" style="height: auto;float: right">

                            </div>
                        </div>

                    </div><!--/.blog-item-->
                </div><!--/.col-md-8-->
                <div class="col-md-4">
                    <!--右边栏-->
                </div>
            </div><!--/.row-->
        </div>
    </section><!--/#blog-->
@endsection