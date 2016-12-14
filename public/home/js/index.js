var BannerImgNum = 1;//初始化banner图
var time1 = null;//banner轮播时间函数
$(function(){
	//banner图点击事件
	$("#js_btn1 li").click(function(){
		$("#js_btn1 .active").removeClass("active");
		$(this).addClass("active");
		var num = $(this).attr("zxz-data");
		BannerImgNum = parseInt(num)+1;
		bannerImg(num);
	})
	//鼠标进入banner高清图
	$("#NavigationBar_img").mouseenter(function(){
		clearInterval(time1);
	})
	//鼠标离开banner高清图
	$("#NavigationBar_img").mouseleave(function(){
		// time1 = setInterval("autoBannerImg()",3000);
	})
	//众筹上下按钮点击事件
	$("#js_btn2 li").click(function(){
		$("#js_btn2 .active").removeClass("active");
		$(this).addClass("active");
		var tops = $(this).attr("zxz-data");
		var imgTop = $(this).attr("zxz-datas");
		moveBiao(tops,imgTop);
	})
	//众筹最新上架与即将结束切换
	$("#section5_content_middle li").click(function(){
		$("#section5_content_middle .active").removeClass("active");
		$(this).addClass("active");
		$("#section5_content_bottom ul"). toggleClass("active")
	})
	// time1 = setInterval("autoBannerImg()",3000);
	
})
//众筹上下按钮触发动画方法
function moveBiao(tops,imgTop){
	$("#js_btn2_biao").animate({top:tops})
	$("#crowd_img").animate({top:imgTop})
}
//生成众筹进度条加载
function loadbar(obj){
	
}
//将小数转化为百分数
function creatPercentage(num){
	var nums = parseFloat(num);
	if(num>1){
		return "100%";
	}else{
		var temp = Math.round(nums*100)+"%";
		return temp;
	}
}
//去除指定长度字符后返回剩余部分
function cutStr(num,str){
	var temp = str.substring(num);
}
