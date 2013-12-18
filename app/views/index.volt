<!DOCTYPE html>
<html>
    <head>
        <title>{{ t._("title") }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ stylesheet_link("css/bootstrap.min.css") }}
        {{ stylesheet_link("css/font-awesome.min.css") }}
        {{ stylesheet_link("css/font-custom.css") }}
        {{ stylesheet_link("css/summernote.css") }}
        {{ stylesheet_link("css/application.css") }}
        {{ stylesheet_link("css/media.css") }}
        {{ stylesheet_link("css/fullcalendar.css") }}
        {{ stylesheet_link("css/jquery.timepicker.css") }}
        {{ stylesheet_link("css/media.css") }}
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    </head>
    <body class="{{ user.getController() }}">

        <!--
        div container and div row disable
        <!div class="container">
        <div class="row">
        -->
        <div class="sidebar">
            <div class="sidebar-scroll">
            {% if user is defined %}
                {{ partial("partials/_header") }}
                {{ partial("partials/_sidebar") }}
            {% endif %}
            </div>
        </div>
        <div class="main-content">
            {% for type, messages in flash.getMessages() %}
            {% for message in messages %}
            <div class="alert alert-warning fade in">
                {{ message }}
                <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
            </div>
            {% endfor%}
            {% endfor %}
            {{ content() }}
        </div>
        <!--
        div container and div row disable
        </div>
        </div>
        -->

        {{ javascript_include("js/libs/jquery-1.9.1.js") }}
        {{ javascript_include("js/libs/jquery-ui-1.10.3.custom.min.js") }}
        {{ javascript_include("js/libs/bootstrap.min.js") }}
        {{ javascript_include("js/libs/moment-with-langs.min.js") }}
        {{ javascript_include("js/libs/jquery.uniform.min.js") }}
        {{ javascript_include("js/libs/jquery.slimscroll.min.js") }}
        {{ javascript_include("js/libs/summernote.min.js") }}
        {{ javascript_include("js/libs/fullcalendar.min.js") }}
        {{ javascript_include("js/createTimetable.js") }}
        {{ javascript_include("js/libs/jquery.timepicker.min.js") }}
        {{ javascript_include("js/translate.en.js") }}
        {{ javascript_include("js/dashboard.js") }}
        {{ javascript_include("js/calendar.js") }}
        {{ javascript_include("js/timetable.js") }}
        {{ javascript_include("js/homework.js") }}
        {{ javascript_include("js/classes.js") }}
        {{ javascript_include("js/notices.js") }}
        {{ javascript_include("js/application.js") }}
    </body>
</html>
