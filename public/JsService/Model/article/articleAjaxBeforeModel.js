/**
 * ajax发送之前的提示函数
 * @author 郭庆
 */
var width  = $(window).width() / 2;
var height = $(window).height() / 2 - 70;

function ajaxBeforeModel() {
    $('#data').html('');
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