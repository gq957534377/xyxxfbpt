<!DOCTYPE html>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="{{url('/qiniu/bootstrap/css/bootstrap.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/highlight/highlight.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('/qiniu/js/uploadbox.css')}}">
<!-- <link href="//vjs.zencdn.net/5.0/video-js.min.css" rel="stylesheet"> -->

</head>
<body>
    <div class="container">
        <div class="text-left col-md-12 ">
            <input type="hidden" id="domain" value="http://ogd29n56i.bkt.clouddn.com/">
            <input type="hidden" id="hlsurl" value="null">
            <input type="hidden" id="_token" value="{{csrf_token()}}">
            <input type="hidden" id="uptoken_url" value="{{url('getuptoken')}}">
        </div>
        <div class="body uploadbox col-md-8 col-md-offset-2">
            {{--上传完成显示块--}}
            <div class = "row">
            <div class = "col-md-12 header">
                <h1>项目发布</h1>
            </div>
            </div>
            {{--<div style="display:none" id="success" class="col-md-8 col-md-offset-2">--}}
                {{--<div class="alert-success">--}}
                    {{--上传完成--}}
                {{--</div>--}}
            {{--</div>--}}
    <input name = "title"/>
    <input name = "content"/>
    <input type = "hidden" name = "image"/>
    <input type = "hidden" name = "file"/>
            <div class="col-md-12 upload_btn_box">
                <div id="container">
                    <button class="btn btn-primary " type="button" id="pickfiles">选择文件</button>
                </div>
            </div>

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
                    </tbody>
                </table>
            </div>
            <a href = "javascript:;" id = "submit">提交</a>

    </div>


</div>


</body>
<script type="text/javascript" src="{{url('/qiniu/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/plupload/plupload.full.min.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/plupload/i18n/zh_CN.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/qiniu.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/ui.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/main.js')}}"></script>
<script type="text/javascript" src="{{url('/qiniu/js/project.js')}}"></script>

</html>