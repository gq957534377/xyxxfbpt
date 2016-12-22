//时间转换
function getLocalTime(ns) {
    var now = new Date(ns);
    var year=now.getYear();
    var month=now.getMonth()+1;
    var date=now.getDate();
    var hour=now.getHours();
    var minute=now.getMinutes();
    var second=now.getSeconds();
    return "20"+year+"年"+month+"月"+date+"日 "+hour+":"+minute;
}

//时间转换
function MyTime(n) {
    var now = new Date(n);
    var year=now.getYear();
    var month=now.getMonth()+1;
    var date=now.getDate();
    var hour=now.getHours();
    var minute=now.getMinutes();
    var second=now.getSeconds();
    return "20"+year+"/"+month+"/"+date+" "+hour+":"+minute;
}