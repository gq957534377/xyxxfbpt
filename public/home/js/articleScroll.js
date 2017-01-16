/**
 * Created by wangt on 2016/12/22.
 */

var nowPage = 2;
var type = $('#article-type').val();
$('.loads').click(function () {
    var url="/article/create";
    $.ajax({
        url:url,
        type:'get',
        data:{'nowPage':nowPage,'type':type},
        success:function (data) {
            var html = '';
            if (data.StatusCode == '200') {
                $.each(data.ResultData.data, function (key, val) {
                    html += '<li class="row">';
                    html += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 list-img">';
                    html += '<a href="/article/"'+ val.guid +'><img onerror="this.src=/home/img/zxz.png" src="'+ val.banner +'"></a>';
                    html += '</div>';
                    html += '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 list-font">';
                    html += '<h3><a href="/article/'+ val.guid +'">' + val.title + '</a></h3>';
                    html += '<p>' + val.brief + '</p>';
                    html += '<div class="row list-font-bottom">';
                    html += '<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">'+ formatDate(val.addtime) +'</span>';
                    html += '<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
                    html += '<div class="bg-mg">';
                    html += '<div class="bg-mg-f">';
                    html += '<img onerror="this.src=' + "'/home/img/zxz.png'" + '" src="' + val.headPic +'">';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="bg-mg-name">' + (val.author == '')? '匿名' : val.author + '</div>';
                    html += '</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '</li>';
                });
                $('.article-list').append(html);
            }
            if (nowPage < data.ResultData.totalPage){
                nowPage+=1;
            }else {
                $('.loads').remove();
            }
        }
    });
});

function   formatDate(now)   {
    var   now= new Date(now * 1000);
    var   year=now.getFullYear();
    var   month=now.getMonth()+1;
    var   date=now.getDate();
    var   hour=now.getHours();
    var   minute=now.getMinutes();
    var   second=now.getSeconds();
    return   year+"年"+fixZero(month,2)+"月"+fixZero(date,2)+"日"+fixZero(hour,2)+":"+fixZero(minute,2)+":"+fixZero(second,2);
}
//时间如果为单位数补0
function fixZero(num,length){
    var str=""+num;
    var len=str.length;
    var s="";
    for(var i=length;i-->len;){
        s+="0";
    }      return s+str;
}