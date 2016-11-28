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
        html += '<td>' + author(e.author) + '</td>';
        html += '<td>' + e.time+'</td>';
        html += '<td>' + status(e.status)+'</td>';
        html += '<td>' + e.source+'</td>';
        html += '<td><a class="info" data-name="' + e.guid + '" href="javascript:;"><button class="btn-primary" data-toggle="modal" data-target="#full-width-modal" style="margin-bottom: 6px">详情</button></a>';
        if(!e.author){
            html += '<button data-name="' + e.guid + '" class="charge-road btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">修改文章</button>';
        }else{
        }
        if (e.status == 1) {
            html += '<a href="javascript:;" data-name="' + e.guid + '" data-status="3" class="status"><button class="btn-danger">禁用</button></a>';
        } else if (e.status == 3) {
            html += '<a href="javascript:;" data-name="' + e.guid + '" data-status="1" class="status"><button class="btn-primary">启用</button></a>';
        }
        if (e.status == 2){
            html += '<a href="javascript:;" data-name="' + e.guid + '" data-status="1" class="status"><button class="btn-success">通过</button></a>';
            html += '<button class="btn-danger" id="pass" data-name="' + e.guid + '" data-status="3" data-toggle="modal" data-target="#panel-modal">否决</button>';
        }
        html += '</td>';
    });
    html += '</tbody></table></div><div class="row"><div class="col-sm-8"></div><div class="col-sm-4" id="page"></div></div>';
    return html;
}

function author(author) {
    if(author) return author;
    return 'admin';
}
// 分页li点击触发获取ajax事件获取分页
function getPage() {
    $('.pagination li').click(function () {
        var class_name = $(this).prop('class');
        if(class_name == 'disabled' || class_name == 'active') {
            return false;
        }
        var url = $(this).children().prop('href')+'&type='+list_type+'&status='+list_status+'&user='+list_user;
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
    if (list_user==1){
        $('#xg_type').val(data.type);
    }else{
        $('#xg_type').val(3);
        $('#xg_type').attr('disable','true');
    }
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
            $('#xq_title').html(data.title);
            $('#xq_time_author').html(data.time+'     发表人：'+ data.author);
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
