$(function() {
    $("#due-date").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 1,
        beforeShowDay: enableDays
    });
});

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