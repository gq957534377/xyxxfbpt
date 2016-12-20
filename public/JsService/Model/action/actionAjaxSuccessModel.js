/**
 * ajax成功执行函数
 * @author 郭庆
 */
function listHtml(data){
    var html = '';
    console.log(data);
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th>活动类型</th><th>活动主题</th><th>负责人</th><th>活动时间</th><th>截止报名</th><th>报名人数限定</th><th>报名人数</th><th>操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + type(e.type)+ '</td>';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.author + '</td>';
        html += '<td>' + e.start_time + '--'+e.end_time+'</td>';
        html += '<td>' + e.deadline+'</td>';
        html += '<td>' + e.limit+'</td>';
        html += '<td>' + e.people+'</td>';
        html += '<td><a class="info btn btn-xs btn-warning tooltips" data-toggle="modal" data-target="#tabs-modal" style="border-radius: 6px;" data-name="' + e.guid + '">详情</a>&nbsp';
        if (e.status == 1) {
            html += '<a class="btn btn-xs btn-info tooltips charge-road" style="border-radius: 6px;" data-name="' + e.guid + '" data-toggle="modal" data-target=".bs-example-modal-lg">修改</a>&nbsp';
            html += '<a class="btn btn-xs btn-primary tooltips" style="border-radius: 6px;"><i data-name="' + e.guid + '" data-num="'+e.people+'" class="bm">报名详情</i></a>&nbsp';
            html += '<a class="btn btn-xs btn-danger tooltips status" data-name="' + e.guid + '" data-status="' + 4 + '" style="border-radius: 6px;">禁用</a>&nbsp';
        } else if (e.status == 4) {
            html += '<a class="btn btn-xs btn-info tooltips charge-road" style="border-radius: 6px;" data-name="' + e.guid + '" data-toggle="modal" data-target=".bs-example-modal-lg">修改</a>&nbsp';
            html += '<a class="btn btn-xs btn-danger tooltips status" style="border-radius: 6px;" data-name="' + e.guid + '" data-status="' + 1 + '">启用</a>&nbsp';
        }else if (e.status == 2) {
            html += '<a class="btn btn-xs btn-danger tooltips status" data-name="' + e.guid + '" data-status="' + 4 + '" style="border-radius: 6px;">禁用</a>&nbsp';
        }else if (e.status == 3) {
            html += '<a class="btn btn-xs btn-danger tooltips status" data-name="' + e.guid + '" data-status="' + 4 + '" style="border-radius: 6px;">禁用</a>&nbsp';
        }else if (e.status == 5) {
            html += '<a class="btn btn-xs btn-danger tooltips status" data-name="' + e.guid + '" data-status="' + 4 + '" style="border-radius: 6px;">禁用</a>&nbsp';
            html += '<a class="btn btn-xs btn-primary tooltips" style="border-radius: 6px;"><i data-name="' + e.guid + '" data-num="'+e.people+'" class="bm">报名详情</i></a>&nbsp';
            html += '<a class="btn btn-xs btn-info tooltips charge-road" style="border-radius: 6px;" data-name="' + e.guid + '" data-toggle="modal" data-target=".bs-example-modal-lg">修改</a>&nbsp';
        }
        html += '</td>';
    });
    html += '</tbody></table></div><div class="row"><div class="col-xs-8"></div><div class="col-xs-4" id="page"></div></div>';
    return html;
}

//活动类型展示
function type(type) {
    var res;
    switch (type){
        case 1:
            res = '路演活动';
            break;
        case 2:
            res = '大赛';
            break;
        default:
            res = '学习';
            break;
    }
    return res;
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
            res = '个人';
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
//展示旧数据
function date(data) {
    data = data.ResultData;
    $('#yz_xg').find('input[name=id]').val(data.guid);
    $('#yz_xg').find('input[name=title]').val(data.title);
    $('#yz_xg').find('input[name=end_time]').val(data.end_time);
    $('#yz_xg').find('input[name=deadline]').val(data.deadline);
    $('#yz_xg').find('input[name=address]').val(data.address);
    $('#yz_xg').find('input[name=limit]').val(data.limit);
    $('#yz_xg').find('input[name=author]').val(data.author);
    $('#yz_xg').find('input[name=banner]').val(data.banner);
    $('#charge_thumb_img').attr('src',data.banner);
    $('#yz_xg').find('select[name=group]').val(data.group);
    $('#yz_xg').find('input[name=start_time]').val(data.start_time);
    $('#yz_xg').find('textarea[name=brief]').val(data.brief);
    ue1.setContent(data.describe);
    $('.loading').hide();
}
// 显示活动信息详情
function showInfoList(data){
    $('.loading').hide();
    if (data) {
        if (data.StatusCode == 200) {
            data = data.ResultData;
            console.log(data);
            $('#xq_title').val(data.title);
            $('#xq_author').val(data.author);
            $('#xq_type').val(type(data.type));
            $('#xq_group').val(group(data.group));
            $('#xq_start_time').val(data.start_time);
            $('#xq_end_time').val(data.end_time);
            $('#xq_deadline').val(data.deadline);
            $('#xq_time').val(data.time);
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

//展示活动报名情况表
function actionOrder(data) {
    $('.loading').hide();
    if (data) {
        if (data.StatusCode == 200) {
            $('#list_baoming').html('');
            data = data.ResultData;
            data.map(function (item) {
                var html = '<tr><td>'+item.user_id+'</td><td>'+item.time+'</td><td>';
                if (item.status == 1) {
                    html += '<a href="javascript:;" data-name="' + item.id + '" data-status="3" class="action_status"><button class="btn-danger">禁用</button></a>';
                } else if (item.status == 3) {
                    html += '<a href="javascript:;" data-name="' + item.id + '" data-status="1" class="action_status"><button class="btn-primary">启用</button></a>';
                }
                html+= '</td></tr>';
                $('#list_baoming').append(html);
            });
            actionStatus();
        } else {
            $('#baoming').modal('hide');
            $('#myModal').modal('show');
            $('#alert-info').html('<p>' + data.ResultData + '  错误代码：'+data.StatusCode + '</p>');
        }
    } else {
        $('#myModal').modal('show');
        $('#alert-info').html('<p>未知的错误</p>');
    }
}
