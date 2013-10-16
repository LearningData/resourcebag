var dashboard = (function() {

    var urlBase = window.location.origin + "/schoolbag"
    var displayDate = new Date()
    var monthsToInt = {"jan": 1, "feb": 2, "mar": 3, "apr": 4, "may": 5, "jun": 6, "jul": 7, "aug": 8, "sep": 9, "oct": 10, "nov": 11, "dec": 12}

    var timetable
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
    $( "#dashboard-events-head" ).click( function() {
        window.location.href = urlBase + "/" + getUser() + "/calendar"
    })
    $( "#dashboard-timetable .header-navigation a.default-prev").click(
        function() {
            displayDate.setUTCDate(displayDate.getUTCDate() - 1)
            populateTimetable( displayDate )
    })
    $( "#dashboard-timetable .header-navigation a.default-next").click(
        function() {
            displayDate.setUTCDate(displayDate.getUTCDate() + 1)
            populateTimetable( displayDate )
    })
    resetCalendarEvents = function() {
        $( "#dashboard-events-head  a.ui-datepicker-next").click(function( event ){ 
            event.stopPropagation()
            findCurrentEvents()
            resetCalendarEvents()
        })
        $( "#dashboard-events-head  a.ui-datepicker-prev").click(function( event ){ 
            event.stopPropagation()
            findCurrentEvents()
            resetCalendarEvents()
        })
        $( "#dashboard-events-head .ui-datepicker-calendar td").click(function( event ){ 
            findCurrentEvents()
            resetCalendarEvents()
            var day
            if ( event.target.tagName == "A" ) {
                day = event.target.textContent
                event.target = event.target.parentElement
            } else {
                day = event.target.firstChild.textContent
            }
            var year = event.target.getAttribute("data-year")
            var month = event.target.getAttribute("data-month")
            fillDaysEvents( new Date(year, month, day) )
        })
    }
    $( "#dashboard-events-head" ).datepicker({
        inline: true,
        firstDay: 1,
        onBeforeShow: resetCalendarEvents,
        showOtherMonths: true,
        dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        yearSuffix: " <h2>Events</h2>"
    });
    

    fillDaysEvents = function( thisDate ) {
        var url = urlBase + "/service/calendar/"
        $.get( url, function(response ) {
            var items = []
            $( "#dashboard-events" ).empty( )

            for ( var i = 0; i < response.length; i++ ) {
                eventDate = new Date(response[i].start)
                if ( eventDate.getUTCFullYear() == thisDate.getUTCFullYear() &&
                   eventDate.getUTCMonth() == thisDate.getUTCMonth() &&
                   eventDate.getUTCDate() == thisDate.getUTCDate() ) {
                    var eventStr = "<tr><td>" + response[i].description + "</td>"
                    if ( response[i].allDay == 0 ) {
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
        })
    }

    findCurrentEvents = function() {
        var url = urlBase + "/service/calendar/"
        $.get( url, function(response ) {
            for ( var i = 0; i < response.length; i++ ) {
                eventDate = new Date(response[i].start)
                $('.ui-datepicker-calendar td').not('.ui-datepicker-other-month').each(function(index, value) {
                    if ( eventDate.getUTCFullYear() == value.getAttribute("data-year") &&
                     eventDate.getUTCMonth() == value.getAttribute("data-month") &&
                     eventDate.getUTCDate() + 1 == index + 1 ) {
                        $(this).addClass( "ui-datepicker-has-event" )
                    }
                })
            }
    })
}


    init = function() {
        populateHomework()
        populateTimetable( displayDate )
        fillDaysEvents( displayDate )
        findCurrentEvents()
        resetCalendarEvents()
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
*/
    orderPanels = function() {
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
            var day = date.getUTCDay()
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
            var firstNote = $( "<div><div class=\"note\"><h3>" + notices[0].text.substring(0,15) + "</h3><span>" + notices[0].text + "</span></div></div>" )
            var items = [ "<div class=\"note\"><h3>" + notices[1].text.substring(0,15) + "</h3><span>" + notices[1].text + "</span></div>" ,
                "<div class=\"note\"><h3>" + notices[2].text.substring(0,15) + "</h3><span>" + notices[2].text + "</span></div>" ]
            var noticeElement = $( "<div class=\"notice-home\">")
            noticeElement.append( firstNote )
            var innerElement = $( "<div class=\"notice-lesser\">" )
            innerElement.append( items.join( "" ) )
            noticeElement.append( innerElement )
            $( "#dashboard-notices" ).append( noticeElement )
        })

    }

    return {
        init: init
    };
})()

