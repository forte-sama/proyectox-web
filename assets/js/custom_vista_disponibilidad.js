$(function () {
    $('#calendario_disponibilidad').fullCalendar({
        events: [
            {
                title  : '2pm - 3pm Juan Garcia',
                start  : '2016-04-04',
                end    : '2016-04-04'
            },
            {
                title  : '9am - 10am Pedro Jimenez',
                start  : '2016-04-02',
                end    : '2016-04-02'
            },
            {
                title  : '5pm - 6pm Pedro Navaja',
                start  : '2016-04-02',
                end    : '2016-04-02'
            },
            {
                title  : '1pm - 2pm Willie Colon',
                start  : '2016-04-07',
                end    : '2016-04-07'
            }
        ],
        eventClick: function(calEvent, jsEvent, view) {
            alert('Cita: ' + calEvent.title);
        }
    })
});
