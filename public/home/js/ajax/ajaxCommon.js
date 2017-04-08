/**
 * ajax 上传类
 * @author 郭庆
 */

// 实例化函数时，初始值
function ajaxCommon()
{
    this.async = 'true';
    this.data = {};
}


// 对象添加属性和方法
ajaxCommon.prototype.ajaxHead = function () {

    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
};

ajaxCommon.prototype.ajax = function (param) {

    this.ajaxHead();

    $.ajax({
        url         : param.url,
        type        : param.type,
        data        : param.data || this.data,
        async       : param.async || this.async,
        beforeSend  : function () {
            param.beforeSend;
        },
        success     : function (msg) {
            param.success(msg);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            var number = XMLHttpRequest.status;
            var info = "错误: 错误号为" + number + ",数据异常!";
            ajaxAfterSend($('.loading'));
            swal('消息提示', info, "warning");
        }


    });
};


// ajax 请求前

function ajaxBeforeSend (obj)
{
    // var width = obj.width()/2 -40;
    // var height = obj.height()/2 -50;
    obj.show();
}

// ajax 请求后
function ajaxAfterSend (obj)
{
    obj.hide();
}





