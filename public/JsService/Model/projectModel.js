function Project(){

}
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
}