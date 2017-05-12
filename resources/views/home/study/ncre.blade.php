@extends('home.layouts.master')

@section('style')
    <style>
        .col-lg-3 {
            width: 73%;
        }

    </style>
@endsection
@section('title', 'ncre成绩查询')

@section('menu')
    @parent
@endsection

@section('content')

    <div class="content-wrap"><!--内容-->
        <div class="content">
            <center><h2>Ncre考试成绩查询</h2></center>
            <br><br>
            <form id="grade">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>身份证号：</label>
                    <input type="text" class="form-control" id="ZJH" name="ZJH" placeholder="请输入您的身份证号">
                </div>
                <div class="form-group">
                    <label>姓名：</label>
                    <input type="text" class="form-control" id="XM" name="XM" placeholder="请输入您的姓名">
                </div>
                <center>
                    <button type="submit" class="btn btn-success">查询</button>
                </center>
            </form>
            <br><br>
            <div class="table-responsive" id="table" style="display: none">
                <table class="table table-bordered table-striped">
                    <thread>
                        <tr>
                            <th style="text-align:center;">身份证号</th>
                            <th style="text-align:center;">成绩</th>
                        <tr>
                    </thread>
                    <tbody>
                    <tr style="text-align:center;" id="tr">

                    </tr>
                    </tbody>
                </table>
                <div id="R"></div>
            </div>

            <p>分享到:</p>
            <div class="bdsharebuttonbox col-lg-3 col-md-4 col-sm-4 col-xs-9 pad-clr pad-l30-md pad-l30-sm">
                <a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone"
                                                                    title="分享到QQ空间"></a><a href="#" class="bds_tsina"
                                                                                           data-cmd="tsina"
                                                                                           title="分享到新浪微博"></a><a
                        href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren"
                                                                                       data-cmd="renren"
                                                                                       title="分享到人人网"></a><a href="#"
                                                                                                             class="bds_weixin"
                                                                                                             data-cmd="weixin"
                                                                                                             title="分享到微信"></a>

            </div>
        </div>
    </div>
    <!--/内容-->
@endsection
@section('script')
    <script src="{{asset('home/js/jquery.validate.min.js')}}"></script>
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <script>
        //分享按钮
        window._bd_share_config = {
            "common": {
                "bdSnsKey": {},
                "bdText": "",
                "bdMini": "2",
                "bdMiniList": false,
                "bdPic": "",
                "bdStyle": "0",
                "bdSize": "24"
            }, "share": {}
        };
        with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];

        // 表单验证
        $("#grade").validate({
            rules: {
                ZJH: {
                    required: true,
                },
                XM: {
                    required: true,
                }
            },
            //错误信息提示
            messages: {
                ZJH: {
                    required: "请输入身份证号",
                },
                XM: {
                    required: "请输入您的姓名",
                }
            },
            //提交
            submitHandler: function (form) {
                var data = {"action": "getCJ"};
                var t = $('form').serializeArray();
                $.each(t, function (i, v) {
                    data[v.name] = v.value;
                });

                $.ajax({
                    url: "/ncre",
                    data: data,
                    type: 'post',
                    success: function (data) {
                        console.log(data);
                        if (data.StatusCode == "200") {
                            var data = data.ResultData;
                            $('#table').show();
                            $("#tr").html("<td>"
                                + data.zjh + "</td><td>" + status(data.dd) + "</td></tr>");
                            $("#R").html(span(data.dd));
                        } else {
                            alert(data.ResultData);
                        }
                    },
                    error: function (data) {
                        alert(data);
                    }
                });
            },
        });

        function status(dd) {
            switch (dd) {
                case -1:
                    return "缺考";
                case 0:
                    return "不合格";
                case 1:
                    return "及格";
                case 3:
                    return "优秀";
            }
        }

        function span(dd) {
            switch (dd) {
                case -1:
                    return "<span style='color:green;'>该考生未按时参加考试！</span>";
                case 0:
                    return "<span style='color:blue;'>考试未通过，请继续努力，请注意软件学院网站报名通知！</span>";
                case 1:
                    return "<span style='color:red;'>恭喜您已通过该考试，请注意软件学院网站合格证书领取通知！</span>";
                case 3:
                    return "<span style='color:red;'>恭喜您已通过该考试，并获得优秀的成绩，请注意软件学院网站合格证书领取通知！</span>";
            }
        }
    </script>
@endsection

