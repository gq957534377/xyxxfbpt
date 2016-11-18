<!-- 验证机制 Start -->
<script src="{{asset('admin/js/jquery.validate.min.js')}}"></script>
<script>
    /**
     * Theme: Velonic Admin Template
     * Author: Coderthemes
     * Form Validator
     */
    // 文档地址 http://www.runoob.com/jquery/jquery-plugin-validate.html

    $('#publish_trigger').click(function(){
        $.ajax({
            url:'/project/create',
            type:'get',
            async:false,
            beforeSend:function(){$('.loading').show()},
            success:function(data){
                $('.loading').hide();
                if(data.data!=2){
                    promptBoxHandle('提示','请先申请成为创业者哦！');
                }else{
                    $('#_projectPunlish').modal('show');
                }
            },
            error:function(){
                $('.loading').hide();
            }
        });
    })

    !function($) {
        "use strict";
        var FormValidator = function() {
            this.$projectForm = $("#projectForm");
        };
        FormValidator.prototype.init = function() {
            $.validator.setDefaults({
                submitHandler: function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var data = new FormData();
                    data.append( "title"     , $('input[name=title]').val());
                    data.append( "content"   , $('input[name=content]').val());
                    data.append( "image"     , $('input[name=image]').val());
                    data.append( "file"      , $('input[name=file]').val());
                    data.append( "habitude"  , $('input[name=habitude]').val());
                    data.append( "less_funding" , $('input[name=less_funding]').val());
                    data.append( "cycle"        , $('input[name=cycle]').val());
                    data.append( "project_type" , $('select[name=project_type]').val());
                    // add data for ajax
                    $.ajax({
                        url:'/project',
                        type:'post',
                        data:{
                            title:$("input[name='title']").val(),
                            content:$("textarea[name='content']").val(),
                            image:$("input[name='image']").val(),
                            file: $("input[name='file']").val(),
                            habitude: $("input[name='habitude']").val(),
                            less_funding:$("input[name='less_funding']").val(),
                            cycle:$("input[name='cycle']").val(),
                            project_type:$("select[name='project_type']").val()
                        },
                        beforeSend:function(){
                          $('.loading').show();
                        },
                        success:function(data){
                            $('.loading').hide();
                            $("input[name='title']").val('');
                            $("textarea[name='content']").val('');
                            $("input[name='image']").val('');
                            $("input[name='file']").val('');
                            $("input[name='habitude']").val('');
                            $("input[name='less_funding']").val('');
                            $("input[name='cycle']").val('');
                            $("select[name='project_type']").val('');
                            $('#pro_list_table tbody').html('');
                            promptBoxHandle('操作提示','提交成功');
                            $('#_projectPunlish').modal('hide');
                        },
                        error:function(data){
                            promptBoxHandle('操作提示','提交失败');
                        }
                    })
                }
            });
            // validate signup form on keyup and submit
            this.$projectForm.validate({
                // 验证规则
                rules: {
                    title: {
                        required: true
                    },
                    content: {
                        required: true
                    },
                    image: {
                        required: true
                    },
                    file: {
                        required: true
                    },
                    habitude:{
                        required:true
                    },
                    less_funding:{
                        required:true
                    },
                    cycle:{
                        required:true
                    },
                    project_type:{
                        required:true,
                        max:50
                    }
                },
                // 提示信息
                messages: {
                    title: {
                        required: '必须要填写标题哦',
                    },
                    content: {
                        required: '必须要填写项目简介哦'
                    },
                    image: {
                        required: '必须要上传一张图片哦'
                    },
                    file: {
                        required: '必须要上传一份项目文件哦'
                    },
                    habitude:{
                        required: '请填写项目性质'
                    },
                    less_funding:{
                        required: '请填写项目起步资金'
                    },
                    cycle:{
                        required: '请填写项目周期'
                    },
                    project_type:{
                        required: '请选择项目类型',
                        max:'请控制在50字以内哦'
                    }
                }
            });

        },
                //init
                $.FormValidator = new FormValidator,
                $.FormValidator.Constructor = FormValidator
    }(window.jQuery),

            function($) {
                "use strict";
                $.FormValidator.init()
            }(window.jQuery);


</script>
<!-- 验证机制 End -->
