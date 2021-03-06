/**
 * Created by Administrator on 2017/1/10.
 * 评论分页方法
 */
$(function () {
    aOnClick();
});
function aOnClick() {
    $('.pagination li a').click(function () {
        var contentId = getId($(this).attr('href'));
        var nowpage = getNowPage($(this).attr('href'));
        ajaxForPage(nowpage, contentId);
        return false;
    })
}
function getId(str) {
    var arr = str.split('?');
    return arr[0];
}
function getNowPage(str) {
    var temp1 = str.split('?')[1];
    var temp2 = temp1.split('&')[1];
    var temp3 = temp2.split('=')[1];
    return temp3;
}
function ajaxForPage(nowpage, contentId) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/commentForPage',
        type: 'get',
        data: {nowPage: nowpage, contentId: contentId},
        success: function (data) {
            if (data.StatusCode == "200") {
                createDom(data.ResultData);
            }
        }
    })
}
function createDom(data) {
    createCommentDom(data.commentData);
    $('#js_pages').html(data.pageStyle);
    aOnClick();
}
function createCommentDom(data) {
    $('#js_comment').html('');
    for (var i in data) {
        var html = '';
        html += '<ul>';
        html += '<li><span class="face"><img src="' + data[i].userImg + '"></span>';
        html += '<span class="text"><strong>' + data[i].nikename + '</strong> (' + date(data[i].addtime) + ') 说：<br/>' + data[i].content + '</span></li></ul>';

        $('#js_comment').append(html);
    }
}
function date(time) {
    var now = new Date();
    now.setTime(parseInt(time) * 1000);
    var nowStr = now.format("yyyy-MM-dd hh:mm:ss");
    return nowStr;
}
Date.prototype.format = function (format) {
    var o = {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(), //day
        "h+": this.getHours(), //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3), //quarter
        "S": this.getMilliseconds() //millisecond
    }

    if (/(y+)/.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    }

    for (var k in o) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;
}