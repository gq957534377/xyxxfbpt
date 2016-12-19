$(document).ready(function (){

    var guid = $('#topAvatar').attr('data-id');
    // 个人资料
    var user_avatar = $(".user_avatar");
    var user_name = $(".user_name");
    var user_nickname = $(".user_nickname");
    var user_sex = $(".user_sex");
    var user_birthday = $(".user_birthday");
    var user_webchat = $(".user_webchat");
    var user_info = $(".user_info");
    // 隐藏个人信息表单
    var hide_avatar = $('#head-pic');
    var hide_realname = $('input[name = "realname"]');
    var hide_nickname = $('input[name = "nickname"]');
    var hide_birthday = $('input[name = "birthday"]');

    // 异步获取用户数据
    $.ajax({
        type: "GET",
        url: '/user/'+guid,
        beforeSend:function(){
            $(".loading").show();
        },
        success: function(msg){
            // 将传过json格式转换为json对象
            switch(msg.StatusCode){
                case '200':
                    console.log(msg.ResultData);

                    user_avatar.attr('src',msg.ResultData.headpic);
                    user_nickname.html(msg.ResultData.nickname);
                    user_name.html(msg.ResultData.realname);

                    var sex ='';
                    if (msg.ResultData.sex == 1) {
                        sex = '男';
                    } else if(msg.ResultData.sex == 2) {
                        sex = '女';
                    } else{
                        sex = '保密';
                    }

                    user_sex.html(sex);
                    user_birthday.html(msg.ResultData.birthday);
                    // user_webchat.html('无');
                    user_info.html(msg.ResultData.introduction);

                    hide_avatar.attr('src',msg.ResultData.headpic);
                    hide_realname.empty().val(msg.ResultData.realname);
                    hide_nickname.empty().val(msg.ResultData.nickname);

                    if (msg.ResultData.sex == 1)
                    {
                       $('#male').attr('checked',true);
                    } else if(msg.ResultData.sex == 2)
                    {
                        $('#female').attr('checked',true);
                    } else {
                        $('#other-sex').attr('checked',true);
                    }

                    hide_birthday.empty().val(msg.ResultData.birthday);

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
            'nickname' : $('input[name="nickname"]').val(),
            'realname' : $('input[name="realname"]').val(),
            'birthday' : $('input[name="birthday"]').val(),
            'sex':  $('input:radio[name="sex"]:checked').val(),
            // 'wechat':  $('input[name="wechat"]').val(),
            'introduction':  $('textarea[name="introduction"]').val(),
        };
        ajaxRequire('user/'+guid, 'PUT', data, $("#editUserInfo"), 2);

        user_name.html($('input[name="realname"]').val());

        var sex ='';
        if ( $('input:radio[name="sex"]:checked').val() == 1) {
            sex = '男';
        } else if( $('input:radio[name="sex"]:checked').val() == 2) {
            sex = '女';
        } else{
            sex = '保密';
        }

        user_sex.html(sex);
        user_birthday.html($('input[name="birthday"]').val());
        // user_webchat.html('无');
        user_info.html($('textarea[name="introduction"]').val());

        $('#userinfo').show();
        $('#editUserInfo').hide();

    });

    $('#companyAddress').citys({
        required:false,
        nodata:'disabled',
        onChange:function(data){
            var text = data['direct']?'(直辖市)':'';
            $('#place').val(data['province']+text+' '+data['city']+' '+data['area']);
        }
    });

});

