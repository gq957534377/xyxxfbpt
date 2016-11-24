@extends('home.layouts.index')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/uploadbox.css')}}">
    <script type="text/javascript" src="{{url('qiniu/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/plupload.full.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/qiniu.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/ui.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main2.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main3.js')}}"></script>
    <script type="text/javascript" src="{{url('/qiniu/js/main4.js')}}"></script>
@endsection
@section('content')
    <section id="contact-page">
        <div class="container main-container">

            <div class="users-show">
                <!--侧边菜单栏 Start-->
                 @include('home.user.side')
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <a id = 'publish_trigger' href="{{url('#')}}" class="list-group-item " data-toggle="modal">
                        <i class="text-md fa fa-bell" aria-hidden="true"></i>项目发布
                    </a>
                    <!--项目发布 end-->

                    <!--已发布项目管理 start-->
                    <a id='all_pro_list' href="#" class="list-group-item " data-toggle="modal">
                        <i class="text-md fa fa-picture-o" aria-hidden="true"></i>&nbsp;项目管理</a>
                    <!--已发布项目管理 end-->
                    <table id="all_pros" class="table table-striped table-hover" style="display: none">
                        <thead>
                            <tr>
                                <td>项目标题</td>
                                <td>项目状态</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <!--引入模态框模板-->
            @include('home.user.projectEdit')
            @include('home.user.projectPublish')

        </div>
    </section><!--/#contact-page-->
@endsection
@section('script')
    <script>
    </script>
    @include('home.validator.publishValidator')
    @include('home.project.all_pro_list')
@endsection