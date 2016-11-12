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

function add(data){
    $('.loading').hide();
    $('#myModal').modal('show');
    $('.modal-title').html('提示');
    console.log(data);
    if (data) {
        console.log(data);
        if (data.ServerNo == 200) {
            var code = data.ResultData;
            $('#alert-form').hide();
            _this.data('status', code);
            if (_this.children().hasClass("btn-danger")) {
                _this.children().removeClass("btn-danger").addClass("btn-primary").html('启用');
            } else if (_this.children().hasClass("btn-primary")) {
                _this.children().removeClass("btn-primary").addClass("btn-danger").html('禁用');
            }
            $('#fabu').hide();
            $('#alert-info').html('<p>路演发布成功!</p>');
        } else {
            $('#alert-info').html('<p>' + data.ResultData + '</p>');
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}

function listHtml(data){
    var html = '';
    console.log(data);
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th>路演主题</th><th>主讲人</th><th>所属机构</th><th>路演开始时间</th><th>操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.speaker + '</td>';
        html += '<td>' + e.group + '</td>';
        html += '<td>' + e.roadShow_time + '</td>';
        html += '<td><a class="info" data-name="' + e.roadShow_id + '" href="javascript:;"><button class="btn-primary">详情</button></a>';
        html += '<a class="charge" data-name="' + e.roadShow_id + '" href="javascript:;"><button class="btn-primary">修改路演</button></a>';
        if (e.status == 1) {
            html += '<a href="javascript:;" data-name="' + e.roadShow_id + '" data-status="' + e.status + '" class="status"><button class="btn-danger">禁用</button></a>';
        } else if (e.status == 3) {
            html += '<a href="javascript:;" data-name="' + e.roadShow_id + '" data-status="' + e.status + '" class="status"><button class="btn-primary">启用</button></a>';
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
    html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="field-1" class="control-label">路演主题</label>';
    html += '<input type="text" class="form-control" value="' + (data.title || '') + '" id="surname" placeholder="roadShow_title..." disabled="true"></div></div>';
    html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="field-1" class="control-label">发布时间</label>';
    html += '<input type="text" class="form-control" value="' + (data.time || '') + '" id="surname" placeholder="roadShow_title..." disabled="true"></div></div>';
    html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">主讲人</label>';
    html += '<input type="text" class="form-control" value="' + (data.speaker || '') + '" id="name" placeholder="speaker" disabled="true"></div></div>';
    html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">所属机构</label>';
    html += '<input type="text" class="form-control" value="' + (data.group || '') + '" id="english_name" placeholder="group" disabled="true"></div></div></div>';
    html += '<div class="row"><div class="col-md-3"><div class="form-group"><label for="field-2" class="control-label">路演开始时间</label>';
    html += '<input type="text" class="form-control" value="' + (data.roadShow_time)  + '" id="card_type" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-3"><div class="form-group"><label for="field-7" class="control-label">缩略图</label>';
    html += '<input type="text" class="form-control" value="' + (data.banner) + '" id="" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-6"><div class="form-group"><label for="field-4" class="control-label">点赞人数</label>';
    html += '<input type="text" class="form-control" value="' + (data.population|| '') + '" id="card_number" placeholder="无" disabled="true"></div></div></div>';
    html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="field-6" class="control-label">状态</label>';
    html += '<input type="text" class="form-control" value="' + (data.status || '') + '" id="birthday" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-2"><div class="form-group no-margin"><label for="field-7" class="control-label">简述</label>';
    html += '<input type="text" class="form-control" value="' + (data.brief) + '" id="sex" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-6"><div class="form-group no-margin"><label for="field-7" class="control-label">详情</label>';
    html += '<input type="text" class="form-control" value="' + (data.roadShow_descript || '') + '" id="tel" placeholder="无" disabled="true"></div></div></div>';
    return html;
}
// 判断身份证类型
function cardState(code){
    if(code == 1) {
        return '大陆身份证';
    }else if(code == 2) {
        return '其它身份证';
    }else if(code == 3) {
        return '护照';
    }else{
        return '';
    }
}

// 判断姓别类型
function sexMethod(code){
    if(code == 1) {
        return '男';
    }else if(code == 2) {
        return '女';
    }else {
        return '';
    }
}

// 显示路演信息详情
function showInfoList(data){
    $('.loading').hide();
    $('#alert-form').show();
    $('#myModal').modal('show');
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
}

function addR(data){
    $('.loading').hide();
    $('#alert-form').show();
    $('MyModal').modal('show');
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
