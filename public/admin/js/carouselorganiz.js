/**
 * Created by wangt on 2016/12/7.
 */

// 轮播图
function carousel ()
{
    // 异步登录
    $.ajax({
        type: "GET",
        url: '/picture/carouselajax',
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
        html += '<div class="row">';
        html += '<div class="col-sm-10">';
        html += '<div class="panel">';
        html += '<div class="panel-body">';
        html += '<div class="media-main">';
        html += '<a class="pull-left" href="#">';
        html += '<img class="thumb-lg bx-s" src="'+ value.url +'" alt="" style="width: 250%;">';
        html += '</a>';
        html += '<div class="pull-right btn-group-sm">';
        html += '<a href="#" class="btn btn-success tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit">';
        html += '<i class="fa fa-pencil"></i>';
        html += '</a>';
        html += '<a id="'+ value.id +'" href="#" class="btn btn-danger tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Delete">';
        html += '<i class="fa fa-close"></i>';
        html += '</a>';
        html += '</div>';

        html += '</div>';
        html += '<div class="clearfix"></div>';
        html += '</div> <!-- panel-body -->';
        html += '</div> <!-- panel -->';
        html += '</div> <!-- end col -->';
        html += '</div> <!-- end row -->';
    });
    $('#carousel').html(html);
    $('#headpic').attr('src', '/admin/images/jiahao.jpg');


}
$(document).ready(function(){
    carousel();
    $('.panel-body').on('click', '.btn-danger' ,function () {
        alert('nihao');
    })
});