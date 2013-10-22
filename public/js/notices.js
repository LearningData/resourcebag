var noticesPage = (function() {

    //init
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
            if ( note == undefined)
                return
            var header = $( "<h4>" + note.text + "</h4>" )
            if ( i == 0 )
                header = $( "<h2>" + note.text + "</h2>" )
            else if ( i==1 )
                header = $( "<h3>" + note.text + "</h3>" )
            var infoElement = $( "<div><span class=\"date\"" + note.date + "</span><span class=\"author\">" + note.author + "</span></div>" )
            var pElement = $( "<p class=\"message\">" + note.text + "</p>" )
            var itemDiv = $( "<div>" )
            var item = $( "#ntebrd" + (i + 1) )
            
            //images temporary
            
            var imgNotices = $( "<img src='../img/notices/thankyou.png'/>" )
            
            if (i == 1 ) {
                imgNotices = $( "<img src='../img/notices/meeting.png' />" )
            }
            else if ( i==2){
                imgNotices = $( "<img src='../img/notices/announcements.png' />" )
            }
                else if ( i==3){
                imgNotices = $( "<img src='../img/notices/announcements.png' />" )
            }
                else if ( i==4){
                imgNotices = $( "<img src='../img/notices/announcements.png' />" )
            }
                
            
            item.append( itemDiv )
            itemDiv.append( header )
            itemDiv.append( pElement )
            itemDiv.append( imgNotices )
            
        }
        
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
        }
    }

    return {
        init: init
    }
})()

