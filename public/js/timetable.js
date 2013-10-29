var timetablePage = (function() {

    //init
    var displayDate = new Date()
    var init = function() {
        if ( $( ".timetable .header" ).length > 0 ) {
            getWeekView( displayDate )
            //events
            $( ".timetable .header" ).click( function( event ) {
                window.location.href = urlBase + "/" + getUser() + "/timetable"
            })
            $( ".timetable .day-of-week" ).click( function( event ) {
                getTimetableData( $ ( this ).data().day )
                $( ".timetable .day-of-week" ).removeClass( "active" )
                $( this ).addClass( "active" )
            })
            $( ".timetable .nav .title" ).click( function( event ) {
                getWeekView( displayDate )
                $( ".timetable-day" ).removeClass( "active" )
            })
            $( ".timetable .nav .btn-prev").click( function() {
                displayDate.setUTCDate(displayDate.getUTCDate() - 7)
                getWeekView( displayDate )
                $( ".timetable-day" ).removeClass( "active" )
            })
            $( ".timetable .nav .btn-next").click( function() {
                displayDate.setUTCDate(displayDate.getUTCDate() + 7)
                getWeekView( displayDate )
                $( ".day-of-week" ).removeClass( "active" )
            })
            $( ".teacher .timetable .btn-edit").click( function() {
                $( ".teacher .timetable .table" ).toggleClass( "edit" )
            })
        }
    }

    var getTimetableData = function( day ) {
        var url = urlBase + "/service/timetable/" //TODO add dates
        $.get(url, function(response) {
            var tableHead = $( ".timetable .table .head" )
            data = response.week[day]
            if ( data == undefined ) {
                return
            }
            var timetable = $( "<table class=\"table day\">")
            var tableRows = []
            for ( var i = 0; i < data.length; i++ ) {
                var rowStr = "<tr><td>" + data[i].time.substr(0, 5) + " - " + data[i].endTime.substr(0, 5) + "</td>"
                rowStr += "<td colSpan=5>" + timetableFunctions.getTimetableTextInline( data[i] ) + "</td></tr>"
                tableRows.push(rowStr)
            }
            var tableBody = $( "<tbody>" )
            tableBody.append( tableRows.join("") )
            timetable.append( tableBody )
            timetable.prepend(tableHead)
            $( ".timetable .table" ).replaceWith( timetable )
        })
    }

    var setMainTableHeader = function ( week, firstDay ) {
        var lastDay = new Date()
        lastDay.setDate(firstDay.getUTCDate() + Object.keys(week).length)
        var header = $( ".timetable .nav .title h2" )
        header.empty()
        header.append(prettyDate(firstDay) + " - " + prettyDate(lastDay) )
        
    }

    var setWeekTableHead = function( firstDay ) {
        var tableHead = $( ".timetable .table .head" )
        var headRows = tableHead.find( ".day-of-week")
            for (var i = 0; i < headRows.length; i++ ) {
                var thisDay = new Date( firstDay )
                thisDay.setDate(thisDay.getDate() + i)
                headRows[i].textContent = dayOfWeek(thisDay)
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
                for (var i = 0; i < dayData.length; i++ ) {
                    if ( dayData[i].time == timeSlot ) {
                        rowStr += timetableFunctions.getTimetableTextBlock( dayData[i] )
                        if (getUser() != "teacher") break
                        if (dayData[i]["class-id"] == undefined) {
                            rowStr += "<span class=\"cell-icon btn-icon icon-plus\"></span>"
                        } else {
                            rowStr += "<span class=\"cell-icon btn-icon icon-remove\"></span>"
                        }
                    }
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
            firstDay.setDate(date.getDate() - date.getDay() + 1)
            setMainTableHeader( response.week, firstDay )
            var tableHead = setWeekTableHead( firstDay )
            var timetable = $( "<table class=\"table week\">")
            timetable.append( getWeekRows( response.week ) )
            timetable.prepend(tableHead)
            $( ".timetable .table" ).replaceWith( timetable )
            $( ".teacher .timetable .table.week td .cell-icon").click(function( event ) {
                event.stopPropagation()
                if ($( event.target ).hasClass("icon-remove") ) { 
                    removeSubjectClass(event.target.parentElement, event.target)
                 }
                else if ($( event.target ).hasClass("icon-plus") ) { 
                    addSubjectClass(event.target.parentElement, event.target)
                }
            })
            $( ".teacher .timetable .table.week td .subject").click(function( event ) {
                event.preventDefault()
                event.stopPropagation()
                window.location.href = urlBase + "/teacher/showClass/" + event.target.getAttribute("data-subject-id")
            })
            $( ".teacher .timetable .table.week td").click(function( event ) {
                $( ".teacher .timetable .table.week td").removeClass( "edit" )
                event.currentTarget.classList.add( "edit" )
            })
        })
    }

    var createWeekTimes = function( week ) {
        var times = {}
        for ( var day in week ) {
            for ( var i = 0; i < week[day].length; i++ ) {
                times[week[day][i].time] = week[day][i].time
            }
        }
        return times
    }
    

    var addSubjectClass = function(cell, icon) {
        $( icon ).detach()
        var cell = $( cell )
        cell.empty()
        var selectClass = $( "<select>", {
            "class": "form-control customSelect"
        })

        selectClass.append("<option value=\"\" disabled selected>Select Class</option><option value=\"1\">Class 1</option><option value=\"class 2\">Class 2</option><option>Class 3</option><option value=\"redirect\">New Class</option>")
        cell.append( selectClass )
        selectClass.change(function( event ) {
            var selected = event.target.value
            if (selected == "redirect") {
                window.location.href = urlBase + "/" + getUser() + "/newClass?thisDay=2"
                return
            }
            cell.append( "<span>" + selected + "</span>" )
            icon.classList.remove( "icon-plus" )
            icon.classList.add( "icon-remove" )
            cell.append( icon )
            $( selectClass ).remove( )
            cell.removeClass("edit")
        })
    }

    var removeSubjectClass = function( cell, icon ) {
        $( icon ).detach()
        var cell = $( cell )
        cell.empty()
        icon.classList.remove( "icon-remove" )
        icon.classList.add( "icon-plus" )
        cell.append( icon )
        cell.removeClass("edit")
    }

    return {
        init: init
    }
})()
