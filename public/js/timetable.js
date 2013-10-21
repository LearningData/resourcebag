var timetablePage = (function() {

    //init
    var displayDate = new Date()

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
        getWeekView( displayDate )
        $( ".timetable-day" ).removeClass( "active" )
    })
    $( ".nav-timetable-btn-prev").click(
        function() {
            displayDate.setUTCDate(displayDate.getUTCDate() - 7)
            getWeekView( displayDate )
    })
    $( ".nav-timetable-btn-next").click(
        function() {
            displayDate.setUTCDate(displayDate.getUTCDate() + 7)
            getWeekView( displayDate )
    })

    var getTimetableData = function( day ) {
        var url = urlBase + "/service/timetable/" //TODO add dates
        $.get(url, function(response) {
            var tableHead = $( ".table.table-timetable .table-head" )
            data = response.week[day]
            if ( data == undefined ) {
                return
            }
            var timetable = $( "<table class=\"table table-timetable day\">")
            var tableRows = []
            for ( var i = 0; i < data.length; i++ ) {
                var rowStr = "<tr><td>" + data[i].time + "</td>"
                rowStr += "<td colSpan=5>" + timetableFunctions.getTimetableTextInline( data[i] ) + "</td></tr>"
                tableRows.push(rowStr)
            }
            var tableBody = $( "<tbody>" )
            tableBody.append( tableRows.join("") )
            timetable.append( tableBody )
            timetable.prepend(tableHead)
            $( ".table.table-timetable" ).replaceWith( timetable )
        })
    }

    var setMainTableHeader = function ( week, firstDay ) {
        var lastDay = new Date()
        lastDay.setDate(firstDay.getUTCDate() + Object.keys(week).length)
        var header = $( ".nav-timetable-title h2" )
        header.empty()
        header.append(prettyDate(firstDay) + " - " + prettyDate(lastDay) )
        
    }

    var setWeekTableHead = function( firstDay ) {
        var tableHead = $( ".table.table-timetable .table-head" )
        var headRows = tableHead.find( ".timetable-day")
            for (var i = 0; i < headRows.length; i++ ) {
                var thisDay = new Date( firstDay )
                thisDay.setDate(firstDay.getUTCDate() + parseInt(headRows[i].getAttribute("data-day")))
                headRows[i].textContent = prettyDay(thisDay)
       }
       return tableHead
}

    var getWeekRows = function( week ) {
        var times = createWeekTimes( week )
        var tableRows = []
        for ( var timeSlot in times ) {
            var rowStr = "<tr>"
            for ( var day in week ) {
                rowStr += "<td>"
                var dayData = week[day]
                for (var i = 0; i < dayData.length; i++ )
                    if ( dayData[i].time == timeSlot ) {
                        rowStr += timetableFunctions.getTimetableTextBlock( dayData[i] )
                }
                rowStr += "</td>"
            }
            rowStr += "</tr>"
            tableRows.push( rowStr )
        }
        var tableBody = $( "<tbody>" )
        tableBody.append( tableRows.join("") )
        return tableBody
}

    var getWeekView = function( date ) {
        var url = urlBase + "/service/timetable/" //TODO add dates
        $.get(url, function(response) {
            var firstDay = new Date( date )
            firstDay.setDate(date.getUTCDate() - date.getUTCDay())
            setMainTableHeader( response.week, firstDay )
            var tableHead = setWeekTableHead( firstDay )
            var timetable = $( "<table class=\"table table-timetable\">")
            timetable.append( getWeekRows( response.week ) )
            timetable.prepend(tableHead)
            $( ".table.table-timetable" ).replaceWith( timetable )
        })
    }

    createWeekTimes = function( week ) {
        var times = {}
        for ( var day in week ) {
            for ( var i = 0; i < week[day].length; i++ ) {
                times[week[day][i].time] = week[day][i].time
            }
        }
        return times
    }


    var init = function() {
        getWeekView( displayDate )
    }

    return {
        init: init
    }
})()

