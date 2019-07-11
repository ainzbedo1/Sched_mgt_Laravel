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
        var form = $("@if(isset($event)) <form method = 'PUT' action = '{{ route('event.edit', "+calEvent.id+") }}' ></form> @endif");
        form.append("<input type = 'hidden' name = 'id' id = 'edit_evid' value='"+calEvent.id+"'/>");
        form.append("<label>Change event name</label>");
        form.append("<div class='input-group'><input class='form-control' name = 'event_name' type=text value='" + calEvent.title + "' /><span class='input-group-btn'> <button type='submit' class='btn btn-success waves-effect waves-light'> <i class='fa fa-check'></i> Save</button></span></div>");
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
    this.enableDrag();

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
            right: 'month,agendaWeek,agendaDay'
        },
        events: {
            url: '/sched/ajax'
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        drop: function(date) { $this.onDrop($(this), date); },
        select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
        eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }

    });

    //on new event
    this.$saveCategoryBtn.on('click', function(){
        var categoryName = $this.$categoryForm.find("input[name='event_name']").val();
        var categoryColor = $this.$categoryForm.find("select[name='evcat_id']").val();
        if (categoryName !== null && categoryName.length != 0) {
            $this.$extEvents.append('<div class="calendar-events bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-move"></i>' + categoryName + '</div>')
            $this.enableDrag();
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