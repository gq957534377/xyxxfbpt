/**
 * Created by wangt on 2016/12/7.
 */

// 轮播图
function carousel ()
{
    // 异步登录
    $.ajax({
        type: "GET",
        url: '/web_cooper_organiz/create',
        success:function(data){
            if (data.StatusCode == 200 ) {
                carouselHtml(data.ResultData);
            } else {
                alert(data.ResultData);
            }

        }
    });
}

function carouselHtml (data) {
    html = '';
    data.forEach(function (value) {
        html += '<div class="col-sm-6">';
        html += '<div class="panel">';
        html += '<div class="panel-body">';
        html += '<div class="media-main">';
        html += '<a id="img'+ value.id +'" class="pull-left" href="'+ value.pointurl +'">';
        html += '<img  class="thumb-lg bx-s" src="'+ value.url +'" alt="" style="width: 146%;">';
        html += '</a>';
        html += '<div class="pull-right btn-group-sm">';
        html += '<a data-id="'+ value.id +'" href="" class="btn btn-success tooltips" data-placement="top" data-toggle="modal" data-target="#custom-width-modal" data-original-title="Edit">';
        html += '<i class="fa fa-pencil"></i>';
        html += '</a>';
        html += '<a id="'+ value.id +'"  class="btn btn-danger tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Delete">';
        html += '<i class="fa fa-close"></i>';
        html += '</a>';
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
    $('#carousel').html(html);
    $('#headpic').attr('src', '/admin/images/jiahao.jpg');

}
$(document).ready(function(){
    carousel();
    // 删除
    $('#carousel').on('click', '.btn-danger' ,function () {
        if (!confirm('是否确认删除？')) {
            return ;
        }
        var me = $(this);
        // 异步删除
        $.ajax({
            type: "POST",
            url: '/picture/'+ me.attr('id'),
            data: {
                '_method': 'DELETE',
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){
                if (data.StatusCode == 200) {
                    me.parent().parent().parent().parent().parent().remove();
                } else {
                    alert(data.ResultData);
                }

            }
        });
    });

    // 编辑信息
    $('#carousel').on('click', '.btn-success', function () {
        //alert($(this).data('id'));
        var me = $(this);
        var id = me.data('id');
        $('#investid').val(id);
        $('#investname').val($('#name' + id).html());
        $('#investurl').val($('#img' + id).attr('href'));
    });

    // 提交修改信息
    $('#saveinfo').on('click', function () {
        var id = $('#investid').val();
        var name = $('#investname').val();
        var url = $('#investurl').val()

        // 异步修改
        $.ajax({
            type: "POST",
            url: '/picture/'+ id,
            data: {
                '_method': 'PUT',
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'name' : name,
                'url' : url
            },
            success:function(data){
                alert(data.ResultData);
                carousel();
            }
        });
    });
});