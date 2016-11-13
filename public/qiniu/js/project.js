
$(function(){

    //异步提交项目发布信息
  $("#submit").click(function(){
      $.ajax({
          url:'/project',
          type:'post',
          data:{
              title:$("input[name='title']").val(),
              content:$("textarea[name='content']").val(),
              image:$("input[name='image']").val(),
              file:$("input[name='file']").val(),
              _token:$("#_token").val()
          },
          success:function(data){
              alert('添加成功');
          },
          error:function(){
              alert('3');
          }
      })
  })
});