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


// 根据user返回data

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
    if(number == 7)
        return data = {
            memeber : 4
        };
    if(number == 8)
        return data = {
            memeber : 3
        };
    if(number == 9)
        return data = {
            memeber : 5
        };
    if(number == 10)
        return data = {
            memeber : 6
        };
    return false;

}


//事件 修改
function modifyData() {
    $('.user_modify').off("click").click(function () {
        window.modify_guid = $(this).data('name');
        window.item = $(this).parent().siblings("td").first().text();
        url = '/user/create';
        var req_data = {
            name : window.modify_guid
        };
        type = 'GET';
        load(url, req_data, type, function (data) {
            // $('.loading').hide();
            $('#con-modal').modal('show');
            $('#cancel').removeClass("hidden");
            $('#post').removeClass("hidden");
            $('#close').addClass("hidden");
            if (data) {
                if (data.StatusCode == 200) {
                    $('#alert-info').hide();
                    $('#alert-form').show().html(userInfoUpdateShow(data.ResultData));
                    submitData();
                } else {
                    $('#alert-form').hide();
                    $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
                }
            } else {
                $('#alert-form').hide();
                $('#alert-info').html('<p>未知的错误</p>');
            }
        });
    });
}

//事件 审核
function checkInfo() {
    $('.check_check').off("click").click(function () {

        window.item = $(this).parent().siblings("td").first().text();

        var guid = $(this).data('name');
        url = 'user_role/create';
        var data = {
            name : guid
        };
        type = 'GET';
        load(url, data, type, function (data) {
            // $('.loading').hide();
            $('#con-modal').modal('show');
            $('#cancel').addClass("hidden");
            $('#post').addClass("hidden");
            $('.check_pass').removeClass("hidden").addClass("btn-success").data('name',guid);
            $('.check_fail').removeClass("hidden").data('name',guid);
            $('#close').removeClass("hidden");
            if (data) {
                if (data.StatusCode == 200) {
                    $('#alert-info').hide();

                    //弹出审核编辑信息
                    $('#alert-form').show().html(checkDetailShow(data.ResultData));
                } else {
                    $('#alert-form').hide();
                    $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
                }
            } else {
                $('#alert-form').hide();
                $('#alert-info').html('<p>未知的错误</p>');
            }
        });

    });


    $('.check_memeber').off("click").click(function () {

        window.item = $(this).parent().siblings("td").first().text();

        var guid = $(this).data('name');
        url = 'user_role/create';
        var data = {
            name : guid
        };
        type = 'GET';
        load(url, data, type, function (data) {
            // $('.loading').hide();
            $('#con-modal').modal('show');
            $('#cancel').addClass("hidden");
            $('#post').addClass("hidden");
            $('.check_pass').removeClass("hidden").addClass("btn-success").data('name',guid);
            $('.change_memeber_false').removeClass("hidden").data('name',guid);
            $('.check_fail').addClass("hidden");
            $('#close').removeClass("hidden");
            if (data) {
                if (data.StatusCode == 200) {
                    $('#alert-info').hide();

                    //弹出审核编辑信息
                    $('#alert-form').show().html(checkDetailShow(data.ResultData));
                } else {
                    $('#alert-form').hide();
                    $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
                }
            } else {
                $('#alert-form').hide();
                $('#alert-info').html('<p>未知的错误</p>');
            }
        });
    });
}



