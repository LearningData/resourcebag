var calendarPage = (function() {
    init = function() {
        $('#calendar').fullCalendar({
            header : {
                left : 'prev,next ',
                center : 'title',
                right : ''
            },
            dayClick: function(date, allDay, jsEvent, view) {
                if (allDay) {
                    createNewEventDialog( date )
                    $( "#createNewEventModal" ).modal( "show" )
                }else{
                    alert('Clicked on the slot: ' + date);
                }
            },
            eventClick: function(data, jsEvent, view) {
                    console.log(data)
                createEditEventDialog( data )
                $( "#createEditEventModal" ).modal( "show" )
                return false
            },
            editable : false,
            firstDay : 1,
            center : 'prevYear',
            events : urlBase + "/service/calendar"
        })
    }

    createNewEventDialog = function( date ) {
        $( "#createNewEventModal" ).remove()
        var modal = $( "<div class=\"modal fade\" id=\"createNewEventModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title\">New Event " + date.toDateString() + "</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"></div>" )

        var titleTitle = $ ("<label>Title</label>")
        modalBody.append( titleTitle )
        
        var titleInput = $ ( "<input>", {
            type: "text",
            name: "title",
            id: "title",
            "class": "form-control ",
            placeholder: "Title",
            required: "required"
        })
        modalBody.append( titleInput )

        var titleLink = $ ("<label>Link</label>")
        modalBody.append( titleLink )
        
        var linkInput = $ ( "<input>", {
            type: "text",
            name: "link",
            id: "link",
            "class": "form-control",
            placeholder: "Link"
        })
        modalBody.append( linkInput )

        var titleLocation = $ ("<label>Location</label>")
        modalBody.append( titleLocation )
        
        var locationInput = $ ( "<input>", {
            type: "text",
            name: "location",
            id: "location",
            "class": "form-control",
            placeholder: "Location"
        })
        modalBody.append( locationInput )

        var titleContact = $ ("<label>Contact</label>")
        modalBody.append( titleContact )
        
        var contactInput = $ ( "<input>", {
            type: "text",
            name: "contact",
            id: "contact",
            "class": "form-control",
            placeholder: "Contact"
        })
        modalBody.append( contactInput )
        
        var titleDescription = $ ("<label>Description</label>")
        modalBody.append( titleDescription )
        
        var descriptionInput = $( "<textarea>", {
            name: "description",
            rows: "5",
            "class": "form-control",
            placeholder: "Description"
        })
        modalBody.append( descriptionInput )
        dateStr = "" + date.getFullYear() + "-"
        dateStr +=  (date.getMonth() < 9) ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1) + "-"
        dateStr += (date.getDate() < 10) ? "0" + date.getDate() : date.getDate()
        var hiddenStart = $( "<input>", {
            type: "hidden",
            name: "start",
            id: "start",
            value: dateStr
        })
        var hiddenEnd = $( "<input>", {
            type: "hidden",
            name: "end",
            id: "end",
            value: dateStr
        })
        var allDay = $( "<input>", {
            type: "hidden",
            name: "allDay",
            id: "allDay",
            value: 0
        })
        modalBody.append( hiddenStart )
        modalBody.append( hiddenEnd )
        modalBody.append( allDay )
        //buttons
        var send = $( "<input>", {
            "class": "btn bg-evt",
            type: "submit",
            value: "save"
        })

        var cancel = $( "<button>", {
            type: "button",
            "class": "btn bg-evt",
            "data-dismiss": "modal",
            html: "Cancel"
        })
        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append( send )
        modalFooter.append( cancel )

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"modal-calendar modal-content\"></div>" )
        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )
        var form = $( "<form>", {
            method: "post",
            action: urlBase + "/calendar/create",
            enctype: "multipart/form-data"
        })

        modalContent.appendTo( form )
        form.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "div.ld-calendar" )
    }

    createEditEventDialog = function( data ) {
        $( "#createEditEventModal" ).remove()
        var modal = $( "<div class=\"modal fade\" id=\"createEditEventModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title\">" + data.title + "</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"></div>" )

        modalBody.append( "<span class=\"label\">When:</span>" ) 
        if (data.end != null && data.end.getDate() != data.start.getDate()) {
            modalBody.append( "<span>" + prettyDate(data.start) + "-" + prettyDate(data.end) + "</span>" ) 
        } else { 
            modalBody.append( "<span>" + prettyDate(data.start) + "</span>" ) 
        }

        if (data.url != null) {
            modalBody.append( "<br><span class=\"label\">Url:</span>" ) 
            modalBody.append( "<a href=" + data.url + ">" + data.url + "</a>" ) 
        }

        var remove = $( "<button>", {
            "class": "btn",
            html: "Delete"
        })

        var edit = $( "<button>", {
            type: "button",
            "class": "btn",
            html: "Edit"
        })
        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append(remove)
        modalFooter.append(edit)

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"modal-calendar modal-content\"></div>" )
        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )
        
        modalContent.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "div.ld-calendar" )
    }

    return {
        init: init
    };
})()

