function Project(){

}
Project.prototype.creatTable=function(dom, data,status,hasBtn){
    for(i in data.data){
        var tr = $('<tr></tr>');

        var title_td = $('<td></td>');
        title_td.html(data.data[i].title);

        var image_td = $('<td></td>');
        image_td.html(data.data[i].image);

        var file_td = $('<td></td>');
        file_td.html(data.data[i].file);

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