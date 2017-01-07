/**
 * Created by wang fei long on 2017/1/5.
 *
 *进入页面时相应导航栏状态保持
 */

//取得页面的url地址
var url_str = location.href;

//处理url地址
var a = url_str.split('/')[3];
var b = 1;
if (a.indexOf('?') > -1) {
    b = a.split('?')[1].split('=')[1];
    a = a.split('?')[0];
}
//依情况添加类
switch (a) {
    case '':
        $("[data-status='index']").addClass('nav-content-active');
        break;
    case 'project':
        //解决进入新建项目页面时和顶部导航栏冲突
        if (url_str.indexOf('create') > -1) {
            break;
        }

        $("[data-status='project']").addClass('nav-content-active');
        break;
    case 'school':
        $("[data-status='school']").addClass('nav-content-active');
        break;
    case 'article':
        //辨识详情页属于 市场资讯 还是 创业政策
        var c = $('#article-type').html();
        if (c) {
            b = c;
        }

        if (b == 1)
            $("[data-status='article1']").addClass('nav-content-active');
        if (b == 2)
            $("[data-status='article2']").addClass('nav-content-active');
        break;
    case 'action':
        $("[data-status='action']").addClass('nav-content-active');
        break;
}
