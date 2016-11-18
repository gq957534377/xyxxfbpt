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
        $(this).parent().parent().siblings('button').addClass('btn-success');
        //设置请求参数，更改标题
        var data = null;
        var tmp = $(this).data('name');
        // 普通用户 0-2
        if(tmp == 'user_normal') {
            user = 0;
            $('#user_title').text('普通用户');
        }
        if(tmp == 'user_normal_disabled') {
            user = 1;
            $('#user_title').text('禁用普通用户');
        }
        if(tmp == 'user_normal_deleted') {
            user = 2;
            $('#user_title').text('已停用普通用户');
        }
        // 创业者 3-5
        if(tmp == 'user_entrepreneurs') {
            user = 3;
            $('#user_title').text('创业者用户');
            $('#checking').addClass('btn-success');
        }
        if(tmp == 'user_entrepreneurs_disabled') {
            user = 4;
            $('#user_title').text('已禁用创业者用户');
            $('#checking').addClass('btn-success');
        }
        if(tmp == 'user_entrepreneurs_deleted') {
            user = 5;
            $('#user_title').text('已停用创业者用户');
            $('#checking').addClass('btn-success');
        }
        // 投资者 6-8
        if(tmp == 'user_investor') {
            user = 6;
            $('#user_title').text('投资者用户');
            $('#checking').addClass('btn-success');
        }
        if(tmp == 'user_investor_disabled') {
            user = 7;
            $('#user_title').text('已禁用投资者用户');
            $('#checking').addClass('btn-success');
        }
        if(tmp == 'user_investor_deleted') {
            user = 8;
            $('#user_title').text('已停用投资者用户');
            $('#checking').addClass('btn-success');
        }
        // 待审核 9-10
        if(tmp == 'check_entrepreneurs') {
            user = 9;
            $('#user_title').text('待审核创业者用户');
            $('#checking').addClass('btn-success');
        }
        if(tmp == 'check_investor') {
            user = 10;
            $('#user_title').text('待审核投资者用户');
            $('#checking').addClass('btn-success');
        }
        // 审核失败 11-12
        if(tmp == 'check_entrepreneurs_fail') {
            user = 11;
            $('#user_title').text('审核失败创业者用户');
            $('#checking').addClass('btn-success');
        }
        if(tmp == 'check_investor_fail') {
            user = 12;
            $('#user_title').text('审核失败投资者用户');
            $('#checking').addClass('btn-success');
        }

        data = roleData(user);

        // console.log(handle);

        if(data.role == 1 || data.role == 2 || data.role == 3)
            load('/user/create', data, 'GET', function (data) {
                checkResponse(data, window.handle, listUserShow);
            });
        if(data.role == 4 || data.role == 5)
            load('/user_role/create', data, 'GET', function (data) {
                checkResponse(data, window.handle, listRoleShow);
            });
    });
}

// 根据user返回data
function roleData(user) {
    //////////////////////普通用户
    if(user == 0)
        data = {
            role : 1,
            status : 1
        };
    if(user == 1)
        data = {
            role : 1,
            status : 2
        };
    if(user == 2)
        data = {
            role : 1,
            status : 3
        };
        ////////////////////创业者用户
    if(user == 3)
        data = {
            role : 2,
            status : 1
        };
    if(user == 4)
        data = {
            role : 2,
            status : 2
        };
    if(user == 5)
        data = {
            role : 2,
            status : 3
        };
        //////////////////////投资者用户
    if(user == 6)
        data = {
            role : 3,
            status : 1
        };
    if(user == 7)
        data = {
            role : 3,
            status : 2
        };
    if(user == 8)
        data = {
            role : 3,
            status : 3
        };
        //////////////////////待审核
    if(user == 9)
        data = {
            role : 4,
            status : 1
        };
    if(user == 10)
        data = {
            role : 5,
            status : 1
        };
    /////////////////////////审核失败
    if(user == 11)
        data = {
            role : 4,
            status : 3
        };
    if(user == 12)
        data = {
            role : 5,
            status : 3
        };

    return data;
}

// 根据user返回data
function numberData(number) {
       // user_unlock
    if(number == 0)
        return data = {
            status : 1
        };
        // user_lock
    if(number == 1)
        return data = {
            status : 2
        };
        // user_delete
    if(number == 2)
        return data = {
            status : 3
        };
        // user_un_delete
    if(number == 3)
        return data = {
            status : 1
        };

        ////////////////////////
        // check_pass
        // 审核成功分为 投资者 和 创业者 所以必须结合页面全局变量传递数据
    if(number == 4)
        return data = {
            status : 2
        };
        // check_fail
    if(number == 5)
        return data = {
            status : 3
        };
        // check_delete
    if(number == 6)
        return data = {
            status : 4
        };
    return false;
}

