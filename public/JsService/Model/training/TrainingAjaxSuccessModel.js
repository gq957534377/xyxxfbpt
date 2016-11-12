/**
 * ajax成功执行函数
 * @author 郭鹏超
 */

// 获取分页数据并加载显示在页面
function getInfoList(data){
    $('.loading').hide();
    if (data) {
        if (data.ServerNo == 200) {
            if(data.ResultData.data == '') {
                $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
            }else {
                $('#data').html(listHtml(data));
                $('#page').html(data.ResultData.pages);
                getPage();
                modifyStatus();
                showInfo();
                //showCard();
            }
        } else {
            $('#con-close-modal').modal('show');
            $('#alert-form').hide();
            $('#alert-info').html('<p>' + data.ResultData + '</p>');
        }
    } else {
        $('#con-close-modal').modal('show');
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}

//组装培训信息列表
function listHtml(data){
    var html = '';
    console.log(data);
    html += '<div class="row"><div class="col-sm-12"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">创业项目培训列表</h3></div><table class="table table-bordered table-striped" id="datatable-editable"><thead><tr><th>创业项目培训主题</th><th>组织</th><th>培训开始时间</th><th>培训结束时间</th><th>报名截止时间</th><th>参与人数</th><th>状态</th><th>操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeU">';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.group + '</td>';
        html += '<td>' + e.start_time + '</td>';
        html += '<td>' + e.stop_time + '</td>';
        html += '<td>' + e.deadline + '</td>';
        html += '<td>' + e.population + '</td>';
        html += '<td>' + e.status + '</td>';


        html += '<td class="actions"><a href="javascipt:;" data-name="' + e.guid + '"  class="on-default edit-row"><i class="fa fa-pencil"></i>编辑</a>';
        html += '<a href="javascipt:;" data-name="' + e.guid + '"  class="on-default edit-row"><i class="fa fa-pencil"></i>编辑</a></td></tr>>';
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
        var url = $(this).children().prop('href');
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

// 组装HTML元素
function infoHtml(data){
    var html = '';
    //创业技术培训名称
    html += '<div class="row"><div class="col-md-6"><div class="form-group"><label for="field-1" class="control-label">创业技术培训名称：</label>';
    html += '<input type="text" class="form-control" value="' + (data.roadShow_title || '') + '" id="title" name="title" placeholder="请填写创业技术培训名称"></div></div>';
    //组织机构名称
    html += '<div class="row"><div class="col-md-6"><div class="form-group"><label for="field-2" class="control-label">组织机构名称：</label>';
    html += '<input type="text" class="form-control" value="' + (data.roadShow_title || '') + '" id="groupname" name="groupname" placeholder="组织机构名称"></div></div></div>';
    //培训开始时间
    html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="field-4" class="control-label">培训开始时间：</label>';
    html += '<input type="datetime-local" value="' + (data.roadShow_title || '') + '" class="form-control"name="start_time" id="start_time"></div></div>';
    //培训结束时间
    html += '<div class="col-md-4"><div class="form-group"><label for="field-4" class="control-label">培训结束时间：</label>';
    html += '<input type="datetime-local" value="' + (data.roadShow_title || '') + '" class="form-control"name="stop_time" id="stop_time"></div></div>';
    //报名截止时间
    html += '<div class="col-md-4"><div class="form-group"><label for="field-4" class="control-label">报名截止时间：</label>';
    html += '<input type="datetime-local" value="' + (data.roadShow_title || '') + '" class="form-control"name="deadline" id="deadline"></div></div></div>';
    //缩略图
    html += '<div class="row"><div class="col-md-6"><div class="form-group"><label for="field-4" class="control-label">缩略图：</label>';
    html += '<img  name="banner" id="banner" src="' + (data.roadShow_title || '') + '" alt="缩略图""></div></div></div>';
    // 编辑器
    html += '<div class="row"> <div class="col-md-12"><div class="form-group no-margin"><label for="field-7"class="control-label">创业项目培训详情</label>';
    html += '<textarea class="" placeholder="请详细描述创业项目培训内容" id="UE" name="describe">' + (data.roadShow_title || '') + '</textarea></div></div></div>';
    return html;
}


// 显示个人用户详情
function showInfoList(data){
    $('.loading').hide();
    $('#alert-form').show();
    $('#con-close-modal').modal('show');
    if (data) {
        if (data.ServerNo == 200) {
            $('#alert-form').html(infoHtml(data.ResultData));
        } else {
            $('#alert-form').hide();
            $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
};