var createTimetable = (function() {

    createDayTable = function( data, day ) {
        var timetable = $( "<table class=\"table table-timetable day\">")
        createTimetableRows( timetable )
        var day
        for ( var i = 0; i < data[day].length; i++ ) {
            var classInfo = data[day][i]
            var id = "#subj" + classInfo.time.substring(0,5)
            id = id.replace(":", "")
            var element = timetable.find( id )
            element.append((classInfo.subject || "") + " | " + (classInfo.room || ""))
        }
        return timetable
    }

    //TODO fetch currect time periods
    setTimePeriods = function( day ) {
        var periods = ["09:00", "09:40", "10:20", "11:00", "12:00", "12:40", "13:30", "14:10", "14:50"]
        /*for ( var i = 0; i < day.length; i++ ) {
            periods.push( day[i].time )
        }
        periods.sort(function ( a, b ) { return a - b } )*/
        return periods
    }

    createTimetableRows = function( timetable ) {
        var periods = setTimePeriods()
        var tableRows = []
        for ( var i = 0; i < periods.length - 1; i++ ) {
            tableRows.push("<tr id=\"tt" + periods[i] + "\"><td>" + periods[i] + " - " + periods[i+1] + "</td><td id=\"subj" + periods[i].replace(":", "") + "\" colspan=\"5\"></td></tr>")
        }
        var tableBody = $( "<tbody>")
        tableBody.append( tableRows.join("") )
        timetable.append( tableBody )
    }
    
    return {
        dayTable: createDayTable,
        dayTableRows: createTimetableRows
    };
})()

