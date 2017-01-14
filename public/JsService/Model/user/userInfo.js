
//页面默认加载所有可用用户信息
$(function () {
    $('#user_title').html('<h3>所有用户</h3>');
    var key = 0;

    var url = '/user_management/show';

    //初始化请求参数
    var queryString = {
        key : key
    };

    //执行ajax请求
    execAjax( url, queryString, 'get');
});

/**************************************************************************************************/
/** 弹出确认框
 * Theme: Velonic Admin Template
 * Author: Coderthemes
 * SweetAlert -
 * Usage: $.SweetAlert.methodname
 */

function initAlert() {
    !function($) {
        "use strict";

        var SweetAlert = function() {};

        //examples
        SweetAlert.prototype.init = function() {

            //禁用弹出确认框
            $('.user_change').click(function(){
                var guid = $(this).data('name');
                var id = $(this).data('id');

                //获取tr节点
                var tr = $(this).parent().parent();
                if(id == 2){
                    var status = '禁用';
                }else{
                    var status = '启用';
                }

                swal({
                    title: "确定要"+status+"?",
                    text: "当前操作会"+status+"用户的所有功能!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: status,
                    cancelButtonText: "取消",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm){
                    if (isConfirm) {
                        $('.confirm').prop('disabled','disabled');
                        //发送请求
                        $.ajax({
                            url :'/user_management/'+id+'/edit', //参数2 为禁用,1 为启用
                            type : 'get',
                            data : {guid : guid},
                            success : function (msg) {
                                if(msg.statusCode == 400){
                                    swal(msg.resultData, '执行' + status + '失败', "danger");
                                    return;
                                }
                                swal(msg.resultData, '该用户已被成功'+status, "success");
                                //成功后删除当前行
                                tr.remove();
                                $('.confirm').prop('disabled','');

                            }
                        });

                    } else {
                        swal("已取消！", "没有做任何修改！", "error");
                    }
                });
            });
        },
            //init
            $.SweetAlert = new SweetAlert,
            $.SweetAlert.Constructor = SweetAlert
    }(window.jQuery),

//initializing
        function($) {
            "use strict";
            $.SweetAlert.init()
        }(window.jQuery);
}


/********************************************************************************************/

/**
 *修改用户信息
 *
 *
 *
 * */
function userChange() {
    $('.user_modify').click(function () {
        var guid = $(this).data('name');
        if(1){
            $('#user-change').modal('show');
            //$('.modal-body').html('操作成功！');
        }

    });
}

/**
 * 查看用户详情
 *
 *
 * */
function userInfo() {
    $('.user_info').click(function () {

        var data = $(this).data();
        var time = new Date(data.addtime*1000);
        //alert(realname);
        $('#headpic').attr('src',data.headpic);
        $('#realname').text(data.realname ? data.realname : ' - - ');
        $('#nickname').text(data.nickname);
        $('#phone').text(data.tel);
        $('#email').text(data.email ? data.email : ' - - ');
        $('#addtime').text(time.getFullYear() +'-'+ time.getMonth() + 1 +'-' +time.getDate()+ ' ' +time.getHours()+':'+time.getMinutes() + ':' + time.getSeconds());
        //角色身份选择
        switch (data.role){
            case 1 :
                var str = '<strong>身份 ：</strong><span class="text-info text-xs">普通用户&nbsp;</span>';
                break;
            case 2 :
                var str = '<strong>身份 ：</strong><span class="text-warning text-xs">创业者&nbsp;</span>';
                break;
            case 3 :
                var str = '<strong>身份 ：</strong><span class="text-success text-xs">投资者&nbsp;</span>';
                break;
            case 23 :
                var str = '<strong>身份 ：</strong><span class="text-warning text-xs">创业者&nbsp;</span><span class="text-success text-xs">投资者</span>';
                break;
        }
        //会员身份选择
        switch(data.memeber){
            case 2:
                var member = '<span class="text-danger text-xs">英雄会员&nbsp;</span>';
                break;
            default:
                var member = '';
        }


        $('#role').html(str + member);

        //状态匹配
        switch (data.status){
            case 1:
                var status = '<strong>当前状态 ：</strong><span class="text-primary text-xs">正常使用中&nbsp;</span>';
                break;
            default:
                var status = '<strong>当前状态 ：</strong><span class="text-danger text-xs">禁用中&nbsp;</span>';
        }
        $('#status').html(status);
        $('#introduction').text(data.introduction ? data.introduction : '');
        $('#').text();

        $('#user-info').modal('show');

    });
}

/**
 *  获取不同类型用户的列表点击事件
 *
 * @return  mixed   用户的列表
 * */
$('.user_role_list').click(function(){
    //用户列表title
    var title = $(this).attr('title');
    var key = $(this).attr('key');

    $('#user_title').html('<h3>' + title + '</h3>');

    //获取参数
    var url = '/user_management/show';  //请求url

    //初始化请求参数
    var queryString = {
        key : key
    };

    //执行ajax请求
    execAjax( url, queryString, 'get');
});

