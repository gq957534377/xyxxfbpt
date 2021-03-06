@extends('home.layouts.master')

@section('style')
    <style>
        .col-lg-3 {
            width: 73%;
        }

    </style>
@endsection
@section('title', '计算机等级考试查询')

@section('menu')
    @parent
@endsection

@section('content')

    <div class="content-wrap"><!--内容-->
        <div class="content">
            <center><h2>全国计算机等级考试成绩查询--考点“山西大学”</h2></center>
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
                            <th style="text-align:center;">姓名</th>
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
                    url: "/jisuanji",
                    data: data,
                    type: 'post',
                    success: function (data) {
                        if (data.StatusCode == "200") {
                            if (data.ResultData.Result == '1') {
                                var data = data.ResultData;
                                $('#table').show();
                                $("#tr").html("<td>"
                                    + data.ZJH + "</td><td>" + data.XM + "</td><td>" + data.DD + "</td></tr>");
                                if (data.DD == "优秀" || data.DD == "合格") {
                                    $("#R").html("<span style='color:red;'>恭喜您已通过该考试，请注意软件学院网站合格证书领取通知！</span>");
                                } else if (data.DD == "不合格") {
                                    $("#R").html("<span style='color:blue;'>考试未通过，请继续努力，请注意软件学院网站报名通知！</span>");
                                }
                            } else if (data.ResultData.Result == '0'){
                                alert("不存在该考试记录！");
                            }
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
    </script>
@endsection

