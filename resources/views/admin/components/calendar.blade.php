@extends('admin.layouts.master')

<link href="http://cdn.rooyun.com/css/fullcalendar.css" rel="stylesheet" />
<link href="http://cdn.rooyun.com/css/bootstrap-reset.css" rel="stylesheet">
@section('content')
@section('title', '日历')


<!-- Page Content Start -->
<!-- ================== -->

<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Calendar</h3>
    </div>
    <div class="clearfix"></div>

    <div class="row m-b-30">
        <div class="col-lg-2 col-md-3">

            <h4>Created Events</h4>
            <form method="post" id="add_event_form">
                <input type="text" class="form-control new-event-form bg-white" placeholder="Add new event..." />
            </form>

            <div id='external-events' class="m-t-30">
                <h4 class="m-b-15">Draggable Events</h4>
                <div class='fc-event'>Meet John deo</div>
                <div class='fc-event'>Romantinc Dinner Date</div>
                <div class='fc-event'>Sleeping whole Day</div>
                <div class='fc-event'>Progress review</div>
                <div class='fc-event'>Coffee Meeting</div>
            </div>
            <label class="cr-styled form-label m-t-20" for='drop-remove'>
                <input type="checkbox" id='drop-remove'>
                <i class="fa"></i>
                Drop&nbsp;&&nbsp;Remove
            </label>
        </div>

        <div id='calendar' class="col-md-9 col-lg-10"></div>

    </div>
    <!-- page end-->

</div> <!-- END Wraper -->




@endsection
@section('script')
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="http://cdn.rooyun.com/js/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="http://cdn.rooyun.com/js/pace.min.js"></script>
    <script src="http://cdn.rooyun.com/js/jquery.nicescroll.js" type="text/javascript"></script>

    <script src="http://cdn.rooyun.com/js/moment.min.js"></script>
    <script src="http://cdn.rooyun.com/js/fullcalendar.min.js"></script>
    <!--dragging calendar event-->

    <script src="http://cdn.rooyun.com/js/calendar-init.js"></script>
@endsection