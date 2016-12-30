/**
 * ajax成功执行函数
 * @author 郭庆
 */

function listHtml(data){
    var html = '';
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th style="text-align:center;">文章类型</th><th style="text-align:center;">文章标题</th><th style="text-align:center;">发布人</th><th style="text-align:center;">发布时间</th><th style="text-align:center;">文章状态</th><th style="text-align:center;">文章来源</th><th style="text-align:center;">操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + type(e.type)+ '</td>';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.author + '</td>';
        html += '<td>' + getLocalTime(e.addtime)+'</td>';
        html += '<td>' + status(e.status)+'</td>';
        html += '<td>' + e.source+'</td>';
        html += '<td><a class="info btn btn-xs btn-warning tooltips" style="border-radius: 6px;" data-name="' + e.guid + '" href="javascript:;" data-toggle="modal" data-target="#full-width-modal">详情</a>&nbsp';
        if(e.user == 1){
            html += '<a class="btn btn-xs btn-info tooltips charge-road" style="border-radius: 6px;" data-name="' + e.guid + '" data-toggle="modal" data-target=".bs-example-modal-lg">修改</a>&nbsp';
        }
        if (e.status == 1 && e.status != 2) {
            html += '<a class="btn btn-xs btn-danger tooltips status" style="border-radius: 6px;" data-name="' + e.guid + '" data-status="' + 3 + '">删除</a>&nbsp';
        } else if (e.status == 3 && e.status != 2) {
            html += '<a class="btn btn-xs btn-danger tooltips status" style="border-radius: 6px;" data-name="' + e.guid + '" data-status="' + 1 + '">启用</a>&nbsp';
        }
        if (e.status == 2){
            html += '<a class="btn btn-xs btn-primary tooltips" style="border-radius: 6px;" href="javascript:;"><i data-name="' + e.guid + '" data-status="' + 1 + '" class="status" style="margin-bottom: 6px">通过</i></a>&nbsp';
            html += '<a class="btn btn-xs btn-danger tooltips" style="border-radius: 6px;" href="javascript:;"><i class="pass" data-name="' + e.guid + '" data-status="' + 3 + '" style="margin-bottom: 6px" data-toggle="modal" data-target="#panel-modal">否决</i></a>&nbsp';
        }
        html += '</td>';
    });
    html += '</tbody></table></div><div class="row"><div class="col-xs-8"></div><div class="col-xs-4" id="page"></div></div>';
    return html;
}

//文章类型展示
function type(type) {
    var res;
    switch (type){
        case 1:
            res = '市场';
            break;
        case 2:
            res = '政策';
            break;
        default:
            res = '未知';
            break;
    }
    return res;
}

//文章状态
function status(status) {
    var res;
    switch (status){
        case 1:
            res = '已发布';
            break;
        case 2:
            res = '待审核...';
            break;
        default:
            res = '已下架';
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
    $('#charge_thumb_img').attr('src',data.banner);
    $('#yz_xg').find('textarea[name=brief]').val(data.brief);
    ue1.setContent(data.describe);
    $('.loading').hide();
}
// 显示文章信息详情
function showInfoList(data){
    $('.loading').hide();
    if (data) {
        if (data.StatusCode == 200) {
            data = data.ResultData;
            $('#xq_title').html(data.title);
            $('#xq_time_author').html(getLocalTime(data.addtime)+'     发表人：'+ data.author);
            $('#xq_banner').attr('src',data.banner);
            $('#xq_source').html('<h5>来源：'+data.source+'</h5>');
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
