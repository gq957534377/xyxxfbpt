//活动状态选择
$('.status1').off('click').on('click', function () {
    $('.status1').removeClass('btn-success').addClass('btn-default');
    $(this).addClass('btn-success');
    listType($(this).data('status'));
    var status = $(this).data('status');
    switch (status)
    {
        case 1:
            $('.avatar-scale').val('1');
            break;
        case 2:
            $('.avatar-scale').val(224/153);
            $('.organiz-type').val(status);
            $('.info > h4').html('添加合作机构');
            break;
        case 3:
            $('.avatar-scale').val(224/153);
            $('.organiz-type').val(status);
            $('.info > h4').html('添加投资机构');
            break;
        case 4:
            $('.avatar-scale').val(192/60);
            $('.organiz-type').val(status);
            $('.info > h4').html('添加轮播图');
            break;

    }
});

$(function () {
    listType(1);
});
var width  = $(window).width() / 2;
var height = $(window).height() / 2 - 70;

function ajaxBeforeModel() {
    $('.loading').show().css({
        'left': width,
        'top': height
    });
}
/**
 * 加载指定类型的数据
 * @author 王通
 **/
function listType(type) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "get",
        url: '/web_admins/create',
        data: {
            'type': type,
        },
        before  : ajaxBeforeModel(),
        success:function(data){

            if (data.StatusCode == '200') {

                switch (type)
                {
                    case 1:

                        contentHtml(data.ResultData);
                        $('.add-picture').hide();
                        break;
                    case 2:

                        institutionHtml(data.ResultData);
                        $('.text-coutent').show();
                        $('.add-picture').show();
                        break;
                    case 3:

                        institutionHtml(data.ResultData);
                        $('.text-coutent').show();
                        $('.add-picture').show();
                        break;
                    case 4:
                        carouselHtml(data.ResultData);
                        $('.add-picture').show();
                        $('.text-coutent').hide();
                        break;

                }

            } else {
                switch (type)
                {
                    case 1:
                        contentHtml([]);
                        $('.add-picture').hide();
                        break;
                    case 2:

                        institutionHtml([]);
                        $('.text-coutent').show();
                        $('.add-picture').show();
                        break;
                    case 3:

                        institutionHtml([]);
                        $('.text-coutent').show();
                        $('.add-picture').show();
                        break;
                    case 4:
                        carouselHtml([]);
                        $('.add-picture').show();
                        $('.text-coutent').hide();
                        break;

                }
                swal(data.ResultData);
            }
            $('.loading').hide();
        }
    });

}
/**
 * 拼接html字符串
 * @param data
 */
function institutionHtml(data) {
    html = '';
    $.each(data, function (key, value) {
        html += '<div class="col-sm-6">';
        html += '<div class="panel">';
        html += '<div class="panel-body">';
        html += '<div class="media-main">';
        html += '<a id="img'+ value.id +'" class="pull-left" href="'+ value.pointurl +'" target="_blank">';
        html += '<img  class="thumb-lg bx-s" src="'+ value.url +'" alt="" style="width: 146%;">';
        html += '</a>';
        html += '<div class="pull-right btn-group-sm">';
        // html += '<a data-id="'+ value.id +'" href="" class="btn btn-success tooltips" data-placement="Top" data-toggle="modal" data-target="#custom-width-modal" data-original-title="Edit">';
        // html += '<i class="fa fa-pencil"></i>';
        // html += '</a>';
        // html += '<a id="'+ value.id +'"  class="btn btn-danger tooltips" data-placement="Top" data-toggle="tooltip" data-original-title="Delete">';
        // html += '<i class="fa fa-close"></i>';
        // html += '</a>';
        html +=  '<button class="btn btn-success btn-xs" data-id="'+ value.id +'" style="border-radius:7px;" data-toggle="modal" data-target="#custom-width-modal">编辑</button> ';
        html +=  '<button id="'+ value.id +'" data-ip="" style="border-radius:7px;" data-count="organization" class="btn btn-danger btn-xs">删除</button>';
        html += '</div>';
        html += '<div class="info text-center">';
        html += '<h4 id="name'+ value.id +'">'+ value.name +'</h4>';

        html += '</div>';

        html += '</div>';
        html += '<div class="clearfix"></div>';
        html += '</div> <!-- panel-body -->';
        html += '</div> <!-- panel -->';
        html += '</div> <!-- end col -->';
    });
    $('#data').html(html);
    $('#headpic').attr('src', '/admin/images/jiahao.jpg');

}

function carouselHtml (data) {

    html = '';
    $.each(data, function (key, value) {

        html += '<div class="row">';
        html += '<div class="col-sm-10">';
        html += '<div class="panel">';
        html += '<div class="panel-body">';
        html += '<div class="media-main">';
        html += '<a class="pull-left" href="#">';
        html += '<img class="thumb-lg bx-s" src="'+ value.url +'" alt="" style="width: 250%;">';
        html += '</a>';
        html += '<div class="pull-right btn-group-sm">';
//                html += '<a href="" class="btn btn-success tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit">';
//                html += '<i class="fa fa-pencil"></i>';
//                html += '</a>';
//         html += '<a id="'+ value.id +'"  class="btn btn-danger tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Delete">';
        html +=  '<button id="'+ value.id +'" data-ip="" style="border-radius:7px;" data-count="rolling" class="btn btn-danger btn-xs">删除</button>';
        // html += '<i class="fa fa-close"></i>';
        // html += '</a>';
        html += '</div>';

        html += '</div>';
        html += '<div class="clearfix"></div>';
        html += '</div> <!-- panel-body -->';
        html += '</div> <!-- panel -->';
        html += '</div> <!-- end col -->';
        html += '</div> <!-- end row -->';
    });
    $('#data').html(html);
    $('#headpic').attr('src', '/admin/images/jiahao.jpg');


}
/**
 * 拼接html字符串
 * @param data
 */
