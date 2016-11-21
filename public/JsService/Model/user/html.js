/**
 * Created by wang fei long on 2016/11/16.
 */

// 普通用户 创业者 投资者 共用主列表页面样式
function listUserShow(data){
    var html = '';
    html += '<div class="panel-body">' +
        '<table class="table table-bordered table-striped">' +
        '<thead>' +
        '<tr>' +
        '<th>item</th>' +
        '<th>昵称</th>' +
        '<th>姓名</th>' +
        '<th>性别</th>' +
        '<th>生日</th>' +
        '<th>手机</th>' +
        '<th>邮箱</th>' +
        '<th>用户状态</th>' +
        '<th>操作</th>' +
        '</tr>' +
        '</thead>';
    html += '<tbody>';
    $.each(data.ResultData.data, function (i, e) {
        var status = null;
        var p = '';
        var sex = null;
        if(e.sex == 1) sex = "男";
        if(e.sex == 2) sex = "女";
        if(e.status == 1){
            status = '<p class="text-success">正常</p>';
            p = 1;
        }
        if(e.status == 2){
            status = '<p class="text-warning">禁用</p>';
            p = 2;
        }
        if(e.status == 3){
            status = '<p class="text-danger">已停用</p>';
            p = 3;
        }

        html += '<tr class="gradeX">';
        html += '<td>' + (i + 1) + '</td>';
        html += '<td>' + e.nickname + '</td>';
        html += '<td>' + e.realname + '</td>';
        html += '<td>' + sex + '</td>';
        html += '<td>' + e.birthday + '</td>';
        html += '<td>' + e.tel + '</td>';
        html += '<td>' + e.email + '</td>';
        html += '<td>' + status + '</td>';
        html += '<td>';

        html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_modify"><button class="btn btn-info btn-xs">修改</button></a>';
        if (p != 1 && p != 3)
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_unlock"><button class="btn btn-success btn-xs">激活</button></a>';
        if (p != 2 && p != 3)
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_lock"><button class="btn btn-warning btn-xs">禁用</button></a>';
        if (p != 2 && p != 3)
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_delete"><button class="btn btn-danger btn-xs">停用</button></a>';
        if (p == 3)
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_un_delete"><button class="btn btn-danger btn-xs">启用</button></a>';

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

// 普通用户 创业者 投资者 用户详情页，暂用同一个
function userDetailShow(data) {
    //
}

// 修改时弹出
function userInfoUpdateShow(data) {
    var sex = null;
    if(data.sex == 1) sex = "男";
    if(data.sex == 2) sex = "女";
    var html = '';
    html += '<div class="row">';
    html += '<div class="col-md-4">' +
        '<div class="form-group">' +
        '<label for="field-2" class="control-label">真实姓名：</label>';
    html += '<input type="text" class="form-control" value="' + (data.realname || '') + '" id="realname" placeholder="无">' +
        '</div>' +
        '</div>';
    html += '<div class="col-md-4">' +
        '<div class="form-group">' +
        '<label for="field-2" class="control-label">昵称：</label>';
    html += '<input type="text" class="form-control" value="' + (data.nickname || '') + '" id="nickname" placeholder="无">' +
        '</div>' +
        '</div>';
    html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">性别：</label>';
    html += '<input type="text" class="form-control" value="' + sex + '" id="sex" placeholder="无"></div></div></div>';

    html += '<div class="row">' +
        '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">生日：</label>';
    html += '<input type="text" class="form-control" value="' + data.birthday + '" id="birthday" placeholder="无"></div></div>';
    html += '<div class="col-md-4"><div class="form-group no-margin"><label for="field-7" class="control-label">手机：</label>';
    html += '<input type="text" class="form-control" value="' + (data.tel || '') + '" id="tel" placeholder="无"></div></div>';
    html += '<div class="col-md-4"><div class="form-group no-margin"><label for="field-7" class="control-label">邮箱：</label>';
    // html += '<span class="form-control hidden" id="guid">' + data.guid + '</span>';
    html += '<input type="text" class="form-control" value="' + (data.email || '') + '" id="email" placeholder="无"></div></div></div>';
    return html;
}

// 获得一条数据的html
function listUserOneShow(data){
    url = '/user/create';
    var req_data = {
        name : window.modify_guid
    };
    type = 'GET';
    load(url, req_data, type, function (data) {
        if (data) {
            if (data.StatusCode == 200) {

                var html = '';
                var e = data.ResultData;
                var status = null;
                var p = '';
                var sex = null;
                if(e.sex == 1) sex = "男";
                if(e.sex == 2) sex = "女";
                if(e.status == 1){
                    status = '<p class="text-success">正常</p>';
                    p = 1;
                }
                if(e.status == 2){
                    status = '<p class="text-warning">禁用</p>';
                    p = 2;
                }
                if(e.status == 3){
                    status = '<p class="text-danger">已停用</p>';
                    p = 3;
                }

                html += '<td>' + item + '</td>';
                html += '<td>' + e.nickname + '</td>';
                html += '<td>' + e.realname + '</td>';
                html += '<td>' + sex + '</td>';
                html += '<td>' + e.birthday + '</td>';
                html += '<td>' + e.tel + '</td>';
                html += '<td>' + e.email + '</td>';
                html += '<td>' + status + '</td>';
                html += '<td>';

                html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_modify"><button class="btn btn-info btn-xs">修改</button></a>';
                if (p != 1 && p != 3)
                    html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_unlock"><button class="btn btn-success btn-xs">激活</button></a>';
                if (p != 2 && p != 3)
                    html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_lock"><button class="btn btn-warning btn-xs">禁用</button></a>';
                if (p != 2 && p != 3)
                    html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_delete"><button class="btn btn-danger btn-xs">停用</button></a>';
                if (p == 3)
                    html += '<a href="javascript:;" data-name="' + e.guid + '" class="user_un_delete"><button class="btn btn-danger btn-xs">启用</button></a>';

                html += '</td>';

                $(".gradeX").eq(item - 1).html(html);

            }
        } else {
            $('#alert-form').hide();
            $('#alert-info').html('<p>未知的错误,不能展示修改！</p>');
        }
    });
}

// 创业者项目页面 投资者项目页面 暂用同一个
function listProjectShow(data){
    //
}

/////////////////////////////////////////////////////////////////

// 待审核创业者 投资者 共用主列表页面样式
function listRoleShow(data){
    var html = '';
    html += '<div class="panel-body">' +
        '<table class="table table-bordered table-striped">' +
        '<thead>' +
        '<tr>' +
        '<th>item</th>' +
        '<th>姓名</th>' +
        '<th>性别</th>' +
        '<th>手机</th>' +
        '<th>身份证号码</th>' +
        '<th>状态</th>' +
        '<th>操作</th>' +
        '</tr>' +
        '</thead>';
    html += '<tbody>';
    $.each(data.ResultData.data, function (i, e) {
        var status = null;
        var p= '';
        var sex = null;
        if(e.sex == 1) sex = "男";
        if(e.sex == 2) sex = "女";
        if(e.status == 1){
            status = '<p class="text-success">待审核</p>';
            p = 1;
        }
        if(e.status == 2){
            status = '<p class="text-warning">审核成功</p>';
            p = 2;
        }
        if(e.status == 3){
            status = '<p class="text-danger">审核失败</p>';
            p = 3;
        }
        // if(e.status == 4){
        //     status = '<p class="text-danger">删除</p>';
        // }

        html += '<tr class="gradeX">';
        html += '<td>' + (i + 1) + '</td>';
        html += '<td>' + e.realname + '</td>';
        html += '<td>' + sex + '</td>';
        html += '<td>' + e.tel + '</td>';
        html += '<td>' + e.card_number + '</td>';
        html += '<td>' + status + '</td>';
        html += '<td>';
        if(p == 1)
        html += '<a href="javascript:;" class="info check_check" data-name="' + e.guid + '"><button class="btn btn-info btn-xs">审核</button></a>';
        if(p == 3)
        html += '<a href="javascript:;" class="info check_check" data-name="' + e.guid + '"><button class="btn btn-info btn-xs">重新审核</button></a>';
        if(p == 3)
        html += '<a href="javascript:;" class="info check_delete" data-name="' + e.guid + '"><button class="btn btn-danger btn-xs">删除</button></a>';
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

// 审核弹出页面
function checkDetailShow(data){
    var sex = null;
    if(data.sex == 1) sex = "男";
    if(data.sex == 2) sex = "女";
    if(data.status == 3) $('.check_fail').show();
    // if(data.status == 3) $('.check_fail').addClass("hidden");
    var html = '';
    html += '<div class="row">';
    html += '<div class="col-md-8">' +
        '<div class="form-group">' +
        '<label for="field-2" class="control-label">真实姓名：</label>';
    html += '<input type="text" class="form-control" value="' + (data.realname || '') + '" id="name" placeholder="无" disabled="true">' +
        '</div>' +
        '</div>';
    html += '<div class="col-md-4"><div class="form-group"><label for="field-2" class="control-label">性别：</label>';
    html += '<input type="text" class="form-control" value="' + sex + '" id="english_name" placeholder="无" disabled="true"></div></div></div>';

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

