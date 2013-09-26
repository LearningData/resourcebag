$(function() {
    $("#due-date").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 1,
        beforeShowDay: enableDays,
        onSelect: showTimes
    });
});

function getEnableDays(classId) {
    var url = "http://localhost:7001/schoolbag/service/daysByClass/" + classId.value;
    $.get(url, function(response) {
        $("#week-days")[0].value = response.weekDays;
        $("#class-id")[0].value = classId.value;
    });

    if($("[name='pdue-time']").length > 0) {
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

    var url = "http://localhost:7001/schoolbag/service/getClassTimes/" + classId + "/" + day;

    $.get(url, function(response) {
        var times = response.times;
        for (var i = times.length - 1; i >= 0; i--) {
            var time = times[i];
            var field = '<p name="pdue-time"><input type="radio" name="due-time" value="' + time +'">' + time + '</p>';
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