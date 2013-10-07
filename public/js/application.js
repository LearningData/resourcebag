$(document).ready(function() {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header : {
            left : 'prev,next ',
            center : 'title',
            right : ''
        },

        editable : false,
        firstDay : 1,
        center : 'prevYear',
        events : [{
            title : 'All Day Event',
            start : new Date(y, m, 1)
        }, {
            title : 'Long Event',
            start : new Date(y, m, d - 5),
            end : new Date(y, m, d - 2)
        }, {
            id : 999,
            title : 'Repeating Event',
            start : new Date(y, m, d - 3, 16, 0),
            allDay : false
        }, {
            id : 999,
            title : 'Repeating Event',
            start : new Date(y, m, d + 4, 16, 0),
            allDay : false
        }, {
            title : 'Meeting',
            start : new Date(y, m, d, 10, 30),
            allDay : false
        }, {
            title : 'Lunch',
            start : new Date(y, m, d, 12, 0),
            end : new Date(y, m, d, 14, 0),
            allDay : false
        }, {
            title : 'Birthday Party',
            start : new Date(y, m, d + 1, 19, 0),
            end : new Date(y, m, d + 1, 22, 30),
            allDay : false
        }, {
            title : 'Click for Google',
            start : new Date(y, m, 28),
            end : new Date(y, m, 29),
            url : 'http://google.com/'
        }]
    });

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
            var time = times[i];
            var field = '<p name="pdue-time"><input type="radio" name="due-time" value="' + time + '">' + time + '</p>';
            input = jQuery(field);
            $("#due-times").append(input);
        };
    });
}

function hiddenRadioElements() {
    $(":radio").each(function(index, element) {
        element.hidden = true;
    });
}