/**
 * Created by wangt on 2016/12/11.
 */

/**
 * 点赞的方法，
 * @author 王通
 * @modify 张洵之
 */
$('#like').on('click', function () {
    var me = $(this);
    var id = me.data('id');
    var temp = $(this).is('.taoxin')?-1:1;
    var num = parseInt($('#likeNum').html());
    $.ajax({
        type : 'get',
        url: "/action/"+id+"/edit",
        data: {
            'type': 1,
        },

        contentType: false, // 告诉jQuery不要去设置Content-Type请求头
        async: true,
        success: function(msg){

            switch (msg.StatusCode){
                case '400':
                    alert(msg.ResultData);
                    break;
                case "200":
                    $('#likeNum').html(num+temp);
                    me.toggleClass('taoxin');
                    break;
                default:
                    alert('请先登录');
                    location.href = "http://www.hero.app/login";
                    break;
            }
        },
        error: function(XMLHttpRequest){
            var number = XMLHttpRequest.status;
            var msg = "Error: "+number+",数据异常！";
            alert(msg);
        }

    });
});