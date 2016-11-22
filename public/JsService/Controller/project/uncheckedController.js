//project_info创建待审核列表
var creatTable = function(data){
    if (!data) return false;
    for(i in data.data){
        var tr = $('<tr></tr>');

        var title_td = $('<td></td>');
        title_td.html(data.data[i].title);

        var image_td = $('<td></td>');
        var image_a = $('<a></a>');
        image_a.attr('href',data.data[i].image);
        image_a.attr('target','_blank');
        image_a.html(data.data[i].image);
        image_td.html(image_a);

        var file_td = $('<td></td>');
        var file_a = $('<a></a>');
        file_a.attr('href',data.data[i].image);
        file_a.attr('target','_blank');
        file_a.html(data.data[i].image);
        file_td.html(file_a);

        var status_td = $('<td>待审核</td>');
        var btn_td = $('<td></td>');

        var btn_yes = $("<button class='btn btn-success m-b-5 btn_yes changr_btn' status='yes'>YES</button>");
        var btn_no = $("<button class='btn btn-primary m-b-5 btn_no changr_btn' status='no'>NO</button>");

        btn_yes.attr({'id':data.data[i].project_id});
        btn_no.attr({'id':data.data[i].project_id});
        btn_td.append(btn_yes).append(btn_no);
        tr.append(title_td).append(image_td).append(file_td).append(status_td).append(btn_td);
        var thead_tr = $('<tr><td>项目标题</td><td>图片地址</td><td>项目文件</td><td>状态</td><td>操作</td></tr>');
        $("#unchecked_table tbody").append(tr);
    }
    $("#unchecked_table thead").append(thead_tr);
};

//分页点击时间
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
            creatTable(data);
            statusCheck($(".changr_btn"));
            $("#unchecked_table").parent().append(data.pages);
            $('.pagination li').click(fpageClick);
        }
    });
    return false;
};

//修改状态按钮事件
var statusCheck = function(dom){
    dom.click(function(){

        if(!confirm("是否确认删除")) return false;

        var id = $(this).attr('id');
        $(this).parent().parent().addClass('tmp');
        $.ajax({
            url:'/project',
            type:'post',
            data:{
                id:id,
                status:$(this).attr('status')
            },
            success:function(data){
                $(".loading").hide();
                $('.tmp').remove();
            }
        })
    })
};
$(function(){
    //ajax请求数据
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//        var nowPage = if($('.pagination'))?$('.pagination'):'1';
//        请求待审核数据
    $.ajax({
        url:'status1',
        type:'put',
        data:{
            status:'1'
        },
        beforeSend:function(){$('.loading').show()},
        success:function(res){
            $('.loading').hide();
            var data = res.data;
            if (!data) return '暂时没有数据哦';
            creatTable(data);
            statusCheck($(".changr_btn"));
            $("#unchecked_table").parent().append(data.pages);
            $('.pagination li').click(fpageClick);
        }
    });

})