var noticesPage = (function() {

    //init
    var urlBase = window.location.origin + "/schoolbag"
    var notes = [], noteIndex = 0
    var init = function() {
        var url = urlBase + "/notice/jsonNotices/"
        $.get(url, function(response) {
            notes = response.notices
            gridifyNotes()
        })
    }

    var gridifyNotes = function() {
        for ( var i = 0; i < 5; i++ ) {
            var note = notes[i + noteIndex]
            if (note == undefined)
                return
            var header = $( "<h3>" + note.text.substring(0,15) + "</h3>" )
            var infoElement = $( "<div><span class=\"date\"" + note.date + "</span><span class=\"author\">" + note.author + "</span></div>" )
            var pElement = $( "<p class=\"message\">" + note.text + "</p>" )
            var item = $( "#ntebrd" + (i + 1) )
            item.append( header )
            item.append( item )
            item.append( pElement )
            //add image
        }
        var container = $( ".student.notice-page" )[0]
        var width = container.clientWidth
        $( ".gridster ul" ).gridster({
            widget_margins: [10, 10],
            widget_base_dimensions: [width / 9 - 20, document.documentElement.clientHeight / 8],
            max_cols: 9,
        }).data( "gridster" ).disable();
        for (var i = 0; i < 5; i++) {
            var note = $( "#ntebrd" + (i + 1) )
            if (note == undefined)
                return
            var height = note.clientHeight;
            var pElement = $( "#ntebrd" + (i + 1) + " p" )[0]
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
    init()
    return {
        init: init
    }
})()

