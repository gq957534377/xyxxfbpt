/**
 * Created by wang fei long on 2017/1/5.
 *
 * 进入用户中心时侧边导航栏的状态保持
 */

$(function(){
    var url_str = location.href;
    var set = $("#js_zxz > li");
    var index = 0;
    set.each(function () {
        var b = $(this).children('a').attr('href');

        //只取得最后一个匹配的索引
        if (url_str.indexOf(b) > -1) {
            index = $(this).index();
        }
    });

    //拼接类
    var active_class =  "sidebar-active sidebar-active-" + (index + 1);

    //添加类
    set.eq(index).children('a').addClass(active_class);
});
