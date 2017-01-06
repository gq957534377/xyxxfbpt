/**
 * Created by wang fei long on 2017/1/5.
 *
 * 进入用户中心时侧边导航栏的状态保持
 */

$(function(){
    //取得当前页面url
    var url_str = location.href;

    //取得侧边栏元素
    var set = $(".user-aside-nav > li");

    //初始化index
    var index = 0;

    //判断关键字是否在url中,并返回index
    function checkInUrl(url_str) {
        if (url_str.indexOf('user') > -1) {
            if (url_str.indexOf('edit') > -1) {
                return 6;
            }
            if (url_str.indexOf('myProject') > -1) {
                return 2;
            }
            if (url_str.indexOf('commentandlike') > -1) {
                return 5;
            }
        } else {
            if (url_str.indexOf('action_order') > -1) {
                return 3;
            }
            if (url_str.indexOf('send') > -1) {
                return 4;
            }
        }
        return 0;
    }

    index = checkInUrl(url_str);

    //解决进入新建项目页面时和顶部导航栏冲突
    if (url_str.indexOf('create') > -1 && url_str.indexOf('project') > -1) {
        index = 2;
    }

    //拼接类
    var active_class =  "sidebar-active sidebar-active-" + (index + 1);

    //添加类
    set.eq(index).children('a').addClass(active_class);
});
