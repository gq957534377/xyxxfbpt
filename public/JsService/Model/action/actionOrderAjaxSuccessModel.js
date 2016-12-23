/**
 * ajax成功执行函数
 * @author 郭庆
 */
function listHtml(data){
    var html = '';
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th style="text-align:center;">活动id</th><th style="text-align:center;">活动主题</th><th style="text-align:center;">用户id</th><th style="text-align:center;">报名时间</th><th style="text-align:center;">操作</th>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + e.action_id+ '</td>';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.user_id + '</td>';
        html += '<td>' + getLocalTime(e.addtime) +'</td>';
        if (e.status == 1) {
            html += '<td><a class="btn btn-danger btn-xs" style="border-radius: 6px;" data-name="' + e.id + '" data-status="3" class="action_status"><button class="btn-danger">禁用</button></a>';
        } else if (e.status == 3) {
            html += '<td><a class="btn btn-success btn-xs" style="border-radius: 6px;" data-name="' + e.id + '" data-status="1" class="action_status"><button class="btn-primary">启用</button></a>';
        }
        html += '</td>';
    });
    html += '</tbody></table></div><div class="row"><div class="col-xs-8"></div><div class="col-xs-4" id="page"></div></div>';
    return html;
}

//所属机构展示
function group(type) {
    var res;
    switch (type){
        case '1':
            res = '英雄会';
            break;
        case '2':
            res = '兄弟会';
            break;
        default:
            break;
    }
    return res;
}
//活动状态
function status(status) {
    var res;
    switch (status){
        case 1:
            res = '报名中';
            break;
        case 2:
            res = '活动进行时';
            break;
        case 3:
            res = '活动已结束';
            break;
        case 4:
            res = '已禁用';
            break;
        case 5:
            res = '报名截止，等待开始';
            break;
        default:
            break;
    }
    return res;
}

//展示活动报名情况表
function actionOrder(data) {
    $('.loading').hide();
    if (data) {
        if (data.StatusCode == 200) {
            $('#data').html(htmlStr(data.ResultData.data));
            $('#page').html(data.ResultData.pages);
            actionStatus();
            pageUrl();
        } else if (data.StatusCode == 204) {
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
        '<th class ="text-center">性别</th>' +
        '<th class ="text-center">生日</th>' +
        '<th class ="text-center">手机</th>' +
        '<th class ="text-center">邮箱</th>' +
        '<th class ="text-center">操作</th>' +
        '</tr>' +
        '</thead>'+
        '<tbody>';

    //

    $.each(data, function (i, v) {

        str += '<tr class="gradeX">';
        str +=  '<td>' + v.realname + '</td>';
        str +=  '<td>';
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
            str += '<span class="text-danger text-xs">英雄会员&nbsp;</span>';
        }
        str += '</td>';
        if(v.sex == 1){
            str += '<td>男</td>';
        }else{
            str +=  '<td>女</td>';
        }

        str += '<td>' + v.birthday + '</td>';
        str +=  '<td>' + v.tel + '</td>';
        str +=  '<td>' + v.email + '</td>';

        str +=  '<td>';
        str +=  '<a href="javascript:;" data-nickname="' + v.nickname + '" data-realname="'+ v.realname +'" data-role ="'+v.role+'" data-brithday="'+v.brithday+'" data-sex ="'+v.sex+'" data-company_position="'+v.company_position+'" data-company_address="'+v.company_address+'" data-tel ="'+v.tel+'" data-email="'+v.email+'" data-headpic="'+v.headpic+'" data-chat="'+v.wechat+'" data-intoduction="'+v.introduction+'" data-memeber="'+v.memeber+'" data-addtime="'+v.addtime+'" data-status="'+v.status+'" class="user_info"><button class="btn btn-warning btn-xs">用户详情</button></a>';
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
