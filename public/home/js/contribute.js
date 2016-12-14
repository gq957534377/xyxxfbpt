/**
 * Created by wangt on 2016/12/13.
 */
$('#contribute').on('click', function () {
    var html = '<div>';
    html += '<span class="contribute-title">投稿</span>';
    html += '<form class="form-horizontal form-contribute" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">';
    html += '<div class="form-group mar-b30">';
    html += '<label for="form-title" class="col-md-2 control-label"><span class="form-star">*</span>标题</label>';
    html += '<div class="col-md-10">';
    html += '<input autofocus type="text" class="form-control form-title" id="form-title" placeholder="">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group mar-b30">';
    html += '<label for="form-introduction" class="col-md-2 control-label"><span class="form-star">*</span>导语</label>';
    html += '<div class="col-md-10">';
    html += '<textarea class="form-control form-introduction" id="form-introduction" placeholder=""></textarea>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group mar-b30">';
    html += '<label for="form-content" class="col-md-2 control-label"><span class="form-star">*</span>内容</label>';
    html += '<div class="col-md-10">';
    html += '<textarea class="form-control form-content ht-16" id="form-content" placeholder="需要引入富文本编辑器,实现如下效果"></textarea>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group mar-cb">';
    html += '<label for="author-name" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>作者姓名</label>';
    html += '<div class="col-md-4 mar-b30">';
    html += '<input type="text" class="form-control" id="author-name" placeholder="">';
    html += '</div>';
    html += '<label for="form-source" class="col-md-2 control-label"><span class="form-star">*</span>来源</label>';
    html += '<div class="col-md-4 mar-b30">';
    html += '<input type="text" class="form-control" id="form-source" placeholder="">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group mar-b30">';
    html += '<label for="author-tel" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>联系电话</label>';
    html += '<div class="col-md-4">';
    html += '<input type="text" class="form-control" id="author-tel" placeholder="">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group mar-b30">';
    html += '<label for="auth-code" class="col-md-2 control-label pad-cr"><span class="form-star">*</span>验证码</label>';
    html += '<div class="col-md-8 pad-clr">';
    html += '<div class="col-xs-5 col-sm-8 col-md-6">';
    html += '<input class="form-control" type="text" id="auth-code" placeholder="">';
    html += '</div>';
    html += '<div class="col-xs-6 col-sm-4 col-md-4">';
    html += '<img id="captcha" src="../img/demoimg/code-auth.jpg">';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group">';
    html += '<!--col-sm-offset-2-->';
    html += '<div class="col-xs-4 col-sm-3 col-md-offset-2 col-md-2">';
    html += '<button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">提交审核</button>';
    html += '</div>';
    html += '<div class="col-xs-4 col-sm-3 col-md-2">';
    html += '<button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">保存草稿</button>';
    html += '</div>';
    html += '<div class="col-xs-3 col-sm-2 col-md-2">';
    html += '<button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz">预览</button>';
    html += '</div>';
    html += '</div>';
    html += '</form>';
    html += '</div>';

    $('#contributeNav').html(html);
});
//  document.onselectstart = new Function("return false");
//     按钮状态
var status = 0;
//    全选 取消全选
function checkAllSwitch() {
    if (status == 0) {
        $('input[name="itemId"]').prop('checked', 'true');
        $('.checkbox-1').removeClass('opacity-0').addClass('opacity-1');
        $("#checkAll").html('取消全选');
        status = 1;
    } else {
        $('input[name="itemId"]').each(function(){
            this.checked = false;
        });
        $('.checkbox-1').removeClass('opacity-1').addClass('opacity-0');
        $("#checkAll").html('全选');
        status = 0;
    }
}
//  单个复选框操作
$(function () {
    getContributeList(1);
    var inputs = $("input[name='itemId']");
    var num = inputs.length;
    inputs.on('click', function(){
        var num_checked = $("input[name='itemId']:checked").length;
//      alert(num_checked);
        if (this.checked == true) {
            $(this).parent().removeClass('opacity-0').addClass('opacity-1');
            if (num == num_checked) {
                $("#checkAll").html('取消全选');
                status = 1;
            }
        } else {
            $(this).parent().removeClass('opacity-1').addClass('opacity-0');
            if (num != num_checked) {
                $("#checkAll").html('全选');
                status = 0;
            }
        }
    });
});



