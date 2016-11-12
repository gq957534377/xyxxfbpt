<script>
    /**
     * 向指定url(url)发送GetAjax请求，并执行相应的回调方法（callFunction）
     * param string url ;function callFunction
     * author 张洵之
     */
    function ajaxRequestGet(url,callFunction) {
        $.ajax({
            url:url,
            type:"get",
            success:function (data) {
                if(data.StatusCode == "200"){
                    callFunction(data.ResultData)
                }else {
                    alert(data.ResultData)
                }
            },
            error:function () {
                alert("网络忙，请稍后再试！")
            }
        })
    }
    /**
     * 向指定url(url)发送PostAjax请求，并执行相应的回调方法（callFunction）
     * param string url ;json postData;function callFunction
     * author 张洵之
     */
    function ajaxRequestPost(url,postData,callFunction) {
        $.ajax({
            url:url,
            type:"post",
            data:postData,
            success:function (data) {
                if(data.StatusCode == "200"){
                    callFunction(data.ResultData)
                }else {
                    alert(data.ResultData)
                }
            },
            error:function () {
                alert("网络忙，请稍后再试！")
            }
        })
    }
</script>