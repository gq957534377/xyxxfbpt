<!-- 编辑表单验证 Start -->
<script>
    /**
     * Theme: Velonic Admin Template
     * Author: Coderthemes
     * Form Validator
     */
    // 文档地址 http://www.runoob.com/jquery/jquery-plugin-validate.html
    !function($) {
        "use strict";
        var FormValidator = function() {
            this.$projectForm = $("#pro_edit_form");
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
                    data.append( "title"     , $("#edit_title").val());
                    data.append( "content"   , $('#edit_content').val());
                    data.append( "image"     , $('#edit_image').val());
                    data.append( "file"      , $('#edit_file').val());
                    data.append( "habitude"  , $('#edit_habitude').val());
                    data.append( "less_funding" , $('#edit_less_funding').val());
                    data.append( "cycle"        , $('#edit_cycle').val());
                    data.append( "project_type" , $('#edit_project_type').val());
                    // add data for ajax
                    $.ajax({
                        url:'/project_user/'+ pro_id,
                        type:'put',
                        data:{
                            title:$("#edit_title").val(),
                            content:$('#edit_content').val(),
                            image:$('#edit_image').val(),
                            file: $('#edit_habitude').val(),
                            habitude: $('#edit_habitude').val(),
                            less_funding:$('#edit_less_funding').val(),
                            cycle:$('#edit_cycle').val(),
                            project_type:$('#edit_project_type').val()
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
                            $('#edit_table tbody').html('');
                            $('#edit_table').hide();
                            if(data.status=='200') promptBoxHandle('操作提示','更新成功');
                            if(data.status=='500') promptBoxHandle('操作提示','您没有做任何改变哦');
                            $('#pro_edit').modal('hide');

                            // 重新获得个人管理列表
                            $('#all_pro_list').click();
                        },
                        error:function(data){

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
<!-- 编辑表单验证 End -->
