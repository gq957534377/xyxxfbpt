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