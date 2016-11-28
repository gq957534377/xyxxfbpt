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
        image_a.html('<img class="unchecked_img"/>');
        image_a.find('img').attr('src',data.data[i].image);
        image_td.html(image_a);

        var file_td = $('<td></td>');
        var file_a = $('<a></a>');
        file_a.attr('href',data.data[i].file);
        file_a.attr('target','_blank');
        file_a.html(data.data[i].file);
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
    Project.prototype.creatProList = function(data,dom){
        dom.find('tbody').html('');
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
            //已通过，提供修改项目公开隐藏功能
            if (data[i].disable==0&&data[i].status==3) var operating_td = $('<td class="operateTd"><button type="button" class="btn btn-info pro_on">隐藏</button></td>');
            if (data[i].disable==1&&data[i].status==3) var operating_td = $('<td><button type="button" class="btn btn-info pro_off">公开</button></td>');

            //待审核，
            if (data[i].status==1) var operating_td = $('<td>请耐心等待...</td>');

            //未通过，提供重新发布
            if (data[i].status==2) var operating_td = $('<td><button type="button" class="btn btn-info pro_edit">修改</button></td>');
            operating_td.find('button').prop('id',data[i].project_id);
            var tr = $('<tr></tr>');
            tr.append(title_td);
            tr.append(status_td);
            tr.append(operating_td);
            dom.find('tbody').append(tr);
            dom.show();
        }
    };


    //编辑按钮事件
    Project.prototype.proEdit = function(){
         pro_id = $(this).attr('id');
        $.ajax({
            url:'/project/'+pro_id,
            type:'delete',
            beforeSend:function(){
                $('.loading').show();
            },
            success:function(data){
                creatListModal(data.data[0]);
            }
        })
    };

    //禁用按钮事件
    Project.prototype.proTurnOff = function(){
        pro_id = $(this).attr('id');
        var This = $(this);
        $.ajax({
            url:'/project_user/'+pro_id+'/edit',
            type:'get',
            data:{
                disable:1
            },
            beforeSend:function(){
                $('.loading').show();
            },
            success:function(data){

                if(data.status==200){
                    This.html('公开');
                    This.removeClass('pro_on').addClass('pro_off');
                    alert('已经设置为隐藏');
                    $('.pro_off').off("click").click(project.proTurnOn);
                    $('.pro_on').off("click").click(project.proTurnOff);
                }
            }
        })
    };

    //开启按钮事件
    Project.prototype.proTurnOn = function(){
        pro_id = $(this).attr('id');
        var This = $(this);
        $.ajax({
            url:'/project_user/'+pro_id+'/edit',
            type:'get',
            data:{
                disable:0
            },
            beforeSend:function(){
                $('.loading').show();
            },
            success:function(data){

                if(data.status==200){
                    This.html('隐藏');
                    This.removeClass('pro_off').addClass('pro_on');
                    alert('修改为公开');
                    $('.pro_on').off("click").click(project.proTurnOff);
                    $('.pro_off').off("click").click(project.proTurnOn);
                }
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

    //投资人浏览详情部分
    Project.prototype.creatDetail = function(data,dom){
        dom.html("<span class='readmore_cycle'>  投资周期：</span><br><span class='readmore_habitude'>  投资性质：</span><br> <span class='readmore_less_funding'>  起步资金：</span><br>");
        $('.readmore_cycle').append(data.cycle);
        $('.readmore_habitude').append(data.habitude);
        $('.readmore_less_funding').append(data.less_funding);
    };

    //测试函数
    Project.prototype.test = function(){
        alert('project测试');
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