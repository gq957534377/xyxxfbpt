/**
 * Created by wang fei long on 2016/11/15.
 */

function showCheckInvestor(data) {
    $('#title_one').removeClass('hidden');
    if (data) {
        if (data.StatusCode == 200) {
            if(data.ResultData.data == '') {
                $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
            }else {
                $('#data').html(listInvestorHtml(data));
                $('#page').html(data.ResultData.pages);
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

// 用户列表
function listInvestorHtml(data){
    var html = '';
    html += '<div class="panel-body">' +
        '<table class="table table-bordered table-striped">' +
        '<thead>' +
        '<tr>' +
        '<th>item</th>' +
        '<th>姓名</th>' +
        '<th>性别</th>' +
        '<th>手机</th>' +
        '<th>审核</th>' +
        '<th>操作</th>' +
        '</tr>' +
        '</thead>';
    html += '<tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + (i + 1) + '</td>';
        html += '<td>' + e.realname + '</td>';
        html += '<td>' + e.sex + '</td>';
        html += '<td>' + e.tel + '</td>';
        html += '<td><a class="info" data-name="' + e.guid + '" href="javascript:;"><button class="btn btn-info btn-xs">审核</button></a>' + '</td>';
        html += '<td>';
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="pass"><button class="btn btn-success btn-xs">通过</button></a>';
        html += ' ';
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="fail"><button class="btn btn-danger btn-xs">不通过</button></a>';
        html += '</td>';
    });
    html += '</tbody>' +
        '</table>' +
        '</div>' +
        '<div class="row">' +
        '<div class="col-sm-8"></div>' +
        '<div class="col-sm-4" id="page"></div>' +
        '</div>';
    return html;
}

// 审核弹出内容
function infoInvestorHtml(data){
    var html = '';
    html += '<div class="row">';
    html += '<div class="col-md-8">' +
        '<div class="form-group">' +
        '<label for="field-2" class="control-label">真实姓名：</label>';
    html += '<input type="text" class="form-control" value="' + (data.realname || '') + '" id="name" placeholder="无" disabled="true">' +
        '</div>' +
        '</div>';
    html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">性别：</label>';
    html += '<input type="text" class="form-control" value="' + (data.sex || '') + '" id="english_name" placeholder="无" disabled="true"></div></div></div>';

    html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">生日：</label>';
    html += '<input type="text" class="form-control" value="' + data.birthday  + '" id="card_type" placeholder="无" disabled="true"></div></div>';
    html += '<div class="col-md-8"><div class="form-group no-margin"><label for="field-7" class="control-label">手机：</label>';
    html += '<input type="text" class="form-control" value="' + (data.tel || '') + '" id="tel" placeholder="无" disabled="true"></div></div></div>';

    html += '<div class="col-md-3"><div class="form-group no-margin"><label for="field-7" class="control-label">证件类型：</label>';
    html += '<input type="text" class="form-control" value="' + '' + '" id="sex" placeholder="身份证" disabled="true"></div></div>';
    html += '<div class="col-md-9"><div class="form-group"><label for="field-4" class="control-label">证件号码：</label>';
    html += '<input type="text" class="form-control" value="' + (data.card_number|| '') + '" id="card_number" placeholder="无" disabled="true"></div></div></div>';

    html += '<div class="col-md-12"><div class="form-group no-margin"><label for="field-7" class="control-label">家庭详细地址：</label>';
    html += '<input type="text" class="form-control" value="' + (data.hometown || '') + '" id="address" placeholder="无" disabled="true"></div></div></div>';
    html += '<div class="row">' +
        '<div class="col-md-6"><div class="form-group no-margin">' +
        '<label for="field-7" class="control-label">身份证正面：</label>' +
        '<img src="admin/images/card_pic_z.png" alt="身份证正面" width="150px">' +
        '</div>' +
        '</div>';
    html += '<div class="col-md-6">' +
        '<div class="form-group no-margin">' +
        '<label for="field-7" class="control-label">身份证反面：</label>' +
        '<img src="admin/images/card_pic_b.png" alt="身份证反面" width="150px">' +
        '</div>' +
        '</div>' +
        '</div>';
    return html;
}