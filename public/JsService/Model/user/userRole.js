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
            $('.check_pass').click(function(){
                //判断是审核通过或者不通过
                var action = $(this).children().html();
                var guid = $('#guid').val();
                var role = $('#role').val();

                switch (action){
                    case '通过':
                        var status = 6;
                        break;
                    case '拒绝':
                        var status = 7;
                        break;
                    default:
                        break;
                }

                swal({
                    title: "确定要"+ action +"?",
                    text: "当前操作会"+ action +"用户角色申请!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: '',
                    cancelButtonText: "取消",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm){
                    if (isConfirm) {
                        //发送请求
                        $.ajax({
                            url :'/role_management/'+status+'/edit', //参数2 为禁用,1 为启用
                            type : 'get',
                            data : {
                                guid : guid,
                                role : role
                            },
                            success : function (msg) {
                                if(msg.statusCode == 400){
                                    swal(msg.resultData, action + '角色申请失败', "danger");
                                    $('#con123').modal('hide');
                                    $('#con12').modal('hide');
                                    return;
                                }

                                swal(msg.resultData, '角色申请 '+action + '', "success");
                                $('#con123').modal('hide');
                                $('#con12').modal('hide');
                                //成功后删除当前行
                                tr.remove();

                            }
                        });

                    } else {
                        swal("操作取消！", "你没有进行任何操作！", "error");
                        $('#con123').modal('hide');
                        $('#con12').modal('hide');
                        //delete(tr);

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
 *  审核操作
 *
 *
 */
var tr; //获取审核时对应tr标签节点，审核完成后 执行tr移除操作
function userCheck() {
    $('.user_check').click(function () {

        tr = $(this).parent().parent();
        var data = $(this).data();
        var time = new Date(data.addtime*1000);

        switch (data.role){
            case 2:
                $('#guid').val(data.guid);
                $('#role').val(data.role);
                $('#realname1').text(data.realname);
                $('#pic_a').attr('src',data.card_pic_a);
                $('#pic_b').attr('src',data.card_pic_b);

                $('#education').text(data.education);

                $('#enrollment_year').text(data.enrollment_year);
                $('#graduation_year').text(data.graduation_year);

                $('#school_name').text(data.school_name);
                $('#major').text(data.major ? data.major : '--');
                $('#school_address').text(data.school_address ? data.school_address : '--');
                $('#addtime').text(time.getFullYear() +'-'+ time.getMonth() + 1 +'-' +time.getDate()+ ' ' +time.getHours()+':'+time.getMinutes() + ':' + time.getSeconds());
                break;
            case 3:
                $('#guid').val(data.guid);
                $('#role').val(data.role);
                $('#realname2').text(data.realname);
                $('#pic_aa').attr('src',data.card_pic_a);
                $('#work_year').text(data.work_year);
                $('#scale').text(data.scale+'万');
                $('#company').text(data.company);
                $('#company_address').text(data.company_address);
                $('#field').text(data.field);
                $('#work_year').text(data.work_year);
                $('#addtime1').text(time.getFullYear() +'-'+ time.getMonth() + 1 +'-' +time.getDate()+ ' ' +time.getHours()+':'+time.getMinutes() + ':' + time.getSeconds());
                break;



        }


        //$('#introduction').text(data.introduction ? data.introduction : '--');


        //角色身份选择
        switch (data.role){
            case 4 :
                var str = '<strong>身份 ：</strong><span class="text-info text-xs">申请英雄会会员&nbsp;</span>';
                break;
            case 2 :
                var str = '<strong>身份 ：</strong><span class="text-warning text-xs">申请创业者&nbsp;</span>';
                break;
            case 3 :
                var str = '<strong>身份 ：</strong><span class="text-success text-xs">申请投资者&nbsp;</span>';
                break;
        }
        //会员身份选择



        $('#role').html(str);

        //状态匹配
        switch (data.status){
            case 5:
                var status = '<strong>当前状态 ：</strong><span class="text-primary text-xs">待审核&nbsp;</span>';
                break;
            case 7:
                var status = '<strong>当前状态 ：</strong><span class="text-danger text-xs">审核未通过&nbsp;</span>';

        }
        $('#status').html(status);

        switch (data.role){
            case 2:
                $('#con123').modal('show');
                break;
            case 3:
                $('#con12').modal('show');
                break;
        }

        //$('.modal-content').html(guid);
    });
}
/**
 *查看用户详情
 *
 *
 *
 * */


//页面默认加载所有可用用户信息
$(function () {
    $('#user_title').html('<h3>待审核创业者</h3>');
    var key = 0;   //默认请求所有待审核用户

    var url = '/role_management/show';

    //初始化请求参数
    var queryString = {
        key : key
    };

    //执行ajax请求
    execAjax( url, queryString, 'get');
});

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
    var url = '/role_management/show';  //请求url

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
            pages();
            //listenChange();
            initAlert();
            userCheck();        //监听审核



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
        '<thead>';
    switch(data[0].role){
        case 2: //创业者列表
            str +=  '<tr>' +
                '<th class ="text-center">姓名</th>' +
                '<th class ="text-center">类型</th>' +
                '<th class ="text-center">学校</th>' +
                '<th class ="text-center">学历</th>' +
                '<th class ="text-center">专业</th>' +
                '<th class ="text-center">申请时间</th>' +
                '<th class ="text-center">用户状态</th>' +
                '<th class ="text-center">操作</th>' +
                '</tr>' +
                '</thead>'+
                '<tbody>';
            break;
        case 3: //投资者列表
            str +=  '<tr>' +
                '<th class ="text-center">姓名</th>' +
                '<th class ="text-center">类型</th>' +
                '<th class ="text-center">工作年限</th>' +
                '<th class ="text-center">投资规模</th>' +
                '<th class ="text-center">公司</th>' +
                '<th class ="text-center">申请时间</th>' +
                '<th class ="text-center">用户状态</th>' +
                '<th class ="text-center">操作</th>' +
                '</tr>' +
                '</thead>'+
                '<tbody>';
            break;
        case 4: //英雄会员列表
            str +=  '<tr>' +
                '<th class ="text-center"></th>' +
                '<th class ="text-center"></th>' +
                '<th class ="text-center"></th>' +
                '<th class ="text-center"></th>' +
                '<th class ="text-center"></th>' +
                '<th class ="text-center"></th>' +
                '<th class ="text-center"></th>' +
                '<th class ="text-center"></th>' +
                '</tr>' +
                '</thead>'+
                '<tbody>';
            break;

    }


    //

    $.each(data, function (i, v) {
        var time = new Date(v.addtime*1000);

        str += '<tr class="gradeX">';
        str +=  '<td>' + v.realname + '</td>';

        switch (v.role){
            case 2:
                str +=  '<td>';
                str +=  '<span class="text-warning text-xs">创业者&nbsp;</span>';
                str += '</td>';
                str += '<td>';
                str += v.school_name;
                str += '</td>';
                str +=  '<td>';
                str += v.education;
                str += '</td>';
                str +=  '<td>';
                str += v.major;
                str += '</td>';
                str +=  '<td>';
                str += time.getFullYear() +'-'+ time.getMonth() + 1 +'-' +time.getDate()+ ' ' +time.getHours()+':'+time.getMinutes() + ':' + time.getSeconds();
                str += '</td>';
                switch (v.status){
                    case 5:
                        str +=  '<td>';
                        str += '<span class="text-danger text-xs">待审核&nbsp; </span><span class="text-info text-xs">创业者</span>';
                        str +=  '</td>';
                        break;
                    case 7:
                        str +=  '<td>';
                        str += '<span class="text-danger text-xs">未通过&nbsp; </span><span class="text-info text-xs">创业者</span>';
                        str +=  '</td>';
                        break;


                }
                break;

            case 3:
                str +=  '<td>';
                str += '<span class="text-success text-xs">投资者&nbsp;</span>';
                str += '</td>';
                str += '<td>';
                str += v.work_year;
                str += '</td>';
                str +=  '<td>';
                str += v.scale + '万';
                str += '</td>';
                str +=  '<td>';
                str += v.company;
                str += '</td>';
                str +=  '<td>';
                str += time.getFullYear() +'-'+ time.getMonth() + 1 +'-' +time.getDate()+ ' ' +time.getHours()+':'+time.getMinutes() + ':' + time.getSeconds();
                str += '</td>';
                switch (v.status){
                    case 5:
                        str +=  '<td>';
                        str += '<span class="text-danger text-xs">待审核&nbsp;</span><span class="text-success text-xs">投资者</span>';
                        str +=  '</td>';
                        break;
                    case 7:
                        str +=  '<td>';
                        str += '<span class="text-danger text-xs">未通过&nbsp;</span><span class="text-success text-xs">投资者</span>';
                        str +=  '</td>';
                        break;
                }
                break;

            case 4:
                str +=  '<td>';
                str += '<span class="text-danger text-xs">英雄会员&nbsp;</span>';
                str += '</td>';
                str += '<td>';
                str += v.school_name;
                str += '</td>';
                str +=  '<td>';
                str += v.education;
                str += '</td>';
                str +=  '<td>';
                str += v.major;
                str += '</td>';
                str +=  '<td>';
                str += time.getFullYear() +'-'+ time.getMonth() + 1 +'-' +time.getDate()+ ' ' +time.getHours()+':'+time.getMinutes() + ':' + time.getSeconds();
                str += '</td>';
                switch (v.status){
                    case 5:
                        str +=  '<td>';
                        str += '<span class="text-danger text-xs">待审核&nbsp;</span><span class="text-warning text-xs">英雄会员</span>';
                        str +=  '</td>';
                        break;
                    case 7:
                        str +=  '<td>';
                        str += '<span class="text-danger text-xs">未通过&nbsp;</span><span class="text-warning text-xs">英雄会员</span>';
                        str +=  '</td>';
                        break;
                }
        }


        if(v.status == 5 || v.status == 7){
            str += '<td>';
            str +=  '<a href="javascript:;" data-guid="' + v.guid + '" data-role="'+v.role+'" data-realname="'+ v.realname +
                '" data-card_pic_a="'+v.card_pic_a+'" data-card_pic_b="'+v.card_pic_b+'" data-school_address="'+v.school_address+ '" data-school_name="'+v.school_name+
                '" data-enrollment_year="'+v.enrollment_year+'" data-graduation_year="'+v.graduation_year+'" data-education="'+v.education+
                '" data-major="'+v.major+'" data-work_year="'+v.work_year+'" data-scale="'+v.scale+'" data-company="'+v.company+ '"  data-company_address="'+v.company_address+
                '" data-field="'+v.field+'"  data-addtime="'+v.addtime+'" data-status="'+v.status+'" data-reason="'+ v.reason+
                '" class="user_check"><button class="btn btn-info btn-xs">审核</button></a>';
        }


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

/**
 *
 *
 *
 *
 * */