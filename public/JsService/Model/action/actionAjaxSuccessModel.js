/**
 * ajax成功执行函数
 * @author 郭庆
 */
function listHtml(data){
    var html = '';
    console.log(data);
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th style="text-align:center;">活动类型</th><th style="text-align:center;">活动主题</th><th style="text-align:center;">负责人</th><th style="text-align:center;">活动时间</th><th style="text-align:center;">截止报名</th><th style="text-align:center;">报名人数限定</th><th style="text-align:center;">报名人数</th><th style="text-align:center;">操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + type(e.type)+ '</td>';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.author + '</td>';
        html += '<td>' + getLocalTime(e.start_time) + '--'+getLocalTime(e.end_time)+'</td>';
        html += '<td>' + getLocalTime(e.deadline)+'</td>';
        html += '<td>' + e.limit+'</td>';
        html += '<td>' + e.people+'</td>';
        html += '<td><a class="info btn btn-xs btn-warning tooltips" data-toggle="modal" data-target="#tabs-modal" style="border-radius: 6px;" data-list="'+list_type+'" data-name="' + e.guid + '">详情</a>&nbsp';
        if (e.status === 1) {
            html += '<a class="btn btn-xs btn-info" href="action_change/'+e.guid+'/'+list_type+'" style="border-radius: 6px;">修改</a>&nbsp';
            html += '<a class="btn btn-xs btn-primary tooltips" style="border-radius: 6px;"><i data-name="' + e.guid + '" data-num="'+e.people+'" class="bm">报名详情</i></a>&nbsp';
            html += '<a class="btn btn-xs btn-danger tooltips status" data-name="' + e.guid + '" data-list="'+list_type+'" data-status="' + 4 + '" style="border-radius: 6px;">禁用</a>&nbsp';
        } else if (e.status === 4) {
            html += '<a class="btn btn-xs btn-info" href="action_change/'+e.guid+'/'+list_type+'" style="border-radius: 6px;">修改</a>&nbsp';
            html += '<a class="btn btn-xs btn-danger tooltips status" style="border-radius: 6px;" data-list="'+list_type+'" data-name="' + e.guid + '" data-status="' + 1 + '">启用</a>&nbsp';
        }else if (e.status === 2) {
            html += '<a class="btn btn-xs btn-danger tooltips status" data-list="'+list_type+'" data-name="' + e.guid + '" data-status="' + 4 + '" style="border-radius: 6px;">禁用</a>&nbsp';
        }else if (e.status === 3) {
            html += '<a class="btn btn-xs btn-danger tooltips status" data-list="'+list_type+'" data-name="' + e.guid + '" data-status="' + 4 + '" style="border-radius: 6px;">禁用</a>&nbsp';
        }else if (e.status === 5) {
            html += '<a class="btn btn-xs btn-info" href="action_change/'+e.guid+'/'+list_type+'" style="border-radius: 6px;">修改</a>&nbsp';
            html += '<a class="btn btn-xs btn-primary tooltips" style="border-radius: 6px;"><i data-name="' + e.guid + '" data-num="'+e.people+'" class="bm">报名详情</i></a>&nbsp';
            html += '<a class="btn btn-xs btn-danger tooltips status" data-list="'+list_type+'" data-name="' + e.guid + '" data-status="' + 4 + '" style="border-radius: 6px;">禁用</a>';
        }
        html += '</td>';
    });
    html += '</tbody></table></div><div class="row"><div class="col-xs-8"></div><div class="col-xs-4" id="page"></div></div>';
    return html;
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

// 显示活动信息详情
function showInfoList(data){
    $('.loading').hide();
    if (data) {
        if (data.StatusCode === '200') {
            data = data.ResultData;
            console.log(data);
            $('#xq_title').val(data.title);
            $('#xq_author').val(data.author);
            $('#xq_type').val(type(data.type));
            $('#xq_group').val(group(data.group));
            $('#xq_start_time').val(getLocalTime(data.start_time));
            $('#xq_end_time').val(getLocalTime(data.end_time));
            $('#xq_deadline').val(getLocalTime(data.deadline));
            $('#xq_time').val(data.addtime);
            $('#xq_banner').attr('src',data.banner);
            $('#xq_population').val(data.people);
            $('#xq_limit').val(data.limit);
            $('#xq_address').val(data.address);
            $('#xq_status').val(status(data.status));
            $('#xq_brief').html(data.brief);
            $('#xq_describe').html(data.describe);
        } else {
            $('#alert-form').hide();
            $('#alert-info').html('<p>' + data.ResultData + '  错误代码：'+data.StatusCode + '</p>');
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}



