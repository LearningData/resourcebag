var calendarPage = (function() {
    var urlBase = window.location.origin + "/schoolbag"
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
            editable : false,
            firstDay : 1,
            center : 'prevYear',
            events : urlBase + "/service/calendar"
        })
    }

    createNewEventDialog = function( date ) {
        var modal = $( "<div class=\"modal fade\" id=\"createNewEventModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title bdr-hwk\">New Event " + date.toDateString() + "</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"></div>" )

        var titleInput = $ ( "<input>", {
            type: "text",
            name: "title",
            id: "title",
            "class": "form-control",
            placeholder: "Title:",
            required: "required"
        })
        modalBody.append( titleInput )

        var linkInput = $ ( "<input>", {
            type: "text",
            name: "link",
            id: "link",
            "class": "form-control",
            placeholder: "Link:"
        })
        modalBody.append( linkInput )

        var locationInput = $ ( "<input>", {
            type: "text",
            name: "location",
            id: "location",
            "class": "form-control",
            placeholder: "Location:"
        })
        modalBody.append( locationInput )

        var contactInput = $ ( "<input>", {
            type: "text",
            name: "contact",
            id: "contact",
            "class": "form-control",
            placeholder: "Contact:"
        })
        modalBody.append( contactInput )

        var descriptionInput = $( "<textarea>", {
            name: "description",
            rows: "5",
            "class": "form-control",
            placeholder: "Description:"
        })
        modalBody.append( descriptionInput )

        var hiddenStart = $( "<input>", {
            type: "hidden",
            name: "start",
            id: "start",
            value: new Date(date)
        })
        var hiddenEnd = $( "<input>", {
            type: "hidden",
            name: "end",
            id: "end",
            value: date.dateString
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
            "class": "btn bg-cldr bg-cldr-hv",
            type: "submit",
            value: "save"
        })

        var cancel = $( "<button>", {
            type: "button",
            "class": "btn bg-cldr bg-cldr-hv",
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
        modal.appendTo( "body" )
    }

    return {
        init: init
    };
})()

