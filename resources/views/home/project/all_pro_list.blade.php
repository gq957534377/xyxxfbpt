<script type="text/javascript" src="{{url("jsService/Model/projectModel.js")}}"></script>
<script>
    var project = new Project();
    // 项目管理个人列表
    $('#all_pro_list').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'project/list',
            type:'put',
            data:{

            },
            beforeSend:function(){
                $('.loading').show();
            },
            success:function(data){
                $('.loading').hide();
                $('#userBox').hide();
                project.creatProList(data.data);
                $('.pro_edit').click(project.proEdit);
            }

        })
    })
</script>