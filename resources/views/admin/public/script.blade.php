<!-- js placed at the end of the document so the pages load faster -->
<script src="http://cdn.rooyun.com/js/jquery.js"></script>
<script src="http://cdn.rooyun.com/js/bootstrap.min.js"></script>
<script src="http://cdn.rooyun.com/js/modernizr.min.js"></script>
<script src="http://cdn.rooyun.com/js/pace.min.js"></script>
<script src="http://cdn.rooyun.com/js/wow.min.js"></script>
<script src="http://cdn.rooyun.com/js/jquery.scrollto.min.js"></script>
<script src="http://cdn.rooyun.com/js/jquery.nicescroll.js" type="text/javascript"></script>

<!-- Counter-up -->
<script src="http://cdn.rooyun.com/js/waypoints.min.js" type="text/javascript"></script>
<script src="http://cdn.rooyun.com/js/jquery.counterup.min.js" type="text/javascript"></script>

<!-- sparkline -->
<script src="http://cdn.rooyun.com/js/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="http://cdn.rooyun.com/js/chart-sparkline.js" type="text/javascript"></script>

<!-- skycons -->
<script src="http://cdn.rooyun.com/js/skycons.min.js" type="text/javascript"></script>

<!--Morris Chart-->
<script src="http://cdn.rooyun.com/js/morris.min.js"></script>
<script src="http://cdn.rooyun.com/js/raphael.min.js"></script>

<script src="http://cdn.rooyun.com/js/jquery.app.js"></script>

<!-- Dashboard -->
<script src="http://cdn.rooyun.com/js/jquery.dashboard.js"></script>
<script src="{{asset('/laravel-ueditor/ueditor.config.js') }}"></script>
<script src="{{asset('/laravel-ueditor/ueditor.all.min.js')}}"></script>

<script type="text/javascript">

    var ue = UE.getEditor('UE', {
        toolbars: [
            [
//                'anchor', //锚点
//                'undo', //撤销
//                'redo', //重做
                'bold', //加粗
                'indent', //首行缩进
                'italic', //斜体
                'underline', //下划线
//                'strikethrough', //删除线
//                'subscript', //下标
//                'fontborder', //字符边框
//                'superscript', //上标
//                'source', //源代码
                'blockquote', //引用
//                'pasteplain', //纯文本粘贴模式
//                'selectall', //全选
                'horizontal', //分隔线
                'removeformat', //清除格式
//                'time', //时间
//                'date', //日期
                'unlink', //取消链接
//                'insertrow', //前插入行
//                'insertcol', //前插入列
                'mergeright', //右合并单元格
                'mergedown', //下合并单元格
                'deleterow', //删除行
                'deletecol', //删除列
                'inserttitle', //插入标题
                'mergecells', //合并多个单元格
                'deletetable', //删除表格
                'cleardoc', //清空文档
                'insertparagraphbeforetable', //"表格前插入行"
//                'insertcode', //代码语言
                'fontfamily', //字体
                'fontsize', //字号
                'paragraph', //段落格式
//                'simpleupload', //单图上传
//                'insertimage', //多图上传
                'edittable', //表格属性
                'edittd', //单元格属性
                'link', //超链接
                'spechars', //特殊字符
//                'searchreplace', //查询替换
//                'gmap', //Google地图
//                'insertvideo', //视频
                'justifyleft', //居左对齐
                'justifyright', //居右对齐
                'justifycenter', //居中对齐
                'forecolor', //字体颜色
                'backcolor', //背景色
//                'directionalityltr', //从左向右输入
//                'directionalityrtl', //从右向左输入
//                'rowspacingtop', //段前距
//                'rowspacingbottom', //段后距
//                'pagebreak', //分页
//                'insertframe', //插入Iframe
//                'imagenone', //默认
//                'imageleft', //左浮动
//                'imageright', //右浮动
//                'attachment', //附件
                'imagecenter', //居中
                'lineheight', //行间距
//                'customstyle', //自定义标题
//                'autotypeset', //自动排版
//                'webapp', //百度应用
                'background', //背景
//                'template', //模板
//                'scrawl', //涂鸦
//                'music', //音乐
                'inserttable', //插入表格
//                'charts', // 图表
            ]
        ],
        initialFrameWidth : '100%',
        initialFrameHeight : '30%'
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        /* Counter Up */
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });
    });
    /* BEGIN SVG WEATHER ICON */
    if (typeof Skycons !== 'undefined'){
        var icons = new Skycons(
                {"color": "#fff"},
                {"resizeClear": true}
                ),
                list  = [
                    "clear-day", "clear-night", "partly-cloudy-day",
                    "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                    "fog"
                ],
                i;

        for(i = list.length; i--; )
            icons.set(list[i], list[i]);
        icons.play();
    };
</script>