function fix(num, length) {
    return ('' + num).length < length ? ((new Array(length + 1)).join('0') + num).slice(-length) : '' + num;
}
//时间转换
function getLocalTime(ns) {
    var now = new Date(ns*1000);
    var year=now.getFullYear();
    var month=now.getMonth()+1;
    var date=now.getDate();
    var hour=now.getHours();
    var minute=now.getMinutes();
    return year+"-"+month+"-"+date+" "+hour+":"+fix(minute, 2);
}

//时间转换
function MyTime(n) {
    var now = new Date(n);
    var year=now.getFullYear();
    var month=now.getMonth()+1;
    var date=now.getDate();
    var hour=now.getHours();
    var minute=now.getMinutes();
    var second=now.getSeconds();
    return year+"/"+month+"/"+date+" "+hour+":"+minute;
}