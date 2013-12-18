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
            var dateStr = moment(val).format("YYYY-MM-DD HH:mm:ss")
            $(".ld-calendar #hidden-start-date").val(dateStr)
            millsecs = $(".ld-calendar #end-time").timepicker('getSecondsFromMidnight') * 1000
            val = new Date($(".ld-calendar #end-date").datepicker("getDate"))
            val.setTime(val.getTime() + millsecs)
            dateStr = moment(val).format("YYYY-MM-DD HH:mm:ss")
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
        $('#calendar').fullCalendar({
            header : {
                left : 'prev,next ',
                center : 'title',
                right : ''
            },
            dayClick : function(date, allDay, jsEvent, view) {
                updateNewEventDialog(date)
                $("body").popover("show")
                var pop = $(".popover")
                pop.css('top', jsEvent.currentTarget.offsetTop+jsEvent.currentTarget.clientHeight)
                var left = jsEvent.currentTarget.offsetLeft + 
                    jsEvent.currentTarget.clientWidth/2 - pop[0].clientWidth/2
                pop.css('left', left)
                //check height
                var posTop =  pop.offset().top
                var posHeight = pop.height()
                var allowedHeight = $(window).scrollTop() + $(window).height()
                if(posTop + posHeight > allowedHeight) {
                    pop.css('top', jsEvent.currentTarget.offsetTop - posHeight )
                    pop.removeClass("bottom")
                    pop.addClass("top")
                }
                //check width
                var posLeft =  pop.offset().left
                var posWidth = pop.width()
                var allowedWidth = $(window).scrollLeft() + $(window).width()
                if (left < 0) {
                    pop.css('left', 0)
                    pop.find('.arrow').css("left", ((left/(pop[0].clientWidth/2) * 50) + 50) + "%")
                } else if(posLeft + posWidth > allowedWidth) {
                    var offset =  posLeft + posWidth - allowedWidth
                    pop.css('left', left - offset)
                    pop.find('.arrow').css("left", ((offset/(pop[0].clientWidth/2) * 50) + 50) + "%")
                }
            },
            eventClick : function(data, jsEvent, view) {
                createEditEventDialog(data)
                $("#createEditEventModal").modal("show")
                return false
            },
            editable : false,
            firstDay : 1,
            center : 'prevYear',
            events : function(start, end, callback) {
                var url = urlBase + "/service/calendar";
                $.get(url, function(response) {
                    callback(response)
                    fillAgenda(response)
                })
            },
            timeFormat : ''
        })
        var parent = $("body").popover({
            html : true,
            container : ".fc-content",
            selector : ".fc-day",
            trigger: "manual",
            placement : "top auto",
            content : function() {
                return $('#createNewEventPopover').html();
            }
        }).parent()
        parent.on("click", ".popover button.close", function(event) {
            $(".popover").remove()
        })
        parent.on("click", ".btn:submit", function( event ) {
            event.preventDefault()
            var form = $( ".popover form")
            if (validForm(form)) {
                form.submit()
            }
        })
        parent.on("click", ".btn-cancel.details" ,function(event) {
            var get = "title=" + encodeURIComponent($('#createNewEventPopover #title').val()) +
                "&start=" + encodeURIComponent($('#createNewEventPopover #start').val()) +
                "&end=" + encodeURIComponent($('#createNewEventPopover #end').val())
            window.location.href = urlBase + "/" + getUser() + "/calendar/edit/?" + get
        })
        $( ".ld-calendar .btn-delete" ).click(function( event ) {
            event.preventDefault()
            createDeleteEventDialog( $ ( this ).data() )
            $( "#createDeleteEventModal" ).modal( "show" )
        })
        
    }
    var fillAgenda = function(data) {
        if ($(".agenda-list").parent().hasClass("slimScrollDiv")) {
            $(".agenda-list").parent().remove()
        } else {
            $(".agenda-list").remove()
        }
        data.sort(function(a, b) {
            allA = (a["allDay"] || 0)
            allB = (b["allDay"] || 0)
            if (allA > allB)
                return -1
            if (allA < allB)
                return 1
            return 0
        })
        data.sort(function(a, b) {
            if (moment(a["start"]).isBefore(moment(b["start"]), 'day'))
                return -1
            if (moment(a["start"]).isAfter(moment(b["start"]), 'day'))
                return 1
            return 0
        })
        agendaItems = {}
        for (var i = 0; i < data.length; i++) {
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
        $(".agenda-list").slimScroll({height: $(".fc-content").css("height")})
        $(".fc-content").data("size", {w:$(".fc-content").width(),h:$(".fc-content").height()})
        $(".fc-content").bind( 'resize', function(event) {
            $(".agenda-list").css("height", $(".fc-content").css("height"))
            $(".agenda-list").slimScroll()
            $(".fc-content").data("size", {w:$(".fc-content").width(),h:$(".fc-content").height()})
        });

        $(window).bind('resize', function(event) {
            loop_elements()
        })
        function loop_elements() {
            window.setTimeout(function(){
                var elem = $(".fc-content")
                width = elem.width()
                height = elem.height()
                data = elem.data()
                    
                if ( width !== data.size.w || height !== data.size.h ) {
                    elem.trigger( 'resize', [ data.w = width, data.h = height ] );
                }
                loop_elements();
              
            }, 60);
        }
    }
    var getAgendaElement = function(data, startTime) {
        agendaItems[startTime.format("DMMMYYYY")] = agendaItems[startTime.format("DMMMYYYY")] || $("<div class='agenda-item'><div class='day-format'><span class='day-week'>" + startTime.format("dddd") + "</span><span class='day-month'>" + startTime.format(" Do MMM ") + "</span></div></div>")
        var thisElement = agendaItems[startTime.format("DMMMYYYY")]
        if (data.allDay) {
            if (thisElement.find(".all-day").length == 0) {
                thisElement.append($("<div class='time-format'><span class='all-day time'>" + _t("all-day") + "</span><span class='all-day-title'></span></div>"))
            }
            thisElement.find(".all-day-title").append( $("<span class='test'>" + data.title + "</span>"))
        } else if (moment(data.end) && moment(data.end).isSame(startTime, 'day')) {
            thisElement.append($("<div class='time-format'><span class='time'>" + startTime.format("hh:mm a") + /*" - " + moment(data.end).format("hh:mm a") + */"</span><span>" + data.title + "</span></div>"))
        } else {
            if (thisElement.find(".all-day").length == 0) {
                thisElement.append($("<div class='time-format'><span class='all-day time'>" + _t("all-day") + "</span><span class='all-day-title'></span></div>"))
            }
            thisElement.find(".all-day-title").append( $("<span class='test'>" + data.title + "</span>"))
        }
        if (startTime.isBefore(moment(data.end), 'day')) {
            startTime.add('d', 1)
            getAgendaElement(data, startTime)
        }
    }
    var updateNewEventDialog = function(date) {
        $('#createNewEventPopover #event-date').empty()
        $('#createNewEventPopover #event-date').append(date)
        formatDate($('#createNewEventPopover #event-date')[0])
        $('#createNewEventPopover #start').val(moment(date).format("YYYY-MM-DD 00:00:00"))
        $('#createNewEventPopover #end').val(moment(date).format("YYYY-MM-DD 23:59:00"))

    }
    var createEditEventDialog = function(data) {
        $("#createEditEventModal").remove()
        var modal = $("<div class=\"modal fade\" id=\"createEditEventModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">")
        var modalHeader = $("<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h2 class=\"modal-title\">" + data.title + "</h2></div>")
        var modalBody = $("<div class=\"modal-body\"></div>")
        var dateElement = $("<span class='modal-value' data-start='" + data.start + "' data-end='" + data.end + "' ></span>")
        formatDateRange(dateElement[0])
        modalBody.append("<span class=\"icon-calendar\"></span>")
        modalBody.append(dateElement)
        

        if (!data.allDay) dateElement.attr("data-date-special", "inc-time")
        modalBody.append("<hr/>")
        modalBody.append("<span class=\"icon-map-marker\"></span><span class=\"modal-value\">" + data.location + "</span>")
        modalBody.append("<hr/>")
        modalBody.append("<span class=\"icon-phone\"></span><span class=\"modal-value\">" + data.contact + "</span>")
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
            $("#createEditEventModal").modal('hide')
            createDeleteEventDialog(data)
            $("#createDeleteEventModal").modal("show")
        })
    }
    var createDeleteEventDialog = function(data) {
        var modal = $("<div class=\"modal fade\" id=\"createDeleteEventModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">")
        var modalHeader = $("<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h4 class=\"modal-title\">" + _t("delete-event") + "</h4></div>")
        var modalBody = $("<div class=\"modal-body\"><p>" + _t("confirm-delete-event") + " <strong>" + data.title + " </strong> </p></div>")

        //buttons
        var send = $("<a>", {
            href : urlBase + "/calendar/remove/" + data.id,
            "class" : "btn",
            html : "Yes"
        })

        var cancel = $("<button>", {
            "class" : "btn btn-cancel",
            "data-dismiss" : "modal",
            html : "Cancel"
        })
        var modalFooter = $("<div class=\"modal-footer\"></div>")
        modalFooter.append(send)
        modalFooter.append(cancel)

        var modalDialog = $("<div class=\"modal-dialog\"></div>")

        var modalContent = $("<div class=\"modal-homework modal-content\"></div>")
        modalContent.append(modalHeader)
        modalContent.append(modalBody)
        modalContent.append(modalFooter)

        modalContent.appendTo(modalDialog)
        modalDialog.appendTo(modal)
        modal.appendTo("div.ld-calendar")
    }

    return {
        init : init
    };
})()

