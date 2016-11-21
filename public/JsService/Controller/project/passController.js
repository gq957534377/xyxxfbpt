var project = new Project();

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
            status:'2'
        },
        success:function (res) {
            var data = res.data;
            $('.loading').hide();
            $("#unchecked_table thead").html('');
            $("#unchecked_table tbody").html('');
            $('.pagination').html('');
            project.creatTable($('#unchecked_table'),data,'已通过',0);
            statusCheck($(".changr_btn"));
            $("#unchecked_table").parent().append(data.pages);
            $('.pagination li').click(fpageClick);
        }
    });
    return false;
};

var statusCheck = function(dom){
    dom.click(function(){
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
        url:'status2',
        type:'put',
        data:{
            status:'2'
        },
        success:function(res){
            var data = res.data;
            $('.loading').hide();
            project.creatTable($('#unchecked_table'),data,'已通过',0);
            statusCheck($(".changr_btn"));
            $("#unchecked_table").parent().append(data.pages);
            $('.pagination li').click(fpageClick);
        }
    });

})