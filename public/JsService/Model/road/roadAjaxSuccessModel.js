/**
 * ajax成功执行函数
 * @author 郭庆
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
                updateRoad();
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
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th>路演主题</th><th>主讲人</th><th>所属机构</th><th>路演时间</th><th>截止报名</th><th>报名人数限定</th><th>报名人数</th><th>发布时间</th><th>操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.speaker + '</td>';
        html += '<td>' + group(e.group) + '</td>';
        html += '<td>' + e.start_time + '--'+e.end_time+'</td>';
        html += '<td>' + e.deadline+'</td>';
        html += '<td>' + e.limit+'</td>';
        html += '<td>' + e.population+'</td>';
        html += '<td>' + e.time + '</td>';
        html += '<td><a class="info" data-name="' + e.roadShow_id + '" href="javascript:;"><button class="btn-primary" data-toggle="modal" data-target="#tabs-modal">详情</button></a>';
        html += '<button data-name="' + e.roadShow_id + '" class="charge-road btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">修改路演</button>';
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


function group(type) {
    var res;
    switch (type){
        case 1:
            res = '英雄会';
            break;
        case 2:
            res = '兄弟会';
            break;
        default:
            res = '无名组织';
            break;
    }
    return res;
}

function date(data) {
    data = data.ResultData;
    console.log(data);
    $('#yz_xg').find('input[name=id]').val(data.roadShow_id);
    $('#yz_xg').find('input[name=title]').val(data.title);
    $('#yz_xg').find('input[name=end_time]').val(data.end_time);
    $('#yz_xg').find('input[name=deadline]').val(data.deadline);
    $('#yz_xg').find('input[name=address]').val(data.address);
    $('#yz_xg').find('input[name=limit]').val(data.limit);
    $('#yz_xg').find('input[name=speaker]').val(data.speaker);
    $('#yz_xg').find('input[name=banner]').val(data.banner);
    $('#charge_thumb_img').attr('src',data.banner);
    $('#yz_xg').find('select[name=group]').val(data.group);
    $('#yz_xg').find('input[name=start_time]').val(data.start_time);
    $('#yz_xg').find('textarea[name=brief]').val(data.brief);
    // $('#yz_xg').find('textarea[name=describe]').val(data.describe);
    ue1.setContent(data.describe);
    $('.loading').hide();
}
// 显示路演信息详情
function showInfoList(data){
    $('.loading').hide();
    if (data) {
        if (data.ServerNo == 200) {
            data = data.ResultData;
            console.log(data);
            $('#xq_title').val(data.title);
            $('#xq_speaker').val(data.speaker);
            $('#xq_type').val(data.type);
            $('#xq_group').val(group(data.group));
            $('#xq_start_time').val(data.start_time);
            $('#xq_end_time').val(data.end_time);
            $('#xq_deadline').val(data.deadline);
            $('#xq_time').val(data.time);
            $('#xq_banner').attr('src',data.banner);
            $('#xq_population').val(data.population);
            $('#xq_limit').val(data.limit);
            $('#xq_address').val(data.address);
            $('#xq_status').val(data.status);
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
