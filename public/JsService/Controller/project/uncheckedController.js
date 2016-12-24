//project_info创建待审核列表
var creatTable = function(data){
    if (!data) return false;
    for(i in data){
        var tr = $('<tr></tr>');

        var title_td = $('<td></td>');
        title_td.html(data[i].title);

        var image_td = $('<td></td>');
        var image_a = $('<a></a>');
        image_a.attr('href',data[i].banner_img);
        image_a.attr('target','_blank');
        image_a.html('<img class="unchecked_img"/>');
        image_a.find('img').attr('src',data[i].banner_img);
        image_td.html(image_a);

        var file_td = $('<td></td>');
        var file_a = $('<a></a>');
        file_a.attr('href',data[i].brief_content);
        file_a.attr('target','_blank');
        file_a.html(data[i].brief_content);
        file_td.html(file_a);

        var status_td = $('<td>待审核</td>');
        var btn_td = $('<td></td>');

        var btn_yes = $("<button class='btn btn-success m-b-5 btn_yes changr_btn' status='yes'>通过</button>");
        var btn_no = $("<button class='btn btn-primary m-b-5 btn_no changr_btn' status='no'>不通过</button>");
        btn_yes.attr({'id':data[i].guid});
        btn_no.attr({'id':data[i].guid});
        btn_td.append(btn_yes).append(btn_no);
        tr.append(title_td).append(image_td).append(file_td).append(status_td).append(btn_td);
        var thead_tr = $('<tr><td>项目标题</td><td>图片</td><td>项目简介</td><td>状态</td><td>操作</td></tr>');
        $("#unchecked_table tbody").append(tr);
    }
    $("#unchecked_table thead").append(thead_tr);
};

//确认通过
var statusCheck_yes = function(id, status){
    $.ajax({
        url:'/project',
        type:'post',
        data:{
            id:id,
            status:status
        },
        success:function(data){
            $(".loading").hide();
            $('#'+id).parents('tr').remove();
        }
    })
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
    var class_name = $(this).prop('class');
    if(class_name == 'disabled' || class_name == 'active') {
        return false;
    }
    var url = $(this).children().prop('href');
    $.ajax({
        url:url,
        type:'delete',
        data:{
            status:'1'
        },
        success:function (res) {
            var data = res.data;
            $('.loading').hide();
            $("#unchecked_table thead").html('');
            $("#unchecked_table tbody").html('');
            $('.pagination').html('');

            //绘制待审核表格
            creatTable(data);

            $("#unchecked_table").parent().append(data.pages);
            $('.pagination li').click(fpageClick);

            //通过按钮
            $('.btn_yes').click(function(){
                $('#verify_yes').modal('show');
                $('#verify_yes_btn').attr('pro_id',$(this).attr('id'));
            });

            //不通过按钮
            $('.btn_no').click(function(){
                $('#verify_no').modal('show');
                $('#verify_remark').val('');
                $('#verify_no_btn').attr('pro_id',$(this).attr('id'));
            });

            //定义确认通过按钮
            $('#verify_yes_btn').click(function(){
                statusCheck_yes($(this).attr('pro_id'),3);
                $('#verify_yes').modal('hide');
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
            status:'0'
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
            $('.pagination li').click(fpageClick);

            //通过按钮
            $('.btn_yes').click(function(){
                $('#verify_yes').modal('show');
                $('#verify_yes_btn').attr('pro_id',$(this).attr('id'));
            });

            //不通过按钮
            $('.btn_no').click(function(){
                $('#verify_no').modal('show');
                $('#verify_remark').val('');
                $('#verify_no_btn').attr('pro_id',$(this).attr('id'));
            });

            //定义确认通过按钮
            $('#verify_yes_btn').click(function(){
                statusCheck_yes($(this).attr('pro_id'),3);
                $('#verify_yes').modal('hide');
            });

            //定义确认不通过按钮
            $('#verify_no_btn').click(function(){
                statusCheck_no($(this).attr('pro_id'),2);
            })
        }
    });

})