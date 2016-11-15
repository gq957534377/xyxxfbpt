/**
 * Created by wang fei long on 2016/11/15.
 */

function showNormal(data) {
    $('#title_one').removeClass('hidden');
    if (data) {
        if (data.StatusCode == 200) {
            if(data.ResultData.data == '') {
                $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
            }else {
                $('#data').html(listNormalHtml(data));
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


function listNormalHtml(data){
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
        '<th>操作</th>' +
        '</tr>' +
        '</thead>';
    html += '<tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + (i + 1) + '</td>';
        html += '<td>' + e.nickname + '</td>';
        html += '<td>' + e.realname + '</td>';
        html += '<td>' + e.sex + '</td>';
        html += '<td>' + e.birthday + '</td>';
        html += '<td>' + e.tel + '</td>';
        html += '<td>' + e.email + '</td>';
        html += '<td>';
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="modify"><button class="btn btn-info btn-xs">修改</button></a>';
        html += ' ';
        html += '<a href="javascript:;" data-name="' + e.guid + '" class="delete"><button class="btn btn-danger btn-xs">删除</button></a>';
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