/**
 * ajax成功执行函数
 * @author 郭鹏超
 */

// 获取分页数据并加载显示在页面
function getInfoList(data){
    $('.loading').hide();
    if (data) {
        if (data.StatusCode == 200) {
            if(data.ResultData.data == '') {
                $('#data').html('<p style="padding:20px;" class="text-center">没有数据,请添加数据！</p>');
            }else {
                $('#data').html(listHtml(data));
                $('#page').html(data.ResultData.pages);
                if( typeof deleteData === 'function' )
                    deleteData();
                if( typeof modifyPass === 'function' )
                    modifyPass();
                if( typeof modifyFail === 'function' )
                    modifyFail();
                if( typeof updateData === 'function' )
                    updateData();
                if( typeof showInfo === 'function' )
                    showInfo();
                    getPage();
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


// 判断身份证类型
function cardState(code){
    if(code == 1) {
        return '大陆身份证';
    }else if(code == 2) {
        return '其它身份证';
    }else if(code == 3) {
        return '护照';
    }else{
        return '';
    }
}

// 判断姓别类型
function sexMethod(code){
    if(code == 1) {
        return '男';
    }else if(code == 2) {
        return '女';
    }else {
        return '';
    }
}

// 显示个人用户详情
function showInfoList(data){
    $('.loading').hide();
    $('#alert-form').show();
    $('#con-close-modal').modal('show');
    if (data) {
        if (data.StatusCode == 200) {
            $('#alert-form').html(infoHtml(data.ResultData));
        } else {
            $('#alert-form').hide();
            $('#alert-info').html('<p>' + data.ResultData + ',获取数据失败</p>');
        }
    } else {
        $('#alert-form').hide();
        $('#alert-info').html('<p>未知的错误</p>');
    }
}