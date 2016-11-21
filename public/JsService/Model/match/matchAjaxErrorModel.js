/**
 * ajax显示错误的方法
 * @param  info 错误信息
 * @author 郭鹏超
 */
function ajaxErrorModel(info){
    $("#hint").click();
    $("#hint_form h4").html("未知错误");
    $("#hint_form p").html("抱歉出现位置错，请刷新页面再次进行添加");
}