// 事件 提交修改
function submitData() {
    $('#post').off("click").click(function () {
        var data = {
            realname : $('#realname').val(),
            nickname : $('#nickname').val(),
            sex       : $('#sex').val(),
            birthday : $('#birthday').val(),
            tel       : $('#tel').val(),
            email     : $('#email').val()
            // role      : '1'
            // id        : $('#guid').text()
        };
        url = '/user/' + window.modify_guid;
        type = 'PUT';
        load(url, data, type, function (data) {
            // $('.loading').hide();
            $('#con-modal').modal('show');
            $('#cancel').addClass("hidden");
            $('#post').addClass("hidden");
            $('#close').removeClass("hidden");
            if (data) {
                if (data.StatusCode == 200) {
                    $('#alert-form').hide();
                    $('#alert-info').show().html('<p>数据修改成功!</p>');
                    listUserOneShow(data);
                } else {
                    $('#alert-form').hide();
                    $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
                }
            } else {
                $('#alert-form').hide();
                $('#alert-info').show().html('<p>未知的错误</p>');
            }
        });
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
    if(object.hasClass('change_memeber_false')) return number = 7;
    if(object.hasClass('change_memeber_true')) return number = 8;
    if(object.hasClass('change_memeber_lock')) return number = 9;
    if(object.hasClass('change_memeber_delete')) return number = 10;
    return false;
}

//事件 更改 禁用|激活 通过|不通过 删除
function changeSomeStatus(){


    $('.user_unlock, .user_lock, .user_delete, .user_un_delete, .check_pass , .check_fail, .check_delete, .change_memeber_false, .change_memeber_true, .change_memeber_lock, .change_memeber_delete').off('click').on('click', function () {
     
        //获得number
        // getNumber($(this));
        //初始化全局变量
        guid = $(this).data('name');

        var url_1 = '/user/' + $(this).data('name');
        var url_2 = '/user_role/' + $(this).data('name');

        if(number == 0 || number == 1 || number == 2 || number == 3){
            window.item = $(this).parent().siblings("td").first().text();
            load(url_1, numberData(getNumber($(this))), 'put', checkResponseStatus);
        }

        if(number == 5){
            load(url_2, numberData(getNumber($(this))), 'put', checkResponseStatus);
        }
        if(number == 6){
            window.item = $(this).parent().siblings("td").first().text();
            load(url_2, numberData(getNumber($(this))), 'put', checkResponseStatus);
        }

        // 英雄会会员
        // 不通过
        if(number == 7){
            window.item = $(this).parent().siblings("td").first().text();
            load(url_2, numberData(getNumber($(this))), 'put', checkResponseStatus);
        }

        if(number == 8){
            window.item = $(this).parent().siblings("td").first().text();
            load(url_2, numberData(getNumber($(this))), 'put', checkResponseStatus);
        }

        if(number == 9){
            window.item = $(this).parent().siblings("td").first().text();
            load(url_2, numberData(getNumber($(this))), 'put', checkResponseStatus);
        }

        if(number == 10){
            window.item = $(this).parent().siblings("td").first().text();
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
        if (data.StatusCode == 300)
            $('#data').html('<p style="padding:20px;" class="text-center"> 没有数据，请添加！</p>');
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
                window.pagenum = $('.gradeX').length;

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
    $('#post').addClass("hidden");
    $('#cancel').addClass("hidden");
    $('.check_pass').addClass("hidden");
    $('.check_fail').addClass("hidden");
    $('.change_memeber_false').addClass("hidden");

    if (data) {
        if(data.StatusCode == 300){
            $('#alert-form').hide();
            $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
            // return false;
        }
        if (data.StatusCode == 200) {
            $('#alert-form').hide();
            $('#alert-info').show().html('<p>数据修改成功!</p>');
            $(".gradeX").eq(window.item - 1).empty();

            // 页面数据条数为零则刷新
            window.pagenum -= 1;
            if(window.pagenum == 0){
                var t=setTimeout(function () {
                    //依据当前页面代号获取查询条件
                    data = roleData(user);
                    //获取查询分页数
                    if(totalpage - nowpage == 0)
                        data.nowPage = (nowpage == 1) ? nowpage : (nowpage - 1);
                    else{
                        data.nowPage = nowpage;
                    }

                    if(data.role == 1 || data.role == 2 || data.role == 3)
                        load('/user/create', data, 'GET', function (data) {
                            checkResponse(data, handle, listUserShow);
                        });
                    if(data.role == 4 || data.role == 5)
                        load('/user_role/create', data, 'GET', function (data) {
                            checkResponse(data, handle, listRoleShow);
                        });
                },1000);
            }
        } else{
            $('#alert-form').hide();
            $('#alert-info').show().html('<p>' + data.ResultData + '</p>');
            // return false;
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').show().html('<p>未知的错误</p>');
        // return false;
    }
}