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

    init = function() {
        populateHomework()
        populateTimetable( displayDate )
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
        })
    }

    populateTimetable = function( date ) {
        var header = $( "#dashboard-timetable .header-navigation h3")
        header.empty()
        header.append(prettyDate(date))
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
    
    return {
        init: init
    };
})()

