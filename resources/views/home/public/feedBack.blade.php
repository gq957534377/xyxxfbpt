<!-- 反馈对话框开始 -->

<div id="htmlfeedback-container" class="unselectable" style="display: none;">
    <div id="htmlfeedback-more" style="background-color: rgb(150, 185, 125);">
        <div id="htmlfeedback-info" style="display: inline-block;"><i class="fa fa-comments-o" aria-hidden="true"></i> 我的建议</div>

        <div id="htmlfeedback-close" style="display: block;">X</div>
    </div>

    <div id="htmlfeedback-container-more" class="expanded" style="display: block;">
        <h3>反馈内容<span style="color:red;display:inline-block;">（*必填）</span></h3>

        <p>
            <textarea id="htmlfeedback-input-description" name="description" placeholder="欢迎提出您在使用过程中遇到的问题或宝贵建议（400字以内），感谢您对菜鸟教程的支持。"></textarea>

        </p>
        <form id="htmlfeedback-form">


            <h3>
                联系方式(邮箱)
            </h3>
            <input name="fb_email" type="text" class="fb-email" maxlength="100" placeholder="请留下您的联系方式，以便我们及时回复您。" id="feedback_email">
            <p>
                <input type="submit" id="htmlfeedback-submit" value="提交反馈">

            </p>
            <br>
            <hr>
            {{--<p style="margin: 5px;">--}}
                {{--<strong>联系邮箱：<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&amp;email=ssbDyoOAgfLU3crf09venNHd3w" target="_balnk">{{ $email }}</a></strong>--}}

            {{--</p>--}}

        </form>
    </div>
</div>
<!-- 反馈对话框结束 -->
