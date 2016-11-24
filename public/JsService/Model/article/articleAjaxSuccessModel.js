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
                updateArticle();
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
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th>文章类型</th><th>文章标题</th><th>发布人</th><th>发布时间</th><th>文章状态</th><th>文章来源</th><th>操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + type(e.type)+ '</td>';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.author + '</td>';
        html += '<td>' + e.time+'</td>';
        html += '<td>' + status(e.status)+'</td>';
        html += '<td>' + e.source+'</td>';
        html += '<td><a class="info" data-name="' + e.guid + '" href="javascript:;"><button class="btn-primary" data-toggle="modal" data-target="#tabs-modal" style="margin-bottom: 6px">详情</button></a>';
        html += '<button data-name="' + e.guid + '" class="charge-road btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">修改文章</button>';
        if (e.status == 1) {
            html += '<a href="javascript:;" data-name="' + e.guid + '" data-status="' + e.status + '" class="status"><button class="btn-danger">禁用</button></a>';
        } else if (e.status == 3) {
            html += '<a href="javascript:;" data-name="' + e.guid + '" data-status="' + e.status + '" class="status"><button class="btn-primary">启用</button></a>';
        }
        if (e.type == 3 && e.status == 2)
            html += '<a href="javascript:;" data-name="' + e.guid + '" data-status="' + e.status + '" class="status"><button class="btn-primary">通过</button></a>';
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
            res = '用户来稿';
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
    console.log(data);
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
            console.log(data);
            $('#xq_title').val(data.title);
            $('#xq_author').val(data.author);
            $('#xq_type').val(type(data.type));
            $('#xq_time').val(data.time);
            $('#xq_banner').attr('src',data.banner);
            $('#xq_source').val(data.source);
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
