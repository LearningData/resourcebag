$(document).ready(function() {

    $(".btn-profile-actions").click(function() {
        $(".user-profile-actions").slideToggle("fast");
    });
    $("select").uniform();
    $(":checkbox").uniform({checkboxClass: 'ld-CheckClass'});
    
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $(".nav.navbar-nav li").removeClass("active")
    if (window.location.pathname.indexOf("dashboard") != -1) {
        dashboard.init()
        $(".nav.navbar-nav li.dashboard").addClass("active")
    } else if (window.location.pathname.indexOf("messages") != -1) {
        $(".nav.navbar-nav li.messages").addClass("active")
    } else if (window.location.pathname.indexOf("noticeboard") != -1) {
        noticesPage.init()
        $(".nav.navbar-nav li.notices").addClass("active")
    } else if (window.location.pathname.indexOf("calendar") != -1) {
        calendarPage.init()
        $(".nav.navbar-nav li.events").addClass("active")
    } else if (window.location.pathname.indexOf("Ebooks") != -1) {
        $(".nav.navbar-nav li.ebooks").addClass("active")
    } else if (window.location.pathname.indexOf("resources") != -1) {
        $(".nav.navbar-nav li.resources").addClass("active")
    } else if (window.location.pathname.indexOf("policies") != -1) {
        $(".nav.navbar-nav li.policies").addClass("active")
    } else if ($( "div.ld-timetable" ).length > 0) {
        timetablePage.init()
        $(".nav.navbar-nav li.timetable").addClass("active")
    } else if ($( "div.ld-homework" ).length > 0) {
        homeworkPage.init()
        $(".nav.navbar-nav li.homework").addClass("active")
    } else if ($( "div.ld-classes" ).length > 0) {
        classesPage.init()
        $(".nav.navbar-nav li.classes").addClass("active")
    }

    $(".alert").alert();
    $("#teacher-due-date").datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 1,
        beforeShowDay : enableDays,
        onSelect : showTimes
    })
    $("#start-date").datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 0
    })
    $("#end-date").datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 0
    })
    $("#notice-note-date").datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 0
    })
    $("#start-date").datepicker("widget").addClass("event-page")
    $("#end-date").datepicker("widget").addClass("event-page")
    $("#notice-note-date").datepicker("widget").addClass("datepicker-note")
    setUpEvents()
});
var urlBase = window.location.protocol + "//" + window.location.host + "/schoolbag"
$("input[type=file]").uniform();

function getUser() {
    var body = $("body")
    if (body.hasClass("teacher")) {
        return "teacher"
    } else if (body.hasClass("student")) {
        return "student"
    } else if (body.hasClass("school")) {
        return "school"
    } else if (body.hasClass("administrator")) {
        return "administrator"
    }
    return ""
}

function enableDatePicker(id) {
    $(id).removeAttr("disabled")
    $(id).datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 1,
        beforeShowDay : enableDays,
        onSelect : showTimes
    })
}

function populeStudentsAndDays(classId) {
    getEnableDays(classId);
    if ($("[name='student']").length > 0) {
        $("[name='student']").remove();
    }

    var url = host() + "/schoolbag/service/getStudents/" + classId.value;
    $.get(url, function(response) {
        var students = response.students;
        for (var i = students.length - 1; i >= 0; i--) {
            var student = students[i];
            var input = "<p name='student'><input  type='checkbox' name='students[]' value='" + student.id + "'>" + student.name + "</p>";
            $("#students").append(input);
        };
    });

}

function host() {
    return "http://" + window.location.host
}

function getEnableDays(classId) {
    var url = host() + "/schoolbag/service/daysByClass/" + classId.value;
    $.get(url, function(response) {
        $("#week-days")[0].value = response.weekDays;
        $("#class-id")[0].value = classId.value;
    });

    if ($("[name='pdue-time']").length > 0) {
        $("[name='pdue-time']").remove();
    }
    enableDatePicker("#due-date")
}

function enableDays(date) {
    var day = date.getDay();
    var weekDays = document.getElementById("week-days").value;
    var days = weekDays.split(",");

    if (days.indexOf(day.toString()) >= 0) {
        return [true, ""];
    } else {
        return [false];
    }
}

function showTimes(date) {
    var date = new Date(date);
    var day = date.getUTCDay();

    var classId = $("#class-id")[0].value;

    var url = host() + "/schoolbag/service/getClassTimes/" + classId + "/" + day;

    $.get(url, function(response) {
        var times = response.times;
        for (var i = times.length - 1; i >= 0; i--) {
            var time = times[i];
            var hour = parseInt(time / 100)
            hour = (hour < 10 ) ? "0" + hour : hour
            var mins = time % 100
            mins = (mins < 10 ) ? "0" + mins : mins
            var field = '<p name="pdue-time"><lable for="due-time">Due Time </label><br /><input type="radio" required name="due-time" value="' + time + '">' + hour + ":" + mins + '</p>';
            input = jQuery(field);
            $("#due-times").append(input);
        };
    });
}

function dayOfWeek(date) {
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
    return days[date.getUTCDay()]
}

function prettyDay(date) {
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
    return days[date.getUTCDay()] + " " + date.getUTCDate()
}

function prettyDate(date) {
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    return date.getUTCDate() + " " + months[date.getUTCMonth()]
}

function prettyHour(date) {
    var hours = (date.getUTCHours() < 10) ? "0" + date.getUTCHours() : date.getUTCHours()
    var mins = (date.getUTCMinutes() < 10) ? "0" + date.getUTCMinutes() : date.getUTCMinutes()
    return hours + ":" + mins
}

function hiddenRadioElements() {
    $(":radio").each(function(index, element) {
        element.hidden = true;
    });
}

function setUpEvents() {
    //buttone events
    $(".btn.btn-return").click(function(a) {
        window.history.go(-1)
    })
    window.setTimeout(function() {
        $(".alert-warning").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
    if ($(".ld-tree").length > 0) setTreeEvents()
}

/****************************************
                UI Events
******************************************/
var setTreeEvents = function() {
    //set child node when change parent
    $(".ld-tree .parent-node").change(function(event) {
        $( $( event.target ).data().target ).each(function() {
            //this.checked = (event.target.checked) ? "checked" : ""
            this.parentElement.className = (event.target.checked) ? "checked" : ""
            $( this ).change()
        })
    })
    //set state of parent when click on child
    $(".ld-tree .child-node").click(function(event) {
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
}



