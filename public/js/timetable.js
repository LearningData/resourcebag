var timetablePage = (function() {
    var displayDate = new Date()
    var displayDay = displayDate.getDay()
    var init = function() {
        refreshTables()
        //events
        $( ".ld-timetable header" ).click( function( event ) {
            window.location.href = urlBase + "/" + getUser() + "/timetable"
        })
        $( ".ld-timetable .day-of-week" ).click( function( event ) {
            getSingleDayData( $ ( this ).data().day )
            $( ".ld-timetable .day-of-week" ).removeClass( "active" )
            $( this ).addClass( "active" )
        })
        $( ".ld-timetable .ld-responsive-sm .nav .title" ).click( function( event ) {
            refreshTables()
            $( ".ld-timetable .day-of-week" ).removeClass( "active" )
        })
        $( ".ld-timetable .ld-responsive-sm .nav .btn-prev" ).click( function() {
            displayDate.setUTCDate(displayDate.getUTCDate() - 7)
            refreshTables()
            $( ".ld-timetable .day-of-week" ).removeClass( "active" )
        })
        $( ".ld-timetable .ld-responsive-sm .nav .btn-next" ).click( function() {
            displayDate.setUTCDate(displayDate.getUTCDate() + 7)
            refreshTables()
            $( ".day-of-week" ).removeClass( "active" )
        })
        $( ".ld-timetable .ld-responsive-xs .nav .btn-prev" ).click( function() {
            displayDay -= 1
            if (displayDay < 0) {
                displayDate.setUTCDate(displayDate.getUTCDate() - 7)
                displayDay = 6
            }
            refreshTables()
        })
        $( ".ld-timetable .ld-responsive-xs .nav .btn-next" ).click( function() {
            displayDay += 1
            if (displayDay > 6) {
                displayDate.setUTCDate(displayDate.getUTCDate() + 7)
                displayDay = 1
            }
            refreshTables()
        })
        $( ".teacher .ld-timetable .btn-edit").click( function() {
        //    $( ".teacher .ld-timetable .table" ).toggleClass( "edit" )
        })
    }

    var refreshTables = function() {
        getWeekView(displayDate)
        getSingleDayData(displayDay, true)
    }

    var getSingleDayData = function( day, hidden ) {
        var url = urlBase + "/service/timetable/" //TODO add dates
        $.get(url, function(response) {
            data = response.week[day]
            if ( data == undefined ) {
                return
            }
            var timetable = $( "<table class=\"table day\">")
            var tableRows = []
            for ( var i = 0; i < data.length; i++ ) {
                var rowStr = "<tr"
                    if (data[i].subject != "" && data[i]['class-id'] == undefined) {
                        rowStr += " class='break' "
                    }
                    rowStr += ">"
                    rowStr += "<td colspan=2>" + data[i].time.substr(0, 5) + " - " + data[i].endTime.substr(0, 5) + "</td>"
                rowStr += "<td colspan=4>" + timetableFunctions.getTimetableTextInline( data[i] ) + "</td></tr>"
                tableRows.push(rowStr)
            }
            var tableBody = $( "<tbody>" )
            tableBody.append( tableRows.join("") )
            timetable.append( tableBody )
            if (hidden) {
                var header = $( ".ld-timetable .ld-responsive-xs .nav .title h2" )
                var date = new Date(displayDate)
                date.setDate(date.getDate() - date.getDay() + day)
                header.empty()
                header.append(prettyDay(date))

                timetable.append( tableBody )
                $( ".ld-timetable .ld-responsive-xs .table" ).replaceWith( timetable )
            } else {
                var tableHead = $( ".ld-timetable .table .head" )
                timetable.prepend(tableHead)
                $( ".ld-timetable .ld-responsive-sm .table" ).replaceWith( timetable )
            }
        })
    }

    var setMainTableHeader = function ( week, firstDay ) {
        var lastDay = new Date(firstDay)
        lastDay.setDate(lastDay.getDate() + Object.keys(week).length)
        var header = $( ".ld-timetable .ld-responsive-sm .nav .title h2" )
        header.empty()
        header.append(prettyDate(firstDay) + " - " + prettyDate(lastDay) )
        
    }

    var setWeekTableHead = function( firstDay ) {
        var tableHead = $( ".ld-timetable .table .head" )
        var headRows = tableHead.find( ".day-of-week")
            for (var i = 0; i < headRows.length; i++ ) {
                var thisDay = new Date( firstDay )
                thisDay.setDate(thisDay.getDate() + i)
                headRows[i].textContent = dayOfWeek(thisDay)
       }
       return tableHead
    }
    function getWeekRows(week) {
        var times = createWeekTimes( week )
        var keys = Object.keys(times)
        keys.sort()
        var tableRows = []
        for ( var i = 0; i < keys.length; i++) {
            var rowStr = "<tr>"
            for ( var day in week ) {
                rowStr += "<td>"
                var dayData = week[day]
                for (var j = 0; j < dayData.length; j++ ) {
                    if (dayData[j] && dayData[j].time == keys[i] ) {
                        if (dayData[j].subject != "" && dayData[j]['class-id'] == undefined) {
                            rowStr = rowStr.substring(0,  rowStr.length-4) + "<td class='break' >"
                        }
                        rowStr += timetableFunctions.getTimetableTextBlock( dayData[j] )
                        if (getUser() != "teacher") break
                        if (dayData[j]["class-id"] == undefined) {
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
            $( ".ld-timetable .ld-responsive-sm .table" ).replaceWith( timetable )
            $( ".teacher .ld-timetable .table.week td .cell-icon" ).click(function( event ) {
                event.stopPropagation()
                if ($( event.target ).hasClass("icon-remove") ) { 
                    removeSubjectClass(event.target.parentElement, event.target)
                 }
                else if ($( event.target ).hasClass("icon-plus") ) { 
                    addSubjectClass(event.target.parentElement, event.target)
                }
            })
            $( ".ld-timetable .table.week td .class-code").click(function( event ) {
                event.preventDefault()
                event.stopPropagation()
                window.location.href = urlBase + "/" + getUser() + "/showClass/" + event.target.getAttribute("data-class-id")
            })
            $( ".teacher .ld-timetable .table.week td").click(function( event ) {
            //    $( ".teacher .ld-timetable .table.week td").removeClass( "edit" )
            //    event.currentTarget.classList.add( "edit" )
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
