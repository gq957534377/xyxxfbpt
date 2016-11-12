/**
 * ajax方法,用于接收参数,发送ajax请求
 * @author 郭鹏超
 */

// 执行ajax方法--构造方法
function AjaxController(data) {
    this.type = 'get';
    this.data = data;
}

AjaxController.prototype.ajaxHead = function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
};

AjaxController.prototype.ajax = function(param){
    this.ajaxHead();
    $.ajax({
        url: param.url,
        type: param.type || this.type,
        data: this.data,
        processData: false,
        contentType: false,
        beforeSend: function () {
            param.before();
        },
        success: function (data) {
            param.success(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            var number = XMLHttpRequest.status;
            var info = "系统错误：错误号为" + number + ",数据异常!";
            param.error(info);
        },
        async: true
    });
};