<!DOCTYPE html>
<html>
    <head>
        <title>Schoolbag</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ stylesheet_link("css/bootstrap.min.css") }}
        {{ stylesheet_link("css/font-awesome.min.css") }}
        {{ stylesheet_link("css/font-custom.css") }}
        {{ stylesheet_link("css/summernote.css") }}
        {{ stylesheet_link("css/summernote-bootstrap.css") }}
        {{ stylesheet_link("css/style.css") }}
        {{ stylesheet_link("css/application.css") }}
        {{ stylesheet_link("css/media.css") }}
        {{ stylesheet_link("css/uniform.default.css") }}
        {{ stylesheet_link("css/fullcalendar.css") }}
    </head>
    <body class="{{ user.getController() }}">

        <!--
        div container and div row disable
        <!div class="container">
        <div class="row">
        -->
        <div class="sidebar col-sm-3 col-md-3 col-lg-3">
            {% if user is defined %}

            {% set header = user.getController()~"/_header" %}
            {{ partial(header)}}
            {{ partial(user.getController()~"/_sidebar") }}

            {% endif %}
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9">
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

        {{ javascript_include("js/jquery-1.9.1.js") }}
        {{ javascript_include("js/jquery-ui-1.10.3.custom.min.js") }}
        {{ javascript_include("js/bootstrap.min.js") }}
        {{ javascript_include("js/jquery.uniform.min.js") }}
        {{ javascript_include("js/jquery.slimscroll.min.js") }}
        {{ javascript_include("js/summernote.min.js") }}
        {{ javascript_include("js/fullcalendar.min.js") }}
        {{ javascript_include("js/createTimetable.js") }}
        {{ javascript_include("js/dashboard.js") }}
        {{ javascript_include("js/calendar.js") }}
        {{ javascript_include("js/timetable.js") }}
        {{ javascript_include("js/homework.js") }}
        {{ javascript_include("js/notices.js") }}
        {{ javascript_include("js/application.js") }}
    </body>
</html>
