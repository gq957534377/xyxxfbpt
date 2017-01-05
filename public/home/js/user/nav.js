/**
 * Created by wang fei long on 2017/1/5.
 *
 *进入页面时相应导航栏状态保持
 */

//1.取得当以前页面的url
//2.取得url匹配的li
//3.判断此li是否有子菜单
//4.依照判断结果添加类

var url_str = location.href;
var a = url_str.split('/')[3];
var url_status = false;

//处理没有子菜单的导航
var set = $(".nav-status");
set.each(function () {
    var b = $(this).children('a').attr('href').split('/')[3];
    var status = a.indexOf(b) > -1 && $(this).attr('href') != '';
    if (status) {
        $(this).addClass('nav-content-active');
        url_status = true;
    }
});

//处理有子菜单的导航
var set_child = $(".nav-child-status");
set_child.each(function () {
    var b = $(this).children('a').attr('href').split('/')[3];
    var status = a.indexOf(b) > -1 && $(this).attr('href') != '';
    if (status) {
        $(this).addClass('nav-content-active-dropdown').parents('li').addClass('nav-content-active');
        url_status = true;
    }
});
if (!url_status) {
    set.eq(0).addClass('nav-content-active');
}
