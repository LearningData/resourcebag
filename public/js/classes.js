var classesPage = (function() {

    removeClassDialog = function( data ) {
        var modal = $( "<div class=\"modal fade\" id=\"removeClassModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title\">Remove File</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"><p>Are you sure you want to remove this class. This action cannot be undone.</p></div>" )

        //buttons
        var send = $( "<a>", {
            href: urlBase + "/teacher/deleteClass/" + data.classId,
            "class": "btn",
            html: "Yes"
        })

        var cancel = $( "<button>", {
            "class": "btn",
            "data-dismiss": "modal",
            html: "Cancel"
        })
        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append( send )
        modalFooter.append( cancel )

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"modal-classes modal-content\"></div>" )
        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )

        modalContent.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( ".ld-classes" )
    }

    //init
    var init = function() {
        $( ".ld-classes .header" ).click( function( event ) {
            window.location.href = urlBase + "/" + getUser() + "/classes"
        })
        $( ".ld-classes .remove-class" ).click(function( event ) {
            event.preventDefault()
            removeClassDialog( $ ( this ).data() )
            $( "#removeClassModal" ).modal( "show" )
        })
        $( ".ld-classes button.join-class" ).click(function( event ) {
            event.preventDefault()
            $( ".ld-classes form.join-class" ).removeClass( "hidden" )
        })
        $( ".ld-classes .btn-cancel" ).click(function( event ) {
            event.preventDefault()
            $( ".ld-classes form.join-class" ).addClass( "hidden" )
        })
        $( ".ld-classes .filter" ).keyup(function(){
            
            var text = $( this ).val()
            if (text.trim() == "") {
                $( ".ld-classes .student-list p" ).removeClass('hidden')
            } else {
                $( ".ld-classes .student-list p" ).each(function(index) {
                    if ( $( this).text().toLowerCase().indexOf(text.toLowerCase()) != -1) {
                        this.classList.remove("hidden") 
                    } else {
                        this.classList.add("hidden")
                    
                    }
                })
            }
        })
        //hide homework sections if empty
        if ($( ".ld-classes .homework h3").length == 0) {
           $( ".ld-classes .homework").append("You have no homework!")
        }
    }

    return {
        init: init
    };
})()

