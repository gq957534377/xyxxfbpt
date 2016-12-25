
// 获取分页数据并加载显示在页面
function getInfoList(data) {
    $('.loading').hide();
    if (data) {
        console.log(data);
        if (data.StatusCode == 200) {
            $('#data').html(listHtml(data));
            $('#page').html(data.ResultData.pages);
            getPage();
            // modifyStatus();
            initAlert();
            showInfo();
            checkAction();
        } else if (data.StatusCode == 204) {
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

        var url;
        if (typeof (list_user) != 'undefined'){
            url = $(this).children().prop('href') + '&type=' + list_type + '&status=' + list_status + '&user=' + list_user;
        }else {
            url = $(this).children().prop('href') + '&type=' + list_type + '&status=' + list_status+'&college_type='+college_type;
        }

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

//时间转换
function getLocalTime(nS) {
    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
}