/**
 * ajax成功执行函数
 * @author 郭鹏超
 */

// 获取分页数据并加载显示在页面
function getInfoList(data){
    console.log(data);
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
            $('#alert-info').html('<p>' + data.ResultData.pages + '</p>');
        }
    } else {
        $('#con-close-modal').modal('show');
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}

function listHtml(data){
    var html = '';
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th>item</th><th>用户名</th><th>手机</th><th>证件号码</th><th>操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + (i + 1) + '</td>';
        html += '<td>' + e.surname + e.name + '</td>';
        html += '<td>' + e.tel + '</td>';
        html += '<td>' + e.card_number + '</td>';
        html += '<td><a class="info" data-name="' + e.guid + '" href="javascript:;"><button class="btn btn-primary btn-xs">用户详情</button></a>';
        html += '<a class="order" data-name="' + e.guid + '" href="javascript:;"><button class="btn btn-primary btn-xs">订单详情</button></a>';
        html += '<a class="card" data-name="' + e.guid + '" href="javascript:;"><button class="btn btn-primary btn-xs">银行卡详情</button></a>';
        if (e.status == 1) {
            html += '<a href="javascript:;" data-name="' + e.guid + '" data-status="' + e.status + '" class="status"><button class="btn btn-danger btn-xs">禁用</button></a>';
        } else if (e.status == 3) {
            html += '<a href="javascript:;" data-name="' + e.guid + '" data-status="' + e.status + '" class="status"><button class="btn btn-primary btn-xs">启用</button></a>';
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
    html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="field-1" class="control-label">姓：</label>';
    html += '<input type="text" class="form-control" value="' + (data.surname || '') + '" id="surname" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">名：</label>';
    html += '<input type="text" class="form-control" value="' + (data.name || '') + '" id="name" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">英文名：</label>';
    html += '<input type="text" class="form-control" value="' + (data.english_name || '') + '" id="english_name" placeholder="无" disabled="true"></div></div></div>';
    html += '<div class="row"><div class="col-md-3"><div class="form-group"><label for="field-2" class="control-label">证件类型：</label>';
    html += '<input type="text" class="form-control" value="' + cardState(data.card_type)  + '" id="card_type" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-3"><div class="form-group"><label for="field-5" class="control-label">签证国家：</label>';
    html += '<input type="text" class="form-control" value="' + (data.card_state || '') + '" id="card_state" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-6"><div class="form-group"><label for="field-4" class="control-label">证件号码：</label>';
    html += '<input type="text" class="form-control" value="' + (data.card_number|| '') + '" id="card_number" placeholder="无" disabled="true"></div></div></div>';
    html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="field-6" class="control-label">生日：</label>';
    html += '<input type="text" class="form-control" value="' + (data.birthday || '') + '" id="birthday" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-2"><div class="form-group no-margin"><label for="field-7" class="control-label">姓别：</label>';
    html += '<input type="text" class="form-control" value="' + sexMethod(data.sex) + '" id="sex" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-6"><div class="form-group no-margin"><label for="field-7" class="control-label">手机：</label>';
    html += '<input type="text" class="form-control" value="' + (data.tel || '') + '" id="tel" placeholder="无" disabled="true"></div></div></div>';
    html += '<div class="row"><div class="col-md-2"><div class="form-group no-margin"><label for="field-7" class="control-label">国籍：</label>';
    html += '<input type="text" class="form-control" value="' + (data.address_state || '') + '" id="address_state" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-10"><div class="form-group no-margin"><label for="field-7" class="control-label">家庭详细地址：</label>';
    html += '<input type="text" class="form-control" value="' + (data.address || '') + '" id="address" placeholder="无" disabled="true"></div></div></div>';
    html += '<div class="row"><div class="col-md-6"><div class="form-group no-margin"><label for="field-7" class="control-label">身份证正面：</label>';
    html += '<img src="/images/card_pic_z.png" alt="身份证正面" width="150px"></div></div>';
    html += '<div class="col-md-6"><div class="form-group no-margin"><label for="field-7" class="control-label">身份证反面：</label>';
    html += '<img src="/images/card_pic_b.png" alt="身份证反面" width="150px"></div></div></div>';
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