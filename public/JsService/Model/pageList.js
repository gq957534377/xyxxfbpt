
// 获取分页数据并加载显示在页面
function getInfoList(data) {
    $('.loading').hide();
    if (data) {
        console.log(data);
        if (data.StatusCode == 200) {
            $('#data').html(listHtml(data));
            $('#page').html(data.ResultData.pages);
            getPage();
            modifyStatus();
            showInfo();
            updates();
            checkAction();
        } else if (data.StatusCode == 201) {
            $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
        } else {
            $('#myModal').modal('show');
            $('#alert-form').hide();
            $('#alert-info').html('<p>' + data.ResultData + '</p>');
        }
    } else {
        $('#myModal').modal('show');
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}

// 分页li点击触发获取ajax事件获取分页
function getPage() {
    $('.pagination li').click(function () {
        var class_name = $(this).prop('class');
        if (class_name == 'disabled' || class_name == 'active') {
            return false;
        }

        var url = typeof (list_user) != 'undefined'?$(this).children().prop('href') + '&type=' + list_type + '&status=' + list_status + '&user=' + list_user:$(this).children().prop('href') + '&type=' + list_type + '&status=' + list_status;
        var ajax = new ajaxController();
        ajax.ajax({
            url: url,
            before: ajaxBeforeModel,
            success: getInfoList,
            error: ajaxErrorModel
        });
        return false;
    });
}