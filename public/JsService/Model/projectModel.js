function Project(){

    //绘制后台表格分页表格
 Project.prototype.creatTable=function(dom, data,status,hasBtn){
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

        var status_td = $('<td></td>');
        status_td.html(status);
        tr.append(title_td).append(image_td).append(file_td).append(status_td);
        if (hasBtn =='1'){
            var thead_tr = $('<tr><td>项目标题</td><td>图片地址</td><td>项目文件</td><td>状态</td><td>操作</td></tr>');
        }else{
            var thead_tr = $('<tr><td>项目标题</td><td>图片地址</td><td>项目文件</td><td>状态</td></tr>');
        }
        $(dom).find('tbody').append(tr);
    }
    $(dom).find("thead").append(thead_tr);
 };

    // 根据数据绘制个人项目列表
    Project.prototype.creatProList = function(data){
        $('#pro_list_table tbody').html('');
        for (i in data){
            //标题
            var title_td = $('<td></td>');
            title_td.html(data[i].title);
            //状态
            if (data[i].status==1) var status = '待审核';
            if (data[i].status==2) var status = '未通过';
            if (data[i].status==3) var status = '已通过';
            var status_td = $('<td></td>');
            status_td.html(status);
            //操作
            var operating_td = $('<td><button type="button" class="btn btn-info pro_edit">修改</button></td>');
            operating_td.find('button').prop('id',data[i].project_id);
            var tr = $('<tr></tr>');
            tr.append(title_td);
            tr.append(status_td);
            tr.append(operating_td);
            $('#pro_list_table tbody').append(tr);
            $('#pro_list_table').show();
        }
    }



    Project.prototype.proEdit = function(){
         pro_id = $(this).attr('id');
        $.ajax({
            url:'project/'+pro_id,
            type:'delete',
            beforeSend:function(){
                $('.loading').show();
            },
            success:function(data){
                creatListModal(data.data[0]);
            }
        })
    };

    // ajax
    Project.prototype.ajax = function(url,type,data,success){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:url,
            type:type,
            data:data,
            beforeSend:function(){$('.loading').show();},
            success:function (data) {
                success(data);
            },
            error:function(){
                $('.loading').hide();
            }
        })
    };


    //绘制编辑信息模态框
    var creatListModal = function(data){
        $('.loading').hide();
        $('#edit_title').val(data.title);
        $('#edit_habitude').val(data.habitude);
        $('#edit_less_funding').val(data.less_funding);
        $('#edit_cycle').val(data.cycle);
        $('#edit_content').val(data.content);
        $('#edit_project_type').val(data.project_type);
        $('#pro_edit').modal('show');
    }
}