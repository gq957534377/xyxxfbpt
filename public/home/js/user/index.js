$(document).ready(function (){

    var guid = $('#topAvatar').attr('data-id');
    // 个人资料
    var user_avatar = $(".user_avatar");
    var user_name = $(".user_name");
    var user_sex = $(".user_sex");
    var user_birthday = $(".user_birthday");
    var user_webchat = $(".user_webchat");
    var user_info = $(".user_info");
    // 隐藏个人信息表单
    var hide_avatar = $('#head-pic');
    var hide_realname = $('input[name = "realname"]');
    var hide_sex = $('input[name = "sex"]');
    var hide_birthday = $('input[name = "birthday"]');

    // 异步获取用户数据
    $.ajax({
        type: "GET",
        url: '/user/'+guid,
        beforeSend:function(){
            $(".loading").css({'width':'80px','height':'80px'}).show();
        },
        success: function(msg){
            // 将传过json格式转换为json对象
            switch(msg.StatusCode){
                case '200':
                    console.log(msg.ResultData);
                    user_avatar.attr('src',msg.ResultData.msg.headpic);
                    user_name.html(msg.ResultData.msg.realname);

                    if (msg.ResultData.msg.sex == 1) {
                        msg.ResultData.msg.sex = '男';
                    } else if(msg.ResultData.msg.sex == 2) {
                        msg.ResultData.msg.sex = '女';
                    } else{
                        msg.ResultData.msg.sex = '保密';
                    }

                    user_sex.html(msg.ResultData.msg.sex);
                    user_birthday.html(msg.ResultData.msg.birthday);
                    user_webchat.html('无');
                    user_info.html('无');

                    hide_avatar.attr('src',msg.ResultData.msg.headpic);
                    hide_realname.empty().val(msg.ResultData.msg.realname);
                    if (hide_sex.val() == msg.ResultData.msg.sex) {
                        this.attr('ckecked', true);
                    }
                    // hide_sex.empty().val(msg.ResultData.msg.sex);
                    hide_birthday.empty().val(msg.ResultData.msg.birthday);

                    $(".loading").hide();
                    break;
                case '400':
                    alert(msg.ResultData);
                    $(".loading").hide();
                    break;
                case '500':
                    alert(msg.ResultData);
                    $(".loading").hide();
                    break;
            }
        }
    });

    // 编辑页，点击编辑，将Dom元素替换
    $('#editBtn').click(function(){
        $('#userinfo').hide();
        $('#editUserInfo').show();

    });

    $('#editCompanyBtn').click(function(){
        $('#userinfo').hide();
        $('#editCompanyInfo').show();
    });

    // 编辑保存用户信息
    $("#editSubmit").click(function(){
        var data = {
            'realname' : $('input[name="realname"]').val(),
            'birthday' : $('input[name="birthday"]').val(),
            'sex':  $('input:radio[name="sex"]:checked').val()
        };
        ajaxRequire('user/'+guid,'PUT',data,$("#editUserInfo"),2);

        user_name.html($('input[name="realname"]').val());

        var sex ='';
        if ( $('input:radio[name="sex"]:checked').val() == 1) {
            sex = '男';
        } else if(msg.ResultData.msg.sex == 2) {
            sex = '女';
        } else{
            sex = '保密';
        }

        user_sex.html(sex);
        user_birthday.html($('input[name="birthday"]').val());
        user_webchat.html('无');
        user_info.html('无');

        $('#userinfo').show();
        $('#editUserInfo').hide();

    });

});

