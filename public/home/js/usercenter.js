/**
 * Created by Administrator on 2016/12/14.
 * author：张洵之
 */
//页面加载完毕回调函数
$(function () {
    var pathname = getPathname();
    var forNum = $('#js_zxz li').length
    for(var i = 0;i < forNum;i ++){
        changeLiStyle(i,pathname);
    }
})
//修改当前所在页面的li的样式
function changeLiStyle(liIndex,pathname) {
    var temp = $('#js_zxz li').eq(liIndex).children("a").attr("zxz-data");
    if(temp == pathname){
        $('#js_zxz li').eq(liIndex).children("a").addClass("active");
    }
}
//获得包含get传参的当前目录
function getPathname() {
    var urlArr = window.location.href.split("/");
    var pathname = urlArr[urlArr.length-1];
    var pathnames = pathname.split("?")[0];
    return pathnames;
}