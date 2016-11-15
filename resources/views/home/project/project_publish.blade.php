<!DOCTYPE html>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="{{url('/qiniu/bootstrap/css/bootstrap.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/highlight/highlight.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/uploadbox.css')}}">
<!-- <link href="//vjs.zencdn.net/5.0/video-js.min.css" rel="stylesheet"> -->
    <meta name="_token" content="{{csrf_token()}}">
    <style>
        .loading{z-index:999;position:absolute;left:50%;top:50%;display: none;}
    </style>
</head>
<body>

{{--引入loading图片--}}
<img src="{{asset('/admin/images/load.gif')}}" class="loading">

    <div class="container">
        {{--七牛token以domain--}}
        <div class="text-left col-md-12 ">
            <input type="hidden" id="domain" value="http://ogd29n56i.bkt.clouddn.com/">
            <input type="hidden" id="uptoken_url" value="{{url('getuptoken')}}">
        </div>

        <div class="body uploadbox col-md-8 col-md-offset-2">
            <div class = "row">
            <div class = "col-md-12 header">
                <h1>项目发布</h1>
            </div>
            </div>

            {{--后台验证验证不通过错误显示--}}
                <div class="alert alert-danger" style="display: none">
                    <ul>

                    </ul>
                </div>

            <form id = "projectForm">
                <input name='title' type="text" class="form-control _input" placeholder="请输入项目标题">
                <textarea name='content' class="form-control _input" rows="4" placeholder="请输入项目简介"></textarea>
                <input  type ='hidden' name = "image"/>
                <input  type ='hidden' name = "file"/>

                <div class="col-md-12 upload_btn_box">
                      <div id="container">
                          <button class="btn btn-primary btn-sm" type="button" id="pickfiles">选择图片</button>
                      </div>

                      {{--<div id="container2">--}}
                           {{--<button class="btn btn-primary btn-sm" type="button" id="pickfiles2">选择资料</button>--}}
                      {{--</div>--}}
                </div>
                {{--<button class="btn btn-primary " type="submit" id="submit">提交</button>--}}
            </form>

            <div class="col-md-12 table_box">
                <table class="table table-striped table-hover"   style="margin-top:40px;display:none">
                    <thead>
                      <tr>
                        <th class="col-md-4">文件名</th>
                        <th class="col-md-2">文件大小</th>
                        <th class="col-md-6">详情</th>
                      </tr>
                    </thead>
                    <tbody id="fsUploadProgress">
                    <tr class = "_imgtr"></tr>
                    <tr class = "_filetr"></tr>
                    </tbody>
                    <tbody id="fsUploadProgress2">
                    </tbody>
                </table>
            </div>
        </div>


</div>

@include('home.validator.publishValidator')


</body>
<script type="text/javascript" src="{{url('/qiniu/js/plupload/plupload.full.min.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/plupload/i18n/zh_CN.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/qiniu.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/ui.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/main.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/main2.js')}}"></script>

</html>