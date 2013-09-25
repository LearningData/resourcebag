$(function() {
    $("#due-date").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 1,
        //beforeShowDay: enableDays,
        //onSelect: showTimes
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

function showTimes(date) {
    var date = new Date(date);
    var day = date.getUTCDay();

    $("[name='p-radio']").each(function(index, element) {
        element.hidden = true;
    });

    $('[id^=p' + day + ']').each(function(index, e){
        e.hidden=false;
    });
}

function hiddenRadioElements() {
    $(":radio").each(function(index, element) {
        element.hidden = true;
    });
}