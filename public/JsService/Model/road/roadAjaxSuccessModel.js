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
    html += '<div class="panel-body"><table class="table table-bordered table-striped"><thead><tr><th>路演主题</th><th>主讲人</th><th>所属机构</th><th>路演开始时间</th><th>路演发布时间</th><th>操作</th></tr></thead><tbody>';
    $.each(data.ResultData.data, function (i, e) {
        html += '<tr class="gradeX">';
        html += '<td>' + e.title+ '</td>';
        html += '<td>' + e.speaker + '</td>';
        html += '<td>' + group(e.group) + '</td>';
        html += '<td>' + e.roadShow_time + '</td>';
        html += '<td>' + e.time + '</td>';
        html += '<td><a class="info" data-name="' + e.roadShow_id + '" href="javascript:;"><button class="btn-primary">详情</button></a>';
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
    $('#yz_xg').find('input[name=speaker]').val(data.speaker);
    $('#yz_xg').find('select[name=group]').val(data.group);
    $('#yz_xg').find('input[name=roadShow_time]').val(data.roadShow_time);
    $('#yz_xg').find('textarea[name=brief]').val(data.brief);
    // $('#yz_xg').find('textarea[name=roadShow_describe]').val(data.roadShow_describe);
    ue1.setContent(data.roadShow_describe);
    $('.loading').hide();
}


// 修改路演信息详情
function showUpdate(data){
    console.log(data);
    $('.loading').hide();
    $('#con-close-modal').modal('show');
    // $('#myModal').modal('show');
    if (data) {
        if (data.ServerNo == 200) {
            var test = document.getElementById('xiugai');
            test.dataset.name = data.ResultData.roadShow_id;
            console.log(data.ResultData.title);
            $('#title').val(data.ResultData.title);
            $('#speaker').val(data.ResultData.speaker);
            $('#group').val(data.ResultData.group);
            $('#roadShow_time').val(data.ResultData.roadShow_time);
            $('#banner').val(data.ResultData.banner);
            $('#brief').html(data.ResultData.brief);
            ue.setContent(data.ResultData.roadShow_describe);
        } else {
            $('#alert-form').hide();
            $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}
// 显示路演信息详情
function showInfoList(data){
    $('.loading').hide();
    $('#alert-form').show();
    $('#myModal').modal('show');
    if (data) {
        if (data.ServerNo == 200) {
            // console.log(data);
            data = data.ResultData;
            // $('#alert-form').html(infoHtml(data.ResultData));
            $('#alert-form').html('<div><img src="admin/images/banner.png" style="width: 100%"></div><div class="row"><div class="col-md-6"><div class="form-group"><label for="field-1" class="control-label">路演主题</label><input type="text" id="roadShow_title" class="form-control" value="'+data.title+'" disabled="true"></div></div><div class="col-md-6"><div class="form-group"><label for="field-2" class="control-label">主讲人</label><input value="'+data.speaker+'" type="text" class="form-control" id="speaker" placeholder="Doe" disabled="true"></div></div></div><div class="row"><div class="col-md-12"><div class="form-group"><label for="field-3" class="control-label">路演开始时间</label><input type="datetime-local" class="form-control" id="roadShow_time" value="'+data.roadShow_time+'" placeholder="Address" disabled="true"></div></div></div><div class="row"><div class="col-md-4"><div class="form-group"><label for="field-4" class="control-label">所属机构</label><input value="'+group(data.group)+'" type="text" class="form-control" id="group" placeholder="Boston" disabled="true"></div></div><div class="col-md-4"><div class="form-group"><label for="field-5" class="control-label">目前参与人数</label><input value="'+data.population+'" type="text" class="form-control" id="population" placeholder="United States" disabled="true"></div></div><div class="col-md-4"><div class="form-group"><label for="field-5" class="control-label">发布时间</label><input type="datetime-local" value="'+data.time+'" class="form-control" id="time" placeholder="United States" disabled="true"></div></div></div><div class="row"><div class="col-md-12"><label for="field-5" class="control-label">简述</label><p id="brief" disabled="true">'+data.brief+'</p></div></div><div class="row"><div class="col-md-12"><label for="field-5" class="control-label">路演详情</label><p id="roadShow_describe" disabled="true">'+data.roadShow_describe+'</p></div></div>');
            // $('#alert-form').html('<div class="modal-content p-0"><ul class="nav nav-tabs nav-justified"><li class=""><a href="#home-2" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-home"></i></span><span class="hidden-xs">Home</span></a></li><li class=""><a href="#profile-2" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-user"></i></span><span class="hidden-xs">Profile</span></a></li><li class="active"><a href="#messages-2" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-envelope-o"></i></span><span class="hidden-xs">Messages</span></a></li><li class=""><a href="#settings-2" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i></span><span class="hidden-xs">Settings</span></a></li></ul><div class="tab-content"><div class="tab-pane" id="home-2"><div><p>Carriage quitting securing be appetite it declared. High eyes kept so busy feel call in. Would day nor ask walls known. But preserved advantage are but and certainty earnestly enjoyment. Passage weather as up am exposed. And natural related man subject. Eagerness get situation his was delighted. </p><p>Fulfilled direction use continual set him propriety continued. Saw met applauded favourite deficient engrossed concealed and her. Concluded boy perpetual old supposing. Farther related bed and passage comfort civilly. Dashwoods see frankness objection abilities the. As hastened oh produced prospect formerly up am. Placing forming nay looking old married few has. Margaret disposed add screened rendered six say his striking confined. </p></div></div><div class="tab-pane" id="profile-2"><p>Fulfilled direction use continual set him propriety continued. Saw met applauded favourite deficient engrossed concealed and her. Concluded boy perpetual old supposing. Farther related bed and passage comfort civilly. Dashwoods see frankness objection abilities the. As hastened oh produced prospect formerly up am. Placing forming nay looking old married few has. Margaret disposed add screened rendered six say his striking confined. </p><p>When be draw drew ye. Defective in do recommend suffering. House it seven in spoil tiled court. Sister others marked fat missed did out use. Alteration possession dispatched collecting instrument travelling he or on. Snug give made at spot or late that mr. </p></div><div class="tab-pane active" id="messages-2"><p>When be draw drew ye. Defective in do recommend suffering. House it seven in spoil tiled court. Sister others marked fat missed did out use. Alteration possession dispatched collecting instrument travelling he or on. Snug give made at spot or late that mr. </p><p>Carriage quitting securing be appetite it declared. High eyes kept so busy feel call in. Would day nor ask walls known. But preserved advantage are but and certainty earnestly enjoyment. Passage weather as up am exposed. And natural related man subject. Eagerness get situation his was delighted. </p></div><div class="tab-pane" id="settings-2"><p>Luckily friends do ashamed to do suppose. Tried meant mr smile so. Exquisite behaviour as to middleton perfectly. Chicken no wishing waiting am. Say concerns dwelling graceful six humoured. Whether mr up savings talking an. Active mutual nor father mother exeter change six did all. </p><p>Carriage quitting securing be appetite it declared. High eyes kept so busy feel call in. Would day nor ask walls known. But preserved advantage are but and certainty earnestly enjoyment. Passage weather as up am exposed. And natural related man subject. Eagerness get situation his was delighted. </p></div></div></div>');
            // $('#alert-form').html('<div class="modal-content p-0"><ul class="nav nav-tabs nav-justified _btnbox"><li class=""><a href="#home-2" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-home"></i></span><span class="hidden-xs">Home</span></a></li><li class=""><a href="#profile-2" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-user"></i></span><span class="hidden-xs">Many</span></a></li><li class="active"><a href="#messages-2" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-envelope-o"></i></span><span class="hidden-xs">Brief</span></a></li><li class=""><a href="#settings-2" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i></span><span class="hidden-xs">Describe</span></a></li></ul><div class="tab-content"><div class="tab-pane" id="home-2"><div><img src="admin/images/banner.png" style="width: 100%"></div></div><div class="tab-pane" id="profile-2"><div class="row"><div class="col-md-6"><div class="form-group"><label for="field-1" class="control-label">路演主题</label><input type="text" id="roadShow_title" class="form-control" disabled="true"></div></div><div class="col-md-6"><div class="form-group"><label for="field-2" class="control-label">主讲人</label><input type="text" class="form-control" id="speaker" placeholder="Doe" disabled="true"></div></div></div><div class="row"><div class="col-md-12"><div class="form-group"><label for="field-3" class="control-label">路演开始时间</label><input type="text" class="form-control" id="roadShow_time" placeholder="Address" disabled="true"></div></div></div><div class="row"><div class="col-md-4"><div class="form-group"><label for="field-4" class="control-label">所属机构</label><input type="text" class="form-control" id="group" placeholder="Boston" disabled="true"></div></div><div class="col-md-4"><div class="form-group"><label for="field-5" class="control-label">目前参与人数</label><input type="text" class="form-control" id="population" placeholder="United States" disabled="true"></div></div><div class="col-md-4"><div class="form-group"><label for="field-5" class="control-label">发布时间</label><input type="text" class="form-control" id="time" placeholder="United States" disabled="true"></div></div></div></div><div class="tab-pane active" id="messages-2"><div class="row"><div class="col-md-12"><p id="brief" disabled="true"></p></div></div></div><div class="tab-pane" id="settings-2"><div class="row"><div class="col-md-12"><p id="roadShow_describe" disabled="true"></p></div></div></div></div></div><script src="http://cdn.rooyun.com/js/jquery.counterup.min.js"></script>');
            // $('._btnbox').find('li').click(function(){
            //     console.log($('._btnbox').find('li'));
            //     for(i=0;i<3;i++){
            //         // $('.tab-content').find('div')[i].currentStyle.display="none";
            //         $('.tab-content').find('div')[i].addClass('active');
            //         if($('._btnbox').find('li')[i].getAttribute("class")=='active')
            //         {
            //             $('.tab-content').find('div')[i].currentStyle.display="block";
            //         }
            //     }
            // })
        } else {
            $('#alert-form').hide();
            $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
    $('#alert-form').html();
}
