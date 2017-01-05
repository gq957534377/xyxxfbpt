/**
 * Created by wang fei long on 2017/1/5.
 *
 * 进入用户中心时侧边导航栏的状态保持
 */

//取得页面的url地址
var url_str = location.href;

//处理url地址
var a = url_str.split('/')[3];
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
        $("[data-status='project']").addClass('nav-content-active');
        break;
    case 'school':
        $("[data-status='school']").addClass('nav-content-active');
        break;
    case 'article':
        if (b == 1)
            $("[data-status='article1']").addClass('nav-content-active');
        if (b == 2)
            $("[data-status='article2']").addClass('nav-content-active');
        break;
    case 'action':
        $("[data-status='action']").addClass('nav-content-active');
        break;
}
