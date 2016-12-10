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

