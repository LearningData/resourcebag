var homework = (function() {

    //init
    var urlBase = "http://localhost:7001/schoolbag"
    var studentId = 1652
    $( ".btn-remove" ).tooltip({title: "Remove File"})
    $( ".btn-submit" ).tooltip({title: "Submit Homework"})
    $( ".btn-pending" ).tooltip({title: "Start Homework"})
    $( ".btn-review" ).tooltip({title: "Review Homework"})

    //events
    $( ".bt-new a" ).click(function ( event ) {
        event.preventDefault()
        $( "#newHomeworkModal" ).modal( "show" )
    })

    $( ".bt-upload" ).click(function ( event ) {
        event.preventDefault()
        uploadHomeworkFileDialog( $ ( this ).data().homeworkId )
        $( "#uploadHomeworkModal" ).modal( "show" )
    })

    $( ".btn-remove" ).click(function ( event ) {
        event.preventDefault()
        removeHomeworkFileDialog( $ ( this ).data() )
        $( "#removeHomeworkModal" ).modal( "show" )
    })

    $( ".btn-submit" ).click(function ( event ) {
        event.preventDefault()
        submitHomeworkDialog( $ ( this ).data() )
        $( "#submitHomeworkModal" ).modal( "show" )
    })

    getClasses = function( dfdDialog ) {
        var url = urlBase + "/service/homeworks/" + studentId;
        var subjects = {}
        $.get( url, function(response) {
            var homeworks = response.homeworks
            for ( var i = 0; i < homeworks.length; i++ ) {
                subjects[homeworks[i].subjectId] = homeworks[i].subject
            }
            dfdDialog.resolve(subjects)
        });
    }

    createNewHomeworkDialog = function( subjectList ) {
        var modal = $( "<div class=\"modal fade\" id=\"newHomeworkModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h4 class=\"modal-title\">Set New Homework</h4></div>")
        var modalBody = $ ( "<div class=\"modal-body\"></div>" )

        var titleInput = $ ( "<input>", {
            type: "text",
            "class": "form-control",
            placeholder: "Title:",
            name: "title",
            id: "title"
        })
        modalBody.append( titleInput )

        var descriptionInput = $( "<textarea>", {
            name: "description",
            rows: "5",
            "class": "form-control",
            placeholder: "Description:"
        })
        modalBody.append( descriptionInput )
        console.log(subjectList)
        var options= ["<option value=\" \"> Class </option>"]
        for ( var i in subjectList ) {
        //TODO get real ids for options
            options.push("<option value=" + i + ">" + subjectList[i] + "</option>") 
        }
        var selectClass = $( "<select>", {
            name: "classList-id",
            id: "classList-id",
            "class": "form-control customSelect",
            onchange: "return getEnableDays(this)"
        })
        selectClass.append( options.join("") )
        modalBody.append( selectClass )
        var dueDateInput = $( "<input>", {
            type: "text",
            name: "due-date",
            "class": "form-control",
            placeholder: "Due Date",
            id: "due-date"
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
            "class": "btn btn-homework",
            type: "submit",
            value: "save"
        })

        var cancel = $( "<button>", {
            type: "button",
            "class": "btn btn-homework",
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
            action: urlBase + "/homework/createHomeworkByStudent"
        })

        modalContent.appendTo( form )
        form.appendTo( modalDialog )
        modalDialog.appendTo( modal )
        modal.appendTo( "body" )

        //Events
        $("#due-date").datepicker({
            dateFormat : 'yy-mm-dd',
            minDate : 1,
            beforeShowDay : enableDays,
            onSelect : showTimes
        })
    }

    uploadHomeworkFileDialog = function( homeworkId ) {
        var modal = $( "<div class=\"modal fade\" id=\"uploadHomeworkModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h4 class=\"modal-title\">Upload Homework File</h4></div>")
        var modalBody = $ ( "<div class=\"modal-body\"></div>" )

        var fileInput = $ ( "<input>", {
            type: "file",
            name: "file",
            "class": "form-control",
            placeholder: "File:"
        })
        modalBody.append( fileInput )

        var descriptionInput = $( "<textarea>", {
            name: "description",
            rows: "5",
            "class": "form-control",
            placeholder: "Description:"
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
            "class": "btn btn-homework",
            type: "submit",
            value: "save"
        })

        var cancel = $( "<button>", {
            type: "button",
            "class": "btn btn-homework",
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
        modal.appendTo( "body" )
        $( fileInput ).uniform();
    }

    removeHomeworkFileDialog = function( data ) {
        var modal = $( "<div class=\"modal fade\" id=\"removeHomeworkModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h4 class=\"modal-title\">Upload Homework File</h4></div>")
        var modalBody = $ ( "<div class=\"modal-body\"><p>Are you sure you want to remove the file" + data.name +" </p></div>" )

        //buttons
        var send = $( "<a>", {
            href: urlBase + "/homework/removeFile/" + data.fileId,
            "class": "btn btn-homework",
            html: "Yes"
        })

        var cancel = $( "<button>", {
            "class": "btn btn-homework",
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
        modal.appendTo( "body" )
    }

    submitHomeworkDialog = function( data ) {
        var modal = $( "<div class=\"modal fade\" id=\"submitHomeworkModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"> <h4 class=\"modal-title\">Upload Homework File</h4></div>")
        var modalBody = $ ( "<div class=\"modal-body\"><p>Are you sure you want to submit the homework" + data.title +" </p></div>" )

        //buttons
        var send = $( "<a>", {
            href: urlBase + "/student/homework/submit/" + data.homeworkId,
            "class": "btn btn-homework",
            html: "Yes"
        })

        var cancel = $( "<button>", {
            "class": "btn btn-homework",
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
        modal.appendTo( "body" )
    }
    
    //init
    var dfdDialog = $.Deferred();
    dfdDialog.done(createNewHomeworkDialog)
    getClasses( dfdDialog )
    return {

    };
})()

