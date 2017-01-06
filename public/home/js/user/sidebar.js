/**
 * Created by wang fei long on 2017/1/5.
 *
 * 进入用户中心时侧边导航栏的状态保持
 */

$(function(){
    var url_str = location.href.slice(20);
    console.log(url_str);
    var el = $("[href$='" + url_str + "']");
    console.log(el);
    var href = el.attr('href');
    console.log(el.attr('data-sidebar'));
});
