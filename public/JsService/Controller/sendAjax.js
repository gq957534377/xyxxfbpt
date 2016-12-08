/**
 *
 * @param url
 * @param type
 * @param data
 * @param processData
 * @param contentType
 * @constructor
 */
function Sendajax(url,type,data,processData,contentType){
    "use strcit";
    this.url = url;
    this.type=type;
    this.data=data;
    this.processData=processData;
    this.contentType=contentType;
}
Sendajax.prototype.send = function () {
  $.ajax({
      url :this.url,
      type:this.type,
      data:this.data,
      dataType:'json',
      contentType: false,
      processData: this.processData||false,
      beforeSend:function(){
              console.log("数据正在发送");
      },
      success: function(data) {
          console.log(data);
      },
      error : function(XMLHttpRequest, textStatus, errorThrown){
          console.log(XMLHttpRequest.status);
          console.log(XMLHttpRequest.readyState);
          console.log(textStatus);
          console.log(errorThrown);
      }
  });
}