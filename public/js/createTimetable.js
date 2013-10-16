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
            if ( classInfo.subject && classInfo.room ) {
                element.append( classInfo.subject + " | " + classInfo.room )
            } else if ( classInfo.subject ) {
                element.append( classInfo.subject )
            } else if ( classInfo.room ) {
                element.append( classInfo.room )
            }
        }
        return timetable
    }

    createWeekTable = function( data, date ) {
        var timetable = $( "<table class=\"table table-timetable week\">")
        createWeekRows( timetable, data )
        for ( var day in data ) {
            for ( var i = 0; i < data[day].length; i++ ) {
                var classInfo = data[day][i]
                var id = "#" + day + "subj" + classInfo.time.substring(0,5)
                id = id.replace(":", "")
                var element = timetable.find( id )
                if ( classInfo.subject && classInfo.room ) {
                    element.append( "<span>" + classInfo.subject + "</span>")
                    element.append( "<span>" + classInfo.room + "</span>")
                } else if ( classInfo.subject ) {
                    element.append( classInfo.subject )
                } else if ( classInfo.room ) {
                    element.append( classInfo.room )
                }
            }
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

    createWeekRows = function( timetable, data ) {
        var periods = setTimePeriods()
        var tableRows = []
        for ( var i = 0; i < periods.length - 1; i++ ) {
            var row = "<tr id=\"tt" + periods[i] + "\">"
            for ( var day in data ) {
                row += "<td id=\""+ day + "subj" + periods[i].replace(":", "") + "\"</td>"
            }
            row += "</tr>"
            tableRows.push(row)
        }
        var tableBody = $( "<tbody>")
        tableBody.append( tableRows.join("") )
        timetable.append( tableBody )
    }

    createTimetableRows = function( timetable, fullpage ) {
        var periods = setTimePeriods()
        var tableRows = []
        var colSpan = (fullpage) ? 5 : 3
        for ( var i = 0; i < periods.length - 1; i++ ) {
            var rowStr = "<tr id=\"tt" + periods[i] + "\"><td>" + periods[i] + " - " + periods[i+1] + "</td><td id=\"subj" + periods[i].replace(":", "") + "\" \" colspan=\"" + colSpan + "\"></td></tr>"
            tableRows.push(rowStr)
        }
        var tableBody = $( "<tbody>")
        tableBody.append( tableRows.join("") )
        timetable.append( tableBody )
    }
    
    return {
        dayTable: createDayTable,
        weekTable: createWeekTable,
        dayTableRows: createTimetableRows
    };
})()

