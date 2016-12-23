$(document).ready(function () {

    var guid = $('#topAvatar').attr('data-id');
    // 个人资料
    var user_avatar = $(".user_avatar");
    var user_nickname = $(".user_nickname");
    var user_tel = $(".user_tel");
    var user_email = $(".user_email");
    // 隐藏个人信息表单
    var hide_avatar = $('#head-pic');
    var hide_nickname = $('input[name = "nickname"]');
    // 实例化ajaxCommon
    var ajax = new ajaxCommon();

    // 获取用户信息
    ajax.ajax({
        type: 'GET',
        url: 'user/' + guid,
        beforeSend: ajaxBeforeSend($('.loading')),
        success: userInfoReturn
    });

    function userInfoReturn(msg) {
        // 将传过json格式转换为json对象
        switch (msg.StatusCode) {
            case '200':
                console.log(msg.ResultData);

                user_avatar.attr('src', msg.ResultData.headpic);
                user_nickname.html(msg.ResultData.nickname);
                user_tel.html(msg.ResultData.tel);
                user_email.html(msg.ResultData.email);
                // 隐藏表单数据信息
                hide_avatar.attr('src', msg.ResultData.headpic);
                hide_nickname.empty().val(msg.ResultData.nickname);

                $(".loading").hide();
                break;
            case '400':
                alert(msg.ResultData);
                $(".loading").hide();
                break;
        }
    }

    //        测量 滚动条宽度的函数 开始
    function measure() { // thx walsh
        this.$body = $(document.body);
        var scrollDiv = document.createElement('div');
        scrollDiv.className = 'modal-scrollbar-measure';
        this.$body.append(scrollDiv);
        var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
        this.$body[0].removeChild(scrollDiv);
    }
        // 点击编辑，弹出修改昵称模态框
    $('#userInfoEdit').on('click', function () {
//            处理模态框显示时的问题 开始
        var body = $('body');
        body.scrollTop(5);//控制滚动条下移1px
        var b = body.scrollTop();//取得滚动条位置
        if (b > 0) {
            body.scrollTop(0);//滚动条返回顶部
            $('header').css('padding-right', width + 15 + 'px');
            $('#userInfoModal').modal('show').on('hidden.bs.modal', function () {
                $('header').css('padding-right', '15px');
                body.css('padding-right', 0);
            });
        } else {
            $('#userInfoModal').modal('show');
        }
//            处理模态框显示时的问题 结束
    });

    // 编辑保存用户信息
    $("#editSubmit").click(function () {
        var data = {
            'nickname': $('input[name="nickname"]').val(),
        };

        ajax.ajax({
            type: 'PUT',
            url: 'user/' + guid,
            data: data,
            beforeSend: ajaxBeforeSend($('.loading')),
            success: editReturnInfo
        });
        // 请求成功后，需要对返回信息处理
        function editReturnInfo(msg) {

            $("#userInfoError").addClass('hidden');
            $("#userInfoSuccess").addClass('hidden');

            switch (msg.StatusCode) {
                case '400':
                    $(".loading").hide();
                    $("#userInfoError").html(msg.ResultData).removeClass('hidden');
                    break;
                case '200':
                    $(".loading").hide();
                    user_nickname.html($('input[name="nickname"]').val());

                    $("#userInfoSuccess").html(msg.ResultData).removeClass('hidden');
                    break;
            }
        }
    });

    // 点击取消
    $(".userInfoReset").click(function(){
        $("#userInfoError").addClass('hidden');
        $("#userInfoSuccess").addClass('hidden');
    });

});
