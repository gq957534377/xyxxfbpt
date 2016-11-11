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
     var guid = $("input[name='guid']").val();
     var url = '/user';

     $.ajax({
         type: "get",
         url: url+'/'+guid,
         cache: false,
         success: function(msg){
             // 将传过json格式转换为json对象
            switch(msg.StatusCode){
                case 200:
                    nickname.val(msg.ResultData.msg.nickname);
                    email.val(msg.ResultData.msg.email);
                    realname.val(msg.ResultData.msg.realname);
                    hometown.val(msg.ResultData.msg.hometown);
                    birthday.val(msg.ResultData.msg.birthday);
                    phone.val(msg.ResultData.msg.tel);
                break;
                case 404:
                    alert(msg.ResultData);
                    nickname.val('');
                    email.val('');
                    realname.val('');
                    hometown.val('');
                    birthday.val('');
                    phone.val('');
                break;
                case 500:
                    alert(msg.ResultData);
                    nickname.val('');
                    email.val('');
                    realname.val('');
                    hometown.val('');
                    birthday.val('');
                    phone.val('');
                break;
            }


         }
     });

     // 个人中心修改
    $("#editSubmit").click(function(){
        var data ={
            'nickname':nickname.val(),
            'email':email.val(),
            'realname':realname.val(),
            'hometown':hometown.val(),
            'birthday':birthday.val(),
            'sex':sex.val(),
            'phone':phone.val()
        };

        $.ajax({
            type:'POST',
            url:url+'/'+guid,
            dataType: 'json',
            cache: false,
            data:data,
            success:function(msg){
                cosole.log(msg);
            }
        });
    });

 });
</script>