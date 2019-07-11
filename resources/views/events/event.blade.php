@extends('layouts.layouts')

@section('title', 'SchedPage')

@push('styles')
    <!-- Bootstrap Core CSS -->
	<link href="calendar/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="calendar/css/sidebar-nav.min.css" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="calendar/css/fullcalendar.css" rel="stylesheet" />
    <!-- animation CSS -->
    <link href="calendar/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="calendar/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="calendar/css/megna.css" id="theme" rel="stylesheet">
    <link href="calendar/css/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="calendar/css/daterangepicker.css" rel="stylesheet">
@endpush

@section('maincontent')
	<div id="wrapper">
        <div id="page-wrapper">
            <div class="container-fluid">
                <div id ='dv_tabledb' style = 'display:none'>
                    <form method = "post" action = "{{ url('/sched/add') }}" id = "addeventForm">
                        {{ csrf_field() }}
                            <!--add event-->
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Event Name</label>
                                <input class="form-control form-white" placeholder="enter event name" type="text" name="event_name" id = 'event_name'/>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Choose Category Color</label>
                                <select class="form-control form-white" data-placeholder="Choose a category..." name="evcat_id" id = "evcat_id">
                                    @foreach($category as $cat)
                                        <option value= '{{$cat->id}}'>{{$cat->ev_category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                    <div class="col-md-12">
                        <div class="white-box">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- BEGIN MODAL -->
                
                <div class="modal fade none-border" id="my-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add Event</strong></h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Add Category -->
                <div class="modal fade none-border" id="add-new-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add Event</strong></h4>
                            </div>
                            <form method = "post" action = "{{ url('/sched/add') }}">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <!--add event-->
                                        <div class="row">
                                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                                            <div class="col-md-6">
                                                <label class="control-label">Event Name</label>
                                                <input class="form-control form-white" placeholder="enter event name" type="text" name="event_name" id = 'event_name' required/>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Start Date - End Date</label>
                                                <input type="text" onclick = "getTime()" class="form-control input-daterange-timepicker" id = 'daterange' name="daterange" value="" /> 
                                                <input type="hidden" id="start_time">
                                                <input type="hidden" id="end_time">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Choose Category Color</label>
                                                <select class="form-control form-white" data-placeholder="Choose a category..." name="evcat_id" id = "evcat_id">
                                                    @foreach($category as $cat)
                                                        <option value= '{{$cat->id}}'>{{$cat->ev_category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    <!--add event-->
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" value="AddEvent" class="btn btn-danger waves-effect waves-light save-category">Save</button>
                                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="modal fade none-border" id="add-event-cat">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add Category Event</strong></h4>
                            </div>
                            <form method = "post" action = "{{ url('/sched/add_cat') }}">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Event Category Name</label>
                                            <input class="form-control form-white" placeholder="enter category name" type="text" name="ev_category_name" id = 'ev_category_name' required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" value="AddEvent" class="btn btn-danger waves-effect waves-light save-category">Save</button>
                                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
        <nav class="navbar-fixed-bottom navbar-light bg-light">
            <div class="container-fluid">
                <div class = "col-sm-3"></div> 
                <div class = "col-sm-3"> 
                    <a href="#" data-toggle="modal" data-target="#add-new-event" class="btn btn-lg m-t-40 btn-danger btn-block ">
                        <i class="ti-plus"></i> Add Event
                    </a>
                </div>
                <div class = "col-sm-3"> 
                    <a href="#" data-toggle="modal" data-target="#add-event-cat" class="btn btn-lg m-t-40 btn-danger btn-block ">
                        <i class="ti-plus"></i> Add Event Category
                    </a>
                </div>
            </div>
        </nav>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="calendar/js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="calendar/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="calendar/js/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="calendar/js/jquery.slimscroll.js"></script>
    <!-- Calendar JavaScript -->
    <script src="calendar/js/jquery-ui.min.js"></script>
    <script src="calendar/js/moment.js"></script>
    <script src='calendar/js/fullcalendar.min.js'></script>
    <script src="calendar/js/jquery.fullcalendar.js"></script>
    <!--<script src="calendar/js/cal-init.js"></script>-->
    <!--Wave Effects -->
    <script src="calendar/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="calendar/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="calendar/js/jQuery.style.switcher.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="calendar/js/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="calendar/js/bootstrap-timepicker.min.js"></script>
    <script src="calendar/js/daterangepicker.js"></script>
    <script>
        function getTime(){
            var hrs = document.getElementById("start_hourselect").value;
            var mins = document.getElementById("start_minselect").value;
            var ampms = document.getElementById("start_ampmselect").value;
            var hre = document.getElementById("end_hourselect").value;
            var mine = document.getElementById("end_minselect").value;
            var ampme = document.getElementById("end_ampmselect").value;

            var stime = hrs+":"+mins +" "+ ampms;
            var etime = hre+":"+mine +" "+ ampme;

            document.getElementById("start_time").value = stime;
            document.getElementById("end_time").value = etime;
        }
    </script>
    <script>
        $(function() {
            $('.edit-modal').on('click', function() {
                var id = $(this).data('id');
                var event_name = $(this).data('event_name');

                $('#edit_evid').val(id);
                $('#edit_event_name').val(event_name);
            });
        });
        // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        format: 'MM/DD/YYYY h:mm p',
        timePickerIncrement: 30,
        timePicker12Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'MM/DD/YYYY',
        minDate: '06/01/2015',
        maxDate: '06/30/2015',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        dateLimit: {
            days: 6
        }
    });
    </script>
    <script type="text/javascript">
        
    !function($) {
        "use strict";

        var CalendarApp = function() {
            this.$body = $("body")
            this.$calendar = $('#calendar'),
            this.$event = ('#calendar-events div.calendar-events'),
            this.$categoryForm = $('#add-new-event form'),
            this.$extEvents = $('#calendar-events'),
            this.$modal = $('#my-event'),
            this.$saveCategoryBtn = $('.save-category'),
            this.$calendarObj = null
        };


        /* on drop */
        CalendarApp.prototype.onDrop = function (eventObj, date) { 
            var $this = this;
                // retrieve the dropped element's stored Event Object
                var originalEventObject = eventObj.data('eventObject');
                var $categoryClass = eventObj.attr('data-class');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;
                if ($categoryClass)
                    copiedEventObject['className'] = [$categoryClass];
                // render the event on the calendar
                $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    eventObj.remove();
                }
        },
        /* on click on event */
        CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {
            var $this = this;
                var form = $("@if(isset($event)) <form method = 'PUT' action = '{{ route('event.edit', "+ calEvent.id +") }}' ></form> @endif");
                form.append("<input type = 'hidden' name = 'id' id = 'edit_evid' value='"+calEvent.id+"'/>");
                form.append("<label>Change event name</label>");
                form.append("<div class='input-group'><input class='form-control' id = 'event_name' name = 'event_name' type=text value='" + calEvent.title + "' /><span class='input-group-btn'> <button type='submit' class='btn btn-success waves-effect waves-light'> <i class='fa fa-check'></i> Save</button></span></div>");
                $this.$modal.modal({
                    backdrop: 'static'
                });
                $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                    $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                        return (ev._id == calEvent._id);
                    });
                    $this.$modal.modal('hide');
                });
                $this.$modal.find('form').on('submit', function () {
                    calEvent.title = form.find("input[type=text]").val();
                    $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                    $this.$modal.modal('hide');
                    return false;
                });
        },
        /* on select */
        CalendarApp.prototype.onSelect = function (start, end, allDay) {
            var $this = this;
                $this.$modal.modal({
                    backdrop: 'static'
                });
                var form = $("#addeventForm");
                $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                    form.submit();
                });
                $this.$modal.find('form').on('submit', function () {
                    var title = form.find("input[name='event_name']").val();
                    var beginning = form.find("input[name='beginning']").val();
                    var ending = form.find("input[name='ending']").val();
                    var categoryClass = form.find("select[name='category'] option:checked").val();
                    if (title !== null && title.length != 0) {
                        $this.$calendarObj.fullCalendar('renderEvent', {
                            title: title,
                            start: start,
                            end: end,
                            allDay: false,
                            className: categoryClass
                        }, true);  
                        $this.$modal.modal('hide');
                    }
                    else{
                        alert('You have to give a title to your event');
                    }
                    return false;
                    
                });
                $this.$calendarObj.fullCalendar('unselect');
        },
        CalendarApp.prototype.enableDrag = function() {
            //init events
            $(this.$event).each(function () {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });
            });
        }
        /* Initializing */
        CalendarApp.prototype.init = function() {

            /*  Initialize the calendar  */
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var form = '';
            var today = new Date($.now());
            var defaultEvents =  [];
            
            var $this = this;
            $this.$calendarObj = $this.$calendar.fullCalendar({
                slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
                minTime: '08:00:00',
                maxTime: '19:00:00',  
                defaultView: 'month',  
                handleWindowResize: true,   
                 
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month'
                },
                events: {
                    url: '/sched/ajax'
                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
                eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }

            });

            //on new event
            this.$saveCategoryBtn.on('click', function(){
                var categoryName = $this.$categoryForm.find("input[name='event_name']").val();
                var categoryColor = $this.$categoryForm.find("select[name='evcat_id']").val();
                if (categoryName !== null && categoryName.length != 0) {
                    $this.$extEvents.append('<div class="calendar-events bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-move"></i>' + categoryName + '</div>')
                }

            });
        },

       //init CalendarApp
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
        
    }(window.jQuery),

    //initializing CalendarApp
    function($) {
        "use strict";
        $.CalendarApp.init()
    }(window.jQuery);
        </script>
@endpush