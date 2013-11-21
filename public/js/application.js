$(document).ready(function() {
    
    // tooltip
    $('.ld-tooltip').tooltip({
      selector: "[data-toggle=tooltip]",
      container: ".ld-tooltip"
    })

    $(".user-profile").click(function() {
        $(".user-profile-actions").slideToggle("fast");
    });
    $("select").uniform();
    $(":checkbox").uniform({checkboxClass: 'ld-CheckClass'});
    $(":radio").uniform({radioClass: 'ld-RadioClass'});
    
    $ (".sidebar-scroll").slimScroll({height:"100%"})
    
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
        onSelect : showTimes,
        firstDay: 1
    })
    $(".ld-calendar #start-date").datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 0
    })
    $(".ld-calendar #end-date").datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 0
    })
    $(".ld-calendar #start-time").timepicker({ 'scrollDefaultNow': true })
    $(".ld-calendar #end-time").timepicker({ 'scrollDefaultNow': true })
    $("#notice-note-date").datepicker({
        dateFormat : 'yy-mm-dd',
        minDate : 0,
        firstDay: 1
    })
    $("#start-date").datepicker("widget").addClass("event-page")
    $("#end-date").datepicker("widget").addClass("event-page")
    $("#notice-note-date").datepicker("widget").addClass("datepicker-note")
    setUpEvents()
    validationEvents()
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
         $("#due-times").empty()
        if (times.length > 0) {
            dueTimes = $( "<p name=\"pdue-time\">Due Time<br/></p>" )
            for (var i = 0; i < times.length; i++) {
                var time = times[i]
                var hour = parseInt(time / 100)
                hour = (hour < 10 ) ? "0" + hour : hour
                var mins = time % 100
                mins = (mins < 10 ) ? "0" + mins : mins
                var checked = (i == 0) ? "checked=\"checked\"" : ""
                var field = '<label><input type="radio" required name="due-time" value="' + time + '"' + checked + ' >' + hour + ":" + mins + '</label>';
                input = jQuery(field)
                dueTimes.append(input)
            }
            $("#due-times").append(dueTimes)
        }
    })
}
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]

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
    return date.getUTCDate() + " " + months[date.getMonth()]
}
function prettyDateMonth(date) {
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    return months[date.getMonth()]
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
    $(".btn.btn-cancel").click(function(a) {
        window.history.go(-1)
    })
    //general collapse event
    $( ".collapse-toggle" ).click( function( event ){
        var element = event.currentTarget
        var target = element.getAttribute("data-target")
        $( target ).collapse( "toggle" )
        var iconTarget = element.getAttribute("data-icon")
        $(iconTarget).toggleClass("collapse-icon-open")
        $(iconTarget).toggleClass("collapse-icon-close")
        
    })

    window.setTimeout(function() {
        $(".alert-warning").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
    if ($(".ld-tree").length > 0) setTreeEvents()
}
/****************************************
                translate //First attempt at translating js
******************************************/
function _t(str) {
        return translate[str]
}
/****************************************
                UI Events
******************************************/
var setTreeEvents = function() {
    var checkUpwards = function(source) {
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
        $.uniform.update( source )
        if (source.data().source)
            checkUpwards($( source.data().source ))
    }

    //set child node when change parent
    $(".ld-tree .parent-node").change(function(event) {
        $( $( event.target ).data().target ).each(function() {
            this.checked = (event.target.checked) ? "checked" : ""
            $.uniform.update( $( event.target ).data().target ) 
            $( this ).change()
        })
    })
    //set state of parent when click on child
    $(".ld-tree .child-node").click(function(event){
        checkUpwards( $( $( event.target ).data().source ) )
    })
}
var cutText = function(parent, element) {
    if (element == undefined)
        return
    var height = parent.clientHeight
    while ( parent.scrollHeight > height ) {
        $( element ).text(function (index, text) {
            return text.replace(/\W*\s(\S)*$/, "");
        })
    }
}
//validation
var validForm = function(form) {
    var valid = true
    $( form ).find("input:not(:checkbox)").each(function(index, element){
        if (!isValid(element)) valid = false
    })
    if ($( form ).find("input:checkbox").length >0) {
        if (!isValidCheckbox(form)) valid = false
    }
    $( form ).find("textarea").each(function(index, element){
        if (!isValid(element)) valid = false
    })
    $( form ).find("select").each(function(index, element){
        if (!isValid(element)) valid = false
    })
    return valid
}
var isValid = function(element) {
    var required = element.getAttribute("data-required-key")
    if ( required == "true" && element.value.trim() == "") {
        $(element.getAttribute("data-target")).addClass('error')
        return false
    } else {
        $(element.getAttribute("data-target")).removeClass('error')
    }
    if ( required == "date" && 
            !moment(element.value, "YYYY-MM-DD", true).isValid()) {
        $(element.getAttribute("data-target")).addClass('error')
        return false
    } else {
        $(element.getAttribute("data-target")).removeClass('error')
    }
    var preDate = element.getAttribute("data-date-after")
    if (preDate != null ) {
        if (!moment(preDate).isValid())
            preDate = $(element.getAttribute("data-date-after")).val()
        if ( moment(element.value) < moment(preDate) ) {
            $(element.getAttribute("data-target")).addClass('error')
            return false
        } else {
            $(element.getAttribute("data-target")).removeClass('error')
        }
    }

    var isBeforeDate = element.getAttribute("data-valid-dat-before")
    if ( required == "true" && element.value.trim() == "") {
        $(element.getAttribute("data-target")).addClass('error')
        return false
    } else {
        $(element.getAttribute("data-target")).removeClass('error')
    }
    return true
}
var isValidCheckbox = function(form) {
    var element = $( form ).find("input:checkbox")[0]
    var required = element.getAttribute("data-required-key")
    if ( required == "one" ) {
        var count = $(form).find("input:checkbox:checked").length
        if (count == 0 ) {
            $(element.getAttribute("data-target")).addClass('error')
            return false
        }
    }
    return true
}
var validationEvents = function() {
    $("input:not('.hasDatepicker'), form textarea").blur(function(event) {
        if (!isValid(event.currentTarget)) {
            $("input").keyup(function(event) {
                isValid(event.currentTarget)
            })
        }
    })
    $("input.hasDatepicker").change(function(event) {
        isValid(event.target)
    })
}


    