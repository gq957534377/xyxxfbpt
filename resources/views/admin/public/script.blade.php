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


{{--
@ 富文本
@ author郭庆
--}}
<script type="text/javascript">
    var toolbra = {
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
    };
    var ue = UE.getEditor('UE', toolbra);
    var ue1 = UE.getEditor('UE1', toolbra);
//    var ue2 = UE.getEditor('UE2', toolbra);

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

{{--
@ 时间插件
@ author郭庆
--}}

<script src="/dateTime/build/jquery.datetimepicker.full.js"></script>
<script>
    $.datetimepicker.setLocale('en');
    $('#datetimepicker_format').datetimepicker({value:'2015/04/15 05:03', format: $("#datetimepicker_format_value").val()});
    console.log($('#datetimepicker_format').datetimepicker('getValue'));

    $("#datetimepicker_format_change").on("click", function(e){
        $("#datetimepicker_format").data('xdsoft_datetimepicker').setOptions({format: $("#datetimepicker_format_value").val()});
    });
    $("#datetimepicker_format_locale").on("change", function(e){
        $.datetimepicker.setLocale($(e.currentTarget).val());
    });

    $('#datetimepicker').datetimepicker({
        dayOfWeekStart : 1,
        lang:'en',
        disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
        startDate:	'1986/01/05'
    });
    $('#datetimepicker').datetimepicker({value:'2015/04/15 05:03',step:10});

    $('.some_class').datetimepicker();

    $('#default_datetimepicker').datetimepicker({
        formatTime:'H:i',
        formatDate:'d.m.Y',
        //defaultDate:'8.12.1986', // it's my birthday
        defaultDate:'+03.01.1970', // it's my birthday
        defaultTime:'10:00',
        timepickerScrollbar:false
    });

    $('#datetimepicker10').datetimepicker({
        step:5,
        inline:true
    });
    $('#datetimepicker_mask').datetimepicker({
        mask:'9999/19/39 29:59'
    });

    $('#datetimepicker1').datetimepicker({
        datepicker:false,
        format:'H:i',
        step:5
    });
    $('#datetimepicker2').datetimepicker({
        yearOffset:222,
        lang:'ch',
        timepicker:false,
        format:'d/m/Y',
        formatDate:'Y/m/d',
        minDate:'-1970/01/02', // yesterday is minimum date
        maxDate:'+1970/01/02' // and tommorow is maximum date calendar
    });
    $('#datetimepicker3').datetimepicker({
        inline:true
    });
    $('#datetimepicker4').datetimepicker();
    $('#open').click(function(){
        $('#datetimepicker4').datetimepicker('show');
    });
    $('#close').click(function(){
        $('#datetimepicker4').datetimepicker('hide');
    });
    $('#reset').click(function(){
        $('#datetimepicker4').datetimepicker('reset');
    });
    $('#datetimepicker5').datetimepicker({
        datepicker:false,
        allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00'],
        step:5
    });
    $('#datetimepicker6').datetimepicker();
    $('#destroy').click(function(){
        if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
            $('#datetimepicker6').datetimepicker('destroy');
            this.value = 'create';
        }else{
            $('#datetimepicker6').datetimepicker();
            this.value = 'destroy';
        }
    });
    var logic = function( currentDateTime ){
        if (currentDateTime && currentDateTime.getDay() == 6){
            this.setOptions({
                minTime:'11:00'
            });
        }else
            this.setOptions({
                minTime:'8:00'
            });
    };
    $('#datetimepicker7').datetimepicker({
        onChangeDateTime:logic,
        onShow:logic
    });
    $('#datetimepicker8').datetimepicker({
        onGenerate:function( ct ){
            $(this).find('.xdsoft_date')
                    .toggleClass('xdsoft_disabled');
        },
        minDate:'-1970/01/2',
        maxDate:'+1970/01/2',
        timepicker:false
    });
    $('#datetimepicker9').datetimepicker({
        onGenerate:function( ct ){
            $(this).find('.xdsoft_date.xdsoft_weekend')
                    .addClass('xdsoft_disabled');
        },
        weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
        timepicker:false
    });
    var dateToDisable = new Date();
    dateToDisable.setDate(dateToDisable.getDate() + 2);
    $('#datetimepicker11').datetimepicker({
        beforeShowDay: function(date) {
            if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
                return [false, ""]
            }

            return [true, ""];
        }
    });
    $('#datetimepicker12').datetimepicker({
        beforeShowDay: function(date) {
            if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
                return [true, "custom-date-style"];
            }

            return [true, ""];
        }
    });
    $('#datetimepicker_dark').datetimepicker({theme:'dark'})
</script>

