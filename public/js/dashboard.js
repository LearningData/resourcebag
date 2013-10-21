var dashboard = (function() {

    var displayDate = new Date()
    var monthsToInt = {"jan": 1, "feb": 2, "mar": 3, "apr": 4, "may": 5, "jun": 6, "jul": 7, "aug": 8, "sep": 9, "oct": 10, "nov": 11, "dec": 12}

    var timetable
    var calendarEvents
    //events
    $( "#dashboard-homework-head" ).click( function() {
        window.location.href = urlBase + "/" + getUser() + "/homework"
    })
    $( "#dashboard-timetable-head" ).click( function() {
        window.location.href = urlBase + "/" + getUser() + "/timetable"
    })
    $( "#dashboard-notices-head" ).click( function() {
        window.location.href = urlBase + "/" + getUser() + "/noticeboard"
    })
    $( "#dashboard-events-head" ).click( function( event ) {
        if ( $( event.target ).is( ".ui-datepicker-title, .ui-datepicker-title *, .ui-datepicker-header" ) ) {
            window.location.href = urlBase + "/" + getUser() + "/calendar"
        }
    })
    $( "#dashboard-timetable .header-navigation a.default-prev").click(
        function() {
            displayDate.setDate(displayDate.getDate() - 1)
            populateTimetable( displayDate )
    })
    $( "#dashboard-timetable .header-navigation a.default-next").click(
        function() {
            displayDate.setDate(displayDate.getDate() + 1)
            populateTimetable( displayDate )
    })
    fillDaysEvents = function( dateStr, selectEvent ) {
        var items = []
        $( "#dashboard-events" ).empty( )
        for ( var i = 0; i < calendarEvents.length; i++ ) {
            var dateValues = calendarEvents[i].start.split(/[-\s]/)
            eventDate = new Date(dateValues[0], dateValues[1] - 1, dateValues[2])
            if ( eventDate.getFullYear() == selectEvent.selectedYear &&
               eventDate.getMonth() == selectEvent.selectedMonth &&
               eventDate.getDate() == selectEvent.selectedDay ) {
                var eventStr = "<tr><td colSpan=\"3\">" + calendarEvents[i].description + "</td>"
                if ( calendarEvents[i].allDay == 0 ) {
                    eventStr += "<td> All Day </td></tr>"
                } else {
                    eventStr += "<td>" + prettyHour(eventDate) + "</td></tr>"
                }
                items.push(eventStr)
            }
        }
        var tableBody = $( "<tbody></tbody>")
        tableBody.append( items.join("") )
        var table = $ ( "<table class=\"table table-events\"></table>" )
        table.append( tableBody )
        $( "#dashboard-events" ).append( table )
    }

    findCurrentEvents = function( date ) {
        if (date < new Date().setHours(0,0,0,0))
            return [false]
        for ( var i = 0; i < calendarEvents.length; i++ ) {
            var dateValues = calendarEvents[i].start.split(/[-\s]/)
            eventDate = new Date(dateValues[0], dateValues[1] - 1, dateValues[2])
            if ( eventDate.getFullYear() == date.getFullYear() &&
                eventDate.getMonth() == date.getMonth() &&
                eventDate.getDate() == date.getDate()
            ) {
                return [true, ""]
            }
        }
        return [false]
    }


    var init = function() {
        populateHomework()
        populateTimetable( displayDate )
        var url = urlBase + "/service/calendar/"
        $.get( url, function(response ) {
            calendarEvents = response
            $( "#dashboard-events-head" ).datepicker({
                inline: true,
                firstDay: 0,
                onSelect: fillDaysEvents,
                beforeShowDay: findCurrentEvents,
                showOtherMonths: true,
                dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
                yearSuffix: " <h2>Events</h2>",
            })
            fillDaysEvents("", { selectedYear: displayDate.getFullYear(),
                selectedMonth: displayDate.getMonth() ,selectedDay: displayDate.getDate() })
        })

        
        populateMessages()
        populateNotices()
    }
    
    populateHomework = function() {
        var url = urlBase + "/service/homeworks/"
        $.get(url, function(response) {
            var homeworkItems = []
            var length = response.homeworks.length
            for ( var i = 0; i < length; i++ ) {
                var item = response.homeworks[i]
                var icon
                switch ( item.status ) {
                    case "0" :
                        icon = "icon-caret-right"
                    break
                    case "1" :
                        icon = "icon-pencil"
                    break
                    default: 
                        icon = "icon-eye-open"
                }
                homeworkItems.push("<li class=\"dash-brd-hv\"><a class=\"btn-icon bg-hwk " + icon + "\" href=" + urlBase + "/student/homework/edit/" + response.homeworks[i].id + "></a><p>" + response.homeworks[i].description + " (" + response.homeworks[i].subject + ")</p></li>")
            }
            var homeworkList = $( "<ul class=\"homeworkList\">")
            homeworkList.append( homeworkItems.join("") )
            $( "#dashboard-homework" ).append( homeworkList )
            $ (".box-homework .box-child").slimScroll({height:"335px"})
        })
    }

    var populateTimetable = function( date ) {
        var header = $( "#dashboard-timetable .header-navigation h3")
        header.empty()
        header.append(prettyDay(date))
        var url = urlBase + "/service/timetable/" //TODO add dates
        $.get(url, function(response) {
            var day = date.getDay()
            data = response.week[day]
            if ( timetable) {
                timetable.remove()
            }
            if ( data == undefined || data.length == 0 ) {
                timetable = $( "<div class=\"table table-timetable none\"> No Classes Today</div>")
            } else {
                timetable = $( "<table class=\"table table-timetable day\">")
                var tableRows = []
                for ( var i = 0; i < data.length; i++ ) {
                    var rowStr = "<tr><td>" + data[i].time + "</td>"
                    rowStr += "<td colSpan=3>" + timetableFunctions.getTimetableTextInline( data[i] ) + "</td></tr>"
                    tableRows.push(rowStr)
                }
                var tableBody = $( "<tbody>")
                tableBody.append( tableRows.join("") )
                timetable.append( tableBody )
            }
            $( "#dashboard-timetable" ).append( timetable )
        })
    }
    
    var populateMessages = function( date ) {
        //var url = urlBase + "/service/events/"
        //$.get(url, function(response) {
        var response = {messages: [{status: 0, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},{status: 1, sender: "P", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},{status: 1, sender: "S", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},{status: 1, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},{status: 1, sender: "S", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, 
{status: 0, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 0, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 1, sender: "P", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 1, sender: "S", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 1, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 1, sender: "S", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 0, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 0, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 1, sender: "P", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, {status: 1, sender: "S", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},
{status: 1, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},{status: 1,sender: "S", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, 
{status: 0, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},{status: 0, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},
{status: 1, sender: "P",text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},{status: 1, sender: "S", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},
{status: 1, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."},{status: 1, sender: "S", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}, 
{status: 0, sender: "ST", text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ipsum."}]}
            var items = []
            for ( var i = 0; i < response.messages.length; i++ ) {
                var msg = response.messages[i]
                var classStr = "class=" + ((msg.status == 0) ? "\"msg-unread dash-brd-hv\"" : "\"dash-brd-hv\"")
                items.push("<li " + classStr + "><div class=msg-label>" + msg.sender + "</div><p>" + msg.text + "</p></li>")
            }
            var list = $( "<ul>")
            list.append( items.join("") )
            $( "#dashboard-messages" ).append( list )
            $ (".box-messages .box-child").slimScroll({height:"335px"})
        //})

    }

    var populateNotices = function( date ) {
        var url = urlBase + "/notice/jsonNotices/"
        $.get(url, function(response) {
            var notices = response.notices
            var items = []
            if (notices[0] != undefined) {
                items.push( "<div class=\"note\"><h3>" + notices[0].text + "</h3><span>" + notices[0].text + "</span></div>" )
            }
            if ( notices[1] != undefined ) {
                items.push( "<div class=\"note\"><h3>" + notices[1].text + "</h3><span>" + notices[1].text + "</span></div>" )
            }
            if ( notices[2] != undefined ) {
                items.push( "<div class=\"note\"><h3>" + notices[2].text + "</h3><span>" + notices[2].text + "</span></div>" )
            }
            var noticeElement = $( "<div class=\"notice-home\">")
            noticeElement.append( items.join( "" ) )
            $( "#dashboard-notices" ).append( noticeElement )
            if ( noticeElement[0].children.length == 2) {
                noticeElement.addClass( "missing-child" )
            }
        })
    }

    return {
        init: init
    };
})()

