/**
 * ajax成功执行函数
 * @author 郭庆
 */
//展示活动报名情况表
function actionOrder(data) {
    $('.loading').hide();
    if (data) {
        if (data.StatusCode === '200') {
            $('#data').html(htmlStr(data.ResultData.data));
            $('#page').html(data.ResultData.pages);
            userInfo();
            pageUrl();
        } else if (data.StatusCode === '204') {
            $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
        }else {
            $('#myModal').modal('show');
            $('#alert-info').html('<p>' + data.ResultData + '  错误代码：'+data.StatusCode + '</p>');
        }
    } else {
        $('#myModal').modal('show');
        $('#alert-info').html('<p>未知的错误</p>');
    }
}

/**
 *  HtmlStr() 用户列表标签拼装
 *
 * @param var data      json        ajax请求返回的json格式数组
 *
 * @return var str      string      返回拼装遍历好的html标签
 * */
function htmlStr( data) {
    //初始化变量
    var str = '';

    //公共表格头
    str +=  '<div class="panel-body">' +
        '<table class="table table-bordered table-striped">' +
        '<thead>' +
        '<tr>' +
        '<th class ="text-center">姓名</th>' +
        '<th class ="text-center">类型</th>' +
        '<th class ="text-center">手机</th>' +
        '<th class ="text-center">邮箱</th>' +
        '<th class ="text-center">操作</th>' +
        '</tr>' +
        '</thead>'+
        '<tbody>';

    //

    $.each(data, function (i, v) {
        v.realname = v.realname ? v.realname : '--';
        v.email    = v.email ? v.email : '--';
        v.headpic  = v.headpic ? v.headpic : '/home/img/user_center.jpg';
        v.introduction = v.introduction ? v.introduction : '--';
        v.addtime = v.addtime ? getLocalTime(v.addtime) : '--';

        str += '<tr class="gradeX">';
        str += '<td>' + v.realname + '</td>';
        str += '<td>';
        if(v.role == 1){
            str +=  '<span class="text-info text-xs">普通用户&nbsp;</span>';
        }
        if(v.role == 2){
            str +=  '<span class="text-warning text-xs">创业者&nbsp;</span>';
        }
        if(v.role == 3){
            str += '<span class="text-success text-xs">投资者&nbsp;</span>';
        }
        if(v.memeber == 2){
            str += '<span class="text-danger text-xs">校园信息发布平台员&nbsp;</span>';
        }
        str += '</td>';

        str +=  '<td>' + v.phone_number + '</td>';
        str +=  '<td>' + v.email + '</td>';
        str +=  '<td>';
        str +=  '<a href="javascript:;" data-nickname="' + v.username + '" data-realname="'+ v.realname +'" data-role ="'+v.role+
            '" data-tel ="'+v.phone_number+'" data-email="'+v.email+
            '" data-headpic="'+v.headpic+'" data-introduction="'+v.introduction+
            '" data-memeber="'+v.memeber+'" data-addtime="'+v.addtime+'" data-status="'+v.status+
            '" class="user_info"><button class="btn btn-warning btn-xs">详情</button></a>';

        str +=  '</td></tr>';
    });
    str += '</tbody>' +
        '</table>' +
        '</div>' +
        '<div class="row">' +
        '<div class="col-sm-8"></div>' +
        '<div class="col-sm-4" id="page"></div>' +
        '</div>';
    return str;
}

/**
 * 查看用户详情
 *
 *
 * */
function userInfo() {
    $('.user_info').click(function () {
        var data = $(this).data();

        $('#head').attr('src',data.headpic);
        $('#realname').text(data.realname);
        $('#nickname').text(data.nickname);


        $('#phone').text(data.tel);
        $('#email').text(data.email);
        $('#introduction').text(data.introduction);
        $('#addtime').text(data.addtime);
        //角色身份选择
        switch (data.role){
            case 1 :
                var str = '<strong>身份 ：</strong><span class="text-info text-xs">普通用户&nbsp;</span>';
                break;
            case 2 :
                var str = '<strong>身份 ：</strong><span class="text-warning text-xs">创业者&nbsp;</span>';
                break;
            case 3 :
                var str = '<strong>身份 ：</strong><span class="text-success text-xs">投资者&nbsp;</span>';
                break;
            default:
                var str = '<strong>身份 ：</strong><span class="text-success text-xs">未知&nbsp;</span>';
                break;
        }
        //会员身份选择
        switch(data.memeber){
            case 2:
                var member = '<span class="text-danger text-xs">校园信息发布平台员&nbsp;</span>';
                break;
            default:
                var member = '';
        }


        $('#role').html(str + member);

        //状态匹配
        switch (data.status){
            case 1:
                var status = '<strong>当前状态 ：</strong><span class="text-primary text-xs">正常使用中&nbsp;</span>';
                break;
            default:
                var status = '<strong>当前状态 ：</strong><span class="text-danger text-xs">禁用中&nbsp;</span>';
        }
        $('#status').html(status);
        $('#introduction').text(data.introduction);

        $('#user-info').modal('show');

    });
}
