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
            var response = {events: [{time: "09:00", event: "Fusce molestie magna risus, suscipit ullamcorper enim porttitor non."}, {time: "11:30", event: ""}, {time: "13:00", event: "Fusce molestie magna risus, suscipit ullamcorper enim porttitor non."}]}
            var items = []
            for ( var i = 0; i < response.events.length; i++ ) {
                items.push("<tr><td>" + response.events[i].event + "</td><td>" + response.events[i].time + "</td></tr>")
            }
            var tableBody = $( "<tbody>")
            tableBody.append( items.join("") )
            var table = $ ( "<table class=\"table table-events\"><table>" )
            table.append( tableBody )
            //$( "#dashboard-events" ).append( table )
        //})

    }

    populateNotices = function( date ) {
        var url = urlBase + "/notice/jsonNotices/"
        $.get(url, function(response) {
            var notices = response.notices
            var firstNote = $( "<div><div class=\"note\"><h3>" + notices[0].date + "</h3><span>" + notices[0].text + "</span></div></div>" )
            var items = [ "<div class=\"note\"><h3>" + notices[1].date + "</h3><span>" + notices[1].text + "</span></div>" ,
                "<div class=\"note\"><h3>" + notices[2].date + "</h3><span>" + notices[2].text + "</span></div>" ]
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