/**
 * 点击分页列表获取点击页用户信息
 *
 */
function pages() {
    $('.pagination li').click(function () {
        var class_name = $(this).prop('class');
        if(class_name == 'disabled' || class_name == 'active') {
            return false;
        }
        var url = $(this).children().prop('href');

        //初始化请求参数
        var queryString = {};

        //执行ajax请求
        execAjax( url, queryString, 'get');
        return false;

    });
}



/** ajax请求，通过参数返回不同类型用户的列表
 *
 * @param   var url           string    请求url
 * @param   var querystring   json      请求参数，需要提前拼装为json格式
 * @param   var type          string    请求类型（get or post ...）
 *
 * @return  msg              json      接口响应的json格式数据 msg.ResultData[1] 用户列表，msg.ResultData[0] 分页信息。
 * */
function execAjax( url, queryString, type) {
    //如果为非GET请求  携带 csrf _token 做请求验证
    if(type == 'post' || type == 'put' || type == 'delete'){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
    //ajax请求
    $.ajax({
        url : url,
        type : type,
        data : queryString,
        success : function(msg){
            //没有该类型用户数据返回提示
            if (msg.StatusCode == 400) return $('#data').html('暂无数据');
            //alert(msg.ResultData);
            //有数据，遍历数据进行DOM操作
            $('#data').html(htmlStr(msg.ResultData[1]));
            $('#page').html(msg.ResultData[0]);
            pages();    //分页事件触发
            userChange(); //调用修改弹出框
            initAlert();    //调用确认弹出框
            userInfo();     //用户详情


        }
    })
}

/**
 *  HtmlStr() 用户列表标签拼装
 *
 * @param var data      json        ajax请求返回的json格式数组
 *
 * @return var str      string      返回拼装遍历好的html标签
 * */
function htmlStr( data) {
    //初始化变量
    var str = '';

    //公共表格头
    str +=  '<div class="panel-body">' +
        '<table class="table table-bordered table-striped">' +
        '<thead>' +
        '<tr>' +
        '<th class ="text-center">昵称</th>' +
        '<th class ="text-center">类型</th>' +
        '<th class ="text-center">姓名</th>' +
        '<th class ="text-center">手机</th>' +
        '<th class ="text-center">邮箱</th>' +
        '<th class ="text-center">用户状态</th>' +
        '<th class ="text-center">操作</th>' +
        '</tr>' +
        '</thead>'+
        '<tbody>';

    //

    $.each(data, function (i, v) {

        str += '<tr class="gradeX">';
        str +=  '<td>' + v.nickname + '</td>';
        str +=  '<td>';
        if(v.role == 1){
            str +=  '<span class="text-info text-xs">普通用户&nbsp;</span>';
        }
        if(v.role == 2){
            str +=  '<span class="text-warning text-xs">创业者&nbsp;</span>';
        }
        if(v.role == 3){
            str += '<span class="text-success text-xs">投资者&nbsp;</span>';
        }
        if(v.role == 23){
            str +=  '<span class="text-warning text-xs">创业者&nbsp;</span><span class="text-success text-xs">投资者&nbsp;</span>';
        }
        if(v.memeber == 2){
            str += '<span class="text-danger text-xs">英雄会员&nbsp;</span>';
        }
        str += '</td>';

        str += '<td>';
        str += v.realname ? v.realname : '--';
        str += '</td>';
        str +=  '<td>' + v.tel + '</td>';
        str +=  '<td>';
        str += v.email ? v.email : '--';
        str += '</td>';
        str +=  '<td>';

        if(v.status == 1){
            str +=  '<a href="javascript:;" data-name="' + v.guid + '" data-id="2" class="user_change"><button class="btn btn-danger btn-xs" id = "sa-warning" style="border-radius:6px">禁用</button></a>';
        }
        if(v.status == 2){
            str +=  '<a href="javascript:;" data-name="' + v.guid + '" data-id="1" class="user_change"><button class="btn btn-success btn-xs">启用</button></a>';
        }
        str +=  '</td>';
        str +=  '<td>';
        str +=  '<a href="javascript:;" data-name="' + v.guid + '" class="user_modify"><button class="btn btn-info btn-xs">修改</button></a>&nbsp;';
        str +=  '<a href="javascript:;" data-nickname="' + v.nickname + '" data-realname="'+ v.realname +'" data-role ="'+v.role+
            '"  data-tel ="'+v.tel+'" data-email="'+v.email+
            '" data-headpic="'+v.headpic+'"   data-memeber="'+v.memeber+'" data-addtime="'+v.addtime+'" data-status="'+v.status+
            '" class="user_info"><button class="btn btn-warning btn-xs">详情</button></a>';

        str +=  '</td></tr>';
    });
    str += '</tbody>' +
        '</table>' +
        '</div>' +
        '<div class="row">' +
        '<div class="col-sm-8"></div>' +
        '<div class="col-sm-4" id="page"></div>' +
        '</div>';
    return str;
}



