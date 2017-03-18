/**
 * ajax成功执行函数
 * @author 郭庆
 */

function listHtml(data) {
    var html = '';
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th style="text-align:center;">通知类型</th><th style="text-align:center;">通知标题</th><th style="text-align:center;">发布人</th><th style="text-align:center;">发布时间</th><th style="text-align:center;">通知状态</th><th style="text-align:center;">通知来源</th><th style="text-align:center;">操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + type(e.type) + '</td>';
        html += '<td>' + e.title + '</td>';
        html += '<td>' + e.author + '</td>';
        html += '<td>' + getLocalTime(e.addtime) + '</td>';
        html += '<td>' + status(e.status) + '</td>';
        html += '<td>' + e.source + '</td>';
        html += '<td><a class="info btn btn-xs btn-warning tooltips" style="border-radius: 6px;" data-name="' + e.guid + '" href="javascript:;" data-toggle="modal" data-target="#full-width-modal">详情</a>&nbsp';
        if (e.status == 1) {
            html += '<a class="btn btn-xs btn-danger tooltips status" style="border-radius: 6px;" data-name="' + e.guid + '" data-status="' + 2 + '">删除</a>&nbsp';
        } else if (e.status == 2) {
            html += '<a class="btn btn-xs btn-info tooltips charge-road" style="border-radius: 6px;" data-name="' + e.guid + '" data-toggle="modal" data-target=".bs-example-modal-lg">修改</a>&nbsp';
            html += '<a class="btn btn-xs btn-danger tooltips status" style="border-radius: 6px;" data-name="' + e.guid + '" data-status="' + 1 + '">启用</a>&nbsp';
        }
        html += '</td>';
    });
    html += '</tbody></table></div><div class="row"><div class="col-xs-8"></div><div class="col-xs-4" id="page"></div></div>';
    return html;
}

//通知类型展示
function type(type) {
    var res;
    switch (type) {
        case 1:
            res = '两办通知';
            break;
        case 2:
            res = '其他通知';
            break;
        case 3:
            res = '本科教学';
            break;
        case 4:
            res = '研究生教学';
            break;
        case 5:
            res = '科技信息';
            break;
        case 6:
            res = '社科信息';
            break;
        default:
            res = '--';
            break;
    }
    return res;
}

//通知状态
function status(status) {
    var res;
    switch (status) {
        case 1:
            res = '已发布';
            break;
        case 2:
            res = '已删除';
            break;
        default:
            res = '--';
            break;
    }
    return res;
}

//展示旧数据
function date(data) {
    data = data.ResultData;
    $('#xg_type').val(data.type);
    $('#yz_xg').find('input[name=id]').val(data.guid);
    $('#yz_xg').find('input[name=title]').val(data.title);
    $('#yz_xg').find('input[name=source]').val(data.source);
    $('#yz_xg').find('input[name=author]').val(data.author);
    $('#yz_xg').find('input[name=banner]').val(data.banner);
    $('#charge_thumb_img').attr('src', data.banner);
    $('#yz_xg').find('textarea[name=brief]').val(data.brief);
    ue1.setContent(data.describe);
    $('.loading').hide();
}
// 显示通知信息详情
function showInfoList(data) {
    $('.loading').hide();
    if (data) {
        if (data.StatusCode == 200) {
            data = data.ResultData;
            $('#xq_title').html(data.title);
            $('#xq_time_author').html(getLocalTime(data.addtime) + '     发表人：' + data.author);
            $('#xq_banner').attr('src', data.banner);
            $('#xq_source').html('<h5>来源：' + data.source + '</h5>');
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

// 获取分页数据并加载显示在页面
function getInfoList(data) {
    $('.loading').hide();
    if (data) {
        if (data.StatusCode === '200') {
            $('#data').html(listHtml(data));
            $('#page').html(data.ResultData.pages);
            getPage();
            updates();
            initAlert();
            showInfo();
            checkAction();
        } else if (data.StatusCode === '204') {
            $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
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

// 分页li点击触发获取ajax事件获取分页
function getPage() {
    $('.pagination li').click(function () {
        var class_name = $(this).prop('class');
        if (class_name === 'disabled' || class_name === 'active') {
            return false;
        }

        var url = $(this).children().prop('href') + '&type=' + list_type + '&status=' + list_status;

        var ajax = new ajaxController();
        ajax.ajax({
            url: url,
            before: ajaxBeforeModel,
            success: getInfoList,
            error: ajaxErrorModel
        });
        return false;
    });
}

//时间转换
function getLocalTime(nS) {
    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
}
