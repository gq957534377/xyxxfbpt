<div class="zxz-footer">

    <div class="fixed-btn">
        <a class="go-top" href="javascript:void(0)" title="返回顶部"> <i class="fa fa-angle-up"></i></a>
        @if(!empty(session('user')))
        <a class="writer" href="javascript:void(0)" id="custom-service" data-toggle="modal" data-target="#custom-width-modal" title="联系客服"><i class="fa fa-envelope-o"></i></a>
        @endif
    </div>

    <footer class="container-fluid">
        <div  id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
            <div  class="modal-dialog modal-full">
                <div class="modal-content">

                    <div id="openim"></div>

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
                <a href="#">免责条款</a>
                <a href="#">版权声明</a>
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