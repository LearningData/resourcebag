var noticesPage = (function() {

    //init
    var notes = [], noteIndex = 0
    var init = function() {
        var url = urlBase + "/notice/jsonNotices/"
        $.get(url, function(response) {
            notes = response.notices
            gridifyNotes()
        })
        $( ".btn-notice.btn-return" ).click( function( event ) {
            window.location.href = urlBase + "/" + getUser() + "/noticeboard"
        })
        //create new page:
        $( ".ld-notices .ld-teachers-only" ).click(function() {
            $( ".ld-notices .ld-tree" ).addClass('hidden')
            $( ".ld-notices .ld-no-tree" ).removeClass('hidden')
         })
        $( ".ld-notices .ld-include-students" ).click(function() {
            if ($( ".ld-notices .ld-tree" ).length == 0 ) {
                generateClassListTree()
            }
            $( ".ld-notices .ld-tree" ).removeClass('hidden')
            $( ".ld-notices .ld-no-tree" ).addClass('hidden')
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

    function generateClassListTree(){
        var url = urlBase + "/service/subjectsandclasses/"
        $.get(url, function(response) {
            var tree = $( "<span class=\"ld-tree\"><label><input class=\"node topLevel\" data-target=\".new-event-classLevel\" type=\"checkbox\"></input>All</label></span>" )
            branches = []
            for (var i in response) {
                var branchData = response[i]
                var branchId = (branchData.classes[0]) ? branchData.classes[0].subjectId : "null"
                var branch = $( "<span class=\"ld-branch icon-chevron-right collapse-toggle\" data-target=\"#ne" + branchId + "\"></span>" )
                branch.append( "<label><input class=\"node new-event-classLevel " + branchId +"\" data-source=\".node.topLevel\" data-target=\".new-event-itemLevel." + branchId +"\" type=\"checkbox\"></input>" + branchData.name + "</label>" )
                var items = []
                for (var j = 0; j < branchData.classes.length; j++) {
                    var input = "<input name=\"class-id[]\" value=\"" +branchData.classes[j].id + "\" class=\"node new-event-itemLevel " + branchId +"\" data-source=\".new-event-classLevel." + branchId +"\" type=\"checkbox\"/>"
                    items.push("<label>" + input + branchData.classes[j].extraRef + "</label>")
                }
                var span = $("<span id=\"ne" + branchId + "\" class=\"ld-leaf collapse\">")
                span.append(items.join(""))
                branch.append(span)
                tree.append(branch)
            }
            tree.append(branch)
            $( ".ld-notices .ld-classes-tree" ).append(tree)
            $( ".ld-notices .ld-tree .collapse-toggle" ).click( function( event ){
                if ($( event.target ).is( ".ld-branch *" )) return
                var element = event.target
                var target = element.getAttribute("data-target")
                $( target ).collapse( "toggle" )
                element.classList.toggle("icon-chevron-right")
                element.classList.toggle("icon-chevron-down")
                
            })
            $(".node.topLevel, .node.new-event-classLevel").change(function(event) {
                $( $( event.target ).data().target ).each(function() {
                    this.checked = (event.target.checked) ? "checked" : ""
                    $( this ).change()
                })
            })
            $(".node.new-event-classLevel, .node.new-event-itemLevel").click(function(event) {
                var source = $( $( event.target ).data().source )
                var all = 0, checkCount = 0
                $( source.data().target ).each(function() {
                    all++
                    if (this.checked) {
                       checkCount++
                    }
                })
                if (checkCount == 0) {
                    source[0].checked = ""
                    source[0].indeterminate = false
                } else if (checkCount == all) {
                    source[0].checked = "checked"
                    source[0].indeterminate = false
                } else {
                    source[0].checked = ""
                    source[0].indeterminate = true
                }
            })
        })
    }

    return {
        init: init
    }
})()

