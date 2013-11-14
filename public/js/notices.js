var noticesPage = (function() {

    //init
    var notes = [], noteIndex = 0
    var init = function() {
        var url = urlBase + "/notice/jsonNotices/"
        $( ".ld-notices header" ).click( function( event ) {
            window.location.href = urlBase + "/" + getUser() + "/noticeboard"
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
        $( ".ld-notices .notice-space .note .message" ).each(function (index, element) {
            console.log(element)
           cutText(element, $( element ).find(".text"))
        }) 
    }

    function generateClassListTree(){
        var url = urlBase + "/service/subjectsandclasses/"
        $.get(url, function(response) {
            var tree = $( "<span class=\"ld-tree\"><label><input class=\"parent-node top-level\" data-target=\".subject-level\" type=\"checkbox\"></input>All</label></span>" )
            branches = []
            for (var i in response) {
                var branchData = response[i]
                var branchId = (branchData.classes[0]) ? branchData.classes[0].subjectId : "null"
                var branch = $( "<span class=\"ld-branch icon-chevron-right collapse-toggle\" data-target=\"#ne" + branchId + "\"></span>" )
                branch.append( "<label><input class=\"parent-node child-node subject-level " + branchId +"\" data-source=\".parent-node.top-level\" data-target=\".class-level." + branchId +"\" type=\"checkbox\"></input>" + branchData.name + "</label>" )
                var items = []
                for (var j = 0; j < branchData.classes.length; j++) {
                    var input = "<input name=\"class-id[]\" value=\"" +branchData.classes[j].id + "\" class=\"child-node class-level " + branchId +"\" data-source=\".subject-level." + branchId +"\" type=\"checkbox\"/>"
                    items.push("<label>" + input + branchData.classes[j].extraRef + "</label>")
                }
                var span = $("<span id=\"ne" + branchId + "\" class=\"ld-leaf collapse\">")
                span.append(items.join(""))
                branch.append(span)
                tree.append(branch)
            }
            tree.append(branch)
            $( ".ld-notices .ld-classes-tree" ).append(tree)
            $( ".ld-notices .ld-classes-tree :checkbox").uniform({checkboxClass: 'ld-CheckClass'})
            setTreeEvents()

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

    return {
        init: init
    }
})()

