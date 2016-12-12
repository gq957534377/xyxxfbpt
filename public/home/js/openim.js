/**
 * Created by wangt on 2016/12/9.
 */
$(function () {
    $('#custom-service').on('click',function () {

        getIMInfo();


    });

    function OpenIM(obj) {
        console.log('__________________________');
        console.log(obj);
        WKIT.init({
            container: document.getElementById('J_demo'),
            uid: obj.uid,
            appkey: obj.appkey,
            credential: obj.pwd,
            touid: obj.touid,
            sendMsgToCustomService: true,
            theme: 'red',
//            title: '我是客服哟',
            logo: 'http://interface.im.taobao.com/mobileimweb/fileupload/downloadPriFile.do?type=1&fileId=876114ca44f4362f629f7d592014e057.jpg&suffix=jpg&width=1920&height=1200&wangxintype=1&client=ww',
            autoMsgType: 1,
            pluginUrl: 'http://www.taobao.com/market/seller/openim/plugindemo.php'
        });
    }
    
    function getIMInfo () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type : 'get',
            url: '/openim',
            processData: false, // 告诉jQuery不要去处理发送的数据
            contentType: false, // 告诉jQuery不要去设置Content-Type请求头
            async: true,
            success: function(msg){

                switch (msg.StatusCode){
                    case '400':
                        alert(msg.ResultData);
                        break;
                    case '200':
                        OpenIM(msg.ResultData);
                        break;
                }
            },
            error: function(XMLHttpRequest){
                var number = XMLHttpRequest.status;
                var msg = "Error: "+number+",数据异常！";
                alert(msg);
            }

        });
    }
})
