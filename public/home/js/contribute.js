/**
 * Created by wangt on 2016/12/13.
 */
!function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples
    SweetAlert.prototype.init = function() {},
        //init
        $.SweetAlert = new SweetAlert,
        $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

    function($) {
        "use strict";
        $.SweetAlert.init()
    }(window.jQuery);
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
/**
 * 删除单条记录
 * @author 王通
 */
$('.bg-del').on('click', function () {
    me = $(this);
    deleteAjax ('DELETE', {'id' : [me.data('delete')]});
    // deleteAjax(me.data('delete'));
});


// 删除记录
$('#delete').on('click', function () {
    var num = $('.checkbox-contri').size();
    var guidArr = [];
    var k = 0;
    for (var i = 0; i < num; i++) {
        if ($('.checkbox-contri:eq('+i+')').is(':checked')) {
            guidArr[i] = $('.checkbox-contri:eq('+i+')').attr('id');
            guidArr[k++];
        };
    }
    deleteAjax ('DELETE', {'id' : guidArr});
});



/**
 * ajax请求，删除数据
 */
function deleteAjax(method, id)
{

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var data = {
        '_method': method,
        'id': id
    };
    $.ajax({
        type: 'POST',
        url: '/send/delete',
        data: data,
        success: function(msg){
            switch (msg.StatusCode){
                case '404':
                    $(".loading").hide();
                    swal(msg.ResultData);

                    break;
                case '400':
                    $(".loading").hide();
                    swal(msg.ResultData);
                    break;
                case '200':
                    console.log(id.id);
                    $(".loading").hide();
                    $.each(id.id, function (key, val) {
                        $('#' + val).parent().parent().parent().remove();
                    })

                    swal('删除成功');
                    break;
            }
        },
        error: function(XMLHttpRequest){
            var number = XMLHttpRequest.status;
            var msg = "Error: "+number+",数据异常！";
            swal(msg);
        }

    });
}

/**
 * 获取要操作的文章数组
 * @author 王通
 */

function getAllGuid()
{


}



