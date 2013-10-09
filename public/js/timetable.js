var timetablePage = (function() {

    //init
    var displayDate = new Date()
    var urlBase = window.location.origin + "/schoolbag"

    //events
    $( ".timetable-header" ).click( function( event ) {
        window.location.href = urlBase + "/" + getUser() + "/timetable"
    })
    $( ".timetable-day" ).click( function( event ) {
        getTimetableData( $ ( this ).data().day )
        $( ".timetable-day" ).removeClass( "active" )
        $( this ).addClass( "active" )
    })

    getTimetableData = function( day ) {
        var url = urlBase + "/service/timetable/" //TODO add dates
        $.get(url, function(response) {
            var tableHead = $( ".table.table-timetable .table-head" )
            if ( response.week[day] == undefined ) {
                var timetable = $( "<table class=\"table table-timetable day\">")
                timetable.prepend(tableHead)
                createTimetable.dayTableRows( timetable )
                $( ".table.table-timetable" ).replace( timetable )
                return
            }
            var timetable = createTimetable.dayTable( response.week, (day % 7))
            timetable.prepend(tableHead)
            $( ".table.table-timetable" ).replaceWith( timetable )
        })
    }

    return {

    };
})()