//事件 分页 重新请求数据并加载
function getPage() {
    $('.pagination li a').removeAttr('href');
    $('.pagination li').off('click').click(function () {

        var class_name = $(this).prop('class');
        if(class_name == 'disabled' || class_name == 'active') {
            return false;
        }
        window.nowpage = $(this).children('a').text();
        data = roleData(user);
        data.nowPage = window.nowpage;

        if(data.role == 1 || data.role == 2 || data.role == 3)
            load('/user/create', data, 'GET', function (data) {
                checkResponse(data, handle, listUserShow);
            });
        if(data.role == 4 || data.role == 5)
            load('/user_role/create', data, 'GET', function (data) {
                checkResponse(data, handle, listRoleShow);
            });
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

function getNumber(this_obj) {
    var object =this_obj;
    if(object.hasClass('user_unlock')) return number = 0;
    if(object.hasClass('user_lock')) return number = 1;
    if(object.hasClass('user_delete')) return number = 2;
    if(object.hasClass('user_un_delete')) return number = 3;
    if(object.hasClass('check_pass')) return number = 4;
    if(object.hasClass('check_fail')) return number = 5;
    if(object.hasClass('check_delete')) return number = 6;
    return false;
}

//事件 更改 禁用|激活 通过|不通过 删除
function changeSomeStatus(){
    $('.user_unlock, .user_lock, .user_delete, .user_un_delete, .check_pass, .check_fail, .check_delete').off('click').on('click', function () {
        //获得number
        getNumber($(this));

        window.item = $(this).parent().siblings("td").first().text();
        guid = $(this).data('name');

        $pointer1 = (number == 0 || number == 1 || number == 2 || number == 3);
        $pointer2 = (number == 4);
        $pointer3 = (number == 5 || number == 6);

        var url_1 = '/user/' + $(this).data('name');
        var url_2 = '/user_role/' + $(this).data('name');

        if($pointer1){
            load(url_1, numberData(getNumber($(this))), 'put', checkResponseStatus);
        }

        //发送一个信号，让服务器执行一个事务
        if($pointer2){
            var msg = {
                msg : "check_pass"
            };
            if(user == 9) load(url_1, msg, 'put', checkResponseStatus);
            if(user == 10) load(url_1, msg, 'put', checkResponseStatus);
        }
        if($pointer3){
            load(url_2, numberData(getNumber($(this))), 'put', checkResponseStatus);
        }

    })
}

//处理 针对ajax返回的数据做处理
//data 必选 表示ajax返回的数据
//func 可选 表示数据成功时需要加载的函数
//show 必选 表示要显示的html页面
function checkResponse(data, func, show) {
    var funct = func || null;
    $('#title_one').removeClass('hidden');
    if (data) {
        if (data.StatusCode == 400)
            $('#data').html('<p style="padding:20px;" class="text-center"> 获取数据失败！</p>');
        if (data.StatusCode == 200) {
            if(data.ResultData.data == '') {
                $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
            }else {
                $('#data').html(show(data));
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
function checkResponseStatus(data){
    $('.loading').hide();
    $('#con-modal').modal('show');
    $('#close').removeClass("hidden");
    if (data) {
        if (data.StatusCode == 200) {
            $('#alert-form').hide();
            $('#alert-info').show().html('<p>数据修改成功!</p>');
            $(".gradeX").eq(window.item - 1).empty();

            // 页面数据条数为零则刷新
            window.pagenum += 1;
            var num = $('.gradeX').length;
            if(num == window.pagenum){
                data = roleData(user);
                data.nowPage = (nowpage ? nowpage : 1) + 1;

                if(data.role == 1 || data.role == 2 || data.role == 3)
                    load('/user/create', data, 'GET', function (data) {
                        checkResponse(data, handle, listUserShow);
                    });
                if(data.role == 4 || data.role == 5)
                    load('/user_role/create', data, 'GET', function (data) {
                        checkResponse(data, handle, listRoleShow);
                    });
                window.pagenum = 0;
            }
            // changeSomeStatus();
        } else {
            $('#alert-form').hide();
            $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
            return false;
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').show().html('<p>未知的错误</p>');
        return false;
    }
}

//处理 动态修改内容
function changeContent(){
    var data = {
        name : window.user_guid,
        role : user
    };
    if(user == '1' || user == '2' || user == '3'){
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

    if(user == '4' || user == '5'){
        load('/user/create', data, 'GET', function (data) {
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