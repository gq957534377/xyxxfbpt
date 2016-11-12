/**
 * Created by wang fei long on 2016/11/12.
 */

function listHtml(data){
    var html = '';
    html += '<div class="panel-body">' +
        '<table class="table table-bordered table-striped">' +
            '<thead>' +
                '<tr>' +
                    '<th>item</th>' +
                    '<th>姓名</th>' +
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
        html += '<td>' + e.tel + '</td>';
        html += '<td><a class="info" data-name="' + e.guid + '" href="javascript:;"><button class="btn btn-info btn-xs">审核</button></a>' + '</td>';
        html += '<td>';
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="status"><button class="btn btn-success btn-xs">通过</button></a>';
        html += ' ';
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="status"><button class="btn btn-danger btn-xs">不通过</button></a>';
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