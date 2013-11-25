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
            $( ".ld-calendar #hidden-start-date").val(dateStr)
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
                if (allDay) {
                    createNewEventDialog(date)
                    $("#createNewEventModal").modal("show")
                } else {
                    alert('Clicked on the slot: ' + date);
                }
            },
            eventClick : function(data, jsEvent, view) {
                createEditEventDialog(data)
                $("#createEditEventModal").modal("show")
            },
            editable : false,
            firstDay : 1,
            center : 'prevYear',
            events : urlBase + "/service/calendar",
            timeFormat : ''
        })
    }
    createNewEventDialog = function(date) {
        $("#createNewEventModal").remove()
        var modal = $("<div class=\"modal fade\" id=\"createNewEventModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">")
        var modalHeader = $("<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h2 class=\"modal-title\">New Event " + moment(date).format("ddd MMM DD YYYY") + "</h2></div>")
        var modalBody = $("<div class=\"modal-body\"></div>")

        var titleTitle = $("<label>Title</label>")
        modalBody.append(titleTitle)

        var titleInput = $("<input>", {
            type : "text",
            name : "title",
            id : "title",
            "class" : "form-control ",
            placeholder : "Title",
            required : "required"
        })
        modalBody.append(titleInput)

        var titleLink = $("<label>Link</label>")
        modalBody.append(titleLink)

        var linkInput = $("<input>", {
            type : "text",
            name : "link",
            id : "link",
            "class" : "form-control",
            placeholder : "Link"
        })
        modalBody.append(linkInput)

        var titleLocation = $("<label>Location</label>")
        modalBody.append(titleLocation)

        var locationInput = $("<input>", {
            type : "text",
            name : "location",
            id : "location",
            "class" : "form-control",
            placeholder : "Location"
        })
        modalBody.append(locationInput)

        var titleContact = $("<label>Contact</label>")
        modalBody.append(titleContact)

        var contactInput = $("<input>", {
            type : "text",
            name : "contact",
            id : "contact",
            "class" : "form-control",
            placeholder : "Contact"
        })
        modalBody.append(contactInput)

        var titleDescription = $("<label>Description</label>")
        modalBody.append(titleDescription)

        var descriptionInput = $("<textarea>", {
            name : "description",
            rows : "5",
            "class" : "form-control",
            placeholder : "Description"
        })
        modalBody.append( descriptionInput )
        var dateStr = moment(date).format("YYYY-MM-DD")
        var hiddenStart = $( "<input>", {
            type: "hidden",
            name: "start",
            id: "start",
            value: dateStr
        })
        var hiddenEnd = $("<input>", {
            type : "hidden",
            name : "end",
            id : "end",
            value : dateStr
        })
        var allDay = $( "<input>", {
            type: "hidden",
            name: "allDay",
            id: "allDay",
            value: 1
        })
        modalBody.append(hiddenStart)
        modalBody.append(hiddenEnd)
        modalBody.append(allDay)
        var hiddenElement = $( "input:hidden" )[0]
        var hiddenTag = $("<input>", {
            type : "hidden",
            name : hiddenElement.name,
            value : hiddenElement.value
        })
        modalBody.append(hiddenTag)
        //buttons
        var send = $("<input>", {
            "class" : "btn bg-evt",
            type : "submit",
            value : "save"
        })

        var cancel = $("<button>", {
            type : "button",
            "class" : "btn btn-cancel",
            "data-dismiss" : "modal",
            html : "Cancel"
        })
        var modalFooter = $("<div class=\"modal-footer\"></div>")
        modalFooter.append(send)
        modalFooter.append(cancel)

        var modalDialog = $("<div class=\"modal-dialog\"></div>")

        var modalContent = $("<div class=\"modal-calendar modal-content\"></div>")
        modalContent.append(modalHeader)
        modalContent.append(modalBody)
        modalContent.append(modalFooter)
        var form = $("<form>", {
            method : "post",
            action : urlBase + "/calendar/create",
            enctype : "multipart/form-data"
        })

        modalContent.appendTo(form)
        form.appendTo(modalDialog)
        modalDialog.appendTo(modal)
        modal.appendTo("div.ld-calendar")
    }
    createEditEventDialog = function(data) {
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
            "data-dismiss" : "modal",
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
    }

    return {
        init : init
    };
})()