function contentHtml(data) {

    html = '';
    html += '<div class="row">';
    html += '<div class="col-sm-11">';
    html += '<div class="panel panel-default">';
    html += '<div class="panel-heading"><h3 class="panel-title">文字管理</h3></div>';
    html += '<div class="panel-body">';
    html += '<div class=" form p-20">';
    html += '<form class="cmxform form-horizontal tasi-form" id="textfrom">';
    html += '<div class="form-group ">';
    html += '<label for="cemail" class="control-label col-lg-2">客服电话：</label>';
    html += '<div class="col-lg-8">';
    html += '<input class="form-control " id="tel" type="text" name="tel" required="" aria-required="true" value="' + data.tel  + '">';
    html += '</div>';
    html += '</div>';
    html += ' <div class="form-group ">';
    html += '<label for="cemail" class="control-label col-lg-2">客服邮箱：</label>';
    html += '<div class="col-lg-8">';
    html += '<input class="form-control " id="cemail" type="email" name="email" required="" aria-required="true" value="' + data.email + '">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group ">';
    html += '<label for="cemail" class="control-label col-lg-2">工作时间：</label>';
    html += '<div class="col-lg-8">';
    html += '<input class="form-control " id="time" type="text" name="time" required="" aria-required="true" value="' + data.time + '" >';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group ">';
    html += '<label for="curl" class="control-label col-lg-2">备案内容：</label>';
    html += '<div class="col-lg-8">';
    html += '<input class="form-control " id="record" type="text" name="record" value="' + data.record + '">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group">';
    html += '<div class="col-lg-offset-2 col-lg-10">';
    html += '<button id="text-content-submit" class="btn btn-success" style="border-radius:7px;" type="button">保存</button>';
    html += '</div>';
    html += '</div>';
    html += '</form>';
    html += '</div> ';
    html += '</div> ';
    html += '</div> ';
    html += '</div> ';
    html += '</div> ';

    $('#data').html(html);
}

// 提交文本内容
$('#data').on('click', '#text-content-submit', function(){
    // 异步更新
    $.ajax({
        type: "POST",
        url: '/web_admins',
        data: {
            'email' : $('#cemail').val(),
            'tel' : $('#tel').val(),
            'time' : $('#time').val(),
            'record' : $('#record').val(),
            '_token' : $('meta[name="csrf-token"]').attr('content')
        },
        before  : ajaxBeforeModel(),
        success:function(data){
            if (data.StatusCode == '200') {
                listType(1);
                swal("更新成功!");
            } else {
                swal('失败：' + data.ResultData);
            }
            $('.loading').hide();
        }
    });
});
function addHtml() {
    var html = '';
    html += '<div class="col-sm-10">';
    html += '<div class="panel">';
    html += '<div class="panel-body">';
    html += '<div class="media-main">';
    html += '<a class="pull-left" href="#">';


    html += '</a>';
    html += '</div>';
    html += '<div class="info">';
    html += '<h4>添加合作机构</h4>';
    html += '<p class="text-muted">Graphics Designer</p>';
    html += '</div>';
    html += '<div class="clearfix"></div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

}

// 删除
$('#data').on('click', '.btn-danger' ,function () {
    var me = $(this);
    var type = me.data('count');
    swal({
        title: "确认删除吗?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "确认删除!",
        cancelButtonText: "取消",
        closeOnCancel: false
    },function(isConfirm) {
        if (isConfirm) {
            // 异步删除
            $.ajax({
                type: "POST",
                url: '/web_admins/'+ me.attr('id'),
                data: {
                    '_method': 'DELETE',
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'type' : type
                },
                before  : ajaxBeforeModel(),
                success:function(data){
                    if (data.StatusCode == 200) {
                        me.parent().parent().parent().parent().parent().remove();
                        swal("操作成功！");
                    } else {
                        swal(data.ResultData);
                    }
                    $('.loading').hide();
                }
            });

        } else {
            return;
        }
    });


});
var iName= '';
var iUrl= '';
// 编辑信息
$('#data').on('click', '.btn-success', function () {

    var me = $(this);
    var id = me.data('id');
    $('#investid').val(id);
    $('#investname').val($('#name' + id).html());
    $('#investurl').val($('#img' + id).attr('href'));
    iName = $('#name' + id).html();
    iUrl = $('#img' + id).attr('href');
});

// 提交修改信息 异步
$('#saveinfo').on('click', function () {
    var id = $('#investid').val();
    var name = $('#investname').val();
    var url = $('#investurl').val();
    if (iName == name && iUrl == url) {
        swal('未做修改');
        return;
    }
    // 异步修改
    $.ajax({
        type: "POST",
        url: '/web_admins/'+ id,
        data: {
            '_method': 'PUT',
            '_token' : $('meta[name="csrf-token"]').attr('content'),
            'name' : name,
            'url' : url
        },
        before  : ajaxBeforeModel(),
        success:function(data){
            swal(data.ResultData);
            updateHtml();
            $('.loading').hide();
        }
    });
});
// 更新HTML界面
function updateHtml() {
    var status = $('.page-title .btn-success').data('status');
    if (status == null || status == undefined) {
        listType(1);
    } else {
        listType(status);
    }
}
/**
 * Created by wangt on 2016/12/20.
 */
