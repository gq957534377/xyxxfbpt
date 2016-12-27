//project_info创建待审核列表
var creatTable = function(data){
    if (!data) return false;
    for(i in data){
        var tr = $('<tr></tr>');

        var title_td = $('<td></td>');
        title_td.html(data[i].title);

        var image_td = $('<td></td>');
        var image_a = $('<a></a>');
        image_a.attr('href','/project/'+data[i].guid+'?online');
        image_a.attr('target','_self');
        image_a.html('<button class="btn btn-warning btn-xs">查看详情</button>');
        image_td.html(image_a);

        var file_td = $('<td></td>');
        var file_a = $('<a></a>');
        var str = data[i].brief_content;
        if(str.length>40){
            str = str.substring(0,40)+'...'
        }
        file_a.html(str);
        file_td.html(file_a);

        var btn_td = $('<td></td>');

        var btn_no = $('<button class="btn_no btn btn-danger btn-xs" style="border-radius:6px">下线</button>');
        btn_no.attr({'id':data[i].guid});
        btn_td.append(btn_no);
        tr.append(title_td).append(file_td).append(image_td).append(btn_td);
        var thead_tr = $('<tr><td>项目标题</td><td>项目简介</td><td>项目详情</td><td>操作</td></tr>');
        $("#unchecked_table tbody").append(tr);
    }
    $("#unchecked_table thead").append(thead_tr);
};

//确认不通过事件
var statusCheck_no = function(id, status){
    //控制审核失败原因不能为空
    if ($('#verify_remark').val()==''){
        $('#verify_remark').val('请输入审核不通过原因');
        return false;
    }

    $.ajax({
        url:'/project',
        type:'post',
        data:{
            id:id,
            status:status,
            remark:$('#verify_remark').val()
        },
        success:function(data){
            if (data.status==200){
                $(".loading").hide();
                $('#'+id).parents('tr').remove();
                $('#verify_no').modal('hide');
            }
        }
    })
};
//分页点击事件
var fpageClick = function(){
    var class_name = $(this).parent('li').prop('class');
    if(class_name == 'disabled' || class_name == 'active') {
        return false;
    }
    var nowPage = $(this).html();

    $.ajax({
        url:'status1',
        type:'put',
        data:{
            status:'1',
            nowPage : nowPage
        },
        success:function (res) {
            if(res.StatusCode == '400'){
                location.reload(true)
            }
            var data = res.ResultData;
            $('.loading').hide();
            $("#unchecked_table thead").html('');
            $("#unchecked_table tbody").html('');
            $('.pagination').html('');

            //绘制待审核表格
            creatTable(data);

            $("#unchecked_table").parent().append(res.pages);
            $('.pagination li a').click(fpageClick);


            //不通过按钮
            $('.btn_no').click(function(){
                $('#verify_no').modal('show');
                $('#verify_remark').val('');
                $('#verify_no_btn').attr('pro_id',$(this).attr('id'));
            });


            //定义确认不通过按钮
            $('#verify_no_btn').click(function(){
                statusCheck_no($(this).attr('pro_id'),2);
            })

        }
    });
    return false;
};

$(function(){
    //页面刷新请求待审核数据
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:'status1',
        type:'put',
        data:{
            status:'1'
        },
        beforeSend:function(){
            var width  = $('#margin_load').width() / 2;
            var height = $('#margin_load').height() / 2 + 80;

            $('.loading').show().css({
                'left' : width,
                'top' : height,
            });
        },
        success:function(data){
            $('.loading').hide();

            if (data.StatusCode == '400') return '暂时没有数据哦';

            creatTable(data.ResultData);

            $("#unchecked_table").parent().append(data.pages);
            $('.pagination li a').click(fpageClick);


            //不通过按钮
            $('.btn_no').click(function(){
                $('#verify_no').modal('show');
                $('#verify_remark').val('');
                $('#verify_no_btn').attr('pro_id',$(this).attr('id'));
            });


            //定义确认不通过按钮
            $('#verify_no_btn').click(function(){
                statusCheck_no($(this).attr('pro_id'),2);
            })
        }
    });

})