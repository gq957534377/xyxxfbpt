/**
 * Created by wangt on 2016/12/11.
 */


$('#like').on('click', function () {
    var me = $(this);
    var id = me.data('id');
    $.ajax({
        type : 'get',
        url: '/article/' + id + '/edit',
        processData: false, // 告诉jQuery不要去处理发送的数据
        contentType: false, // 告诉jQuery不要去设置Content-Type请求头
        async: true,
        success: function(msg){

            switch (msg.StatusCode){
                case '400':
                    alert(msg.ResultData);
                    break;
                case "200":
                    me.html('点赞  ' + msg.ResultData[0]);
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