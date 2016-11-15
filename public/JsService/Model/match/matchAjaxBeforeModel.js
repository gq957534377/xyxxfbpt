/**
 * ajax发送之前的提示函数
 * @author 郭鹏超
 */
var width  = $(window).width() / 2;
var height = $(window).height() / 2 - 70;

function ajaxBeforeModel() {
    // 清空
    $('#data').html('');
    // 菊花
    $('.loading').show().css({
        'left': width,
        'top': height
    });
}

function ajaxBeforeNoHiddenModel() {
    $('.loading').show().css({
        'left': width,
        'top': height
    });
}