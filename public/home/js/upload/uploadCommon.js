
function uploadCommon()
{
    this.async = 'true';
    this.data = {};
}

uploadCommon.prototype.upload = function (param) {

    param.inputObj.on('change', function(){
        var obj = this;
        var formData = new FormData();
        formData.append(param.inputObj.attr('name'), this.files[0]);

        $.ajaxSetup({
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            url         : param.url,
            type        : param.type,
            data        : formData,
            async       : param.async || this.async,
            processData : false,
            contentType : false,
            beforeSend  : function(){
                param.imgObj.css({ "width": "80px"});
                param.imgObj.attr('src', param.loadingPic);
            },
            success     : function(msg){
                if (msg.StatusCode == '200') {
                    param.imgObj.attr('src', msg.ResultData).css({ "width": "100%"});
                    param.hideinput.val(msg.ResultData);
                }else{
                    param.imgObj.attr('src', param.originalPic);
                    alert(msg.ResultData);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                var number = XMLHttpRequest.status;
                var info = "错误号:"+number+",文件上传失败!";
                // 将菊花图换成原图
                param.imgObj.attr('src', param.originalPic);

                alert(info);
            },
        });

        $(obj).off('change');
    });

};
