var noticesPage = (function() {

    //init
    var urlBase = window.location.origin + "/schoolbag"

    var gridifyNotes = function() {
        var container = $( ".student.notice-page" )[0]
        var width = container.clientWidth
        var row = 1, col = 1, maxCols = 4
        var notes = $( ".student.notice-page .notice" )
        notes[0].setAttribute("data-sizex", "2")
        notes[0].setAttribute("data-sizey", "2")
        notes[1].setAttribute("data-sizey", "2")
        notes[2].setAttribute("data-sizey", "2")

        for (var i = 1; i < notes.length; i++) {
            notes[i].setAttribute( "data-col", col )
            notes[i].setAttribute( "data-row", row )
            col++
            if (col > maxCols) {
                row++
                col = 1
            }
            
        }
        $( ".gridster ul" ).gridster({
            widget_margins: [10, 10],
            widget_base_dimensions: [width/4 - 40, 140],
            max_cols: 4,
        }).data( "gridster" ).disable();
        for (var i = 0; i < notes.length; i++) {
            var height = notes[i].clientHeight;
            var pElement = $( notes[i] ).find( "p" )[0]
            var height = pElement.clientHeight
            var message = pElement.textContent
            while ( pElement.scrollHeight > height ) {
                $( pElement ).text(function (index, text) {
                    return text.replace(/\W*\s(\S)*$/, "...");
                });
            }
            (function (msg) {
                $( notes[i] ).click(function( event ) {
                    showFullNoticeDialog( {message: msg} )
                    $( "#showNoticeModal" ).modal( "show" )
                })
            }(message))
        }
    }

    var showFullNoticeDialog = function( data ) {
        $( '#showNoticeModal' ).remove();
        var modal = $( "<div class=\"modal fade\" id=\"showNoticeModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title bdr-hwk\">School Notice</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"><p>" + data.message +" </p></div>" )

//        modalBody.append( descriptionInput )

        //buttons
        var dismiss = $( "<button>", {
            type: "button",
            "class": "btn btn-single bg-nte bg-nte-hv",
            "data-dismiss": "modal",
            html: "Dismiss"
        })
        
        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append( dismiss )

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"modal-notice modal-content\"></div>" )

        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )
        modalContent.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "body" )
    }
    gridifyNotes()
    
    return {

    }
})()

