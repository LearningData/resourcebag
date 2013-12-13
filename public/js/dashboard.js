var dashboard = (function() {

    var displayDate = new Date()
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
    nextThreeEvents = function() {
        var items = []
        $( "#dashboard-events" ).empty( )
        for ( var i = 0; i < calendarEvents.length; i++ ) {
            var eventDate = moment(calendarEvents[i].start)
            if ( eventDate >= moment()) {
                var eventStr = "<tr class='event-details' data-index=" + i + "><td colSpan=\"3\">" + calendarEvents[i].title + "</td>"
                eventStr += "<td colSpan=2>" + moment(eventDate).format("ddd Do MMM") + "<br/>"
                if ( calendarEvents[i].allDay == 0 ) {
                    eventStr += "All Day"
                } else {
                    eventStr += moment(eventDate).format("hh:mm")
                }
                eventStr += "</td></tr>"
                items.push(eventStr)
                if (items.length == 3) break
            }
        }
        var tableBody = $( "<tbody></tbody>")
        tableBody.append( "<tr><td class=\"single-date-cell\" colSpan=5> " +
            _t("upcoming-events") )
        tableBody.append( items.join("") )
        var table = $ ( "<table class=\"table table-events\"></table>" )
        table.append( tableBody )
        $( "#dashboard-events" ).append( table )
        $(".table-events tr.event-details").click(function(event) {
            console.log(event.currentTarget,$(event.currentTarget).data().index)
            createEditEventDialog(calendarEvents[$(event.currentTarget).data().index])
            $("#createEditEventModal").modal("show")
        })
    }
    fillDaysEvents = function( dateStr ) {
        var selectDate = moment()
        var items = []
        $( "#dashboard-events" ).empty( )
        for ( var i = 0; i < calendarEvents.length; i++ ) {
            var eventDate = moment(calendarEvents[i].start)
            if ( eventDate.isSame(dateStr, "day") ) {
                var eventStr = "<tr><td colSpan=\"3\">" + calendarEvents[i].title + "</td>"
                if ( calendarEvents[i].allDay == 0 ) {
                    eventStr += "<td> All Day </td></tr>"
                } else {
                    eventStr += "<td>" + moment(eventDate).format("hh:mm") + "</td></tr>"
                }
                items.push(eventStr)
            }
        }
        var tableBody = $( "<tbody></tbody>")
        tableBody.append( "<tr><td class=\"single-date-cell\" colSpan=4> " +
            moment(selectDate).format("ddd MMM Do YYYY")  + " </td></tr>" )
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
            var eventDate = moment(calendarEvents[i].start)
            if ( eventDate.isSame(date, "day")) {
                return [true, ""]
            }
        }
        return [false]
    }


    var init = function() {
        populateHomework()
        populateTimetable( displayDate )
        populateEvents()
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
                    titleTip = "Edit Homework"
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
                "<a  href=\"" + urlBase + "/student/homework/start/" +
                homework[i].id + "\">" + btnIcon + "<p>" +
                homework[i].title + " (" + homework[i].subject +
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
                    urlSegment = "review"
                break
                default:
                    continue
            }
            homeworkItems.push("<li class='ld-tooltip'><a href=" + urlBase + "/teacher/homework/" + urlSegment +"/" + homework[i].id + "><span title=\"" + titleTip + "\" class=\"btn-icon bg-hwk " + icon + "\" data-placement='left auto' data-toggle='tooltip'></span><p>" + homework[i].title + " (" + homework[i].subject + ")</p></a></li>")
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
                    var rowStr = "<tr"
                    if (data[i].subject != "" && data[i]['class-id'] == undefined) {
                        rowStr += " class='break' "
                    }
                    rowStr += ">"
                    rowStr += "<td>" + data[i].time.substr(0,5) + " - " + data[i].endTime.substr(0, 5) + "</td>"
                    rowStr += "<td colSpan=3>" + timetableFunctions.getTimetableTextInline( data[i] ) + "</td></tr>"
                    tableRows.push(rowStr)
                }
                var tableBody = $( "<tbody>")
                tableBody.append( tableRows.join("") )
                timetable.append( tableBody )
            }
            $( "#dashboard-timetable-contents" ).append( timetable )
            //fix table heigh for dashboard
            var rowCount = tableRows.length -2 //subtract break tables
            var height = parseInt($( "#dashboard-timetable-box" ).css("height"))
            height -= parseInt($( "#dashboard-timetable-box .ld-box-head" ).css("height"))
            height -= parseInt($( "#dashboard-timetable-box .ld-box-child .header-navigation" ).css("height"))
            height -= (2 * parseInt($( "#dashboard-timetable-box .table tr.break td" ).css("height")))
            height /= rowCount
            $( "#dashboard-timetable-box .table tr:not('.break') td" ).css({height: height -1})
        })
    }

    function populateEvents() {
        var url = urlBase + "/service/calendar/"
        $.get( url, function(response ) {
            response.sort(function(a, b) {
                if (moment(a["start"]).isBefore(moment(b["start"]), 'day'))
                    return -1
                if (moment(a["start"]).isAfter(moment(b["start"]), 'day'))
                    return 1
                return 0
            })
            calendarEvents = response
            $( "#dashboard-events-head" ).datepicker({
                inline: true,
                firstDay: 1,
                onSelect: fillDaysEvents,
                beforeShowDay: findCurrentEvents,
                showOtherMonths: true,
                dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S']
            })
            $("<h2><span class='custom-icon-events'></span>Events</h2>").prependTo($(".dashboard .ld-box.ld-events .ld-box-head .ui-datepicker-header .ui-datepicker-title"))
            upcomingEvents()
        })
    }
    upcomingEvents = function() {
        var items = []
        $( "#dashboard-events" ).empty( )
        for ( var i = 0; i < calendarEvents.length; i++ ) {
            var eventDate = moment(calendarEvents[i].start)
            if ( eventDate >= moment()) {
                var eventStr = "<tr class='event-details' data-index=" + i + "><td colSpan=\"3\">" + calendarEvents[i].title + "</td>"
                eventStr += "<td colSpan=2>" + moment(eventDate).fromNow()
                eventStr += "</td></tr>"
                items.push(eventStr)
            }
        }
        var tableBody = $( "<tbody></tbody>")
        tableBody.append( items.join("") )
        var table = $ ( "<table class=\"table table-events\"></table>" )
        table.append( tableBody )
        $( "#dashboard-events" ).append( table )
        $(".table-events tr.event-details").click(function(event) {
            console.log(event.currentTarget,$(event.currentTarget).data().index)
            createEditEventDialog(calendarEvents[$(event.currentTarget).data().index])
            $("#createEditEventModal").modal("show")
        })
        $("#dashboard-events").slimScroll({height:"200px"})
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
            $(".dashboard .messages .ld-box-child").slimScroll({height:"335px"})
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
                //cutText(item, $( item ).find( "p")[0])
            })
        })
    }
    var createEditEventDialog = function(data) {
        $("#createEditEventModal").remove()
        var modal = $("<div class=\"modal fade\" id=\"createEditEventModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">")
        var modalHeader = $("<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h2 class=\"modal-title\">" + data.title + "</h2></div>")
        var modalBody = $("<div class=\"modal-body\"></div>")
        if (data.end == null) data.end = data.start
        modalBody.append("<span class=\"icon-calendar\"></span><span class=\"modal-value\">" + moment(data.start).format("ddd, MMMM D, YYYY, h:mm a") + " - </span><span class=\"modal-value\">" + moment(data.end).format("ddd, MMMM D, YYYY, h:mm a") + "</span>")
        modalBody.append("<hr/>")
        modalBody.append("<span class=\"icon-map-marker\"></span><span class=\"modal-value\">" + data.location + "</span>")
        modalBody.append("<hr/>")
        modalBody.append("<span class=\"icon-phone\"></span><span class=\"modal-value\">" + data.contact + "</span")
        modalBody.append("<span class=\"icon-link\"></span><span class=\"modal-value\"> <a href="+ data.url +" target=\"_blank\">" + data.url + "</a></span>")
        modalBody.append("<hr/>")
        modalBody.append("<span class=\"icon-align-left\"></span> <p class=\"value\">" + data.description + "</p>")

        /*var edit = $("<button>", {
            type : "button",
            "class" : "btn btn-sm",
            html : "Edit"
        })
        var cancel = $("<button>", {
            type : "button",
            "class" : "btn btn-cancel btn-sm",
            "data-dismiss" : "modal",
            html : "Cancel"
        })
        var del = $("<button>", {
            type : "button",
            "class" : "btn-delete",
            html : "<span class=\"icon-trash\"></span> Delete"
        })*/

        var modalFooter = $("<div class=\"modal-footer\"></div>")
        /*modalFooter.append("<hr/>")
        modalFooter.append(edit)
        modalFooter.append(cancel)
        modalFooter.append(del)
        */var modalDialog = $("<div class=\"modal-dialog\"></div>")

        var modalContent = $("<div class=\"modal-calendar modal-content\"></div>")
        modalContent.append(modalHeader)
        modalContent.append(modalBody)
        modalContent.append(modalFooter)

        modalContent.appendTo(modalDialog)
        modalDialog.appendTo(modal)
        modal.appendTo("li.ld-events")

        /*edit.click(function() {
            window.location.href = urlBase + "/" + getUser() + "/calendar/edit/" + data.id
        })
        del.click(function() {
            window.location.href = urlBase + "/calendar/remove/" + data.id
        })*/
    }

    return {
        init: init
    };
})()

