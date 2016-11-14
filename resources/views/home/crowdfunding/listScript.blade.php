<script>
    var page = 1;//当前页码
    var pageBlock = 1;//选中的按钮（1-5）
    var status = 0;//0为原始状态；1为改变状态
    var endPage = null;//全部的页码
    var object;
    var projectClass = window.location.href.substring(window.location.href.length-1);//当前所在项目分类列表页
    //查询总页数
    var selectEndPage = function (data) {
        endPage = parseInt(data.endPage);
        createButton(endPage);
    }
    var creatBlock =function (data) {
        creatPageHtml(data);
        changeActive(object);
    }
    //创建分页按钮点击事件
    function creatButtonClick()
    {
        //数字按钮绑定触发事件
        for(var i =1;i<6;i++){
            $(".pagination").children("li").eq(i).click(function () {
                object = $(this);
                clickPages($(this));
            })
        }
        //向下按钮绑定点击事件
        $(".pagination").children("li").eq(0).click(function () {
            if(page != 1){
                if(page == 3){
                    $(".pagination").children("li").eq(2).trigger("click")
                }else {
                    downPage();
                }
            }else {
                alert("没有了哦！")
            }
        })
        //向上按钮绑定点击事件
        $(".pagination").children("li").eq(6).click(function () {
            if(page < endPage-2){
                upPage();
            }else {
                alert("没有了哦！")
            }
        })
    }

    //向下翻页
    function downPage() {
        $(".pagination").children("li").eq(pageBlock-1).trigger("click")
    }
    
    //向上翻页
    function upPage() {
        $(".pagination").children("li").eq(pageBlock+1).trigger("click")
    }
    
    //改变数字按钮样式
    function changeActive(obj) {
        pageBlock = parseInt(obj.attr("zxz"));
        page = parseInt(obj.children("a").html())
        if(pageBlock < 4&&page < 4){
            if(status == 0){
                $(".pagination").children(".active").removeClass("active");
                obj.addClass("active");
            }else {
                status = 0;
                for(var i =1;i<6;i++){
                    $(".pagination").children("li").eq(i).children("a").html(i)
                }
            }
        }else if(page >endPage-2){
            pageBlock = parseInt(obj.attr("zxz"));
            if(endPage - page == 1){
                $(".pagination").children(".active").removeClass("active");
                $(".pagination").children("li").eq(pageBlock).addClass("active")
                for(var i =1;i<6;i++){
                    $(".pagination").children("li").eq(i).children("a").html(page-4+i)
                }
            }else {
                $(".pagination").children(".active").removeClass("active");
                obj.addClass("active");
            }
        }else {
            reHtml()
        }
    }
    
    //改变数字按钮html内的数字(核心)
    function reHtml() {
        pageBlock = 3;
        status = 1;
        $(".pagination").children(".active").removeClass("active");
        $(".pagination").children("li").eq(pageBlock).addClass("active")
        for(var i =1;i<6;i++){
            $(".pagination").children("li").eq(i).children("a").html(page-3+i)
        }
    }
    
    //生成分页按钮
    function createButton(Pages) {
        if(Pages > 5){
            var num =1;
            var str = "<li><a href='javascript:void(0);'><i class='fa fa-long-arrow-left'></i>Previous Page</a></li><li zxz='1'><a href='javascript:void(0);'>1</a></li><li zxz='2'><a href='javascript:void(0);'>2</a></li><li zxz='3'><a href='javascript:void(0);'>3</a></li><li zxz='4'><a href='javascript:void(0);'>4</a></li><li zxz='5'><a href='javascript:void(0);'>5</a></li><li><a href='javascript:void(0);'>Next Page<i class='fa fa-long-arrow-right'></i></a></li>";
        }else {
            var buttons = "";
            for(var i = 1;i <= Pages;i++){
                var num = 0;
                buttons += "<li zxz='"+i+"'><a href='javascript:void(0);'>"+i+"</a></li>"
            }
            var str = buttons;
        }
        $(".pagination").html(str)
        $(".pagination").children("li").eq(num).addClass('active');
        if(Pages > 5){
            creatButtonClick();
        }else{
            buttonClicks();
        }
    }
    
    //创建分页按钮点击补充事件
    function buttonClicks()
    {
        $(".pagination").children("li").click(function () {
            object = $(this);
            ajaxSup($(this))
        })
    }
    
    var tokens = "{{csrf_token()}}";
    var postData = {_token:tokens,page:page,type:projectClass};
    ajaxRequestPost("/crow_funding_page",postData,creatBlock)
    ajaxRequestGet('/crow_funding_page/'+projectClass,selectEndPage)//执行查询总分页数Ajax请求
    //
    function clickPages(object) {
        var clickPage = object.children("a").html();
        var postBag ={_token:tokens,page:clickPage,type:projectClass}
        ajaxRequestPost("/crow_funding_page",postBag,creatBlock)
    }
    //补充Ajax请求
    function ajaxSup(obj) {
        var clickPage = object.children("a").html();
        var postBag ={_token:tokens,page:clickPage,type:projectClass}
        ajaxRequestPost("/crow_funding_page",postBag,function (data) {
            creatPageHtml(data);
            $(".pagination").children(".active").removeClass("active");
            obj.addClass("active");
        })
    }
    //生成该页相关内容html
    function creatPageHtml(data) {
        var strFather ="";
        var strSon = "";
        var forNum = 0;
        for(var i = 0;i < Math.ceil(data.length/4);i++){
            for(var j = 0;j<4;j++){
                forNum++;
                if(forNum>data.length){
                    break;
                }else {
                    strSon += "<div style='margin-top: 35px;' class='portfolio-item apps col-xs-12 col-sm-4 col-md-3'><div class='recent-work-wrap'><img class='img-responsive' src='{{asset('home/images/portfolio/full/item1.png')}}' alt=''><div class='overlay'><div class='recent-work-inner'><h3><a href='#'>热门推荐</a></h3><p>There are many variations of passages of Lorem Ipsum available, but the majority</p><a class='preview' href='{{url('crowd_funding/0/edit')}}'><i class='fa fa-eye'></i> 查看</a></div></div></div></div><!--/.portfolio-item-->";
                }
            }
            strFather += "<div class='row wow fadeInUp'><div class='portfolio-items'>"+strSon+"</div></div>"
            strSon="";
        }
        $("#plotBord").html(strFather);
    }
</script>