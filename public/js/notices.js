var noticesPage = (function() {

    //init
    var notes = [], noteIndex = 0
    var studentTree = null
    var init = function() {
        var url = urlBase + "/notice/jsonNotices/"
        $( ".ld-notices header" ).click( function( event ) {
            window.location.href = urlBase + "/" + getUser() + "/noticeboard"
        })
        $( ".btn-notice.btn-return" ).click( function( event ) {
            window.location.href = urlBase + "/" + getUser() + "/noticeboard"
        })
        $( ".ld-notices .ld-all-school" ).click(function() {
            $( ".ld-notices .ld-tree" ).detach()
            $( ".ld-notices .ld-no-tree-all" ).removeClass('hidden')
            $( ".ld-notices .ld-no-tree-teachers" ).addClass('hidden')
         })
        $( ".ld-notices .ld-teachers-only" ).click(function() {
            $( ".ld-notices .ld-tree" ).detach()
            $( ".ld-notices .ld-no-tree-teachers" ).removeClass('hidden')
            $( ".ld-notices .ld-no-tree-all" ).addClass('hidden')
         })
        $( ".ld-notices .ld-include-students" ).click(function() {
            if (studentTree == null ) {
                generateClassListTree()
            } else {
                $( ".ld-notices .ld-classes-tree" ).append(studentTree)
            }
            $( ".ld-notices .ld-no-tree-teachers" ).addClass('hidden')
            $( ".ld-notices .ld-no-tree-all" ).addClass('hidden')
        })
        $( ".ld-notices .notice-space .note .message" ).each(function (index, element) {
           cutText(element, $( element ).find(".text"))
        }) 
        $( ".ld-notices .btn:submit").click( function( event ) {
            event.preventDefault()
            var form = $( ".ld-notices form")
            if (validForm(form)) {
                form.submit()
            }
        })
        $( ".ld-notices .btn.view-user-notices").click( function( event ) {
            $(".user-notices").toggleClass("hidden")
        })
        $( ".ld-notices .btn-delete" ).click(function( event ) {
            event.preventDefault()
            removeNoticeDialog( $ ( this ).data() )
            $( "#removeNoticeModal" ).modal( "show" )
        })
    }

    function generateClassListTree(){
        var url = urlBase + "/service/subjectsandclasses/"
        $.get(url, function(response) {
            var tree = $( "<span class=\"ld-tree\"><label><input class=\"parent-node top-level\" data-child=\".subject-level\" type=\"checkbox\" data-target='#nts-frm-choose-who' data-required-key='one'></input>All</label></span>" )
            branches = []
            for (var i in response) {
                var branchData = response[i]
                var branchId = (branchData.classes[0]) ? branchData.classes[0].subjectId : "null"
                var branch = $( "<span class=\"ld-branch icon-chevron-right collapse-toggle\" data-target=\"#ne" + branchId + "\"></span>" )
                branch.append( "<label><input class=\"parent-node child-node subject-level " + branchId +"\" data-source=\".parent-node.top-level\" data-child=\".class-level." + branchId +"\" type=\"checkbox\" data-target='#nts-frm-choose-who' data-required-key='one'></input>" + branchData.name + "</label>" )
                var items = []
                for (var j = 0; j < branchData.classes.length; j++) {
                    var input = "<input name=\"class-id[]\" value=\"" +branchData.classes[j].id + "\" class=\"child-node class-level " + branchId +"\" data-source=\".subject-level." + branchId +"\" type=\"checkbox\" data-target='#nts-frm-choose-who' data-required-key='one'/>"
                    items.push("<label>" + input + branchData.classes[j].extraRef + "</label>")
                }
                var span = $("<span id=\"ne" + branchId + "\" class=\"ld-leaf collapse\">")
                span.append(items.join(""))
                branch.append(span)
                tree.append(branch)
            }
            tree.append(branch)
            $( ".ld-notices .ld-classes-tree" ).append(tree)
            $( ".ld-notices .ld-classes-tree" ).attr('id', 'nts-frm-choose-who')
            $( ".ld-notices .ld-classes-tree" ).append("<span class='validation-error'>" + _t("must-select-one") + "</span>")
            $( ".ld-notices .ld-classes-tree :checkbox").uniform({checkboxClass: 'ld-CheckClass'})
            setTreeEvents()
            studentTree = tree

            $( ".ld-notices .ld-tree .collapse-toggle" ).click( function( event ){
                if ($( event.target ).is( ".ld-branch *" )) return
                var element = event.target
                var target = element.getAttribute("data-target")
                $( target ).collapse( "toggle" )
                element.classList.toggle("icon-chevron-right")
                element.classList.toggle("icon-chevron-down")
                
            })
        })
    }

    function removeNoticeDialog( data ) {
        var modal = $( "<div class=\"modal fade\" id=\"removeNoticeModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">" )
        var modalHeader = $( "<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h2 class=\"modal-title\">" + _t("remove-file") + "</h2></div>")
        var modalBody = $ ( "<div class=\"modal-body\"><p>" + _t("confirm-delete-notice") + " </p></div>" )

        //buttons
        var send = $( "<a>", {
            href: urlBase + "/notice/remove/" + data.id,
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
        modal.appendTo( "div.ld-notices" )
    }


    return {
        init: init
    }
})()

