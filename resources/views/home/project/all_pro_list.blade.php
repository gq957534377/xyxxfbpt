<script type="text/javascript" src="{{url("JsService/Model/projectModel.js")}}"></script>
<script type="text/javascript" src="{{url("qiniu/js/main3.js")}}"></script>
<script type="text/javascript" src="{{url("qiniu/js/main4.js")}}"></script>
<script>
    var project = new Project();
    // 根据session获得项目管理个人列表
    $('#all_pro_list').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'project/list',
            type:'put',
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
@include('home.validator.editValidator')
