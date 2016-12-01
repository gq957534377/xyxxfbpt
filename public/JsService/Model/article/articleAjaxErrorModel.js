/**
 * ajax显示错误的方法
 * @param  info 错误信息
 * @author 郭庆
 */
function ajaxErrorModel(info){
    $('#con-close-modal').modal('show');
    $('.loading').hide();
    $('#alert-form').hide();
    $('#alert-info').html('<p>' + info + '</p>');
}
