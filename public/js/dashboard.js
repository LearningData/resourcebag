var dashboard = (function() {

    var urlBase = window.location.origin + "/schoolbag"
    var displayDate = new Date()
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
    $( "#dashboard-events-head" ).datepicker({
        inline: true,
        firstDay: 1,
        showOtherMonths: true,
        dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        yearSuffix: " <h2>Events</h2>"
    });
    init = function() {
        populateHomework()
        populateTimetable( displayDate )
        populateEvents()
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
    
    populateEvents = function( date ) {
        //var url = urlBase + "/service/events/"
        //$.get(url, function(response) {
            var response = {events: [{time: "09:00", event: "Fusce molestie magna risus, suscipit ullamcorper enim porttitor non."}, {time: "11:30", event: ""}, {time: "13:00", event: "Fusce molestie magna risus, suscipit ullamcorper enim porttitor non."}]}
            var items = []
            for ( var i = 0; i < response.events.length; i++ ) {
                items.push("<tr><td>" + response.events[i].event + "</td><td>" + response.events[i].time + "</td></tr>")
            }
            var tableBody = $( "<tbody></tbody>")
            tableBody.append( items.join("") )
            var table = $ ( "<table class=\"table table-events\"></table>" )
            table.append( tableBody )
            $( "#dashboard-events" ).append( table )
        //})
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

