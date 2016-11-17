<script>
    /**
     * 前台Ajax异步请求
     * @author 刘峻廷
     */
    function beforeSend(obj)
    {
        var width = obj.width()/2 -40;
        var height = obj.height()/2 -50;
        $(".loading").css({'width':'80px','height':'80px','left':width,'top':height}).show();
    }
    // 初始化数据
    function ajaxRequire(url,type,data,obj,model)
    {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        switch(model){
            case 1:
                $.ajax({
                    type:type,
                    url:url,
                    data:data,
                    processData: false, // 告诉jQuery不要去处理发送的数据
                    contentType: false, // 告诉jQuery不要去设置Content-Type请求头
                    async: true,
                    beforeSend : beforeSend(obj),
                    success: function(msg){
                        switch (msg.StatusCode){
                            case '404':
                                $(".loading").hide();
                                promptBoxHandle('警告',msg.ResultData);

                                break;
                            case '400':
                                $(".loading").hide();
                                promptBoxHandle('警告',msg.ResultData);
                                $('#myModal_1').modal('hide');

                                break;
                            case '200':
                                $(".loading").hide();
                                promptBoxHandle('提示',msg.ResultData);
                                $('#myModal_1').modal('hide');

                                break;
                        }
                    },
                    error: function(XMLHttpRequest){
                        var number = XMLHttpRequest.status;
                        var msg = "Error: "+number+",数据异常！";
                        promptBoxHandle('警告',msg);
                    }

                });
                break;
            case 2:
                $.ajax({
                    type:type,
                    url:url,
                    data:data,
                    async: true,
                    beforeSend : beforeSend(obj),
                    success: function(msg){
                        switch (msg.StatusCode){
                            case '404':
                                $(".loading").hide();
                                promptBoxHandle('警告',msg.ResultData);
                                break;
                            case '400':
                                $(".loading").hide();
                                promptBoxHandle('警告',msg.ResultData);
                                break;
                            case '200':
                                $(".loading").hide();
                                promptBoxHandle('提示',msg.ResultData);
                                break;
                        }
                    },
                    error: function(XMLHttpRequest){
                        var number = XMLHttpRequest.status;
                        var msg = "Error: "+number+",数据异常！";
                        promptBoxHandle('警告',msg);
                    }

                });
                break;
        }

    }
</script>