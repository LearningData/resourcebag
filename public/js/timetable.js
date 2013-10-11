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
    $( ".nav-timetable-title" ).click( function( event ) {
        getWeekData( displayDate )
        $( ".timetable-day" ).removeClass( "active" )
    })
    $( ".nav-timetable-btn-prev").click(
        function() {
            displayDate.setUTCDate(displayDate.getUTCDate() - 7)
            getWeekData( displayDate )
    })
    $( ".nav-timetable-btn-next").click(
        function() {
            displayDate.setUTCDate(displayDate.getUTCDate() + 7)
            getWeekData( displayDate )
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

    getWeekData = function( date ) {
        var url = urlBase + "/service/timetable/" //TODO add dates
        $.get(url, function(response) {
            var firstDay = new Date( date )
            var lastDay = new Date( date )
            firstDay.setDate(date.getUTCDate() - date.getUTCDay())
            lastDay.setDate(firstDay.getUTCDate() + Object.keys(response.week).length)
            var header = $( ".nav-timetable-title h2")
            header.empty()
            header.append(prettyDate(firstDay) + " - " + prettyDate(lastDay) )
            var tableHead = $( ".table.table-timetable .table-head" )
            var headRows = tableHead.find( ".timetable-day")
            for (var i = 0; i < headRows.length; i++ ) {
                var thisDay = new Date( firstDay )
                thisDay.setDate(firstDay.getUTCDate() + parseInt(headRows[i].getAttribute("data-day")))
                headRows[i].textContent = prettyDay(thisDay)
            }
            var timetable = createTimetable.weekTable( response.week )
            timetable.prepend(tableHead)
            $( ".table.table-timetable" ).replaceWith( timetable )
        })
    }

    return {

    }
})()

