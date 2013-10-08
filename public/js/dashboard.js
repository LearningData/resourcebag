var dashboard = (function() {

    var urlBase = "http://localhost:7001/schoolbag"
    var studentId = 1652


    //events
    $( "#dashboard-homework-head" ).click( function() {
        window.location.href = urlBase + "/student/homework"
    })


    init = function() {
        populateHomework()
    
    }

    populateHomework = function() {
        var url = urlBase + "/service/homeworks/" + studentId;
        $.get(url, function(response) {
            var works = []
            for ( var i = 0; i < response.homeworks.length; i++ ) {
                works.push("<a href=" + urlBase + "/student/homework/edit/" + response.homeworks[i].id + "><li><p>" + response.homeworks[i].description + " (" + response.homeworks[i].subject + ")</p></li></a>")
            }
            var homeworkList = $( "<ul class=\"homeworkList\">")
            homeworkList.append( works.join("") )
            $( "#dashboard-homework" ).append( homeworkList )
        })
    }

    return {
        init: init
    };
})()

