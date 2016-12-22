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
            $('#data').html(listHtml(data));
            $('#page').html(data.ResultData.pages);
            actionStatus();
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
