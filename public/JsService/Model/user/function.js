/**
 * Created by wang fei long on 2016/11/16.
 */

//处理 ajax
function load(url, data, type, success) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url     : url,
        data    : data,
        type    : type,
        async   : true,
        success : success
    });
}

//事件 初始化
function initial() {
    $('.add_event').off('click').on('click', function () {
        //重设按钮颜色
        $('.btn-success').removeClass('btn-success').addClass('btn-default');
        $(this).addClass('btn-success');
        //设置请求参数，更改标题
        var data = null;
        var tmp = $(this).data('name');
        if(tmp == 'normal') {
            user_role = '1';
            $('#user_title').text('普通用户');
        }
        if(tmp == 'entrepreneurs') {
            user_role = '2';
            $('#user_title').text('创业者用户');
        }
        if(tmp == 'investor') {
            user_role = '3';
            $('#user_title').text('投资者用户');
        }
        if(tmp == 'check_entrepreneurs') {
            user_role = '4';
            $('#user_title').text('待审核创业者用户');
            $('#checking').addClass('btn-success');
        }
        if(tmp == 'check_investor') {
            user_role = '5';
            $('#user_title').text('待审核投资者用户');
            $('#checking').addClass('btn-success');
        }
        data = {
            role : user_role
        };
        if(data.role == '1' || data.role == '2' || data.role == '3')
            load('/user/create', data, 'GET', showNormal);
        if(data.role == '4' || data.role == '5')
            load('/user_role/create', data, 'GET', showCheckInvestor);

    });
}

//事件 分页 重新请求数据并加载
function getPage() {
    $('.pagination li a').removeAttr('href');
    $('.pagination li').off('click').click(function () {

        var class_name = $(this).prop('class');
        if(class_name == 'disabled' || class_name == 'active') {
            return false;
        }
        var nowPage = $(this).children('a').text();

        var data = {
            role : user_role,
            nowPage : nowPage
        };

        if(user_role == '1' || user_role == '2' || user_role == '3')
            load('user/create', data, 'GET', showNormal);
        if(user_role == '4' || user_role == '5')
            load('user_role/create', data, 'GET', showCheckInvestor);
    });
}

//事件 修改
function modifyData() {
    $('.modify').off("click").click(function (event) {
        event.stopPropagation();
        var data = {
            role : '1',
            name : $(this).data('name')
        };
        $.ajax({
            url     : '/users_one_data',
            type    : 'get',
            data    : data,
            success : function showInfoList(data){
                $('.loading').hide();
                $('#con-modal').modal('show');
                $('#cancel').removeClass("hidden");
                $('#post').removeClass("hidden");
                $('#close').addClass("hidden");
                if (data) {
                    if (data.StatusCode == 200) {
                        $('#alert-info').hide();
                        $('#alert-form').show().html(infoHtml(data.ResultData));
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
                    }
                } else {
                    $('#alert-form').hide();
                    $('#alert-info').html('<p>未知的错误</p>');
                }
            }
        });
    });
    submitData();
}

// 事件 提交修改
function submitData() {
    $('#post').off("click").click(function (event) {
        event.stopPropagation();
        var data = {
            realname : $('#realname').val(),
            nickname : $('#nickname').val(),
            sex       : $('#sex').val(),
            birthday : $('#birthday').val(),
            tel       : $('#tel').val(),
            email     : $('#email').val(),
            role      : '1',
            id        : $('#guid').text()
        };

        $.ajax({
            url : '/users_data',
            type : 'put',
            data : data,
            success: function checkStatus(data){
                $('.loading').hide();
                $('#con-modal').modal('show');
                $('#cancel').addClass("hidden");
                $('#post').addClass("hidden");
                $('#close').removeClass("hidden");
                if (data) {
                    if (data.StatusCode == 200) {
                        $('#alert-form').hide();
                        $('#alert-info').show().html('<p>数据修改成功!</p>');
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
                    }
                } else {
                    $('#alert-form').hide();
                    $('#alert-info').show().html('<p>未知的错误</p>');
                }
            }
        });
//                return false;
    });
}

//事件 更改 禁用|激活 通过|不通过 删除
function changeAllStatus(){
    $('.unlock, .lock, .pass, .fail, .delete').off('click').on('click', function () {
        window.user_guid = $(this).data('name');
        window.item = $(this).parent().siblings("td").first().text();
        $pointer1 = (user_role == '1' || user_role == '2' || user_role == '3');
        $pointer2 = (user_role == '4' || user_role == '5');
        var data = null;
        var status = null;
        var url =null;
        if($(this).hasClass('delete')){
            if($pointer1) {
                status = '3';
                url = '/user/' + $(this).data('name');
            }
            if($pointer2) {
                status = '4';
                url = '/user_role/' + $(this).data('name');
            }
        }
        if($(this).hasClass('unlock')){
            status = '1';
            url = '/user/' + $(this).data('name');
        }
        if($(this).hasClass('lock')){
            status = '2';
            url = '/user/' + $(this).data('name');
        }
        if($(this).hasClass('fail')){
            status = '3';
            url = '/user_role/' + $(this).data('name');
        }
        if($(this).hasClass('pass')){
            status = '2';
            url = '/user_role/' + $(this).data('name');
        }

        data = {
            status : status,
            role : user_role
        };

        load(url, data, 'put', checkStatus);
    })
}

