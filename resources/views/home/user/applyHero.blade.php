@extends('home.layouts.userCenter')

@section('title', '琦力英雄会报名')

@section('style')
    <link href="{{ asset('home/css/join-hero.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!--琦立英雄会报名 开始-->
    <div id="applyHeroMemeberBox" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 pad-clr bgc-1 pos-1">

        <img src="{{asset('home/img/load.gif')}}" class="loading pull-right">

        <div class="center-block pad-5 text-center">
            <div class="banner-img text-center">
                banner 图片<br>
                加入英雄会我们共同成长
            </div>
            <p class="mar-1 text-left fs-15">
                在奇立英雄会，和谁在一起？<br><br>
                创业者，我们了解你在想什么。<br><br>
                你想要找到靠谱的投资人，想要知道他对所在领域真的感兴趣且活跃，希望能有机会跟投资人介绍你的项目，最好能约个时间地点当面聊聊。<br><br>
                针对这些需求，我们煞费苦心的思考融资流程中可以做减法的步骤，想要用高效的互联网产品打破时间地域限制，为更广面的创投进行更精准的匹配。希望不仅节省创业者触达目标投资人所耗费的时间和精力，更想让这种触达得到较为有效的反馈，从而建立起创投之间的联系。<br><br>
                基于这样的理念，极速融资在过去一年举办了 5 期，曝光率高达 280 万，10000+ 创业者向 116 位特邀投资人投递了 BP，并得到了有效的回复，约见率达 35%，最快的在约见当天就获得了 Term Sheet。
            </p>
            <a href="javascript:void(0)" id="toggle-popup" class="btn fs-15 btn-1 bgc-2 fs-c-1 zxz border-no" role="button">加入琦立英雄会</a>
        </div>
        <!-- 加入琦立英雄会 弹出层 开始 -->
        <div id="join-popup" class="join-popup join-popup-xs">
            后期需要添加图片
            <img src="#">
        </div>
        <!-- 加入琦立英雄会 弹出层 结束 -->
    </div>
    <!--琦立英雄会报名 结束-->
@endsection

@section('script')
    <script src="{{asset('home/js/ajaxRequire.js')}}"></script>

    <script>
        var guid = $('#topAvatar').data('id');
        // 异步先获取信息
        $.ajax({
            url     : '/identity/' + guid,
            type    : 'GET',
            data    : {
                role : 'memeber',
            },
            beforeSend: function(){
                $('.loading').show();
            },
            success : function(msg){
                console.log(msg);
                if (msg.StatusCode == '200') {
                    console.log(msg.ResultData);
                    switch (msg.ResultData.status) {
                        case 1:
                          $('#toggle-popup').html('待审核').attr('disabled', 'true').unbind('click');
                          break;
                        case 2:
                          $('#toggle-popup').html('英雄会会员').attr('disabled', 'true').unbind('click');
                          break;
                        case 3:
                            $('#toggle-popup').html('审核失败，请重新申请');
                          break;
                    }
                }
                $('.loading').hide();
            }
        });

        $('#toggle-popup').click(function(){
            var guid = $('#topAvatar').data('id');
            var data = {
                'guid' : guid,
                'role' : '4'
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url:'/identity',
                data:data,
                beforeSend : function(){
                    $(".loading").show();
                },
                success: function(msg){
                    switch (msg.StatusCode){
                        case '400':
                            $(".loading").hide();
                            swal('警告', msg.ResultData, "warning");
                            break;
                        case '200':
//                            $('#toggle-popup').html('待审核').attr('disabled', 'true').unbind('click');
                            $(".loading").hide();
                            swal({
                                    title: '提示', // 标题，自定
                                    text: '申请成功，3个工作日内，会有相关人员联系您，请保持电话畅通...',   // 内容，自定
                                    type: "success",    // 类型，分别为error、warning、success，以及info
                                    showCancelButton: false, // 展示取消按钮，点击后会取消接下来的进程（下面那个function）
                                    confirmButtonColor: '#ff9036',  // 确认用途的按钮颜色，自定
                                },
                                function (isConfirm) {
                                    swal('提示', msg.ResultData, "success");
                                });
                            break;
                    }
                },
                error: function(XMLHttpRequest){
                    var number = XMLHttpRequest.status;
                    var msg = "Error: "+number+",数据异常！";
                    $('.loading').hide();
                    aswal('警告', msg, "warning");
                }

            });
        });
    </script>
@endsection