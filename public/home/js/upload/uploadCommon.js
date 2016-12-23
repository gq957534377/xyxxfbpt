
function uploadCommon()
{
    this.async = 'true';
    this.data = {};
}

uploadCommon.prototype.ajaxHead = function () {

    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
};

uploadCommon.prototype.upload = function (param) {

    this.ajaxHead();

    param.inputObj.trigger('click');

    inputObj.on('change', function(){
        var obj = this;
        var formData = new FormData();
        formData.append(param.inputObj.attr('name'), this.files[0]);

        $.ajax({
            url         : param.url,
            type        : param.type,
            data        : formData,
            async       : param.async || this.async,
            processData : false,
            contentType : false,
            beforeSend  : function(){
                param.beforeSend;
            },
            success     : function(msg){
                if (msg.StatusCode == '200') {
                    param.imgObj.attr('src', msg.ResultData);
                }else{
                    param.afterSend;
                    alert(msg.ResultData);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                var number = XMLHttpRequest.status;
                var info = "错误号:"+number+",文件上传失败!";
                // 将菊花图换成原图
                param.afterSend;

                alert(info);
            },
        });

        $(obj).off('change');
    });

};


// ajax 请求前

function ajaxBeforeSend (obj, loadingPic)
{
    obj.attr('src', loadingPic);
}

// ajax 请求后
function ajaxAfterSend (obj, originalPic)
{
    obj.attr('src', originalPic);
}