//处理 针对ajax返回的数据做处理
//data 必选 表示ajax返回的数据
//func 可选 表示数据成功时需要加载的函数
function checkResponse(data, func) {
    var funct = func || null;
    $('#title_one').removeClass('hidden');
    if (data) {
        if (data.StatusCode == 200) {
            if(data.ResultData.data == '') {
                $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
            }else {
                $('#data').html(listNormalHtml(data));
                $('#page').html(data.ResultData.pages);
                if(!(funct == null)){
                    $.each(funct, function (i , e) {
                        e();
                    });
                }
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

//处理 针对ajax修改操作返回的数据做处理
//data 必选 表示ajax返回的数据
//func 可选 表示数据成功时需要加载的函数
function checkResponseStatus(data, func){
    var funct = func || null;
    $('.loading').hide();
    $('#con-modal').modal('show');
    $('#close').removeClass("hidden");
    if (data) {
        if (data.StatusCode == 200) {
            $('#alert-form').hide();
            $('#alert-info').show().html('<p>数据修改成功!</p>');
            if(!(funct == null)){
                $.each(funct, function (i , e) {
                    e();
                });
            }
        } else {
            $('#alert-form').hide();
            $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').show().html('<p>未知的错误</p>');
    }
}

//处理 动态修改内容
function changeContent(){
    var data = {
        name : window.user_guid,
        role : user_role
    };
    if(user_role == '1' || user_role == '2' || user_role == '3'){
        load('/user/create', data, 'GET', function (data) {
            var e = data.ResultData;
            var html = '';
            var status = null;
            var p1, p2, p3 = '';
            if(e.status == 1){
                status = '<p class="text-success">激活</p>';
                p1 = 'disabled';
            }
            if(e.status == 2){
                status = '<p class="text-warning">禁用</p>';
                p2 = 'disabled';
            }
            if(e.status == 3){
                status = '<p class="text-danger">删除</p>';
                p3 = 'disabled';
            }
            html += '<td>' + item + '</td>';
            html += '<td>' + e.nickname + '</td>';
            html += '<td>' + e.realname + '</td>';
            html += '<td>' + e.sex + '</td>';
            html += '<td>' + e.birthday + '</td>';
            html += '<td>' + e.tel + '</td>';
            html += '<td>' + e.email + '</td>';
            html += '<td>' + status + '</td>';
            html += '<td>';
            html += '<a href="javascript:;" data-name="' + e.guid + '" class="modify"><button class="btn btn-info btn-xs">修改</button></a>';
            html += '<a href="javascript:;" data-name="' + e.guid + '" class="unlock"><button class="btn btn-success ' + p1 + '  btn-xs">激活</button></a>';
            html += '<a href="javascript:;" data-name="' + e.guid + '" class="lock"><button class="btn btn-warning ' + p2 + ' btn-xs">禁用</button></a>';
            html += '<a href="javascript:;" data-name="' + e.guid + '" class="delete"><button class="btn btn-danger ' + p3 + '  btn-xs">删除</button></a>';
            html += '</td>';
            $(".gradeX").eq(item - 1).html(html);

            //DOM树替换后再次分配事件
            changeAllStatus();
        });
    }

    if(user_role == '4' || user_role == '5'){
        load('/user_role/create', data, 'GET', function (data) {
            var e = data.ResultData;
            var html = '';
            var status = null;
            var p1, p2, p3, p4= '';
            if(e.status == 1){
                status = '<p class="text-success">待审核</p>';
                p1 = 'disabled';
            }
            if(e.status == 2){
                status = '<p class="text-warning">审核成功</p>';
                p2 = 'disabled';
            }
            if(e.status == 3){
                status = '<p class="text-danger">审核失败</p>';
                p3 = 'disabled';
            }
            if(e.status == 4){
                status = '<p class="text-danger">删除</p>';
                p4 = 'disabled';
            }

            html += '<td>' + item + '</td>';
            html += '<td>' + e.realname + '</td>';
            html += '<td>' + e.sex + '</td>';
            html += '<td>' + e.tel + '</td>';
            html += '<td>' + e.card_number + '</td>';
            html += '<td>' + status + '</td>';
            html += '<td>';
            html += '<a href="javascript:;" class="info check" data-name="' + e.guid + '"><button class="btn btn-info btn-xs">审核</button></a>';
            html += '<a href="javascript:;" class="info pass" data-name="' + e.guid + '"><button class="btn btn-success ' + p2 + ' btn-xs">通过</button></a>';
            html += '<a href="javascript:;" class="info fail" data-name="' + e.guid + '"><button class="btn btn-warning ' + p3 + ' btn-xs">不通过</button></a>';
            html += '<a href="javascript:;" class="info delete" data-name="' + e.guid + '"><button class="btn btn-danger ' + p4 + ' btn-xs">删除</button></a>';
            html += '</td>';

            $(".gradeX").eq(item - 1).html(html);

            //DOM树替换后再次分配事件
            changeAllStatus();
        });
    }
}