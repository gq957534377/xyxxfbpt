<script>
 $(function(){
     // 用户信息获取
     var nickname = $("input[name='nickname']");
     var email = $("input[name='email']");
     var realname = $("input[name='realname']");
     var hometown = $("input[name='hometown']");
     var birthday = $("input[name='birthday']");
     var sex = $("input[name='sex']");
     var phone = $("input[name='phone']");
     var guid = $("#userinfo").val();
     var url = '/user';

     $.ajax({
         type: "get",
         url: url+'/'+guid,
         cache: false,
         success: function(msg){
             // 将传过json格式转换为json对象
            switch(msg.StatusCode){
                case 200:
                    nickname.empty().val(msg.ResultData.msg.nickname);
                    email.empty().val(msg.ResultData.msg.email);
                    realname.empty().val(msg.ResultData.msg.realname);
                    hometown.empty().val(msg.ResultData.msg.hometown);
                    birthday.empty().val(msg.ResultData.msg.birthday);
                    phone..empty().val(msg.ResultData.msg.tel);
                break;
                case 404:
                    alert(msg.ResultData);
//                    nickname.val('');
//                    email.val('');
//                    realname.val('');
//                    hometown.val('');
//                    birthday.val('');
//                    phone.val('');
                break;
                case 500:
                    alert(msg.ResultData);
//                    nickname.val('');
//                    email.val('');
//                    realname.val('');
//                    hometown.val('');
//                    birthday.val('');
//                    phone.val('');
                break;
            }


         }
     });

     // 个人中心修改
    $("#editSubmit").click(function(){
        $(this).html('234');

    });

 });
</script>