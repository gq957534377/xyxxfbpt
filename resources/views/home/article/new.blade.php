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
            @if(is_string($data))
                <h2>{{$data}}</h2>
            @elseif(!$data)
                <h2>失败</h2>
            @else
                <h2>{{$data->title}}</h2>
                <p class="lead">{{$data->brief}}</p>
        </div>

        <div class="blog">
            <div class="row">
                <div class="col-md-8">
                    <div class="blog-item">
                        <img class="img-responsive img-blog" src="{{asset($data->banner)}}" width="100%" alt="" />
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 blog-content">
                                <h2>@if(isset($data->author)) {{$data->author}} @else Admin @endif</h2>
                                {!!$data->describe!!}
                            </div>
                        </div>
                    </div><!--/.blog-item-->
                    @endif

                        <button class="btn-danger" id="support">支持0</button>
                        <button class="btn-custom" id="no_support">不支持0</button>
                    <h1 id="comments_title">Comments</h1>
                    <div id = 'comment_list'>

                    </div>

                    <div id="contact-page clearfix">
                        <div class="status alert alert-success" style="display: none"></div>

                        <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>评论 *</label>
                                        <textarea name="message" id="message" required class="form-control" rows="8"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" id="comment" class="btn btn-primary btn-lg" required="required">Submit Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!--/#contact-page-->
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

        </div><!--/.blog-->

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
    <script>

    @include('home.user.ajax.ajaxRequire')
    @include('home.validator.UpdateValidator')
@endsection