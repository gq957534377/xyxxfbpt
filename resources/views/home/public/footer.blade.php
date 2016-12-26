<div class="zxz-footer">

    <div class="fixed-btn">
        <a class="go-top" href="javascript:void(0)" title="返回顶部"> <i class="fa fa-angle-up"></i></a>

        <a class="writer" href="javascript:void(0)" id="custom-service" data-toggle="modal" data-target="#custom-width-modal" title="联系客服"><i class="fa fa-envelope-o" style="font-size: 20px;"></i></a>

    </div>

    <footer class="container-fluid">
        <div  id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" style="display: none;">
            <div  class="modal-dialog modal-full">
                <div style="width: 700px;height: 470px;" class="modal-content">

                    <div  class="demo" id="openim" style="width: 700px;height: 470px;"></div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    <div class="container">
        <div class="row change-row-margin">
            <div class="footer-left col-xs-12 col-sm-4 col-md-4 col-lg-3">
                <p class="text-left">客服电话：{{ $tel }}<br>客服邮箱：{{ $email }}<br>工作时间：{{ $time }}</p>
            </div>
            <div class="footer-center col-xs-12  col-sm-4 col-md-4 col-lg-5">
                <a href="#">关于我们</a>
                <a href="#">新人课堂</a>
                <a href="#">常见问题</a>
            </div>
            <div class="footer-right col-xs-12  col-sm-4 col-md-4 col-lg-4">
                <span>关注奇立英雄会微信号</span>
                <p class="text-left">随时随地查看项目<br>进度及时推送</p>

                </div>

            </div>
        </div>
    </footer>

    <div class="container-fluid bottom">
        <p class="text-center">{{ $record }}</p>
    </div>

</div>