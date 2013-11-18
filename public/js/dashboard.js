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
    $( "#dashboard-timetable-contents .header-navigation a.default-prev").click(
        function() {
            displayDate.setDate(displayDate.getDate() - 1)
            populateTimetable( displayDate )
    })
    $( "#dashboard-timetable-contents .header-navigation a.default-next").click(
        function() {
            displayDate.setDate(displayDate.getDate() + 1)
            populateTimetable( displayDate )
    })
    fillMonthEvents = function( year, month ) {
        var items = []
        $( "#dashboard-events" ).empty( )
        for ( var i = 0; i < calendarEvents.length; i++ ) {
            var dateValues = calendarEvents[i].start.split(/[-\s]/)
            eventDate = new Date(dateValues[0], dateValues[1], dateValues[2])
            if ( eventDate.getFullYear() == year &&
               eventDate.getMonth() == month ) {
                var eventStr = "<tr><td colSpan=\"3\">" + calendarEvents[i].description + "</td>"
                eventStr += "<td colSpan=2>" + getDisplayDate(eventDate, "D jS") + "<br/>"
                if ( calendarEvents[i].allDay == 0 ) {
                    eventStr += "All Day"
                } else {
                    eventStr += prettyHour(eventDate)
                }
                eventStr += "</td></tr>"
                items.push(eventStr)
            }
        }
        var tableBody = $( "<tbody></tbody>")
        tableBody.append( items.join("") )
        var table = $ ( "<table class=\"table table-events\"></table>" )
        table.append( tableBody )
        $( "#dashboard-events" ).append( table )
    }
    fillDaysEvents = function( dateStr ) {
        var selectDate = new Date(dateStr)
        var items = []
        $( "#dashboard-events" ).empty( )
        for ( var i = 0; i < calendarEvents.length; i++ ) {
            var dateValues = calendarEvents[i].start.split(/[-\s]/)
            eventDate = new Date(dateValues[0], dateValues[1] - 1, dateValues[2])
            if ( eventDate.getFullYear() == selectDate.getFullYear() &&
               eventDate.getMonth() ==  selectDate.getMonth() &&
               eventDate.getDate() == selectDate.getDate() ) {
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
        tableBody.append( "<tr><td class=\"single-date-cell\" colSpan=4> " + getDisplayDate(eventDate, "D jS") + " " + prettyDateMonth(eventDate) + " " + eventDate.getFullYear() + " </td></tr>" )
        tableBody.append( items.join("") )
        tableBody.append( "<tr><td class=\"single-date-cell\" colSpan=4><a class=\"btn\" href=\"" + urlBase + "/" + getUser() + "/calendar/new\">New Event</a></td></tr>" )
        var table = $ ( "<table class=\"table table-events\"></table>" )
        table.append( tableBody )
        $( "#dashboard-events" ).append( table )
    }

    findCurrentEvents = function( date ) {
       // if (date < new Date().setHours(0,0,0,0))
       //     return [false]
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
                firstDay: 1,
                onSelect: fillDaysEvents,
                onChangeMonthYear: fillMonthEvents,
                beforeShowDay: findCurrentEvents,
                showOtherMonths: true,
                dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
                yearSuffix: " <h2>Events</h2>"
            })
            fillMonthEvents(displayDate.getFullYear(), displayDate.getMonth()+1)
        })

        
        populateMessages()
        populateNotices()
    }

    var studentHomeworkList = function(homework) {
        homework.sort(function(a, b) {
            if (a["due-date"] < b["due-date"] ) return -1
            if (a["due-date"] > b["due-date"] ) return 1
            return 0
        })
        var homeworkItems = []
        var length = homework.length
        for ( var i = 0; i < length; i++ ) {
            var item = homework[i]
            var icon
            var titleTip
            switch ( item.status ) {
                case "0" :
                    icon = "icon-caret-right",
                    titleTip = "Start homework"
                break
                case "1" :
                    icon = "icon-pencil",
                    titleTip = "Edit Howework"
                break
                default: 
                    continue
            }
            
            var dueDate = new Date(item["due-date"])
            var btnIcon = "<span title=\"" + titleTip + "\" class=\"btn-icon " 
                + icon + 
                "\" data-placement='left auto' data-toggle='tooltip'></span>"
            var overdue = dueDate < Date.now() ? "overdue" : ""
            var due = "<p class=\"due-date " + overdue + "\">" + 
                "<span class=\"due-date-icon\" title=\"Overdue\"" + 
                "data-placement='left auto' data-toggle='tooltip'>" + 
                "</span>    " + moment(dueDate).fromNow() + 
                "</p>"
            homeworkItems.push("<li class=\"ld-tooltip\">" + 
                "<a  href=\"" + urlBase + "/student/homework/edit/" + 
                homework[i].id + "\">" + btnIcon + "<p>" + 
                homework[i].description + " (" + homework[i].subject + 
                ")</p>" + due + "</a></li>"
            )
        }
        return homeworkItems
    }
    var teacherHomeworkList = function(homework) {
        var homeworkItems = []
        var length = homework.length
        for ( var i = 0; i < length; i++ ) {
            var item = homework[i]
            var urlSegment
            var icon
            switch ( item.status ) {
                case "2" :
                    icon = "icon-pencil"
                    titleTip = "View howework"
                    urlSegment = "show"
                break
                default: 
                    continue
            }
            homeworkItems.push("<li class='ld-tooltip'><a href=" + urlBase + "/teacher/homework/" + urlSegment +"/" + homework[i].id + "><span title=\"" + titleTip + "\" class=\"btn-icon bg-hwk " + icon + "\" data-placement='left auto' data-toggle='tooltip'></span><p>" + homework[i].description + " (" + homework[i].subject + ")</p></a></li>")
        }
        return homeworkItems
    }

    var populateHomework = function() {
        var url = urlBase + "/service/homeworks/"
        $.get(url, function(response) {
            var homeworkItems = getUser() == "student" ? studentHomeworkList(response.homeworks) : teacherHomeworkList(response.homeworks)
            var homeworkList = $( "<ul>")
            homeworkList.append( homeworkItems.join("") )
            $( "#dashboard-homework-contents" ).append( homeworkList )
            $('.ld-tooltip').tooltip({selector: "[data-toggle=tooltip]", container: ".ld-tooltip"})
            $ (".dashboard .ld-homework.ld-box .ld-box-child").slimScroll({height:"335px"})
        })
    }

    var populateTimetable = function( date ) {
        var header = $( "#dashboard-timetable-contents .header-navigation h3")
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
                timetable = $( "<div class=\"table none\"> No Classes Today</div>")
            } else {
                timetable = $( "<table class=\"table day\">")
                var tableRows = []
                for ( var i = 0; i < data.length; i++ ) {
                    if (data[i].time == "11:00:00") {
                        var rowStr = "<tr class=\"break\"><td> 10:45 - 11:00 </td>"
                        rowStr += "<td colSpan=3> Break </td></tr>"
                        tableRows.push(rowStr)
                    } else if (data[i].time == "12:40:00") {
                        var rowStr = "<tr class=\"break\"><td> 12:20 - 12:40 </td>"
                        rowStr += "<td colSpan=3> Lunch </td></tr>"
                        tableRows.push(rowStr)
                    }
                    var rowStr = "<tr><td>" + data[i].time.substr(0,5) + " - " + data[i].endTime.substr(0, 5) + "</td>"
                    rowStr += "<td colSpan=3>" + timetableFunctions.getTimetableTextInline( data[i] ) + "</td></tr>"
                    tableRows.push(rowStr)
                }
                var tableBody = $( "<tbody>")
                tableBody.append( tableRows.join("") )
                timetable.append( tableBody )
            }
            $( "#dashboard-timetable-contents" ).append( timetable )
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
                var classStr = "class=" + ((msg.status == 0) ? "\"unread\"" : "")
                items.push("<li " + classStr + "><div class=label>" + msg.sender + "</div><p>" + msg.text + "</p></li>")
            }
            var list = $( "<ul>")
            list.append( items.join("") )
            $( "#dashboard-messages-contents" ).append( list )
            $ (".dashboard .messages .ld-box-child").slimScroll({height:"335px"})
        //})
    }

    var populateNotices = function( date ) {
        var url = urlBase + "/notice/jsonNotices/"
        $.get(url, function(response) {
            var notices = response.notices
            var items = []
            if (notices[0] != undefined) {
                items.push( "<div class=\"note " + (notices[0].category || "general") + "\"><span class=\"ld-notice-icon\"></span><p>" + notices[0].text + "</p></div>" )
            }
            if ( notices[1] != undefined ) {
                items.push( "<div class=\"note " + (notices[1].category || "general") + "\"><span class=\"ld-notice-icon\"></span><p>" + notices[1].text + "</p></div>" )
            }
            if ( notices[2] != undefined ) {
                items.push( "<div class=\"note " + (notices[2].category || "general") + "\"><span class=\"ld-notice-icon\"></span><p>" + notices[2].text + "</p></div>" )
            }
            $( "#dashboard-notices" ).append( items.join( "" ) )
            $( "#dashboard-notices .note" ).each(function(index, item) {
                cutText(item, $( item ).find( "p")[0])
            })
        })
    }

    return {
        init: init
    };
})()

