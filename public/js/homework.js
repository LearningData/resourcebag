var homeworkPage = (function() {

    var getClasses = function( dfdDialog ) {
        var url = urlBase + "/service/classes/";
        $.get( url, function(response) {
            var classes = response.classes
            dfdDialog.resolve( classes )
        });
    }

    var createNewHomeworkDialog = function( classes ) {
        var modal = $( "<div class=\"modal fade\" id=\"newHomeworkModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title\">Set New Homework</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"></div>" )

        var titleTitle = $ ("<label>Title</label>")
        modalBody.append( titleTitle )

        var titleInput = $ ( "<input>", {
            type: "text",
            "class": "form-control",
            placeholder: "Title",
            name: "title",
            id: "title",
            required: "required"
        })
        modalBody.append( titleInput )

        var titleDescription = $ ("<label>Description</label>")
        modalBody.append( titleDescription )
        
        var descriptionInput = $( "<textarea>", {
            name: "description",
            rows: "5",
            "class": "form-control",
            placeholder: "Description",
            required: "required"
        })
        modalBody.append( descriptionInput )
        var options= ["<option value=\"\" disabled=\"disabled\"> Class:</option>"]
        for ( var i = 0; i < classes.length; i++ ) {
            options.push("<option value=" + classes[i].id + ">" + classes[i].subject + "</option>")
        }
        
        var titleSubject = $ ("<label>Subject</label>")
        modalBody.append( titleSubject )
        
        var selectClass = $( "<select>", {
            name: "classList-id",
            id: "classList-id",
            "class": "form-control customSelect",
            required: "required",
            onchange: "return getEnableDays(this)"
        })
        selectClass.append( options.join("") )
        modalBody.append( selectClass )
        
        var titleDuedate = $ ("<label>Due Date</label>")
        modalBody.append( titleDuedate )
        
        var dueDateInput = $( "<input>", {
            type: "text",
            name: "due-date",
            "class": "form-control",
            placeholder: "Due Date",
            id: "due-date",
            disabled: "disabled",
            required: "required"
        })
        
        modalBody.append( dueDateInput )
        var dueTimes = $( "<div>", {
          id: "due-times"
        })
        var weekDays = $( "<input>", {
            type: "hidden",
            name: "week-days",
            id: "week-days"
        })
        var classId = $( "<input>", {
            type: "hidden",
            name: "class-id",
            id: "class-id"
        })
        modalBody.append(dueTimes)
        modalBody.append(weekDays)
        modalBody.append(classId)
        //buttons
        var send = $( "<input>", {
            "class": "btn",
            type: "submit",
            value: "save"
        })

        var cancel = $( "<button>", {
            type: "button",
            "class": "btn btn-cancel",
            "data-dismiss": "modal",
            html: "Cancel"
        })

        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append( send )
        modalFooter.append( cancel )

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"homework orange modal-content\"></div>" )
        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )

        var form = $( "<form>", {
            method: "post",
            action: urlBase + "/homework/createHomeworkByStudent"
        })

        modalContent.appendTo( form )
        form.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "div.ld-homework" )

        //Events
    }

    var uploadHomeworkFileDialog = function( homeworkId ) {
        var modal = $( "<div class=\"modal fade\" id=\"uploadHomeworkModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title\">Upload Homework File</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"></div>" )

        
        var titleFile = $ ("<label>Choose File</label>")
        modalBody.append( titleFile )
        
        var fileInput = $ ( "<input>", {
            type: "file",
            name: "file",
            "class": "form-control",
            placeholder: "File:",
            required: "required"
        })
        modalBody.append( fileInput )

        var titleDescription = $ ("<label>Description</label>")
        modalBody.append( titleDescription )
        
        var descriptionInput = $( "<textarea>", {
            name: "description",
            rows: "5",
            "class": "form-control",
            placeholder: "Description"
        })
        modalBody.append( descriptionInput )

        var homeworkId = $( "<input>", {
            type: "hidden",
            name: "homework-id",
            id: "homework-id",
            value: homeworkId
        })
        modalBody.append(homeworkId)
        //buttons
        var send = $( "<input>", {
            "class": "btn",
            type: "submit",
            value: "save"
        })

        var cancel = $( "<button>", {
            type: "button",
            "class": "btn btn-cancel",
            "data-dismiss": "modal",
            html: "Cancel"
        })
        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append( send )
        modalFooter.append( cancel )

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"modal-homework modal-content\"></div>" )
        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )

        var form = $( "<form>", {
            method: "post",
            action: urlBase + "/homework/uploadFile",
            enctype: "multipart/form-data"
        })

        modalContent.appendTo( form )
        form.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "div.ld-homework" )
        $( fileInput ).uniform();
    }

    removeHomeworkFileDialog = function( data ) {
        var modal = $( "<div class=\"modal fade\" id=\"removeHomeworkModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h2 class=\"modal-title\">Remove File</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"><p>Are you sure you want to remove the file " + data.name +" </p></div>" )

        //buttons
        var send = $( "<a>", {
            href: urlBase + "/homework/removeFile/" + data.fileId,
            "class": "btn",
            html: "Yes"
        })

        var cancel = $( "<button>", {
            "class": "btn btn-cancel",
            "data-dismiss": "modal",
            html: "Cancel"
        })
        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append( send )
        modalFooter.append( cancel )

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"modal-homework modal-content\"></div>" )
        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )

        modalContent.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "div.ld-homework" )
    }

    var submitHomeworkDialog = function( data ) {
        var modal = $( "<div class=\"modal fade\" id=\"submitHomeworkModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h4 class=\"modal-title\">Submit Homework</h4></div>")
        var modalBody = $ ( "<div class=\"modal-body\"><p>Are you sure you want to submit the homework " + data.title +" </p></div>" )

        //buttons
        var send = $( "<a>", {
            href: urlBase + "/student/homework/submit/" + data.homeworkId,
            "class": "btn",
            html: "Yes"
        })

        var cancel = $( "<button>", {
            "class": "btn btn-cancel",
            "data-dismiss": "modal",
            html: "Cancel"
        })
        var modalFooter = $ ( "<div class=\"modal-footer\"></div>" )
        modalFooter.append( send )
        modalFooter.append( cancel )

        var modalDialog = $ ( "<div class=\"modal-dialog\"></div>" )

        var modalContent = $ ( "<div class=\"modal-homework modal-content\"></div>" )
        modalContent.append( modalHeader )
        modalContent.append( modalBody )
        modalContent.append( modalFooter )

        modalContent.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "div.ld-homework" )
    }

    var stylePaginator = function() {
        var paginator = $( ".paginator" )[0]
        if ( paginator == undefined )
            return
        var pageNumber = 1
        var startPos = window.location.href.indexOf( "?" )
        startPos = window.location.href.substring( startPos).indexOf( "page" )
        if ( startPos != -1 ) {
            var endPos = window.location.href.indexOf( "&" )
            pageNumber = parseInt(window.location.href.substring( startPos, endPos ).split( "=" )[1])
        }
        paginator.children[pageNumber].classList.add( "this-page" )
        paginator.children[pageNumber].onclick = function() {
            event.preventDefault()
        }
        if ( pageNumber == 1) {
            paginator.classList.add("AtStart")
            $( ".paginator .Prev" ).replaceWith( $( "<span class=\"icon-chevron-left Prev\"></span>" ) )
        }
        if ( pageNumber == paginator.children.length - 2) {
            paginator.classList.add("AtEnd")
            $( ".paginator .Next" ).replaceWith( $( "<span class=\"icon-chevron-right Next\"></span>" ) )
        }

    }

    //init
    var init = function() {
        var dfdDialog = $.Deferred();
        dfdDialog.done(createNewHomeworkDialog)
        getClasses( dfdDialog )
        stylePaginator()

        $( ".btn-remove" ).tooltip( {title: "Remove File"} )
        $( ".btn-submit" ).tooltip( {title: "Submit Homework"} )
        $( ".btn-edit" ).tooltip( {title: "Edit Homework"} )
        $( ".btn-pending" ).tooltip( {title: "Start Homework"} )
        $( ".btn-review" ).tooltip( {title: "Review Homework"} )

        //events
        $( ".ld-homework header" ).click( function( event ) {
            window.location.href = urlBase + "/" + getUser() + "/homework"
        })
        $( ".bt-new a" ).click(function( event ) {
            event.preventDefault()
            $( "#newHomeworkModal" ).modal( "show" )
        })
        $( "#upload-homework-file" ).click(function( event ) {
            event.preventDefault()
            uploadHomeworkFileDialog( $ ( this ).data().homeworkId )
            $( "#uploadHomeworkModal" ).modal( "show" )
        })
        $( "#add-homework-text" ).click(function( event ) {
            event.preventDefault()
            $("#save-homework-text").show()
            $( "#summernote" ).summernote({
                height: 300,
                focus: true,
                toolbar: [
                    [ "style", [ "bold", "italic", "underline" ] ],
                    //['fontsize', ["fontsize"]],
                    ['para', ['ul', 'ol', 'paragraph']],
                    //['insert', ['picture', 'link']], // no insert buttons
                ]
            })
        })

        $( "#save-homework-text" ).click(function( event ) {
            event.preventDefault()
            $('textarea[name="content-homework"]').val($('#summernote').code())[0]
            $("#text-form").submit()
        })

        $( ".btn-remove" ).click(function( event ) {
            event.preventDefault()
            removeHomeworkFileDialog( $ ( this ).data() )
            $( "#removeHomeworkModal" ).modal( "show" )
        })
        $( ".btn-submit" ).click(function( event ) {
            event.preventDefault()
            if ($( event.currentTarget ).hasClass("btn-inactive")) {
                return
            }
            submitHomeworkDialog( $ ( this ).data() )
            $( "#submitHomeworkModal" ).modal( "show" )
        })
        $( ".homework-view .btn.return" ).click( function( event ) {
            if ( document.referrer.indexOf("homework") != -1 ) {
                window.history.go( -1 )
            } else {
                window.location.href = urlBase + "/" + getUser() + "/homework"
            }
        })
        $( ".ld-homework .table .collapse-toggle" ).click( function( event ){
            var element = event.target
            var target = element.getAttribute("data-target")
            var iconTarget = element.getAttribute("data-icon")
            $( target ).collapse( "toggle" )
            $( iconTarget )[0].classList.toggle("icon-chevron-right")
            $( iconTarget )[0].classList.toggle("icon-chevron-down")
            
        })
    }

    return {
        init: init
    };
})()

