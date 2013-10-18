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
                var eventStr = "<tr><td>" + calendarEvents[i].description + "</td>"
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


    init = function() {
        populateHomework()
        populateTimetable( displayDate )
        var url = urlBase + "/service/calendar/"
        $.get( url, function(response ) {
            calendarEvents = response
            $( "#dashboard-events-head" ).datepicker({
                inline: true,
                firstDay: 1,
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
        orderPanels()
    }
    
/*    orderPanels = function() {
        var pnlHomework = $( "#dashboard-homework-box" )
        var pnlTimetable = $( "#dashboard-timetable-box" )
        var pnlMessages = $( "#dashboard-messages-box" )
        var pnlEvents = $( "#dashboard-events-box" )
        var pnlNotices = $( "#dashboard-notices-box" )

        pnlTimetable.addClass("col-md-8")
        pnlHomework.addClass( "col-md-4" )
        pnlMessages.addClass("col-md-4")
        pnlEvents.addClass("col-md-4")
        pnlNotices.addClass("col-md-4")
    
    }
*/    orderPanels = function() {
        //TODO add order and size to users customisations
        var pnlHomework = $( "#dashboard-homework-box" )
        var pnlTimetable = $( "#dashboard-timetable-box" )
        var pnlEvents = $( "#dashboard-events-box" )
        var pnlMessages = $( "#dashboard-messages-box" )
        var pnlNotices = $( "#dashboard-notices-box" )
        var container = $( ".dashboard-page" )[0]
        var width = container.clientWidth
        var mediaWidth = document.documentElement.clientWidth
        var maxCols = 9
        var largeX = 6, largeY = 4
        var normalX = 3, normalY = 3
        if (mediaWidth < 768 ) {
            maxCols = 1
            pnlTimetable.attr({"data-row": 1, "data-col": 1, "data-sizex": 1, "data-sizey": 5})
            pnlNotices.attr({"data-row": 5, "data-col": 1, "data-sizex": 1, "data-sizey": 3})
            pnlEvents.attr({"data-row": 8, "data-col": 1, "data-sizex": 1, "data-sizey": 3})
            pnlHomework.attr({"data-row": 11, "data-col": 1, "data-sizex": 1, "data-sizey": 3})
            pnlMessages.attr({"data-row": 14, "data-col": 1, "data-sizex": 1, "data-sizey": 3})
        } else {
            pnlTimetable.attr({"data-row": 1, "data-col": 1, "data-sizex": 6, "data-sizey": 4})
            pnlNotices.attr({"data-row": 5, "data-col": 4, "data-sizex": 3, "data-sizey": 3})
            pnlEvents.attr({"data-row": 4, "data-col": 1, "data-sizex": 3, "data-sizey": 3})
            pnlHomework.attr({"data-row": 1, "data-col": 4, "data-sizex": 3, "data-sizey": 3})
            pnlMessages.attr({"data-row": 5, "data-col": 1, "data-sizex": 3, "data-sizey": 3})
        } 
        $( ".gridster ul" ).gridster({
            widget_margins: [5, 5],
            widget_base_dimensions: [width/maxCols - 10, 385 / 3],
            max_cols: maxCols,
        }).data( "gridster" ).disable();
    }
    populateHomework = function() {
        var url = urlBase + "/service/homeworks/"
        $.get(url, function(response) {
            var homeworkItems = []
            for ( var i = 0; i < response.homeworks.length; i++ ) {
                homeworkItems.push("<a href=" + urlBase + "/student/homework/edit/" + response.homeworks[i].id + "><li><p>" + response.homeworks[i].description + " (" + response.homeworks[i].subject + ")</p></li></a>")
            }
            var homeworkList = $( "<ul class=\"homeworkList\">")
            homeworkList.append( homeworkItems.join("") )
            $( "#dashboard-homework" ).append( homeworkList )
            $ (".box-homework .box-child").slimScroll({height:"335px"})
        })
    }

    populateTimetable = function( date ) {
        var header = $( "#dashboard-timetable .header-navigation h3")
        header.empty()
        header.append(prettyDay(date))
        var url = urlBase + "/service/timetable/" //TODO add dates
        $.get(url, function(response) {
            var day = date.getDay()
            if ( response.week[day] == undefined ) {
                timetable.empty()
                createTimetable.dayTableRows( timetable )
                return
            }
            if ( timetable) {
                timetable.remove()
            }
            timetable = createTimetable.dayTable( response.week, day)
            $( "#dashboard-timetable" ).append( timetable )
        })
    }
    

    populateMessages = function( date ) {
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
                items.push("<li " + ((msg.status == 0) ? "class=\"msg-unread\"" : "") + "><div class=msg-label>" + msg.sender + "</div><p>" + msg.text + "</p></li>")
            }
            var list = $( "<ul>")
            list.append( items.join("") )
            $( "#dashboard-messages" ).append( list )
            $ (".box-messages .box-child").slimScroll({height:"335px"})
        //})

    }

    populateNotices = function( date ) {
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

