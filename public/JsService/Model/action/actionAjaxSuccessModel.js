/**
 * ajax成功执行函数
 * @author 郭庆
 */

// 获取分页数据并加载显示在页面
function getInfoList(data){
    $('.loading').hide();
    if (data) {
        console.log(data);
        if (data.StatusCode == 200) {
            if(data.ResultData.data == '') {
                $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
            }else {
                $('#data').html(listHtml(data));
                $('#page').html(data.ResultData.pages);
                getPage();
                modifyStatus();
                showInfo();
                updateRoad();
                checkAction();

            }
        } else {
            $('#myModal').modal('show');
            $('#alert-form').hide();
            $('#alert-info').html('<p>' + data.ResultData + '</p>');
        }
    } else {
        $('#myModal').modal('show');
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}

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
        html += '<td><a class="info btn btn-success tooltips" data-name="' + e.guid + '" href="javascript:;"><i class="fa" data-toggle="modal" data-target="#tabs-modal" style="margin-bottom: 6px">详情</i></a>&nbsp';
        if (e.status == 1) {
            html += '<a class="btn btn-danger tooltips" href="javascript:;"><i data-name="' + e.guid + '" class="fa fa-pencil charge-road" data-toggle="modal" data-target=".bs-example-modal-lg" style="margin-bottom: 6px"></i></a>&nbsp';
            html += '<a class="btn btn-primary tooltips"><i data-name="' + e.guid + '" class="bm" data-toggle="modal" data-target="#baoming">报名详情</i></a>&nbsp';
            html += '<a class="btn btn-danger tooltips" href="javascript:;"><i data-name="' + e.guid + '" data-status="' + 4 + '" class="status fa fa-close" style="margin-bottom: 6px"></i></a>&nbsp';
        } else if (e.status == 4) {
            html += '<a class="btn btn-danger tooltips" href="javascript:;"><i data-name="' + e.guid + '" class="fa fa-pencil charge-road" data-toggle="modal" data-target=".bs-example-modal-lg" style="margin-bottom: 6px"></i></a>&nbsp';
            html += '<a class="btn btn-danger tooltips" href="javascript:;"><i data-name="' + e.guid + '" data-status="' + 1 + '" class="status ion ion-checkmark-round" style="margin-bottom: 6px"></i></a>&nbsp';
        }else if (e.status == 2) {
            html += '<a class="btn btn-danger tooltips" href="javascript:;"><i data-name="' + e.guid + '" data-status="' + 4 + '" class="status fa fa-close" style="margin-bottom: 6px"></i></a>&nbsp';
        }else if (e.status == 3) {
            html += '<a class="btn btn-danger tooltips" href="javascript:;"><i data-name="' + e.guid + '" data-status="' + 4 + '" class="status fa fa-close" style="margin-bottom: 6px"></i></a>&nbsp';
        }else if (e.status == 5) {
            html += '<a class="btn btn-danger tooltips" href="javascript:;"><i data-name="' + e.guid + '" data-status="' + 4 + '" class="status fa fa-close" style="margin-bottom: 6px"></i></a>&nbsp';
            html += '<a class="btn btn-primary tooltips"><i data-name="' + e.guid + '" class="bm" data-toggle="modal" data-target="#baoming">报名详情</i></a>&nbsp';
            html += '<a class="btn btn-danger tooltips" href="javascript:;"><i data-name="' + e.guid + '" class="fa fa-pencil charge-road" data-toggle="modal" data-target=".bs-example-modal-lg" style="margin-bottom: 6px"></i></a>&nbsp';
        }
        html += '</td>';
    });
    html += '</tbody></table></div><div class="row"><div class="col-sm-8"></div><div class="col-sm-4" id="page"></div></div>';
    return html;
}
// 分页li点击触发获取ajax事件获取分页
function getPage() {
    $('.pagination li').click(function () {
        var class_name = $(this).prop('class');
        if(class_name == 'disabled' || class_name == 'active') {
            return false;
        }
        var url = $(this).children().prop('href')+'&type='+list_type+'&status='+list_status;
        var ajax = new ajaxController();
        ajax.ajax({
            url : url,
            before : ajaxBeforeModel,
            success: getInfoList,
            error: ajaxErrorModel
        });
        return false;
    });
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
    console.log(data);
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
            $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}

//展示活动报名情况表
function actionOrder(data) {
    $('.loading').hide();
    console.log(data);
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
            $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
        }
    } else {
        $('#myModal').modal('show');
        $('#alert-info').html('<p>未知的错误</p>');
    }
}
