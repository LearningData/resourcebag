var timetablePage = (function() {

    //init
    var displayDate = new Date()
    var init = function() {
        getWeekView( displayDate )
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
        $( ".nav-timetable-btn-prev").click( function() {
            displayDate.setUTCDate(displayDate.getUTCDate() - 7)
            getWeekView( displayDate )
            $( ".timetable-day" ).removeClass( "active" )
        })
        $( ".nav-timetable-btn-next").click( function() {
            displayDate.setUTCDate(displayDate.getUTCDate() + 7)
            getWeekView( displayDate )
            $( ".timetable-day" ).removeClass( "active" )
        })
        $( ".teacher .btn-timetable-edit").click( function() {
            $( ".teacher .table-timetable" ).toggleClass( "edit" )
        })
        $( ".btn-tmtbl .btn-return" ).click( function( event ) {
            window.location.href = urlBase + "/" + getUser() + "/homework"
        })
       
    }

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
            firstDay.setDate(date.getUTCDate() - date.getUTCDay())
            setMainTableHeader( response.week, firstDay )
            var tableHead = setWeekTableHead( firstDay )
            var timetable = $( "<table class=\"table table-timetable week\">")
            timetable.append( getWeekRows( response.week ) )
            timetable.prepend(tableHead)
            $( ".table.table-timetable" ).replaceWith( timetable )
            $( ".teacher .table.table-timetable.week td .cell-icon").click(function( event ) {
                event.stopPropagation()
                if ($( event.target ).hasClass("icon-remove") ) { 
                    removeSubjectClass(event.target.parentElement, event.target)
                 }
                else if ($( event.target ).hasClass("icon-plus") ) { 
                    addSubjectClass(event.target.parentElement, event.target)
                }
            })
            $( ".teacher .table.table-timetable.week td .subject").click(function( event ) {
                event.preventDefault()
                event.stopPropagation()
                window.location.href = urlBase + "/teacher/showClass/" + event.target.getAttribute("data-subject-id")
            })
            $( ".teacher .table.table-timetable.week td").click(function( event ) {
                console.log(event.currentTarget)
                console.log(event.target)
                $( ".teacher .table.table-timetable.week td").removeClass( "edit" )
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

    var createNewClassModalDialog = function( classes ) {
        var modal = $( "<div class=\"modal timetable fade\" id=\"newClassModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title bdr-hwk\">New Class</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"></div>" )

/*        //select subjects
        <label for="subject-id">Subject</label>
        {{ select('subject-id', subjects, 'using': ['id', 'name'],
                'emptyText': 'Please, choose one subject') }}
        var options= ["<option value=\"\" disabled=\"disabled\"> Class:</option>"]
        for ( var i = 0; i < classes.length; i++ ) {
            options.push("<option value=" + classes[i].id + ">" + classes[i].subject + "</option>")
        }
        var selectClass = $( "<select>", {
            name: "classList-id",
            id: "classList-id",
            "class": "form-control customSelect",
            required: "required",
            onchange: "return getEnableDays(this)"
        })
        selectClass.append( options.join("") )
        modalBody.append( selectClass )

*/
        var yearInput = $ ( "<input>", {
            type: "text",
            "class": "form-control",
            placeholder: "Year:",
            name: "year",
            id: "year",
            required: "required"
        })
        modalBody.append( yearInput )
        var roomInput = $ ( "<input>", {
            type: "text",
            "class": "form-control",
            placeholder: "Room:",
            name: "room",
            id: "room",
            required: "required"
        })
        modalBody.append( roomInput )
        var extraInput = $ ( "<input>", {
            type: "text",
            "class": "form-control",
            placeholder: "Extra-Ref:",
            name: "extra-ref",
            required: "required"
        })
        modalBody.append( extraInput )
        var hiddenInput = $ ( "<input>", {
            type: "hidden",
            name: "schyear",
            value: "2014" //TODO get year
        })
        modalBody.append( extraInput )

       var hiddenInput = $ ( "<input>", {
            style: "display: none",
            type: "checkbox",
            name: "day/name",
            value: "TimeSlotId" //TODO get year
        })

        //buttons
        var send = $( "<input>", {
            "class": "btn",
            type: "submit",
            value: "save"
        })
        var cancel = $( "<button>", {
            type: "button",
            "class": "btn",
            "data-dismiss": "modal",
            html: "Cancel"
        })

        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append( send )
        modalFooter.append( cancel )

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"modal-timetable modal-content\"></div>" )
        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )

        var form = $( "<form class=\"form-timetable\">", {
            method: "post",
            action: urlBase + "/teacher/createClass"
        })
        modalContent.appendTo( form )
        form.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "body" )
    }


    return {
        init: init
    }
})()

