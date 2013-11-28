var calendarPage = (function() {
    init = function() {
        $(".ld-calendar header").click(function(event) {
            window.location.href = urlBase + "/" + getUser() + "/calendar"
        })
        $(".ld-calendar #all-day").click(function(event) {
            $(".ld-calendar .all-day-block").toggleClass("hidden")
        })

        $(".ld-calendar .btn:submit").click(function(event) {
            event.preventDefault()
            //set times
            var millsecs = $(".ld-calendar #start-time").timepicker('getSecondsFromMidnight') * 1000
            var val = new Date($(".ld-calendar #start-date").datepicker("getDate"))
            val.setTime(val.getTime() + millsecs)
            var dateStr = moment(val).format("YYYY-MM-DD hh:mm:ss")
            $(".ld-calendar #hidden-start-date").val(dateStr)
            millsecs = $(".ld-calendar #end-time").timepicker('getSecondsFromMidnight') * 1000
            val = new Date($(".ld-calendar #end-date").datepicker("getDate"))
            val.setTime(val.getTime() + millsecs)
            dateStr = moment(val).format("YYYY-MM-DD hh:mm:ss")
            $(".ld-calendar #hidden-end-date").val(dateStr)
            var form = $(".ld-calendar form")
            if (validForm(form)) {
                form.submit()
            }
        })

        //Set times for mysql format
        $(".ld-calendar #start-time, .ld-calendar #start-date").change(function(event) {
            var millsecs = $(".ld-calendar #start-time").timepicker('getSecondsFromMidnight') * 1000
            var val = new Date($(".ld-calendar #start-date").datepicker("getDate"))
            val.setTime(val.getTime() + millsecs)
            var dateStr = moment(val).format("YYYY-MM-DD hh:mm:ss")
            $(".ld-calendar #hidden-start-date").val(dateStr)
        })
        $(".ld-calendar #end-time, .ld-calendar #end-date").change(function(event) {
            var millsecs = $(".ld-calendar #end-time").timepicker('getSecondsFromMidnight') * 1000
            var val = new Date($(".ld-calendar #end-date").datepicker("getDate"))
            val.setTime(val.getTime() + millsecs)
            var dateStr = moment(val).format("YYYY-MM-DD hh:mm:ss")
            $( ".ld-calendar #hidden-end-date")[0].value = dateStr
        })
        if ($( ".ld-calendar #hidden-start-date")[0]) {
            var val = $( ".ld-calendar #hidden-start-date")[0].value.split(" ")
            if (val[0])
                $( ".ld-calendar #start-date" )[0].value = val[0]
            if (val[1])
                $( ".ld-calendar #start-time" )[0].value = val[1]
        }
        if ($( ".ld-calendar #hidden-end-date")[0]) {
            var val = $( ".ld-calendar #hidden-end-date")[0].value.split(" ")
            if (val[0])
                $( ".ld-calendar #end-date" )[0].value = val[0]
            if (val[1])
                $( ".ld-calendar #end-time" )[0].value = val[1]
        }
        var url = urlBase + "/service/calendar";
        $.get( url, function(response) {
            $('#calendar').fullCalendar({
                header : {
                    left : 'prev,next ',
                    center : 'title',
                    right : ''
                },
                dayClick : function(date, allDay, jsEvent, view) {
                    updateNewEventDialog(date)
                    $(".popover").remove()
                },
                eventClick : function(data, jsEvent, view) {
                    createEditEventDialog(data)
                    $("#createEditEventModal").modal("show")
                    return false
                },
                editable : false,
                firstDay : 1,
                center : 'prevYear',
                events : response,
                timeFormat : ''
            })
            fillAgenda(response)
        })
        $("body").popover({
            html : true,
            container : ".fc-content",
            selector: ".fc-day",
            placement : "top auto",
            content : function() {
                return $('#createNewEventPopover').html();
            }
        }).parent().on("click", "button.close", function(event) {
            var dismiss = event.currentTarget.getAttribute("data-dismiss")
            $( "." + dismiss ).remove()
        })
    }
    var fillAgenda = function(data) {
        data.sort(function(a, b) {
            allA = (a["allDay"] || 0) 
            allB = (b["allDay"] || 0) 
            if (allA < allB ) return -1
            if (allA > allB ) return 1
            return 0
        })        
      /*  data.sort(function(a, b) {
            if (a["start"] < b["start"] ) return -1
            if (a["start"] > b["start"] ) return 1
            return 0
        })*/
        agendaItems = {}
        for (var i = 0; i< data.length; i++) {
            startTime = moment(data[i].start)
            if (startTime.isSame(moment($('#calendar').fullCalendar('getDate')), 'month')) {
                getAgendaElement(data[i], startTime)
            }
        }
        var agenda = $("<div class='agenda-list'></div>")
        for (var item in agendaItems) {
            agenda.append(agendaItems[item])
        }
        $("#agenda").append(agenda)
        agenda.css("height", $(".fc-content").css("height"))
    }
    var getAgendaElement = function (data, startTime) {
        var timeStr = getAgendaTime(startTime, moment(data.end))
        agendaItems[startTime.format("DMMMYYYY")] = agendaItems[startTime.format("DMMMYYYY")] ||
            $("<div class='agenda-item'><span class='day'>" + startTime.format("ddd D MMM YYYY") + "</span></div>")
        agendaItems[startTime.format("DMMMYYYY")].append($("<span class='time'>" + timeStr + "</span>"))
        agendaItems[startTime.format("DMMMYYYY")].append($("<span>" + data.title + "</span>"))
        if (startTime.isBefore(moment(data.end), 'day')) {
            startTime.add('d', 1)
            getAgendaElement(data, startTime)
        }
    }
    var getAgendaTime = function(start, end) {
        var timeStr = _t("all-day")
        if (end && end.isSame(start, 'day'))
            timeStr = startTime.format("hh:mm a") + " - " + end.format("hh:mm a")
        return timeStr
    }
    var updateNewEventDialog = function(date) {
        $('#createNewEventPopover #event-date').empty()
        $('#createNewEventPopover #event-date').append(moment(date).format("dddd MMM DD YYYY"))
        $('#createNewEventPopover #start').val(moment(date).format("YYYY-MM-DD 00:00:00"))
        $('#createNewEventPopover #end').val(moment(date).format("YYYY-MM-DD 23:59:00"))

    }
    var createEditEventDialog = function(data) {
        $("#createEditEventModal").remove()
        var modal = $("<div class=\"modal fade\" id=\"createEditEventModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">")
        var modalHeader = $("<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h2 class=\"modal-title\">" + data.title + "</h2></div>")
        var modalBody = $("<div class=\"modal-body\"></div>")
        if (data.end == null)
            data.end = data.start
        modalBody.append("<span class=\"icon-calendar\"></span><span class=\"modal-value\">" + moment(data.start).format("ddd, MMMM D, YYYY, h:mm a") + " - </span><span class=\"modal-value\">" + moment(data.end).format("ddd, MMMM D, YYYY, h:mm a") + "</span>")
        modalBody.append("<hr/>")
        modalBody.append("<span class=\"icon-map-marker\"></span><span class=\"modal-value\">" + data.location + "</span>")
        modalBody.append("<hr/>")
        modalBody.append("<span class=\"icon-phone\"></span><span class=\"modal-value\">" + data.contact + "</span")
        modalBody.append("<span class=\"icon-link\"></span><span class=\"modal-value\"> <a href=" + data.url + " target=\"_blank\">" + data.url + "</a></span>")
        modalBody.append("<hr/>")
        modalBody.append("<span class=\"icon-align-left\"></span> <p class=\"value\">" + data.description + "</p>")

        var edit = $("<button>", {
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
        })

        var modalFooter = $("<div class=\"modal-footer\"></div>")
        modalFooter.append("<hr/>")
        modalFooter.append(edit)
        modalFooter.append(cancel)
        modalFooter.append(del)
        var modalDialog = $("<div class=\"modal-dialog\"></div>")

        var modalContent = $("<div class=\"modal-calendar modal-content\"></div>")
        modalContent.append(modalHeader)
        modalContent.append(modalBody)
        modalContent.append(modalFooter)

        modalContent.appendTo(modalDialog)
        modalDialog.appendTo(modal)
        modal.appendTo("div.ld-calendar")

        edit.click(function() {
            window.location.href = urlBase + "/" + getUser() + "/calendar/edit/" + data.id
        })
        del.click(function() {
            window.location.href = urlBase + "/calendar/remove/" + data.id
        })
    }

    return {
        init : init
    };
})()

