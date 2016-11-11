<script>
    $(function(){

        var login = $('#login');
        var register = $('#register');
        var guid = $('input[name="guid"]');
        var url = '/userinfo';
        $.ajax({
            type: "GET",
            url: url,
            success: function(msg){
                if(msg.StatusCode == 200){
                    guid.val(msg.ResultData.guid);
                    login.attr('href','/user').html(msg.ResultData.email);
                    register.attr('href','/logout').html('登出');
                }else{
                    guid.val('');
                    login.attr('href','/login').html('登录');
                    register.attr('href','/register').html('注册');
                }
            }
        });

    });
</script>