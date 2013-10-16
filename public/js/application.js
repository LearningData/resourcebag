$(document).ready(function() {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    
    if ( window.location.pathname.indexOf("dashboard") != -1 ) {
        dashboard.init()
    }
    else if ( window.location.pathname.indexOf("calendar") != -1 ) {
        calendarPage.init()
    }
    $(".alert").alert();
});

$("input[type=file], select").uniform();

$(function() {
    $("#due-date").datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 1,
        beforeShowDay : enableDays,
        onSelect : showTimes
    });
});

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
            var input = "<p name='student'><input  type='checkbox' name='students[]' value='" + student.id + "'>" + student.name+ "</p>";
             $("#students").append(input);
        };
    });

}

function host() {
    return "http://" + window.location.host
}

function getUser() {
    var pathname = window.location.pathname
    if ( pathname.indexOf("teacher") != -1 ) {
        return "teacher"
    } else if ( pathname.indexOf("student") != -1 ) {
        return "student"
    } else {
        return "student"
    }
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
            console.log(times)
            var time = times[i];
            var field = '<p name="pdue-time"><input type="radio" required name="due-time" value="' + time + '">' + time.substring(0,2) + ":" + time.substring(2)+ '</p>';
            input = jQuery(field);
            $("#due-times").append(input);
        };
    });
}

function prettyDay( date ) {
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ]
    return days[date.getUTCDay()] + " " + date.getUTCDate()
}
function prettyDate( date ) {
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    return date.getUTCDate() + " " + months[date.getUTCMonth()]
}

function prettyHour( date ) {
    var hours = ( date.getUTCHours() < 10) ? "0" + date.getUTCHours() :  date.getUTCHours()
    var mins = ( date.getUTCMinutes() < 10) ? "0" + date.getUTCMinutes() :  date.getUTCMinutes()
    return hours + ":" + mins
}


function hiddenRadioElements() {
    $(":radio").each(function(index, element) {
        element.hidden = true;
    });
}
